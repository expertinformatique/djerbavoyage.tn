<?php
require_once __DIR__ . '/../core/Database.php';

use Core\Database;

$pdo = Database::getInstance();
$stmt = $pdo->query("SELECT category, COUNT(*) as total FROM local_services WHERE is_active = 1 GROUP BY category");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "===========================================\n";
echo "📊 COMPTE DES PRODUITS PAR FAMILLE (/services)\n";
echo "===========================================\n";

$grandTotal = 0;
foreach ($rows as $row) {
    echo " • " . str_pad($row['category'], 15) . " : " . $row['total'] . " produits\n";
    $grandTotal += (int)$row['total'];
}

echo "-------------------------------------------\n";
echo "TOTAL GÉNÉRAL : {$grandTotal} produits en base\n\n";
