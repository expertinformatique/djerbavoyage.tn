-- Migration 007 : Garantir au minimum 10 produits par famille dans /services (80+ services au total)

-- 1. NAUTISME (Complément jusqu'à 10 items)
INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'nautisme', 'excursion-catamaran-sunset-djerba', 'Excursion Catamaran Luxe & Sunset avec Aperitif', 'Navigation douce le long de la côte djerbienne au coucher du soleil avec buffet d''amuse-bouches et boissons fraîches.', 45.00, 'par personne', '3 heures', 'Marina d''Houmt Souk', 'Sunset Luxe', 'service_bateau_pirate.jpg', 1, 23
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'excursion-catamaran-sunset-djerba');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'nautisme', 'stage-windsurf-planche-voile', 'Stage & Location Windsurf / Planche à Voile', 'Vents constants et plan d''eau idéal. Matériel RRD / NeilPryde et conseils d''un moniteur diplômé.', 60.00, 'par personne', 'Session 2h', 'Spot d''Aghir', 'Sensations', 'service_kitesurf.jpg', 1, 24
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'stage-windsurf-planche-voile');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'nautisme', 'parasailing-parachute-ascensionnel', 'Vol Parachute Ascensionnel au-dessus du Lagon', 'Vue panoramique spectaculaire sur les plages et palmeraies de Djerba depuis 100 mètres d''altitude.', 40.00, 'par vol (1 ou 2 pers)', '15 minutes en vol', 'Plage Sidi Mahres', 'Vue Panoramique', 'service_jetski.jpg', 1, 25
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'parasailing-parachute-ascensionnel');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'nautisme', 'paddle-kayak-transparent-lagune', 'Location Stand-Up Paddle & Kayak Translucide', 'Glissez en silence sur les eaux cristallines de la lagune et observez les fonds marins à travers la coque transparente.', 20.00, 'par personne', '1 heure 30', 'Lagune Castille', 'Éco-Tourisme', 'aghir.png', 1, 26
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'paddle-kayak-transparent-lagune');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'nautisme', 'ski-nautique-wakeboard-session', 'Session Ski Nautique & Wakeboard Pro', 'Traction bateau MasterCraft pro sur eau calme. Équipement complet et coaching personnalisé.', 50.00, 'par personne', '20 minutes', 'Zone Nautique Sidi Mahres', 'Glisse Pro', 'service_jetski.jpg', 1, 27
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'ski-nautique-wakeboard-session');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'nautisme', 'peche-gros-mediterranee-bateau', 'Partie de Pêche au Gros en Haute Mer', 'Sortie en mer avec équipage expérimenté, cannes professionnelles et matériel de traîne pour thon, dorade et thazard.', 85.00, 'par pêcheur', 'Demi-journée', 'Port d''Houmt Souk', 'Pêche Pro', 'service_bateau_pirate.jpg', 1, 28
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'peche-gros-mediterranee-bateau');


-- 2. QUAD & BUGGY (Complément jusqu'à 10 items)
INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'quad', 'quad-circuit-dunes-erriadh', 'Circuit Quad Pistes Sauvages d''Erriadh', 'Randonnée technique entre oliviers centenaires, ruelles de campagne et pistes salées du sud djerbien.', 35.00, 'par quad', '1h30', 'Pistes d''Erriadh', 'Aventure', 'service_quad.jpg', 1, 29
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'quad-circuit-dunes-erriadh');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'quad', 'buggy-familial-4-places-oasis', 'Buggy Familial 4 Places à travers les Palmeraies', 'Véhicule tout-terrain 4 places grand confort pour explorer les pistes sauvages en famille en toute sécurité.', 90.00, 'par buggy 4p', '2 heures', 'Midoun & Lagune', 'Spécial Famille', 'service_buggy.jpg', 1, 30
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'buggy-familial-4-places-oasis');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'quad', 'quad-raid-demi-journee-salines', 'Raid Quad 4 Heures Salines & Côte Sauvage d''Aghir', 'Grand tour de l''île hors des sentiers battus : salines, phare du Phare de Taguermess et pause baignade.', 65.00, 'par quad', 'Demi-journée (4h)', 'Salines & Phare Taguermess', 'Grand Raid', 'service_quad.jpg', 1, 31
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'quad-raid-demi-journee-salines');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'quad', 'quad-nuit-etoilee-feux-camp', 'Safari Quad Nocturne & Feux de Camp Bédouin', 'Conduite de nuit sous le ciel étoilé djerbien suivie d''une soirée autour du feu avec thé à la menthe.', 50.00, 'par quad', '2 heures', 'Pistes de la Lagune', 'Nocturne Magic', 'service_quad.jpg', 1, 32
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'quad-nuit-etoilee-feux-camp');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'quad', 'buggy-vip-private-tour-guide', 'Tour Privé Buggy VIP avec Guide Dédié', 'Parcours sur-mesure à votre rythme avec équipement haut de gamme et rafraîchissements servis en chemin.', 110.00, 'par buggy VIP', '3 heures', 'Itinéraire Sur-Mesure', 'Exclusivité VIP', 'service_buggy.jpg', 1, 33
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'buggy-vip-private-tour-guide');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'quad', 'quad-initiations-enfants-ados', 'Circuit Sécurisé Quad Enfants & Ados (Yamaha 90cc)', 'Piste fermée et sécurisée avec moniteurs pour initier les plus jeunes au pilotage de quad en toute confiance.', 25.00, 'par pilote', '45 minutes', 'Base Quad Midoun', 'Pour Enfants', 'service_quad.jpg', 1, 34
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'quad-initiations-enfants-ados');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'quad', 'quad-matmata-desert-journee', 'Raid Quad & Sahara Journée Matmata', 'Raid d''exception franchissant la chaussée romaine vers le continent et les dômes de Matmata.', 130.00, 'par quad', 'Journée complète', 'Matmata Continent', 'Aventure Extrême', 'service_quad.jpg', 1, 35
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'quad-matmata-desert-journee');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'quad', 'quad-sunset-chameau-duo-pack', 'Pack Duo Quad & Dromadaire Coucher de Soleil', '1h de quad à sensations suivie d''1h de balade apaisante à dos de dromadaire au coucher du soleil.', 45.00, 'par personne', '2 heures 30', 'Lagune & Dunes', 'Best-Seller Duo', 'service_quad.jpg', 1, 36
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'quad-sunset-chameau-duo-pack');


-- 3. DROMADAIRE & CHEVAL (Complément jusqu'à 10 items)
INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'chameau', 'caravane-dromadaire-costume-traditionnel', 'Caravane Dromadaire avec Tenue Bédouine & Souvenir Photo', 'Immersion totale en costume nomade traditionnel djerbien avec séance photo professionnelle dans les dômes.', 28.00, 'par personne', '1h30', 'Oasis de Midoun', 'Photo Souvenir', 'hero.png', 1, 37
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'caravane-dromadaire-costume-traditionnel');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'chameau', 'randonnee-equestre-cavalier-confirme', 'Galop Pur-Sang Arabe sur les Grandes Plages', 'Randonnée sportive pour cavaliers confirmés sur des chevaux pur-sang arabes entraînés.', 50.00, 'par cavalier', '2 heures', 'Plage Sidi Mahres & Aghir', 'Sportif', 'aghir.png', 1, 38
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'randonnee-equestre-cavalier-confirme');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'chameau', 'promenade-poney-enfants-palmeraie', 'Promenade à Poney & Âne pour Enfants dans l''Oasis', 'Balade calme et joyeuse sous les palmiers tenue en longe par un guide bédouin attentionné.', 15.00, 'par enfant', '45 minutes', 'Palmeraie de Midoun', 'Famille / Enfants', 'hero.png', 1, 39
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'promenade-poney-enfants-palmeraie');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'chameau', 'caravane-petit-dejeuner-nomade-dunes', 'Caravane Dromadaire Petit-Déjeuner Lever du Soleil', 'Départ à l''aube pour admirer le lever de soleil sur la mer suivi d''un petit-déjeuner traditionnel djerbien.', 35.00, 'par personne', '2 heures', 'Plage d''Aghir', 'Éveil Magique', 'hero.png', 1, 40
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'caravane-petit-dejeuner-nomade-dunes');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'chameau', 'randonnee-chameau-guellala-poterie', 'Randonnée Dromadaire vers les Ateliers de Guellala', 'Traversée des oliveraies séculaires à dos de chameau jusqu''aux grottes des potiers de Guellala.', 38.00, 'par personne', 'Demi-journée', 'Pistes de Guellala', 'Artisanal', 'guellala.png', 1, 41
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'randonnee-chameau-guellala-poterie');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'chameau', 'stage-equitation-djerba-club', 'Stage Équitation 3 Séances Club Hippique Djerba', 'Perfectionnement ou initiation à l''équitation en carrière et sorties en extérieur sur la plage.', 90.00, 'par personne', '3 cours de 1h30', 'Club Hippique Midoun', 'Stage Passion', 'aghir.png', 1, 42
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'stage-equitation-djerba-club');


-- 4. SAHARA (Complément jusqu'à 10 items)
INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'sahara', 'sahara-tataouine-chenini-ksour', 'Excursion 4x4 Ksour de Tataouine & Village Berbère Chenini', 'Visite guidée des greniers fortifiés (ksour) et du village perché de Chenini accroché à la montagne.', 85.00, 'par personne', 'Journée complète', 'Tataouine & Chenini', 'Culture & Patrimoine', 'ajim.png', 1, 43
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'sahara-tataouine-chenini-ksour');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'sahara', 'sahara-tozeur-star-wars-nefta', 'Circuit 2 Jours Tozeur, Nefta & Décors Star Wars', 'Grande boucle saharienne : oasis de Tozeur, palmeraie en calèche, canyon de Mides et village Star Wars Mos Espa.', 150.00, 'par personne', '2 Jours / 1 Nuit', 'Tozeur & Nefta', 'Mythique Star Wars', 'ajim.png', 1, 44
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'sahara-tozeur-star-wars-nefta');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'sahara', 'sahara-ksar-jouamaa-nuit-ksar', 'Nuit Insolite dans un Ksar Berbère du XVe Siècle', 'Dormez dans une ghorfa authentique restaurée au cœur des montagnes du Sud Tunisien.', 95.00, 'par personne', '1 Nuit & Dîner', 'Ksar Jouamaa', 'Expérience Insolite', 'ajim.png', 1, 45
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'sahara-ksar-jouamaa-nuit-ksar');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'sahara', 'sahara-source-chaude-ksar-ghilane-spa', 'Bain Thermal Source Chaude Ksar Ghilane & Massage Oasis', 'Baignade relaxante dans la source naturelle à 34°C bordée par les dromadaires et massage sous les palmiers.', 70.00, 'par personne', 'Journée complète', 'Source Ksar Ghilane', 'Détente Saharienne', 'ajim.png', 1, 46
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'sahara-source-chaude-ksar-ghilane-spa');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'sahara', 'sahara-survol-montgolfiere-douz', 'Survol du Sahara en Montgolfière au Lever du Soleil', 'Envol féérique au-dessus des dromadaires et de l''océan de dromadaires au lever du jour à Douz.', 180.00, 'par passager', 'Vol 1h + Collation', 'Désert de Douz', 'Féerie Aérienne', 'ajim.png', 1, 47
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'sahara-survol-montgolfiere-douz');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'sahara', 'sahara-circuit-dunes-erg-zmela', 'Expédition 4x4 Grand Erg Oriental & Dunes Erg Zmela', 'Franchissement des plus hautes dunes de sable de Tunisie jusqu au campement isolé d Erg Zmela.', 160.00, 'par personne', '2 Jours / 1 Nuit', 'Erg Zmela Saharien', 'Désert Profond', 'ajim.png', 1, 48
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'sahara-circuit-dunes-erg-zmela');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'sahara', 'sahara-raid-buggy-desert-2days', 'Raid Buggy 2 Jours Désert & Bivouac Nomade', 'Pilotage de buggy sur 250 km de pistes désertiques avec assistance mécanique et bivouac nomade sous les étoiles.', 290.00, 'par pilote', '2 Jours complets', 'Pistes Sahariennes', 'Extrême Pilotage', 'service_buggy.jpg', 1, 49
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'sahara-raid-buggy-desert-2days');


-- 5. RESTAURANTS & GASTRONOMIE (Complément jusqu'à 10 items)
INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'restaurant', 'restaurant-le-moussaillon-seafood', 'Le Moussaillon - Grillades de Poisson & Calamars Frais', 'Dîner décontracté pieds dans le sable avec friture de poisson du jour, calamars dorés et salade méchouia.', 30.00, 'par personne', 'Déjeuner / Dîner', 'Plage Sidi Mahres', 'Pieds dans l''Eau', 'sidi_mahres.png', 1, 50
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'restaurant-le-moussaillon-seafood');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'restaurant', 'restaurant-es-sofra-cuisine-traditionnelle', 'Es Sofra - Couscous Djerbien & Gargoulette Traditionnelle', 'Le restaurant de référence pour savourer le couscous au poisson djerbien et l agneau cuit à l étouffée dans la terre.', 25.00, 'par personne', 'Repas complet', 'Houmt Souk Médina', 'Authentique Terroir', 'houmt_souk.png', 1, 51
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'restaurant-es-sofra-cuisine-traditionnelle');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'restaurant', 'restaurant-le-lotus-gastronomique', 'Le Lotus - Gastronomie Méditerranéenne & Vin Bio', 'Table d exception offrant une cuisine fusion djerbo-méditerranéenne accompagnée de grands crus tunisiens.', 48.00, 'par personne', 'Dîner 4 Services', 'Zone Balnéaire', 'Fine Dining', 'sidi_mahres.png', 1, 52
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'restaurant-le-lotus-gastronomique');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'restaurant', 'restaurant-la-lagune-sunset-lounge', 'La Lagune Sunset Lounge - Cocktails & Tapas Mer', 'Bar-restaurant lounge avec terrasse suspendue sur la lagune pour admirer le coucher de soleil musique chillout.', 35.00, 'par personne', 'Soirée Lounge', 'Lagune d''Aghir', 'Sunset Lounge', 'aghir.png', 1, 53
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'restaurant-la-lagune-sunset-lounge');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'restaurant', 'restaurant-dar-hassine-menzel', 'Restaurant Dar Hassine - Cour Ombragée & Briks Djerbiennes', 'Dîner dans la cour d une demeure djerbienne historique : briks à l œuf coulante, tajine malsouka et thé pignons.', 28.00, 'par personne', 'Déjeuner / Dîner', 'Erriadh / Djerbahood', 'Décor Historique', 'djerbahood.png', 1, 54
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'restaurant-dar-hassine-menzel');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'restaurant', 'restaurant-le-caravanserai-ryad', 'Le Caravansérail - Dîner aux Chandelles Ryad Historique', 'Cadre romantique somptueux éclairé à la bougie dans un caravansérail restauré. Musique d ambiance luth traditionnel.', 55.00, 'par personne', 'Soirée Romantique', 'Médina Houmt Souk', 'Chic & Romantique', 'houmt_souk.png', 1, 55
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'restaurant-le-caravanserai-ryad');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'restaurant', 'restaurant-al-jazeera-djerbahood', 'Table d''Hôtes Al Jazeera - Cuisine du Terroir & Huile d''Olive', 'Cuisine familiale préparée avec des légumes du potager bio et les huiles d olive pressées à la meule de pierre.', 26.00, 'par personne', 'Repas convivial', 'Djerbahood Erriadh', 'Cuisine Bio', 'djerbahood.png', 1, 56
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'restaurant-al-jazeera-djerbahood');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'restaurant', 'degustation-vins-huile-olive-djerba', 'Atelier Dégustation Vins Tunisiens & Huiles d''Olive Bio', 'Atelier dégustation animé par un sommelier : 4 cuvées de vins tunisiens (Magon, Selian) et sélections d huiles d olive.', 40.00, 'par personne', 'Atelier 2h', 'Cave Domaine Djerba', 'Atelier Gourmand', 'concierge.png', 1, 57
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'degustation-vins-huile-olive-djerba');


-- 6. DÎNER BÉDOUIN & SOIRÉES (Complément jusqu'à 10 items)
INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'diner', 'diner-croisiere-bateau-sunset-djerba', 'Dîner Croisière Coucher de Soleil & Musique Live', 'Embarquement à la tombée du jour pour un dîner buffet de fruits de mer en mer avec animation musicale live.', 45.00, 'par personne', 'Soirée 3h', 'Mer de Djerba', 'Croisière Gourmande', 'service_bateau_pirate.jpg', 1, 58
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'diner-croisiere-bateau-sunset-djerba');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'diner', 'diner-romantique-plage-privee-bougies', 'Dîner Romantique Privé sur la Plage aux Bougies', 'Table privée dressée sur le sable au bord de l eau avec serveur dédié, carpaccio de langouste et champagne.', 75.00, 'par personne', 'Soirée Privée', 'Plage d''Aghir', '100% Romantique', 'sidi_mahres.png', 1, 59
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'diner-romantique-plage-privee-bougies');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'diner', 'diner-spectacle-mille-et-une-nuits', 'Soirée Spectacle Mille et Une Nuits & Danseuse Orientale', 'Grand diner spectacle folkore bédouin : charmeurs de serpents, cracheurs de feu et danses orientales sous la tente.', 42.00, 'par personne', 'Soirée 19h30', 'Oasis de Midoun', 'Spectacle Féérique', 'houmt_souk.png', 1, 60
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'diner-spectacle-mille-et-une-nuits');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'diner', 'diner-gargoulette-agneau-four-terre', 'Soirée Gargoulette d''Agneau Cuite à l''Étouffée sous Terre', 'Assistez à l déterrage traditionnel des amphores en terre cuite où l agneau mijote doucement pendant 6 heures.', 36.00, 'par personne', 'Dîner Typique', 'Ferme Bédouine', 'Tradition Djerba', 'houmt_souk.png', 1, 61
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'diner-gargoulette-agneau-four-terre');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'diner', 'diner-nomade-oasis-etoilee', 'Dîner Bédouin dans les Dunes avec Observation des Étoiles', 'Dîner traditionnel autour du feu suivi d un atelier d astronomie guidé au télescope sous le ciel pur du désert.', 48.00, 'par personne', 'Soirée Astronomie', 'Dunes de Midoun', 'Soirée Étoilée', 'ajim.png', 1, 62
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'diner-nomade-oasis-etoilee');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'diner', 'diner-poisson-grille-cabane-pecheur', 'Dîner Barbecue Poisson Grillé dans une Cabane de Pêcheur', 'Dîner authentique préparé par les pêcheurs d Ajim : dorades et loups grillés au feu de bois avec salades fraîches.', 32.00, 'par personne', 'Dîner champêtre', 'Port d''Ajim', 'Simple & Frais', 'ajim.png', 1, 63
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'diner-poisson-grille-cabane-pecheur');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'diner', 'diner-concert-malouf-patio-ryad', 'Soirée Dîner & Concert Musique Andalouse Malouf', 'Dîner raffiné bercé par les mélodies séculaires du Malouf tunisien joué à l oud dans un patio illuminé.', 50.00, 'par personne', 'Soirée Musique', 'Patio Ryad Erriadh', 'Culture & Musique', 'djerbahood.png', 1, 64
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'diner-concert-malouf-patio-ryad');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'diner', 'diner-degustation-tajines-djerbiens', 'Dîner Buffet 7 Tajines Djerbiens & Pâtisseries au Miel', 'Parcours gourmand à la découverte des 7 variétés de tajines traditionnels et douceurs aux dattes et amandes.', 28.00, 'par personne', 'Buffet Gourmand', 'Houmt Souk Centre', 'Buffet Terroir', 'houmt_souk.png', 1, 65
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'diner-degustation-tajines-djerbiens');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'diner', 'diner-vip-chef-prive-villa', 'Chef Privé à Domicile pour Dîner Gastronomique en Villa', 'Un chef étoilé s installe dans votre villa pour cuisiner un menu sur-mesure de 5 services avec service à table.', 95.00, 'par personne', 'Prestation Privée', 'Votre Villa Djerba', 'Exclusif 5 Stars', 'concierge.png', 1, 66
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'diner-vip-chef-prive-villa');


-- 7. HÔTELS & RESORTS 5★ (Complément jusqu'à 10 items)
INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'hotel', 'hotel-radisson-blu-palace-djerba', 'Radisson Blu Palace Resort & Thalasso 5★', 'Resort iconique pieds dans l eau avec centre de thalassothérapie Thalgo de 3000 m² et jardins tropicaux.', 150.00, 'par nuit (2 pers)', 'Séjour libre', 'Sidi Mahres Plage', 'Luxe 5 Stars', 'sidi_mahres.png', 1, 67
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'hotel-radisson-blu-palace-djerba');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'hotel', 'hotel-iberostar-selection-royal-el-mansour', 'Iberostar Selection Djerba Beach 4★ All Inclusive', 'Formule tout inclus premium en bord de plage privée avec piscines lagon et animations d exception.', 95.00, 'par nuit (2 pers)', 'Séjour libre', 'Zone Balnéaire Midoun', 'All Inclusive VIP', 'sidi_mahres.png', 1, 68
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'hotel-iberostar-selection-royal-el-mansour');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'hotel', 'hotel-royal-garden-palace-5star', 'Royal Garden Palace 5★ - Architecture Arabo-Andalouse', 'Hôtel d une élégance rare disposant d un parcours de golf 27 trous adjacent et de suites somptueuses.', 140.00, 'par nuit (2 pers)', 'Séjour libre', 'Zone Golf Midoun', 'Prestige & Golf', 'sidi_mahres.png', 1, 69
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'hotel-royal-garden-palace-5star');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'hotel', 'hotel-u-paalm-beach-resort-spa', 'Palm Beach Palace Djerba 4★ Adults Only', 'Hôtel réservé aux adultes pour une sérénité absolue : spa oriental, piscine privée et ambiance lounge.', 88.00, 'par nuit (2 pers)', 'Séjour libre', 'Plage Sidi Mahres', 'Adults Only', 'sidi_mahres.png', 1, 70
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'hotel-u-paalm-beach-resort-spa');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'hotel', 'hotel-fiesta-beach-djerba-club', 'Fiesta Beach Djerba 4★ Club Bungalows', 'Village vacances au style djerbien avec bungalows en dômes dans la palmeraie et parc aquatique.', 78.00, 'par nuit (2 pers)', 'Séjour libre', 'Plage Sidi Bakour', 'Top Animations', 'sidi_mahres.png', 1, 71
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'hotel-fiesta-beach-djerba-club');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'hotel', 'hotel-robinson-club-djerba-badiya', 'Robinson Club Djerba Badiya Golf & Tennis 4★', 'Club haut de gamme axé sur le sport et le bien-être : 9 courts de tennis, voile, golf et cuisine équilibrée.', 125.00, 'par nuit (2 pers)', 'Séjour libre', 'Midoun Golf Coast', 'Sport & Premium', 'sidi_mahres.png', 1, 72
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'hotel-robinson-club-djerba-badiya');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'hotel', 'hotel-seabel-rives-bleues-resort', 'Seabel Rives Bleues Resort & Spa Front de Mer', 'Resort familial chaleureux entouré de 6 hectares de parc paysager au bord des eaux turquoise.', 82.00, 'par nuit (2 pers)', 'Séjour libre', 'Midoun Plage', 'Confort Familial', 'sidi_mahres.png', 1, 73
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'hotel-seabel-rives-bleues-resort');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'hotel', 'hotel-sentido-djerba-beach-resort', 'Sentido Djerba Beach 4★ Pieds dans l''Eau', 'Hôtel moderne entièrement rénové offrant des prestations raffinées et une plage privée de sable fin.', 90.00, 'par nuit (2 pers)', 'Séjour libre', 'Sidi Mahres Centre', 'Design & Beach', 'sidi_mahres.png', 1, 74
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'hotel-sentido-djerba-beach-resort');


-- 8. MAISONS D'HÔTES / RYADS (Complément jusqu'à 10 items)
INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'maison', 'maison-dar-bibine-djerbahood', 'Dar Bibine - Maison d''Hôtes Design & Art Contemporain', 'Ryad épuré mêlant architecture traditionnelle djerbienne et œuvres d art contemporain à Erriadh.', 120.00, 'par nuit (suite)', 'Séjour libre', 'Djerbahood Erriadh', 'Design & Art', 'djerbahood.png', 1, 75
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'maison-dar-bibine-djerbahood');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'maison', 'maison-menzel-cajou-aghir', 'Menzel Cajou Aghir - Suite avec Piscine Lagon Ombragée', 'Havre de paix au milieu des oliviers et bougainvilliers avec suites avec terrasses privatives.', 105.00, 'par nuit (suite)', 'Séjour libre', 'Aghir Campagne', 'Havre de Paix', 'aghir.png', 1, 76
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'maison-menzel-cajou-aghir');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'maison', 'maison-dar-el-gaied-houmt-souk', 'Dar El Gaïed - Demeure Patricienne Historique du XIXe', 'Demeure de notable restaurée avec patio luxuriant, fontaine en marbre et mobilier d époque.', 115.00, 'par nuit (suite)', 'Séjour libre', 'Houmt Souk Médina', 'Charme Historique', 'houmt_souk.png', 1, 77
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'maison-dar-el-gaied-houmt-souk');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'maison', 'maison-houch-el-khadra-campagne', 'Houch El Khadra - Domaine Éco-Responsable & Palmeraie', 'Domaine agricole bio proposant des chambres d hôtes authentiques au milieu des palmiers et grenadiers.', 85.00, 'par nuit (chambre)', 'Séjour libre', 'Campagne de Midoun', 'Éco-Responsable', 'hero.png', 1, 78
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'maison-houch-el-khadra-campagne');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'maison', 'maison-dar-zahra-suite-patio', 'Dar Zahra - Suite de Charme avec Jacuzzi Privé sur Toit', 'Menzel exclusif offrant une vue panoramique à 360° sur l île et jacuzzi privé chauffé sur le solarium.', 130.00, 'par nuit (suite VIP)', 'Séjour libre', 'Erriadh / Djerbahood', 'Jacuzzi Privé', 'djerbahood.png', 1, 79
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'maison-dar-zahra-suite-patio');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'maison', 'maison-menzel-tazi-jardin-bio', 'Menzel Tazi - Ryad avec Potager Bio & Petit-Déjeuner Maison', 'Séjour convivial dans une maison de famille djerbienne avec petit-déjeuner composé de jus frais et confitures maison.', 95.00, 'par nuit (chambre)', 'Séjour libre', 'Guellala Nature', 'Authenticité', 'guellala.png', 1, 80
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'maison-menzel-tazi-jardin-bio');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'maison', 'maison-dar-sultan-suites-charme', 'Dar Sultan - Maison d''Hôtes de Luxe avec Hammam Privatif', 'Suites impériales djerbiennes décorées avec raffinement disposant d un hammam et spa privatif.', 145.00, 'par nuit (suite)', 'Séjour libre', 'Midoun Centre', 'Luxe & Spa', 'concierge.png', 1, 81
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'maison-dar-sultan-suites-charme');
