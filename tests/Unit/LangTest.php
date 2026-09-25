<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires pour Core\Lang
 */
class LangTest extends TestCase
{
    protected function setUp(): void
    {
        if (!defined('ROOT_PATH')) {
            define('ROOT_PATH', dirname(__DIR__, 2));
        }
        // Réinitialiser la classe Lang entre les tests via Reflection
        $reflection = new \ReflectionClass(\Core\Lang::class);

        $localeProp = $reflection->getProperty('locale');
        $localeProp->setAccessible(true);
        $localeProp->setValue(null, 'fr');

        $msgProp = $reflection->getProperty('messages');
        $msgProp->setAccessible(true);
        $msgProp->setValue(null, []);
    }

    public function testDefaultLocaleIsFr(): void
    {
        $this->assertEquals('fr', \Core\Lang::getLocale());
    }

    public function testSetLocaleFr(): void
    {
        \Core\Lang::setLocale('fr');
        $this->assertEquals('fr', \Core\Lang::getLocale());
    }

    public function testSetLocaleEn(): void
    {
        \Core\Lang::setLocale('en');
        $this->assertEquals('en', \Core\Lang::getLocale());
    }

    public function testSetLocaleAr(): void
    {
        \Core\Lang::setLocale('ar');
        $this->assertEquals('ar', \Core\Lang::getLocale());
    }

    public function testInvalidLocaleFallsBackToFr(): void
    {
        \Core\Lang::setLocale('de'); // non supporté
        $this->assertEquals('fr', \Core\Lang::getLocale());
    }

    public function testDirIsLtrForFr(): void
    {
        \Core\Lang::setLocale('fr');
        $this->assertEquals('ltr', \Core\Lang::getDir());
    }

    public function testDirIsRtlForAr(): void
    {
        \Core\Lang::setLocale('ar');
        $this->assertEquals('rtl', \Core\Lang::getDir());
    }

    public function testIsRtlFalseForEn(): void
    {
        \Core\Lang::setLocale('en');
        $this->assertEquals(false, \Core\Lang::isRtl());
    }

    public function testTranslationLoadsFrench(): void
    {
        \Core\Lang::setLocale('fr');
        $result = \Core\Lang::t('nav.home');
        $this->assertEquals('Accueil', $result);
    }

    public function testTranslationLoadsEnglish(): void
    {
        \Core\Lang::setLocale('en');
        $result = \Core\Lang::t('nav.home');
        $this->assertEquals('Home', $result);
    }

    public function testTranslationLoadsArabic(): void
    {
        \Core\Lang::setLocale('ar');
        $result = \Core\Lang::t('nav.home');
        $this->assertEquals('الرئيسية', $result);
    }

    public function testMissingKeyReturnsSelf(): void
    {
        \Core\Lang::setLocale('fr');
        $result = \Core\Lang::t('clé.inexistante');
        $this->assertEquals('clé.inexistante', $result);
    }

    public function testPlaceholderReplacement(): void
    {
        \Core\Lang::setLocale('fr');
        $result = \Core\Lang::t('footer.copyright', ['year' => '2026', 'name' => 'Djerba Voyage']);
        $this->assertEquals('© 2026 Djerba Voyage. Tous droits réservés.', $result);
    }

    public function testNativeName(): void
    {
        $this->assertEquals('Français', \Core\Lang::nativeName('fr'));
        $this->assertEquals('English', \Core\Lang::nativeName('en'));
        $this->assertEquals('العربية', \Core\Lang::nativeName('ar'));
    }

    public function testSupportedLocales(): void
    {
        $supported = \Core\Lang::supported();
        $this->assertIsArray($supported);
        $this->assertContains('fr', $supported);
        $this->assertContains('en', $supported);
        $this->assertContains('ar', $supported);
    }

    public function testCriticalKeysExistInAllLanguages(): void
    {
        $criticalKeys = [
            'nav.home', 'nav.activities', 'nav.destinations', 'nav.shop', 'nav.concierge',
            'hero.title', 'hero.subtitle', 'home.destinations_badge', 'home.concierge_badge',
            'activities.hero_title', 'itineraries.hero_title', 'hotels_restos.title',
            'blog_list.title', 'blog_single.badge_official', 'shop.title',
            'pdf_modal.badge', 'booking_modal.title', 'quiz.badge', 'quiz_lead.badge',
            'newsletter.title', 'about.hero_title', 'faq.title', 'reviews.title',
            'contact.title', 'footer.description'
        ];

        foreach (['fr', 'en', 'ar'] as $loc) {
            \Core\Lang::setLocale($loc);
            foreach ($criticalKeys as $k) {
                $trans = \Core\Lang::t($k);
                $this->assertNotEquals($k, $trans, "La clé '{$k}' n'est pas traduite pour la langue '{$loc}'");
                $this->assertNotEmpty($trans);
            }
        }
    }

    public function testFlagHtmlOutput(): void
    {
        $frFlag = \Core\Lang::flag('fr');
        $this->assertStringContainsString('<img', $frFlag);
        $this->assertStringContainsString('class="c-flag"', $frFlag);
        $this->assertStringContainsString('fr.svg', $frFlag);

        $enFlag = \Core\Lang::flag('en');
        $this->assertStringContainsString('en.svg', $enFlag);

        $arFlag = \Core\Lang::flag('ar');
        $this->assertStringContainsString('ar.svg', $arFlag);
    }

    public function testFlagUrlOutput(): void
    {
        $this->assertStringContainsString('flags/fr.svg', \Core\Lang::flagUrl('fr'));
        $this->assertStringContainsString('flags/en.svg', \Core\Lang::flagUrl('en'));
        $this->assertStringContainsString('flags/ar.svg', \Core\Lang::flagUrl('ar'));
    }

    public function testFlagEmojiOutput(): void
    {
        $this->assertEquals('🇫🇷', \Core\Lang::flagEmoji('fr'));
        $this->assertEquals('🇬🇧', \Core\Lang::flagEmoji('en'));
        $this->assertEquals('🇹🇳', \Core\Lang::flagEmoji('ar'));
    }
}

