<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Controllers\ShopController;
use App\Models\Product;
use App\Interfaces\ProductRepositoryInterface;
use App\Services\AnalyticsService;
use App\Services\SettingsService;
use Core\Database;
use App\Repositories\PdoSettingsRepository;
use App\Services\CacheService;

class MockProductRepoForShopSchema implements ProductRepositoryInterface {
    public function findById(int $id): ?Product {
        return new Product(id: $id, slug: 'guide-djerba-pdf', titleFr: 'Guide Djerba 2026 PDF', priceEur: 14.99);
    }
    public function findBySlug(string $slug): ?Product {
        return new Product(id: 1, slug: $slug, titleFr: 'Guide Djerba 2026 PDF', priceEur: 14.99);
    }
    public function getAllActive(): array {
        return [
            new Product(id: 1, slug: 'guide-djerba-pdf', titleFr: 'Guide Djerba 2026 PDF', priceEur: 14.99),
            new Product(id: 2, slug: 'carte-gps-djerba', titleFr: 'Carte GPS Djerba Interactive', priceEur: 9.99),
            new Product(id: 3, slug: 'pack-voyageur-djerba', titleFr: 'Pack Complet Voyageur', priceEur: 29.99),
            new Product(id: 4, slug: 'audio-guide-djerba', titleFr: 'Audio Guide MP3 Djerba', priceEur: 7.99),
            new Product(id: 5, slug: 'pass-excursion-quad', titleFr: 'Pass Excursion Quad', priceEur: 35.00)
        ];
    }
    public function getAll(): array { return $this->getAllActive(); }
    public function countAll(): int { return count($this->getAllActive()); }
    public function getPaginated(int $page = 1, int $limit = 10): array {
        return ['items' => $this->getAllActive(), 'total' => count($this->getAllActive())];
    }
    public function create(Product $product): bool { return true; }
    public function update(Product $product): bool { return true; }
    public function delete(int $id): bool { return true; }
}

class ShopStructuredDataTest extends TestCase {
    private ShopController $controller;

    protected function setUp(): void {
        $_SERVER['HTTP_HOST'] = 'djerbavoyage.tn';
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['REQUEST_URI'] = '/shop';
        $_SERVER['SCRIPT_NAME'] = '/index.php';

        $pdo = Database::getInstance();
        $settingsRepo = new PdoSettingsRepository($pdo);
        $settingsService = new SettingsService($settingsRepo, new CacheService());
        $analyticsService = new AnalyticsService($pdo);

        $this->controller = new ShopController(
            new MockProductRepoForShopSchema(),
            $settingsService,
            $analyticsService
        );
    }

    public function testShopIndexGeneratesCompliantMerchantListingsJsonLd(): void {
        ob_start();
        $this->controller->index();
        $html = ob_get_clean();

        // Extraire tous les scripts JSON-LD de la page
        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches);
        $this->assertNotEmpty($matches[1]);

        $itemListJson = null;
        foreach ($matches[1] as $block) {
            $decoded = json_decode($block, true);
            if (is_array($decoded) && ($decoded['@type'] ?? '') === 'ItemList') {
                $itemListJson = $decoded;
                break;
            }
        }

        $this->assertNotNull($itemListJson, 'Le bloc JSON-LD ItemList doit être présent sur /shop');
        $this->assertNotEmpty($itemListJson['itemListElement']);

        foreach ($itemListJson['itemListElement'] as $element) {
            $item = $element['item'];
            $this->assertEquals('Product', $item['@type']);

            // 1. Problème critique GSC : Image requise
            $this->assertTrue(array_key_exists('image', $item), 'Le champ image est obligatoire pour Merchant Listings');
            $this->assertNotEmpty($item['image']);
            $this->assertTrue(str_starts_with($item['image'][0], 'https://'));
            $this->assertTrue((bool)preg_match('/\.(jpg|png|jpeg|webp)$/i', $item['image'][0]));

            // 2. Offres avec données marchand obligatoires
            $this->assertTrue(array_key_exists('offers', $item));
            $offer = $item['offers'];
            $this->assertEquals('Offer', $offer['@type']);
            $this->assertNotEmpty($offer['price']);
            $this->assertEquals('EUR', $offer['priceCurrency']);

            // 3. Problème non-critique GSC : shippingDetails manquant dans offers
            $this->assertTrue(array_key_exists('shippingDetails', $offer), 'Le champ shippingDetails est requis dans offers');
            $shipping = $offer['shippingDetails'];
            $this->assertEquals('OfferShippingDetails', $shipping['@type']);
            $this->assertTrue(array_key_exists('shippingRate', $shipping));
            $this->assertEquals('0.00', $shipping['shippingRate']['value']);
            $this->assertEquals('EUR', $shipping['shippingRate']['currency']);
            $this->assertTrue(array_key_exists('shippingDestination', $shipping));
            $this->assertNotEmpty($shipping['shippingDestination']);
            $this->assertTrue(array_key_exists('deliveryTime', $shipping));

            // 4. Problème non-critique GSC : hasMerchantReturnPolicy manquant dans offers
            $this->assertTrue(array_key_exists('hasMerchantReturnPolicy', $offer), 'Le champ hasMerchantReturnPolicy est requis dans offers');
            $returnPolicy = $offer['hasMerchantReturnPolicy'];
            $this->assertEquals('MerchantReturnPolicy', $returnPolicy['@type']);
            $this->assertTrue(array_key_exists('applicableCountry', $returnPolicy));
            $this->assertTrue(array_key_exists('returnPolicyCountry', $returnPolicy));
            $this->assertContains('FR', $returnPolicy['applicableCountry']);
            $this->assertContains('TN', $returnPolicy['applicableCountry']);
            $this->assertEquals('https://schema.org/MerchantReturnNotPermitted', $returnPolicy['returnPolicyCategory']);
        }
    }

    public function testShopShowSingleProductGeneratesCompliantJsonLd(): void {
        ob_start();
        $this->controller->show('guide-djerba-pdf');
        $html = ob_get_clean();

        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches);
        $this->assertNotEmpty($matches[1]);

        $productJson = null;
        foreach ($matches[1] as $block) {
            $decoded = json_decode($block, true);
            if (is_array($decoded) && ($decoded['@type'] ?? '') === 'Product') {
                $productJson = $decoded;
                break;
            }
        }

        $this->assertNotNull($productJson, 'Le bloc JSON-LD Product doit être présent sur /shop/{slug}');
        $this->assertEquals('Product', $productJson['@type']);

        // Vérification image
        $this->assertTrue(array_key_exists('image', $productJson));
        $this->assertNotEmpty($productJson['image']);
        $this->assertStringContainsString('shop_guide_pdf.jpg', $productJson['image'][0]);

        // Vérification shippingDetails
        $this->assertTrue(array_key_exists('shippingDetails', $productJson['offers']));
        $this->assertEquals('OfferShippingDetails', $productJson['offers']['shippingDetails']['@type']);
        $this->assertEquals('0.00', $productJson['offers']['shippingDetails']['shippingRate']['value']);

        // Vérification returnPolicy
        $this->assertTrue(array_key_exists('hasMerchantReturnPolicy', $productJson['offers']));
        $this->assertEquals('MerchantReturnPolicy', $productJson['offers']['hasMerchantReturnPolicy']['@type']);
        $this->assertEquals('https://schema.org/MerchantReturnNotPermitted', $productJson['offers']['hasMerchantReturnPolicy']['returnPolicyCategory']);
    }
}
