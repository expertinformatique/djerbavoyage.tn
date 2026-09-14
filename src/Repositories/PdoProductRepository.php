<?php
namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use PDO;

class PdoProductRepository implements ProductRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    public function findById(int $id): ?Product {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? Product::fromArray($data) : null;
        } catch (\Throwable $e) {
            $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
            return null;
        }
    }

    public function findBySlug(string $slug): ?Product {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM products WHERE slug = :slug AND is_active = 1");
            $stmt->execute(['slug' => $slug]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? Product::fromArray($data) : null;
        } catch (\Throwable $e) {
            $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
            return null;
        }
    }

    public function getAllActive(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM products WHERE is_active = 1 ORDER BY price_eur ASC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_map(fn($row) => Product::fromArray($row), $rows);
        } catch (\Throwable $e) {
            $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
            return [];
        }
    }
}