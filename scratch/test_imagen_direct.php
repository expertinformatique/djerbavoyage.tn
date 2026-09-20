<?php
require_once __DIR__ . '/../scratch/debian_dashboard/api.php';

$apiKey = getApiKeyFromEnv('GEMINI_API_KEY');
echo "Gemini Key length: " . strlen($apiKey ?? '') . "\n";

$models = [
    'imagen-3.0-generate-002',
    'imagen-3.0-fast-generate-001'
];

foreach ($models as $m) {
    echo "Testing Imagen model: $m...\n";
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$m}:predict?key=" . $apiKey;
    $payload = json_encode([
        'instances' => [
            ['prompt' => 'Traditional Djerbian whitewashed dome house with blue doors and bougainvillea sunset, photorealistic 8k']
        ],
        'parameters' => [
            'sampleCount' => 1,
            'aspectRatio' => '16:9',
            'outputMimeType' => 'image/jpeg'
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
    $json = json_decode($res, true);
    if ($code === 200 && !empty($json['predictions'][0]['bytesBase64Encoded'])) {
        $b64 = $json['predictions'][0]['bytesBase64Encoded'];
        echo "✅ SUCCESS! Received Base64 image length: " . strlen($b64) . " bytes\n";
    } else {
        echo "Response: " . substr($res, 0, 400) . "\n";
    }
    echo "--------------------------------------------------------\n";
}
