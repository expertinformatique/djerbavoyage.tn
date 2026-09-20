<?php
$pageId = "136561653049793";
$token = $_ENV['FB_PAGE_ACCESS_TOKEN'] ?? getenv('FB_PAGE_ACCESS_TOKEN') ?: 'YOUR_FACEBOOK_PAGE_ACCESS_TOKEN';

// Test POST /{page-id}/photo_stories
$ch = curl_init("https://graph.facebook.com/v19.0/{$pageId}/photo_stories");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'access_token' => $token
]));
$res = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "POST photo_stories HTTP: $code\n";
echo "Response: $res\n";
