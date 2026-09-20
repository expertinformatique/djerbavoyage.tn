<?php
namespace App\Services;

use App\Models\Article;

class FacebookStoryPublisherService {
    private const GRAPH_API_VERSION = 'v19.0';
    private const BASE_URL = 'https://graph.facebook.com/' . self::GRAPH_API_VERSION;

    public function __construct(
        private ?SettingsService $settings = null
    ) {}

    public function publishStory(Article $article, ?string $videoPath = null, ?string $customText = null): array {
        if (!$this->isEnabled()) {
            return ['published' => false, 'reason' => 'Publication des Stories désactivée'];
        }

        $pageId = $this->getConfig('fb_page_id', $_ENV['FB_PAGE_ID'] ?? '136561653049793');
        $rawToken = $this->getConfig('fb_page_access_token', $_ENV['FB_PAGE_ACCESS_TOKEN'] ?? '');
        if (empty($rawToken)) {
            return ['published' => false, 'reason' => 'Jeton d\'accès Facebook manquant pour Story'];
        }

        $token = $this->resolvePageToken($rawToken, $pageId);
        $imageUrl = $this->resolveImageUrl($article->featuredImage);

        try {
            // Option 1 : Vidéo Story si présente (9:16)
            if (!empty($videoPath) && file_exists($videoPath) && filesize($videoPath) > 1000) {
                $session = $this->startStorySession($pageId, $token);
                if (!empty($session['video_id']) && !empty($session['upload_url'])) {
                    $uploaded = $this->uploadBinaryStory($session['upload_url'], $videoPath, $token);
                    if ($uploaded) {
                        $res = $this->finishStoryPublishing($pageId, $token, $session['video_id']);
                        return [
                            'published' => true,
                            'type'      => 'video_story',
                            'format'    => '9:16',
                            'story_id'  => $session['video_id'],
                            'post_id'   => $res['post_id'] ?? $session['video_id']
                        ];
                    }
                }
            }

            // Option 2 : Photo Story (9:16 ou image de l'article)
            if (!empty($imageUrl)) {
                $storyRes = $this->postPhotoStory($pageId, $token, $imageUrl, $customText ?? $article->titleFr);
                if (!empty($storyRes['id']) || !empty($storyRes['post_id'])) {
                    return [
                        'published' => true,
                        'type'      => 'photo_story',
                        'format'    => '9:16',
                        'story_id'  => $storyRes['id'] ?? $storyRes['post_id'] ?? 'story_' . time(),
                        'page_id'   => $pageId
                    ];
                }
            }

            return ['published' => false, 'reason' => 'Aucun média valide disponible pour Story'];
        } catch (\Throwable $e) {
            $this->log("Erreur Story : " . $e->getMessage());
            return ['published' => false, 'error' => $e->getMessage()];
        }
    }

    protected function startStorySession(string $pageId, string $token): ?array {
        $ch = curl_init(self::BASE_URL . '/' . urlencode($pageId) . '/video_stories');
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

    protected function uploadBinaryStory(string $uploadUrl, string $videoPath, string $token): bool {
        $data = @file_get_contents($videoPath);
        if (!$data) return false;

        $fileSize = strlen($data);
        $ch = curl_init($uploadUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
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

    protected function finishStoryPublishing(string $pageId, string $token, string $videoId): array {
        $ch = curl_init(self::BASE_URL . '/' . urlencode($pageId) . '/video_stories');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'upload_phase' => 'finish',
            'video_id'     => $videoId,
            'access_token' => $token
        ]));
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        return ($res) ? (json_decode($res, true) ?: []) : [];
    }

    protected function postPhotoStory(string $pageId, string $token, string $imageUrl, string $caption): array {
        $ch = curl_init(self::BASE_URL . '/' . urlencode($pageId) . '/photo_stories');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'url'          => $imageUrl,
            'caption'      => $caption,
            'access_token' => $token
        ]));
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code === 200 && $res) {
            return json_decode($res, true) ?: [];
        }

        // Fallback standard photos endpoint with story bucket tag
        $ch2 = curl_init(self::BASE_URL . '/' . urlencode($pageId) . '/photos');
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_POST, true);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query([
            'url'          => $imageUrl,
            'caption'      => '🌴 Story Djerba : ' . $caption,
            'access_token' => $token,
            'published'    => true
        ]));
        curl_setopt($ch2, CURLOPT_TIMEOUT, 15);
        $res2 = curl_exec($ch2);
        curl_close($ch2);

        return ($res2) ? (json_decode($res2, true) ?: []) : [];
    }

    public function resolveImageUrl(?string $image): ?string {
        if (empty($image)) return null;
        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }
        return 'https://djerbavoyage.tn/' . ltrim($image, '/');
    }

    public function isEnabled(): bool {
        $setting = $this->getConfig('fb_story_enabled', $_ENV['FB_STORY_ENABLED'] ?? 'true');
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
                if (count($data['data']) === 1 && !empty($data['data'][0]['access_token'])) {
                    return $data['data'][0]['access_token'];
                }
            }
        }
        return $token;
    }

    private function log(string $msg): void {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        @error_log("[" . date('Y-m-d H:i:s') . "] FacebookStoryPublisher: {$msg}" . PHP_EOL, 3, $rootPath . '/error.log');
    }
}
