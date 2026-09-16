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

    public function testCleanTitleRemovesHourAndPrefixesAndKeepsDjerbaKeyword(): void {
        $fetcher = new DjerbaContextFetcherService();
        $generator = new AiArticleGeneratorService($fetcher, $this->repo);

        $input1 = "Djerba ce jour (22:00) : Excursion Désert, Buggy & Quad depuis Djerba sous 31°C";
        $clean1 = $generator->cleanTitle($input1);
        $this->assertEquals("Excursion Désert, Buggy & Quad depuis Djerba sous 31°C", $clean1);
        $this->assertFalse(str_contains($clean1, '22:00'));
        $this->assertFalse(str_contains($clean1, 'ce jour'));
        $this->assertTrue((bool) preg_match('/djerba/i', $clean1));

        $input2 = "Djerba : Météo, Plages & Baignade à Djerba sous 27°C";
        $clean2 = $generator->cleanTitle($input2);
        $this->assertEquals("Météo, Plages & Baignade à Djerba sous 27°C", $clean2);

        $input3 = "Évasion à Djerba : Kitesurf et Jet Ski sous 28°C";
        $clean3 = $generator->cleanTitle($input3);
        $this->assertTrue((bool) preg_match('/djerba/i', $clean3));
        $this->assertFalse(str_starts_with($clean3, 'Évasion à Djerba :'));

        $input4 = "Kitesurf, Jet Ski & Sports Nautiques sous 28°C";
        $clean4 = $generator->cleanTitle($input4);
        $this->assertEquals("Kitesurf, Jet Ski & Sports Nautiques sous 28°C à Djerba", $clean4);
    }

    public function testStoryFallbackGeneratesRichNarrativeWithHistoryAndTraditions(): void {
        $fallbackService = new \App\Services\DjerbaStoryFallbackService();
        $context = [
            'weather' => ['temp_c' => 28, 'condition' => 'Ensoleillé', 'wind_speed' => 15],
            'angle' => [
                'theme' => 'Secrets Millénaires des Potiers de Guellala à Djerba',
                'keywords' => ['potiers guellala', 'argile souterraine', 'amphores', 'artisanat djerba'],
                'suggested_services' => ['visite-guidee-djerba'],
                'image_prompt' => 'Artisan potter shaping clay in cave workshop Guellala Djerba',
                'fallback_local_image' => 'images/guellala.png'
            ]
        ];

        $article = $fallbackService->generate($context);

        $this->assertNotEmpty($article['title_fr']);
        $this->assertTrue((bool) preg_match('/guellala/i', $article['title_fr']));
        $this->assertTrue(str_contains($article['content_fr'], 'Guellala'));
        $this->assertTrue(str_contains($article['content_fr'], '<blockquote>'));
        $this->assertTrue(str_contains($article['content_fr'], 'argile'));
        $this->assertTrue(str_contains($article['content_fr'], 'c-article-tip'));
    }

    public function testAiImageServiceMatchesAllNarrativeThemesAccurately(): void {
        $imageService = new \App\Services\AiImageService();

        $cases = [
            ['prompt' => 'pottery workshop with artisan hands shaping clay', 'expected' => 'images/guellala.png'],
            ['prompt' => 'fishing boats with sponges on stone quay in port', 'expected' => 'images/ajim.png'],
            ['prompt' => 'street art mural on whitewashed wall in Erriadh', 'expected' => 'images/djerbahood.png'],
            ['prompt' => 'fish auction market with fresh seafood platter', 'expected' => 'images/houmt_souk.png'],
            ['prompt' => 'quad expedition riding desert dunes at sunset', 'expected' => 'images/service_quad.jpg'],
            ['prompt' => 'kitesurfing over turquoise shallow waters', 'expected' => 'images/service_kitesurf.jpg'],
            ['prompt' => 'traditional menzel courtyard with white domes', 'expected' => 'images/concierge.png'],
        ];

        foreach ($cases as $c) {
            $matched = $imageService->resolveThemeImage($c['prompt'], ['angle' => ['fallback_local_image' => 'images/sidi_mahres.png']]);
            $this->assertEquals($c['expected'], $matched, "Failed for prompt: {$c['prompt']}");
        }
    }
}
