<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';

$runnerCode = <<<'PHP'
<?php
define('ROOT_PATH', dirname(__DIR__));
require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../src/Services/NanoBananaImageService.php';
require_once __DIR__ . '/../src/Services/SettingsService.php';

// Load .env
if (file_exists(ROOT_PATH . '/.env')) {
    foreach (file(ROOT_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos($line, '=') !== false && strpos(trim($line), '#') !== 0) {
            list($k, $v) = explode('=', $line, 2);
            putenv(trim($k) . '=' . trim($v, " \t\n\r\0\x0B\"'"));
            $_ENV[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        }
    }
}

$nano = new App\Services\NanoBananaImageService();
echo "Enabled: " . ($nano->isEnabled() ? "YES" : "NO") . "\n";
echo "Model: " . $nano->getModel() . "\n";
echo "API Key prefix: " . substr(getenv('GEMINI_API_KEY') ?: $_ENV['GEMINI_API_KEY'] ?? '', 0, 8) . "\n";

$slug = "test-prod-diag-" . time();
$prompt = "Kitesurf on turquoise lagoon in Djerba Tunisia";
$res = $nano->generate($prompt, $slug, ROOT_PATH);
echo "Generate Result: " . var_export($res, true) . "\n";

if ($res) {
    echo "File exists: " . (file_exists(ROOT_PATH . '/public/' . $res) ? "YES" : "NO") . "\n";
    if (file_exists(ROOT_PATH . '/public/' . $res)) {
        echo "Size: " . filesize(ROOT_PATH . '/public/' . $res) . " bytes\n";
    }
}
PHP;

$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/diag_nano_prod.php";

// Upload
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

echo "Diagnostic uploaded to production. Executing...\n";
$start = microtime(true);
$out = file_get_contents("https://djerbavoyage.tn/diag_nano_prod.php");
$dur = round(microtime(true) - $start, 2);
echo "Output (in {$dur}s):\n" . $out . "\n";

// Cleanup
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/diag_nano_prod.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
echo "Cleaned up remote diag.\n";
