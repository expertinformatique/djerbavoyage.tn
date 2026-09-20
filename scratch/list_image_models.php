<?php
$lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$apiKey = '';
foreach ($lines as $l) {
    if (str_starts_with(trim($l), 'GEMINI_API_KEY=')) {
        $apiKey = trim(substr(trim($l), strlen('GEMINI_API_KEY=')), "\"' ");
    }
}

$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;
$res = @file_get_contents($url);
$json = json_decode($res, true);
echo "Total Google models: " . count($json['models'] ?? []) . "\n";
foreach ($json['models'] ?? [] as $m) {
    $methods = implode(', ', $m['supportedGenerationMethods'] ?? []);
    if (stripos($m['name'], 'image') !== false || stripos($methods, 'image') !== false || stripos($m['name'], 'imagen') !== false) {
        echo "Model: " . $m['name'] . " | Methods: " . $methods . "\n";
    }
}
