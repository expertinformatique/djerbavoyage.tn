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
    if ($driver === 'mysql') {
        @$pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    }
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
    $stmt->closeCursor();

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
    $alters = [
        ['table' => 'articles', 'column' => 'title_en', 'sql' => "ALTER TABLE articles ADD COLUMN title_en VARCHAR(255) NULL"],
        ['table' => 'articles', 'column' => 'content_en', 'sql' => "ALTER TABLE articles ADD COLUMN content_en TEXT NULL"],
        ['table' => 'articles', 'column' => 'seo_description', 'sql' => "ALTER TABLE articles ADD COLUMN seo_description TEXT NULL"],
        ['table' => 'articles', 'column' => 'meta_keywords', 'sql' => "ALTER TABLE articles ADD COLUMN meta_keywords VARCHAR(255) NULL"],
        ['table' => 'articles', 'column' => 'summary_ai', 'sql' => "ALTER TABLE articles ADD COLUMN summary_ai TEXT NULL"],
        ['table' => 'articles', 'column' => 'schema_json', 'sql' => "ALTER TABLE articles ADD COLUMN schema_json TEXT NULL"],
        ['table' => 'articles', 'column' => 'pdf_enabled', 'sql' => "ALTER TABLE articles ADD COLUMN pdf_enabled TINYINT(1) DEFAULT 1"],
        ['table' => 'articles', 'column' => 'pdf_price_eur', 'sql' => "ALTER TABLE articles ADD COLUMN pdf_price_eur DECIMAL(10,2) DEFAULT 2.99"],
        ['table' => 'articles', 'column' => 'cta_services_json', 'sql' => "ALTER TABLE articles ADD COLUMN cta_services_json TEXT NULL"],
        ['table' => 'articles', 'column' => 'author_name', 'sql' => "ALTER TABLE articles ADD COLUMN author_name VARCHAR(100) DEFAULT 'IA Voyageur Djerba'"],
    ];

    foreach ($alters as $alter) {
        $table = $alter['table'];
        $column = $alter['column'];
        $sql = $alter['sql'];

        if ($driver === 'sqlite') {
            $colsStmt = $pdo->query("PRAGMA table_info({$table})");
            $cols = $colsStmt->fetchAll(PDO::FETCH_COLUMN, 1);
            if (!in_array($column, $cols)) {
                $pdo->exec($sql);
            }
        } else {
            $colsStmt = $pdo->query("SHOW COLUMNS FROM `{$table}` LIKE '{$column}'");
            if ($colsStmt->rowCount() === 0) {
                $pdo->exec($sql);
            }
        }
    }

    if ($driver === 'mysql') {
        @$pdo->exec("ALTER TABLE articles MODIFY COLUMN featured_image TEXT NULL");
    }

    // Nettoyer les heures résiduelles dans les titres existants des articles
    $stmt = $pdo->query("SELECT id, title_fr FROM articles WHERE title_fr LIKE '%:%' OR title_fr LIKE '%(%'");
    $articles = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    if ($stmt) $stmt->closeCursor();
    $upd = $pdo->prepare("UPDATE articles SET title_fr = ? WHERE id = ?");
    foreach ($articles as $art) {
        $cleaned = preg_replace('/\s*ce jour\s*\(\d{1,2}[:h]\d{2}\)\s*:\s*/i', ' : ', $art['title_fr']);
        $cleaned = preg_replace('/\s*\(\d{1,2}[:h]\d{2}\)\s*/i', ' ', $cleaned);
        $cleaned = preg_replace('/\s*ce jour\s*:\s*/i', ' : ', $cleaned);
        $cleaned = preg_replace('/\s+/', ' ', trim($cleaned));
        $cleaned = ltrim($cleaned, ' :');
        if (!empty($cleaned) && $cleaned !== $art['title_fr']) {
            $upd->execute([$cleaned, $art['id']]);
        }
    }

    echo "\n-------------------------------------------\n";
    echo "✅ Toutes les migrations sont à jour !\n\n";

} catch (Exception $e) {
    echo "\n❌ ERREUR MIGRATION : " . $e->getMessage() . "\n";
    exit(1);
}
