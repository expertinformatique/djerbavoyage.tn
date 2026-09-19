<?php
require_once __DIR__ . '/../core/Database.php';

try {
    $pdo = Core\Database::getInstance();
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'fb_%'");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
