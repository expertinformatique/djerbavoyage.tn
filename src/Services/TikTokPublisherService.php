<?php
namespace App\Services;

class TikTokPublisherService {
    private const AUTH_URL = 'https://www.tiktok.com/v2/auth/authorize/';
    private const API_BASE = 'https://open.tiktokapis.com/v2';

    public function __construct(
        private ?SettingsService $settings = null
    ) {}

    public function getAuthorizationUrl(string $state = 'djerba_tiktok'): string {
        $clientKey   = $this->getConfig('tiktok_client_key', $_ENV['TIKTOK_CLIENT_KEY'] ?? '');
        $redirectUri = $this->getConfig('tiktok_redirect_uri', $_ENV['TIKTOK_REDIRECT_URI'] ?? 'https://djerbavoyage.tn/admin/tiktok/callback');
        $scopes      = 'user.info.basic,video.publish,video.upload';

        $params = [
            'client_key'    => $clientKey,
            'scope'         => $scopes,
            'response_type' => 'code',
            'redirect_uri'  => $redirectUri,
            'state'         => $state,
        ];

        return self::AUTH_URL . '?' . http_build_query($params);
    }

    public function exchangeCodeForToken(string $code): ?array {
        $clientKey    = $this->getConfig('tiktok_client_key', $_ENV['TIKTOK_CLIENT_KEY'] ?? '');
        $clientSecret = $this->getConfig('tiktok_client_secret', $_ENV['TIKTOK_CLIENT_SECRET'] ?? '');
        $redirectUri  = $this->getConfig('tiktok_redirect_uri', $_ENV['TIKTOK_REDIRECT_URI'] ?? 'https://djerbavoyage.tn/admin/tiktok/callback');

        $body = [
            'client_key'    => $clientKey,
            'client_secret' => $clientSecret,
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => $redirectUri,
        ];

        $res = $this->postForm(self::API_BASE . '/oauth/token/', $body);
        if (!empty($res['data']['access_token'])) {
            $this->saveTokenData($res['data']);
            return $res['data'];
        }

        $this->log("Échec échange code TikTok : " . json_encode($res));
        return null;
    }

    public function refreshAccessToken(string $refreshToken): ?array {
        $clientKey    = $this->getConfig('tiktok_client_key', $_ENV['TIKTOK_CLIENT_KEY'] ?? '');
        $clientSecret = $this->getConfig('tiktok_client_secret', $_ENV['TIKTOK_CLIENT_SECRET'] ?? '');

        $body = [
            'client_key'    => $clientKey,
            'client_secret' => $clientSecret,
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refreshToken,
        ];

        $res = $this->postForm(self::API_BASE . '/oauth/token/', $body);
        if (!empty($res['data']['access_token'])) {
            $this->saveTokenData($res['data']);
            return $res['data'];
        }

        $this->log("Échec rafraîchissement token TikTok : " . json_encode($res));
        return null;
    }

    public function publishVideo(string $videoPath, string $caption): array {
        if (!$this->isEnabled()) {
            return ['published' => false, 'reason' => 'Publication TikTok désactivée'];
        }

        if (!file_exists($videoPath) || filesize($videoPath) < 1000) {
            return ['published' => false, 'reason' => 'Fichier vidéo introuvable'];
        }

        $token = $this->getValidAccessToken();
        if (empty($token)) {
            return ['published' => false, 'reason' => 'Jeton TikTok manquant. Veuillez connecter votre compte.'];
        }

        $fileSize = filesize($videoPath);

        // 1. Initialiser la publication
        $initData = $this->initUploadSession($token, $fileSize, $caption, false);
        $isInbox = false;

        if (empty($initData['data']['upload_url'])) {
            // Tentative en mode Brouillon / Inbox si l'app est en développement
            $initData = $this->initUploadSession($token, $fileSize, $caption, true);
            $isInbox = true;
        }

        if (empty($initData['data']['upload_url'])) {
            $errMsg = $initData['error']['message'] ?? 'Échec initialisation upload TikTok';
            $this->log("Erreur init TikTok : " . $errMsg);
            return ['published' => false, 'error' => $errMsg];
        }

        $uploadUrl = $initData['data']['upload_url'];
        $publishId = $initData['data']['publish_id'] ?? '';

        // 2. Téléverser le binaire vidéo
        $uploaded = $this->uploadBinaryFile($uploadUrl, $videoPath, $fileSize);
        if (!$uploaded) {
            return ['published' => false, 'reason' => 'Échec transmission binaire vers TikTok'];
        }

        return [
            'published'  => true,
            'platform'   => 'tiktok',
            'publish_id' => $publishId,
            'type'       => $isInbox ? 'inbox_draft' : 'direct_post',
            'message'    => $isInbox ? 'Vidéo prête dans la boîte de réception TikTok' : 'Vidéo publiée sur TikTok'
        ];
    }

    public function buildCaption(string $title): string {
        $cleanTitle = trim(preg_replace('/\s+/', ' ', $title));
        if (mb_strlen($cleanTitle) > 100) {
            $cleanTitle = mb_substr($cleanTitle, 0, 97) . '...';
        }
        return "🌴 {$cleanTitle} ✨ #djerba #tunisie #voyage #djerbatunisie #bonplan #traveltok #excursion";
    }

    public function isEnabled(): bool {
        $setting = $this->getConfig('tiktok_auto_publish', $_ENV['TIKTOK_AUTO_PUBLISH'] ?? 'true');
        return filter_var($setting, FILTER_VALIDATE_BOOLEAN);
    }

    public function getValidAccessToken(): ?string {
        $token = $this->getConfig('tiktok_access_token', $_ENV['TIKTOK_ACCESS_TOKEN'] ?? null);
        if (!empty($token)) return $token;

        $refreshToken = $this->getConfig('tiktok_refresh_token', $_ENV['TIKTOK_REFRESH_TOKEN'] ?? null);
        if (!empty($refreshToken)) {
            $data = $this->refreshAccessToken($refreshToken);
            return $data['access_token'] ?? null;
        }

        return null;
    }

    private function initUploadSession(string $token, int $fileSize, string $caption, bool $inbox = false): array {
        $endpoint = self::API_BASE . ($inbox ? '/post/publish/inbox/video/init/' : '/post/publish/video/init/');
        
        $payload = [
            'post_info' => [
                'title'                    => $caption,
                'privacy_level'            => 'PUBLIC_TO_EVERYONE',
                'disable_duet'             => false,
                'disable_comment'          => false,
                'disable_stitch'           => false,
                'video_cover_timestamp_ms' => 1000
            ],
            'source_info' => [
                'source'            => 'FILE_UPLOAD',
                'video_size'        => $fileSize,
                'chunk_size'        => $fileSize,
                'total_chunk_count' => 1
            ]
        ];

        return $this->postJson($endpoint, $payload, $token);
    }

    private function uploadBinaryFile(string $uploadUrl, string $filePath, int $fileSize): bool {
        $fp = fopen($filePath, 'rb');
        if (!$fp) return false;

        $endByte = $fileSize - 1;
        $ch = curl_init($uploadUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_INFILE, $fp);
        curl_setopt($ch, CURLOPT_INFILESIZE, $fileSize);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: video/mp4",
            "Content-Range: bytes 0-{$endByte}/{$fileSize}"
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $res = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        fclose($fp);
        curl_close($ch);

        return ($code >= 200 && $code < 300);
    }

    private function postForm(string $url, array $params): array {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res ?: '', true) ?: [];
    }

    private function postJson(string $url, array $data, string $token): array {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$token}",
            "Content-Type: application/json; charset=UTF-8"
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res ?: '', true) ?: [];
    }

    private function saveTokenData(array $data): void {
        if ($this->settings !== null) {
            if (!empty($data['access_token'])) {
                $this->settings->set('tiktok_access_token', $data['access_token'], 'social');
            }
            if (!empty($data['refresh_token'])) {
                $this->settings->set('tiktok_refresh_token', $data['refresh_token'], 'social');
            }
            if (!empty($data['open_id'])) {
                $this->settings->set('tiktok_open_id', $data['open_id'], 'social');
            }
        }
    }

    private function getConfig(string $key, mixed $default = null): mixed {
        if ($this->settings !== null) {
            $val = $this->settings->get($key);
            if ($val !== null && $val !== '') return $val;
        }
        return $default;
    }

    private function log(string $message): void {
        $logPath = defined('ROOT_PATH') ? ROOT_PATH . '/error.log' : __DIR__ . '/../../error.log';
        @file_put_contents($logPath, "[" . date('Y-m-d H:i:s') . "] [TikTokPublisher] {$message}\n", FILE_APPEND);
    }
}
