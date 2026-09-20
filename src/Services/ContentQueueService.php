<?php
namespace App\Services;

class ContentQueueService {
    private string $filePath;

    public function __construct(?string $customPath = null) {
        if ($customPath !== null) {
            $this->filePath = $customPath;
        } else {
            $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            $this->filePath = $rootPath . '/storage/content_queue.json';
        }
        $dir = dirname($this->filePath);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        if (!file_exists($this->filePath)) {
            $this->saveQueue(['topics' => [], 'images' => []]);
        }
    }

    public function loadQueue(): array {
        if (!file_exists($this->filePath)) {
            return ['topics' => [], 'images' => []];
        }
        $content = @file_get_contents($this->filePath) ?: '{"topics":[],"images":[]}';
        $data = json_decode($content, true) ?: [];
        return [
            'topics' => $data['topics'] ?? [],
            'images' => $data['images'] ?? []
        ];
    }

    public static function getAvailableCategories(): array {
        return [
            'general'      => ['label' => 'Général & Multi-thèmes', 'icon' => '🌴'],
            'patrimoine'   => ['label' => 'Patrimoine, Histoire & UNESCO', 'icon' => '🏛️'],
            'plages'       => ['label' => 'Plages & Activités Nautiques', 'icon' => '🏄‍♂️'],
            'excursions'   => ['label' => 'Excursions, Désert & Quad', 'icon' => '🐪'],
            'gastronomie'  => ['label' => 'Gastronomie & Restaurants', 'icon' => '🍽️'],
            'hebergements' => ['label' => 'Hôtels, Menzels & Spas', 'icon' => '🏡'],
            'vie_pratique' => ['label' => 'Vie Pratique & Conseils', 'icon' => '🧭'],
        ];
    }

    public function saveQueue(array $data): bool {
        return (bool)file_put_contents(
            $this->filePath,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    public function addTopic(string $title, int $maxUses = 1, string $botId = 'all', string $keywords = '', string $guidelines = '', string $category = 'general'): array {
        $queue = $this->loadQueue();
        $id = 'top_' . substr(md5($title . uniqid()), 0, 8);
        $item = [
            'id' => $id,
            'bot_id' => $botId,
            'category' => !empty($category) ? trim($category) : 'general',
            'title' => trim($title),
            'keywords' => trim($keywords),
            'guidelines' => trim($guidelines),
            'max_uses' => max(1, $maxUses),
            'uses_count' => 0,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'last_used_at' => null
        ];
        $queue['topics'][] = $item;
        $this->saveQueue($queue);
        return $item;
    }

    public function addImage(string $imageUrl, string $title = '', int $maxUses = 1, string $botId = 'all', string $style = 'reference', string $category = 'general'): array {
        $queue = $this->loadQueue();
        $id = 'img_' . substr(md5($imageUrl . uniqid()), 0, 8);
        $item = [
            'id' => $id,
            'bot_id' => $botId,
            'category' => !empty($category) ? trim($category) : 'general',
            'image_url' => trim($imageUrl),
            'title' => trim($title ?: basename($imageUrl)),
            'style' => $style,
            'max_uses' => max(1, $maxUses),
            'uses_count' => 0,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'last_used_at' => null
        ];
        $queue['images'][] = $item;
        $this->saveQueue($queue);
        return $item;
    }

    public function batchAddTopics(array $topicLines, int $maxUses = 1, string $botId = 'all', string $category = 'general'): int {
        $count = 0;
        foreach ($topicLines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                $this->addTopic($line, $maxUses, $botId, '', '', $category);
                $count++;
            }
        }
        return $count;
    }

    public function batchAddImages(array $imageUrls, int $maxUses = 1, string $botId = 'all', string $style = 'reference', string $category = 'general'): int {
        $count = 0;
        foreach ($imageUrls as $url) {
            $url = trim($url);
            if (!empty($url)) {
                $this->addImage($url, basename($url), $maxUses, $botId, $style, $category);
                $count++;
            }
        }
        return $count;
    }

    public function getNextAvailableTopic(?string $botId = null, array|string|null $allowedCategories = null): ?array {
        $queue = $this->loadQueue();
        $cats = $this->normalizeCategories($allowedCategories);

        foreach ($queue['topics'] as $t) {
            if (($t['status'] ?? 'active') === 'active' && ($t['uses_count'] ?? 0) < ($t['max_uses'] ?? 1)) {
                $matchesBot = ($botId === null || ($t['bot_id'] ?? 'all') === 'all' || ($t['bot_id'] ?? '') === $botId);
                if (!$matchesBot) {
                    continue;
                }

                $itemCat = $t['category'] ?? 'general';
                $matchesCategory = ($cats === null || in_array('all', $cats, true) || in_array('*', $cats, true) || in_array($itemCat, $cats, true) || $itemCat === 'general');

                if ($matchesCategory) {
                    return $t;
                }
            }
        }
        return null;
    }

    public function getNextAvailableImage(?string $botId = null, array|string|null $allowedCategories = null): ?array {
        $queue = $this->loadQueue();
        $cats = $this->normalizeCategories($allowedCategories);

        foreach ($queue['images'] as $img) {
            if (($img['status'] ?? 'active') === 'active' && ($img['uses_count'] ?? 0) < ($img['max_uses'] ?? 1)) {
                $matchesBot = ($botId === null || ($img['bot_id'] ?? 'all') === 'all' || ($img['bot_id'] ?? '') === $botId);
                if (!$matchesBot) {
                    continue;
                }

                $itemCat = $img['category'] ?? 'general';
                $matchesCategory = ($cats === null || in_array('all', $cats, true) || in_array('*', $cats, true) || in_array($itemCat, $cats, true) || $itemCat === 'general');

                if ($matchesCategory) {
                    return $img;
                }
            }
        }
        return null;
    }

    private function normalizeCategories(array|string|null $categories): ?array {
        if ($categories === null) {
            return null;
        }
        if (is_string($categories)) {
            $categories = array_filter(array_map('trim', explode(',', $categories)));
        }
        return empty($categories) ? null : array_values($categories);
    }

    public function incrementTopicUsage(string $topicId): bool {
        $queue = $this->loadQueue();
        foreach ($queue['topics'] as &$t) {
            if ($t['id'] === $topicId) {
                $t['uses_count']++;
                $t['last_used_at'] = date('Y-m-d H:i:s');
                if ($t['uses_count'] >= $t['max_uses']) {
                    $t['status'] = 'exhausted';
                }
                $this->saveQueue($queue);
                return true;
            }
        }
        return false;
    }

    public function incrementImageUsage(string $imageId): bool {
        $queue = $this->loadQueue();
        foreach ($queue['images'] as &$img) {
            if ($img['id'] === $imageId) {
                $img['uses_count']++;
                $img['last_used_at'] = date('Y-m-d H:i:s');
                if ($img['uses_count'] >= $img['max_uses']) {
                    $img['status'] = 'exhausted';
                }
                $this->saveQueue($queue);
                return true;
            }
        }
        return false;
    }

    public function deleteItem(string $type, string $id): bool {
        $queue = $this->loadQueue();
        $key = ($type === 'image') ? 'images' : 'topics';
        $filtered = array_values(array_filter($queue[$key] ?? [], fn($i) => $i['id'] !== $id));
        $queue[$key] = $filtered;
        return $this->saveQueue($queue);
    }

    public function resetUsage(string $type, string $id): bool {
        $queue = $this->loadQueue();
        $key = ($type === 'image') ? 'images' : 'topics';
        foreach ($queue[$key] as &$item) {
            if ($item['id'] === $id) {
                $item['uses_count'] = 0;
                $item['status'] = 'active';
                $this->saveQueue($queue);
                return true;
            }
        }
        return false;
    }

    public function getStats(): array {
        $q = $this->loadQueue();
        $topics = $q['topics'];
        $images = $q['images'];
        return [
            'total_topics' => count($topics),
            'active_topics' => count(array_filter($topics, fn($t) => $t['status'] === 'active')),
            'exhausted_topics' => count(array_filter($topics, fn($t) => $t['status'] === 'exhausted')),
            'total_images' => count($images),
            'active_images' => count(array_filter($images, fn($i) => $i['status'] === 'active')),
            'exhausted_images' => count(array_filter($images, fn($i) => $i['status'] === 'exhausted')),
        ];
    }
}
