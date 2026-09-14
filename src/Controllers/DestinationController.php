<?php
namespace App\Controllers;

use Core\Controller;
use App\Interfaces\ArticleRepositoryInterface;
use App\Services\AnalyticsService;
use App\Services\SettingsService;
use Core\Database;

class DestinationController extends Controller {
    public function __construct(
        private ArticleRepositoryInterface $articleRepo,
        private SettingsService $settings,
        private AnalyticsService $analytics
    ) {}

    public function show(string $slug): void {
        $this->analytics->trackPageView('/destinations/' . $slug);

        $destination = null;
        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM destinations WHERE slug = :slug");
            $stmt->execute(['slug' => $slug]);
            $destination = $stmt->fetch();
        } catch (\Throwable $e) {
            $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
        }

        if (!$destination) {
            $defaults = [
                'houmt-souk' => ['id' => 1, 'slug' => 'houmt-souk', 'name_fr' => 'Houmt Souk', 'description_fr' => 'La capitale animée de Djerba, connue pour ses souks colorés, ses fondouks historiques et sa marina.'],
                'sidi-mahres' => ['id' => 2, 'slug' => 'sidi-mahres', 'name_fr' => 'Plage de Sidi Mahres', 'description_fr' => 'La plus belle plage de sable fin de Djerba avec ses hôtels d\'exception et ses eaux turquoise.'],
                'midoun' => ['id' => 3, 'slug' => 'midoun', 'name_fr' => 'Djerbahood & Erriadh', 'description_fr' => 'Le village d\'art célèbre à ciel ouvert, réputé pour ses 250 fresques street art uniques et ses cours intérieures.'],
                'aghir' => ['id' => 4, 'slug' => 'aghir', 'name_fr' => 'Aghir & Lagune VIP', 'description_fr' => 'Zone côtière d\'exception au sud-est, réputée pour ses chevaux au bord de l\'eau et le phare du Nadhour.'],
                'guellala' => ['id' => 5, 'slug' => 'guellala', 'name_fr' => 'Guellala & Les Potiers', 'description_fr' => 'Capitale historique de la poterie artisanale djerbienne, réputée pour ses ateliers ancestraux et son grand musée.'],
                'ajim-el-melga' => ['id' => 6, 'slug' => 'ajim-el-melga', 'name_fr' => 'Ajim & El Melga', 'description_fr' => 'Port pittoresque des pêcheurs d\'éponges naturelles, traversée du bac et décor culte de la Cantina Star Wars.']
            ];
            $destination = $defaults[$slug] ?? null;
        }

        if (!$destination) {
            http_response_code(404);
            $this->render('pages/404');
            return;
        }

        $articles = $this->articleRepo->getByDestination((int)$destination['id']);

        $this->render('pages/destination', [
            'seoTitle'       => 'Visiter ' . $destination['name_fr'] . ' | Guide & Conseils Djerba',
            'seoDescription' => substr(strip_tags($destination['description_fr']), 0, 160),
            'destination'    => $destination,
            'articles'       => $articles,
            'settings'       => $this->settings
        ]);
    }
}