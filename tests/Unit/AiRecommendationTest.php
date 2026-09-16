<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\AiRecommendationService;

class AiRecommendationTest extends TestCase {
    private AiRecommendationService $aiService;

    protected function setUp(): void {
        $this->aiService = new AiRecommendationService();
    }

    public function testRotatingBadgesCycleOnVisits() {
        $badgeVisit1 = $this->aiService->getBadgeForVisit(1, 0);
        $badgeVisit2 = $this->aiService->getBadgeForVisit(2, 0);

        $this->assertNotEmpty($badgeVisit1);
        $this->assertNotEmpty($badgeVisit2);
        $this->assertNotEquals($badgeVisit1, $badgeVisit2, "Returning visitors must see rotated badges");
    }

    public function testMatchScoreCalculationWithAllParameters() {
        $fullCriteria = [
            'traveler' => 'couple',
            'style' => 'culture',
            'lodging' => 'menzel',
            'pace' => 'balanced',
            'duration' => '5j'
        ];

        $scoreFull = $this->aiService->calculateMatchScore($fullCriteria);
        $this->assertGreaterThanOrEqual(95, $scoreFull);
        $this->assertLessThanOrEqual(99, $scoreFull);

        $partialCriteria = ['style' => 'culture'];
        $scorePartial = $this->aiService->calculateMatchScore($partialCriteria);
        $this->assertLessThan($scoreFull, $scorePartial);
    }

    public function testRecommendationVariantsProvideVariety() {
        $criteria = [
            'traveler' => 'friends',
            'style' => 'adventure',
            'lodging' => 'resort',
            'pace' => 'active',
            'duration' => '5j'
        ];

        $variantA = $this->aiService->generateRecommendation($criteria, 0);
        $variantB = $this->aiService->generateRecommendation($criteria, 1);

        $this->assertNotEmpty($variantA['title']);
        $this->assertNotEmpty($variantB['title']);
        $this->assertNotEquals($variantA['itinerary'], $variantB['itinerary'], "Variants must offer different itineraries");
        $this->assertNotEquals($variantA['hotel'], $variantB['hotel'], "Variants must propose different hotels");
        $this->assertNotEquals($variantA['restaurant'], $variantB['restaurant'], "Variants must propose different restaurants");
    }

    public function testRobustnessAgainstInvalidOrMissingParameters() {
        $invalidCriteria = [
            'traveler' => 'invalid_type',
            'style' => 'unknown_style'
        ];

        $rec = $this->aiService->generateRecommendation($invalidCriteria, 0);
        $this->assertNotEmpty($rec['title']);
        $this->assertNotEmpty($rec['hotel']);
        $this->assertNotEmpty($rec['alt_hotel']);
        $this->assertGreaterThanOrEqual(85, $rec['match_score']);
    }

    public function testBehavioralGreetingConditions() {
        $firstVisit = $this->aiService->getBehavioralGreeting(1, false, 0);
        $this->assertNotEmpty($firstVisit);
        $this->assertTrue(str_contains($firstVisit, 'Bienvenue'));

        $hesitating = $this->aiService->getBehavioralGreeting(2, false, 0);
        $this->assertNotEmpty($hesitating);
        $this->assertTrue(str_contains($hesitating, 'hésit') || str_contains($hesitating, 'indécis') || str_contains($hesitating, 'inspiration'));

        $alreadyChosen = $this->aiService->getBehavioralGreeting(2, true, 0);
        $this->assertNotEmpty($alreadyChosen);
        $this->assertTrue(str_contains($alreadyChosen, 'choix précédent') || str_contains($alreadyChosen, 'horizons') || str_contains($alreadyChosen, 'contact'));
    }

    public function testGreetingVarietyBySeed() {
        $greetingSeed0 = $this->aiService->getBehavioralGreeting(2, true, 0);
        $greetingSeed1 = $this->aiService->getBehavioralGreeting(2, true, 1);
        $this->assertNotEquals($greetingSeed0, $greetingSeed1, "Greetings must vary across seeds to avoid repetition");
    }
}
