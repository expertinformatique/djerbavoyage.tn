<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';
$localFile = dirname(__DIR__) . '/public/run_migrate_prod_temp.php';
$remoteUrl = "ftp://{$ftpHost}/djerbavoyage.tn/public/run_migrate_prod_temp.php";

// Upload
$fp = fopen($localFile, 'r');
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_UPLOAD, 1);
curl_setopt($ch, CURLOPT_INFILE, $fp);
curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localFile));
curl_exec($ch);
curl_close($ch);
fclose($fp);

echo "Runner uploaded to production.\n";

// Execute via web
$output = file_get_contents("https://djerbavoyage.tn/run_migrate_prod_temp.php");
echo "Migration output:\n" . $output . "\n";

// Delete remote file
$ch = curl_init($remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_QUOTE, ["DELE /djerbavoyage.tn/public/run_migrate_prod_temp.php"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);

@unlink($localFile);
echo "Remote runner cleaned up.\n";
