<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';

$runnerCode = <<<'PHP'
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(60);

define('ROOT_PATH', dirname(__DIR__));
require_once __DIR__ . '/../core/helpers.php';

if (file_exists(ROOT_PATH . '/.env')) {
    foreach (file(ROOT_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos($line, '=') !== false && strpos(trim($line), '#') !== 0) {
            list($k, $v) = explode('=', $line, 2);
            putenv(trim($k) . '=' . trim($v, " \t\n\r\0\x0B\"'"));
            $_ENV[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        }
    }
}
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../src/Services/NanoBananaImageService.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    die("Missing ?id=\n");
}

$pdo = Core\Database::getInstance();
$stmt = $pdo->prepare("SELECT id, title_fr, slug, featured_image FROM articles WHERE id = ?");
$stmt->execute([$id]);
$art = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$art) {
    die("Article $id not found\n");
}

echo "Generating new unique image for Article #$id: '{$art['title_fr']}'\n";
$nano = new App\Services\NanoBananaImageService();
echo "Enabled: " . ($nano->isEnabled() ? "YES" : "NO") . " | Model: " . $nano->getModel() . "\n";
echo "GEMINI_API_KEY: " . substr($_ENV['GEMINI_API_KEY'] ?? '', 0, 8) . "\n";

$newSlug = $art['slug'] . '-ai-' . mt_rand(100, 999);
$newImg = $nano->generate($art['title_fr'], $newSlug, ROOT_PATH);

if ($newImg && file_exists(ROOT_PATH . '/public/' . $newImg)) {
    $size = filesize(ROOT_PATH . '/public/' . $newImg);
    $up = $pdo->prepare("UPDATE articles SET featured_image = ? WHERE id = ?");
    $up->execute([$newImg, $id]);
    echo "SUCCESS: Article #$id updated to $newImg ($size bytes)\n";
} else {
    echo "FAILED: Result was " . var_export($newImg, true) . "\n";
}
PHP;

$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/fix_one_article.php";

$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_UPLOAD, 1);
$tempFp = fopen('php://temp', 'r+');
fwrite($tempFp, $runnerCode);
rewind($tempFp);
curl_setopt($ch, CURLOPT_INFILE, $tempFp);
curl_setopt($ch, CURLOPT_INFILESIZE, strlen($runnerCode));
curl_exec($ch);
fclose($tempFp);
curl_close($ch);

echo "Runner uploaded. Now fixing articles 647, 646, 642, 640...\n";

foreach ([647, 646, 642, 640] as $targetId) {
    $start = microtime(true);
    $url = "https://djerbavoyage.tn/fix_one_article.php?id={$targetId}";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $res = curl_exec($ch);
    $dur = round(microtime(true) - $start, 2);
    curl_close($ch);
    echo "[$dur s] " . trim($res) . "\n";
}

// Cleanup
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/fix_one_article.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
echo "Cleaned up fix_one_article.\n";
