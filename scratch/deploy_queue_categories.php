<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';
$ftpBase = 'djerbavoyage.tn';

$filesToUpload = [
    'src/Services/TextImageBannerService.php',
    'src/Services/ContentQueueService.php',
    'src/Services/AiArticleGeneratorService.php',
];

$root = dirname(__DIR__);

echo "===========================================\n";
echo "🚀 Déploiement FTP des Services Catégorisés\n";
echo "===========================================\n\n";

foreach ($filesToUpload as $relPath) {
    $localFile = $root . '/' . $relPath;
    if (!file_exists($localFile)) {
        echo "❌ Local file not found: $relPath\n";
        continue;
    }

    $remoteUrl = "ftp://{$ftpHost}/{$ftpBase}/{$relPath}";
    echo "Uploading {$relPath} to {$remoteUrl}...\n";

    $fp = fopen($localFile, 'r');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remoteUrl);
    curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
    curl_setopt($ch, CURLOPT_UPLOAD, 1);
    curl_setopt($ch, CURLOPT_INFILE, $fp);
    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localFile));
    curl_setopt($ch, CURLOPT_FTP_CREATE_MISSING_DIRS, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $res = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    fclose($fp);

    if ($res) {
        echo "  ✅ Success: {$relPath}\n";
    } else {
        echo "  ❌ Failed: {$relPath} - Error: {$error}\n";
    }
}

echo "\nDéploiement FTP terminé avec succès.\n";
