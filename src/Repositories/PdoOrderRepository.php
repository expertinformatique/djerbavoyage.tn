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
        if ($stmt) $stmt->closeCursor();
        return $data ? Order::fromArray($data) : null;
    }

    public function findByStripeSessionId(string $sessionId): ?Order {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE stripe_session_id = :session_id");
        $stmt->execute(['session_id' => $sessionId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt) $stmt->closeCursor();
        return $data ? Order::fromArray($data) : null;
    }

    public function findByOrderNumber(string $orderNumber): ?Order {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE order_number = :order_number");
        $stmt->execute(['order_number' => $orderNumber]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt) $stmt->closeCursor();
        return $data ? Order::fromArray($data) : null;
    }

    public function create(Order $order): Order {
        $stmt = $this->pdo->prepare("
            INSERT INTO orders (order_number, customer_email, total_amount, currency, stripe_session_id, status, type, created_at)
            VALUES (:number, :email, :amount, :currency, :session_id, :status, :type, CURRENT_TIMESTAMP)
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
        $count = (int)$stmt->fetchColumn();
        if ($stmt) $stmt->closeCursor();
        return $count;
    }

    public function getStats(): array {
        $stmt = $this->pdo->query("
            SELECT 
                COUNT(*) as total_count,
                SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid_count,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_count,
                COALESCE(SUM(CASE WHEN status = 'paid' THEN total_amount ELSE 0 END), 0) as total_revenue
            FROM orders
        ");
        $data = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : [];
        if ($stmt) $stmt->closeCursor();
        return [
            'total_count'     => (int)($data['total_count'] ?? 0),
            'paid_count'      => (int)($data['paid_count'] ?? 0),
            'pending_count'   => (int)($data['pending_count'] ?? 0),
            'cancelled_count' => (int)($data['cancelled_count'] ?? 0),
            'total_revenue'   => (float)($data['total_revenue'] ?? 0.0)
        ];
    }

    public function getPaginated(int $page = 1, int $limit = 10, string $search = '', string $status = ''): array {
        $offset = ($page - 1) * $limit;
        $where = [];
        $params = [];

        if ($search !== '') {
            $where[] = "(customer_email LIKE :search_email OR order_number LIKE :search_order)";
            $params[':search_email'] = "%{$search}%";
            $params[':search_order'] = "%{$search}%";
        }

        if ($status !== '' && $status !== 'all') {
            $where[] = "status = :status";
            $params[':status'] = $status;
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

        $countStmt = $this->pdo->prepare("SELECT COUNT(*) FROM orders {$whereClause}");
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();
        if ($countStmt) $countStmt->closeCursor();

        $stmt = $this->pdo->prepare("
            SELECT * FROM orders {$whereClause}
            ORDER BY created_at DESC 
            LIMIT :limit OFFSET :offset
        ");
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($stmt) $stmt->closeCursor();

        $orders = array_map(fn($row) => Order::fromArray($row), $rows);
        $enriched = $this->enrichOrders($orders);

        return [
            'total' => $total,
            'items' => $enriched
        ];
    }

    public function getOrderDetails(int $orderId): ?array {
        $order = $this->findById($orderId);
        if (!$order) return null;

        $bookings = [];
        $transfer = null;
        $products = [];
        $concierge = null;

        try {
            $stmt = $this->pdo->prepare("
                SELECT sb.*, ls.name as service_name, ls.category as service_category, ls.image_url as service_image
                FROM service_bookings sb
                LEFT JOIN local_services ls ON sb.service_id = ls.id
                WHERE sb.order_id = :id
            ");
            $stmt->execute(['id' => $orderId]);
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt) $stmt->closeCursor();
        } catch (\Throwable $e) {}

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM airport_transfers WHERE order_id = :id LIMIT 1");
            $stmt->execute(['id' => $orderId]);
            $transfer = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
            if ($stmt) $stmt->closeCursor();
        } catch (\Throwable $e) {}

        try {
            $stmt = $this->pdo->prepare("
                SELECT dt.*, p.title_fr as product_title, p.file_path, p.price_eur as product_price
                FROM download_tokens dt
                LEFT JOIN products p ON dt.product_id = p.id
                WHERE dt.order_id = :id
            ");
            $stmt->execute(['id' => $orderId]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt) $stmt->closeCursor();
        } catch (\Throwable $e) {}

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM concierge_tickets WHERE order_id = :id LIMIT 1");
            $stmt->execute(['id' => $orderId]);
            $concierge = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
            if ($stmt) $stmt->closeCursor();
        } catch (\Throwable $e) {}

        return [
            'order'          => $order,
            'customer_name'  => $concierge['client_name'] ?? null,
            'customer_phone' => $transfer['phone_whatsapp'] ?? null,
            'bookings'       => $bookings,
            'transfer'       => $transfer,
            'products'       => $products,
            'concierge'      => $concierge
        ];
    }

    private function enrichOrders(array $orders): array {
        if (empty($orders)) return [];
        $orderIds = array_map(fn($o) => $o->id, $orders);
        $inPlaceholder = implode(',', array_fill(0, count($orderIds), '?'));

        $transfers = [];
        try {
            $stmt = $this->pdo->prepare("SELECT order_id, phone_whatsapp, flight_number FROM airport_transfers WHERE order_id IN ({$inPlaceholder})");
            $stmt->execute($orderIds);
            while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $transfers[$r['order_id']] = $r;
            }
            if ($stmt) $stmt->closeCursor();
        } catch (\Throwable $e) {}

        $bookings = [];
        try {
            $stmt = $this->pdo->prepare("
                SELECT sb.order_id, ls.name as service_name
                FROM service_bookings sb
                LEFT JOIN local_services ls ON sb.service_id = ls.id
                WHERE sb.order_id IN ({$inPlaceholder})
            ");
            $stmt->execute($orderIds);
            while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $bookings[$r['order_id']][] = $r['service_name'];
            }
            if ($stmt) $stmt->closeCursor();
        } catch (\Throwable $e) {}

        $products = [];
        try {
            $stmt = $this->pdo->prepare("
                SELECT dt.order_id, p.title_fr as product_title
                FROM download_tokens dt
                LEFT JOIN products p ON dt.product_id = p.id
                WHERE dt.order_id IN ({$inPlaceholder})
            ");
            $stmt->execute($orderIds);
            while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products[$r['order_id']][] = $r['product_title'];
            }
            if ($stmt) $stmt->closeCursor();
        } catch (\Throwable $e) {}

        foreach ($orders as $order) {
            if (isset($transfers[$order->id])) {
                $order->customerPhone = $transfers[$order->id]['phone_whatsapp'] ?: null;
            }
            if (!empty($bookings[$order->id])) {
                $bList = array_filter($bookings[$order->id]);
                $order->itemsCount = count($bList);
                $summary = implode(', ', array_slice($bList, 0, 2));
                if (count($bList) > 2) $summary .= ' +' . (count($bList) - 2);
                if (!empty($transfers[$order->id])) $summary .= ' + Navette VIP';
                $order->summaryDescription = $summary;
            } elseif (!empty($products[$order->id])) {
                $order->itemsCount = count($products[$order->id]);
                $order->summaryDescription = implode(', ', $products[$order->id]);
            } elseif ($order->type === 'concierge') {
                $order->summaryDescription = 'Itinéraire 100% sur-mesure (Conciergerie)';
            } elseif ($order->type === 'personalized_pdf') {
                $order->summaryDescription = 'Guide PDF Personnalisé';
            } else {
                $order->summaryDescription = ucfirst(str_replace('_', ' ', $order->type));
            }
        }
        return $orders;
    }
}