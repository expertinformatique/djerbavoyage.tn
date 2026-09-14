<?php
require_once __DIR__ . '/core/Database.php';

use Core\Database;

try {
    $pdo = Database::getInstance();
    echo "🌱 Exécution du Seeding Djerba Voyage (6 Destinations & Catalogue 100 Produits)...\n";

    // 1. Admin Account
    $passwordHash = password_hash('admin123', PASSWORD_ARGON2ID);
    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password, role)
        VALUES ('admin', 'admin@djerba-voyage.tn', :pass, 'admin')
        ON DUPLICATE KEY UPDATE password = VALUES(password)
    ");
    $stmt->execute(['pass' => $passwordHash]);
    echo "✅ Admin créé : admin / admin123\n";

    // 2. Settings
    $settings = [
        ['site_name', 'Djerba Voyage - Guide Officiel & Conciergerie', 'general'],
        ['contact_email', 'contact@djerba-voyage.tn', 'general'],
        ['currency', 'EUR', 'pricing'],
        ['concierge_price', '29.00', 'pricing'],
        ['stripe_mode', 'test', 'stripe'],
        ['booking_partner_id', 'booking_djerba_123', 'affiliates'],
        ['getyourguide_partner_id', 'gyg_djerba_456', 'affiliates'],
        ['meta_title_default', 'Visiter Djerba : Guides, Hôtels et Itinéraires Sur-Mesure 2026', 'seo'],
        ['meta_description_default', 'Découvrez Djerba avec nos guides complets : Houmt Souk, Djerbahood, Guellala, Ajim, Sidi Mahres.', 'seo']
    ];
    $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value, setting_group) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    foreach ($settings as $s) {
        $stmt->execute($s);
    }
    echo "✅ Paramètres globaux créés.\n";

    // 3. Destinations (6 Destinations djerbiennes)
    $destinations = [
        ['houmt-souk', 'Houmt Souk', 'Houmt Souk', 'La capitale animée de Djerba, connue pour ses souks colorés, ses fondouks historiques et sa marina.', 'images/houmt_souk.png'],
        ['sidi-mahres', 'Plage de Sidi Mahres', 'Sidi Mahres Beach', 'La plus belle plage de sable fin de Djerba avec ses hôtels d\'exception et ses eaux turquoise.', 'images/sidi_mahres.png'],
        ['midoun', 'Djerbahood & Erriadh', 'Djerbahood Erriadh', 'Le village d\'art célèbre à ciel ouvert, réputé pour ses 250 fresques street art uniques et ses cours intérieures.', 'images/djerbahood.png'],
        ['aghir', 'Aghir & Lagune VIP', 'Aghir Beach & Lagoon', 'Zone côtière d\'exception au sud-est, réputée pour ses chevaux au bord de l\'eau et le phare du Nadhour.', 'images/aghir.png'],
        ['guellala', 'Guellala & Les Potiers', 'Guellala Pottery Village', 'Capitale historique de la poterie artisanale djerbienne, réputée pour ses ateliers ancestraux et son grand musée.', 'images/guellala.png'],
        ['ajim-el-melga', 'Ajim & El Melga', 'Ajim Sponge Fishing Port', 'Port pittoresque des pêcheurs d\'éponges naturelles, traversée du bac et décor culte de la Cantina Star Wars.', 'images/ajim.png']
    ];
    $stmt = $pdo->prepare("INSERT INTO destinations (slug, name_fr, name_en, description_fr, image_url) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE name_fr = VALUES(name_fr), description_fr = VALUES(description_fr), image_url = VALUES(image_url)");
    foreach ($destinations as $d) {
        $stmt->execute($d);
    }
    echo "✅ 6 Destinations insérées avec visuels HD.\n";

    // Map destination IDs
    $destMap = [];
    $destRows = $pdo->query("SELECT id, slug FROM destinations")->fetchAll();
    foreach ($destRows as $row) {
        $destMap[$row['slug']] = $row['id'];
    }

    // 4. Génération du Produit Vedette Personnalisé + 100 Produits Catalogue
    $stmtProduct = $pdo->prepare("INSERT INTO products (slug, title_fr, price_eur, file_path, is_active) VALUES (?, ?, ?, ?, 1) ON DUPLICATE KEY UPDATE title_fr = VALUES(title_fr), price_eur = VALUES(price_eur)");

    // Special Personalized PDF product
    $stmtProduct->execute([
        'guide-pdf-personnalise-nom-photo',
        '⭐ Votre Guide PDF Personnalisé avec votre Nom & Photo de Couverture',
        9.90,
        'storage/downloads/guide-personnalise.pdf'
    ]);

    $categories = [
        'Guides PDF' => [
            'Guide Ultime Djerbahood & Street Art 2026',
            'Guide Secret Houmt Souk & Les Fondouks',
            'Guide Guellala & Les Potiers Ancestraux',
            'Guide Ajim & El Melga (Pêche aux Éponges & Star Wars)',
            'Guide Gastronomie djerbienne : Les Meilleurs Couscous & Ryads',
            'Guide Plages Secrètes & Lagunes Sauvages',
            'Guide Midoun : Marchés & Vergers d\'Oliviers',
            'Guide Photographie & Spots Sunset Djerba',
            'Guide Famille & Activités Enfants à Djerba',
            'Guide Voyage Éco-Responsable & Artisanat',
            'Guide Plongée & Écosystèmes Marins Djerba',
            'Guide Hôtels de Charme & Menzel Authentiques',
            'Guide Bien-être, Spas & Hammams Orientaux',
            'Guide Histoire & Patrimoine Juif de la Ghriba',
            'Guide Transports & Location de Voiture Sécurisée',
            'Guide Architecture des Houss & Mosquées Underground',
            'Guide Vie Nocturne & Lounges Bord de Mer',
            'Guide Souvenirs & Négociation dans les Souks',
            'Guide Randonnées & Balades à Vélo à Djerba',
            'Guide Spots Kitesurf & Vent à Aghir'
        ],
        'Cartes GPS & Maps' => [
            'Carte GPS Secrète des 250 Fresques Djerbahood',
            'Carte GPS des Potiers & Ateliers Guellala',
            'Carte GPS des Meilleurs Restaurants de Poisson',
            'Carte GPS des 15 Plus Belles Plages Sauvages',
            'Carte GPS des Hôtels Ryads & Menzels',
            'Carte GPS des Circuits Vélo & Trottinette',
            'Carte GPS des Spots Sunset & Photographie',
            'Carte GPS des Marchés Hebdomadaires Djerbiens',
            'Carte GPS des Kitesurf & Water Sports Spots',
            'Carte GPS des Stations Essence & Garages Sécurisés',
            'Carte GPS des Boutiques de Bijoux Argent Souk',
            'Carte GPS des Cafés Traditionnels avec Vue',
            'Carte GPS des Fondouks & Caravansérails',
            'Carte GPS des Mosquées Fortifiées Historiques',
            'Carte GPS des Pharmacies & Cliniques d\'Urgence',
            'Carte GPS des Distributeurs & Bureaux de Change',
            'Carte GPS des Pistes Off-Road Quad & Buggy',
            'Carte GPS des Loueurs de Voitures Vérifiés',
            'Carte GPS des Ports de Pêche & Criées',
            'Carte GPS des Fermes d\'Huilieriennes Ancestrales'
        ],
        'Pass & Billets Excursions' => [
            'Pass Bateau Pirate & Île aux Flamants Roses',
            'Pass Randonnée Quad 2H au Coucher du Soleil',
            'Pass Cours de Kitesurf Lagune (Session 2H)',
            'Pass Cours de Cuisine Djerbienne en Ryad',
            'Pass Balade à Chameau le long de la Plage',
            'Pass Vol en Parapente Moteur au-dessus du Lagon',
            'Pass Dégustation d\'Huile d\'Olive & Huilerie Bio',
            'Pass Day-Pass Spa & Hammam Oriental VIP',
            'Pass Visite Guidée Privée Djerbahood',
            'Pass Excursion Désert 1 Jour Ksar Ghilane',
            'Pass Balade à Cheval dans les Palmeraies',
            'Pass Kayak de Mer & Stand-Up Paddle Lagune',
            'Pass Session Buggy Extrême dans les Dunes',
            'Pass Dîner Romantique Fruits de Mer sur la Plage',
            'Pass Visite du Musée de Guellala avec Guide Local',
            'Pass Traversée Bateau & Pêche Traditionnelle Ajim',
            'Pass Atelier Poterie & Sculptures sur Argile',
            'Pass Photographe Personnel (Session Photo 1H)',
            'Pass Location Vélo Électrique Journée',
            'Pass VIP Transfert Aéroport DJE A/R Privatif'
        ],
        'Packs Complets' => [
            'Pack Voyageur Complet Djerba en 7 Jours',
            'Pack Week-end Express 3 Jours Djerba',
            'Pack Romantique & Lune de Miel Djerba',
            'Pack Famille Tout Inclus Djerba 5 Jours',
            'Pack Aventure Désert & Oasis Sud Tunisien',
            'Pack Gourmet & Saveurs Orientales 4 Jours',
            'Pack Sports Nautiques & Sensations Forte',
            'Pack Culture & Histoire Millénaire Djerba',
            'Pack Road-Trip Voiture & Pistes 7 Jours',
            'Pack Nomade Digital & Remote Work Djerba'
        ],
        'Audio-Guides' => [
            'Audio-Guide Immersion Djerbahood (MP3 / App)',
            'Audio-Guide Houmt Souk & Les Légendes des Pirates',
            'Audio-Guide Guellala & Histoire de la Poterie',
            'Audio-Guide Ajim & La Pêche aux Éponges',
            'Audio-Guide Synagogue de la Ghriba & Histoire',
            'Audio-Guide Fort Ghazi Moustapha',
            'Audio-Guide Musée des Arts & Traditions Guellala',
            'Audio-Guide Circuit des Mosquées Underground',
            'Audio-Guide Chaussée Romaine & El Kantara',
            'Audio-Guide Contes & Musiques Traditionnelles Djerbiennes'
        ]
    ];

    $count = 1;
    $prices = [2.90, 3.50, 4.90, 5.90, 7.90, 9.90, 12.90, 14.90, 19.90, 29.90, 39.90, 49.90];

    foreach ($categories as $catName => $items) {
        foreach ($items as $index => $title) {
            $count++;
            $slug = 'produit-' . $count . '-' . strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $title));
            $slug = trim($slug, '-');
            $price = $prices[($count + $index) % count($prices)];
            $filePath = 'storage/downloads/product-' . $count . '.pdf';

            $stmtProduct->execute([$slug, $title, $price, $filePath]);
        }
    }

    echo "✅ 1 Produit Vedette Personnalisé + " . ($count-1) . " Produits seeded avec succès !\n";

    // 5. Articles (Articles SEO avec Guellala & Ajim)
    $articles = [
        [$destMap['houmt-souk'] ?? null, 'meilleure-periode-visiter-djerba', 'Quelle est la meilleure période pour visiter Djerba ?', '<p>Djerba bénéficie d\'un climat méditerranéen très doux toute l\'année. La période idéale s\'étend d\'avril à novembre avec des températures oscillant entre 24°C et 32°C.</p>', 'images/hero.png', 'published'],
        [$destMap['midoun'] ?? null, 'guide-complet-djerbahood', 'Guide Complet de Djerbahood : Le Musée de Street Art à Ciel Ouvert', '<p>Situé dans le village d\'Erriadh, Djerbahood regroupe plus de 250 fresques d\'artistes venus de plus de 30 pays.</p>', 'images/djerbahood.png', 'published'],
        [$destMap['guellala'] ?? null, 'guellala-poterie-artisanat', 'Guellala : Découverte des Potiers Ancestraux et du Musée d\'Art', '<p>Plongez au cœur du village des potiers de Guellala. Visitez les ateliers souterrains et assistez au façonnage traditionnel des jarres et amphores.</p>', 'images/guellala.png', 'published'],
        [$destMap['ajim-el-melga'] ?? null, 'ajim-port-eponges-star-wars', 'Ajim et El Melga : Entre Pêche aux Éponges et Cantina Star Wars', '<p>Explorez Ajim, port d\'origine des pêcheurs d\'éponges naturelles djerbiens et lieu de tournage culte du premier film Star Wars.</p>', 'images/ajim.png', 'published']
    ];
    $stmt = $pdo->prepare("INSERT INTO articles (destination_id, slug, title_fr, content_fr, featured_image, status) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE title_fr = VALUES(title_fr), featured_image = VALUES(featured_image)");
    foreach ($articles as $a) {
        $stmt->execute($a);
    }
    echo "✅ 4 Articles de blog SEO insérés.\n";

    echo "🎉 Base de données initialisée et seeded avec 6 DESTINATIONS & CATALOGUE !\n";

} catch (Exception $e) {
    echo "❌ Erreur Seeding: " . $e->getMessage() . "\n";
}
