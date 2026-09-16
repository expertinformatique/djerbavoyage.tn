<?php
namespace App\Models;

class User {
    public function __construct(
        public ?int $id = null,
        public string $username = '',
        public string $email = '',
        public string $password = '',
        public string $role = 'admin',
        public ?string $createdAt = null
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            username: $data['username'] ?? '',
            email: $data['email'] ?? '',
            password: $data['password'] ?? '',
            role: $data['role'] ?? 'admin',
            createdAt: $data['created_at'] ?? null
        );
    }
}
