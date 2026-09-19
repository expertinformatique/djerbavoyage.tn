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
        public ?string $publishedAt = null,
        public ?string $seoDescription = null,
        public ?string $metaKeywords = null,
        public ?string $summaryAi = null,
        public ?string $schemaJson = null,
        public bool $pdfEnabled = true,
        public float $pdfPriceEur = 2.99,
        public ?string $ctaServicesJson = null,
        public string $authorName = 'IA Voyageur Djerba',
        public ?string $videoUrl = null
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
            publishedAt: $data['published_at'] ?? null,
            seoDescription: $data['seo_description'] ?? null,
            metaKeywords: $data['meta_keywords'] ?? null,
            summaryAi: $data['summary_ai'] ?? null,
            schemaJson: $data['schema_json'] ?? null,
            pdfEnabled: isset($data['pdf_enabled']) ? (bool)$data['pdf_enabled'] : true,
            pdfPriceEur: isset($data['pdf_price_eur']) ? (float)$data['pdf_price_eur'] : 2.99,
            ctaServicesJson: $data['cta_services_json'] ?? null,
            authorName: $data['author_name'] ?? 'IA Voyageur Djerba',
            videoUrl: $data['video_url'] ?? null
        );
    }
}