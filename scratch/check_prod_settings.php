<?php
$localFile = dirname(__DIR__) . '/public/check_prod_settings_temp.php';
file_put_contents($localFile, '<?php
require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../core/helpers.php";
$pdo = Core\Database::getInstance();
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings WHERE setting_key IN (\'site_name\', \'meta_description_default\')");
echo json_encode($stmt->fetchAll(PDO::FETCH_KEY_PAIR), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Clear cache if storage/cache exists
$cacheDir = __DIR__ . "/../storage/cache";
if (is_dir($cacheDir)) {
    foreach (glob($cacheDir . "/*") as $f) {
        @unlink($f);
    }
    echo "\nCache cleared.\n";
}
');

$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';
$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/check_prod_settings_temp.php";

$fp = fopen($localFile, 'r');
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_UPLOAD, 1);
curl_setopt($ch, CURLOPT_INFILE, $fp);
curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localFile));
curl_exec($ch);
curl_close($ch);
fclose($fp);
@unlink($localFile);

$output = file_get_contents("https://djerbavoyage.tn/check_prod_settings_temp.php");
echo "Settings from DB:\n" . $output . "\n";

// Delete remote file
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/check_prod_settings_temp.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
