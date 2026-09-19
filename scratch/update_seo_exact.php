<?php
$localFile = dirname(__DIR__) . '/public/update_seo_exact.php';
file_put_contents($localFile, '<?php
require_once __DIR__ . "/../core/Database.php";
$pdo = Core\Database::getInstance();
$pdo->exec("UPDATE settings SET setting_value = \'Djerba Voyage 2026 : Guide Officiel, Excursions et Activités\' WHERE setting_key = \'site_name\'");
$pdo->exec("UPDATE settings SET setting_value = \'Préparez votre voyage à Djerba : guides complets, réservation d\'\'excursions, quads, sorties en mer et conciergerie VIP.\' WHERE setting_key = \'meta_description_default\'");

// Clear cache if storage/cache exists
$cacheDir = __DIR__ . "/../storage/cache";
if (is_dir($cacheDir)) {
    foreach (glob($cacheDir . "/*") as $f) {
        @unlink($f);
    }
}
echo "OK";
');

$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';
$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/update_seo_exact.php";

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

$output = file_get_contents("https://djerbavoyage.tn/update_seo_exact.php");
echo "Update output: " . $output . "\n";

// Delete remote file
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/update_seo_exact.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
