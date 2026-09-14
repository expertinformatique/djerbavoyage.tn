<?php
namespace App\Controllers;

use Core\Controller;
use App\Interfaces\ProductRepositoryInterface;
use App\Services\AnalyticsService;
use App\Services\SettingsService;

class ShopController extends Controller {
    public function __construct(
        private ProductRepositoryInterface $productRepo,
        private SettingsService $settings,
        private AnalyticsService $analytics
    ) {}

    public function index(): void {
        $this->analytics->trackPageView('/shop');
        $products = $this->productRepo->getAllActive();

        $this->render('pages/shop', [
            'seoTitle'       => 'Boutique Guides PDF Djerba | Cartes & Itinéraires',
            'seoDescription' => 'Téléchargez nos guides PDF exclusifs pour organiser votre séjour à Djerba.',
            'products'       => $products,
            'settings'       => $this->settings
        ]);
    }
}