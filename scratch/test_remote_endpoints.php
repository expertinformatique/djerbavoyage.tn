<?php
$endpoints = [
    'gemini-2.0-flash' => 'http://192.168.0.129/api.php?action=test_agent_text&agent_id=gemini-2.0-flash',
    'gemini-1.5-flash' => 'http://192.168.0.129/api.php?action=test_agent_text&agent_id=gemini-1.5-flash',
    'pollinations-openai' => 'http://192.168.0.129/api.php?action=test_agent_text&agent_id=pollinations-openai',
    'pollinations-mistral' => 'http://192.168.0.129/api.php?action=test_agent_text&agent_id=pollinations-mistral',
    'nano-banana image' => 'http://192.168.0.129/api.php?action=test_agent_image&agent_id=nano-banana',
    'reel-5photo-kenburns video' => 'http://192.168.0.129/api.php?action=test_agent_video&agent_id=reel-5photo-kenburns'
];

foreach ($endpoints as $label => $url) {
    echo "Testing $label...\n";
    $start = microtime(true);
    $ctx = stream_context_create(['http' => ['timeout' => 15]]);
    $res = @file_get_contents($url, false, $ctx);
    $dur = round((microtime(true) - $start) * 1000);
    if ($res === false) {
        echo "  ❌ FAILED to reach $url in {$dur}ms\n";
    } else {
        $json = json_decode($res, true);
        echo "  ✅ ({$dur}ms): " . json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
    }
    echo "--------------------------------------------------------\n";
}
