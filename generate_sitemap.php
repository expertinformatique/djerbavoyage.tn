<?php
/**
 * Script de génération du Sitemap XML et robots.txt pour Google
 * Usage CLI : php generate_sitemap.php
 */

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__);
}

if (file_exists(ROOT_PATH . '/.env')) {
    $envLines = file(ROOT_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($name, $val) = explode('=', $line, 2);
            $name = trim($name);
            $val = trim($val, " \t\n\r\0\x0B\"'");
            $_ENV[$name] = $val;
            putenv("{$name}={$val}");
        }
    }
}

require_once ROOT_PATH . '/core/helpers.php';

spl_autoload_register(function ($class) {
    $prefixApp  = 'App\\';
    $prefixCore = 'Core\\';
    $baseDir    = ROOT_PATH . '/';

    if (strpos($class, $prefixApp) === 0) {
        $relativeClass = substr($class, strlen($prefixApp));
        $file = $baseDir . 'src/' . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($file)) require_once $file;
    } else if (strpos($class, $prefixCore) === 0) {
        $relativeClass = substr($class, strlen($prefixCore));
        $file = $baseDir . 'core/' . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($file)) require_once $file;
    }
});

use Core\Database;
use App\Repositories\PdoProductRepository;
use App\Repositories\PdoLocalServiceRepository;
use App\Repositories\PdoArticleRepository;
use App\Services\SitemapService;

try {
    $pdo = Database::getInstance();
    $productRepo = new PdoProductRepository($pdo);
    $serviceRepo = new PdoLocalServiceRepository($pdo);
    $articleRepo = new PdoArticleRepository($pdo);

    $sitemapService = new SitemapService($productRepo, $serviceRepo, $articleRepo);
    $domain = 'https://djerbavoyage.tn';

    if ($sitemapService->regenerateFile($domain)) {
        $sitemapFile = ROOT_PATH . '/public/sitemap.xml';
        $robotsFile  = ROOT_PATH . '/public/robots.txt';
        $sitemapSize = file_exists($sitemapFile) ? filesize($sitemapFile) : 0;
        $robotsSize  = file_exists($robotsFile) ? filesize($robotsFile) : 0;

        echo "✅ sitemap.xml généré avec succès dans public/sitemap.xml ({$sitemapSize} octets)\n";
        echo "✅ robots.txt généré avec succès dans public/robots.txt ({$robotsSize} octets)\n";
    } else {
        throw new \Exception("Échec de l'écriture des fichiers sitemap.xml ou robots.txt");
    }
} catch (\Throwable $e) {
    echo "❌ Erreur lors de la génération du sitemap : " . $e->getMessage() . "\n";
    exit(1);
}
