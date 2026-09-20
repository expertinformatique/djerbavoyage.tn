<?php
require_once __DIR__ . '/../core/Database.php';
$pdo = Core\Database::getInstance();
$stmt = $pdo->query('SELECT id, title_fr, slug, featured_image, published_at FROM articles ORDER BY id DESC LIMIT 15');
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo $r['id'] . ' | ' . $r['published_at'] . ' | ' . $r['featured_image'] . ' | ' . mb_substr($r['title_fr'], 0, 50) . PHP_EOL;
}
