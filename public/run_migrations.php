<?php
/**
 * Script d'urgence — Lancer les migrations via navigateur
 * ⚠️  SUPPRIMER CE FICHIER APRÈS USAGE ⚠️
 * Accès : https://djerbavoyage.tn/run_migrations.php?token=DjerbaSecureMigrate2026
 */

// ─── TOKEN DE SÉCURITÉ ──────────────────────────────────────────────────────
define('SECRET_TOKEN', 'DjerbaSecureMigrate2026');

if (empty($_GET['token']) || $_GET['token'] !== SECRET_TOKEN) {
    http_response_code(403);
    die('Accès refusé.');
}

// ─── BOOTSTRAP ──────────────────────────────────────────────────────────────
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/core/Database.php';

use Core\Database;

header('Content-Type: text/plain; charset=utf-8');

try {
    $pdo    = Database::getInstance();
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

    echo "===========================================\n";
    echo "🚀 Démarrage des migrations ({$driver})\n";
    echo "===========================================\n\n";

    // 1. Table de suivi
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

    // 2. Migrations déjà appliquées
    $stmt    = $pdo->query("SELECT migration FROM migrations");
    $applied = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // 3. Exécution séquentielle
    $migrationsDir = ROOT_PATH . '/database/migrations';
    $files         = glob($migrationsDir . '/*.sql');
    sort($files);

    foreach ($files as $file) {
        $name = basename($file);

        if (in_array($name, $applied)) {
            echo "  ⏩ [Déjà appliquée] {$name}\n";
            continue;
        }

        echo "  ▶ [Exécution] {$name}... ";
        $sql     = file_get_contents($file);
        $queries = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($queries as $query) {
            if (!empty($query)) {
                try {
                    $pdo->exec($query);
                } catch (\PDOException $qe) {
                    if (str_contains($qe->getMessage(), 'Duplicate column') || str_contains($qe->getMessage(), 'already exists')) {
                        // Idempotent: colonne déjà présente
                    } else {
                        throw $qe;
                    }
                }
            }
        }

        $ins = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $ins->execute([$name]);
        echo "✅ OK\n";
    }

    // Nettoyer les heures résiduelles et préfixes dans les titres existants des articles
    $stmt = $pdo->query("SELECT id, title_fr, title_en FROM articles WHERE title_fr LIKE '%ce jour%' OR title_fr LIKE 'Djerba :%' OR title_fr LIKE 'Évasion à Djerba :%' OR title_fr LIKE 'Voyager à Djerba :%' OR title_fr LIKE 'Guide Djerba :%' OR title_fr LIKE '%(%'");
    $articles = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    if ($stmt) $stmt->closeCursor();
    $cleanFn = function(string $title, bool $isEn = false): string {
        $title = preg_replace('/\s*\(\s*\d{1,2}[:h]\d{2}\s*\)\s*/iu', ' ', $title);
        $title = preg_replace('/\b\d{1,2}[:h]\d{2}\b/iu', '', $title);
        $title = preg_replace('/^(\s*djerba\s+)?(ce\s+jour|aujourd\'hui|today)\s*:\s*/iu', '', $title);
        $title = preg_replace('/^(djerba|évasion\s+à\s+djerba|voyager\s+à\s+djerba|guide\s+djerba|djerba\s+guide|djerba\s+getaway|djerba\s+travel)\s*:\s*/iu', '', $title);
        $title = trim(preg_replace('/^[\s:\-]+|[\s:\-]+$/u', '', $title));
        if (!empty($title) && !preg_match('/djerba|djerbien/iu', $title)) {
            $title .= $isEn ? ' in Djerba' : ' à Djerba';
        }
        return preg_replace('/\s{2,}/', ' ', $title);
    };
    $upd = $pdo->prepare("UPDATE articles SET title_fr = ?, title_en = ? WHERE id = ?");
    foreach ($articles as $art) {
        $cleanedFr = $cleanFn($art['title_fr'] ?? '');
        $cleanedEn = !empty($art['title_en']) ? $cleanFn($art['title_en'], true) : $art['title_en'];
        if ($cleanedFr !== $art['title_fr'] || $cleanedEn !== $art['title_en']) {
            $upd->execute([$cleanedFr, $cleanedEn, $art['id']]);
        }
    }

    echo "\n-------------------------------------------\n";
    echo "✅ Toutes les migrations sont à jour !\n\n";
    echo "⚠️  PENSEZ À SUPPRIMER CE FICHIER : public/run_migrations.php\n";

} catch (Exception $e) {
    echo "\n❌ ERREUR : " . $e->getMessage() . "\n";
    error_log("[" . date('Y-m-d H:i:s') . "] MIGRATION ERROR: " . $e->getMessage(), 3, ROOT_PATH . '/error.log');
    http_response_code(500);
}
