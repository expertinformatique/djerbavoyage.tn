CREATE TABLE IF NOT EXISTS local_services (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category VARCHAR(50) NOT NULL,
  slug VARCHAR(100) NOT NULL UNIQUE,
  name VARCHAR(150) NOT NULL,
  short_description TEXT NOT NULL,
  price_eur DECIMAL(10,2) NOT NULL,
  unit_label VARCHAR(50) NOT NULL,
  duration_label VARCHAR(50) NOT NULL,
  location_label VARCHAR(100) NOT NULL,
  badge VARCHAR(50) DEFAULT NULL,
  image_url VARCHAR(255) NOT NULL,
  is_active TINYINT(1) DEFAULT 1,
  sort_order INT DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS service_bookings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  service_id INT UNSIGNED NOT NULL,
  scheduled_date VARCHAR(20) DEFAULT NULL,
  scheduled_time VARCHAR(20) DEFAULT NULL,
  guests_count INT UNSIGNED DEFAULT 1,
  unit_price DECIMAL(10,2) NOT NULL,
  total_price DECIMAL(10,2) NOT NULL,
  notes TEXT DEFAULT NULL,
  status VARCHAR(30) DEFAULT 'confirmed',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS airport_transfers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  flight_number VARCHAR(50) DEFAULT NULL,
  airline VARCHAR(100) DEFAULT NULL,
  arrival_date VARCHAR(20) DEFAULT NULL,
  arrival_time VARCHAR(20) DEFAULT NULL,
  passengers_count INT UNSIGNED DEFAULT 1,
  dropoff_location VARCHAR(255) DEFAULT NULL,
  phone_whatsapp VARCHAR(50) DEFAULT NULL,
  status VARCHAR(30) DEFAULT 'pending',
  driver_notes TEXT DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'nautisme', 'base-nautique-jet-ski', 'Base Nautique & Randonnée Jet-Ski', 'Sensations fortes sur les eaux turquoise de la lagune. Encadrement certifié, gilets et briefing inclus.', 65.00, 'par jet (1 ou 2 pers)', '30 min à 1h', 'Lagune Sidi Mahres', 'Sensations', 'sidi_mahres.png', 1, 1
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'base-nautique-jet-ski');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'nautisme', 'base-nautique-kitesurf', 'Session & Stage Kitesurf Lagon', 'Spot mondialement réputé d''eau peu profonde et plate. Idéal débutant à confirmé avec instructeur IKO.', 90.00, 'par personne', 'Session 2h', 'Lagune Aghir / Castille', 'Top Vente', 'aghir.png', 1, 2
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'base-nautique-kitesurf');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'hotel', 'hotel-resort-charme', 'Séjour Hôtel & Resort 4* Front de Mer', 'Hôtel de prestige en accès direct plage privée, piscines lagon et formules demi-pension ou all-inclusive.', 85.00, 'par nuit (2 pers)', 'Séjour libre', 'Zone Balnéaire Midoun', 'Confort VIP', 'sidi_mahres.png', 1, 3
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'hotel-resort-charme');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'maison', 'maison-hotes-menzel', 'Maison d''Hôtes de Charme & Houch Traditionnel', 'Immersion authentique dans un menzel séculaire avec patio fleuri, piscine privée et petits-déjeuners djerbiens.', 110.00, 'par nuit (suite)', 'Séjour libre', 'Erriadh / Djerbahood', 'Coup de Cœur', 'djerbahood.png', 1, 4
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'maison-hotes-menzel');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'quad', 'quad-lagune-sunset', 'Randonnée Quad & Buggy Coucher de Soleil', 'Franchissement des pistes de terre oasiennes, lagune salée et pause thé à la menthe face au soleil couchant.', 40.00, 'par quad (1 ou 2 pers)', '2 heures', 'Pistes de la Lagune', 'Incontournable', 'concierge.png', 1, 5
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'quad-lagune-sunset');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'chameau', 'chameau-caravane-plage', 'Caravane Dromadaire & Cheval sur la Plage', 'Balade poétique au pas feutré des dromadaires le long des grandes plages sauvages ou à dos de pur-sang arabe.', 25.00, 'par personne', '1 heure 30', 'Plage Sidi Mahres & Oasis', 'Authentique', 'hero.png', 1, 6
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'chameau-caravane-plage');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'sahara', 'sahara-ksar-ghilane', 'Excursion Grand Sud & Portes du Sahara (4x4)', 'Journée d''exception : maisons troglodytes de Matmata, ksour berbères de Tataouine et source chaude de Ksar Ghilane.', 95.00, 'par personne', 'Journée complète', 'Matmata & Ksar Ghilane', 'Aventure Épique', 'ajim.png', 1, 7
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'sahara-ksar-ghilane');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'diner', 'diner-spectacle-bedouin', 'Dîner Spectacle Bédouin sous Tente Nomade', 'Saveurs du terroir : couscous djerbien, agneau cuit à la gargoulette, danse folklorique et musiques du désert.', 38.00, 'par personne', 'Soirée (19h30)', 'Palmeraie & Dar Djerbienne', 'Gastronomie', 'houmt_souk.png', 1, 8
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'diner-spectacle-bedouin');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'transfert', 'transfert-aeroport-vip', 'Accueil VIP & Chauffeur Privé Aéroport (DJE)', 'Chauffeur privé avec pancarte nominative à la sortie, bouteilles d''eau fraîche, carte SIM locale 4G et dépose hôtel.', 35.00, 'par véhicule (1 à 4 pers)', 'Trajet direct', 'Aéroport Djerba-Zarzis', 'Gratuit dès 3 activités', 'hero.png', 1, 9
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'transfert-aeroport-vip');
