<?php
$query = "Djerba Guellala";
$url = "https://commons.wikimedia.org/w/api.php?action=query&list=search&srsearch=" . urlencode($query) . "&srnamespace=6&format=json";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'DjerbaVoyageBot/1.0');
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$res = curl_exec($ch);
curl_close($ch);

$data = json_decode($res, true);
$results = $data['query']['search'] ?? [];
echo "Search results: " . count($results) . "\n";
if (!empty($results[0]['title'])) {
    $fileTitle = $results[0]['title'];
    $infoUrl = "https://commons.wikimedia.org/w/api.php?action=query&titles=" . urlencode($fileTitle) . "&prop=imageinfo&iiprop=url|size&format=json";
    $ch2 = curl_init($infoUrl);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_USERAGENT, 'DjerbaVoyageBot/1.0');
    $infoRes = curl_exec($ch2);
    curl_close($ch2);
    $infoData = json_decode($infoRes, true);
    $pages = $infoData['query']['pages'] ?? [];
    $page = reset($pages);
    $url = $page['imageinfo'][0]['url'] ?? 'none';
    echo "Found image: $fileTitle => $url\n";
}
