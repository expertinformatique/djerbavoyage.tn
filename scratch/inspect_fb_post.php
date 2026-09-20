<?php
$token = $_ENV['FB_PAGE_ACCESS_TOKEN'] ?? getenv('FB_PAGE_ACCESS_TOKEN') ?: 'YOUR_FACEBOOK_PAGE_ACCESS_TOKEN';
$url = "https://graph.facebook.com/v19.0/136561653049793/published_posts?fields=id,message,created_time&limit=2&access_token=" . urlencode($token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
curl_close($ch);

echo "PAGE FEED INSPECTION:\n";
$data = json_decode($res, true);
print_r($data);
