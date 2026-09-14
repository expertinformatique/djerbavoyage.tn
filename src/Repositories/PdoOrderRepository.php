<?php
namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use PDO;

class PdoOrderRepository implements OrderRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    public function findById(int $id): ?Order {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? Order::fromArray($data) : null;
    }

    public function findByStripeSessionId(string $sessionId): ?Order {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE stripe_session_id = :session_id");
        $stmt->execute(['session_id' => $sessionId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? Order::fromArray($data) : null;
    }

    public function create(Order $order): Order {
        $stmt = $this->pdo->prepare("
            INSERT INTO orders (order_number, customer_email, total_amount, currency, stripe_session_id, status, type)
            VALUES (:number, :email, :amount, :currency, :session_id, :status, :type)
        ");
        $stmt->execute([
            'number'     => $order->orderNumber,
            'email'      => $order->customerEmail,
            'amount'     => $order->totalAmount,
            'currency'   => $order->currency,
            'session_id' => $order->stripeSessionId,
            'status'     => $order->status,
            'type'       => $order->type,
        ]);
        $order->id = (int)$this->pdo->lastInsertId();
        return $order;
    }

    public function updateStatus(int $orderId, string $status): bool {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = :status WHERE id = :id");
        return $stmt->execute(['status' => $status, 'id' => $orderId]);
    }

    public function getPaidOrdersCount(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'paid'");
        return (int)$stmt->fetchColumn();
    }

    public function getPaginated(int $page = 1, int $limit = 10, string $search = ''): array {
        $offset = ($page - 1) * $limit;
        $searchQuery = "%{$search}%";

        $countStmt = $this->pdo->prepare("SELECT COUNT(*) FROM orders WHERE customer_email LIKE :search OR order_number LIKE :search");
        $countStmt->execute(['search' => $searchQuery]);
        $total = (int)$countStmt->fetchColumn();

        $stmt = $this->pdo->prepare("
            SELECT * FROM orders 
            WHERE customer_email LIKE :search OR order_number LIKE :search
            ORDER BY created_at DESC 
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':search', $searchQuery, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'total' => $total,
            'items' => array_map(fn($row) => Order::fromArray($row), $rows)
        ];
    }
}