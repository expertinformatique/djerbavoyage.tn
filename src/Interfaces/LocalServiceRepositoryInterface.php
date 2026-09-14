<?php
namespace App\Interfaces;

use App\Models\LocalService;

interface LocalServiceRepositoryInterface {
    public function findById(int $id): ?LocalService;
    public function findBySlug(string $slug): ?LocalService;
    public function findByIds(array $ids): array;
    public function getAllActive(): array;
    public function getByCategory(string $category): array;
}
