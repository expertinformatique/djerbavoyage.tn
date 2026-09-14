-- Migration 003 : Avis clients vérifiés et mise à jour des visuels des services
CREATE TABLE IF NOT EXISTS service_reviews (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  service_id INT UNSIGNED NOT NULL,
  author_name VARCHAR(100) NOT NULL,
  rating INT NOT NULL DEFAULT 5,
  comment TEXT NOT NULL,
  is_verified TINYINT(1) DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Mise à jour des visuels réels HD pour chaque service local
UPDATE local_services SET image_url = 'service_jetski.jpg' WHERE slug = 'base-nautique-jet-ski';
UPDATE local_services SET image_url = 'service_kitesurf.jpg' WHERE slug = 'base-nautique-kitesurf';
UPDATE local_services SET image_url = 'service_quad.jpg' WHERE slug = 'quad-lagune-sunset';
UPDATE local_services SET image_url = 'hero.png' WHERE slug = 'chameau-caravane-plage';
UPDATE local_services SET image_url = 'concierge.png' WHERE slug = 'transfert-aeroport-vip';
UPDATE local_services SET image_url = 'sidi_mahres.png' WHERE slug = 'hotel-resort-charme';
UPDATE local_services SET image_url = 'djerbahood.png' WHERE slug = 'maison-hotes-menzel';
UPDATE local_services SET image_url = 'ajim.png' WHERE slug = 'sahara-ksar-ghilane';
UPDATE local_services SET image_url = 'houmt_souk.png' WHERE slug = 'diner-spectacle-bedouin';

-- Insertion d'avis certifiés initiaux
INSERT INTO service_reviews (service_id, author_name, rating, comment, is_verified)
SELECT id, 'Julien M.', 5, 'Session jet-ski au top sur une eau translucide ! Moniteur très pro et matériel neuf.', 1
FROM local_services WHERE slug = 'base-nautique-jet-ski'
AND NOT EXISTS (SELECT 1 FROM service_reviews WHERE author_name = 'Julien M.');

INSERT INTO service_reviews (service_id, author_name, rating, comment, is_verified)
SELECT id, 'Sophie & Marc', 5, 'La randonnée quad au coucher de soleil sur la lagune est magique. Pause thé inoubliable !', 1
FROM local_services WHERE slug = 'quad-lagune-sunset'
AND NOT EXISTS (SELECT 1 FROM service_reviews WHERE author_name = 'Sophie & Marc');

INSERT INTO service_reviews (service_id, author_name, rating, comment, is_verified)
SELECT id, 'Karim D.', 5, 'Excursion 4x4 jusqu''aux portes de Ksar Ghilane remarquable. Chauffeur guide passionné.', 1
FROM local_services WHERE slug = 'sahara-ksar-ghilane'
AND NOT EXISTS (SELECT 1 FROM service_reviews WHERE author_name = 'Karim D.');

INSERT INTO service_reviews (service_id, author_name, rating, comment, is_verified)
SELECT id, 'Émilie R.', 5, 'Accueil aéroport parfait, chauffeur avec pancarte à la sortie et bouteilles d''eau fraîche. Un vrai confort !', 1
FROM local_services WHERE slug = 'transfert-aeroport-vip'
AND NOT EXISTS (SELECT 1 FROM service_reviews WHERE author_name = 'Émilie R.');

INSERT INTO service_reviews (service_id, author_name, rating, comment, is_verified)
SELECT id, 'Alexandre B.', 5, 'Stage kitesurf au top, lagon avec de l''eau à la taille et fond de sable, idéal pour progresser en toute sécurité.', 1
FROM local_services WHERE slug = 'base-nautique-kitesurf'
AND NOT EXISTS (SELECT 1 FROM service_reviews WHERE author_name = 'Alexandre B.');
