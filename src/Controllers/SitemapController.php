<?php
namespace App\Controllers;

use Core\Controller;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\LocalServiceRepositoryInterface;
use App\Interfaces\ArticleRepositoryInterface;
use App\Services\SitemapService;

class SitemapController extends Controller {
    private SitemapService $sitemapService;

    public function __construct(
        private ProductRepositoryInterface $productRepo,
        private LocalServiceRepositoryInterface $serviceRepo,
        private ArticleRepositoryInterface $articleRepo,
        ?SitemapService $sitemapService = null
    ) {
        $this->sitemapService = $sitemapService ?? new SitemapService($this->productRepo, $this->serviceRepo, $this->articleRepo);
    }

    public function sitemap(): void {
        header('Content-Type: application/xml; charset=utf-8');
        $xml = $this->sitemapService->generateXml();
        $this->sitemapService->regenerateFile();
        echo $xml;
        exit;
    }

    public function robots(): void {
        header('Content-Type: text/plain; charset=utf-8');
        echo $this->sitemapService->generateRobots();
        exit;
    }

    public function generateXml(?string $domain = null): string {
        return $this->sitemapService->generateXml($domain);
    }

    public function generateRobots(?string $domain = null): string {
        return $this->sitemapService->generateRobots($domain);
    }
}
