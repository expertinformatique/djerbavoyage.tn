<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\DownloadService;
use Core\Database;

class DownloadServiceTest extends TestCase {
    public function testTokenValidation() {
        $pdo = Database::getInstance();
        $service = new DownloadService($pdo);

        $token = $service->generateToken(1, 1, 24);
        $this->assertNotEmpty($token);

        $validated = $service->validateToken($token);
        $this->assertNotNull($validated);
        $this->assertEquals(1, $validated['product_id']);
    }
}
