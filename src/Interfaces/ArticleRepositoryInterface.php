<?php
namespace App\Interfaces;

use App\Models\Article;

interface ArticleRepositoryInterface {
    public function findBySlug(string $slug): ?Article;
    public function findById(int $id): ?Article;
    public function getAllPublished(int $limit = 10): array;
    public function getByDestination(int $destinationId): array;
    public function incrementViews(int $id): void;
    public function save(Article $article): Article;
    public function delete(int $id): bool;
    public function countPublished(): int;
    public function countAll(): int;
    public function getPaginated(int $page = 1, int $limit = 10, string $search = '', string $status = ''): array;
    public function getStats(): array;
}