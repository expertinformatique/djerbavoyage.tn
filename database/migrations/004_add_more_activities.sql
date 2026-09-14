-- Migration 004 : Nouvelles Activités & Expériences Djerba 2026

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'nautisme', 'bateau-pirate-ile-flamants-roses', 'Traversée Bateau Pirate & Île aux Flamants Roses', 'Journée féérique en mer : animation corsaire, baignade turquoise et déjeuner traditionnel barbecue de poisson frais sur l''île.', 35.00, 'par personne', 'Journée (9h-16h)', 'Presqu''île de Ras R''mal', 'Top Famille', 'service_bateau_pirate.jpg', 1, 10
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'bateau-pirate-ile-flamants-roses');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'nautisme', 'bapteme-plongee-sous-marine', 'Baptême de Plongée & Épaves Méditerranéennes', 'Exploration sécurisée des récifs et faune marine avec moniteur diplômé. Équipement professionnel et photos sous-marines incluses.', 50.00, 'par personne', '2h30', 'Rochers de Ras R''mal', 'Découverte', 'service_plongee.jpg', 1, 11
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'bapteme-plongee-sous-marine');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'quad', 'buggy-can-am-extreme', 'Randonnée Buggy Can-Am Extreme 800cc', 'Sensations pures sur les pistes sauvages, dunes salées et littoraux djerbiens au volant d''un Buggy biplace dernière génération.', 75.00, 'par buggy (1-2 pers)', '2 heures', 'Lagune & Dunes d''Aghir', 'Sensations 800cc', 'service_buggy.jpg', 1, 12
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'buggy-can-am-extreme');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'chameau', 'balade-cheval-pur-sang-mer', 'Randonnée Équestre Pur-Sang Arabe dans l''Eau', 'Galop poétique et baignade à cheval au soleil couchant le long des plages désertes du sud de l''île.', 45.00, 'par cavalier', '2 heures', 'Plage d''Aghir & Salines', 'Magique', 'aghir.png', 1, 13
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'balade-cheval-pur-sang-mer');

INSERT INTO local_services (category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
SELECT 'maison', 'spa-rituel-hammam-massage-bio', 'Rituel Hammam, Gommage & Massage Bio 60 min', 'Détente absolue dans un centre de Thalassothérapie d''exception : hammam eucalyptus, gommage oriental au savon noir et massage aromatique.', 55.00, 'par personne', '2 heures', 'Zone Balnéaire Hasdrubal', 'Bien-être VIP', 'sidi_mahres.png', 1, 14
WHERE NOT EXISTS (SELECT 1 FROM local_services WHERE slug = 'spa-rituel-hammam-massage-bio');
