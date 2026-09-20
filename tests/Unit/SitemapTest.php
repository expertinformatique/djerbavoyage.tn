<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Controllers\SitemapController;
use App\Services\SitemapService;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\LocalServiceRepositoryInterface;
use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Product;
use App\Models\LocalService;
use App\Models\Article;
use App\Controllers\Admin\ProductsAdminController;

class DummyProductRepository implements ProductRepositoryInterface {
    public array $created = [];
    public array $updated = [];
    public array $deleted = [];

    public function findById(int $id): ?Product {
        return new Product(id: $id, slug: 'guide-djerba-2026', titleFr: 'Guide Voyage Djerba 2026', priceEur: 19.99);
    }
    public function findBySlug(string $slug): ?Product {
        return new Product(id: 1, slug: $slug, titleFr: 'Guide Voyage Djerba 2026', priceEur: 19.99);
    }
    public function getAllActive(): array {
        return [
            new Product(id: 1, slug: 'guide-djerba-pdf', titleFr: 'Guide Djerba 2026 PDF', priceEur: 14.99),
            new Product(id: 2, slug: 'carte-gps-djerba', titleFr: 'Carte GPS Djerba Interactive', priceEur: 9.99)
        ];
    }
    public function getAll(): array { return $this->getAllActive(); }
    public function countAll(): int { return 2; }
    public function getPaginated(int $page = 1, int $limit = 10): array {
        return ['items' => $this->getAllActive(), 'total' => 2];
    }
    public function create(Product $product): bool {
        $this->created[] = $product;
        return true;
    }
    public function update(Product $product): bool {
        $this->updated[] = $product;
        return true;
    }
    public function delete(int $id): bool {
        $this->deleted[] = $id;
        return true;
    }
}

class DummyServiceRepository implements LocalServiceRepositoryInterface {
    public function findById(int $id): ?LocalService { return null; }
    public function findBySlug(string $slug): ?LocalService { return null; }
    public function findByIds(array $ids): array { return []; }
    public function getAllActive(): array { return []; }
    public function getByCategory(string $category): array { return []; }
}

class DummyArticleRepository implements ArticleRepositoryInterface {
    public function findBySlug(string $slug): ?Article { return null; }
    public function findById(int $id): ?Article {
        return new Article(id: $id, slug: 'test-slug', titleFr: 'Titre Test', contentFr: 'Contenu Test');
    }
    public function getAllPublished(int $limit = 10): array {
        $articles = [];
        // Générer 15 articles pour tester le dépassement de la limite par défaut de 10
        $count = min($limit, 15);
        for ($i = 1; $i <= $count; $i++) {
            $articles[] = (object)[
                'slug' => "guide-test-djerba-{$i}",
                'titleFr' => "Guide de Test Djerba #{$i}",
                'featuredImage' => "/images/blog/test-{$i}.jpg",
                'publishedAt' => '2026-09-17 10:00:00',
                'pdfEnabled' => ($i === 1)
            ];
        }
        return $articles;
    }
    public function getByDestination(int $destinationId): array { return []; }
    public function incrementViews(int $id): void {}
    public function save(Article $article): Article { return $article; }
    public function delete(int $id): bool { return true; }
    public function countPublished(): int { return 15; }
    public function countAll(): int { return 15; }
    public function getPaginated(int $page = 1, int $limit = 10, string $search = '', string $status = '', string $sort = 'published_at', string $order = 'DESC'): array { return []; }
    public function getStats(): array { return []; }
    public function getAllUsedFeaturedImages(): array { return []; }
}

class TrackingSitemapService extends SitemapService {
    public int $regenerateCalls = 0;

    public function regenerateFile(?string $domain = null): bool {
        $this->regenerateCalls++;
        return true;
    }
}

class SitemapTest extends TestCase {
    public function testGenerateXmlContainsValidStructureAndUrls() {
        $productRepo = new DummyProductRepository();
        $serviceRepo = new DummyServiceRepository();
        $articleRepo = new DummyArticleRepository();

        $controller = new SitemapController($productRepo, $serviceRepo, $articleRepo);
        $xml = $controller->generateXml('https://djerbavoyage.tn');

        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $xml);
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"', $xml);
        $this->assertStringContainsString('<loc>https://djerbavoyage.tn/</loc>', $xml);
        $this->assertStringContainsString('<loc>https://djerbavoyage.tn/guide/guide-test-djerba-1</loc>', $xml);
        $this->assertStringContainsString('<loc>https://djerbavoyage.tn/guide/guide-test-djerba-1/pdf</loc>', $xml);
        $this->assertStringContainsString('<image:loc>https://djerbavoyage.tn/images/blog/test-1.jpg</image:loc>', $xml);
    }

    public function testGenerateXmlIncludesActiveProductsWithImages() {
        $productRepo = new DummyProductRepository();
        $serviceRepo = new DummyServiceRepository();
        $articleRepo = new DummyArticleRepository();

        $service = new SitemapService($productRepo, $serviceRepo, $articleRepo);
        $xml = $service->generateXml('https://djerbavoyage.tn');

        $this->assertStringContainsString('<loc>https://djerbavoyage.tn/shop/guide-djerba-pdf</loc>', $xml);
        $this->assertStringContainsString('<loc>https://djerbavoyage.tn/shop/carte-gps-djerba</loc>', $xml);
        $this->assertStringContainsString('<image:loc>https://djerbavoyage.tn/images/shop_guide_pdf.jpg</image:loc>', $xml);
        $this->assertStringContainsString('<image:loc>https://djerbavoyage.tn/images/shop_gps_map.jpg</image:loc>', $xml);
        $this->assertStringContainsString('<image:title>Guide Djerba 2026 PDF</image:title>', $xml);
    }

    public function testGenerateXmlIncludesAllArticlesBeyondDefaultLimit() {
        $productRepo = new DummyProductRepository();
        $serviceRepo = new DummyServiceRepository();
        $articleRepo = new DummyArticleRepository();

        $service = new SitemapService($productRepo, $serviceRepo, $articleRepo);
        $xml = $service->generateXml('https://djerbavoyage.tn');

        // L'article 15 doit être présent (car getAllPublished(1000) a été appelé au lieu du limit=10 par défaut)
        $this->assertStringContainsString('<loc>https://djerbavoyage.tn/guide/guide-test-djerba-15</loc>', $xml);
    }

    public function testGenerateRobotsContainsSitemapUrl() {
        $productRepo = new DummyProductRepository();
        $serviceRepo = new DummyServiceRepository();
        $articleRepo = new DummyArticleRepository();

        $controller = new SitemapController($productRepo, $serviceRepo, $articleRepo);
        $robots = $controller->generateRobots('https://djerbavoyage.tn');

        $this->assertStringContainsString('User-agent: *', $robots);
        $this->assertStringContainsString('Content-Signal: search=yes, ai-input=yes, ai-train=no', $robots);
        $this->assertStringContainsString('Sitemap: https://djerbavoyage.tn/sitemap.xml', $robots);
    }

    public function testRegenerateFileCreatesPhysicalFilesOnDisk() {
        $productRepo = new DummyProductRepository();
        $serviceRepo = new DummyServiceRepository();
        $articleRepo = new DummyArticleRepository();

        $service = new SitemapService($productRepo, $serviceRepo, $articleRepo);
        $result = $service->regenerateFile('https://djerbavoyage.tn');

        $this->assertTrue($result);
        $root = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        $sitemapPath = $root . '/public/sitemap.xml';
        $robotsPath  = $root . '/public/robots.txt';

        $this->assertFileExists($sitemapPath);
        $this->assertFileExists($robotsPath);

        $content = file_get_contents($sitemapPath);
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('<loc>https://djerbavoyage.tn/shop/guide-djerba-pdf</loc>', $content);
    }

    public function testProductAdminTriggersSitemapRegeneration() {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }
        $_SESSION['admin_logged'] = true;

        $productRepo = new DummyProductRepository();
        $serviceRepo = new DummyServiceRepository();
        $articleRepo = new DummyArticleRepository();
        $sitemapService = new TrackingSitemapService($productRepo, $serviceRepo, $articleRepo);

        $adminController = new ProductsAdminController($productRepo, $sitemapService);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'slug' => 'nouveau-produit-test',
            'title_fr' => 'Nouveau Produit Test',
            'price_eur' => '25.00',
            'file_path' => 'guide.pdf',
            'is_active' => '1'
        ];

        // Capture la redirection
        try {
            $adminController->create();
        } catch (\Throwable $e) {
            // Ignorer si redirection exit/header
        }

        $this->assertEquals(1, $sitemapService->regenerateCalls);
        $this->assertCount(1, $productRepo->created);

        // Test delete déclenche également
        try {
            $adminController->delete(1);
        } catch (\Throwable $e) {}

        $this->assertEquals(2, $sitemapService->regenerateCalls);
    }

    public function testArticleAdminTriggersSitemapRegeneration() {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }
        $_SESSION['admin_logged'] = true;

        $productRepo = new DummyProductRepository();
        $serviceRepo = new DummyServiceRepository();
        $articleRepo = new DummyArticleRepository();
        $sitemapService = new TrackingSitemapService($productRepo, $serviceRepo, $articleRepo);

        $adminController = new \App\Controllers\Admin\ArticlesAdminController($articleRepo, null, $sitemapService);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'title_fr' => 'Nouvel Article Djerba Test',
            'slug' => 'nouvel-article-djerba-test',
            'content_fr' => '<p>Contenu de test du sitemap</p>',
            'status' => 'published'
        ];

        try {
            $adminController->create();
        } catch (\Throwable $e) {}

        $this->assertEquals(1, $sitemapService->regenerateCalls);

        // Test delete déclenche également
        $_POST = ['id' => 1];
        try {
            $adminController->delete();
        } catch (\Throwable $e) {}

        $this->assertEquals(2, $sitemapService->regenerateCalls);
    }

    public function testShopControllerShowProduct() {
        $productRepo = new DummyProductRepository();
        $pdo = \Core\Database::getInstance();
        $settingsRepo = new \App\Repositories\PdoSettingsRepository($pdo);
        $settingsService = new \App\Services\SettingsService($settingsRepo, new \App\Services\CacheService());
        $analyticsService = new \App\Services\AnalyticsService($pdo);

        $shopController = new \App\Controllers\ShopController($productRepo, $settingsService, $analyticsService);

        ob_start();
        $shopController->show('guide-djerba-pdf');
        $output = ob_get_clean();

        $this->assertNotEmpty($output);
        $this->assertStringContainsString('id="product-guide-djerba-pdf"', $output);
        $this->assertStringContainsString('Guide Djerba 2026 PDF', $output);
    }

    public function testGenerateXmlIncludesGoogleVideoSitemapTags() {
        $productRepo = new DummyProductRepository();
        $serviceRepo = new DummyServiceRepository();
        
        $articleWithVideo = new Article(
            id: 99,
            slug: 'video-djerba-quad',
            titleFr: 'Aventure en Quad à Djerba',
            featuredImage: '/assets/images/blog/quad.jpg',
            seoDescription: 'Superbe vidéo de quad à Djerba',
            publishedAt: '2026-09-19 12:00:00',
            videoUrl: 'assets/videos/reels/desert_quad.mp4'
        );
        
        $mockArticleRepo = new class([$articleWithVideo]) extends DummyArticleRepository {
            public function __construct(private array $articles) {}
            public function getAllPublished(int $limit = 10): array { return $this->articles; }
        };

        $service = new SitemapService($productRepo, $serviceRepo, $mockArticleRepo);
        $xml = $service->generateXml('https://djerbavoyage.tn');

        $this->assertStringContainsString('xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"', $xml);
        $this->assertStringContainsString('<video:video>', $xml);
        $this->assertStringContainsString('<video:content_loc>https://djerbavoyage.tn/assets/videos/reels/desert_quad.mp4</video:content_loc>', $xml);
        $this->assertStringContainsString('<video:title>Aventure en Quad à Djerba</video:title>', $xml);
        $this->assertStringContainsString('<video:duration>19</video:duration>', $xml);
    }
}

