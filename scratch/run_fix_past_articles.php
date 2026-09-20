<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';

$runnerCode = <<<'PHP'
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(300);

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

$pdo = Core\Database::getInstance();
$nano = new App\Services\NanoBananaImageService();

// Find articles needing image correction
$stmt = $pdo->query("SELECT id, title_fr, slug, featured_image FROM articles WHERE featured_image IN ('images/ajim.png', 'images/sidi_mahres.png') OR id IN (640, 642, 646, 647) ORDER BY id DESC");
$articlesToFix = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Found " . count($articlesToFix) . " articles to verify/fix.\n";

$castleHash = 'baf521a2372656f931be82d5ec8d01c3';

foreach ($articlesToFix as $art) {
    $id = $art['id'];
    $title = $art['title_fr'];
    $slug = $art['slug'];
    $currentImg = $art['featured_image'];
    
    $fullPath = ROOT_PATH . '/public/' . ltrim($currentImg, '/');
    $isCastle = file_exists($fullPath) && md5_file($fullPath) === $castleHash;
    $isFallbackPng = in_array($currentImg, ['images/ajim.png', 'images/sidi_mahres.png', 'images/guellala.png']);
    
    if (!$isCastle && !$isFallbackPng) {
        echo "Article #$id: Image is already custom/valid ($currentImg)\n";
        continue;
    }

    echo "Fixing Article #$id ('$title')...\n";
    $newSlug = $slug . '-ai-' . mt_rand(100, 999);
    $prompt = $title;
    
    $newImgRel = $nano->generate($prompt, $newSlug, ROOT_PATH);
    if ($newImgRel && file_exists(ROOT_PATH . '/public/' . $newImgRel)) {
        $size = filesize(ROOT_PATH . '/public/' . $newImgRel);
        $updateStmt = $pdo->prepare("UPDATE articles SET featured_image = ? WHERE id = ?");
        $updateStmt->execute([$newImgRel, $id]);
        echo "  ✅ Article #$id updated: $currentImg -> $newImgRel ($size bytes)\n";
    } else {
        echo "  ❌ Failed to generate image for Article #$id\n";
    }
}
echo "Fix process completed.\n";
PHP;

$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/fix_images_runner.php";

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

echo "Uploaded image fixer to production. Running...\n";
$start = microtime(true);
$ch = curl_init("https://djerbavoyage.tn/fix_images_runner.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 180);
$out = curl_exec($ch);
$dur = round(microtime(true) - $start, 2);
curl_close($ch);

echo "Output (in {$dur}s):\n" . $out . "\n";

// Cleanup
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/fix_images_runner.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
echo "Cleaned up remote fixer.\n";
