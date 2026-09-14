<?php
namespace App\Interfaces;

interface SettingsRepositoryInterface {
    public function getAllAsKeyValue(): array;
    public function set(string $key, mixed $value, string $group = 'general'): bool;
}