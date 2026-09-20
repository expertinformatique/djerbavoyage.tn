<?php
$res = file_get_contents('http://192.168.0.129/api.php?action=logs&lines=60');
$data = json_decode($res, true);
echo "=== LOG CONTENT ===\n";
echo $data['content'] ?? 'NO CONTENT';
echo "\n";
