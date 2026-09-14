<?php
namespace App\Controllers;

use Core\Controller;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\LocalServiceRepositoryInterface;
use App\Interfaces\ArticleRepositoryInterface;

class SitemapController extends Controller {
    public function __construct(
        private ProductRepositoryInterface $productRepo,
        private LocalServiceRepositoryInterface $serviceRepo,
        private ArticleRepositoryInterface $articleRepo
    ) {}

    public function sitemap(): void {
        header('Content-Type: application/xml; charset=utf-8');

        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
        $currentDate = date('Y-m-d');

        $staticPages = [
            '/'                            => ['priority' => '1.0', 'freq' => 'daily'],
            '/services'                    => ['priority' => '0.9', 'freq' => 'daily'],
            '/shop'                        => ['priority' => '0.9', 'freq' => 'daily'],
            '/activites'                   => ['priority' => '0.8', 'freq' => 'weekly'],
            '/itineraires'                 => ['priority' => '0.8', 'freq' => 'weekly'],
            '/hotels-restaurants'          => ['priority' => '0.8', 'freq' => 'weekly'],
            '/gastronomie'                 => ['priority' => '0.7', 'freq' => 'weekly'],
            '/transports'                  => ['priority' => '0.7', 'freq' => 'weekly'],
            '/meteo-climat'                => ['priority' => '0.7', 'freq' => 'monthly'],
            '/guide'                       => ['priority' => '0.8', 'freq' => 'daily'],
            '/concierge'                   => ['priority' => '0.8', 'freq' => 'weekly'],
            '/avis'                        => ['priority' => '0.7', 'freq' => 'weekly'],
            '/faq'                         => ['priority' => '0.6', 'freq' => 'monthly'],
            '/a-propos'                     => ['priority' => '0.5', 'freq' => 'monthly'],
            '/contact'                     => ['priority' => '0.5', 'freq' => 'monthly'],
            '/politique-de-confidentialite' => ['priority' => '0.3', 'freq' => 'yearly'],
            '/divulgation-affiliation'      => ['priority' => '0.3', 'freq' => 'yearly'],
        ];

        $articles = $this->articleRepo->getAllPublished();
        $destinations = ['houmt-souk', 'sidi-mahres', 'djerbahood-erriadh', 'aghir', 'guellala', 'ajim-el-melga'];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($staticPages as $path => $meta) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . $path) . "</loc>\n";
            $xml .= "    <lastmod>{$currentDate}</lastmod>\n";
            $xml .= "    <changefreq>{$meta['freq']}</changefreq>\n";
            $xml .= "    <priority>{$meta['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        foreach ($articles as $art) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . '/guide/' . $art->slug) . "</loc>\n";
            $xml .= "    <lastmod>" . substr($art->createdAt ?? $currentDate, 0, 10) . "</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        foreach ($destinations as $dest) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . '/destinations/' . $dest) . "</loc>\n";
            $xml .= "    <lastmod>{$currentDate}</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';
        echo $xml;
        exit;
    }

    public function robots(): void {
        header('Content-Type: text/plain; charset=utf-8');
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');

        echo "User-agent: *\n";
        echo "Allow: /\n";
        echo "Disallow: /admin/\n";
        echo "Disallow: /api/\n";
        echo "Disallow: /download\n";
        echo "\nSitemap: {$baseUrl}/sitemap.xml\n";
        exit;
    }
}
