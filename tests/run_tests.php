<?php
/**
 * Test Runner - Djerba Voyage
 * Exécution : php tests/run_tests.php
 */

require_once __DIR__ . '/TestCase.php';

// ROOT_PATH requis par Lang pour charger les fichiers de traduction
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}
require_once ROOT_PATH . '/core/helpers.php';

spl_autoload_register(function ($class) {
    $prefixes = [
        'App\\' => __DIR__ . '/../src/',
        'Core\\' => __DIR__ . '/../core/',
        'Tests\\' => __DIR__ . '/../tests/'
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        if (str_starts_with($class, $prefix)) {
            $rel = substr($class, strlen($prefix));
            $file = $baseDir . str_replace('\\', '/', $rel) . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
});

use Core\Database;
use PHPUnit\Framework\TestCase;

echo "===========================================\n";
echo "🧪 Lancement de la suite de tests unitaires\n";
echo "===========================================\n\n";

// Configuration Base de Données SQLite en mémoire pour les tests
$sqlitePdo = new \PDO('sqlite::memory:');
$sqlitePdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

// Création des tables requises en SQLite
$sqlitePdo->exec("
    CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        slug TEXT UNIQUE,
        title_fr TEXT,
        price_eur REAL,
        file_path TEXT,
        is_active INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_number TEXT UNIQUE,
        customer_email TEXT,
        total_amount REAL,
        currency TEXT DEFAULT 'EUR',
        stripe_session_id TEXT UNIQUE,
        status TEXT DEFAULT 'pending',
        type TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS download_tokens (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_id INTEGER,
        product_id INTEGER,
        token TEXT UNIQUE,
        downloads_left INTEGER DEFAULT 5,
        expires_at DATETIME,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS local_services (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category TEXT,
        slug TEXT UNIQUE,
        name TEXT,
        short_description TEXT,
        price_eur REAL,
        unit_label TEXT,
        duration_label TEXT,
        location_label TEXT,
        badge TEXT,
        image_url TEXT,
        is_active INTEGER DEFAULT 1,
        sort_order INTEGER DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS service_bookings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_id INTEGER,
        service_id INTEGER,
        scheduled_date TEXT,
        scheduled_time TEXT,
        guests_count INTEGER DEFAULT 1,
        unit_price REAL,
        total_price REAL,
        notes TEXT,
        status TEXT DEFAULT 'confirmed',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS airport_transfers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_id INTEGER,
        flight_number TEXT,
        airline TEXT,
        arrival_date TEXT,
        arrival_time TEXT,
        passengers_count INTEGER DEFAULT 1,
        dropoff_location TEXT,
        phone_whatsapp TEXT,
        status TEXT DEFAULT 'pending',
        driver_notes TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS concierge_tickets (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_id INTEGER,
        client_name TEXT,
        client_email TEXT,
        travel_dates TEXT,
        status TEXT DEFAULT 'new',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS service_reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        service_id INTEGER,
        author_name TEXT,
        rating INTEGER DEFAULT 5,
        comment TEXT,
        is_verified INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS newsletter_subscribers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT UNIQUE,
        status TEXT DEFAULT 'active',
        token TEXT UNIQUE,
        ip_address TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        unsubscribed_at DATETIME DEFAULT NULL
    );
    CREATE TABLE IF NOT EXISTS ai_leads (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        phone TEXT,
        travel_date TEXT,
        notes TEXT,
        preferences_json TEXT,
        ip_address TEXT,
        status TEXT DEFAULT 'new',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS contact_messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        phone TEXT,
        subject TEXT,
        message TEXT NOT NULL,
        ip_address TEXT,
        status TEXT DEFAULT 'new',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS settings (
        setting_key TEXT PRIMARY KEY,
        setting_value TEXT,
        setting_group TEXT DEFAULT 'general'
    );
    CREATE TABLE IF NOT EXISTS spam_rate_limits (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ip TEXT NOT NULL,
        action TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS articles (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        destination_id INTEGER NULL,
        slug TEXT UNIQUE,
        title_fr TEXT NOT NULL,
        title_en TEXT NULL,
        content_fr TEXT NOT NULL,
        content_en TEXT NULL,
        featured_image TEXT NULL,
        status TEXT DEFAULT 'published',
        views_count INTEGER DEFAULT 0,
        published_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        seo_description TEXT NULL,
        meta_keywords TEXT NULL,
        summary_ai TEXT NULL,
        schema_json TEXT NULL,
        pdf_enabled INTEGER DEFAULT 1,
        pdf_price_eur REAL DEFAULT 2.99,
        cta_services_json TEXT NULL,
        author_name TEXT DEFAULT 'IA Voyageur Djerba'
    );
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE,
        email TEXT UNIQUE,
        password TEXT,
        role TEXT DEFAULT 'admin',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
");

// Données initiales pour les tests
$sqlitePdo->exec("INSERT INTO products (id, slug, title_fr, price_eur, file_path) VALUES (1, 'guide-test', 'Guide Test', 9.90, 'storage/downloads/test.pdf')");
$sqlitePdo->exec("INSERT INTO orders (id, order_number, customer_email, total_amount, stripe_session_id, status, type) VALUES (1, 'CMD-TEST', 'client@test.tn', 9.90, 'sess_test', 'paid', 'digital_product')");
$sqlitePdo->exec("INSERT INTO users (id, username, email, password, role) VALUES (1, 'admin', 'admin@djerbavoyage.tn', '\$2y\$10\$abcdefghijklmnopqrstuv', 'admin')");

Database::setInstance($sqlitePdo);

// Découverte et exécution des tests
$testFiles = glob(__DIR__ . '/Unit/*Test.php');
$totalTests = 0;
$failedTests = 0;

foreach ($testFiles as $file) {
    require_once $file;
    $className = 'Tests\\Unit\\' . basename($file, '.php');

    if (!class_exists($className)) continue;

    $reflection = new \ReflectionClass($className);
    $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

    echo "▶ Classe : " . basename($file, '.php') . "\n";

    foreach ($methods as $method) {
        if (!str_starts_with($method->getName(), 'test')) continue;

        // Réinitialisation variables globales & session
        $_POST = [];
        $_GET = [];
        $_SESSION = [];

        $testInstance = new $className();
        $totalTests++;

        try {
            if (method_exists($testInstance, 'runSetUp')) {
                $testInstance->runSetUp();
            }

            $method->invoke($testInstance);

            if (method_exists($testInstance, 'runTearDown')) {
                $testInstance->runTearDown();
            }

            echo "  ✔ " . $method->getName() . "\n";
        } catch (\Throwable $e) {
            $failedTests++;
            echo "  ✖ " . $method->getName() . " -> Erreur : " . $e->getMessage() . "\n";
        }
    }
    echo "\n";
}

echo "-------------------------------------------\n";
echo "Résultats : $totalTests test(s), " . TestCase::$assertionsCount . " assertion(s)\n";

if ($failedTests > 0) {
    echo "❌ $failedTests test(s) ont échoué !\n";
    exit(1);
} else {
    echo "✅ 100% des tests ont réussi avec succès !\n";
    exit(0);
}
