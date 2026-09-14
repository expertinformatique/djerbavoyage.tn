-- Migration 005 : Ajout d'Hôtels de Prestige & Tables Gastronomiques dans /services

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'hotel', 'hasdrubal-prestige-thalassa-5star', 'Réservation Hasdrubal Prestige Thalassa 5★ & Spa', 'Palais de luxe en bord de mer avec 3 piscines lagon, suites impériales et centre de thalassothérapie d''exception.', 160.00, 'par nuit (2 pers)', 'Séjour libre', 'Sidi Mahres Front de Mer', 'Luxe 5 Stars', 'sidi_mahres.png', 1, 15
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'hasdrubal-prestige-thalassa-5star');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'maison', 'dar-dhiafa-menzel-erriadh', 'Séjour Ryad Dar Dhiafa & Cours Traditionnelles', 'Hôtel de charme emblématique composé de plusieurs houchs djerbiens du XVIe siècle à Djerbahood. Gastronomie djerbienne raffinée.', 135.00, 'par nuit (suite)', 'Séjour libre', 'Djerbahood Erriadh', 'Patrimoine Unique', 'djerbahood.png', 1, 16
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'dar-dhiafa-menzel-erriadh');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'restaurant', 'restaurant-haroun-port-houmt-souk', 'Dîner Gastronomique Haroun - Poissons & Langoustes', 'Emplacement privilégié sur le port d''Houmt Souk. Arrivage quotidien de langoustes, thon rouge et poissons grillés au feu de bois.', 45.00, 'par personne', 'Soirée Gourmande', 'Port de Pêche Houmt Souk', 'Incontournable Mer', 'houmt_souk.png', 1, 17
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'restaurant-haroun-port-houmt-souk');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'restaurant', 'restaurant-dar-el-houth-poisson', 'Menu Dégustation Poisson & Huile d''Olive Bio Djerba', 'Dîner intimiste dans un menzel séculaire. Menu 4 services : salade djerbienne, ojja aux fruits de mer, poisson du jour et pâtisserie au miel.', 32.00, 'par personne', 'Déjeuner ou Dîner', 'Midoun Centre', 'Table de Charme', 'concierge.png', 1, 18
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'restaurant-dar-el-houth-poisson');
