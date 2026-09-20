<?php
$prompt = urlencode("Photorealistic DSLR photograph of Djerba beach turquoise water 8k");
$url = "https://image.pollinations.ai/prompt/" . $prompt . "?width=1200&height=675&nologo=true&seed=" . mt_rand(100, 99999);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$b = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "HTTP: $code | Len: " . strlen($b) . "
";
