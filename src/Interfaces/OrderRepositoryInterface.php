<?php
namespace App\Interfaces;

use App\Models\Order;

interface OrderRepositoryInterface {
    public function findById(int $id): ?Order;
    public function findByStripeSessionId(string $sessionId): ?Order;
    public function create(Order $order): Order;
    public function findByOrderNumber(string $orderNumber): ?Order;
    public function updateStatus(int $orderId, string $status): bool;
    public function getPaidOrdersCount(): int;
    public function getPaginated(int $page = 1, int $limit = 10, string $search = ''): array;
}