<?php
/**
 * Script CLI Cron pour la génération d'articles de blog toutes les 15 minutes
 * Usage CLI : php bin/auto_blog_cron.php
 * Crontab sur serveur Linux/Debian :
 * Cadence 15 minutes : [star]/15 * * * * /usr/bin/php /var/www/djerbavoyage/bin/auto_blog_cron.php >> /var/log/djerba_blog.log 2>&1
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    die("Accès interdit : Ce script doit être exécuté en ligne de commande CLI uniquement.\n");
}

define('ROOT_PATH', dirname(__DIR__));

// Chargement des variables d'environnement .env
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

// Autoloader
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
use App\Repositories\PdoArticleRepository;
use App\Repositories\PdoProductRepository;
use App\Repositories\PdoLocalServiceRepository;
use App\Repositories\PdoSettingsRepository;
use App\Services\DjerbaContextFetcherService;
use App\Services\AiArticleGeneratorService;
use App\Services\SitemapService;
use App\Services\FacebookPublisherService;
use App\Services\SettingsService;
use App\Services\CacheService;

try {
    $timestamp = date('Y-m-d H:i:s');
    echo "[{$timestamp}] 🚀 Démarrage de la génération d'article de blog automatique...\n";

    $pdo = Database::getInstance();
    $articleRepo = new PdoArticleRepository($pdo);
    $productRepo = new PdoProductRepository($pdo);
    $serviceRepo = new PdoLocalServiceRepository($pdo);
    $settingsRepo = new PdoSettingsRepository($pdo);
    $cache = new CacheService();
    $settingsService = new SettingsService($settingsRepo, $cache);
    $sitemapService = new SitemapService($productRepo, $serviceRepo, $articleRepo);
    $contextFetcher = new DjerbaContextFetcherService();
    $facebookPublisher = new FacebookPublisherService($settingsService);
    $generator = new AiArticleGeneratorService($contextFetcher, $articleRepo, null, $sitemapService, $facebookPublisher);

    $article = $generator->generateAndSave();
    $fbResult = $generator->getLastFacebookResult();

    echo "[{$timestamp}] ✅ Succès ! Article #{$article->id} généré et publié.\n";
    echo "  - Titre : {$article->titleFr}\n";
    echo "  - Slug : {$article->slug}\n";
    echo "  - Image : {$article->featuredImage}\n";
    echo "  - Sitemap : public/sitemap.xml synchronisé avec succès\n";
    if (!empty($fbResult['published'])) {
        echo "  - Facebook : ✅ Publié avec succès (ID: {$fbResult['post_id']})\n";
    } else {
        $reason = $fbResult['reason'] ?? ($fbResult['error'] ?? 'Non publié');
        echo "  - Facebook : ℹ️ Non partagé ({$reason})\n";
    }

} catch (\Throwable $e) {
    $timestamp = date('Y-m-d H:i:s');
    echo "[{$timestamp}] ❌ ERREUR lors de la génération : " . $e->getMessage() . "\n";
    @error_log("[{$timestamp}] ERROR AutoBlogCron: " . $e->getMessage() . PHP_EOL, 3, ROOT_PATH . '/error.log');
    exit(1);
}
