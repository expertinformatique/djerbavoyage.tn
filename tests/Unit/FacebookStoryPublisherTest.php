<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Article;
use App\Services\FacebookStoryPublisherService;

class FacebookStoryPublisherTest extends TestCase {
    private string $tempVideo;
    private Article $sampleArticle;

    protected function setUp(): void {
        $this->tempVideo = sys_get_temp_dir() . '/test_sample_story_' . uniqid() . '.mp4';
        file_put_contents($this->tempVideo, str_repeat("STORY_DATA_DUMMY", 200));

        $this->sampleArticle = new Article(
            id: 99,
            destinationId: 1,
            slug: 'test-djerba-story',
            titleFr: 'Guide Insolite Djerba Story',
            titleEn: 'Unique Djerba Story Guide',
            contentFr: '<p>Contenu test story</p>',
            contentEn: '<p>Story content</p>',
            featuredImage: 'assets/images/service_kitesurf.jpg',
            status: 'published',
            viewsCount: 120,
            publishedAt: date('Y-m-d H:i:s'),
            seoDescription: 'Découverte des plus belles stories de Djerba',
            metaKeywords: 'djerba, story',
            summaryAi: 'Résumé story',
            schemaJson: '{}',
            pdfEnabled: true,
            pdfPriceEur: 2.99,
            ctaServicesJson: '[]',
            authorName: 'Rédaction Djerba',
            videoUrl: 'assets/videos/reels/culture.mp4'
        );
    }

    protected function tearDown(): void {
        if (file_exists($this->tempVideo)) {
            @unlink($this->tempVideo);
        }
    }

    public function testDisabledPublishingReturnsFalse(): void {
        $_ENV['FB_STORY_ENABLED'] = 'false';
        $service = new FacebookStoryPublisherService();
        $res = $service->publishStory($this->sampleArticle, $this->tempVideo);

        $this->assertFalse($res['published']);
        $this->assertStringContainsString('désactivée', $res['reason']);

        $_ENV['FB_STORY_ENABLED'] = 'true';
    }

    public function testMissingTokenReturnsFalse(): void {
        $orig = $_ENV['FB_PAGE_ACCESS_TOKEN'] ?? '';
        $_ENV['FB_PAGE_ACCESS_TOKEN'] = '';
        $_ENV['FB_STORY_ENABLED'] = 'true';

        $service = new FacebookStoryPublisherService();
        $res = $service->publishStory($this->sampleArticle, $this->tempVideo);

        $this->assertFalse($res['published']);
        $this->assertStringContainsString('manquant', $res['reason']);

        $_ENV['FB_PAGE_ACCESS_TOKEN'] = $orig;
    }

    public function testSimulatedVideoStoryPublishSuccess(): void {
        $_ENV['FB_PAGE_ACCESS_TOKEN'] = 'mock_valid_token';
        $_ENV['FB_STORY_ENABLED'] = 'true';

        $mock = new class extends FacebookStoryPublisherService {
            protected function startStorySession(string $pageId, string $token): ?array {
                return ['video_id' => 'story_vid_999', 'upload_url' => 'https://rupload.facebook.com/mock_story'];
            }
            protected function uploadBinaryStory(string $uploadUrl, string $videoPath, string $token): bool {
                return true;
            }
            protected function finishStoryPublishing(string $pageId, string $token, string $videoId): array {
                return ['post_id' => 'story_post_999'];
            }
        };

        $res = $mock->publishStory($this->sampleArticle, $this->tempVideo);
        $this->assertTrue($res['published']);
        $this->assertEquals('video_story', $res['type']);
        $this->assertEquals('9:16', $res['format']);
        $this->assertEquals('story_vid_999', $res['story_id']);
    }

    public function testSimulatedPhotoStoryPublishSuccess(): void {
        $_ENV['FB_PAGE_ACCESS_TOKEN'] = 'mock_valid_token';
        $_ENV['FB_STORY_ENABLED'] = 'true';

        $mock = new class extends FacebookStoryPublisherService {
            protected function postPhotoStory(string $pageId, string $token, string $imageUrl, string $caption): array {
                return ['id' => 'photo_story_123', 'post_id' => 'photo_story_123'];
            }
        };

        // Sans vidéo, doit basculer sur photo story
        $res = $mock->publishStory($this->sampleArticle, null, 'Story caption');
        $this->assertTrue($res['published']);
        $this->assertEquals('photo_story', $res['type']);
        $this->assertEquals('9:16', $res['format']);
        $this->assertEquals('photo_story_123', $res['story_id']);
    }

    public function testResolveImageUrl(): void {
        $service = new FacebookStoryPublisherService();
        $this->assertEquals('https://example.com/img.jpg', $service->resolveImageUrl('https://example.com/img.jpg'));
        $this->assertEquals('https://djerbavoyage.tn/assets/test.jpg', $service->resolveImageUrl('assets/test.jpg'));
        $this->assertNull($service->resolveImageUrl(null));
    }
}
