<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';
$ftpBase = 'djerbavoyage.tn';

$filesToUpload = [
    'database/migrations/017_add_arabic_translations_to_articles.sql',
    'database/migrate.php',
    'src/Models/Article.php',
    'src/Repositories/PdoArticleRepository.php',
    'src/Services/DjerbaStoryDataProvider.php',
    'src/Services/DjerbaStoryFallbackService.php',
    'src/Services/AiArticleGeneratorService.php',
    'src/Services/ArticlePdfService.php',
    'src/Controllers/Admin/ArticlesAdminController.php',
    'views/admin/articles/form.php',
    'views/pages/guide-single.php',
    'views/pages/guide-list.php',
    'views/partials/home_blog_section.php',
    'views/partials/blog/article_related.php',
];

$root = dirname(__DIR__);

echo "===========================================\n";
echo "🚀 Déploiement FTP des fichiers Multi-Langues\n";
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

echo "\n-------------------------------------------\n";
echo "Exécution de la migration sur le serveur de prod...\n";
$remoteMigrateUrl = "https://djerbavoyage.tn/api/auto-blog/generate?migrate=1";
// On execute execute_prod_migrate if available
require_once __DIR__ . '/execute_prod_migrate.php';
