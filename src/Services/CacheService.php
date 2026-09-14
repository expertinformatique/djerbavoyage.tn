<?php
namespace App\Services;

use App\Interfaces\CacheInterface;

class CacheService implements CacheInterface {
    private string $cacheDir;

    public function __construct(string $cacheDir = __DIR__ . '/../../storage/cache') {
        $this->cacheDir = rtrim($cacheDir, '/');
        if (!is_dir($this->cacheDir)) {
            @mkdir($this->cacheDir, 0777, true);
        }
    }

    public function get(string $key): mixed {
        $file = $this->getFilePath($key);
        if (!file_exists($file)) return null;

        $content = file_get_contents($file);
        $data = @unserialize($content);

        if (!$data || time() > $data['expires_at']) {
            @unlink($file);
            return null;
        }

        return $data['payload'];
    }

    public function set(string $key, mixed $data, int $ttlSeconds = 3600): bool {
        $file = $this->getFilePath($key);
        $payload = [
            'expires_at' => time() + $ttlSeconds,
            'payload'    => $data
        ];
        return file_put_contents($file, serialize($payload), LOCK_EX) !== false;
    }

    public function delete(string $key): bool {
        $file = $this->getFilePath($key);
        return file_exists($file) ? @unlink($file) : true;
    }

    public function clear(): bool {
        $files = glob($this->cacheDir . '/*.cache');
        if ($files) {
            foreach ($files as $file) @unlink($file);
        }
        return true;
    }

    private function getFilePath(string $key): string {
        return $this->cacheDir . '/' . md5($key) . '.cache';
    }
}