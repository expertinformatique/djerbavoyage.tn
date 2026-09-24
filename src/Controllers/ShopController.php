<?php
namespace App\Controllers;

use Core\Controller;
use Core\Lang;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Services\AnalyticsService;
use App\Services\SettingsService;
use App\Services\ProductLocalizationService;

class ShopController extends Controller {
    public function __construct(
        private ProductRepositoryInterface $productRepo,
        private SettingsService $settings,
        private AnalyticsService $analytics
    ) {}

    public function index(): void {
        $this->analytics->trackPageView('/shop');
        $products = $this->productRepo->getAllActive();
        $domain = rtrim(absolute_url(''), '/');

        $itemListElement = [];
        foreach ($products as $index => $prod) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'item' => $this->buildProductSchema($prod, $domain)
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

    public function show(string $slug): void {
        $product = $this->productRepo->findBySlug($slug);
        if (!$product) {
            $this->redirect('/shop');
            return;
        }

        $this->analytics->trackPageView('/shop/' . $slug);
        $products = $this->productRepo->getAllActive();
        $domain = rtrim(absolute_url(''), '/');

        $productData = array_merge([
            '@context' => 'https://schema.org',
        ], $this->buildProductSchema($product, $domain));

        $jsonLd = '<script type="application/ld+json">' . json_encode(
            $productData,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        ) . '</script>';

        $activeLang = Lang::getLocale();
        $displayTitle = ProductLocalizationService::getTitle($product, $activeLang);
        $displayDesc = ProductLocalizationService::getDescription($product, $activeLang);

        $this->render('pages/shop-single', [
            'seoTitle'        => htmlspecialchars($displayTitle) . ' | Boutique Djerba Voyage',
            'seoDescription'  => htmlspecialchars($displayDesc) . ' - ' . number_format($product->priceEur, 2) . ' €. Téléchargement immédiat sécurisé.',
            'product'         => $product,
            'products'        => $products,
            'selectedProduct' => $product,
            'settings'        => $this->settings,
            'jsonLd'          => $jsonLd
        ]);
    }

    private function buildProductSchema(Product $product, string $domain): array {
        return [
            '@type' => 'Product',
            'name' => $product->titleFr,
            'description' => 'Guide touristique numérique Djerba 2026 avec carte GPS, itinéraires détaillés et conseils d\'experts localisés.',
            'image' => [
                $this->resolveProductImage($product, $domain)
            ],
            'sku' => 'DV-PROD-' . ($product->id ?? $product->slug),
            'brand' => [
                '@type' => 'Brand',
                'name'  => 'Djerba Voyage'
            ],
            'offers' => $this->buildOffersSchema($product, $domain),
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.9',
                'reviewCount' => '128'
            ]
        ];
    }

    private function buildOffersSchema(Product $product, string $domain): array {
        $supportedCountries = ['FR', 'TN', 'BE', 'CH', 'CA', 'DE', 'IT', 'GB'];
        $destinations = array_map(fn(string $code): array => [
            '@type' => 'DefinedRegion',
            'addressCountry' => $code
        ], $supportedCountries);

        return [
            '@type' => 'Offer',
            'price' => number_format($product->priceEur, 2, '.', ''),
            'priceCurrency' => 'EUR',
            'priceValidUntil' => (date('Y') + 1) . '-12-31',
            'availability' => 'https://schema.org/InStock',
            'itemCondition' => 'https://schema.org/NewCondition',
            'url' => $domain . '/shop/' . $product->slug,
            'seller' => [
                '@type' => 'Organization',
                'name'  => 'Djerba Voyage'
            ],
            'shippingDetails' => [
                '@type' => 'OfferShippingDetails',
                'shippingRate' => [
                    '@type' => 'MonetaryAmount',
                    'value' => '0.00',
                    'currency' => 'EUR'
                ],
                'shippingDestination' => $destinations,
                'deliveryTime' => [
                    '@type' => 'ShippingDeliveryTime',
                    'handlingTime' => [
                        '@type' => 'QuantitativeValue',
                        'minValue' => 0,
                        'maxValue' => 0,
                        'unitCode' => 'DAY'
                    ],
                    'transitTime' => [
                        '@type' => 'QuantitativeValue',
                        'minValue' => 0,
                        'maxValue' => 0,
                        'unitCode' => 'DAY'
                    ]
                ]
            ],
            'hasMerchantReturnPolicy' => [
                '@type' => 'MerchantReturnPolicy',
                'applicableCountry' => $supportedCountries,
                'returnPolicyCountry' => $supportedCountries,
                'returnPolicyCategory' => 'https://schema.org/MerchantReturnNotPermitted',
                'merchantReturnDays' => 0
            ]
        ];
    }

    private function resolveProductImage(Product $prod, string $domain): string {
        $titleLower = mb_strtolower($prod->titleFr);
        $image = 'shop_guide_pdf.jpg';

        if (str_contains($titleLower, 'carte gps') || str_contains($titleLower, 'map')) {
            $image = 'shop_gps_map.jpg';
        } elseif (str_contains($titleLower, 'pass') || str_contains($titleLower, 'excursion') || str_contains($titleLower, 'balade') || str_contains($titleLower, 'session') || str_contains($titleLower, 'jet') || str_contains($titleLower, 'quad')) {
            $image = str_contains($titleLower, 'jet') ? 'service_jetski.jpg' : (str_contains($titleLower, 'quad') ? 'service_quad.jpg' : 'service_bateau_pirate.jpg');
        } elseif (str_contains($titleLower, 'pack')) {
            $image = 'hero.png';
        } elseif (str_contains($titleLower, 'audio')) {
            $image = 'shop_audio_guide.jpg';
        }

        return $domain . '/assets/images/' . $image;
    }
}