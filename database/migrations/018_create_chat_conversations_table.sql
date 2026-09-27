-- Migration 018 : Création de la table des conversations du ChatBot IA
-- Compatible SQLite (tests unitaires) et MySQL (production)
CREATE TABLE IF NOT EXISTS chat_conversations (
    id VARCHAR(32) PRIMARY KEY,
    session_id VARCHAR(64) NOT NULL,
    client_name VARCHAR(255) DEFAULT NULL,
    client_email VARCHAR(255) DEFAULT NULL,
    client_phone VARCHAR(50) DEFAULT NULL,
    client_company VARCHAR(255) DEFAULT NULL,
    detected_need VARCHAR(255) DEFAULT NULL,
    summary TEXT DEFAULT NULL,
    messages_json TEXT NOT NULL,
    ip_hash VARCHAR(64) NOT NULL,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
