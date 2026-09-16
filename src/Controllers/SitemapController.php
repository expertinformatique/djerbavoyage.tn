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
        echo $this->generateXml();
        exit;
    }

    public function robots(): void {
        header('Content-Type: text/plain; charset=utf-8');
        echo $this->generateRobots();
        exit;
    }

    public function generateXml(?string $domain = null): string {
        $baseUrl = $domain ? rtrim($domain, '/') : rtrim(function_exists('absolute_url') ? absolute_url('') : 'https://djerbavoyage.tn', '/');
        if (empty($baseUrl) || str_contains($baseUrl, 'localhost') || str_contains($baseUrl, '127.0.0.1')) {
            $baseUrl = 'https://djerbavoyage.tn';
        }

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
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        foreach ($staticPages as $path => $meta) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . $path, ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$currentDate}</lastmod>\n";
            $xml .= "    <changefreq>{$meta['freq']}</changefreq>\n";
            $xml .= "    <priority>{$meta['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        foreach ($articles as $art) {
            $date = !empty($art->publishedAt) ? date('Y-m-d', strtotime($art->publishedAt)) : (!empty($art->createdAt) ? date('Y-m-d', strtotime($art->createdAt)) : $currentDate);
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . '/guide/' . $art->slug, ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$date}</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";

            if (!empty($art->featuredImage)) {
                $imgUrl = str_starts_with($art->featuredImage, 'http') ? $art->featuredImage : $baseUrl . '/' . ltrim($art->featuredImage, '/');
                $title = htmlspecialchars($art->titleFr ?? 'Guide Djerba Voyage', ENT_QUOTES, 'UTF-8');
                $xml .= "    <image:image>\n";
                $xml .= "      <image:loc>" . htmlspecialchars($imgUrl, ENT_QUOTES, 'UTF-8') . "</image:loc>\n";
                $xml .= "      <image:title>{$title}</image:title>\n";
                $xml .= "    </image:image>\n";
            }

            $xml .= "  </url>\n";

            if (!empty($art->pdfEnabled)) {
                $xml .= "  <url>\n";
                $xml .= "    <loc>" . htmlspecialchars($baseUrl . '/guide/' . $art->slug . '/pdf', ENT_QUOTES, 'UTF-8') . "</loc>\n";
                $xml .= "    <lastmod>{$date}</lastmod>\n";
                $xml .= "    <changefreq>monthly</changefreq>\n";
                $xml .= "    <priority>0.5</priority>\n";
                $xml .= "  </url>\n";
            }
        }

        foreach ($destinations as $dest) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . '/destinations/' . $dest, ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$currentDate}</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';
        return $xml;
    }

    public function generateRobots(?string $domain = null): string {
        $baseUrl = $domain ? rtrim($domain, '/') : rtrim(function_exists('absolute_url') ? absolute_url('') : 'https://djerbavoyage.tn', '/');
        if (empty($baseUrl) || str_contains($baseUrl, 'localhost') || str_contains($baseUrl, '127.0.0.1')) {
            $baseUrl = 'https://djerbavoyage.tn';
        }

        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /admin/\n";
        $robots .= "Disallow: /api/\n";
        $robots .= "Disallow: /download\n";
        $robots .= "\nSitemap: {$baseUrl}/sitemap.xml\n";

        return $robots;
    }
}
