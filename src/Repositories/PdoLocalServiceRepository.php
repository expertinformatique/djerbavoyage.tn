<?php
namespace App\Repositories;

use App\Interfaces\LocalServiceRepositoryInterface;
use App\Models\LocalService;
use PDO;
use Throwable;

class PdoLocalServiceRepository implements LocalServiceRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    private function logError(Throwable $e): void {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
    }

    public function findById(int $id): ?LocalService {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM local_services WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? LocalService::fromArray($data) : null;
        } catch (Throwable $e) {
            $this->logError($e);
            return null;
        }
    }

    public function findBySlug(string $slug): ?LocalService {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM local_services WHERE slug = :slug AND is_active = 1");
            $stmt->execute(['slug' => $slug]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? LocalService::fromArray($data) : null;
        } catch (Throwable $e) {
            $this->logError($e);
            return null;
        }
    }

    public function findByIds(array $ids): array {
        if (empty($ids)) {
            return [];
        }
        try {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $this->pdo->prepare("SELECT * FROM local_services WHERE id IN ($placeholders) AND is_active = 1 ORDER BY sort_order ASC");
            $stmt->execute(array_values($ids));
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_map(fn($r) => LocalService::fromArray($r), $rows);
        } catch (Throwable $e) {
            $this->logError($e);
            return [];
        }
    }

    public function getAllActive(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM local_services WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_map(fn($r) => LocalService::fromArray($r), $rows);
        } catch (Throwable $e) {
            $this->logError($e);
            return [];
        }
    }

    public function getByCategory(string $category): array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM local_services WHERE category = :cat AND is_active = 1 ORDER BY sort_order ASC");
            $stmt->execute(['cat' => $category]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_map(fn($r) => LocalService::fromArray($r), $rows);
        } catch (Throwable $e) {
            $this->logError($e);
            return [];
        }
    }
}
