<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Database;
use App\Models\Article;
use App\Repositories\PdoArticleRepository;

class ArticlesAdminTest extends TestCase {
    private \PDO $pdo;
    private PdoArticleRepository $articleRepo;

    protected function setUp(): void {
        $this->pdo = Database::getInstance();
        $this->articleRepo = new PdoArticleRepository($this->pdo);

        // Réinitialiser la table articles pour un test prévisible
        $this->pdo->exec("DELETE FROM articles");

        $this->pdo->exec("
            INSERT INTO articles (id, slug, title_fr, content_fr, status, views_count, published_at, featured_image, author_name)
            VALUES 
            (1, 'plages-djerba', 'Les plus belles plages de Djerba', '<p>Contenu plages</p>', 'published', 150, CURRENT_TIMESTAMP, 'sidi_mahres.png', 'Rédaction'),
            (2, 'djerbahood-street-art', 'Guide Djerbahood Street Art', '<p>Contenu Djerbahood</p>', 'published', 80, CURRENT_TIMESTAMP, 'djerbahood.png', 'Rédaction'),
            (3, 'brouillon-sahara', 'Brouillon Excursion Sahara', '<p>Brouillon</p>', 'draft', 0, CURRENT_TIMESTAMP, 'desert_camp.png', 'Rédaction')
        ");
    }

    public function testGetStatsCalculation() {
        $stats = $this->articleRepo->getStats();
        $this->assertEquals(3, $stats['total_count']);
        $this->assertEquals(2, $stats['published_count']);
        $this->assertEquals(1, $stats['draft_count']);
        $this->assertEquals(230, $stats['total_views']);
    }

    public function testGetPaginatedWithStatusFilter() {
        // Filtrer uniquement les articles publiés
        $pub = $this->articleRepo->getPaginated(1, 10, '', 'published');
        $this->assertEquals(2, $pub['total']);

        // Filtrer uniquement les brouillons
        $drafts = $this->articleRepo->getPaginated(1, 10, '', 'draft');
        $this->assertEquals(1, $drafts['total']);
        $this->assertEquals('brouillon-sahara', $drafts['items'][0]->slug);
    }

    public function testGetPaginatedWithSearch() {
        $res = $this->articleRepo->getPaginated(1, 10, 'plages');
        $this->assertEquals(1, $res['total']);
        $this->assertEquals('plages-djerba', $res['items'][0]->slug);
    }

    public function testCreateAndEditArticle() {
        $newArt = new Article(
            slug: 'nouveau-guide-test',
            titleFr: 'Nouveau Guide Test 2026',
            contentFr: '<p>Contenu test</p>',
            status: 'draft',
            featuredImage: 'guellala.png'
        );

        $saved = $this->articleRepo->save($newArt);
        $this->assertNotNull($saved->id);

        $retrieved = $this->articleRepo->findById($saved->id);
        $this->assertNotNull($retrieved);
        $this->assertEquals('Nouveau Guide Test 2026', $retrieved->titleFr);
        $this->assertEquals('draft', $retrieved->status);

        // Mettre à jour en publié
        $retrieved->status = 'published';
        $retrieved->titleFr = 'Guide Test Modifié';
        $updated = $this->articleRepo->save($retrieved);
        $this->assertEquals('Guide Test Modifié', $updated->titleFr);

        $stats = $this->articleRepo->getStats();
        $this->assertEquals(4, $stats['total_count']);
    }

    public function testDeleteArticle() {
        $ok = $this->articleRepo->delete(3);
        $this->assertTrue($ok);
        $this->assertNull($this->articleRepo->findById(3));
        $this->assertEquals(2, $this->articleRepo->countAll());
    }
}
