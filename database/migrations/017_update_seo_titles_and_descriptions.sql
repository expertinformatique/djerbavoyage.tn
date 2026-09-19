-- Migration 017: Mise à jour des titres et méta-descriptions par défaut pour l'optimisation SEO Google (50-60 caractères pour le titre, 100-130 caractères pour la méta-description)
UPDATE settings SET setting_value = 'Djerba Voyage 2026 : Guide Officiel, Excursions et Activités' WHERE setting_key = 'site_name';
UPDATE settings SET setting_value = 'Préparez votre voyage à Djerba : guides complets, réservation d''excursions, quads, sorties en mer et conciergerie VIP.' WHERE setting_key = 'meta_description_default';

