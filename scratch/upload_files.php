<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';
$ftpBase = 'djerbavoyage.tn';

$filesToUpload = [
    'database/migrations/017_update_seo_titles_and_descriptions.sql',
    'src/Controllers/HomeController.php',
    'src/Services/SitemapService.php',
    'public/robots.txt',
    'views/layouts/main.php',
    'views/pages/home.php',
    'views/partials/navbar.php',
    'views/partials/personalized_pdf_modal.php',
    'public/assets/images/logo-djerba-voyage-guide-officiel.png',
    'public/assets/images/conciergerie-voyage-djerba-vip.png',
    'public/assets/images/guide-djerba-pdf-personnalise-voyage.png',
];

$root = dirname(__DIR__);

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
    $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    fclose($fp);

    if ($res) {
        echo "  ✅ Success: {$relPath}\n";
    } else {
        echo "  ❌ Failed: {$relPath} - Error: {$error}\n";
    }
}
