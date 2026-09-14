<?php
namespace App\Repositories;

use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Article;
use PDO;

class PdoArticleRepository implements ArticleRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    public function findBySlug(string $slug): ?Article {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE slug = :slug AND status = 'published'");
        $stmt->execute(['slug' => $slug]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? Article::fromArray($data) : null;
    }

    public function getAllPublished(int $limit = 10): array {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE status = 'published' ORDER BY published_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => Article::fromArray($row), $rows);
    }

    public function getByDestination(int $destinationId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE destination_id = :dest_id AND status = 'published'");
        $stmt->execute(['dest_id' => $destinationId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => Article::fromArray($row), $rows);
    }

    public function incrementViews(int $id): void {
        $stmt = $this->pdo->prepare("UPDATE articles SET views_count = views_count + 1 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}