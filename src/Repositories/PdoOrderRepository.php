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

    public function findByOrderNumber(string $orderNumber): ?Order {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE order_number = :order_number");
        $stmt->execute(['order_number' => $orderNumber]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? Order::fromArray($data) : null;
    }

    public function create(Order $order): Order {
        try {
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
        } catch (\Throwable $e) {
            $driver = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
            if (strpos($e->getMessage(), "doesn't exist") !== false || strpos($e->getMessage(), "no such table") !== false) {
                if ($driver === 'sqlite') {
                    $this->pdo->exec("CREATE TABLE IF NOT EXISTS orders (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        order_number VARCHAR(50) NOT NULL UNIQUE,
                        customer_email VARCHAR(150) NOT NULL,
                        total_amount DECIMAL(10,2) NOT NULL,
                        currency VARCHAR(10) DEFAULT 'EUR',
                        stripe_session_id VARCHAR(255) NOT NULL UNIQUE,
                        status VARCHAR(20) NOT NULL DEFAULT 'pending',
                        type VARCHAR(50) NOT NULL DEFAULT 'digital_product',
                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                    )");
                } else {
                    $this->pdo->exec("CREATE TABLE IF NOT EXISTS orders (
                        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        order_number VARCHAR(50) NOT NULL UNIQUE,
                        customer_email VARCHAR(150) NOT NULL,
                        total_amount DECIMAL(10,2) NOT NULL,
                        currency VARCHAR(10) DEFAULT 'EUR',
                        stripe_session_id VARCHAR(255) NOT NULL UNIQUE,
                        status VARCHAR(20) NOT NULL DEFAULT 'pending',
                        type VARCHAR(50) NOT NULL DEFAULT 'digital_product',
                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
                }
            } elseif (strpos($e->getMessage(), 'Unknown column') !== false || strpos($e->getMessage(), 'no column') !== false) {
                try {
                    $this->pdo->exec("ALTER TABLE orders ADD COLUMN type VARCHAR(50) NOT NULL DEFAULT 'digital_product'");
                } catch (\Throwable $t) {}
            } elseif (strpos($e->getMessage(), 'truncated') !== false || strpos($e->getMessage(), '1265') !== false || strpos($e->getMessage(), '01000') !== false) {
                if ($driver !== 'sqlite') {
                    try {
                        $this->pdo->exec("ALTER TABLE orders MODIFY type VARCHAR(50) NOT NULL DEFAULT 'digital_product'");
                    } catch (\Throwable $t) {}
                }
            }

            try {
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
            } catch (\Throwable $e2) {
                try {
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
                        'type'       => substr($order->type, 0, 10),
                    ]);
                    $order->id = (int)$this->pdo->lastInsertId();
                    return $order;
                } catch (\Throwable $e3) {
                    $stmt = $this->pdo->prepare("
                        INSERT INTO orders (order_number, customer_email, total_amount, currency, stripe_session_id, status)
                        VALUES (:number, :email, :amount, :currency, :session_id, :status)
                    ");
                    $stmt->execute([
                        'number'     => $order->orderNumber,
                        'email'      => $order->customerEmail,
                        'amount'     => $order->totalAmount,
                        'currency'   => $order->currency,
                        'session_id' => $order->stripeSessionId,
                        'status'     => $order->status,
                    ]);
                    $order->id = (int)$this->pdo->lastInsertId();
                    return $order;
                }
            }
        }
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

        $countStmt = $this->pdo->prepare("SELECT COUNT(*) FROM orders WHERE customer_email LIKE :search_email OR order_number LIKE :search_order");
        $countStmt->execute(['search_email' => $searchQuery, 'search_order' => $searchQuery]);
        $total = (int)$countStmt->fetchColumn();

        $stmt = $this->pdo->prepare("
            SELECT * FROM orders 
            WHERE customer_email LIKE :search_email OR order_number LIKE :search_order
            ORDER BY created_at DESC 
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':search_email', $searchQuery, PDO::PARAM_STR);
        $stmt->bindValue(':search_order', $searchQuery, PDO::PARAM_STR);
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