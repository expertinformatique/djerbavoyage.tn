<?php
namespace App\Controllers\Admin;

use Core\Controller;
use Core\Security;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductsAdminController extends Controller {
    public function __construct(private ProductRepositoryInterface $productRepo) {}

    private function requireAuth(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) {
            $this->redirect('/admin/login');
        }
    }

    public function index(): void {
        $this->requireAuth();
        $products = $this->productRepo->getAll();
        
        $this->render('admin/products/index', [
            'products' => $products
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
                $this->redirect('/admin/products');
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
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product->slug = Security::sanitize($_POST['slug'] ?? '');
            $product->titleFr = Security::sanitize($_POST['title_fr'] ?? '');
            $product->priceEur = (float)($_POST['price_eur'] ?? 0);
            $product->filePath = Security::sanitize($_POST['file_path'] ?? '');
            $product->isActive = isset($_POST['is_active']) ? true : false;
            
            if ($this->productRepo->update($product)) {
                $this->redirect('/admin/products');
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
        }
        
        $this->redirect('/admin/products');
    }
}
