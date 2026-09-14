# Plateforme de Voyage Djerba — Cahier des Charges Technique & Architecture From Scratch

> **Architecture Technique** : PHP 8.2+ (MVC / Repository Pattern / DI Container / Multi-layer Cache), MySQL / MariaDB (PDO), Vanilla JavaScript (ES6 Modules), CSS3 Ultra-Modulaire, SDK `stripe/stripe-php` et suite de tests **PHPUnit**.
> **Règles d'Ingénierie & Contrôle Backend** :
> 1. **Script de Seeding de Données Initiales (`seeder.php`)** : Population automatique de la base de données avec des destinations, articles, produits PDF, compte admin et paramètres pour un test immédiat sous Laragon.
> 2. **Page Analytics "Google Analytics Like"** : Tableau de bord de statistiques internes en temps réel (`/admin/analytics`).
> 3. **Système d'Audit & Anti-Fraude** : Détection automatique des fraudes de paiement, blocage IP, traqueur de bugs et alertes en temps réel.
> 4. **Back-Office 100% Paramétrable** : Contrôle dynamique via la table SQL `settings` (Zero Hardcoding).
> 5. **Modularité Stricte** : Fichiers légers (~100-150 lignes max par fichier).
> 6. **Nommage CSS Sémantique** : Convention **BEM** avec préfixes (`c-`, `l-`, `u-`, `is-`).
> 7. **Tableaux avec Pagination AJAX** : Pagination dynamique sans aucun rechargement de page.
> 8. **Moteur d'Animations Frontend** : Scroll reveal (`IntersectionObserver`), skeletons et transitions 60 FPS.
> 9. **Optimisation SEO / GEO & Marketing** : SEO classique, GEO (Agents IA ChatGPT/Gemini/Perplexity via `/llms.txt`), JSON-LD.

---

## 1. Résumé du Projet & Business Model

Un site web de voyage premium axé sur **Djerba (Tunisie)**, combinant un portail média SEO/GEO à haute conversion et des canaux de monétisation directs :

1. **Commissions d'affiliation** : Hôtels (Booking.com), Excursions (GetYourGuide, Viator), Vols.
2. **Micro-paiements e-commerce (Produits Numériques)** : Vente de guides PDF, cartes interactives et itinéraires thématiques.
3. **Service de Conciergerie Payant sur-mesure** : Création d'itinéraires personnalisés à la demande.

---

## 2. Script de Seeding Initial de la Base de Données (`seeder.php`)

Pour permettre un test immédiat de l'application sur Laragon dès l'import du fichier `schema.sql`, le script `seeder.php` peuple automatiquement la base de données avec des données de démonstration réalistes.

**Exécution** : `php seeder.php` ou accès via navigateur sur `http://voyage.test/seeder.php`.

```php
<?php
/**
 * Script d'initialisation et de population de la base de données (Database Seeder)
 */
require_once __DIR__ . '/config/database.php';

try {
    $pdo = Database::getInstance();
    echo "🌱 Démarrage du Seeding de la base de données djerba_voyage...\n";

    // 1. Inscription du Compte Administrateur Principal (Mot de passe: admin123)
    $passwordHash = password_hash('admin123', PASSWORD_ARGON2ID);
    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password, role)
        VALUES ('admin', 'admin@djerba-voyage.tn', :pass, 'admin')
        ON DUPLICATE KEY UPDATE password = :pass
    ");
    $stmt->execute(['pass' => $passwordHash]);
    echo "✅ Administrateur créé : admin / admin123\n";

    // 2. Population des Paramètres Globaux (settings)
    $settings = [
        ['site_name', 'Djerba Voyage - Guide Officiel & Conciergerie', 'general'],
        ['contact_email', 'contact@djerba-voyage.tn', 'general'],
        ['currency', 'EUR', 'pricing'],
        ['concierge_price', '29.00', 'pricing'],
        ['stripe_mode', 'test', 'stripe'],
        ['booking_partner_id', 'booking_djerba_123', 'affiliates'],
        ['getyourguide_partner_id', 'gyg_djerba_456', 'affiliates'],
        ['meta_title_default', 'Visiter Djerba : Guides, Hôtels et Itinéraires Sur-Mesure 2026', 'seo'],
        ['meta_description_default', 'Découvrez Djerba avec nos guides complets : Houmt Souk, Djerbahood, plages de Sidi Mahres. Service de conciergerie personnalisée.', 'seo'],
    ];
    $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value, setting_group) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    foreach ($settings as $s) { $stmt->execute($s); }
    echo "✅ Paramètres globaux initialisés dans la table settings.\n";

    // 3. Population des Destinations Populaires
    $destinations = [
        ['houmt-souk', 'Houmt Souk', 'Houmt Souk', 'La capitale animée de Djerba, connue pour ses souks colorés, ses fondouks historiques et sa marina.'],
        ['sidi-mahres', 'Plage de Sidi Mahres', 'Sidi Mahres Beach', 'La plus belle plage de sable fin de Djerba avec ses hôtels d\'exception et ses eaux turquoise.'],
        ['midoun', 'Midoun', 'Midoun', 'Deuxième ville de l\'île, réputée pour ses marchés traditionnels et ses vergers d\'oliviers.'],
        ['aghir', 'Aghir', 'Aghir', 'Zone côtière paisible au sud-est, idéale pour le kitesurf et la détente au calme.']
    ];
    $stmt = $pdo->prepare("INSERT INTO destinations (slug, name_fr, name_en, description_fr) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE name_fr = VALUES(name_fr)");
    foreach ($destinations as $d) { $stmt->execute($d); }
    echo "✅ 4 Destinations Djerba insérées.\n";

    // 4. Population des Produits Numériques (PDF)
    $products = [
        ['guide-djerbahood-2026', 'Guide Ultime Djerbahood & Street Art 2026 (PDF)', 4.90, 'storage/downloads/guide-djerbahood-2026.pdf'],
        ['carte-restaurants-djerba', 'Carte Secretes des Meilleurs Restaurants & Ryads (PDF)', 3.50, 'storage/downloads/carte-restaurants-djerba.pdf'],
        ['pack-complet-djerba-7j', 'Pack Voyageur Complet Djerba en 7 Jours (PDF)', 7.90, 'storage/downloads/pack-complet-djerba-7j.pdf']
    ];
    $stmt = $pdo->prepare("INSERT INTO products (slug, title_fr, price_eur, file_path) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE price_eur = VALUES(price_eur)");
    foreach ($products as $p) { $stmt->execute($p); }
    echo "✅ 3 Produits Numériques PDF créés.\n";

    // 5. Population d'Articles Blog SEO
    $articles = [
        [1, 'meilleure-periode-visiter-djerba', 'Quelle est la meilleure période pour visiter Djerba ?', '<p>Djerba bénéficie d\'un climat méditerranéen très doux...</p>', 'published'],
        [1, 'guide-complet-djerbahood', 'Guide Complet de Djerbahood : Le Musée de Street Art à Ciel Ouvert', '<p>Situé dans le village d\'Erriadh, Djerbahood regroupe plus de 250 fresques...</p>', 'published']
    ];
    $stmt = $pdo->prepare("INSERT INTO articles (destination_id, slug, title_fr, content_fr, status) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE title_fr = VALUES(title_fr)");
    foreach ($articles as $a) { $stmt->execute($a); }
    echo "✅ Articles de blog SEO insérés.\n";

    echo "🎉 Seeding terminé avec succès ! Vous pouvez tester l'application.\n";

} catch (Exception $e) {
    echo "❌ Erreur Seeding : " . $e->getMessage() . "\n";
}
```

---

## 3. Page d'Analytics Interne (Style Google Analytics) (`/admin/analytics`)

- Suivi autonome et RGPD des visites via `page_views`.
- Widget visiteurs en direct, KPI Cards, graphiques Chart.js et filtres de période AJAX.

---

## 4. Système d'Audit, Anti-Fraude & Traqueur de Bugs

- Table SQL `audit_logs` avec niveaux de sévérité.
- Validation des prix Stripe (`FraudDetectionService.php`) et bannissement d'IP.
- Handler d'exceptions global (`ExceptionHandler.php`) et interface `/admin/audit`.

---

## 5. Back-Office d'Administration Intégral & Configuration Dynamique

- Panneau de configuration global via la table SQL `settings`.
- CMS Contenu, Boutique PDF, Conciergerie et Médiathèque.

---

## 6. Optimisation SEO / GEO & Marketing

- Fichier d'indexation IA `/llms.txt` à la racine.
- Micro-données JSON-LD Schema.org et balises OpenGraph.

---

## 7. Moteur d'Animations Frontend & Micro-Interactions (60 FPS)

- Animations au scroll via `IntersectionObserver` (`ScrollAnimate.js`).
- Skeleton Loading Shimmer pendant les chargements AJAX.

---

## 8. Architecture Modulaire des Fichiers (< 150 lignes max)

```text
d:/laragon/www/Voyage/
├── config/
│   ├── database.php
│   └── app.php
├── core/
├── src/
├── public/
├── seeder.php                 # Script d'initialisation de la base de données
├── views/
└── tests/
```

---

## 9. Base de Données SQL & Modélisation (MySQL / MariaDB)

Schéma DDL complet pour **phpMyAdmin** / Laragon.

```sql
CREATE DATABASE IF NOT EXISTS `djerba_voyage` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `djerba_voyage`;

-- 1. Table des Statistiques Analytics
CREATE TABLE IF NOT EXISTS `page_views` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `url_path` VARCHAR(255) NOT NULL,
  `referrer_domain` VARCHAR(150) DEFAULT 'Direct',
  `device_type` ENUM('mobile', 'tablet', 'desktop') NOT NULL DEFAULT 'desktop',
  `browser` VARCHAR(50) DEFAULT 'Unknown',
  `country_code` CHAR(2) DEFAULT 'FR',
  `session_id` VARCHAR(64) NOT NULL,
  `ip_hash` VARCHAR(64) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_created_url` (`created_at`, `url_path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Table des Logs d'Audit & Détection de Fraudes
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `event_type` VARCHAR(100) NOT NULL,
  `severity` ENUM('info', 'warning', 'critical') NOT NULL DEFAULT 'info',
  `message` TEXT NOT NULL,
  `payload_json` JSON DEFAULT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Table des Paramètres Globaux
CREATE TABLE IF NOT EXISTS `settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT,
  `setting_group` VARCHAR(50) DEFAULT 'general',
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Table des Administrateurs
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'editor') NOT NULL DEFAULT 'admin',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Table des Destinations
CREATE TABLE IF NOT EXISTS `destinations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `name_fr` VARCHAR(150) NOT NULL,
  `name_en` VARCHAR(150) NOT NULL,
  `description_fr` TEXT,
  `image_url` VARCHAR(255),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Table des Articles & Guides Blog
CREATE TABLE IF NOT EXISTS `articles` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `destination_id` INT UNSIGNED NULL,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `title_fr` VARCHAR(255) NOT NULL,
  `content_fr` LONGTEXT NOT NULL,
  `featured_image` VARCHAR(255),
  `status` ENUM('draft', 'published') NOT NULL DEFAULT 'published',
  `views_count` INT UNSIGNED DEFAULT 0,
  `published_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`destination_id`) REFERENCES `destinations`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Table des Produits Numériques
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `title_fr` VARCHAR(200) NOT NULL,
  `price_eur` DECIMAL(10,2) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Table des Commandes Stripe
CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_number` VARCHAR(50) NOT NULL UNIQUE,
  `customer_email` VARCHAR(150) NOT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `currency` VARCHAR(10) DEFAULT 'EUR',
  `stripe_session_id` VARCHAR(255) NOT NULL UNIQUE,
  `status` ENUM('pending', 'paid', 'failed', 'refunded') NOT NULL DEFAULT 'pending',
  `type` ENUM('digital_product', 'concierge') NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Table des Tokens de Téléchargement Sécurisés
CREATE TABLE IF NOT EXISTS `download_tokens` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL,
  `token` VARCHAR(64) NOT NULL UNIQUE,
  `downloads_left` INT UNSIGNED DEFAULT 5,
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Table des Demandes de Conciergerie Payante
CREATE TABLE IF NOT EXISTS `concierge_tickets` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT UNSIGNED NOT NULL,
  `client_name` VARCHAR(100) NOT NULL,
  `client_email` VARCHAR(150) NOT NULL,
  `travel_dates` VARCHAR(100) NOT NULL,
  `status` ENUM('new', 'in_progress', 'delivered') NOT NULL DEFAULT 'new',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 10. Strategic Roadmap Developpement (6 Semaines)

1. **Semaine 1** : Noyau MVC, Repositories, DI Container, **`seeder.php`** et `AnalyticsService.php`.
2. **Semaine 2** : CSS Sémantique BEM, Animations CSS3, Module `ScrollAnimate.js` et JSON-LD.
3. **Semaine 3** : Module `AjaxTable.js`, Modales Imbriquées (`ModalManager.js`), Onglets (`TabsManager.js`) et `ExitIntent.js`.
4. **Semaine 4** : Module Stripe Payment (`stripe/stripe-php`), Webhooks & Tokens.
5. **Semaine 5** : Back-Office Admin avec Dashboard Analytics (`/admin/analytics`) et Audit (`/admin/audit`).
6. **Semaine 6** : Tests PHPUnit de non-régression et recette globale avec le Seeder.
