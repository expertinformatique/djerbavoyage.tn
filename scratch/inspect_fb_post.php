<?php
$token = "EAAfUfAaCJ84BSvagEKS6pTZCaoeRSrZB5nFmMH8ri3r7pCVcNeyvI4BueGxqO1Jrwb5xpEImrn7nE2Or3x9gKWdV1N0gsJEoT1CuyMPb6B06sMZBAiWVjr50Ya5riiaUaoNo4lqE29Wy62dTdB6qbWD1xXAadAGLJnXFeGL2TEITFQ2B1xCgpaEAhkv4jfGi1IaoaZBHUJM3nkavle0ZD";
$url = "https://graph.facebook.com/v19.0/136561653049793/published_posts?fields=id,message,created_time&limit=2&access_token=" . urlencode($token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
curl_close($ch);

echo "PAGE FEED INSPECTION:\n";
$data = json_decode($res, true);
print_r($data);
