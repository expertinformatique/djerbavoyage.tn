<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ContentQueueService;
use App\Services\TextImageBannerService;

class ContentQueueServiceTest extends TestCase {
    private string $tempFile;
    private ContentQueueService $service;

    protected function setUp(): void {
        $this->tempFile = sys_get_temp_dir() . '/test_queue_' . uniqid() . '.json';
        $this->service = new ContentQueueService($this->tempFile);
    }

    protected function tearDown(): void {
        if (file_exists($this->tempFile)) {
            @unlink($this->tempFile);
        }
    }

    public function testAddAndRetrieveTopic(): void {
        $topic = $this->service->addTopic("Plongée à Djerba", 2, "bot_kitesurf_activites", "plongée, mer");
        $this->assertNotEmpty($topic['id']);
        $this->assertEquals("Plongée à Djerba", $topic['title']);
        $this->assertEquals(2, $topic['max_uses']);
        $this->assertEquals(0, $topic['uses_count']);
        $this->assertEquals("active", $topic['status']);

        $next = $this->service->getNextAvailableTopic("bot_kitesurf_activites");
        $this->assertNotNull($next);
        $this->assertEquals($topic['id'], $next['id']);
    }

    public function testIncrementUsageAndExhaustion(): void {
        $topic = $this->service->addTopic("Excursion Chameau", 1);
        $this->assertTrue($this->service->incrementTopicUsage($topic['id']));

        // Devrait être épuisé
        $next = $this->service->getNextAvailableTopic();
        $this->assertNull($next);

        // Reset
        $this->assertTrue($this->service->resetUsage('topic', $topic['id']));
        $nextAfterReset = $this->service->getNextAvailableTopic();
        $this->assertNotNull($nextAfterReset);
        $this->assertEquals(0, $nextAfterReset['uses_count']);
    }

    public function testAddAndRetrieveImage(): void {
        $img = $this->service->addImage("https://example.com/photo.jpg", "Photo Djerbahood", 3);
        $this->assertNotEmpty($img['id']);
        $this->assertEquals(3, $img['max_uses']);

        $next = $this->service->getNextAvailableImage();
        $this->assertNotNull($next);
        $this->assertEquals("https://example.com/photo.jpg", $next['image_url']);

        $this->assertTrue($this->service->incrementImageUsage($img['id']));
        $q = $this->service->loadQueue();
        $this->assertEquals(1, $q['images'][0]['uses_count']);
    }

    public function testBatchAddTopicsAndImages(): void {
        $topics = ["Sujet 1", "Sujet 2", "Sujet 3"];
        $added = $this->service->batchAddTopics($topics, 1);
        $this->assertEquals(3, $added);

        $images = ["https://site.com/1.jpg", "https://site.com/2.jpg"];
        $addedImgs = $this->service->batchAddImages($images, 2);
        $this->assertEquals(2, $addedImgs);

        $stats = $this->service->getStats();
        $this->assertEquals(3, $stats['total_topics']);
        $this->assertEquals(2, $stats['total_images']);
    }

    public function testDeleteItem(): void {
        $topic = $this->service->addTopic("A supprimer", 1);
        $this->assertTrue($this->service->deleteItem('topic', $topic['id']));

        $q = $this->service->loadQueue();
        $this->assertCount(0, $q['topics']);
    }

    public function testCategorizedTopicsAndBotFiltering(): void {
        $tPatrimoine = $this->service->addTopic("Synagogue de la Ghriba", 2, "all", "histoire", "", "patrimoine");
        $tPlages = $this->service->addTopic("Kitesurf à Ras Rmel", 2, "all", "mer", "", "plages");
        $tGastro = $this->service->addTopic("Brik à l'oeuf et Couscous", 2, "all", "cuisine", "", "gastronomie");

        $this->assertEquals('patrimoine', $tPatrimoine['category']);
        $this->assertEquals('plages', $tPlages['category']);
        $this->assertEquals('gastronomie', $tGastro['category']);

        // Bot avec seulement 'plages'
        $nextForPlagesBot = $this->service->getNextAvailableTopic(null, ['plages']);
        $this->assertNotNull($nextForPlagesBot);
        $this->assertEquals($tPlages['id'], $nextForPlagesBot['id']);

        // Bot avec 'patrimoine' et 'gastronomie'
        $nextForCultureBot = $this->service->getNextAvailableTopic(null, ['patrimoine', 'gastronomie']);
        $this->assertNotNull($nextForCultureBot);
        $this->assertEquals($tPatrimoine['id'], $nextForCultureBot['id']);

        // Bot avec 'all'
        $nextForAll = $this->service->getNextAvailableTopic(null, ['all']);
        $this->assertNotNull($nextForAll);
    }

    public function testCategorizedImagesAndBotFiltering(): void {
        $imgPlage = $this->service->addImage("https://example.com/kitesurf.jpg", "Kitesurf Photo", 2, "all", "reference", "plages");
        $imgHotel = $this->service->addImage("https://example.com/menzel.jpg", "Menzel Photo", 2, "all", "reference", "hebergements");

        $this->assertEquals('plages', $imgPlage['category']);
        $this->assertEquals('hebergements', $imgHotel['category']);

        // Bot restreint aux hébergements
        $nextImg = $this->service->getNextAvailableImage(null, ['hebergements']);
        $this->assertNotNull($nextImg);
        $this->assertEquals($imgHotel['id'], $nextImg['id']);

        // Bot avec chaîne séparée par virgule "plages,excursions"
        $nextImgPlage = $this->service->getNextAvailableImage(null, "plages,excursions");
        $this->assertNotNull($nextImgPlage);
        $this->assertEquals($imgPlage['id'], $nextImgPlage['id']);
    }

    public function testBannerServiceGeneratesImage(): void {
        $bannerService = new TextImageBannerService();
        $relPath = $bannerService->generateBanner("Les Secrets d'Erriadh à Djerba", "Patrimoine");
        $this->assertNotEmpty($relPath);
        $this->assertStringContainsString('assets/images/banners/', $relPath);

        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        $fullPath = $rootPath . '/public/' . $relPath;
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }
}
