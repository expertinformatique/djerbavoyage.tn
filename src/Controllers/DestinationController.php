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

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM destinations WHERE slug = :slug");
        $stmt->execute(['slug' => $slug]);
        $destination = $stmt->fetch();

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