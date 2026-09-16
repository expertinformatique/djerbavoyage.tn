<?php
namespace App\Models;

class ContactMessage {
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public ?string $phone,
        public ?string $subject,
        public string $message,
        public ?string $ipAddress = null,
        public string $status = 'new',
        public ?string $createdAt = null
    ) {}

    public static function fromArray(array $row): self {
        return new self(
            id: isset($row['id']) ? (int)$row['id'] : null,
            name: $row['name'] ?? '',
            email: $row['email'] ?? '',
            phone: $row['phone'] ?? null,
            subject: $row['subject'] ?? null,
            message: $row['message'] ?? '',
            ipAddress: $row['ip_address'] ?? null,
            status: $row['status'] ?? 'new',
            createdAt: $row['created_at'] ?? null
        );
    }
}
