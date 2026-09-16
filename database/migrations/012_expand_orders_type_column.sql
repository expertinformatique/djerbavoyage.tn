-- Migration 012: Modifier la colonne type dans la table orders pour supporter VARCHAR(50)
-- Évite l'erreur MySQL Warning 1265: Data truncated for column 'type'

ALTER TABLE orders MODIFY type VARCHAR(50) NOT NULL DEFAULT 'digital_product';
