<?php

$baseUrl = 'http://192.168.0.129';

$bots = [
    [
        'id' => 'bot_guide_patrimoine',
        'name' => 'Guide Culture, Histoire & UNESCO',
        'description' => 'Récits historiques, villages traditionnels (Erriadh, Guellala, Ajim), patrimoine UNESCO et légendes de Djerba.',
        'icon' => '🏛️',
        'theme' => 'Culture, Patrimoine & UNESCO',
        'status' => 'active',
        'schedule' => '15m',
        'target_destination' => [
            'site_name' => 'Djerba Voyage',
            'site_url' => 'https://djerbavoyage.tn',
            'api_endpoint' => 'https://djerbavoyage.tn/api/auto-blog/generate',
            'api_secret_token' => 'djerba_secret_cron_key_2026'
        ],
        'social_destinations' => [
            'facebook_page_name' => 'Djerba Voyage Officiel',
            'facebook_page_id' => '104192661073862',
            'facebook_access_token' => ''
        ],
        'ai_agents' => [
            'text' => 'gemini-2.5-flash',
            'image' => 'nano-banana',
            'video' => 'reel-5photo-kenburns'
        ],
        'channels' => [
            'website' => true,
            'pdf' => true,
            'facebook_photo' => true,
            'facebook_reel' => true,
            'facebook_story' => true
        ]
    ],
    [
        'id' => 'bot_menzels_hotels',
        'name' => 'Menzels de Charme & Hébergements',
        'description' => 'Mise en valeur de l\'architecture unique des Menzels djerbiens, maisons d\'hôtes de luxe et éco-lodges de l\'île.',
        'icon' => '🏡',
        'theme' => 'Menzels & Hôtels de Charme',
        'status' => 'active',
        'schedule' => '2h',
        'target_destination' => [
            'site_name' => 'Djerba Voyage',
            'site_url' => 'https://djerbavoyage.tn',
            'api_endpoint' => 'https://djerbavoyage.tn/api/auto-blog/generate',
            'api_secret_token' => 'djerba_secret_cron_key_2026'
        ],
        'social_destinations' => [
            'facebook_page_name' => 'Djerba Voyage Officiel',
            'facebook_page_id' => '104192661073862',
            'facebook_access_token' => ''
        ],
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
            'facebook_story' => true
        ]
    ],
    [
        'id' => 'bot_kitesurf_activites',
        'name' => 'Kitesurf, Plages & Aventures Nautiques',
        'description' => 'Guides spots de kitesurf, lagune de Djerba, excursions en catamaran, plongée et activités sportives outdoor.',
        'icon' => '🏄‍♂️',
        'theme' => 'Kitesurf, Plages & Sports Nautiques',
        'status' => 'active',
        'schedule' => '4h',
        'target_destination' => [
            'site_name' => 'Djerba Voyage',
            'site_url' => 'https://djerbavoyage.tn',
            'api_endpoint' => 'https://djerbavoyage.tn/api/auto-blog/generate',
            'api_secret_token' => 'djerba_secret_cron_key_2026'
        ],
        'social_destinations' => [
            'facebook_page_name' => 'Djerba Voyage Officiel',
            'facebook_page_id' => '104192661073862',
            'facebook_access_token' => ''
        ],
        'ai_agents' => [
            'text' => 'gemini-2.5-flash',
            'image' => 'nano-banana',
            'video' => 'reel-5photo-kenburns'
        ],
        'channels' => [
            'website' => true,
            'pdf' => true,
            'facebook_photo' => true,
            'facebook_reel' => true,
            'facebook_story' => true
        ]
    ]
];

foreach ($bots as $b) {
    $ch = curl_init("$baseUrl/api.php?action=bot_save");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($b),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true
    ]);
    $res = curl_exec($ch);
    curl_close($ch);
    echo "Saved: {$b['name']} -> $res\n";
}
