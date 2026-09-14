<?php
namespace App\Models;

class ConciergeTicket {
    public function __construct(
        public ?int $id = null,
        public int $orderId = 0,
        public string $clientName = '',
        public string $clientEmail = '',
        public string $travelDates = '',
        public string $status = 'new'
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            orderId: isset($data['order_id']) ? (int)$data['order_id'] : 0,
            clientName: $data['client_name'] ?? '',
            clientEmail: $data['client_email'] ?? '',
            travelDates: $data['travel_dates'] ?? '',
            status: $data['status'] ?? 'new'
        );
    }
}