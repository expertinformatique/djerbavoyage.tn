<?php
$html = file_get_contents('https://djerbavoyage.tn/guide');
if (!$html) {
    echo "Could not fetch https://djerbavoyage.tn/guide\n";
    exit;
}
preg_match_all('/<article[\s\S]*?<\/article>/i', $html, $articles);
echo "Found " . count($articles[0]) . " articles on /guide\n";
foreach (array_slice($articles[0], 0, 10) as $i => $art) {
    preg_match('/<h[23][^>]*>(.*?)<\/h[23]>/i', $art, $title);
    preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $art, $img);
    echo "#" . ($i+1) . " | Img: " . ($img[1] ?? 'none') . " | Title: " . trim(strip_tags($title[1] ?? 'no title')) . "\n";
}
