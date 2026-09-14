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
        public string $type = 'digital_product'
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
            type: $data['type'] ?? 'digital_product'
        );
    }
}