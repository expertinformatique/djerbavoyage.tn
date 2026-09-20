<?php
namespace App\Models;

class Article {
    public function __construct(
        public ?int $id = null,
        public ?int $destinationId = null,
        public string $slug = '',
        public string $titleFr = '',
        public ?string $titleEn = null,
        public ?string $titleAr = null,
        public string $contentFr = '',
        public ?string $contentEn = null,
        public ?string $contentAr = null,
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

    public function getTitle(?string $locale = null): string {
        $loc = $locale ?? (\class_exists('Core\Lang') ? \Core\Lang::getLocale() : 'fr');
        if ($loc === 'ar' && !empty($this->titleAr)) {
            return $this->titleAr;
        }
        if ($loc === 'en' && !empty($this->titleEn)) {
            return $this->titleEn;
        }
        return $this->titleFr;
    }

    public function getContent(?string $locale = null): string {
        $loc = $locale ?? (\class_exists('Core\Lang') ? \Core\Lang::getLocale() : 'fr');
        if ($loc === 'ar' && !empty($this->contentAr)) {
            return $this->contentAr;
        }
        if ($loc === 'en' && !empty($this->contentEn)) {
            return $this->contentEn;
        }
        return $this->contentFr;
    }

    public function getAvailableLanguages(): array {
        $langs = ['fr'];
        if (!empty($this->titleEn) || !empty($this->contentEn)) {
            $langs[] = 'en';
        }
        if (!empty($this->titleAr) || !empty($this->contentAr)) {
            $langs[] = 'ar';
        }
        return $langs;
    }

    public static function fromArray(array $data): self {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            destinationId: isset($data['destination_id']) ? (int)$data['destination_id'] : null,
            slug: $data['slug'] ?? '',
            titleFr: $data['title_fr'] ?? '',
            titleEn: $data['title_en'] ?? null,
            titleAr: $data['title_ar'] ?? null,
            contentFr: $data['content_fr'] ?? '',
            contentEn: $data['content_en'] ?? null,
            contentAr: $data['content_ar'] ?? null,
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