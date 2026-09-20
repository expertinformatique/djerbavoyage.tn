<?php
set_time_limit(120);
$start = microtime(true);
$prompt = rawurlencode("Photorealistic DSLR photograph of Djerba beach turquoise water");
$url = "https://image.pollinations.ai/prompt/" . $prompt . "?width=800&height=450&nologo=true&seed=" . mt_rand(100, 99999);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$b = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err = curl_error($ch);
$dur = round(microtime(true) - $start, 2);

echo "Time: {$dur}s | HTTP $code | Err: $err | Len: " . strlen($b) . "
";
if ($code === 200 && strlen($b) > 5000) {
    echo "IS_JPEG: " . (substr($b, 0, 3) === "ÿØÿ" ? "YES" : "NO") . "
";
}
