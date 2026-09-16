<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Database;
use App\Models\Article;
use App\Repositories\PdoArticleRepository;
use App\Services\DjerbaContextFetcherService;
use App\Services\AiArticleGeneratorService;
use App\Services\ArticlePdfService;

class AutoBlogTest extends TestCase {
    private \PDO $pdo;
    private PdoArticleRepository $repo;

    protected function setUp(): void {
        $this->pdo = Database::getInstance();
        $this->pdo->exec("DELETE FROM articles WHERE slug LIKE 'test-%' OR slug LIKE 'djerba-%'");
        $this->repo = new PdoArticleRepository($this->pdo);
    }

    public function testContextFetcherReturnsValidData(): void {
        $fetcher = new DjerbaContextFetcherService();
        $ctx = $fetcher->getContext();

        $this->assertTrue(array_key_exists('weather', $ctx));
        $this->assertTrue(array_key_exists('angle', $ctx));
        $this->assertTrue(array_key_exists('temp_c', $ctx['weather']));
        $this->assertNotNull($ctx['weather']['temp_c']);
    }

    public function testArticleRepositorySaveAndRetrieve(): void {
        $article = new Article(
            id: null,
            destinationId: 1,
            slug: 'test-article-' . time(),
            titleFr: 'Titre de Test Djerba',
            contentFr: '<p>Contenu de test pour Djerba.</p>',
            featuredImage: 'https://example.com/image.jpg',
            status: 'published',
            seoDescription: 'Description de test',
            summaryAi: 'Résumé IA de test'
        );

        $saved = $this->repo->save($article);
        $this->assertNotNull($saved->id);

        $fetched = $this->repo->findBySlug($saved->slug);
        $this->assertNotNull($fetched);
        $this->assertEquals('Titre de Test Djerba', $fetched->titleFr);
        $this->assertEquals('Description de test', $fetched->seoDescription);

        // Delete test
        $deleted = $this->repo->delete($saved->id);
        $this->assertTrue($deleted);
        $this->assertNull($this->repo->findBySlug($saved->slug));
    }

    public function testAiArticleGeneratorCreatesAndSavesArticle(): void {
        $fetcher = new DjerbaContextFetcherService();
        $generator = new AiArticleGeneratorService($fetcher, $this->repo);

        $article = $generator->generateAndSave();

        $this->assertNotNull($article->id);
        $this->assertNotEmpty($article->titleFr);
        $this->assertNotEmpty($article->slug);
        $this->assertNotEmpty($article->featuredImage);
        $this->assertNotNull($article->summaryAi);

        // Cleanup
        $this->repo->delete($article->id);
    }

    public function testPdfServiceGeneratesValidHtml(): void {
        $article = new Article(
            id: 999,
            slug: 'test-pdf-slug',
            titleFr: 'Guide PDF Djerba Test',
            contentFr: '<h2>Chapitre 1</h2><p>Excursion désert Ksar Ghilane.</p>',
            authorName: 'Rédacteur IA'
        );

        $pdfService = new ArticlePdfService();
        $html = $pdfService->generateHtmlForPdf($article);

        $this->assertTrue(str_contains($html, 'Guide Djerba — Guide PDF Djerba Test'));
        $this->assertTrue(str_contains($html, 'Excursion désert Ksar Ghilane.'));
        $this->assertTrue(str_contains($html, 'Imprimer / Sauvegarder en PDF'));
    }

    public function testAiImageServiceMatchesArticleTheme(): void {
        $imageService = new \App\Services\AiImageService();
        $desertContext = [
            'angle' => [
                'theme' => 'Excursion Désert, Buggy & Quad depuis Djerba',
                'image_prompt' => 'Exciting desert quad bike adventure in golden sand dunes',
                'fallback_local_image' => 'images/service_quad.jpg'
            ]
        ];

        $kitesurfContext = [
            'angle' => [
                'theme' => 'Kitesurf, Jet Ski & Sports Nautiques',
                'image_prompt' => 'Action photography of kitesurfers on shallow turquoise lagoon',
                'fallback_local_image' => 'images/service_kitesurf.jpg'
            ]
        ];

        $imgDesert = $imageService->generateForArticle('quad in desert dunes', 'slug-desert-1', $desertContext);
        $imgKitesurf = $imageService->generateForArticle('kitesurf on turquoise lagoon', 'slug-kitesurf-1', $kitesurfContext);

        $this->assertEquals('images/service_quad.jpg', $imgDesert);
        $this->assertEquals('images/service_kitesurf.jpg', $imgKitesurf);
        $this->assertNotEquals($imgDesert, $imgKitesurf);
    }
}
