<?php
$url = "https://djerbavoyage.tn/guide/kitesurf-a-djerba-guide-complet-de-la-lagune-turquoise-et-de-ses-spots-de-glisse-20260919-152314-16";
$html = file_get_contents($url);
preg_match('#<div class="c-article-body">(.*?)</div>\s*<!--#s', $html, $c);
$body = $c[1] ?? '';
echo "URL: $url\n";
echo "CONTENT LENGTH: " . strlen($body) . "\n";
echo "WORD COUNT: " . str_word_count(strip_tags($body)) . "\n";
echo "HAS <table>: " . (str_contains($body, '<table') ? 'YES' : 'NO') . "\n";
echo "HAS <blockquote>: " . (str_contains($body, '<blockquote') ? 'YES' : 'NO') . "\n";
echo "HAS FAQ: " . (str_contains($body, 'FAQ') || str_contains($body, 'Questions') || str_contains($body, 'questions') ? 'YES' : 'NO') . "\n";

preg_match_all('#<h2[^>]*>(.*?)</h2>#', $body, $h2s);
echo "H2 SUBHEADINGS (" . count($h2s[1]) . "):\n";
foreach ($h2s[1] as $h2) {
    echo "  - " . trim(strip_tags($h2)) . "\n";
}

preg_match_all('#href="([^"]+)"#', $body, $links);
echo "INTERNAL LINKS (" . count($links[1]) . "):\n";
foreach (array_unique($links[1]) as $link) {
    echo "  -> " . $link . "\n";
}

preg_match('#<div class="c-article-hero-media">.*?<img src="([^"]+)"#s', $html, $img);
echo "IMAGE HERO: " . ($img[1] ?? 'none') . "\n";

// Vérifier l'accessibilité de l'image
$fullImgUrl = "https://djerbavoyage.tn" . ($img[1] ?? '');
$imgHeaders = get_headers($fullImgUrl);
echo "IMAGE HTTP STATUS: " . ($imgHeaders[0] ?? 'unknown') . "\n";
