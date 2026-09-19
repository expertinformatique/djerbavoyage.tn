<?php
namespace App\Controllers;

use Core\Controller;
use App\Services\AiArticleGeneratorService;

class AutoBlogController extends Controller {
    public function __construct(
        private AiArticleGeneratorService $generator
    ) {}

    public function generate(): void {
        header('Content-Type: application/json; charset=utf-8');

        $secret = $_ENV['AUTO_BLOG_SECRET'] ?? 'djerba_secret_cron_key_2026';
        $providedToken = $_GET['token'] ?? $_SERVER['HTTP_X_AUTO_BLOG_TOKEN'] ?? '';

        if (!empty($secret) && $providedToken !== $secret && php_sapi_name() !== 'cli') {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Accès refusé : token secret invalide'
            ]);
            return;
        }

        try {
            $article = $this->generator->generateAndSave();
            $fbResult = $this->generator->getLastFacebookResult();
            $reelResult = $this->generator->getLastReelResult();

            echo json_encode([
                'success' => true,
                'message' => 'Article de blog généré et publié avec succès',
                'data' => [
                    'id' => $article->id,
                    'title' => $article->titleFr,
                    'slug' => $article->slug,
                    'image' => $article->featuredImage,
                    'published_at' => $article->publishedAt,
                    'pdf_url' => '/guide/' . $article->slug . '/pdf',
                    'facebook' => $fbResult ?? ['published' => false, 'reason' => 'Service non initialisé'],
                    'reel' => $reelResult ?? ['published' => false, 'reason' => 'Non planifié sur ce cycle']
                ]
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
