<?php
$url = "https://image.pollinations.ai/prompt/Djerba?width=800&height=450&nologo=true";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
echo $res;
