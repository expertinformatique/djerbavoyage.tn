-- Migration 017: Support multi-langue complet pour les articles (Arabe et Anglais)
ALTER TABLE `articles` ADD COLUMN `title_ar` VARCHAR(255) NULL AFTER `title_en`;
ALTER TABLE `articles` ADD COLUMN `content_ar` LONGTEXT NULL AFTER `content_en`;
