<?php

echo "=== 1. Test Agent Text avec Instructions Personnalisées (Gemini) ===\n";
$url1 = 'http://192.168.0.129/api.php?action=test_agent_text&agent_id=gemini-2.0-flash&instructions=' . urlencode("Sois bref et commence impérativement ta réponse par '[MODE BOT DJERBA]'");
$res1 = file_get_contents($url1);
$json1 = json_decode($res1, true);
echo "Statut: " . ($json1['success'] ? "✅ SUCCÈS" : "❌ ÉCHEC") . "\n";
echo "Modèle: " . ($json1['model_name'] ?? 'N/A') . " (Latence: " . ($json1['latency_ms'] ?? 0) . "ms)\n";
echo "Réponse: " . ($json1['response_text'] ?? ($json1['error'] ?? 'N/A')) . "\n\n";

echo "=== 2. Test Agent Text Gratuit avec Instructions (Pollinations) ===\n";
$url2 = 'http://192.168.0.129/api.php?action=test_agent_text&agent_id=pollinations-openai&instructions=' . urlencode("Commence par '[GUIDE VIP] '");
$res2 = file_get_contents($url2);
$json2 = json_decode($res2, true);
echo "Statut: " . ($json2['success'] ? "✅ SUCCÈS" : "❌ ÉCHEC") . "\n";
echo "Modèle: " . ($json2['model_name'] ?? 'N/A') . " (Latence: " . ($json2['latency_ms'] ?? 0) . "ms)\n";
echo "Réponse: " . ($json2['response_text'] ?? ($json2['error'] ?? 'N/A')) . "\n\n";

echo "=== 3. Test Bot Save avec Clés API Dédiées & Instructions ===\n";
$testBot = [
    'id' => 'bot-test-tabs-instructions',
    'name' => 'Bot Test Onglets & Clés',
    'icon' => '🌟',
    'theme' => 'Test Thématique Spéciale',
    'description' => 'Bot de validation des 6 onglets et des clés dédiées',
    'status' => 'paused',
    'schedule' => 'manual',
    'target_destination' => [
        'site_name' => 'Djerba Voyage',
        'site_url' => 'https://djerbavoyage.tn',
        'api_endpoint' => 'https://djerbavoyage.tn/api/auto-blog/generate',
        'api_secret_token' => 'djerba_secret_cron_key_2026'
    ],
    'social_destinations' => [
        'facebook_page_name' => 'Djerba Voyage Test',
        'facebook_page_id' => '123456789',
        'facebook_access_token' => 'test_token_fb'
    ],
    'ai_agents' => [
        'text' => 'gemini-2.0-flash',
        'image' => 'nano-banana',
        'video' => 'reel-5photo-kenburns'
    ],
    'custom_api_keys' => [
        'gemini_api_key' => 'AIzaSy_test_custom_key_gemini',
        'groq_api_key' => 'gsk_test_custom_key_groq'
    ],
    'custom_instructions' => 'Tu es un guide officiel passionné de Djerba La Douce.',
    'channels' => [
        'website' => true,
        'pdf' => false,
        'facebook_photo' => true,
        'facebook_reel' => false,
        'facebook_story' => true
    ]
];

$ctx = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($testBot)
    ]
]);
$res3 = file_get_contents('http://192.168.0.129/api.php?action=bot_save', false, $ctx);
$json3 = json_decode($res3, true);
echo "Sauvegarde Bot: " . ($json3['success'] ? "✅ SUCCÈS" : "❌ ÉCHEC") . "\n";

echo "=== 4. Vérification de la persistance des Clés & Instructions dans bots_list ===\n";
$res4 = file_get_contents('http://192.168.0.129/api.php?action=bots_list');
$json4 = json_decode($res4, true);
$foundBot = null;
foreach ($json4['bots'] as $b) {
    if ($b['id'] === 'bot-test-tabs-instructions') {
        $foundBot = $b;
        break;
    }
}
if ($foundBot) {
    echo "✅ Bot trouvé dans la liste!\n";
    echo "  - Custom Gemini Key: " . ($foundBot['custom_api_keys']['gemini_api_key'] ?? 'NON DÉFINI') . "\n";
    echo "  - Custom Groq Key: " . ($foundBot['custom_api_keys']['groq_api_key'] ?? 'NON DÉFINI') . "\n";
    echo "  - Custom Instructions: " . ($foundBot['custom_instructions'] ?? 'NON DÉFINI') . "\n";
} else {
    echo "❌ Bot non trouvé dans bots_list\n";
}

echo "=== 5. Nettoyage du bot de test ===\n";
$ctxDel = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode(['id' => 'bot-test-tabs-instructions'])
    ]
]);
$res5 = file_get_contents('http://192.168.0.129/api.php?action=bot_delete', false, $ctxDel);
$json5 = json_decode($res5, true);
echo "Suppression Bot: " . ($json5['success'] ? "✅ SUCCÈS" : "❌ ÉCHEC") . "\n";
