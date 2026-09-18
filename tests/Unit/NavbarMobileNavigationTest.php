<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires pour la barre de navigation mobile et le sélecteur de locale intégré
 */
class NavbarMobileNavigationTest extends TestCase
{
    protected function setUp(): void
    {
        if (!defined('ROOT_PATH')) {
            define('ROOT_PATH', dirname(__DIR__, 2));
        }
    }

    public function testNavbarRendersMobileLocaleSwitcherInsideDrawer(): void
    {
        ob_start();
        require ROOT_PATH . '/views/partials/navbar.php';
        $html = ob_get_clean();

        // 1. Le menu tiroir principal existe
        $this->assertStringContainsString('id="mainNavMenu"', $html);

        // 2. Le sous-composant mobile de locale est présent dans le menu
        $this->assertStringContainsString('c-navbar__item--mobile-locale', $html);
        $this->assertStringContainsString('c-mobile-locale', $html);

        // 3. Les sélections de langue et devises sont présentes avec action vers /api/locale
        $this->assertStringContainsString('action="' . url('/api/locale') . '"', $html);
        $this->assertStringContainsString('name="lang" value="fr"', $html);
        $this->assertStringContainsString('name="lang" value="en"', $html);
        $this->assertStringContainsString('name="lang" value="ar"', $html);
        $this->assertStringContainsString('name="currency" value="EUR"', $html);
        $this->assertStringContainsString('name="currency" value="TND"', $html);
        $this->assertStringContainsString('name="currency" value="USD"', $html);
    }

    public function testDesktopLocaleSwitcherRenderedInActions(): void
    {
        ob_start();
        require ROOT_PATH . '/views/partials/navbar.php';
        $html = ob_get_clean();

        // Le sélecteur desktop doit être présent dans les actions
        $this->assertStringContainsString('c-locale-switcher--desktop', $html);
        $this->assertStringContainsString('id="localeSwitcher"', $html);
        $this->assertStringContainsString('id="localeTrigger"', $html);
    }

    public function testMobileCssHidesPdfButtonAndDesktopLocaleOnMobile(): void
    {
        $cssPath = ROOT_PATH . '/public/assets/css/components/mobile-nav.css';
        $this->assertFileExists($cssPath);

        $css = file_get_contents($cssPath);

        // 1. Règle mobile max-width: 992px
        $this->assertStringContainsString('@media (max-width: 992px)', $css);

        // 2. Pas de bouton PDF en mobile (.c-navbar__cta masqué)
        $this->assertTrue((bool)preg_match('/\.c-navbar__cta\s*\{\s*display:\s*none\s*!important;/s', $css));

        // 3. Pas de sélecteur desktop dans le header en mobile
        $this->assertTrue((bool)preg_match('/\.c-locale-switcher--desktop\s*\{\s*display:\s*none\s*!important;/s', $css));

        // 4. Masquage de la locale mobile sur Desktop (min-width: 993px)
        $this->assertStringContainsString('@media (min-width: 993px)', $css);
        $this->assertTrue((bool)preg_match('/\.c-navbar__item--mobile-locale\s*\{\s*display:\s*none\s*!important;/s', $css));
    }

    public function testLayoutIncludesMobileNavCss(): void
    {
        $layoutPath = ROOT_PATH . '/views/layouts/main.php';
        $this->assertFileExists($layoutPath);

        $content = file_get_contents($layoutPath);
        $this->assertStringContainsString('css/components/mobile-nav.css', $content);
    }
}
