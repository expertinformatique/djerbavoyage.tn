<?php
$apiUrl = "https://djerbavoyage.tn/api/auto-blog/generate?token=djerba_secret_cron_key_2026";
echo "Calling production API: $apiUrl ...\n";
$start = microtime(true);
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
$res = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err = curl_error($ch);
curl_close($ch);
$duration = round(microtime(true) - $start, 2);

echo "HTTP Code: $code (in {$duration}s)\n";
if ($err) echo "cURL error: $err\n";

$json = json_decode($res, true);
if ($json) {
    echo json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
} else {
    echo "Raw response: " . substr($res, 0, 800) . "\n";
}
