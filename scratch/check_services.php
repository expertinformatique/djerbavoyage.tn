<?php
require_once __DIR__ . '/../core/Database.php';

use Core\Database;

$pdo = Database::getInstance();
$stmt = $pdo->query("SELECT id, name, category, price_eur, image_url FROM local_services WHERE is_active = 1");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Total Services Active: " . count($rows) . "\n";
foreach ($rows as $row) {
    echo "• ID {$row['id']} [{$row['category']}] {$row['name']} - {$row['price_eur']} € ({$row['image_url']})\n";
}
