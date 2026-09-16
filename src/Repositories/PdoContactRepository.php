<?php
namespace App\Repositories;

use App\Interfaces\ContactRepositoryInterface;
use App\Models\ContactMessage;
use PDO;
use Throwable;

class PdoContactRepository implements ContactRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    private function logError(Throwable $e): void {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
    }

    public function create(ContactMessage $msg): ?int {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO contact_messages (name, email, phone, subject, message, ip_address, status)
                VALUES (:name, :email, :phone, :subject, :message, :ip_address, :status)
            ");
            $stmt->execute([
                'name'       => $msg->name,
                'email'      => $msg->email,
                'phone'      => $msg->phone,
                'subject'    => $msg->subject,
                'message'    => $msg->message,
                'ip_address' => $msg->ipAddress,
                'status'     => $msg->status
            ]);
            return (int)$this->pdo->lastInsertId();
        } catch (Throwable $e) {
            $this->logError($e);
            return null;
        }
    }

    public function findById(int $id): ?ContactMessage {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM contact_messages WHERE id = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? ContactMessage::fromArray($row) : null;
        } catch (Throwable $e) {
            $this->logError($e);
            return null;
        }
    }

    public function countAll(): int {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM contact_messages");
            return (int)$stmt->fetchColumn();
        } catch (Throwable $e) {
            $this->logError($e);
            return 0;
        }
    }

    public function getAll(int $limit = 50, int $offset = 0): array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM contact_messages ORDER BY id DESC LIMIT :limit OFFSET :offset");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_map(fn($r) => ContactMessage::fromArray($r), $rows ?: []);
        } catch (Throwable $e) {
            $this->logError($e);
            return [];
        }
    }
}
