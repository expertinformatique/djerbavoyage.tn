<?php
namespace App\Repositories;

use App\Interfaces\ChatConversationRepositoryInterface;
use App\Models\ChatConversation;
use PDO;

/**
 * Implémentation SQL / PDO du Repository de conversations
 * 100% compatible SQLite (tests) et MySQL (production)
 */
class PdoChatConversationRepository implements ChatConversationRepositoryInterface
{
    public function __construct(private PDO $pdo) {}

    public function save(ChatConversation $conversation): bool
    {
        $existing = $this->findById($conversation->getId());

        if ($existing) {
            $sql = "UPDATE chat_conversations SET 
                client_name = :client_name,
                client_email = :client_email,
                client_phone = :client_phone,
                client_company = :client_company,
                detected_need = :detected_need,
                summary = :summary,
                messages_json = :messages_json,
                status = :status
                WHERE id = :id";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':client_name' => $conversation->getClientName(),
                ':client_email' => $conversation->getClientEmail(),
                ':client_phone' => $conversation->getClientPhone(),
                ':client_company' => $conversation->getClientCompany(),
                ':detected_need' => $conversation->getDetectedNeed(),
                ':summary' => $conversation->getSummary(),
                ':messages_json' => $conversation->getMessagesJson(),
                ':status' => $conversation->getStatus(),
                ':id' => $conversation->getId(),
            ]);
        }

        $sql = "INSERT INTO chat_conversations (
            id, session_id, client_name, client_email, client_phone, client_company,
            detected_need, summary, messages_json, ip_hash, status
        ) VALUES (
            :id, :session_id, :client_name, :client_email, :client_phone, :client_company,
            :detected_need, :summary, :messages_json, :ip_hash, :status
        )";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $conversation->getId(),
            ':session_id' => $conversation->getSessionId(),
            ':client_name' => $conversation->getClientName(),
            ':client_email' => $conversation->getClientEmail(),
            ':client_phone' => $conversation->getClientPhone(),
            ':client_company' => $conversation->getClientCompany(),
            ':detected_need' => $conversation->getDetectedNeed(),
            ':summary' => $conversation->getSummary(),
            ':messages_json' => $conversation->getMessagesJson(),
            ':ip_hash' => $conversation->getIpHash(),
            ':status' => $conversation->getStatus(),
        ]);
    }

    public function findById(string $id): ?ChatConversation
    {
        $stmt = $this->pdo->prepare("SELECT * FROM chat_conversations WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new ChatConversation($row) : null;
    }

    public function findBySessionId(string $sessionId): ?ChatConversation
    {
        $stmt = $this->pdo->prepare("SELECT * FROM chat_conversations WHERE session_id = :session_id ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([':session_id' => $sessionId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new ChatConversation($row) : null;
    }

    public function deleteBySessionId(string $sessionId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM chat_conversations WHERE session_id = :session_id");
        return $stmt->execute([':session_id' => $sessionId]);
    }

    public function getPaginated(int $page = 1, int $perPage = 20, ?string $status = null): array
    {
        $offset = max(0, ($page - 1) * $perPage);
        $where = $status ? "WHERE status = :status" : "";
        $countSql = "SELECT COUNT(*) FROM chat_conversations {$where}";
        $stmt = $this->pdo->prepare($countSql);
        if ($status) $stmt->bindValue(':status', $status);
        $stmt->execute();
        $total = (int)$stmt->fetchColumn();

        $dataSql = "SELECT * FROM chat_conversations {$where} ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($dataSql);
        if ($status) $stmt->bindValue(':status', $status);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new ChatConversation($row);
        }

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => (int)ceil($total / max(1, $perPage))
        ];
    }
}
