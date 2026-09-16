<?php
namespace App\Repositories;

use App\Interfaces\AiLeadRepositoryInterface;
use App\Models\AiLead;
use PDO;
use Throwable;

class PdoAiLeadRepository implements AiLeadRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    private function logError(Throwable $e): void {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
    }

    public function create(AiLead $lead): ?int {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO ai_leads (name, email, phone, travel_date, notes, preferences_json, ip_address, status)
                VALUES (:name, :email, :phone, :travel_date, :notes, :preferences_json, :ip_address, :status)
            ");
            $data = $lead->toArray();
            $stmt->execute([
                'name'             => $data['name'],
                'email'            => $data['email'],
                'phone'            => $data['phone'],
                'travel_date'      => $data['travel_date'],
                'notes'            => $data['notes'],
                'preferences_json' => $data['preferences_json'],
                'ip_address'       => $data['ip_address'],
                'status'           => $data['status'] ?? 'new'
            ]);
            return (int)$this->pdo->lastInsertId();
        } catch (Throwable $e) {
            $this->logError($e);
            return null;
        }
    }

    public function findById(int $id): ?AiLead {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM ai_leads WHERE id = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? AiLead::fromArray($row) : null;
        } catch (Throwable $e) {
            $this->logError($e);
            return null;
        }
    }

    public function countAll(): int {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM ai_leads");
            return (int)$stmt->fetchColumn();
        } catch (Throwable $e) {
            $this->logError($e);
            return 0;
        }
    }

    public function getAll(int $limit = 50, int $offset = 0): array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM ai_leads ORDER BY id DESC LIMIT :limit OFFSET :offset");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_map(fn($r) => AiLead::fromArray($r), $rows ?: []);
        } catch (Throwable $e) {
            $this->logError($e);
            return [];
        }
    }
}
