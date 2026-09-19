<?php
namespace App\Services;

class ReelVideoProviderService {
    private array $remoteVideoBank = [
        'desert_quad' => 'https://www.w3schools.com/html/mov_bbb.mp4',
        'kitesurf_water' => 'https://www.w3schools.com/html/mov_bbb.mp4',
        'beach_lagoon' => 'https://www.w3schools.com/html/mov_bbb.mp4',
        'sunset_camels' => 'https://www.w3schools.com/html/mov_bbb.mp4',
        'patrimoine_village' => 'https://www.w3schools.com/html/mov_bbb.mp4'
    ];

    public function resolveThemeKey(string $text): string {
        $t = strtolower($text);
        if (preg_match('/quad|buggy|desert|sahara|dune/i', $t)) return 'desert_quad';
        if (preg_match('/kitesurf|kite|jet\s*ski|glisse/i', $t)) return 'kitesurf_water';
        if (preg_match('/chameau|dromadaire|coucher|soleil/i', $t)) return 'sunset_camels';
        if (preg_match('/poterie|guellala|djerbahood|menzel/i', $t)) return 'patrimoine_village';
        return 'beach_lagoon';
    }

    public function getVideoPathForTheme(string $themeText): ?string {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        $themeKey = $this->resolveThemeKey($themeText);
        $dir = $rootPath . '/public/assets/videos/reels';

        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }

        $localFile = $dir . '/' . $themeKey . '.mp4';
        if (file_exists($localFile) && filesize($localFile) > 10000) {
            return $localFile;
        }

        $downloaded = $this->downloadRemoteVideo($themeKey, $localFile);
        if ($downloaded) {
            return $downloaded;
        }

        $existingVideos = glob($dir . '/*.mp4');
        if (!empty($existingVideos)) {
            return $existingVideos[0];
        }

        return null;
    }

    private function downloadRemoteVideo(string $themeKey, string $targetPath): ?string {
        $url = $this->remoteVideoBank[$themeKey] ?? $this->remoteVideoBank['beach_lagoon'];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'DjerbaVoyageBot/1.0 (Reels Downloader)');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $data = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code === 200 && $data && strlen($data) > 10000) {
            if (@file_put_contents($targetPath, $data) !== false) {
                return $targetPath;
            }
        }

        return null;
    }
}
