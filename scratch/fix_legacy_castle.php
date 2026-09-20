<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';

$runnerCode = <<<'PHP'
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(180);

define('ROOT_PATH', dirname(__DIR__));
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../core/Database.php';

$pdo = Core\Database::getInstance();

function generateAndSave(string $prompt, string $slug): ?string {
    for ($attempt = 1; $attempt <= 5; $attempt++) {
        $seed = mt_rand(10000, 999999);
        $url = "https://image.pollinations.ai/prompt/" . rawurlencode($prompt) . "?seed=" . $seed;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $bin = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($code === 200 && $bin && strlen($bin) > 5000) {
            $relPath = 'images/blog/' . $slug . '.jpg';
            $fullPath = ROOT_PATH . '/public/assets/' . $relPath;
            file_put_contents($fullPath, $bin);
            return $relPath;
        }

        sleep(4);
    }
    return null;
}

// Fix 642
$kite1 = generateAndSave("Photorealistic DSLR photograph of Kitesurfer airborne gliding over turquoise sea in Djerba Tunisia, golden hour, 35mm", 'kitesurf-airborne-djerba-ai-' . time());
if ($kite1) {
    $pdo->prepare("UPDATE articles SET featured_image = ? WHERE id = 642")->execute([$kite1]);
    echo "✅ 642 updated: $kite1\n";
}

sleep(3);

// Fix 640
$kite2 = generateAndSave("Photorealistic DSLR photograph of Kitesurf board carving water spray on calm lagoon in Djerba Tunisia, bright sun, 35mm", 'kitesurf-spray-djerba-ai-' . time());
if ($kite2) {
    $pdo->prepare("UPDATE articles SET featured_image = ? WHERE id = 640")->execute([$kite2]);
    echo "✅ 640 updated: $kite2\n";
}

echo "All legacy duplicate articles resolved!\n";
PHP;

$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/fix_legacy_runner.php";

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

$start = microtime(true);
$ch = curl_init("https://djerbavoyage.tn/fix_legacy_runner.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 180);
$res = curl_exec($ch);
$dur = round(microtime(true) - $start, 2);
curl_close($ch);

echo "Result ({$dur}s):\n" . $res . "\n";

// Cleanup
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/fix_legacy_runner.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
