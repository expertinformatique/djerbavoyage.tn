<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires pour les optimisations mobiles, filtres horizontaux et pages enrichies
 */
class MobileOptimizationsTest extends TestCase
{
    protected function setUp(): void
    {
        if (!defined('ROOT_PATH')) {
            define('ROOT_PATH', dirname(__DIR__, 2));
        }
    }

    public function testNavbarItemsHaveConsistentLinkContentStructure(): void
    {
        ob_start();
        require ROOT_PATH . '/views/partials/navbar.php';
        $html = ob_get_clean();

        // Vérifier que tous les liens ont la structure harmonisée c-navbar__link-content
        $this->assertStringContainsString('c-navbar__link-content', $html);
        $this->assertStringContainsString('c-navbar__link-icon', $html);
        $this->assertStringContainsString('fi-rr-home', $html);
        $this->assertStringContainsString('fi-rr-compass', $html);
        $this->assertStringContainsString('fi-rr-sparkles', $html);
        $this->assertStringContainsString('fi-rr-crown', $html);
        $this->assertStringContainsString('fi-rr-envelope', $html);
    }

    public function testCssIncludesSingleLineHorizontalScrollRule(): void
    {
        $mainCss = file_get_contents(ROOT_PATH . '/public/assets/css/main.css');
        $this->assertStringContainsString('.c-scroll-tabs', $mainCss);
        $this->assertStringContainsString('overflow-x: auto', $mainCss);
        $this->assertStringContainsString('flex-wrap: nowrap', $mainCss);
        $this->assertStringContainsString('scrollbar-width: none', $mainCss);

        $blogCss = file_get_contents(ROOT_PATH . '/public/assets/css/components/blog.css');
        $this->assertStringContainsString('.c-blog-filters', $blogCss);
        $this->assertStringContainsString('overflow-x: auto', $blogCss);
    }

    public function testHomeHeroHasWawShowcaseAndNonWrappingButtons(): void
    {
        $homeContent = file_get_contents(ROOT_PATH . '/views/pages/home.php');
        $this->assertStringContainsString('c-hero__showcase', $homeContent);
        $this->assertStringContainsString('djerba_mobile_hero.jpg', $homeContent);
        $this->assertStringContainsString('white-space: nowrap', $homeContent);
    }

    public function testGastronomiePageHasRichContent(): void
    {
        $content = file_get_contents(ROOT_PATH . '/views/pages/gastronomie.php');
        $this->assertStringContainsString('Couscous Djerbien au Poisson', $content);
        $this->assertStringContainsString('Le Brik Djerbien', $content);
        $this->assertStringContainsString('Ojja aux Crevettes', $content);
        $this->assertStringContainsString('Malthouth', $content);
        $this->assertStringContainsString('Makroudh', $content);
        $this->assertStringContainsString('Cornes de Gazelle', $content);
        $this->assertStringContainsString('Vente à la Criée', $content);
    }

    public function testTransportsPageHasRichContent(): void
    {
        $content = file_get_contents(ROOT_PATH . '/views/pages/transports.php');
        $this->assertStringContainsString('Taxis Jaunes Djerbiens', $content);
        $this->assertStringContainsString('Chaussée Romaine', $content);
        $this->assertStringContainsString('Bac d\'Ajim', $content);
        $this->assertStringContainsString('Tableau Récapitulatif des Transports', $content);
    }

    public function testMeteoPageHasRichContent(): void
    {
        $content = file_get_contents(ROOT_PATH . '/views/pages/meteo-climat.php');
        $this->assertStringContainsString('Printemps Fleuri', $content);
        $this->assertStringContainsString('Plein Été', $content);
        $this->assertStringContainsString('Arrière-Saison d\'Or', $content);
        $this->assertStringContainsString('Hiver Doux', $content);
        $this->assertStringContainsString('Aperçu Mensuel des Températures', $content);
    }

    public function testServicesPageHeroReducedAndHasImage(): void
    {
        $content = file_get_contents(ROOT_PATH . '/views/pages/services-builder.php');
        $this->assertStringContainsString('djerba_services_hero.jpg', $content);
        $this->assertStringContainsString('c-scroll-tabs', $content);
    }

    public function testConciergePageHasOptimizedPadding(): void
    {
        $content = file_get_contents(ROOT_PATH . '/views/pages/concierge.php');
        $this->assertStringContainsString('clamp(1.15rem, 3.5vw, 2.25rem)', $content);
    }

    public function testShopPageHasSingleLineTabsAndSafeButtons(): void
    {
        $content = file_get_contents(ROOT_PATH . '/views/pages/shop.php');
        $this->assertStringContainsString('tabs c-scroll-tabs', $content);
        $this->assertStringContainsString('w-full sm:w-auto', $content);
    }
}
