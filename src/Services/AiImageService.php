<?php
namespace App\Services;

class AiImageService {
    /**
     * Génère une image correspondant exactement au sujet de l'article
     * via Pollinations AI (Flux model) et l'enregistre en local si possible.
     */
    public function resolveThemeImage(string $text, array $context): string {
        $t = strtolower($text . ' ' . ($context['angle']['theme'] ?? ''));
        if (preg_match('/guellala|poterie|potter|argile|craftsman/i', $t)) {
            return 'images/guellala.png';
        }
        if (preg_match('/ajim|éponge|sponge|marin|pech|sailor/i', $t)) {
            return 'images/ajim.png';
        }
        if (preg_match('/djerbahood|erriadh|mural|street\s*art/i', $t)) {
            return 'images/djerbahood.png';
        }
        if (preg_match('/souk|poisson|fish|culinaire|cuisine|gastronomie|criée/i', $t)) {
            return 'images/houmt_souk.png';
        }
        if (preg_match('/menzel|houch|architecture|patrimoine|hotel|charme/i', $t)) {
            return 'images/concierge.png';
        }
        if (preg_match('/quad|buggy|desert|sahara|dune|caravane|chameau|dromadaire/i', $t)) {
            return 'images/service_quad.jpg';
        }
        if (preg_match('/kitesurf|kite|jet\s*ski|planche|glisse/i', $t)) {
            return 'images/service_kitesurf.jpg';
        }
        return $context['angle']['fallback_local_image'] ?? 'images/sidi_mahres.png';
    }

    public function generateForArticle(string $imagePrompt, string $slug, array $context): string {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        $fallback = $this->resolveThemeImage($imagePrompt, $context);

        $cleanPrompt = trim(preg_replace('/\s+/', ' ', $imagePrompt));
        if (empty($cleanPrompt)) {
            $cleanPrompt = $context['angle']['image_prompt'] ?? 'scenic photo of Djerba Tunisia';
        }

        // Compléter avec le contexte djerbien si absent
        if (!str_contains(strtolower($cleanPrompt), 'djerba') && !str_contains(strtolower($cleanPrompt), 'tunisia')) {
            $cleanPrompt .= ', Djerba Tunisia';
        }
        $cleanPrompt .= ', photorealistic 8k, warm Mediterranean light, travel photography, no text, no watermark';

        $seed = rand(1000, 99999);
        $encodedPrompt = urlencode($cleanPrompt);
        $aiUrl = "https://image.pollinations.ai/prompt/{$encodedPrompt}?width=1200&height=675&nologo=true&model=flux&seed={$seed}";

        // En mode test unitaire : éviter tout appel réseau externe
        if (defined('PHPUNIT_RUNNING') || getenv('APP_ENV') === 'testing' || (defined('PHPUNIT_COMPAT') && PHPUNIT_COMPAT)) {
            return $fallback;
        }

        // Tenter de télécharger et stocker localement l'image générée
        $blogDir = $rootPath . '/public/assets/images/blog';
        if (!is_dir($blogDir)) {
            @mkdir($blogDir, 0777, true);
        }

        $localFilename = $slug . '.jpg';
        $localFilePath = $blogDir . '/' . $localFilename;

        $ch = curl_init($aiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'DjerbaVoyageBot/1.0 (image generator)');
        $imageData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $imageData && strlen($imageData) > 3000) {
            if (@file_put_contents($localFilePath, $imageData) !== false) {
                return 'images/blog/' . $localFilename;
            }
            return $aiUrl;
        }

        // Si le téléchargement échoue, utiliser l'URL directe ou le fallback local adapté au thème
        return !empty($aiUrl) ? $aiUrl : $fallback;
    }
}
