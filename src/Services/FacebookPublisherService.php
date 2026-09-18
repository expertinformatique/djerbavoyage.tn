<?php
namespace App\Services;

use App\Models\Article;

class FacebookPublisherService {
    private const GRAPH_API_VERSION = 'v19.0';
    private const BASE_URL = 'https://graph.facebook.com/' . self::GRAPH_API_VERSION;

    public function __construct(
        private ?SettingsService $settings = null
    ) {}

    public function publishArticle(Article $article): array {
        if (!$this->isEnabled()) {
            return ['published' => false, 'reason' => 'Publication Facebook désactivée'];
        }

        $pageId = $this->getConfig('fb_page_id', $_ENV['FB_PAGE_ID'] ?? '136561653049793');
        $rawToken = $this->getConfig('fb_page_access_token', $_ENV['FB_PAGE_ACCESS_TOKEN'] ?? '');

        if (empty($rawToken)) {
            $this->log("Jeton d'accès (FB_PAGE_ACCESS_TOKEN) non renseigné. Publication ignorée.");
            return ['published' => false, 'reason' => 'Jeton d\'accès Facebook manquant'];
        }

        $token = $this->resolvePageAccessToken($rawToken, $pageId);
        $message = $this->buildMessage($article);
        $articleUrl = 'https://djerbavoyage.tn/guide/' . $article->slug;
        $imageUrl = $this->resolveImageUrl($article->featuredImage);

        try {
            $lastError = null;

            // 1. Essai de publication sous forme de photo HD avec légende
            if (!empty($imageUrl)) {
                $photoRes = $this->postPhoto($pageId, $token, $imageUrl, $message);
                if (!empty($photoRes['id'])) {
                    return [
                        'published' => true,
                        'type'      => 'photo',
                        'post_id'   => $photoRes['post_id'] ?? $photoRes['id'],
                        'page_id'   => $pageId
                    ];
                }
                $lastError = $photoRes['error']['message'] ?? null;
            }

            // 2. Fallback publication sous forme de lien sur le fil d'actualité
            $feedRes = $this->postFeed($pageId, $token, $message, $articleUrl);
            if (!empty($feedRes['id'])) {
                return [
                    'published' => true,
                    'type'      => 'feed',
                    'post_id'   => $feedRes['id'],
                    'page_id'   => $pageId
                ];
            }
            $lastError = $lastError ?? ($feedRes['error']['message'] ?? 'Réponse API Facebook inattendue');

            return ['published' => false, 'error' => $lastError];
        } catch (\Throwable $e) {
            $this->log("Erreur lors de la publication Facebook : " . $e->getMessage());
            return ['published' => false, 'error' => $e->getMessage()];
        }
    }

    public function buildMessage(Article $article): string {
        $parts = [];
        $parts[] = "🌴 " . $article->titleFr . " 🌴";
        $parts[] = "";

        // Extrait évocateur ou résumé IA
        if (!empty($article->summaryAi)) {
            $summary = trim(strip_tags($article->summaryAi));
            $summaryLines = array_filter(explode("\n", $summary));
            $parts[] = implode("\n", array_slice($summaryLines, 0, 3));
            $parts[] = "";
        } elseif (!empty($article->seoDescription)) {
            $parts[] = trim(strip_tags($article->seoDescription));
            $parts[] = "";
        }

        $parts[] = "📖 Découvrez l'histoire et le guide complet :";
        $parts[] = "👉 https://djerbavoyage.tn/guide/" . $article->slug;
        $parts[] = "";
        $parts[] = "#Djerba #Tunisie #DjerbaVoyage #TourismeTunisie #PhotoDjerba #VoyageDjerba #ExploreDjerba";

        return implode("\n", $parts);
    }

    private function postPhoto(string $pageId, string $token, string $imageUrl, string $caption): array {
        $endpoint = self::BASE_URL . '/' . urlencode($pageId) . '/photos';
        $params = [
            'url'          => $imageUrl,
            'caption'      => $caption,
            'access_token' => $token
        ];
        return $this->callApi($endpoint, $params);
    }

    private function postFeed(string $pageId, string $token, string $message, string $link): array {
        $endpoint = self::BASE_URL . '/' . urlencode($pageId) . '/feed';
        $params = [
            'message'      => $message,
            'link'         => $link,
            'access_token' => $token
        ];
        return $this->callApi($endpoint, $params);
    }

    protected function callApi(string $url, array $params): array {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            throw new \RuntimeException("cURL error: " . $curlError);
        }

        $data = json_decode($response ?: '', true) ?: [];
        if ($httpCode >= 400) {
            $errMsg = $data['error']['message'] ?? ("HTTP error " . $httpCode);
            $this->log("Graph API HTTP {$httpCode}: " . $errMsg);
        }
        return $data;
    }

    public function resolveImageUrl(?string $image): ?string {
        if (empty($image)) return null;
        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }
        return 'https://djerbavoyage.tn/' . ltrim($image, '/');
    }

    public function isEnabled(): bool {
        $setting = $this->getConfig('fb_auto_publish', $_ENV['FB_AUTO_PUBLISH'] ?? 'true');
        return filter_var($setting, FILTER_VALIDATE_BOOLEAN);
    }

    private function getConfig(string $key, mixed $default = null): mixed {
        if ($this->settings !== null) {
            $val = $this->settings->get($key);
            if ($val !== null && $val !== '') {
                return $val;
            }
        }
        return $default;
    }

    public function resolvePageAccessToken(string $token, string $pageId): string {
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
        @error_log("[" . date('Y-m-d H:i:s') . "] FacebookPublisher: {$msg}" . PHP_EOL, 3, $rootPath . '/error.log');
    }
}
