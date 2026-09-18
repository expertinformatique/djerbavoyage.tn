<?php
namespace App\Controllers\Admin;

use Core\Controller;
use Core\Security;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Services\SitemapService;

class ProductsAdminController extends Controller {
    public function __construct(
        private ProductRepositoryInterface $productRepo,
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
        $page  = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        
        $data  = $this->productRepo->getPaginated($page, $limit);
        $total = $data['total'] ?? 0;
        
        $this->render('admin/products/index', [
            'products'   => $data['items'] ?? [],
            'total'      => $total,
            'page'       => $page,
            'limit'      => $limit,
            'totalPages' => $total > 0 ? (int)ceil($total / $limit) : 1
        ], 'layouts/admin');
    }

    public function create(): void {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = new Product();
            $product->slug = Security::sanitize($_POST['slug'] ?? '');
            $product->titleFr = Security::sanitize($_POST['title_fr'] ?? '');
            $product->priceEur = (float)($_POST['price_eur'] ?? 0);
            $product->filePath = Security::sanitize($_POST['file_path'] ?? '');
            $product->isActive = isset($_POST['is_active']) ? true : false;
            
            if ($this->productRepo->create($product)) {
                $this->sitemapService?->regenerateFile();
                $this->redirect('/admin/products');
                return;
            } else {
                $error = "Erreur lors de la création du produit.";
            }
        }
        
        $this->render('admin/products/form', [
            'error' => $error ?? null,
            'product' => null
        ], 'layouts/admin');
    }

    public function edit(int $id): void {
        $this->requireAuth();
        
        $product = $this->productRepo->findById($id);
        if (!$product) {
            $this->redirect('/admin/products');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product->slug = Security::sanitize($_POST['slug'] ?? '');
            $product->titleFr = Security::sanitize($_POST['title_fr'] ?? '');
            $product->priceEur = (float)($_POST['price_eur'] ?? 0);
            $product->filePath = Security::sanitize($_POST['file_path'] ?? '');
            $product->isActive = isset($_POST['is_active']) ? true : false;
            
            if ($this->productRepo->update($product)) {
                $this->sitemapService?->regenerateFile();
                $this->redirect('/admin/products');
                return;
            } else {
                $error = "Erreur lors de la modification du produit.";
            }
        }
        
        $this->render('admin/products/form', [
            'error' => $error ?? null,
            'product' => $product
        ], 'layouts/admin');
    }

    public function delete(int $id): void {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->productRepo->delete($id);
            $this->sitemapService?->regenerateFile();
        }
        
        $this->redirect('/admin/products');
        return;
    }
}
