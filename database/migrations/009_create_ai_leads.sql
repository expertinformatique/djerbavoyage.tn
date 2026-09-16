-- Migration 009 : Création de la table des leads IA & demandes de séjour sur-mesure
CREATE TABLE IF NOT EXISTS ai_leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(191) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    travel_date VARCHAR(50) DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    preferences_json TEXT DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    status VARCHAR(50) DEFAULT 'new',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
