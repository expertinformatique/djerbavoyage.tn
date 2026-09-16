<?php
namespace App\Models;

class Order {
    public function __construct(
        public ?int $id = null,
        public string $orderNumber = '',
        public string $customerEmail = '',
        public float $totalAmount = 0.0,
        public string $currency = 'EUR',
        public string $stripeSessionId = '',
        public string $status = 'pending',
        public string $type = 'digital_product',
        public ?string $createdAt = null,
        public ?string $customerName = null,
        public ?string $customerPhone = null,
        public ?string $summaryDescription = null,
        public int $itemsCount = 0,
        public array $details = []
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            orderNumber: $data['order_number'] ?? '',
            customerEmail: $data['customer_email'] ?? '',
            totalAmount: isset($data['total_amount']) ? (float)$data['total_amount'] : 0.0,
            currency: $data['currency'] ?? 'EUR',
            stripeSessionId: $data['stripe_session_id'] ?? '',
            status: $data['status'] ?? 'pending',
            type: $data['type'] ?? 'digital_product',
            createdAt: $data['created_at'] ?? null,
            customerName: $data['customer_name'] ?? null,
            customerPhone: $data['customer_phone'] ?? null,
            summaryDescription: $data['summary_description'] ?? null,
            itemsCount: isset($data['items_count']) ? (int)$data['items_count'] : 0,
            details: isset($data['details']) && is_array($data['details']) ? $data['details'] : []
        );
    }
}