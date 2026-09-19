<?php
namespace App\Services;

class FacebookReelPublisherService {
    private const GRAPH_API_VERSION = 'v19.0';
    private const BASE_URL = 'https://graph.facebook.com/' . self::GRAPH_API_VERSION;

    public function __construct(
        private ?SettingsService $settings = null
    ) {}

    public function publishReel(string $videoPath, string $caption): array {
        if (!$this->isEnabled()) {
            return ['published' => false, 'reason' => 'Publication Facebook désactivée'];
        }

        if (!file_exists($videoPath) || filesize($videoPath) < 1000) {
            return ['published' => false, 'reason' => 'Fichier vidéo introuvable ou invalide'];
        }

        $pageId = $this->getConfig('fb_page_id', $_ENV['FB_PAGE_ID'] ?? '136561653049793');
        $rawToken = $this->getConfig('fb_page_access_token', $_ENV['FB_PAGE_ACCESS_TOKEN'] ?? '');
        if (empty($rawToken)) {
            return ['published' => false, 'reason' => 'Jeton d\'accès Facebook manquant'];
        }

        $token = $this->resolvePageToken($rawToken, $pageId);

        try {
            // Étape 1 : Initialiser la session
            $session = $this->startUploadSession($pageId, $token);
            if (empty($session['video_id']) || empty($session['upload_url'])) {
                return ['published' => false, 'reason' => 'Échec d\'initialisation du Reel sur Meta'];
            }

            // Étape 2 : Uploader le binaire vidéo
            $uploaded = $this->uploadBinaryVideo($session['upload_url'], $videoPath, $token);
            if (!$uploaded) {
                return ['published' => false, 'reason' => 'Échec de transmission binaire du Reel'];
            }

            // Étape 3 : Finaliser et publier le Reel
            $res = $this->finishPublishing($pageId, $token, $session['video_id'], $caption);
            return [
                'published' => true,
                'type'      => 'reel',
                'video_id'  => $session['video_id'],
                'post_id'   => $res['post_id'] ?? $session['video_id']
            ];
        } catch (\Throwable $e) {
            $this->log("Erreur Reel : " . $e->getMessage());
            return ['published' => false, 'error' => $e->getMessage()];
        }
    }

    protected function startUploadSession(string $pageId, string $token): ?array {
        $ch = curl_init(self::BASE_URL . '/' . urlencode($pageId) . '/video_reels');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'upload_phase' => 'start',
            'access_token' => $token
        ]));
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($code === 200 && $res) ? json_decode($res, true) : null;
    }

    protected function uploadBinaryVideo(string $uploadUrl, string $videoPath, string $token): bool {
        $videoData = @file_get_contents($videoPath);
        if (!$videoData) return false;

        $fileSize = strlen($videoData);
        $ch = curl_init($uploadUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $videoData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: OAuth {$token}",
            "offset: 0",
            "file_size: {$fileSize}",
            "Content-Type: application/octet-stream"
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 45);
        $res = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($code === 200);
    }

    protected function finishPublishing(string $pageId, string $token, string $videoId, string $caption): array {
        $ch = curl_init(self::BASE_URL . '/' . urlencode($pageId) . '/video_reels');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'upload_phase' => 'finish',
            'video_id'     => $videoId,
            'video_state'  => 'PUBLISHED',
            'description'  => $caption,
            'access_token' => $token
        ]));
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        return json_decode($res ?: '', true) ?: [];
    }

    public function isEnabled(): bool {
        $setting = $this->getConfig('fb_auto_publish', $_ENV['FB_AUTO_PUBLISH'] ?? 'true');
        return filter_var($setting, FILTER_VALIDATE_BOOLEAN);
    }

    private function getConfig(string $key, mixed $default = null): mixed {
        if ($this->settings !== null) {
            $val = $this->settings->get($key);
            if ($val !== null && $val !== '') return $val;
        }
        return $default;
    }

    private function resolvePageToken(string $token, string $pageId): string {
        $ch = curl_init(self::BASE_URL . '/me/accounts?access_token=' . urlencode($token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        $res = curl_exec($ch);
        curl_close($ch);

        if ($res) {
            $data = json_decode($res, true);
            if (!empty($data['data']) && is_array($data['data'])) {
                foreach ($data['data'] as $page) {
                    if (($page['id'] ?? '') === $pageId || strcasecmp($page['name'] ?? '', $pageId) === 0) {
                        return $page['access_token'] ?? $token;
                    }
                }
            }
        }
        return $token;
    }

    private function log(string $msg): void {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        @error_log("[" . date('Y-m-d H:i:s') . "] FacebookReelPublisher: {$msg}" . PHP_EOL, 3, $rootPath . '/error.log');
    }
}
