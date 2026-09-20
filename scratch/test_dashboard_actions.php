<?php

$baseUrl = 'http://192.168.0.129';

echo "=== Testing Schedule Switch to 30m ===\n";
$ch = curl_init("$baseUrl/api.php?action=schedule");
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(['interval' => '30m']),
    CURLOPT_RETURNTRANSFER => true
]);
$res = curl_exec($ch);
curl_close($ch);
echo "Result 30m: $res\n";

$status = json_decode(file_get_contents("$baseUrl/api.php?action=status"), true);
echo "New Status: " . ($status['bot']['schedule_label'] ?? 'N/A') . "\n";

echo "\n=== Testing Schedule Switch back to 15m ===\n";
$ch = curl_init("$baseUrl/api.php?action=schedule");
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(['interval' => '15m']),
    CURLOPT_RETURNTRANSFER => true
]);
$res = curl_exec($ch);
curl_close($ch);
echo "Result 15m: $res\n";

$status = json_decode(file_get_contents("$baseUrl/api.php?action=status"), true);
echo "Final Status: " . ($status['bot']['schedule_label'] ?? 'N/A') . "\n";
