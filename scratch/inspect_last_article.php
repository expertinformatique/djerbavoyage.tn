<?php
require_once __DIR__ . '/../core/Database.php';
$pdo = Core\Database::getInstance();
$stmt = $pdo->query('SELECT id, title_fr, LENGTH(content_fr) as len, SUBSTRING(content_fr, 1, 500) as preview, featured_image FROM articles ORDER BY id DESC LIMIT 2');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
