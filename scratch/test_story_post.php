<?php
$pageId = "136561653049793";
$token = "EAAfUfAaCJ84BSvagEKS6pTZCaoeRSrZB5nFmMH8ri3r7pCVcNeyvI4BueGxqO1Jrwb5xpEImrn7nE2Or3x9gKWdV1N0gsJEoT1CuyMPb6B06sMZBAiWVjr50Ya5riiaUaoNo4lqE29Wy62dTdB6qbWD1xXAadAGLJnXFeGL2TEITFQ2B1xCgpaEAhkv4jfGi1IaoaZBHUJM3nkavle0ZD";

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
