<?php
$urls = [
    'plain' => 'https://image.pollinations.ai/prompt/' . rawurlencode('Djerba lagoon beach') . '?seed=1234',
    'nologo' => 'https://image.pollinations.ai/prompt/' . rawurlencode('Djerba lagoon beach') . '?nologo=true&seed=1234',
    'nologo_no_seed' => 'https://image.pollinations.ai/prompt/' . rawurlencode('Djerba lagoon beach 1234') . '?nologo=true',
    'path_only' => 'https://image.pollinations.ai/prompt/' . rawurlencode('Djerba lagoon beach 1234')
];
foreach ($urls as $name => $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo $name . ' => Code: ' . $code . ' Length: ' . strlen($res) . "\n";
}
