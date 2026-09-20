<?php
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
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
use App\Models\Article;
use App\Repositories\PdoArticleRepository;
use App\Services\DjerbaContextFetcherService;
use App\Services\AiArticleGeneratorService;

$pdo = Database::getInstance();
$repo = new PdoArticleRepository($pdo);
$fetcher = new DjerbaContextFetcherService();
$generator = new AiArticleGeneratorService($fetcher, $repo);

echo "Generating live multilingual article...\n";
$article = $generator->generateAndSave();

echo "ID: {$article->id}\n";
echo "Slug: {$article->slug}\n";
echo "Title FR: {$article->titleFr}\n";
echo "Title EN: {$article->titleEn}\n";
echo "Title AR: {$article->titleAr}\n";
echo "Content FR Length: " . strlen($article->contentFr) . " chars\n";
echo "Content EN Length: " . strlen($article->contentEn ?? '') . " chars\n";
echo "Content AR Length: " . strlen($article->contentAr ?? '') . " chars\n";
echo "Available Languages: " . implode(', ', $article->getAvailableLanguages()) . "\n";

// Test getTitle for all locales
echo "getTitle('fr'): " . $article->getTitle('fr') . "\n";
echo "getTitle('en'): " . $article->getTitle('en') . "\n";
echo "getTitle('ar'): " . $article->getTitle('ar') . "\n";

// Cleanup test article
$repo->delete($article->id);
echo "\n✅ Test live multilingual generation completed successfully!\n";
