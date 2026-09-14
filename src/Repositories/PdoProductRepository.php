<?php
namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use PDO;

class PdoProductRepository implements ProductRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    public function findById(int $id): ?Product {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? Product::fromArray($data) : null;
    }

    public function findBySlug(string $slug): ?Product {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE slug = :slug AND is_active = 1");
        $stmt->execute(['slug' => $slug]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? Product::fromArray($data) : null;
    }

    public function getAllActive(): array {
        $stmt = $this->pdo->query("SELECT * FROM products WHERE is_active = 1 ORDER BY price_eur ASC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => Product::fromArray($row), $rows);
    }
}