<?php
namespace App\Controllers\Admin;

use Core\Controller;
use Core\Security;
use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Article;
use App\Services\AiArticleGeneratorService;
use App\Services\SitemapService;

class ArticlesAdminController extends Controller {
    public function __construct(
        private ArticleRepositoryInterface $articleRepo,
        private ?AiArticleGeneratorService $aiGenerator = null,
        private ?SitemapService $sitemapService = null
    ) {}

    private function requireAuth(): void {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }
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

        $sort  = trim(Security::sanitize($_GET['sort'] ?? 'published_at'));
        $order = strtoupper(trim(Security::sanitize($_GET['order'] ?? 'DESC'))) === 'ASC' ? 'ASC' : 'DESC';

        $stats = $this->articleRepo->getStats();
        $data  = $this->articleRepo->getPaginated($page, $limit, $search, $status, $sort, $order);

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
            'sort'         => $sort,
            'order'        => $order,
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

            // Gestion de l'upload de l'image de couverture
            $featuredImage = trim(Security::sanitize($_POST['featured_image'] ?? 'sidi_mahres.png'));
            if (isset($_FILES['featured_image_file']) && $_FILES['featured_image_file']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->handleFileUpload($_FILES['featured_image_file']);
                if ($uploadResult) {
                    $featuredImage = $uploadResult;
                }
            }

            $article = new Article(
                slug: $slug,
                titleFr: $titleFr,
                titleEn: trim(Security::sanitize($_POST['title_en'] ?? '')) ?: null,
                titleAr: trim(Security::sanitize($_POST['title_ar'] ?? '')) ?: null,
                contentFr: $content,
                contentEn: trim($_POST['content_en'] ?? '') ?: null,
                contentAr: trim($_POST['content_ar'] ?? '') ?: null,
                featuredImage: $featuredImage,
                status: in_array($_POST['status'] ?? '', ['published', 'draft']) ? $_POST['status'] : 'published',
                seoDescription: trim(Security::sanitize($_POST['seo_description'] ?? '')) ?: null,
                summaryAi: trim(Security::sanitize($_POST['summary_ai'] ?? '')) ?: null,
                pdfEnabled: !empty($_POST['pdf_enabled']),
                authorName: trim(Security::sanitize($_POST['author_name'] ?? 'Rédaction Djerba Voyage'))
            );

            $saved = $this->articleRepo->save($article);
            $this->sitemapService?->regenerateFile();
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

            // Gestion de l'upload de l'image de couverture
            $featuredImage = trim(Security::sanitize($_POST['featured_image'] ?? $article->featuredImage));
            if (isset($_FILES['featured_image_file']) && $_FILES['featured_image_file']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->handleFileUpload($_FILES['featured_image_file']);
                if ($uploadResult) {
                    $featuredImage = $uploadResult;
                }
            }

            $article->titleFr        = $titleFr;
            $article->slug           = $slug ?: $article->slug;
            $article->titleEn        = trim(Security::sanitize($_POST['title_en'] ?? '')) ?: null;
            $article->titleAr        = trim(Security::sanitize($_POST['title_ar'] ?? '')) ?: null;
            $article->contentFr      = $content;
            $article->contentEn      = trim($_POST['content_en'] ?? '') ?: null;
            $article->contentAr      = trim($_POST['content_ar'] ?? '') ?: null;
            $article->featuredImage  = $featuredImage;
            $article->status         = in_array($_POST['status'] ?? '', ['published', 'draft']) ? $_POST['status'] : $article->status;
            $article->seoDescription = trim(Security::sanitize($_POST['seo_description'] ?? '')) ?: null;
            $article->summaryAi      = trim(Security::sanitize($_POST['summary_ai'] ?? '')) ?: null;
            $article->pdfEnabled     = !empty($_POST['pdf_enabled']);
            $article->authorName     = trim(Security::sanitize($_POST['author_name'] ?? $article->authorName));

            $this->articleRepo->save($article);
            $this->sitemapService?->regenerateFile();
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
            $this->sitemapService?->regenerateFile();
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
            $this->sitemapService?->regenerateFile();
            $_SESSION['admin_flash_success'] = "Nouvel article généré par l'IA : {$article->titleFr}";
        } catch (\Throwable $e) {
            $_SESSION['admin_flash_error'] = "Erreur IA : " . $e->getMessage();
        }

        $this->redirect('/admin/articles');
    }

    private function handleFileUpload(array $file): ?string {
        $uploadDir = ROOT_PATH . '/public/assets/images/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = uniqid('img_') . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '', basename($file['name']));
        $target = $uploadDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $target)) {
            return 'uploads/' . $filename;
        }
        return null;
    }

    public function uploadImageAjax(): void {
        $this->requireAuth();
        header('Content-Type: application/json');

        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $path = $this->handleFileUpload($_FILES['file']);
            if ($path) {
                // Retourner l'URL absolue ou relative pour TinyMCE
                echo json_encode(['location' => '/assets/images/' . $path]);
                exit;
            }
        }
        http_response_code(400);
        echo json_encode(['error' => 'Échec du téléversement de l\'image']);
        exit;
    }
}
