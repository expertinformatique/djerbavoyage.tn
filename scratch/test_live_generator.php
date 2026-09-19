<?php
define('ROOT_PATH', dirname(__DIR__));

if (file_exists(ROOT_PATH . '/.env')) {
    $envLines = file(ROOT_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($name, $val) = explode('=', $line, 2);
            $_ENV[trim($name)] = trim($val, " \t\n\r\0\x0B\"'");
            putenv(trim($name) . "=" . trim($val, " \t\n\r\0\x0B\"'"));
        }
    }
}

spl_autoload_register(function ($class) {
    $prefixApp = 'App\\';
    $prefixCore = 'Core\\';
    $baseDir = dirname(__DIR__) . '/';
    if (strpos($class, $prefixApp) === 0) {
        $file = $baseDir . 'src/' . str_replace('\\', '/', substr($class, strlen($prefixApp))) . '.php';
        if (file_exists($file)) require_once $file;
    } else if (strpos($class, $prefixCore) === 0) {
        $file = $baseDir . 'core/' . str_replace('\\', '/', substr($class, strlen($prefixCore))) . '.php';
        if (file_exists($file)) require_once $file;
    }
});

use Core\Database;
use App\Repositories\PdoArticleRepository;
use App\Services\DjerbaContextFetcherService;
use App\Services\AiArticleGeneratorService;
use App\Services\AiImageService;

$pdo = Database::getInstance();
$repo = new PdoArticleRepository($pdo);
$fetcher = new DjerbaContextFetcherService();
$imageService = new AiImageService();
$generator = new AiArticleGeneratorService($fetcher, $repo, $imageService);

echo "Generating live article with Gemini...\n";
$start = microtime(true);
$article = $generator->generateAndSave();
$duration = round(microtime(true) - $start, 2);

echo "✅ Generated in {$duration}s\n";
echo "ID: " . $article->id . "\n";
echo "TITLE: " . $article->titleFr . "\n";
echo "SLUG: " . $article->slug . "\n";
echo "IMAGE: " . $article->featuredImage . "\n";
echo "WORD COUNT: " . str_word_count(strip_tags($article->contentFr)) . "\n";
echo "HAS TABLE: " . (str_contains($article->contentFr, '<table') ? 'YES' : 'NO') . "\n";
echo "HAS BLOCKQUOTE: " . (str_contains($article->contentFr, '<blockquote') ? 'YES' : 'NO') . "\n";
echo "HAS FAQ: " . (str_contains($article->contentFr, 'c-article-faq') || str_contains($article->contentFr, 'question') || str_contains($article->contentFr, 'FAQ') ? 'YES' : 'NO') . "\n";
$linkCount = preg_match_all('/href="([^"]+)"/', $article->contentFr, $m);
echo "INTERNAL LINKS ({$linkCount}):\n";
if (!empty($m[1])) {
    foreach ($m[1] as $lnk) {
        echo "  -> $lnk\n";
    }
}
