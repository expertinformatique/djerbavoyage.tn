<?php
namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\LocalServiceRepositoryInterface;
use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Product;
use Throwable;

class SitemapService {
    public function __construct(
        private ProductRepositoryInterface $productRepo,
        private LocalServiceRepositoryInterface $serviceRepo,
        private ArticleRepositoryInterface $articleRepo
    ) {}

    public function generateXml(?string $domain = null): string {
        $baseUrl = $this->resolveBaseUrl($domain);
        $currentDate = date('Y-m-d');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        $xml .= $this->buildStaticPagesXml($baseUrl, $currentDate);
        $xml .= $this->buildProductsXml($baseUrl, $currentDate);
        $xml .= $this->buildArticlesXml($baseUrl, $currentDate);
        $xml .= $this->buildDestinationsXml($baseUrl, $currentDate);

        $xml .= '</urlset>';
        return $xml;
    }

    public function generateRobots(?string $domain = null): string {
        $baseUrl = $this->resolveBaseUrl($domain);

        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /admin/\n";
        $robots .= "Disallow: /api/\n";
        $robots .= "Disallow: /download\n";
        $robots .= "\nSitemap: {$baseUrl}/sitemap.xml\n";

        return $robots;
    }

    public function regenerateFile(?string $domain = null): bool {
        try {
            $root = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            $publicDir = $root . '/public';
            if (!is_dir($publicDir)) {
                @mkdir($publicDir, 0755, true);
            }

            $xmlContent = $this->generateXml($domain);
            $robotsContent = $this->generateRobots($domain);

            file_put_contents($publicDir . '/sitemap.xml', $xmlContent, LOCK_EX);
            file_put_contents($publicDir . '/robots.txt', $robotsContent, LOCK_EX);

            return true;
        } catch (Throwable $e) {
            $root = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            @error_log("[" . date('Y-m-d H:i:s') . "] ERROR SitemapService: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $root . '/error.log');
            return false;
        }
    }

    private function resolveBaseUrl(?string $domain): string {
        $baseUrl = $domain ? rtrim($domain, '/') : rtrim(function_exists('absolute_url') ? absolute_url('') : 'https://djerbavoyage.tn', '/');
        if (empty($baseUrl) || str_contains($baseUrl, 'localhost') || str_contains($baseUrl, '127.0.0.1')) {
            $baseUrl = 'https://djerbavoyage.tn';
        }
        return $baseUrl;
    }

    private function buildStaticPagesXml(string $baseUrl, string $currentDate): string {
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

        $xml = '';
        foreach ($staticPages as $path => $meta) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . $path, ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$currentDate}</lastmod>\n";
            $xml .= "    <changefreq>{$meta['freq']}</changefreq>\n";
            $xml .= "    <priority>{$meta['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }
        return $xml;
    }

    private function buildProductsXml(string $baseUrl, string $currentDate): string {
        $xml = '';
        $products = $this->productRepo->getAllActive();
        foreach ($products as $prod) {
            $slug = !empty($prod->slug) ? $prod->slug : 'produit-' . $prod->id;
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . '/shop/' . $slug, ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$currentDate}</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";

            $thumbImage = $this->getProductImage($prod);
            $title = htmlspecialchars($prod->titleFr ?: 'Guide Produit Djerba', ENT_QUOTES, 'UTF-8');
            $xml .= "    <image:image>\n";
            $xml .= "      <image:loc>" . htmlspecialchars($baseUrl . '/images/' . $thumbImage, ENT_QUOTES, 'UTF-8') . "</image:loc>\n";
            $xml .= "      <image:title>{$title}</image:title>\n";
            $xml .= "    </image:image>\n";
            $xml .= "  </url>\n";
        }
        return $xml;
    }

    private function buildArticlesXml(string $baseUrl, string $currentDate): string {
        $xml = '';
        $articles = $this->articleRepo->getAllPublished(1000);
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
        return $xml;
    }

    private function buildDestinationsXml(string $baseUrl, string $currentDate): string {
        $xml = '';
        $destinations = ['houmt-souk', 'sidi-mahres', 'djerbahood-erriadh', 'aghir', 'guellala', 'ajim-el-melga'];
        foreach ($destinations as $dest) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . '/destinations/' . $dest, ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$currentDate}</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }
        return $xml;
    }

    public function getProductImage(Product $prod): string {
        $titleLower = mb_strtolower($prod->titleFr);
        if (str_contains($titleLower, 'carte gps') || str_contains($titleLower, 'map')) {
            return 'shop_gps_map.jpg';
        }
        if (str_contains($titleLower, 'pass') || str_contains($titleLower, 'excursion') || str_contains($titleLower, 'balade') || str_contains($titleLower, 'session') || str_contains($titleLower, 'jet') || str_contains($titleLower, 'quad')) {
            return str_contains($titleLower, 'jet') ? 'service_jetski.jpg' : (str_contains($titleLower, 'quad') ? 'service_quad.jpg' : 'service_bateau_pirate.jpg');
        }
        if (str_contains($titleLower, 'pack')) {
            return 'hero.png';
        }
        if (str_contains($titleLower, 'audio')) {
            return 'shop_audio_guide.jpg';
        }
        return 'shop_guide_pdf.jpg';
    }
}
