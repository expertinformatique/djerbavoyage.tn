<?php
namespace App\Interfaces;

use App\Models\Article;

interface ArticleRepositoryInterface {
    public function findBySlug(string $slug): ?Article;
    public function getAllPublished(int $limit = 10): array;
    public function getByDestination(int $destinationId): array;
    public function incrementViews(int $id): void;
}