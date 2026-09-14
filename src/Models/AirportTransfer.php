<?php
namespace App\Models;

class AirportTransfer {
    public function __construct(
        public ?int $id = null,
        public int $orderId = 0,
        public ?string $flightNumber = null,
        public ?string $airline = null,
        public ?string $arrivalDate = null,
        public ?string $arrivalTime = null,
        public int $passengersCount = 1,
        public ?string $dropoffLocation = null,
        public ?string $phoneWhatsapp = null,
        public string $status = 'pending',
        public ?string $driverNotes = null
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            orderId: (int)($data['order_id'] ?? 0),
            flightNumber: $data['flight_number'] ?? null,
            airline: $data['airline'] ?? null,
            arrivalDate: $data['arrival_date'] ?? null,
            arrivalTime: $data['arrival_time'] ?? null,
            passengersCount: (int)($data['passengers_count'] ?? 1),
            dropoffLocation: $data['dropoff_location'] ?? null,
            phoneWhatsapp: $data['phone_whatsapp'] ?? null,
            status: $data['status'] ?? 'pending',
            driverNotes: $data['driver_notes'] ?? null
        );
    }
}
