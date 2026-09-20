<?php
$images = [
    'https://djerbavoyage.tn/assets/images/blog/plage-de-sidi-mahrez-a-djerba-sable-fin-et-eaux-cristallines-de-la-cote-nord-20260920-154532-77.jpg',
    'https://djerbavoyage.tn/assets/images/blog/secrets-millenaires-des-potiers-de-guellala-a-djerba-ateliers-et-traditions-20260920-153013-17.jpg',
    'https://djerbavoyage.tn/assets/images/blog/kitesurf-et-glisse-sur-la-lagune-turquoise-de-djerba-guide-complet-20260920-151513-98.jpg',
    'https://djerbavoyage.tn/assets/images/blog/plage-de-sidi-mahrez-a-djerba-guide-complet-du-littoral-nord-20260920-150012-89.jpg',
    'https://djerbavoyage.tn/assets/images/blog/kitesurf-et-glisse-sur-la-lagune-turquoise-de-djerba-guide-complet-20260920-140012-24.jpg'
];

foreach ($images as $url) {
    $content = @file_get_contents($url);
    if ($content === false) {
        echo "FAILED: $url\n";
    } else {
        echo basename($url) . " | size: " . strlen($content) . " | md5: " . md5($content) . "\n";
    }
}
