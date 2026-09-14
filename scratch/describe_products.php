<?php
require_once __DIR__ . '/../core/Database.php';

use Core\Database;

$pdo = Database::getInstance();
$stmt = $pdo->query("DESCRIBE products");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
