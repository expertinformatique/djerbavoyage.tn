<?php
// Test des capacités Stories et Reels pour la page Facebook
$pageId = "136561653049793";
$token = $_ENV['FB_PAGE_ACCESS_TOKEN'] ?? getenv('FB_PAGE_ACCESS_TOKEN') ?: 'YOUR_FACEBOOK_PAGE_ACCESS_TOKEN';

echo "1. Checking Page Stories endpoint...\n";
$urlStories = "https://graph.facebook.com/v19.0/{$pageId}/photo_stories?access_token=" . urlencode($token);
$ch = curl_init($urlStories);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "Stories HTTP code: $code\n";
echo "Stories response: " . substr($res, 0, 300) . "\n\n";

echo "2. Checking Video Reels endpoint initialization...\n";
$urlReels = "https://graph.facebook.com/v19.0/{$pageId}/video_reels";
$ch = curl_init($urlReels);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'upload_phase' => 'start',
    'access_token' => $token
]));
$res2 = curl_exec($ch);
$code2 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch2 ?? $ch);
echo "Reels HTTP code: $code2\n";
echo "Reels response: " . substr($res2, 0, 300) . "\n";
