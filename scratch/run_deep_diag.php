<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';

$runnerCode = <<<'PHP'
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ROOT_PATH', dirname(__DIR__));
require_once __DIR__ . '/../core/helpers.php';

// 1. Check Gemini
$apiKey = '';
if (file_exists(ROOT_PATH . '/.env')) {
    foreach (file(ROOT_PATH . '/.env') as $l) {
        if (strpos($l, 'GEMINI_API_KEY=') === 0) {
            $apiKey = trim(substr($l, strlen('GEMINI_API_KEY=')));
        }
    }
}

echo "=== 1. Test Gemini Models ===\n";
$models = ['nano-banana-pro-preview', 'gemini-2.5-flash-image'];
foreach ($models as $m) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$m}:generateContent?key=" . $apiKey;
    $payload = json_encode([
        'contents' => [['parts' => [['text' => 'A photo of Djerba beach']]]],
        'generationConfig' => ['responseModalities' => ['IMAGE']]
    ]);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);
    echo "Model $m => HTTP $code (Err: $err)\n";
    $json = json_decode($res, true);
    if (isset($json['error'])) {
        echo "  Error: " . ($json['error']['message'] ?? '') . "\n";
    }
}

echo "\n=== 2. Test Pollinations / Flux ===\n";
$seed = mt_rand(1000, 99999);
$pollUrl = "https://image.pollinations.ai/prompt/" . rawurlencode("Photorealistic photo of kitesurf in Djerba (seed {$seed})") . "?seed=" . $seed;
echo "URL: $pollUrl\n";
$start = microtime(true);
$ch = curl_init($pollUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$bin = curl_exec($ch);
$pCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$pErr = curl_error($ch);
$pDur = round(microtime(true) - $start, 2);
curl_close($ch);

echo "Pollinations => HTTP $pCode | Err: $pErr | Time: {$pDur}s | Len: " . strlen($bin) . "\n";

echo "\n=== 3. Check /public/assets/images/blog directory ===\n";
$blogDir = ROOT_PATH . '/public/assets/images/blog';
echo "Dir exists: " . (is_dir($blogDir) ? "YES" : "NO") . "\n";
echo "Dir writable: " . (is_writable($blogDir) ? "YES" : "NO") . "\n";
PHP;

$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/deep_diag_prod.php";

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

echo "Uploaded deep diag. Executing...\n";
$start = microtime(true);
$out = file_get_contents("https://djerbavoyage.tn/deep_diag_prod.php");
$dur = round(microtime(true) - $start, 2);
echo "Output (in {$dur}s):\n" . $out . "\n";

// Cleanup
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/deep_diag_prod.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
echo "Cleaned up deep diag.\n";
