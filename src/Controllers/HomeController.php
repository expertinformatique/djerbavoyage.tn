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

        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM destinations ORDER BY id ASC");
        $destinations = $stmt->fetchAll();

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
}