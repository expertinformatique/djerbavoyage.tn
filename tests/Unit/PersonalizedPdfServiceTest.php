<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\PersonalizedPdfService;

class PersonalizedPdfServiceTest extends TestCase {
    private PersonalizedPdfService $service;

    protected function setUp(): void {
        $this->service = new PersonalizedPdfService();
    }

    public function testGenerateCoverWithCustomData(): void {
        $html = $this->service->generateCoverPdf(
            'Sophie & Lucas',
            'Notre merveilleux voyage à Djerba',
            '12 au 19 Octobre 2026',
            '/images/custom_travelers.jpg'
        );

        $this->assertNotEmpty($html);
        $this->assertTrue(str_contains($html, 'Guide Djerba de Sophie &amp; Lucas'));
        $this->assertTrue(str_contains($html, 'Notre merveilleux voyage à Djerba'));
        $this->assertTrue(str_contains($html, '12 au 19 Octobre 2026'));
        $this->assertTrue(str_contains($html, '/images/custom_travelers.jpg'));
        $this->assertTrue(str_contains($html, 'window.print()'));
    }

    public function testGenerateCoverEscapesMaliciousInput(): void {
        $html = $this->service->generateCoverPdf(
            '<script>alert("xss")</script>',
            '<b>Bold Message</b>',
            '2026',
            ''
        );

        $this->assertFalse(str_contains($html, '<script>alert'));
        $this->assertTrue(str_contains($html, '&lt;script&gt;alert'));
        $this->assertTrue(str_contains($html, '&lt;b&gt;Bold Message&lt;/b&gt;'));
    }

    public function testGenerateCoverFallbackValuesWhenEmpty(): void {
        $html = $this->service->generateCoverPdf('', '', '');

        $this->assertTrue(str_contains($html, 'Voyageur Djerba'));
        $this->assertTrue(str_contains($html, 'séjour inoubliable'));
    }
}
