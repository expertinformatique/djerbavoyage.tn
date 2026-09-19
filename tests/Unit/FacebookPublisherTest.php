<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Article;
use App\Services\FacebookPublisherService;
use Core\Database;

class FacebookPublisherTest extends TestCase {
    private Article $sampleArticle;

    protected function setUp(): void {
        $this->sampleArticle = new Article(
            id: 101,
            destinationId: 1,
            slug: 'secrets-potiers-guellala-djerba',
            titleFr: 'Secrets Millénaires des Potiers de Guellala à Djerba',
            contentFr: '<p>Récit sur les potiers de Guellala.</p>',
            featuredImage: 'images/guellala.png',
            status: 'published',
            seoDescription: 'Découvrez l art ancestral des potiers de Guellala au sud de Djerba.',
            summaryAi: "• Histoire de Guellala\n• Ateliers troglodytes\n• Techniques berbères",
            authorName: 'IA Voyageur Djerba'
        );
    }

    public function testBuildMessageContainsTitleSlugAndHashtags(): void {
        $service = new FacebookPublisherService();
        $message = $service->buildMessage($this->sampleArticle);

        $this->assertStringContainsString('Secrets Millénaires des Potiers de Guellala à Djerba', $message);
        $this->assertStringContainsString('https://djerbavoyage.tn/guide/secrets-potiers-guellala-djerba', $message);
        $this->assertStringContainsString('#Djerba', $message);
        $this->assertStringContainsString('#PhotoDjerba', $message);
        $this->assertStringContainsString('Ateliers troglodytes', $message);
    }

    public function testResolveImageUrl(): void {
        $service = new FacebookPublisherService();

        $resolvedRel = $service->resolveImageUrl('images/ajim.png');
        $this->assertEquals('https://djerbavoyage.tn/images/ajim.png', $resolvedRel);

        $resolvedAbs = $service->resolveImageUrl('https://cdn.example.com/photo.jpg');
        $this->assertEquals('https://cdn.example.com/photo.jpg', $resolvedAbs);

        $this->assertNull($service->resolveImageUrl(null));
        $this->assertNull($service->resolveImageUrl(''));
    }

    public function testMissingTokenFailsGracefullyWithoutException(): void {
        $originalToken = $_ENV['FB_PAGE_ACCESS_TOKEN'] ?? null;
        $_ENV['FB_PAGE_ACCESS_TOKEN'] = '';

        $service = new FacebookPublisherService();
        $result = $service->publishArticle($this->sampleArticle);

        $this->assertFalse($result['published']);
        $this->assertStringContainsString('manquant', $result['reason']);

        if ($originalToken !== null) {
            $_ENV['FB_PAGE_ACCESS_TOKEN'] = $originalToken;
        }
    }

    public function testDisabledPublishingReturnsFalse(): void {
        $originalStatus = $_ENV['FB_AUTO_PUBLISH'] ?? null;
        $_ENV['FB_AUTO_PUBLISH'] = 'false';

        $service = new FacebookPublisherService();
        $result = $service->publishArticle($this->sampleArticle);

        $this->assertFalse($result['published']);
        $this->assertStringContainsString('désactivée', $result['reason']);

        if ($originalStatus !== null) {
            $_ENV['FB_AUTO_PUBLISH'] = $originalStatus;
        }
    }

    public function testSimulatedGraphApiPhotoSuccess(): void {
        $mockService = new class extends FacebookPublisherService {
            protected function callApi(string $url, array $params): array {
                if (str_contains($url, '/photos')) {
                    return [
                        'id'      => 'photo_999888',
                        'post_id' => '123456789_999888'
                    ];
                }
                return [];
            }
        };

        $_ENV['FB_PAGE_ACCESS_TOKEN'] = 'mock_valid_token';
        $_ENV['FB_AUTO_PUBLISH'] = 'true';

        $result = $mockService->publishArticle($this->sampleArticle);

        $this->assertTrue($result['published']);
        $this->assertEquals('photo', $result['type']);
        $this->assertEquals('123456789_999888', $result['post_id']);

        unset($_ENV['FB_PAGE_ACCESS_TOKEN']);
    }

    public function testApiErrorIsNonBlocking(): void {
        $mockService = new class extends FacebookPublisherService {
            protected function callApi(string $url, array $params): array {
                throw new \RuntimeException("Simulation panne réseau Facebook");
            }
        };

        $_ENV['FB_PAGE_ACCESS_TOKEN'] = 'mock_valid_token';
        $_ENV['FB_AUTO_PUBLISH'] = 'true';

        $result = $mockService->publishArticle($this->sampleArticle);

        $this->assertFalse($result['published']);
        $this->assertStringContainsString('Simulation panne réseau', $result['error']);

        unset($_ENV['FB_PAGE_ACCESS_TOKEN']);
    }

    public function testCustomCaptionIsUsedWhenProvided(): void {
        $capturedCaption = null;
        $mockService = new class($capturedCaption) extends FacebookPublisherService {
            public function __construct(private &$captured) {
                parent::__construct();
            }
            protected function callApi(string $url, array $params): array {
                $this->captured = $params['caption'] ?? null;
                return ['id' => 'p1', 'post_id' => 'post_123'];
            }
        };

        $_ENV['FB_PAGE_ACCESS_TOKEN'] = 'mock_valid_token';
        $_ENV['FB_AUTO_PUBLISH'] = 'true';

        $custom = "🌟 Découvrez nos secrets insolites à Djerba !\nUn conseil inédit de terrain.\nQue pensez-vous de ce spot ?";
        $res = $mockService->publishArticle($this->sampleArticle, $custom);

        $this->assertTrue($res['published']);
        $this->assertNotNull($capturedCaption);
        $this->assertStringContainsString('Découvrez nos secrets insolites', $capturedCaption);
        $this->assertStringContainsString('djerbavoyage.tn/guide/', $capturedCaption);
        $this->assertStringContainsString('#Djerba', $capturedCaption);

        unset($_ENV['FB_PAGE_ACCESS_TOKEN']);
    }

    public function testBuildMessageWithoutLinkModeHasNoUrl(): void {
        $service = new FacebookPublisherService();
        $message = $service->buildMessage($this->sampleArticle, null, 'SANS_LIEN');

        $this->assertFalse(str_contains($message, 'http://'));
        $this->assertFalse(str_contains($message, 'https://'));
        $this->assertFalse(str_contains($message, 'djerbavoyage.tn'));
        $this->assertStringContainsString('#Djerba', $message);
        $this->assertStringContainsString('commentaire', $message);

        $custom = "Un coucher de soleil magique sur la lagune d'Aghir.";
        $customMsg = $service->buildMessage($this->sampleArticle, $custom, 'SANS_LIEN');
        $this->assertFalse(str_contains($customMsg, 'http'));
        $this->assertStringContainsString('#Djerba', $customMsg);
    }

}

