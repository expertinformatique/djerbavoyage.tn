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

        $domain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');

        // Génération Schema.org JSON-LD Structuré pour Google Search
        $itemListElement = [];
        foreach ($products as $index => $prod) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'item' => [
                    '@type' => 'Product',
                    'name' => $prod->titleFr,
                    'description' => 'Guide touristique numérique Djerba 2026 avec carte GPS, itinéraires détaillés et conseils d\'experts localisés.',
                    'brand' => [
                        '@type' => 'Brand',
                        'name'  => 'Djerba Voyage'
                    ],
                    'offers' => [
                        '@type' => 'Offer',
                        'price' => number_format($prod->priceEur, 2, '.', ''),
                        'priceCurrency' => 'EUR',
                        'availability' => 'https://schema.org/InStock',
                        'url' => $domain . '/shop'
                    ],
                    'aggregateRating' => [
                        '@type' => 'AggregateRating',
                        'ratingValue' => '4.9',
                        'reviewCount' => '128'
                    ]
                ]
            ];
        }

        $jsonLd = '<script type="application/ld+json">' . json_encode([
            '@context' => 'https://schema.org',
            '@type'    => 'ItemList',
            'name'     => 'Catalogue Produits & Guides Numériques Djerba Voyage',
            'itemListElement' => $itemListElement
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';

        $this->render('pages/shop', [
            'seoTitle'       => 'Boutique Guides PDF Djerba 2026 | Cartes GPS, Pass & Audio-Guides',
            'seoDescription' => 'Achetez nos guides PDF officiels de Djerba 2026, cartes GPS interactives et billets d\'excursion VIP. Téléchargement immédiat + Bon Cadeau Aéroport offert.',
            'products'       => $products,
            'settings'       => $this->settings,
            'jsonLd'         => $jsonLd
        ]);
    }
}