<?php
$html = file_get_contents('https://djerbavoyage.tn/');

// 1. Title
preg_match('#<title>(.*?)</title>#', $html, $mTitle);
$title = $mTitle[1] ?? 'NOT FOUND';
echo "1. Title: \"{$title}\"\n";
echo "   Length: " . mb_strlen($title) . " chars (Target: 50-60)\n\n";

// 2. Meta description
preg_match('#<meta name="description" content="(.*?)"#', $html, $mDesc);
$desc = $mDesc[1] ?? 'NOT FOUND';
echo "2. Meta Description: \"{$desc}\"\n";
echo "   Length: " . mb_strlen($desc) . " chars (Target: 100-130)\n\n";

// 3. Hreflang
preg_match_all('#<link rel="alternate" hreflang="([^"]+)" href="([^"]+)"#', $html, $mHref);
echo "3. Hreflang Tags found: " . count($mHref[1]) . "\n";
for ($i = 0; $i < count($mHref[1]); $i++) {
    echo "   - [{$mHref[1][$i]}] => {$mHref[2][$i]}\n";
}
echo "\n";

// 4. Schema.org JSON-LD
preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $mJson);
echo "4. Schema.org JSON-LD blocks found: " . count($mJson[1]) . "\n";
foreach ($mJson[1] as $idx => $block) {
    $parsed = json_decode($block, true);
    echo "   Block #{$idx}: " . ($parsed ? "Valid JSON (" . (count($parsed['@graph'] ?? $parsed) . " objects)") : "Invalid JSON") . "\n";
}
echo "\n";

// 5. Images with optimized names
$imagesToCheck = [
    'logo-djerba-voyage-guide-officiel.png',
    'conciergerie-voyage-djerba-vip.png',
    'guide-djerba-pdf-personnalise-voyage.png'
];
echo "5. Optimized Image Names on Homepage:\n";
foreach ($imagesToCheck as $img) {
    echo "   - {$img}: " . (str_contains($html, $img) ? "✅ PRESENT" : "❌ MISSING") . "\n";
}
echo "\n";

// 6. Robots.txt Content-Signal
$robots = file_get_contents('https://djerbavoyage.tn/robots.txt');
echo "6. Robots.txt Content-Signal:\n";
echo "   Has Content-Signal: " . (str_contains($robots, 'Content-Signal') ? "✅ YES" : "❌ NO") . "\n";
echo "   Content:\n" . trim($robots) . "\n";
