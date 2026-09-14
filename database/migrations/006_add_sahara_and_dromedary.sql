-- Migration 006 : Nouvelles Expériences Sahara & Dromadaire dans /services

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'sahara', 'bivouac-nuit-etoilee-douz-sahara', 'Bivouac 2 Jours Nuit Étoilée à Douz & Chott El Jerid', 'Expérience immersive de 2 jours : traversée du lac salé Chott El Jerid, nuit sous tente de luxe dans les dunes de Douz et petit-déjeuner au lever du soleil.', 140.00, 'par personne', '2 Jours / 1 Nuit', 'Douz & Chott El Jerid', 'Bivouac Étoilé', 'ajim.png', 1, 19
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'bivouac-nuit-etoilee-douz-sahara');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'sahara', 'randonnee-4x4-oasis-chebika-tamerza', 'Expédition 4x4 Oasis de Montagne & Cascades de Tamerza', 'Découverte spectaculaire des oasis de montagne tunisiennes, canyons de Mides et décors de cinéma Star Wars Mos Espa à Tozeur.', 110.00, 'par personne', 'Journée complète', 'Tozeur & Chebika', 'Star Wars Decor', 'ajim.png', 1, 20
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'randonnee-4x4-oasis-chebika-tamerza');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'chameau', 'caravane-sunset-dromadaire-the-nomade', 'Caravane Dromadaire Coucher de Soleil & Thé Bédouin', 'Traversée magique des palmeraies et dunes côtières au crépuscule. Dégustation de pain tabouna chaud et thé à la menthe préparé sur la braise.', 30.00, 'par personne', '2 heures', 'Lagune de Midoun', 'Sunset Féérique', 'hero.png', 1, 21
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'caravane-sunset-dromadaire-the-nomade');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'chameau', 'randonnee-mixte-dromadaire-quad-oasis', 'Combo Duo : 1h Dromadaire + 1h Quad Lagune', 'Formule duo idéale : commencez en douceur à dos de dromadaire à travers l''oasis, puis enchaînez en Quad sur les pistes côtières.', 55.00, 'par personne', '2h30', 'Pistes de la Lagune', 'Combo Populaire', 'hero.png', 1, 22
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'randonnee-mixte-dromadaire-quad-oasis');
