-- ============================================================================
-- Migration 015 : Nettoyage des préfixes et horodatages des titres d'articles
-- Idempotence et compatibilité SQLite / MySQL
-- ============================================================================

UPDATE articles SET title_fr = REPLACE(title_fr, 'Djerba : ', '') WHERE title_fr LIKE 'Djerba : %';
UPDATE articles SET title_fr = REPLACE(title_fr, 'Voyager à Djerba : ', '') WHERE title_fr LIKE 'Voyager à Djerba : %';
UPDATE articles SET title_fr = REPLACE(title_fr, 'Évasion à Djerba : ', '') WHERE title_fr LIKE 'Évasion à Djerba : %';
UPDATE articles SET title_fr = REPLACE(title_fr, 'Guide Djerba : ', '') WHERE title_fr LIKE 'Guide Djerba : %';
