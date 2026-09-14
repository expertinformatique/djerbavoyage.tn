<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Database;
use App\Repositories\PdoReviewRepository;
use App\Services\ReviewService;
use App\Models\ServiceReview;

class ReviewServiceTest extends TestCase {
    private ReviewService $service;
    private PdoReviewRepository $repo;
    private \PDO $pdo;

    protected function setUp(): void {
        $this->pdo = Database::getInstance();
        $this->repo = new PdoReviewRepository($this->pdo);
        $this->service = new ReviewService($this->repo);

        $this->pdo->exec("DELETE FROM service_reviews");
    }

    public function testAddVerifiedReviewAndSummary() {
        $review = $this->service->addVerifiedReview(1, 'Karim', 5, 'Superbe expérience en quad !');
        $this->assertNotNull($review->id);
        $this->assertEquals(5, $review->rating);
        $this->assertEquals('Karim', $review->authorName);

        $summary = $this->service->getServiceSummary(1);
        $this->assertEquals(5.0, $summary['rating']);
        $this->assertEquals(1, $summary['count']);
        $this->assertEquals(1, count($summary['reviews']));
    }

    public function testRatingAverageCalculation() {
        $this->service->addVerifiedReview(2, 'Client 1', 5, 'Parfait');
        $this->service->addVerifiedReview(2, 'Client 2', 4, 'Très bien');

        $summary = $this->service->getServiceSummary(2);
        $this->assertEquals(4.5, $summary['rating']);
        $this->assertEquals(2, $summary['count']);
    }
}
