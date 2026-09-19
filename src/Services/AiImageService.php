<?php
namespace App\Services;

class AiImageService {
    /**
     * Bibliothèque thématique de photographies HD réelles de Djerba et Tunisie
     * 100% libres de droits, sans logo, sans filigrane, optimisées 1200x675.
     */
    private array $curatedPhotos = [
        'desert_quad' => [
            'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=1200&h=675&q=85',
            'https://images.unsplash.com/photo-1547234935-80c7145ec969?auto=format&fit=crop&w=1200&h=675&q=85',
            'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1200&h=675&q=85'
        ],
        'guellala_pottery' => [
            'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?auto=format&fit=crop&w=1200&h=675&q=85',
            'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?auto=format&fit=crop&w=1200&h=675&q=85'
        ],
        'djerbahood_art' => [
            'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=1200&h=675&q=85',
            'https://images.unsplash.com/photo-1528728329032-2972f65dfb3f?auto=format&fit=crop&w=1200&h=675&q=85'
        ],
        'ajim_maritime' => [
            'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&h=675&q=85',
            'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&h=675&q=85'
        ],
        'flamants_lagoon' => [
            'https://images.unsplash.com/photo-1497206365907-f5e630693df0?auto=format&fit=crop&w=1200&h=675&q=85',
            'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1200&h=675&q=85'
        ],
        'cuisine_souk' => [
            'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=1200&h=675&q=85',
            'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&h=675&q=85'
        ],
        'menzel_unesco' => [
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1200&h=675&q=85',
            'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&h=675&q=85'
        ],
        'kitesurf_water' => [
            'https://images.unsplash.com/photo-1502680390469-be75c86b636f?auto=format&fit=crop&w=1200&h=675&q=85',
            'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&h=675&q=85'
        ],
        'tataouine_ksar' => [
            'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=1200&h=675&q=85',
            'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1200&h=675&q=85'
        ],
        'beach_sidi_mahres' => [
            'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&h=675&q=85',
            'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=1200&h=675&q=85'
        ]
    ];

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

    public function generateForArticle(string $imagePrompt, string $slug, array $context): string {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        $fallback = $this->resolveThemeImage($imagePrompt, $context);

        if (defined('PHPUNIT_RUNNING') || getenv('APP_ENV') === 'testing' || (defined('PHPUNIT_COMPAT') && PHPUNIT_COMPAT)) {
            return $fallback;
        }

        $themeKey = $this->resolveThemeKey($imagePrompt . ' ' . ($context['angle']['theme'] ?? ''));
        $targetUrl = $this->resolveRemotePhotoUrl($themeKey, $imagePrompt);
        if (empty($targetUrl)) {
            return $fallback;
        }

        return $this->downloadAndSaveLocal($targetUrl, $slug, $rootPath, $fallback);
    }

    private function resolveRemotePhotoUrl(string $themeKey, string $imagePrompt): string {
        // Sélection aléatoire parmi les photographies HD dédiées
        $pool = $this->curatedPhotos[$themeKey] ?? $this->curatedPhotos['beach_sidi_mahres'];
        $selectedUrl = $pool[array_rand($pool)];

        // Option Wikimedia si mot-clé très spécifique présent
        if (stripos($imagePrompt, 'Guellala') !== false || stripos($imagePrompt, 'Ghriba') !== false) {
            $wikiUrl = $this->fetchFromWikimedia($imagePrompt);
            if (!empty($wikiUrl)) {
                return $wikiUrl;
            }
        }

        return $selectedUrl;
    }

    private function fetchFromWikimedia(string $query): ?string {
        try {
            $apiUrl = "https://commons.wikimedia.org/w/api.php?action=query&list=search&srsearch="
                . urlencode("Djerba " . $query) . "&srnamespace=6&format=json";
            $res = $this->curlGet($apiUrl, 3);
            if (!$res) return null;

            $data = json_decode($res, true);
            $first = $data['query']['search'][0]['title'] ?? null;
            if (!$first) return null;

            $infoUrl = "https://commons.wikimedia.org/w/api.php?action=query&titles="
                . urlencode($first) . "&prop=imageinfo&iiprop=url&format=json";
            $infoRes = $this->curlGet($infoUrl, 3);
            if (!$infoRes) return null;

            $infoData = json_decode($infoRes, true);
            $pages = $infoData['query']['pages'] ?? [];
            $page = reset($pages);
            return $page['imageinfo'][0]['url'] ?? null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function downloadAndSaveLocal(string $remoteUrl, string $slug, string $rootPath, string $fallback): string {
        $blogDir = $rootPath . '/public/assets/images/blog';
        if (!is_dir($blogDir)) {
            @mkdir($blogDir, 0777, true);
        }

        $localFilename = $slug . '.jpg';
        $localFilePath = $blogDir . '/' . $localFilename;

        $imageData = $this->curlGet($remoteUrl, 8);
        if ($imageData && strlen($imageData) > 5000) {
            if (@file_put_contents($localFilePath, $imageData) !== false) {
                return 'images/blog/' . $localFilename;
            }
        }

        return $fallback;
    }

    private function curlGet(string $url, int $timeout): ?string {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'DjerbaVoyageBot/1.0 (Travel Guide HD Images)');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $data = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($code === 200 && $data) ? $data : null;
    }
}
