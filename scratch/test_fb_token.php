<?php
require_once __DIR__ . '/../core/Database.php';

// Lire token depuis .env manuellement
$lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$env = [];
foreach ($lines as $line) {
    if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
    list($k, $v) = explode('=', $line, 2);
    $env[trim($k)] = trim($v);
}
$token = $env['FB_PAGE_ACCESS_TOKEN'] ?? '';
$pageId = $env['FB_PAGE_ID'] ?? '136561653049793';

echo "Page ID: " . $pageId . "\n";
echo "Token prefix: " . substr($token, 0, 15) . "... (length: " . strlen($token) . ")\n\n";

// 1. Tester /me
$ch = curl_init("https://graph.facebook.com/v19.0/me?access_token=" . urlencode($token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code /me: " . $httpCode . "\n";
echo "Response /me:\n" . $res . "\n\n";

// 2. Tester /debug_token
$ch = curl_init("https://graph.facebook.com/debug_token?input_token=" . urlencode($token) . "&access_token=" . urlencode($token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code /debug_token: " . $httpCode . "\n";
echo "Response /debug_token:\n" . $res . "\n\n";

// 3. Tester /{pageId}
$ch = curl_init("https://graph.facebook.com/v19.0/" . urlencode($pageId) . "?fields=id,name,access_token&access_token=" . urlencode($token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code /{$pageId}: " . $httpCode . "\n";
echo "Response /{$pageId}:\n" . $res . "\n";
