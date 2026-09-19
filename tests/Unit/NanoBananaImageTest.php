<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\NanoBananaImageService;
use App\Services\AiImageService;

class NanoBananaImageTest extends TestCase {
    private string $testSlug;
    private string $createdFilePath;

    protected function setUp(): void {
        $this->testSlug = 'test-nano-banana-' . uniqid();
        $this->createdFilePath = dirname(__DIR__, 2) . '/public/assets/images/blog/' . $this->testSlug . '.jpg';
    }

    protected function tearDown(): void {
        if (file_exists($this->createdFilePath)) {
            @unlink($this->createdFilePath);
        }
    }

    public function testPromptConstructionIncludesPhotorealisticDirectivesAndSubject(): void {
        $service = new NanoBananaImageService('test-key', 'nano-banana-pro-preview', true);
        $prompt = $service->buildPhotorealisticPrompt('Poterie traditionnelle de Guellala');

        $this->assertStringContainsString('Photorealistic DSLR photograph', $prompt);
        $this->assertStringContainsString('Poterie traditionnelle de Guellala', $prompt);
        $this->assertStringContainsString('Djerba', $prompt);
        $this->assertStringContainsString('35mm', $prompt);
        $this->assertStringContainsString('no CGI', $prompt);
        $this->assertStringContainsString('no illustration', $prompt);
    }

    public function testServiceEnabledStatus(): void {
        $enabledService = new NanoBananaImageService('valid-key', 'nano-banana-pro-preview', true);
        $this->assertTrue($enabledService->isEnabled());

        $disabledService = new NanoBananaImageService('valid-key', 'nano-banana-pro-preview', false);
        $this->assertFalse($disabledService->isEnabled());

        $noKeyService = new NanoBananaImageService('', 'nano-banana-pro-preview', true);
        $this->assertFalse($noKeyService->isEnabled());
    }

    public function testSuccessfulNanoBananaGenerationDecodesAndSavesImage(): void {
        $service = new NanoBananaImageService('valid-api-key', 'nano-banana-pro-preview', true);
        $rootPath = dirname(__DIR__, 2);

        $dummyImageData = "FAKE_JPEG_IMAGE_DATA_" . bin2hex(random_bytes(16));
        $mockPayload = json_encode([
            'candidates' => [
                [
                    'content' => [
                        'parts' => [
                            [
                                'inlineData' => [
                                    'mimeType' => 'image/jpeg',
                                    'data' => base64_encode($dummyImageData)
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $service->setHttpRequester(function ($url, $payload) use ($mockPayload) {
            return $mockPayload;
        });

        $result = $service->generate('Plage de Sidi Mahrez', $this->testSlug, $rootPath);

        $this->assertNotNull($result);
        $this->assertEquals('images/blog/' . $this->testSlug . '.jpg', $result);
        $this->assertFileExists($this->createdFilePath);
        $this->assertEquals($dummyImageData, file_get_contents($this->createdFilePath));
    }

    public function testNanoBananaGracefulFallbackOnApiError(): void {
        $service = new NanoBananaImageService('valid-api-key', 'nano-banana-pro-preview', true);
        $rootPath = dirname(__DIR__, 2);

        $errorPayload = json_encode([
            'error' => [
                'code' => 429,
                'message' => 'Quota exceeded for model nano-banana-pro-preview'
            ]
        ]);

        $service->setHttpRequester(function ($url, $payload) use ($errorPayload) {
            return $errorPayload;
        });

        $result = $service->generate('Excursion quad', $this->testSlug, $rootPath);

        $this->assertNull($result);
        $this->assertFalse(file_exists($this->createdFilePath));
    }

    public function testAiImageServiceIntegratesNanoBanana(): void {
        $nanoService = new NanoBananaImageService('dummy-key', 'nano-banana-pro-preview', true);
        $imageService = new AiImageService($nanoService);

        $this->assertTrue($nanoService === $imageService->getNanoBananaService());
    }
}
