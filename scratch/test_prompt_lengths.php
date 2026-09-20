<?php
$seed = 12345;
$concise = 'https://image.pollinations.ai/prompt/' . rawurlencode('Photorealistic DSLR photograph of Kitesurf lagoon in Djerba Tunisia, golden hour, 35mm') . '?seed=' . $seed;

$ch = curl_init($concise);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$r = curl_exec($ch);
$c = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "concise => HTTP $c len: " . strlen($r) . "\n";
echo "BODY: $r\n";
