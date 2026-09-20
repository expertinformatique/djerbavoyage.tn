<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';
$ftpBase = 'djerbavoyage.tn';

$ch = curl_init("ftp://{$ftpHost}/{$ftpBase}/src/Services/AiImageService.php");
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$content = curl_exec($ch);
curl_close($ch);

file_put_contents('scratch/prod_AiImageService.php', $content);

$ch2 = curl_init("ftp://{$ftpHost}/{$ftpBase}/src/Services/NanoBananaImageService.php");
curl_setopt($ch2, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
$content2 = curl_exec($ch2);
curl_close($ch2);

file_put_contents('scratch/prod_NanoBananaImageService.php', $content2);

echo "Saved prod files to scratch/\n";
