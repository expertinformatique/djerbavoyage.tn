<?php
namespace App\Models;

class Product {
    public function __construct(
        public ?int $id = null,
        public string $slug = '',
        public string $titleFr = '',
        public float $priceEur = 0.0,
        public string $filePath = '',
        public bool $isActive = true
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            slug: $data['slug'] ?? '',
            titleFr: $data['title_fr'] ?? '',
            priceEur: isset($data['price_eur']) ? (float)$data['price_eur'] : 0.0,
            filePath: $data['file_path'] ?? '',
            isActive: (bool)($data['is_active'] ?? true)
        );
    }
}