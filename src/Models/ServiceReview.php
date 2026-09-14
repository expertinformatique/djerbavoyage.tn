<?php
namespace App\Models;

class ServiceReview {
    public function __construct(
        public ?int $id = null,
        public int $serviceId = 0,
        public string $authorName = '',
        public int $rating = 5,
        public string $comment = '',
        public bool $isVerified = true,
        public ?string $createdAt = null
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            serviceId: (int)($data['service_id'] ?? 0),
            authorName: $data['author_name'] ?? '',
            rating: (int)($data['rating'] ?? 5),
            comment: $data['comment'] ?? '',
            isVerified: (bool)($data['is_verified'] ?? true),
            createdAt: $data['created_at'] ?? null
        );
    }
}
