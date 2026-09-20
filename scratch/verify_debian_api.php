<?php
function testApi($url, $method = 'GET', $data = null) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    }
    $res = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return ['code' => $info['http_code'], 'body' => json_decode($res, true), 'raw' => $res];
}

echo "1. Test Status:\n";
$r1 = testApi('http://192.168.0.129/api.php?action=status');
echo "HTTP {$r1['code']} - " . ($r1['body']['success'] ? "SUCCESS" : "FAIL") . "\n";

echo "\n2. Test Bots List:\n";
$r2 = testApi('http://192.168.0.129/api.php?action=bots_list');
echo "HTTP {$r2['code']} - Found " . count($r2['body']['bots'] ?? []) . " bots\n";
foreach ($r2['body']['bots'] ?? [] as $b) {
    echo "  - {$b['name']} [categories: " . implode(', ', $b['categories'] ?? []) . "]\n";
}

echo "\n3. Test Queue List:\n";
$r3 = testApi('http://192.168.0.129/api.php?action=queue_list');
echo "HTTP {$r3['code']} - Topics: " . count($r3['body']['topics'] ?? []) . ", Images: " . count($r3['body']['images'] ?? []) . "\n";
foreach (array_slice($r3['body']['topics'] ?? [], 0, 3) as $t) {
    echo "  - Topic: {$t['title']} [cat: " . ($t['category'] ?? 'none') . "]\n";
}

echo "\n4. Test Add Categorized Topic:\n";
$testTopic = [
    'title' => 'Test Topic Quad Desert ' . time(),
    'category' => 'excursions',
    'bot_id' => 'all',
    'max_uses' => 2,
    'keywords' => 'quad, ksar ghilane'
];
$r4 = testApi('http://192.168.0.129/api.php?action=queue_add_topic', 'POST', $testTopic);
echo "HTTP {$r4['code']} - " . ($r4['body']['success'] ? "SUCCESS (ID: {$r4['body']['topic']['id']})" : "FAIL") . "\n";

if (!empty($r4['body']['topic']['id'])) {
    $tid = $r4['body']['topic']['id'];
    echo "Cleaning up test topic...\n";
    $r5 = testApi('http://192.168.0.129/api.php?action=queue_delete', 'POST', ['type' => 'topic', 'id' => $tid]);
    echo "Delete: " . ($r5['body']['success'] ? "SUCCESS" : "FAIL") . "\n";
}

echo "\nDone!\n";
