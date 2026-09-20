<?php
$apiKey = '';
if (file_exists(__DIR__ . '/../.env')) {
    foreach (file(__DIR__ . '/../.env') as $l) {
        if (strpos($l, 'GEMINI_API_KEY=') === 0) $apiKey = trim(substr($l, 15));
    }
}

$models = [
    'gemini-3.1-flash-lite-image',
    'gemini-3.1-flash-image',
    'gemini-3.1-flash-image-preview',
    'gemini-2.5-flash-image',
    'gemini-3-pro-image',
    'gemini-3-pro-image-preview',
    'nano-banana-pro-preview'
];

foreach ($models as $m) {
    echo "=== Testing Model: $m ===\n";
    
    // Format A: responseModalities: ["IMAGE"]
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$m}:generateContent?key={$apiKey}";
    $payloadA = [
        'contents' => [['parts' => [['text' => 'Photorealistic DSLR photograph of turquoise sea beach in Djerba, Tunisia']]]],
        'generationConfig' => [
            'responseModalities' => ['IMAGE']
        ]
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payloadA));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $resA = curl_exec($ch);
    $codeA = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "Format A (IMAGE only): HTTP $codeA\n";
    $jsonA = json_decode($resA, true);
    if ($codeA === 200) {
        echo "  🎉 SUCCESS on $m! Candidates: " . count($jsonA['candidates'] ?? []) . "\n";
        $parts = $jsonA['candidates'][0]['content']['parts'] ?? [];
        foreach ($parts as $p) {
            if (isset($p['inlineData'])) {
                echo "    Found inlineData: mimeType=" . ($p['inlineData']['mimeType'] ?? '') . ", bytes=" . strlen(base64_decode($p['inlineData']['data'])) . "\n";
            }
        }
    } else {
        echo "  Error: " . ($jsonA['error']['message'] ?? substr($resA, 0, 200)) . "\n";
    }
    
    // Format B: responseModalities: ["TEXT", "IMAGE"]
    $payloadB = [
        'contents' => [['parts' => [['text' => 'Generate a photorealistic image of Djerba beach']]]],
        'generationConfig' => [
            'responseModalities' => ['TEXT', 'IMAGE']
        ]
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payloadB));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $resB = curl_exec($ch);
    $codeB = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "Format B (TEXT+IMAGE): HTTP $codeB\n";
    if ($codeB === 200) {
        echo "  🎉 SUCCESS on $m (Format B)!\n";
    }
    echo "\n";
}
