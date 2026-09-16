-- Migration 013: Extension de la table articles pour le générateur automatique et l'optimisation SEO/GEO
ALTER TABLE `articles` ADD COLUMN `title_en` VARCHAR(255) NULL AFTER `title_fr`;
ALTER TABLE `articles` ADD COLUMN `content_en` LONGTEXT NULL AFTER `content_fr`;
ALTER TABLE `articles` ADD COLUMN `seo_description` TEXT NULL;
ALTER TABLE `articles` ADD COLUMN `meta_keywords` VARCHAR(255) NULL;
ALTER TABLE `articles` ADD COLUMN `summary_ai` TEXT NULL;
ALTER TABLE `articles` ADD COLUMN `schema_json` TEXT NULL;
ALTER TABLE `articles` ADD COLUMN `pdf_enabled` TINYINT(1) DEFAULT 1;
ALTER TABLE `articles` ADD COLUMN `pdf_price_eur` DECIMAL(10,2) DEFAULT 2.99;
ALTER TABLE `articles` ADD COLUMN `cta_services_json` TEXT NULL;
ALTER TABLE `articles` ADD COLUMN `author_name` VARCHAR(100) DEFAULT 'IA Voyageur Djerba';
