<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ch = curl_init('ftp://ftp.invoices.tn/djerbavoyage.tn/src/Services/NanoBananaImageService.php');
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$content = curl_exec($ch);
curl_close($ch);
echo 'Len: ' . strlen($content) . "\n";
$lines = explode("\n", $content);
for ($i = 135; $i <= 165; $i++) {
    if (isset($lines[$i])) echo ($i+1) . ': ' . $lines[$i] . "\n";
}
