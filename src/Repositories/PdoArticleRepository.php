<?php
namespace App\Repositories;

use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Article;
use PDO;

class PdoArticleRepository implements ArticleRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    private function logError(\Throwable $e): void {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
    }

    public function findBySlug(string $slug): ?Article {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE slug = :slug AND status = 'published'");
            $stmt->execute(['slug' => $slug]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? Article::fromArray($data) : null;
        } catch (\Throwable $e) {
            $this->logError($e);
            return null;
        }
    }

    public function findById(int $id): ?Article {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? Article::fromArray($data) : null;
        } catch (\Throwable $e) {
            $this->logError($e);
            return null;
        }
    }

    public function getAllPublished(int $limit = 10): array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE status = 'published' ORDER BY published_at DESC LIMIT :limit");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_map(fn($row) => Article::fromArray($row), $rows);
        } catch (\Throwable $e) {
            $this->logError($e);
            return [];
        }
    }

    public function getByDestination(int $destinationId): array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE destination_id = :dest_id AND status = 'published'");
            $stmt->execute(['dest_id' => $destinationId]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_map(fn($row) => Article::fromArray($row), $rows);
        } catch (\Throwable $e) {
            $this->logError($e);
            return [];
        }
    }

    public function incrementViews(int $id): void {
        try {
            $stmt = $this->pdo->prepare("UPDATE articles SET views_count = views_count + 1 WHERE id = :id");
            $stmt->execute(['id' => $id]);
        } catch (\Throwable $e) {
            $this->logError($e);
        }
    }

    public function save(Article $article): Article {
        try {
            if ($article->id !== null) {
                $sql = "UPDATE articles SET 
                    destination_id = :destination_id,
                    slug = :slug,
                    title_fr = :title_fr,
                    title_en = :title_en,
                    content_fr = :content_fr,
                    content_en = :content_en,
                    featured_image = :featured_image,
                    status = :status,
                    seo_description = :seo_description,
                    meta_keywords = :meta_keywords,
                    summary_ai = :summary_ai,
                    schema_json = :schema_json,
                    pdf_enabled = :pdf_enabled,
                    pdf_price_eur = :pdf_price_eur,
                    cta_services_json = :cta_services_json,
                    author_name = :author_name,
                    video_url = :video_url
                    WHERE id = :id";
                $params = $this->extractParams($article);
                $params['id'] = $article->id;
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($params);
            } else {
                $sql = "INSERT INTO articles (
                    destination_id, slug, title_fr, title_en, content_fr, content_en, 
                    featured_image, status, published_at, seo_description, meta_keywords, 
                    summary_ai, schema_json, pdf_enabled, pdf_price_eur, cta_services_json, author_name, video_url
                ) VALUES (
                    :destination_id, :slug, :title_fr, :title_en, :content_fr, :content_en, 
                    :featured_image, :status, CURRENT_TIMESTAMP, :seo_description, :meta_keywords, 
                    :summary_ai, :schema_json, :pdf_enabled, :pdf_price_eur, :cta_services_json, :author_name, :video_url
                )";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($this->extractParams($article));
                $article->id = (int)$this->pdo->lastInsertId();
            }
            return $article;
        } catch (\Throwable $e) {
            $this->logError($e);
            throw $e;
        }
    }

    private function extractParams(Article $article): array {
        return [
            'destination_id'   => $article->destinationId,
            'slug'             => $article->slug,
            'title_fr'         => $article->titleFr,
            'title_en'         => $article->titleEn,
            'content_fr'       => $article->contentFr,
            'content_en'       => $article->contentEn,
            'featured_image'   => $article->featuredImage,
            'status'           => $article->status,
            'seo_description'  => $article->seoDescription,
            'meta_keywords'    => $article->metaKeywords,
            'summary_ai'       => $article->summaryAi,
            'schema_json'      => $article->schemaJson,
            'pdf_enabled'      => $article->pdfEnabled ? 1 : 0,
            'pdf_price_eur'    => $article->pdfPriceEur,
            'cta_services_json'=> $article->ctaServicesJson,
            'author_name'      => $article->authorName,
            'video_url'        => $article->videoUrl
        ];
    }

    public function delete(int $id): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM articles WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (\Throwable $e) {
            $this->logError($e);
            return false;
        }
    }

    public function countPublished(): int {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM articles WHERE status = 'published'");
            $count = (int)$stmt->fetchColumn();
            if ($stmt) $stmt->closeCursor();
            return $count;
        } catch (\Throwable $e) {
            $this->logError($e);
            return 0;
        }
    }

    public function countAll(): int {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM articles");
            $count = (int)$stmt->fetchColumn();
            if ($stmt) $stmt->closeCursor();
            return $count;
        } catch (\Throwable $e) {
            $this->logError($e);
            return 0;
        }
    }

    public function getStats(): array {
        try {
            $stmt = $this->pdo->query("
                SELECT 
                    COUNT(*) as total_count,
                    SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published_count,
                    SUM(CASE WHEN status != 'published' THEN 1 ELSE 0 END) as draft_count,
                    COALESCE(SUM(views_count), 0) as total_views
                FROM articles
            ");
            $data = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : [];
            if ($stmt) $stmt->closeCursor();
            return [
                'total_count'     => (int)($data['total_count'] ?? 0),
                'published_count' => (int)($data['published_count'] ?? 0),
                'draft_count'     => (int)($data['draft_count'] ?? 0),
                'total_views'     => (int)($data['total_views'] ?? 0)
            ];
        } catch (\Throwable $e) {
            $this->logError($e);
            return ['total_count' => 0, 'published_count' => 0, 'draft_count' => 0, 'total_views' => 0];
        }
    }

    public function getPaginated(int $page = 1, int $limit = 10, string $search = '', string $status = ''): array {
        $offset = ($page - 1) * $limit;
        $where = [];
        $params = [];

        if ($search !== '') {
            $where[] = "(title_fr LIKE :search OR slug LIKE :search)";
            $params[':search'] = "%{$search}%";
        }

        if ($status !== '' && $status !== 'all') {
            $where[] = "status = :status";
            $params[':status'] = $status;
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

        try {
            $countStmt = $this->pdo->prepare("SELECT COUNT(*) FROM articles {$whereClause}");
            $countStmt->execute($params);
            $total = (int)$countStmt->fetchColumn();
            if ($countStmt) $countStmt->closeCursor();

            $stmt = $this->pdo->prepare("
                SELECT * FROM articles {$whereClause}
                ORDER BY published_at DESC, id DESC
                LIMIT :limit OFFSET :offset
            ");
            foreach ($params as $k => $v) {
                $stmt->bindValue($k, $v);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt) $stmt->closeCursor();

            return [
                'total' => $total,
                'items' => array_map(fn($row) => Article::fromArray($row), $rows)
            ];
        } catch (\Throwable $e) {
            $this->logError($e);
            return ['total' => 0, 'items' => []];
        }
    }
}