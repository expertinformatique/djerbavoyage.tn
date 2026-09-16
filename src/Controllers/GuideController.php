<?php
namespace App\Controllers;

use Core\Controller;
use App\Interfaces\ArticleRepositoryInterface;
use App\Interfaces\LocalServiceRepositoryInterface;
use App\Services\AnalyticsService;
use App\Services\SettingsService;
use App\Services\ArticlePdfService;

class GuideController extends Controller {
    public function __construct(
        private ArticleRepositoryInterface $articleRepo,
        private SettingsService $settings,
        private AnalyticsService $analytics,
        private ArticlePdfService $pdfService,
        private ?LocalServiceRepositoryInterface $localServiceRepo = null
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

        $ctaServices = [];
        if ($this->localServiceRepo && !empty($article->ctaServicesJson)) {
            $slugs = json_decode($article->ctaServicesJson, true);
            if (is_array($slugs)) {
                foreach ($slugs as $s) {
                    $found = $this->localServiceRepo->findBySlug($s);
                    if ($found) $ctaServices[] = $found;
                }
            }
        }
        if (empty($ctaServices) && $this->localServiceRepo) {
            $ctaServices = array_slice($this->localServiceRepo->getAllActive(), 0, 2);
        }

        $allPublished = $this->articleRepo->getAllPublished(6);
        $relatedArticles = [];
        foreach ($allPublished as $item) {
            if ($item->id !== $article->id && count($relatedArticles) < 3) {
                $relatedArticles[] = $item;
            }
        }

        $this->render('pages/guide-single', [
            'seoTitle'        => $article->titleFr . ' | Djerba Voyage',
            'seoDescription'  => $article->seoDescription ?: substr(strip_tags($article->contentFr), 0, 160),
            'article'         => $article,
            'ctaServices'     => $ctaServices,
            'relatedArticles' => $relatedArticles,
            'settings'        => $this->settings
        ]);
    }

    public function pdf(string $slug): void {
        $article = $this->articleRepo->findBySlug($slug);
        if (!$article) {
            http_response_code(404);
            echo "Article non trouvé";
            return;
        }

        $html = $this->pdfService->generateHtmlForPdf($article);
        header('Content-Type: text/html; charset=utf-8');
        echo $html;
    }
}