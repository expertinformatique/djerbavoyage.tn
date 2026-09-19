<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\TikTokPublisherService;

class TikTokPublisherTest extends TestCase {
    private string $tempVideo;

    protected function setUp(): void {
        $this->tempVideo = sys_get_temp_dir() . '/test_tiktok_video_' . uniqid() . '.mp4';
        file_put_contents($this->tempVideo, str_repeat("DUMMY_TIKTOK_DATA", 100));
    }

    protected function tearDown(): void {
        if (file_exists($this->tempVideo)) {
            @unlink($this->tempVideo);
        }
    }

    public function testAuthorizationUrlBuildsValidParams(): void {
        $_ENV['TIKTOK_CLIENT_KEY'] = 'awbsf4kpn6kkxefn';
        $_ENV['TIKTOK_REDIRECT_URI'] = 'https://djerbavoyage.tn/admin/tiktok/callback';

        $service = new TikTokPublisherService();
        $url = $service->getAuthorizationUrl('custom_state_123');

        $this->assertStringContainsString('https://www.tiktok.com/v2/auth/authorize/', $url);
        $this->assertStringContainsString('client_key=awbsf4kpn6kkxefn', $url);
        $this->assertStringContainsString('response_type=code', $url);
        $this->assertStringContainsString('video.publish', $url);
        $this->assertStringContainsString('state=custom_state_123', $url);
    }

    public function testDisabledPublishingReturnsFalse(): void {
        $_ENV['TIKTOK_AUTO_PUBLISH'] = 'false';
        $service = new TikTokPublisherService();
        $res = $service->publishVideo($this->tempVideo, 'Test Caption');

        $this->assertFalse($res['published']);
        $this->assertStringContainsString('désactivée', $res['reason']);

        $_ENV['TIKTOK_AUTO_PUBLISH'] = 'true';
    }

    public function testMissingVideoFileReturnsFalse(): void {
        $_ENV['TIKTOK_AUTO_PUBLISH'] = 'true';
        $service = new TikTokPublisherService();
        $res = $service->publishVideo('/non/existent/video.mp4', 'Test Caption');

        $this->assertFalse($res['published']);
        $this->assertStringContainsString('introuvable', $res['reason']);
    }

    public function testMissingTokenReturnsFalse(): void {
        $orig = $_ENV['TIKTOK_ACCESS_TOKEN'] ?? null;
        unset($_ENV['TIKTOK_ACCESS_TOKEN'], $_ENV['TIKTOK_REFRESH_TOKEN']);

        $service = new TikTokPublisherService();
        $res = $service->publishVideo($this->tempVideo, 'Test Caption');

        $this->assertFalse($res['published']);
        $this->assertStringContainsString('manquant', $res['reason']);

        if ($orig !== null) $_ENV['TIKTOK_ACCESS_TOKEN'] = $orig;
    }

    public function testBuildCaptionFormatsHashtags(): void {
        $service = new TikTokPublisherService();
        $caption = $service->buildCaption('Excursion en Quad dans les Dunes');

        $this->assertStringContainsString('Excursion en Quad dans les Dunes', $caption);
        $this->assertStringContainsString('#djerba', $caption);
        $this->assertStringContainsString('#tunisie', $caption);
        $this->assertStringContainsString('#voyage', $caption);
    }
}
