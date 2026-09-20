<?php
$apiKey = '';
if (file_exists(__DIR__ . '/../.env')) {
    foreach (file(__DIR__ . '/../.env') as $l) {
        if (strpos($l, 'GEMINI_API_KEY=') === 0) $apiKey = trim(substr($l, 15));
    }
}

$models = [
    'imagen-3.0-generate-002',
    'imagen-3.0-fast-generate-001',
    'nano-banana-pro-preview',
    'gemini-2.5-flash-image',
    'gemini-3.1-flash-image'
];

echo "Testing with API key prefix: " . substr($apiKey, 0, 8) . "\n";

foreach ($models as $m) {
    // 1. Try predict (Imagen format)
    $urlPredict = "https://generativelanguage.googleapis.com/v1beta/models/{$m}:predict?key={$apiKey}";
    $payloadPredict = json_encode([
        'instances' => [['prompt' => 'Photorealistic beach in Djerba']],
        'parameters' => ['sampleCount' => 1, 'aspectRatio' => '16:9']
    ]);
    $ch = curl_init($urlPredict);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadPredict);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $res = curl_exec($ch);
    $c = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "$m [predict] => HTTP $c : " . substr($res, 0, 120) . "\n";

    // 2. Try generateContent (Gemini format)
    $urlGen = "https://generativelanguage.googleapis.com/v1beta/models/{$m}:generateContent?key={$apiKey}";
    $payloadGen = json_encode([
        'contents' => [['parts' => [['text' => 'Generate a photorealistic photo of Djerba']]]],
        'generationConfig' => ['responseModalities' => ['IMAGE']]
    ]);
    $ch = curl_init($urlGen);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadGen);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $res2 = curl_exec($ch);
    $c2 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "$m [generateContent] => HTTP $c2 : " . substr($res2, 0, 120) . "\n\n";
}
