<?php
namespace App\Models;

class Destination {
    public function __construct(
        public ?int $id = null,
        public string $slug = '',
        public string $nameFr = '',
        public string $nameEn = '',
        public ?string $descriptionFr = null,
        public ?string $descriptionEn = null,
        public ?string $imageUrl = null
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            slug: $data['slug'] ?? '',
            nameFr: $data['name_fr'] ?? '',
            nameEn: $data['name_en'] ?? '',
            descriptionFr: $data['description_fr'] ?? null,
            descriptionEn: $data['description_en'] ?? null,
            imageUrl: $data['image_url'] ?? null
        );
    }
}