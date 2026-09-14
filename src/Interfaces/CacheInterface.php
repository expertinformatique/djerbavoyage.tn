<?php
namespace App\Interfaces;

interface CacheInterface {
    public function get(string $key): mixed;
    public function set(string $key, mixed $data, int $ttlSeconds = 3600): bool;
    public function delete(string $key): bool;
    public function clear(): bool;
}