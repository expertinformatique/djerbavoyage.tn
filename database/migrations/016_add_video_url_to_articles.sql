-- Migration 016: Support des vidéos et Reels pour les articles du blog (Video SEO)
ALTER TABLE `articles` ADD COLUMN `video_url` VARCHAR(255) NULL;
