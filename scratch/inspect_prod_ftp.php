<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';
$ftpBase = 'djerbavoyage.tn';

$files = [
    'src/Services/NanoBananaImageService.php',
    'src/Services/AiImageService.php',
    'src/Services/AiArticleGeneratorService.php',
    '.env'
];

foreach ($files as $f) {
    $remoteUrl = "ftp://{$ftpHost}/{$ftpBase}/{$f}";
    $ch = curl_init($remoteUrl);
    curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $content = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    
    echo "=== $f (Len: " . strlen($content) . ") ===\n";
    if (strpos($f, '.env') !== false) {
        // Redact secrets but show keys
        $lines = explode("\n", $content);
        foreach ($lines as $l) {
            if (strpos($l, '=') !== false) {
                [$k, $v] = explode('=', $l, 2);
                echo trim($k) . '=' . substr(trim($v), 0, 8) . "...\n";
            }
        }
    } else {
        echo substr($content, 0, 300) . "\n...\n";
    }
}
