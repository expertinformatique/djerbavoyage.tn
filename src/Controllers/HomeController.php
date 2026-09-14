<?php
namespace App\Controllers;

use Core\Controller;
use App\Interfaces\ArticleRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Services\AnalyticsService;
use App\Services\SettingsService;
use Core\Database;

class HomeController extends Controller {
    public function __construct(
        private ArticleRepositoryInterface $articleRepo,
        private ProductRepositoryInterface $productRepo,
        private SettingsService $settings,
        private AnalyticsService $analytics
    ) {}

    public function index(): void {
        $this->analytics->trackPageView('/');

        $destinations = [];
        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->query("SELECT * FROM destinations ORDER BY id ASC");
            $destinations = $stmt->fetchAll() ?: [];
        } catch (\Throwable $e) {
            $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
        }

        if (empty($destinations)) {
            $destinations = $this->getDefaultDestinations();
        }

        $articles = $this->articleRepo->getAllPublished(6);
        $products = $this->productRepo->getAllActive();

        $this->render('pages/home', [
            'seoTitle'       => $this->settings->get('site_name', 'Djerba Voyage - Guide Officiel'),
            'seoDescription' => $this->settings->get('meta_description_default', 'Découvrez Djerba avec nos guides complets.'),
            'destinations'   => $destinations,
            'articles'       => $articles,
            'products'       => $products,
            'settings'       => $this->settings
        ]);
    }

    private function getDefaultDestinations(): array {
        return [
            ['slug' => 'houmt-souk', 'name_fr' => 'Houmt Souk', 'description_fr' => 'La capitale animée de Djerba, connue pour ses souks colorés, ses fondouks historiques et sa marina.', 'image_url' => 'images/houmt_souk.png'],
            ['slug' => 'sidi-mahres', 'name_fr' => 'Plage de Sidi Mahres', 'description_fr' => 'La plus belle plage de sable fin de Djerba avec ses hôtels d\'exception et ses eaux turquoise.', 'image_url' => 'images/sidi_mahres.png'],
            ['slug' => 'midoun', 'name_fr' => 'Djerbahood & Erriadh', 'description_fr' => 'Le village d\'art célèbre à ciel ouvert, réputé pour ses 250 fresques street art uniques et ses cours intérieures.', 'image_url' => 'images/djerbahood.png'],
            ['slug' => 'aghir', 'name_fr' => 'Aghir & Lagune VIP', 'description_fr' => 'Zone côtière d\'exception au sud-est, réputée pour ses chevaux au bord de l\'eau et le phare du Nadhour.', 'image_url' => 'images/aghir.png'],
            ['slug' => 'guellala', 'name_fr' => 'Guellala & Les Potiers', 'description_fr' => 'Capitale historique de la poterie artisanale djerbienne, réputée pour ses ateliers ancestraux et son grand musée.', 'image_url' => 'images/guellala.png'],
            ['slug' => 'ajim-el-melga', 'name_fr' => 'Ajim & El Melga', 'description_fr' => 'Port pittoresque des pêcheurs d\'éponges naturelles, traversée du bac et décor culte de la Cantina Star Wars.', 'image_url' => 'images/ajim.png']
        ];
    }
}