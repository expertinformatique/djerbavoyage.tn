<?php

$baseUrl = 'http://192.168.0.129';

echo "=== 1. Testing GET /api.php?action=status ===\n";
$statusJson = @file_get_contents("$baseUrl/api.php?action=status");
$status = json_decode($statusJson, true);
if ($status && ($status['success'] ?? false)) {
    echo "✓ Status API OK: " . $status['overview']['total_bots'] . " total bots, " . $status['overview']['active_bots'] . " active bots.\n";
    echo "  - RAM: " . $status['system']['memory']['used_mb'] . " / " . $status['system']['memory']['total_mb'] . " MB (" . $status['system']['memory']['percent'] . "%)\n";
} else {
    echo "✗ Status API failed: $statusJson\n";
}

echo "\n=== 2. Testing GET /api.php?action=bots_list ===\n";
$botsJson = @file_get_contents("$baseUrl/api.php?action=bots_list");
$bots = json_decode($botsJson, true);
if ($bots && ($bots['success'] ?? false)) {
    echo "✓ Bots List API OK (" . count($bots['bots']) . " bots):\n";
    foreach ($bots['bots'] as $b) {
        echo "  - [{$b['id']}] {$b['icon']} {$b['name']} ({$b['theme']})\n";
        echo "    * Status: {$b['status']} | Schedule: {$b['schedule_label']}\n";
        echo "    * AI Stack: Text={$b['ai_agents']['text']}, Image={$b['ai_agents']['image']}, Video={$b['ai_agents']['video']}\n";
    }
} else {
    echo "✗ Bots List API failed: $botsJson\n";
}

echo "\n=== 3. Testing GET /api.php?action=ai_agents ===\n";
$agentsJson = @file_get_contents("$baseUrl/api.php?action=ai_agents");
$agents = json_decode($agentsJson, true);
if ($agents && ($agents['success'] ?? false)) {
    echo "✓ AI Agents Catalog OK:\n";
    echo "  - Text Models: " . count($agents['text_agents']) . "\n";
    echo "  - Image Models: " . count($agents['image_agents']) . "\n";
    echo "  - Video Models: " . count($agents['video_agents']) . "\n";
} else {
    echo "✗ AI Agents Catalog failed: $agentsJson\n";
}

echo "\n=== 4. Testing POST /api.php?action=bot_save (Create New Bot) ===\n";
$newBotPayload = [
    'name' => 'Bot Gastronomie & Saveurs Djerba',
    'icon' => '🍽️',
    'theme' => 'Gastronomie, Saveurs & Restaurants',
    'description' => 'Mise en avant des spécialités culinaires djerbiennes, poissons frais et meilleures tables de l\'île.',
    'schedule' => '6h',
    'status' => 'active',
    'ai_agents' => [
        'text' => 'gemini-1.5-pro',
        'image' => 'nano-banana',
        'video' => 'none'
    ],
    'channels' => [
        'website' => true,
        'pdf' => true,
        'facebook_photo' => true,
        'facebook_reel' => false,
        'tiktok' => false
    ]
];

$ch = curl_init("$baseUrl/api.php?action=bot_save");
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($newBotPayload),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_RETURNTRANSFER => true
]);
$createRes = curl_exec($ch);
curl_close($ch);
$created = json_decode($createRes, true);

if ($created && ($created['success'] ?? false)) {
    $newBotId = $created['bot']['id'];
    echo "✓ Bot Created successfully: ID = $newBotId ({$created['bot']['name']})\n";
    
    // Test Toggle
    echo "\n=== 5. Testing POST /api.php?action=bot_toggle ===\n";
    $ch = curl_init("$baseUrl/api.php?action=bot_toggle");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(['id' => $newBotId]),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true
    ]);
    $toggleRes = curl_exec($ch);
    curl_close($ch);
    echo "Toggle response: $toggleRes\n";

    // Test Delete
    echo "\n=== 6. Testing POST /api.php?action=bot_delete ===\n";
    $ch = curl_init("$baseUrl/api.php?action=bot_delete");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(['id' => $newBotId]),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true
    ]);
    $delRes = curl_exec($ch);
    curl_close($ch);
    echo "Delete response: $delRes\n";
} else {
    echo "✗ Bot creation failed: $createRes\n";
}

echo "\n=== 7. Testing GET / (Index Page) ===\n";
$html = @file_get_contents("$baseUrl/");
if ($html !== false && strpos($html, 'Studio Multi-Bots IA') !== false) {
    echo "✓ Index HTML loaded with Multi-Bots UI (" . strlen($html) . " bytes)\n";
} else {
    echo "✗ Failed loading index HTML\n";
}
