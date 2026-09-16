-- Migration 008 : Table des abonnés Newsletter
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(150) NOT NULL UNIQUE,
  status VARCHAR(20) NOT NULL DEFAULT 'active',
  token VARCHAR(64) NOT NULL UNIQUE,
  ip_address VARCHAR(45) DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  unsubscribed_at DATETIME DEFAULT NULL
);
