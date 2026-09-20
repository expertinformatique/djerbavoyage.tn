<?php
$models = ['flux', 'turbo', 'sana'];
foreach ($models as $m) {
    $url = "https://image.pollinations.ai/prompt/Djerba%20beach%20sunset?width=600&height=338&model={$m}&nologo=true&seed=" . rand(100, 999);
    $start = microtime(true);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_FOLLOWLOCATION => true
    ]);
    $bin = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    curl_close($ch);
    $dur = round((microtime(true) - $start) * 1000);
    echo "Model: $m | Code: $code | Type: $contentType | Size: " . strlen($bin ?? '') . " bytes | Time: {$dur}ms\n";
}
