<?php
namespace App\Repositories;

use App\Interfaces\ReviewRepositoryInterface;
use App\Models\ServiceReview;
use PDO;
use Throwable;

class PdoReviewRepository implements ReviewRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    private function logError(Throwable $e): void {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
    }

    public function getReviewsByServiceId(int $serviceId, int $limit = 5): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM service_reviews 
                WHERE service_id = :service_id 
                ORDER BY created_at DESC 
                LIMIT :limit
            ");
            $stmt->bindValue(':service_id', $serviceId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_map(fn($r) => ServiceReview::fromArray($r), $rows);
        } catch (Throwable $e) {
            $this->logError($e);
            return [];
        }
    }

    public function getAverageRating(int $serviceId): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT AVG(rating) as avg_rating, COUNT(*) as count 
                FROM service_reviews 
                WHERE service_id = :service_id
            ");
            $stmt->execute(['service_id' => $serviceId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return [
                'average' => $row ? round((float)($row['avg_rating'] ?? 5.0), 1) : 5.0,
                'count'   => $row ? (int)($row['count'] ?? 0) : 0
            ];
        } catch (Throwable $e) {
            $this->logError($e);
            return ['average' => 5.0, 'count' => 0];
        }
    }

    public function addReview(ServiceReview $review): ServiceReview {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO service_reviews (service_id, author_name, rating, comment, is_verified)
                VALUES (:service_id, :author, :rating, :comment, :verified)
            ");
            $stmt->execute([
                'service_id' => $review->serviceId,
                'author'     => $review->authorName,
                'rating'     => $review->rating,
                'comment'    => $review->comment,
                'verified'   => $review->isVerified ? 1 : 0
            ]);
            $review->id = (int)$this->pdo->lastInsertId();
            return $review;
        } catch (Throwable $e) {
            $this->logError($e);
            return $review;
        }
    }

    public function getAllReviews(int $limit = 20): array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM service_reviews ORDER BY created_at DESC LIMIT :limit");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_map(fn($r) => ServiceReview::fromArray($r), $rows);
        } catch (Throwable $e) {
            $this->logError($e);
            return [];
        }
    }
}
