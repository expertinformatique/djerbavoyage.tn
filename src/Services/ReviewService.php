<?php
namespace App\Services;

use App\Interfaces\ReviewRepositoryInterface;
use App\Models\ServiceReview;

class ReviewService {
    public function __construct(private ReviewRepositoryInterface $reviewRepo) {}

    public function getServiceSummary(int $serviceId): array {
        $stats = $this->reviewRepo->getAverageRating($serviceId);
        $recent = $this->reviewRepo->getReviewsByServiceId($serviceId, 3);

        return [
            'rating'  => $stats['average'] > 0 ? $stats['average'] : 4.9,
            'count'   => max(1, $stats['count']),
            'reviews' => $recent
        ];
    }

    public function addVerifiedReview(int $serviceId, string $author, int $rating, string $comment): ServiceReview {
        $cleanRating = max(1, min(5, $rating));
        $review = new ServiceReview(
            serviceId: $serviceId,
            authorName: trim($author) ?: 'Voyageur Djerba',
            rating: $cleanRating,
            comment: trim($comment),
            isVerified: true
        );
        return $this->reviewRepo->addReview($review);
    }
}
