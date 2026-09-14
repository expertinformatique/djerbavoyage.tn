<?php
namespace App\Models;

class ServiceBooking {
    public function __construct(
        public ?int $id = null,
        public int $orderId = 0,
        public int $serviceId = 0,
        public ?string $scheduledDate = null,
        public ?string $scheduledTime = null,
        public int $guestsCount = 1,
        public float $unitPrice = 0.0,
        public float $totalPrice = 0.0,
        public ?string $notes = null,
        public string $status = 'confirmed',
        public ?LocalService $service = null
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            orderId: (int)($data['order_id'] ?? 0),
            serviceId: (int)($data['service_id'] ?? 0),
            scheduledDate: $data['scheduled_date'] ?? null,
            scheduledTime: $data['scheduled_time'] ?? null,
            guestsCount: (int)($data['guests_count'] ?? 1),
            unitPrice: isset($data['unit_price']) ? (float)$data['unit_price'] : 0.0,
            totalPrice: isset($data['total_price']) ? (float)$data['total_price'] : 0.0,
            notes: $data['notes'] ?? null,
            status: $data['status'] ?? 'confirmed'
        );
    }
}
