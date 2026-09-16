<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Controllers\SitemapController;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\LocalServiceRepositoryInterface;
use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Product;
use App\Models\LocalService;
use App\Models\Article;

class DummyProductRepository implements ProductRepositoryInterface {
    public function findById(int $id): ?Product { return null; }
    public function findBySlug(string $slug): ?Product { return null; }
    public function getAllActive(): array { return []; }
    public function getAll(): array { return []; }
    public function countAll(): int { return 0; }
    public function getPaginated(int $page = 1, int $limit = 10): array { return []; }
    public function create(Product $product): bool { return true; }
    public function update(Product $product): bool { return true; }
    public function delete(int $id): bool { return true; }
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
    public function findById(int $id): ?Article { return null; }
    public function getAllPublished(int $limit = 10): array {
        return [
            (object)[
                'slug' => 'guide-test-djerba',
                'titleFr' => 'Guide de Test Djerba',
                'featuredImage' => '/images/blog/test.jpg',
                'publishedAt' => '2026-09-17 10:00:00',
                'pdfEnabled' => true
            ]
        ];
    }
    public function getByDestination(int $destinationId): array { return []; }
    public function incrementViews(int $id): void {}
    public function save(Article $article): Article { return $article; }
    public function delete(int $id): bool { return true; }
    public function countPublished(): int { return 1; }
    public function countAll(): int { return 1; }
    public function getPaginated(int $page = 1, int $limit = 10, string $search = '', string $status = ''): array { return []; }
    public function getStats(): array { return []; }
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
        $this->assertStringContainsString('<loc>https://djerbavoyage.tn/guide/guide-test-djerba</loc>', $xml);
        $this->assertStringContainsString('<loc>https://djerbavoyage.tn/guide/guide-test-djerba/pdf</loc>', $xml);
        $this->assertStringContainsString('<image:loc>https://djerbavoyage.tn/images/blog/test.jpg</image:loc>', $xml);
    }

    public function testGenerateRobotsContainsSitemapUrl() {
        $productRepo = new DummyProductRepository();
        $serviceRepo = new DummyServiceRepository();
        $articleRepo = new DummyArticleRepository();

        $controller = new SitemapController($productRepo, $serviceRepo, $articleRepo);
        $robots = $controller->generateRobots('https://djerbavoyage.tn');

        $this->assertStringContainsString('User-agent: *', $robots);
        $this->assertStringContainsString('Sitemap: https://djerbavoyage.tn/sitemap.xml', $robots);
    }
}
