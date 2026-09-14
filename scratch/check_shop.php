<?php
require_once __DIR__ . '/../core/Database.php';

use Core\Database;

$pdo = Database::getInstance();
$stmt = $pdo->query("SELECT id, name, category, price_eur, image_url FROM products");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Total Shop Products: " . count($rows) . "\n";
$catCount = [];
foreach ($rows as $row) {
    $cat = $row['category'] ?? 'uncategorized';
    $catCount[$cat] = ($catCount[$cat] ?? 0) + 1;
}

print_r($catCount);
