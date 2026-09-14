<?php
namespace App\Models;

class Article {
    public function __construct(
        public ?int $id = null,
        public ?int $destinationId = null,
        public string $slug = '',
        public string $titleFr = '',
        public ?string $titleEn = null,
        public string $contentFr = '',
        public ?string $contentEn = null,
        public ?string $featuredImage = null,
        public string $status = 'published',
        public int $viewsCount = 0,
        public ?string $publishedAt = null
    ) {}

    public static function fromArray(array $data): self {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            destinationId: isset($data['destination_id']) ? (int)$data['destination_id'] : null,
            slug: $data['slug'] ?? '',
            titleFr: $data['title_fr'] ?? '',
            titleEn: $data['title_en'] ?? null,
            contentFr: $data['content_fr'] ?? '',
            contentEn: $data['content_en'] ?? null,
            featuredImage: $data['featured_image'] ?? null,
            status: $data['status'] ?? 'published',
            viewsCount: isset($data['views_count']) ? (int)$data['views_count'] : 0,
            publishedAt: $data['published_at'] ?? null
        );
    }
}