<?php
// Test de récupération d'image Wikimedia Commons pour Djerba
$keywords = 'Djerba Guellala';
$url = "https://commons.wikimedia.org/w/api.php?action=query&generator=search&gsrsearch=" . urlencode($keywords) . "&gsrlimit=5&prop=imageinfo&iiprop=url|mime|size&format=json";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'DjerbaVoyageBot/1.0 (travel guide photo resolver)');
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$res = curl_exec($ch);
curl_close($ch);

$data = json_decode($res, true);
$pages = $data['query']['pages'] ?? [];
echo "Found " . count($pages) . " results for {$keywords}:\n";
foreach ($pages as $p) {
    $info = $p['imageinfo'][0] ?? null;
    if ($info && in_array($info['mime'], ['image/jpeg', 'image/png', 'image/webp'])) {
        echo "- " . $p['title'] . " => " . $info['url'] . " (" . ($info['size'] ?? 0) . " bytes)\n";
    }
}
