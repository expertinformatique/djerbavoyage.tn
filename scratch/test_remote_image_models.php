<?php

$models = [
    'pollinations-flux' => 'http://192.168.0.129/api.php?action=test_agent_image&agent_id=pollinations-flux',
    'stability-sdxl' => 'http://192.168.0.129/api.php?action=test_agent_image&agent_id=stability-sdxl',
    'djerba-banner' => 'http://192.168.0.129/api.php?action=test_agent_image&agent_id=djerba-banner',
    'dall-e-3 (sans clé)' => 'http://192.168.0.129/api.php?action=test_agent_image&agent_id=dall-e-3',
    'nano-banana' => 'http://192.168.0.129/api.php?action=test_agent_image&agent_id=nano-banana'
];

foreach ($models as $name => $url) {
    echo "Testing $name...\n";
    $start = microtime(true);
    $ctx = stream_context_create(['http' => ['timeout' => 20]]);
    $res = @file_get_contents($url, false, $ctx);
    $dur = round((microtime(true) - $start) * 1000);
    if ($res === false) {
        echo "  ❌ Failed to reach $url in {$dur}ms\n";
    } else {
        $json = json_decode($res, true);
        echo "  Result ({$dur}ms): " . json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    }
    echo "--------------------------------------------------------\n";
}
