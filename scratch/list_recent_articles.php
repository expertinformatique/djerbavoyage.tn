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

$pdo = Core\Database::getInstance();
$stmt = $pdo->query("SELECT id, title_fr, slug, featured_image, published_at FROM articles ORDER BY id DESC LIMIT 10");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
PHP;

$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/list_articles_prod.php";

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

$ch = curl_init("https://djerbavoyage.tn/list_articles_prod.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$out = curl_exec($ch);
curl_close($ch);
echo $out . "\n";

// Cleanup
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/list_articles_prod.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
