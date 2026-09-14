<?php
namespace App\Models;

class LocalService {
    public function __construct(
        public ?int $id = null,
        public string $category = '',
        public string $slug = '',
        public string $name = '',
        public string $shortDescription = '',
        public float $priceEur = 0.0,
        public string $unitLabel = '',
        public string $durationLabel = '',
        public string $locationLabel = '',
        public ?string $badge = null,
        public string $imageUrl = '',
        public bool $isActive = true,
        public int $sortOrder = 0
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            category: $data['category'] ?? '',
            slug: $data['slug'] ?? '',
            name: $data['name'] ?? '',
            shortDescription: $data['short_description'] ?? '',
            priceEur: isset($data['price_eur']) ? (float)$data['price_eur'] : 0.0,
            unitLabel: $data['unit_label'] ?? '',
            durationLabel: $data['duration_label'] ?? '',
            locationLabel: $data['location_label'] ?? '',
            badge: $data['badge'] ?? null,
            imageUrl: $data['image_url'] ?? '',
            isActive: (bool)($data['is_active'] ?? true),
            sortOrder: (int)($data['sort_order'] ?? 0)
        );
    }
}
