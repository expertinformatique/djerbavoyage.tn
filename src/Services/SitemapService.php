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
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">' . "\n";

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
        $robots .= "Content-Signal: search=yes, ai-input=yes, ai-train=no\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /admin/\n";
        $robots .= "Disallow: /api/\n";
        $robots .= "Disallow: /download\n\n";

        $aiBots = ['GPTBot', 'ChatGPT-User', 'ClaudeBot', 'PerplexityBot', 'Google-Extended', 'Bytespider', 'Applebot-Extended', 'CCBot'];
        foreach ($aiBots as $bot) {
            $robots .= "User-agent: {$bot}\n";
            $robots .= "Allow: /\n";
            $robots .= "Disallow: /admin/\n";
            $robots .= "Disallow: /api/\n";
            $robots .= "Disallow: /download\n\n";
        }

        $robots .= "Sitemap: {$baseUrl}/sitemap.xml\n";

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

    private function buildHreflangTags(string $fullUrl): string {
        $cleanUrl = strtok($fullUrl, '?');
        $xml = "    <xhtml:link rel=\"alternate\" hreflang=\"fr\" href=\"" . htmlspecialchars($cleanUrl, ENT_QUOTES, 'UTF-8') . "\" />\n";
        $xml .= "    <xhtml:link rel=\"alternate\" hreflang=\"en\" href=\"" . htmlspecialchars($cleanUrl . '?lang=en', ENT_QUOTES, 'UTF-8') . "\" />\n";
        $xml .= "    <xhtml:link rel=\"alternate\" hreflang=\"ar\" href=\"" . htmlspecialchars($cleanUrl . '?lang=ar', ENT_QUOTES, 'UTF-8') . "\" />\n";
        $xml .= "    <xhtml:link rel=\"alternate\" hreflang=\"x-default\" href=\"" . htmlspecialchars($cleanUrl, ENT_QUOTES, 'UTF-8') . "\" />\n";
        return $xml;
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
            $url = $baseUrl . $path;
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= $this->buildHreflangTags($url);
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
            $url = $baseUrl . '/shop/' . $slug;
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= $this->buildHreflangTags($url);
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
            $url = $baseUrl . '/guide/' . $art->slug;
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= $this->buildHreflangTags($url);
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

            if (!empty($art->videoUrl)) {
                $vidUrl = str_starts_with($art->videoUrl, 'http') ? $art->videoUrl : $baseUrl . '/' . ltrim($art->videoUrl, '/');
                $thumbUrl = !empty($art->featuredImage) ? (str_starts_with($art->featuredImage, 'http') ? $art->featuredImage : $baseUrl . '/' . ltrim($art->featuredImage, '/')) : $baseUrl . '/assets/images/hero.png';
                $vidTitle = htmlspecialchars($art->titleFr ?? 'Vidéo Djerba Voyage', ENT_QUOTES, 'UTF-8');
                $vidDesc = htmlspecialchars($art->seoDescription ?? $art->titleFr, ENT_QUOTES, 'UTF-8');
                $pubDate = !empty($art->publishedAt) ? date('c', strtotime($art->publishedAt)) : date('c');

                $xml .= "    <video:video>\n";
                $xml .= "      <video:thumbnail_loc>" . htmlspecialchars($thumbUrl, ENT_QUOTES, 'UTF-8') . "</video:thumbnail_loc>\n";
                $xml .= "      <video:title>{$vidTitle}</video:title>\n";
                $xml .= "      <video:description>{$vidDesc}</video:description>\n";
                $xml .= "      <video:content_loc>" . htmlspecialchars($vidUrl, ENT_QUOTES, 'UTF-8') . "</video:content_loc>\n";
                $xml .= "      <video:duration>19</video:duration>\n";
                $xml .= "      <video:publication_date>{$pubDate}</video:publication_date>\n";
                $xml .= "      <video:family_friendly>yes</video:family_friendly>\n";
                $xml .= "    </video:video>\n";
            }
            $xml .= "  </url>\n";

            if (!empty($art->pdfEnabled)) {
                $pdfUrl = $baseUrl . '/guide/' . $art->slug . '/pdf';
                $xml .= "  <url>\n";
                $xml .= "    <loc>" . htmlspecialchars($pdfUrl, ENT_QUOTES, 'UTF-8') . "</loc>\n";
                $xml .= $this->buildHreflangTags($pdfUrl);
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
            $url = $baseUrl . '/destinations/' . $dest;
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= $this->buildHreflangTags($url);
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
