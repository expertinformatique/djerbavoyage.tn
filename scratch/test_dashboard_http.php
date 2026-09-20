<?php

$baseUrl = 'http://192.168.0.129';

echo "=== 1. Testing GET / (Index Page) ===\n";
$html = @file_get_contents($baseUrl . '/');
if ($html !== false && strpos($html, 'Centre de Contrôle Bot') !== false) {
    echo "✓ Index HTML loaded successfully (" . strlen($html) . " bytes)\n";
} else {
    echo "✗ Failed loading index HTML\n";
    echo substr($html, 0, 300) . "\n";
}

echo "\n=== 2. Testing GET /api.php?action=status ===\n";
$statusJson = @file_get_contents($baseUrl . '/api.php?action=status');
$status = json_decode($statusJson, true);
if ($status && ($status['success'] ?? false) === true) {
    echo "✓ Status API OK:\n";
    echo "  - Bot Active: " . ($status['bot']['cron_active'] ? 'YES' : 'NO') . " (" . $status['bot']['schedule_label'] . ")\n";
    echo "  - Bot Running: " . ($status['bot']['is_running'] ? 'YES' : 'NO') . "\n";
    echo "  - Log File Size: " . $status['bot']['log_size_kb'] . " KB\n";
    echo "  - Server Time: " . $status['system']['server_time'] . "\n";
    echo "  - System Load: " . $status['system']['load_average'] . "\n";
    echo "  - Memory Usage: " . $status['system']['memory']['percent'] . "% (" . $status['system']['memory']['used_mb'] . " / " . $status['system']['memory']['total_mb'] . " MB)\n";
    echo "  - Disk Usage: " . $status['system']['disk']['percent'] . "% (" . $status['system']['disk']['used_gb'] . " / " . $status['system']['disk']['total_gb'] . " GB)\n";
} else {
    echo "✗ Status API failed: " . $statusJson . "\n";
}

echo "\n=== 3. Testing GET /api.php?action=history ===\n";
$historyJson = @file_get_contents($baseUrl . '/api.php?action=history');
$history = json_decode($historyJson, true);
if ($history && ($history['success'] ?? false) === true) {
    echo "✓ History API OK: " . count($history['runs']) . " runs found (Total in log: " . $history['total'] . ").\n";
    if (!empty($history['runs'])) {
        $first = $history['runs'][0];
        echo "  - Latest run: " . ($first['published_at'] ?? 'N/A') . " | Title: " . ($first['title'] ?? 'N/A') . "\n";
        echo "  - Status: " . ($first['status'] ?? 'N/A') . " | Image: " . ($first['image'] ? 'Yes' : 'No') . "\n";
        echo "  - Facebook: " . (($first['facebook']['published'] ?? false) ? 'YES' : 'NO') . " | Reel: " . (($first['reel']['published'] ?? false) ? 'YES' : 'NO') . "\n";
    }
} else {
    echo "✗ History API failed: " . $historyJson . "\n";
}

echo "\n=== 4. Testing GET /api.php?action=logs&lines=10 ===\n";
$logsJson = @file_get_contents($baseUrl . '/api.php?action=logs&lines=10');
$logs = json_decode($logsJson, true);
if ($logs && ($logs['success'] ?? false) === true) {
    echo "✓ Logs API OK (" . strlen($logs['content'] ?? '') . " chars returned, total lines: " . ($logs['total_lines'] ?? 0) . ")\n";
} else {
    echo "✗ Logs API failed: " . $logsJson . "\n";
}

echo "\n=== 5. Testing GET /api.php?action=test_api ===\n";
$testApiJson = @file_get_contents($baseUrl . '/api.php?action=test_api');
$testApi = json_decode($testApiJson, true);
if ($testApi && ($testApi['success'] ?? false) === true) {
    echo "✓ Target Website Connectivity OK: HTTP " . $testApi['http_code'] . " in " . $testApi['latency_seconds'] . "s\n";
} else {
    echo "✗ Test API Connectivity returned: " . $testApiJson . "\n";
}
