<?php
namespace App\Services;

/**
 * Service d'Images AI pour les Articles & Guides de Djerba
 * Intègre le générateur d'images IA Nano Banana (100% uniques et photoréalistes).
 */
class AiImageService {
    private NanoBananaImageService $nanoBanana;

    public function __construct(?NanoBananaImageService $nanoBanana = null, ?SettingsService $settings = null) {
        $this->nanoBanana = $nanoBanana ?? new NanoBananaImageService(null, null, null, $settings);
    }

    public function getNanoBananaService(): NanoBananaImageService {
        return $this->nanoBanana;
    }

    public function resolveThemeKey(string $text): string {
        $t = strtolower($text);
        if (preg_match('/guellala|poterie|potter|argile|craftsman/i', $t)) return 'guellala_pottery';
        if (preg_match('/ajim|éponge|sponge|marin|pech|sailor/i', $t)) return 'ajim_maritime';
        if (preg_match('/djerbahood|erriadh|mural|street\s*art/i', $t)) return 'djerbahood_art';
        if (preg_match('/flamant|ras\s*rmel|oiseau|lagune/i', $t)) return 'flamants_lagoon';
        if (preg_match('/souk|poisson|fish|culinaire|cuisine|gastronomie|criée/i', $t)) return 'cuisine_souk';
        if (preg_match('/menzel|houch|architecture|patrimoine|hotel|charme/i', $t)) return 'menzel_unesco';
        if (preg_match('/quad|buggy|desert|sahara|dune|caravane|chameau|dromadaire/i', $t)) return 'desert_quad';
        if (preg_match('/kitesurf|kite|jet\s*ski|planche|glisse/i', $t)) return 'kitesurf_water';
        if (preg_match('/tataouine|ksar|ksour|chenini|star\s*wars/i', $t)) return 'tataouine_ksar';
        return 'beach_sidi_mahres';
    }

    public function resolveThemeImage(string $text, array $context): string {
        $key = $this->resolveThemeKey($text . ' ' . ($context['angle']['theme'] ?? ''));
        $fallbacks = [
            'guellala_pottery'  => 'images/guellala.png',
            'ajim_maritime'     => 'images/ajim.png',
            'djerbahood_art'    => 'images/djerbahood.png',
            'flamants_lagoon'   => 'images/sidi_mahres.png',
            'cuisine_souk'      => 'images/houmt_souk.png',
            'menzel_unesco'     => 'images/concierge.png',
            'desert_quad'       => 'images/service_quad.jpg',
            'kitesurf_water'    => 'images/service_kitesurf.jpg',
            'tataouine_ksar'    => 'images/service_quad.jpg',
            'beach_sidi_mahres' => 'images/sidi_mahres.png',
        ];
        return $fallbacks[$key] ?? ($context['angle']['fallback_local_image'] ?? 'images/sidi_mahres.png');
    }

    /**
     * Génère une image 100% unique et photoréaliste pour un article via Nano Banana.
     */
    public function generateForArticle(string $imagePrompt, string $slug, array $context): string {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        $fallback = $this->resolveThemeImage($imagePrompt, $context);

        // Environnement de tests unitaires (mode offline rapide)
        if (defined('PHPUNIT_RUNNING') || getenv('APP_ENV') === 'testing' || (defined('PHPUNIT_COMPAT') && PHPUNIT_COMPAT)) {
            return $fallback;
        }

        // Génération obligatoire et unique via Nano Banana
        $nanoImage = $this->nanoBanana->generate($imagePrompt, $slug, $rootPath, $context);
        if (!empty($nanoImage)) {
            return $nanoImage;
        }

        // Deuxième tentative Nano Banana avec le thème précis de l'article
        $themePrompt = $context['angle']['theme'] ?? $imagePrompt;
        $retrySlug = $slug . '-nano-' . mt_rand(100, 999);
        $nanoRetry = $this->nanoBanana->generate($themePrompt, $retrySlug, $rootPath, $context);
        if (!empty($nanoRetry)) {
            return $nanoRetry;
        }

        return $fallback;
    }
}
