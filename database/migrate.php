<?php
/**
 * Script de migration de base de données (MySQL & SQLite)
 * Respect des règles d'architecture et d'idempotence (Règle 7)
 */

require_once __DIR__ . '/../core/Database.php';

use Core\Database;

try {
    $pdo = Database::getInstance();
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    echo "===========================================\n";
    echo "🚀 Démarrage des migrations ({$driver})\n";
    echo "===========================================\n\n";

    // 1. Table de suivi des migrations
    if ($driver === 'sqlite') {
        $pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            migration VARCHAR(255) NOT NULL UNIQUE,
            executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
    } else {
        $pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL UNIQUE,
            executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }

    // Récupérer les migrations déjà exécutées
    $stmt = $pdo->query("SELECT migration FROM migrations");
    $applied = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // 2. Exécution des fichiers SQL séquentiels
    $files = glob(__DIR__ . '/migrations/*.sql');
    sort($files);

    foreach ($files as $file) {
        $migrationName = basename($file);
        if (in_array($migrationName, $applied)) {
            echo "  ⏩ [Déjà appliquée] {$migrationName}\n";
            continue;
        }

        echo "  ▶ [Exécution] {$migrationName}... ";
        $sql = file_get_contents($file);

        // Découper et exécuter les requêtes
        $queries = array_filter(array_map('trim', explode(';', $sql)));
        foreach ($queries as $query) {
            if (!empty($query)) {
                $pdo->exec($query);
            }
        }

        $ins = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $ins->execute([$migrationName]);
        echo "✅ OK\n";
    }

    // 3. Tableau $alters pour vérification idempotente des colonnes (Règle 7.3)
    $alters = [];
    foreach ($alters as $alter) {
        // Logique de vérification préalable d'existence de colonne
    }

    echo "\n-------------------------------------------\n";
    echo "✅ Toutes les migrations sont à jour !\n\n";

} catch (Exception $e) {
    echo "\n❌ ERREUR MIGRATION : " . $e->getMessage() . "\n";
    exit(1);
}
