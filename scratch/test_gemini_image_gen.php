<?php
$lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$apiKey = '';
foreach ($lines as $l) {
    if (str_starts_with(trim($l), 'GEMINI_API_KEY=')) {
        $apiKey = trim(substr(trim($l), strlen('GEMINI_API_KEY=')), "\"' ");
    }
}

$models = ['gemini-2.5-flash-image', 'gemini-3.1-flash-image', 'gemini-3.1-flash-lite-image'];

foreach ($models as $m) {
    echo "Testing $m...\n";
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$m}:generateContent?key=" . $apiKey;
    $payload = json_encode([
        'contents' => [
            ['parts' => [['text' => 'Generate an image: Traditional Djerba menzel whitewashed dome at sunset with turquoise pool, hyperrealistic 8k']]]
        ],
        'generationConfig' => [
            'responseModalities' => ['IMAGE', 'TEXT']
        ]
    ]);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "HTTP Code: $code\n";
    $data = json_decode($res, true);
    if ($code === 200) {
        $parts = $data['candidates'][0]['content']['parts'] ?? [];
        echo "Parts count: " . count($parts) . "\n";
        foreach ($parts as $p) {
            if (isset($p['inlineData'])) {
                echo "✅ Found inlineData! Mime: " . ($p['inlineData']['mimeType'] ?? 'unknown') . " | Bytes: " . strlen($p['inlineData']['data'] ?? '') . "\n";
            }
            if (isset($p['text'])) {
                echo "Text part: " . substr($p['text'], 0, 100) . "...\n";
            }
        }
    } else {
        echo "Error response: " . substr($res, 0, 300) . "\n";
    }
    echo "--------------------------------------------------------\n";
}
