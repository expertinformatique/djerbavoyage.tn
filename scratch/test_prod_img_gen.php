<?php
require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../core/helpers.php";

$prompt = "Photorealistic DSLR photograph of Kitesurf on turquoise lagoon in Djerba, Tunisia, golden hour, 35mm lens, sharp focus, 8k resolution, real photograph";
$url = "https://image.pollinations.ai/prompt/" . urlencode($prompt) . "?width=1200&height=675&nologo=true&seed=" . mt_rand(1000, 999999);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$b = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($code === 200 && strlen($b) > 8000) {
    file_put_contents(__DIR__ . "/assets/images/blog/test_kitesurf_gen.jpg", $b);
    echo "SUCCESS: " . strlen($b) . " bytes saved to assets/images/blog/test_kitesurf_gen.jpg
";
} else {
    echo "FAILED: HTTP $code, len " . strlen($b) . "
";
}
