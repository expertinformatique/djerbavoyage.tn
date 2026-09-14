<?php
namespace App\Controllers;

use Core\Controller;
use App\Interfaces\ArticleRepositoryInterface;
use App\Services\AnalyticsService;
use App\Services\SettingsService;

class GuideController extends Controller {
    public function __construct(
        private ArticleRepositoryInterface $articleRepo,
        private SettingsService $settings,
        private AnalyticsService $analytics
    ) {}

    public function index(): void {
        $this->analytics->trackPageView('/guide');
        $articles = $this->articleRepo->getAllPublished(20);

        $this->render('pages/guide-list', [
            'seoTitle'       => 'Guides de Voyage Djerba | Tous nos Articles',
            'seoDescription' => 'Consultez nos articles et conseils pratiques pour bien préparer votre séjour à Djerba.',
            'articles'       => $articles,
            'settings'       => $this->settings
        ]);
    }

    public function show(string $slug): void {
        $this->analytics->trackPageView('/guide/' . $slug);
        $article = $this->articleRepo->findBySlug($slug);

        if (!$article) {
            http_response_code(404);
            $this->render('pages/404');
            return;
        }

        $this->articleRepo->incrementViews($article->id);

        $this->render('pages/guide-single', [
            'seoTitle'       => $article->titleFr . ' | Djerba Voyage',
            'seoDescription' => substr(strip_tags($article->contentFr), 0, 160),
            'article'        => $article,
            'settings'       => $this->settings
        ]);
    }
}