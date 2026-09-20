<?php
$key = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY') ?: 'YOUR_GEMINI_API_KEY';

$models = [
    'gemini-2.5-flash-image',
    'nano-banana-pro-preview',
    'gemini-3.1-flash-image',
    'gemini-3-pro-image',
    'gemini-3.1-flash-lite-image'
];

$prompt = "Photorealistic DSLR photograph of turquoise water and sandy beach in Djerba, Tunisia. 8k resolution.";

foreach ($models as $model) {
    echo "\nTesting model: $model ...\n";
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $key;
    
    // Test 1: with responseModalities
    $payload = [
        'contents' => [
            ['parts' => [['text' => $prompt]]]
        ],
        'generationConfig' => [
            'responseModalities' => ['IMAGE']
        ]
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "HTTP $code\n";
    $data = json_decode($res, true);
    if ($code === 200) {
        $parts = $data['candidates'][0]['content']['parts'] ?? [];
        echo "Candidate parts count: " . count($parts) . "\n";
        foreach ($parts as $p) {
            if (isset($p['inlineData'])) {
                echo "FOUND INLINE DATA! Mime: " . ($p['inlineData']['mimeType'] ?? '') . " | Base64 len: " . strlen($p['inlineData']['data'] ?? '') . "\n";
            } elseif (isset($p['text'])) {
                echo "Text response: " . substr($p['text'], 0, 100) . "\n";
            }
        }
        break; // If successful, stop
    } else {
        echo "Error: " . substr($res, 0, 300) . "\n";
    }
}
