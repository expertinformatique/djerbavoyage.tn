-- ============================================================================
-- Migration 014 : Nettoyage des titres d'articles (Suppression des horaires)
-- Idempotence et compatibilité SQLite / MySQL
-- ============================================================================

UPDATE articles SET title_fr = REPLACE(title_fr, 'ce jour ', '') WHERE title_fr LIKE '%ce jour%';
