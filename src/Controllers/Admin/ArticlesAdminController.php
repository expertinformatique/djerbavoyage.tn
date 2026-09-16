<?php
namespace App\Controllers\Admin;

use Core\Controller;
use Core\Security;
use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Article;
use App\Services\AiArticleGeneratorService;

class ArticlesAdminController extends Controller {
    public function __construct(
        private ArticleRepositoryInterface $articleRepo,
        private ?AiArticleGeneratorService $aiGenerator = null
    ) {}

    private function requireAuth(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) {
            $this->redirect('/admin/login');
        }
    }

    public function index(): void {
        $this->requireAuth();

        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 15;
        $search = trim(Security::sanitize($_GET['search'] ?? ''));
        $status = trim(Security::sanitize($_GET['status'] ?? 'all'));
        if (!in_array($status, ['all', 'published', 'draft'])) {
            $status = 'all';
        }

        $stats = $this->articleRepo->getStats();
        $data  = $this->articleRepo->getPaginated($page, $limit, $search, $status);

        $flashSuccess = $_SESSION['admin_flash_success'] ?? null;
        $flashError   = $_SESSION['admin_flash_error'] ?? null;
        unset($_SESSION['admin_flash_success'], $_SESSION['admin_flash_error']);

        $this->render('admin/articles/index', [
            'articles'     => $data['items'] ?? [],
            'total'        => $data['total'] ?? 0,
            'page'         => $page,
            'limit'        => $limit,
            'search'       => $search,
            'status'       => $status,
            'stats'        => $stats,
            'flashSuccess' => $flashSuccess,
            'flashError'   => $flashError,
            'totalPages'   => ($data['total'] ?? 0) > 0 ? (int)ceil($data['total'] / $limit) : 1
        ], 'layouts/admin');
    }

    public function create(): void {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titleFr = trim(Security::sanitize($_POST['title_fr'] ?? ''));
            $slug    = trim(Security::sanitize($_POST['slug'] ?? ''));
            $content = trim($_POST['content_fr'] ?? '');

            if (empty($titleFr) || empty($content)) {
                $this->render('admin/articles/form', [
                    'article' => null,
                    'error'   => 'Le titre et le contenu sont obligatoires.'
                ], 'layouts/admin');
                return;
            }

            if (empty($slug)) {
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titleFr), '-'));
            }

            $article = new Article(
                slug: $slug,
                titleFr: $titleFr,
                titleEn: trim(Security::sanitize($_POST['title_en'] ?? '')) ?: null,
                contentFr: $content,
                contentEn: trim($_POST['content_en'] ?? '') ?: null,
                featuredImage: trim(Security::sanitize($_POST['featured_image'] ?? 'sidi_mahres.png')),
                status: in_array($_POST['status'] ?? '', ['published', 'draft']) ? $_POST['status'] : 'published',
                seoDescription: trim(Security::sanitize($_POST['seo_description'] ?? '')) ?: null,
                summaryAi: trim(Security::sanitize($_POST['summary_ai'] ?? '')) ?: null,
                pdfEnabled: !empty($_POST['pdf_enabled']),
                authorName: trim(Security::sanitize($_POST['author_name'] ?? 'Rédaction Djerba Voyage'))
            );

            $saved = $this->articleRepo->save($article);
            $_SESSION['admin_flash_success'] = "Article créé avec succès : {$saved->titleFr}";
            $this->redirect('/admin/articles');
            return;
        }

        $this->render('admin/articles/form', [
            'article' => null,
            'error'   => null
        ], 'layouts/admin');
    }

    public function edit(): void {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $article = $this->articleRepo->findById($id);

        if (!$article) {
            $_SESSION['admin_flash_error'] = "Article introuvable.";
            $this->redirect('/admin/articles');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titleFr = trim(Security::sanitize($_POST['title_fr'] ?? ''));
            $slug    = trim(Security::sanitize($_POST['slug'] ?? ''));
            $content = trim($_POST['content_fr'] ?? '');

            if (empty($titleFr) || empty($content)) {
                $this->render('admin/articles/form', [
                    'article' => $article,
                    'error'   => 'Le titre et le contenu sont obligatoires.'
                ], 'layouts/admin');
                return;
            }

            $article->titleFr        = $titleFr;
            $article->slug           = $slug ?: $article->slug;
            $article->titleEn        = trim(Security::sanitize($_POST['title_en'] ?? '')) ?: null;
            $article->contentFr      = $content;
            $article->contentEn      = trim($_POST['content_en'] ?? '') ?: null;
            $article->featuredImage  = trim(Security::sanitize($_POST['featured_image'] ?? $article->featuredImage));
            $article->status         = in_array($_POST['status'] ?? '', ['published', 'draft']) ? $_POST['status'] : $article->status;
            $article->seoDescription = trim(Security::sanitize($_POST['seo_description'] ?? '')) ?: null;
            $article->summaryAi      = trim(Security::sanitize($_POST['summary_ai'] ?? '')) ?: null;
            $article->pdfEnabled     = !empty($_POST['pdf_enabled']);
            $article->authorName     = trim(Security::sanitize($_POST['author_name'] ?? $article->authorName));

            $this->articleRepo->save($article);
            $_SESSION['admin_flash_success'] = "Article mis à jour : {$article->titleFr}";
            $this->redirect('/admin/articles');
            return;
        }

        $this->render('admin/articles/form', [
            'article' => $article,
            'error'   => null
        ], 'layouts/admin');
    }

    public function delete(): void {
        $this->requireAuth();
        $id = (int)($_POST['id'] ?? 0);
        $article = $this->articleRepo->findById($id);

        if ($article && $this->articleRepo->delete($id)) {
            $_SESSION['admin_flash_success'] = "Article supprimé avec succès.";
        } else {
            $_SESSION['admin_flash_error'] = "Erreur lors de la suppression de l'article.";
        }

        $this->redirect('/admin/articles');
    }

    public function generateAi(): void {
        $this->requireAuth();

        if (!$this->aiGenerator) {
            $_SESSION['admin_flash_error'] = "Générateur IA non configuré.";
            $this->redirect('/admin/articles');
            return;
        }

        try {
            $article = $this->aiGenerator->generateAndSave();
            $_SESSION['admin_flash_success'] = "Nouvel article généré par l'IA : {$article->titleFr}";
        } catch (\Throwable $e) {
            $_SESSION['admin_flash_error'] = "Erreur IA : " . $e->getMessage();
        }

        $this->redirect('/admin/articles');
    }
}
