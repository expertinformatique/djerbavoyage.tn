<?php
namespace App\Services;

use App\Models\Article;

class ArticlePdfService {
    public function generateHtmlForPdf(Article $article, ?string $locale = null): string {
        $lang = $locale ?? (\class_exists('Core\Lang') ? \Core\Lang::getLocale() : 'fr');
        $title = htmlspecialchars($article->getTitle($lang), ENT_QUOTES, 'UTF-8');
        $date = $article->publishedAt ? date('d/m/Y', strtotime($article->publishedAt)) : date('d/m/Y');
        $author = htmlspecialchars($article->authorName, ENT_QUOTES, 'UTF-8');

        // Construire l'URL absolue de l'image de couverture
        $img = '';
        if (!empty($article->featuredImage)) {
            $img = $this->toAbsoluteUrl($article->featuredImage);
        }

        // Corriger les URLs relatives dans le contenu de l'article
        $contentHtml = $this->fixContentUrls($article->getContent($lang));

        $baseUrl = $this->getBaseUrl();
        $isRtl = ($lang === 'ar');
        $dirAttr = $isRtl ? 'dir="rtl"' : 'dir="ltr"';
        $canonicalUrl = rtrim($baseUrl, '/') . '/guide/' . urlencode($article->slug);
        if ($lang && $lang !== 'fr') {
            $canonicalUrl .= '?lang=' . urlencode($lang);
        }

        return <<<HTML
<!DOCTYPE html>
<html lang="{$lang}" {$dirAttr}>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="{$canonicalUrl}">
    <base href="{$baseUrl}/">
    <title>Guide Djerba — {$title}</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #1e293b; line-height: 1.6; margin: 0; padding: 40px; background: #ffffff; }
        .header { text-align: center; border-bottom: 2px solid #0284c7; padding-bottom: 20px; margin-bottom: 30px; }
        .brand { font-size: 24px; font-weight: bold; color: #0284c7; text-transform: uppercase; letter-spacing: 2px; }
        .tagline { font-size: 13px; color: #64748b; margin-top: 4px; }
        .title { font-size: 26px; font-weight: bold; color: #0f172a; margin-top: 20px; line-height: 1.3; }
        .meta { font-size: 12px; color: #64748b; margin-top: 10px; margin-bottom: 20px; }
        .hero-img { width: 100%; max-height: 380px; object-fit: cover; border-radius: 12px; margin-bottom: 25px; }
        .content { font-size: 15px; color: #334155; }
        .content h2 { font-size: 20px; color: #0369a1; border-left: 4px solid #0284c7; padding-left: 10px; margin-top: 25px; }
        .content h3 { font-size: 17px; color: #0f172a; }
        .content img { max-width: 100%; height: auto; border-radius: 8px; margin: 15px 0; }
        .footer { margin-top: 40px; padding: 20px; background: #f0f9ff; border-radius: 10px; border: 1px solid #bae6fd; text-align: center; }
        .footer-title { font-weight: bold; color: #0369a1; font-size: 16px; margin-bottom: 8px; }
        .footer-text { font-size: 13px; color: #0369a1; }
        @media print {
            body { padding: 20px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="background: #0284c7; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold;">
            🖨️ Imprimer / Sauvegarder en PDF
        </button>
    </div>
    <div class="header">
        <div class="brand">🏝️ Djerba Voyage</div>
        <div class="tagline">Guide Touristique Exclusif & Carnet de Voyage</div>
        <h1 class="title">{$title}</h1>
        <div class="meta">Publié le {$date} par {$author} | Document Officiel Djerba Voyage</div>
    </div>

    {$this->renderImageTag($img)}

    <div class="content">
        {$contentHtml}
    </div>

    <div class="footer">
        <div class="footer-title">Réservez vos Excursions & Services à Djerba</div>
        <div class="footer-text">
            Visitez <strong>https://djerbavoyage.tn</strong> pour réserver vos sorties Quad, Kitesurf, Transferts Aéroport et Conciergerie Premium au meilleur prix garanti.
        </div>
    </div>
</body>
</html>
HTML;
    }

    private function renderImageTag(string $url): string {
        if (empty($url)) return '';
        return '<img class="hero-img" src="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" alt="Illustration Djerba Voyage" />';
    }

    /**
     * Convertir un chemin relatif d'image en URL absolue
     */
    private function toAbsoluteUrl(string $path): string {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
            return $path;
        }
        $cleanPath = ltrim($path, '/');
        // Vérifier si le chemin commence déjà par assets/images/ ou images/
        if (!str_starts_with($cleanPath, 'assets/') && !str_starts_with($cleanPath, 'images/')) {
            $cleanPath = 'images/' . $cleanPath;
        }
        if (str_starts_with($cleanPath, 'images/')) {
            $cleanPath = 'assets/' . $cleanPath;
        }
        return $this->getBaseUrl() . '/' . $cleanPath;
    }

    /**
     * Corriger les URLs relatives des images dans le contenu HTML
     */
    private function fixContentUrls(string $html): string {
        $baseUrl = $this->getBaseUrl();
        // src="/assets/..." ou src="/images/..." → URL absolue
        $html = preg_replace(
            '/src="\/([^"]+)"/',
            'src="' . $baseUrl . '/$1"',
            $html
        );
        // src="assets/..." (sans slash initial) → URL absolue
        $html = preg_replace(
            '/src="(?!https?:\/\/|\/\/)(?!data:)(assets\/[^"]+)"/',
            'src="' . $baseUrl . '/$1"',
            $html
        );
        // src="images/..." (sans slash initial) → URL absolue
        $html = preg_replace(
            '/src="(?!https?:\/\/|\/\/)(?!data:)(images\/[^"]+)"/',
            'src="' . $baseUrl . '/assets/$1"',
            $html
        );
        return $html;
    }

    private function getBaseUrl(): string {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'] ?? 'djerbavoyage.tn';
        return rtrim($scheme . $host, '/');
    }
}
