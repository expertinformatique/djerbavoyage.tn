<?php
namespace App\Services;

use App\Models\Article;

class FacebookPublisherService {
    private const GRAPH_API_VERSION = 'v19.0';
    private const BASE_URL = 'https://graph.facebook.com/' . self::GRAPH_API_VERSION;

    public function __construct(
        private ?SettingsService $settings = null
    ) {}

    public function publishArticle(Article $article, ?string $customCaption = null, string $mode = 'AVEC_LIEN'): array {
        if (!$this->isEnabled()) {
            return ['published' => false, 'reason' => 'Publication Facebook désactivée'];
        }

        $pageId = $this->getConfig('fb_page_id', $_ENV['FB_PAGE_ID'] ?? '136561653049793');
        $rawToken = $this->getConfig('fb_page_access_token', $_ENV['FB_PAGE_ACCESS_TOKEN'] ?? '');

        if (empty($rawToken)) {
            $this->log("Jeton d'accès (FB_PAGE_ACCESS_TOKEN) manquant. Publication ignorée.");
            return ['published' => false, 'reason' => 'Jeton d\'accès Facebook manquant'];
        }

        $token = $this->resolvePageAccessToken($rawToken, $pageId);
        $message = $this->buildMessage($article, $customCaption, $mode);
        $imageUrl = $this->resolveImageUrl($article->featuredImage);
        $feedLink = ($mode === 'AVEC_LIEN') ? ('https://djerbavoyage.tn/guide/' . $article->slug) : null;

        try {
            if (!empty($imageUrl)) {
                $photoRes = $this->postPhoto($pageId, $token, $imageUrl, $message);
                if (!empty($photoRes['id'])) {
                    return [
                        'published' => true,
                        'type'      => 'photo',
                        'mode'      => $mode,
                        'post_id'   => $photoRes['post_id'] ?? $photoRes['id'],
                        'page_id'   => $pageId
                    ];
                }
            }

            $feedRes = $this->postFeed($pageId, $token, $message, $feedLink);
            if (!empty($feedRes['id'])) {
                return [
                    'published' => true,
                    'type'      => 'feed',
                    'mode'      => $mode,
                    'post_id'   => $feedRes['id'],
                    'page_id'   => $pageId
                ];
            }

            return ['published' => false, 'error' => $feedRes['error']['message'] ?? 'Erreur API'];
        } catch (\Throwable $e) {
            $this->log("Erreur Facebook : " . $e->getMessage());
            return ['published' => false, 'error' => $e->getMessage()];
        }
    }

    public function buildMessage(Article $article, ?string $customCaption = null, string $mode = 'AVEC_LIEN'): string {
        if (!empty($customCaption)) {
            $cleaned = trim($customCaption);
            if ($mode === 'AVEC_LIEN') {
                $articleUrl = 'https://djerbavoyage.tn/guide/' . $article->slug;
                if (!str_contains($cleaned, $articleUrl)) {
                    $cleaned .= "\n\n🔗 Lire l'article complet : " . $articleUrl;
                }
            }
            if (!str_contains($cleaned, '#Djerba')) {
                $cleaned .= "\n\n#Djerba #PhotoDjerba #Tunisie";
            }
            return $cleaned;
        }

        $parts = ["🌴 " . $article->titleFr . " 🌴", ""];
        if (!empty($article->summaryAi)) {
            $summary = trim(strip_tags($article->summaryAi));
            $parts[] = implode("\n", array_slice(array_filter(explode("\n", $summary)), 0, 3));
            $parts[] = "";
        }

        if ($mode === 'AVEC_LIEN') {
            $parts[] = "📖 Découvrez le guide complet :";
            $parts[] = "👉 https://djerbavoyage.tn/guide/" . $article->slug;
        } else {
            $parts[] = "💬 Et vous, quel est votre coin secret préféré à Djerba ? Racontez-nous en commentaire ! 👇";
        }

        $parts[] = "";
        $parts[] = "#Djerba #Tunisie #DjerbaVoyage #TourismeTunisie #PhotoDjerba #VoyageDjerba";
        return implode("\n", $parts);
    }

    private function postPhoto(string $pageId, string $token, string $imageUrl, string $caption): array {
        return $this->callApi(self::BASE_URL . '/' . urlencode($pageId) . '/photos', [
            'url'          => $imageUrl,
            'caption'      => $caption,
            'access_token' => $token
        ]);
    }

    private function postFeed(string $pageId, string $token, string $message, ?string $link = null): array {
        $params = ['message' => $message, 'access_token' => $token];
        if (!empty($link)) {
            $params['link'] = $link;
        }
        return $this->callApi(self::BASE_URL . '/' . urlencode($pageId) . '/feed', $params);
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
            $this->log("Graph API HTTP {$httpCode}: " . ($data['error']['message'] ?? 'Erreur inconnue'));
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
            if ($val !== null && $val !== '') return $val;
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
