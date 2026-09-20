<?php
$apiKey = '';
if (file_exists(__DIR__ . '/../.env')) {
    foreach (file(__DIR__ . '/../.env') as $l) {
        if (strpos($l, 'GEMINI_API_KEY=') === 0) $apiKey = trim(substr($l, 15));
    }
}

$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
curl_close($ch);

$data = json_decode($res, true);
if (isset($data['models'])) {
    echo "Found " . count($data['models']) . " models available on this API key:\n";
    foreach ($data['models'] as $m) {
        $methods = implode(', ', $m['supportedGenerationMethods'] ?? []);
        echo "- " . $m['name'] . " (" . ($m['displayName'] ?? '') . ") -> " . $methods . "\n";
    }
} else {
    echo "Error listing models: " . $res . "\n";
}
