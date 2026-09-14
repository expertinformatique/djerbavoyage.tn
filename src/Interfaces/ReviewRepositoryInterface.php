<?php
namespace App\Interfaces;

use App\Models\ServiceReview;

interface ReviewRepositoryInterface {
    public function getReviewsByServiceId(int $serviceId, int $limit = 5): array;
    public function getAverageRating(int $serviceId): array;
    public function addReview(ServiceReview $review): ServiceReview;
    public function getAllReviews(int $limit = 20): array;
}
