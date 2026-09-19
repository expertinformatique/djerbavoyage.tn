<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\FacebookReelPublisherService;
use App\Services\ReelVideoProviderService;

class FacebookReelPublisherTest extends TestCase {
    private string $tempVideo;

    protected function setUp(): void {
        $this->tempVideo = sys_get_temp_dir() . '/test_sample_video_' . uniqid() . '.mp4';
        file_put_contents($this->tempVideo, str_repeat("VIDEO_DATA_DUMMY", 200));
    }

    protected function tearDown(): void {
        if (file_exists($this->tempVideo)) {
            @unlink($this->tempVideo);
        }
    }

    public function testDisabledPublishingReturnsFalse(): void {
        $_ENV['FB_AUTO_PUBLISH'] = 'false';
        $service = new FacebookReelPublisherService();
        $res = $service->publishReel($this->tempVideo, 'Test Caption');

        $this->assertFalse($res['published']);
        $this->assertStringContainsString('désactivée', $res['reason']);

        $_ENV['FB_AUTO_PUBLISH'] = 'true';
    }

    public function testMissingVideoFileReturnsFalse(): void {
        $_ENV['FB_AUTO_PUBLISH'] = 'true';
        $service = new FacebookReelPublisherService();
        $res = $service->publishReel('/non/existent/video.mp4', 'Test Caption');

        $this->assertFalse($res['published']);
        $this->assertStringContainsString('introuvable', $res['reason']);
    }

    public function testMissingTokenReturnsFalse(): void {
        $orig = $_ENV['FB_PAGE_ACCESS_TOKEN'] ?? '';
        $_ENV['FB_PAGE_ACCESS_TOKEN'] = '';

        $service = new FacebookReelPublisherService();
        $res = $service->publishReel($this->tempVideo, 'Test Caption');

        $this->assertFalse($res['published']);
        $this->assertStringContainsString('manquant', $res['reason']);

        $_ENV['FB_PAGE_ACCESS_TOKEN'] = $orig;
    }

    public function testSimulatedReelUploadAndPublishSuccess(): void {
        $mock = new class extends FacebookReelPublisherService {
            protected function startUploadSession(string $pageId, string $token): ?array {
                return ['video_id' => 'v123456', 'upload_url' => 'https://rupload.facebook.com/mock'];
            }
            protected function uploadBinaryVideo(string $uploadUrl, string $videoPath, string $token): bool {
                return true;
            }
            protected function finishPublishing(string $pageId, string $token, string $videoId, string $caption): array {
                return ['success' => true, 'post_id' => 'post_reel_999'];
            }
        };

        $_ENV['FB_PAGE_ACCESS_TOKEN'] = 'mock_valid_token';
        $_ENV['FB_AUTO_PUBLISH'] = 'true';

        $res = $mock->publishReel($this->tempVideo, 'Découvrez Djerba en vidéo ! #Djerba');
        $this->assertTrue($res['published']);
        $this->assertEquals('reel', $res['type']);
        $this->assertEquals('v123456', $res['video_id']);
        $this->assertEquals('post_reel_999', $res['post_id']);
    }

    public function testReelVideoProviderResolvesThemeKeys(): void {
        $provider = new ReelVideoProviderService();

        $this->assertEquals('desert_quad', $provider->resolveThemeKey('Aventure en quad dans les dunes'));
        $this->assertEquals('kitesurf_water', $provider->resolveThemeKey('Sensations kitesurf sur la lagune'));
        $this->assertEquals('sunset_camels', $provider->resolveThemeKey('Coucher de soleil à dos de dromadaire'));
        $this->assertEquals('patrimoine_village', $provider->resolveThemeKey('Poterie traditionnelle à Guellala'));
        $this->assertEquals('beach_lagoon', $provider->resolveThemeKey('Plage de sable fin'));
    }
}
