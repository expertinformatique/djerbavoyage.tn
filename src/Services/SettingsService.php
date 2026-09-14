<?php
namespace App\Services;

use App\Interfaces\SettingsRepositoryInterface;
use App\Interfaces\CacheInterface;

class SettingsService {
    private array $settings = [];

    public function __construct(
        private SettingsRepositoryInterface $repository,
        private CacheInterface $cache
    ) {
        $this->loadSettings();
    }

    private function loadSettings(): void {
        $cached = $this->cache->get('site_settings');
        if ($cached) {
            $this->settings = $cached;
            return;
        }

        $this->settings = $this->repository->getAllAsKeyValue();
        $this->cache->set('site_settings', $this->settings, 86400);
    }

    public function get(string $key, mixed $default = null): mixed {
        return $this->settings[$key] ?? $default;
    }

    public function set(string $key, mixed $value, string $group = 'general'): bool {
        $result = $this->repository->set($key, $value, $group);
        if ($result) {
            $this->settings[$key] = (string)$value;
            $this->cache->set('site_settings', $this->settings, 86400);
        }
        return $result;
    }
}