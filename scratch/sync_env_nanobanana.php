<?php
$ftpUser = 'waelbelhaj@invoices.tn';
$ftpPass = 'lS62Z3nVaG';
$ftpHost = 'ftp.invoices.tn';
$ftpPath = 'djerbavoyage.tn/.env';

$url = "ftp://{$ftpHost}/{$ftpPath}";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$prodEnv = curl_exec($ch);
curl_close($ch);

if (!$prodEnv) {
    die("Error reading remote .env\n");
}

echo "Current production .env read successfully (" . strlen($prodEnv) . " bytes).\n";

$nanoKeys = [
    'NANO_BANANA_ENABLED=true',
    'NANO_BANANA_MODEL=nano-banana-pro-preview'
];

$updatedEnv = $prodEnv;
foreach ($nanoKeys as $line) {
    list($key, $val) = explode('=', $line, 2);
    if (strpos($updatedEnv, $key . '=') !== false) {
        $updatedEnv = preg_replace('/^' . preg_quote($key, '/') . '=.*$/m', $line, $updatedEnv);
    } else {
        $updatedEnv .= "\n" . $line;
    }
}

// Upload back
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_UPLOAD, 1);
$tempFp = fopen('php://temp', 'r+');
fwrite($tempFp, $updatedEnv);
rewind($tempFp);
curl_setopt($ch, CURLOPT_INFILE, $tempFp);
curl_setopt($ch, CURLOPT_INFILESIZE, strlen($updatedEnv));
$res = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
fclose($tempFp);
curl_close($ch);

if ($res) {
    echo "✅ Production .env updated successfully with Nano Banana configuration!\n";
} else {
    echo "❌ Failed to update production .env\n";
}
