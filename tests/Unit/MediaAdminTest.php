<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Controllers\Admin\MediaAdminController;

class MediaAdminTest extends TestCase {

    private MediaAdminController $controller;

    protected function setUp(): void {
        $this->controller = new MediaAdminController();
    }

    public function testScanMediaFilesIncludesBlogImages() {
        $images = $this->controller->scanMediaFiles('images');

        $this->assertNotEmpty($images, "La liste des images ne doit pas être vide.");

        $blogImages = array_filter($images, fn($img) => $img['folder'] === 'blog');
        $siteImages = array_filter($images, fn($img) => $img['folder'] === 'site');

        $this->assertNotEmpty($blogImages, "Le gestionnaire doit trouver des images dans /images/blog/.");
        $this->assertNotEmpty($siteImages, "Le gestionnaire doit trouver des images dans /images/.");

        // Vérifier le formatage d'URL pour le blog (/images/blog/...)
        $firstBlog = reset($blogImages);
        $this->assertTrue(str_starts_with($firstBlog['url'], '/images/blog/'), "L'URL doit commencer par /images/blog/");
        $this->assertTrue(str_starts_with($firstBlog['path'], 'blog/'), "Le path doit commencer par blog/");
        $this->assertTrue($firstBlog['deletable']);

        // Vérifier le formatage d'URL pour le site (/images/...)
        $firstSite = reset($siteImages);
        $this->assertTrue(str_starts_with($firstSite['url'], '/images/'), "L'URL doit commencer par /images/");
        $this->assertFalse($firstSite['deletable']);
    }

    public function testScanMediaFilesIgnoresProtectedFiles() {
        $images = $this->controller->scanMediaFiles('images');
        $names = array_column($images, 'name');

        $this->assertFalse(in_array('index.php', $names, true), "index.php ne doit pas apparaître comme image.");
        $this->assertFalse(in_array('.htaccess', $names, true), ".htaccess ne doit pas apparaître comme image.");
        $this->assertFalse(in_array('.gitkeep', $names, true), ".gitkeep ne doit pas apparaître comme image.");
    }

    public function testImageDirectoryProtectionAndAntiHotlinkConfigExists() {
        $rootPath = dirname(__DIR__, 2);

        // 1. Vérifier le .htaccess de protection dans public/assets/images/
        $imagesHtaccess = $rootPath . '/public/assets/images/.htaccess';
        $this->assertFileExists($imagesHtaccess);
        $htaccessContent = file_get_contents($imagesHtaccess);

        $this->assertStringContainsString('Options -Indexes', $htaccessContent);
        $this->assertStringContainsString('HTTP_REFERER', $htaccessContent);
        $this->assertStringContainsString('djerbavoyage.tn', $htaccessContent);
        $this->assertStringContainsString('google', $htaccessContent);
        $this->assertStringContainsString('facebook', $htaccessContent);

        // 2. Vérifier les index.php protecteurs
        $imagesIndex = $rootPath . '/public/assets/images/index.php';
        $blogIndex   = $rootPath . '/public/assets/images/blog/index.php';
        $this->assertFileExists($imagesIndex);
        $this->assertFileExists($blogIndex);

        $this->assertStringContainsString('403', file_get_contents($imagesIndex));
        $this->assertStringContainsString('403', file_get_contents($blogIndex));
    }
}
