<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';
$ftpPath = 'djerbavoyage.tn/error.log';

$url = "ftp://{$ftpHost}/{$ftpPath}";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$log = curl_exec($ch);
curl_close($ch);

if (!$log) {
    echo "No remote error.log found or empty.\n";
} else {
    $lines = explode("\n", trim($log));
    $last20 = array_slice($lines, -25);
    echo implode("\n", $last20) . "\n";
}
