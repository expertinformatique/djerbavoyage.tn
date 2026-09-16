<?php
namespace App\Models;

class AiLead {
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public ?string $phone = null,
        public ?string $travelDate = null,
        public ?string $notes = null,
        public ?array $preferences = null,
        public ?string $ipAddress = null,
        public string $status = 'new',
        public ?string $createdAt = null
    ) {}

    public static function fromArray(array $row): self {
        $prefs = !empty($row['preferences_json']) 
            ? json_decode($row['preferences_json'], true) 
            : ($row['preferences'] ?? []);

        return new self(
            id: isset($row['id']) ? (int)$row['id'] : null,
            name: $row['name'] ?? '',
            email: $row['email'] ?? '',
            phone: $row['phone'] ?? null,
            travelDate: $row['travel_date'] ?? null,
            notes: $row['notes'] ?? null,
            preferences: is_array($prefs) ? $prefs : [],
            ipAddress: $row['ip_address'] ?? null,
            status: $row['status'] ?? 'new',
            createdAt: $row['created_at'] ?? null
        );
    }

    public function toArray(): array {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'email'            => $this->email,
            'phone'            => $this->phone,
            'travel_date'      => $this->travelDate,
            'notes'            => $this->notes,
            'preferences_json' => !empty($this->preferences) ? json_encode($this->preferences, JSON_UNESCAPED_UNICODE) : null,
            'ip_address'       => $this->ipAddress,
            'status'           => $this->status,
            'created_at'       => $this->createdAt
        ];
    }
}
