<?php
namespace App\Services;

class DjerbaStoryDataProvider {
    public static function getStory(string $key, array $weather): array {
        $temp = $weather['temp_c'] ?? 28;
        $stories = self::getAllStories($temp);
        return $stories[$key] ?? $stories['menzel_architecture'];
    }

    private static function getAllStories(int $temp): array {
        return [
            'desert_adventure' => [
                'title_fr' => "Guide Complet de l'Aventure en Quad et Expédition Saharienne à Djerba",
                'title_en' => "Complete Guide to Quad Adventures and Sahara Expeditions from Djerba",
                'title_ar' => "دليل شامل لمغامرات الكواد والرحلات الصحراوية في جربة",
                'seo_description' => "Tarifs réels, circuits dans les dunes d'Aghir et pistes vers Ksar Ghilane : le guide d'expérience terrain à Djerba.",
                'lead' => "Envie de sensations fortes entre dunes dorées et lagunes sauvages ? Le quad et le buggy sont les meilleurs moyens d'explorer les recoins secrets de Djerba et les portes du Sahara tunisien.",
                'lead_en' => "Looking for thrilling sensations between golden dunes and wild lagoons? Quad and buggy rides are the best way to explore the hidden gems of Djerba and the gates of the Tunisian Sahara.",
                'lead_ar' => "هل تبحث عن الإثارة بين الكثبان الرملية الذهبية والبحيرات الهادئة؟ تعد رحلات الكواد والبوجي أفضل وسيلة لاستكشاف معالم جربة الساحرة وبوابات الصحراء التونسية.",
                'sections' => [
                    [
                        'title' => "Comment se déroule une sortie quad dans les dunes et la lagune d'Aghir ?",
                        'body' => "Le circuit classique démarre généralement depuis Aghir ou Midoun. Après un briefing de sécurité rigoureux et la remise des équipements de protection (casque intégral, lunettes anti-sable), vous partez sur les pistes sableuses bordées d'oliviers centenaires. Le tracé traverse le sébkha (lac salé asséché) avant de grimper sur les crêtes de dunes entourant le célèbre phare du Nadhour (Ras Taguernes). La vue plongeante sur l'eau turquoise de la lagune au coucher du soleil offre un contraste chromatique spectaculaire. Les départs matinaux (9h) et de fin d'après-midi (16h) garantissent une température agréable, loin de la chaleur de midi."
                    ],
                    [
                        'title' => "Peut-on rejoindre le grand désert de Ksar Ghilane et Tataouine depuis Djerba ?",
                        'body' => "Absolument. Djerba est le point de départ historique des caravaniers du Grand Sud. En empruntant la chaussée romaine d'El Kantara, une excursion en 4x4 de 2 jours permet de rallier l'oasis saharienne de Ksar Ghilane, réputée pour sa source thermale naturelle à 34°C jaillissant au milieu des dunes de sable fin. Sur le chemin, la traversée des ksour de Tataouine et du village berbère perché de Chenini plonge les voyageurs dans un décor lunaire d'une majesté brute. La nuitée sous tente bédouine avec dîner traditionnel au feu de bois reste une expérience inoubliable."
                    ]
                ],
                'table_headers' => ['Formule', 'Durée', 'Tarif indicatif', 'Recommandé pour'],
                'table_rows' => [
                    ['Balade Quad Initiation Dunes & Mer', '1h30', '90 TND (~27 €)', 'Débutants, familles avec ados'],
                    ['Grand Tour Lagune & Phare Taguernes', '2h30', '140 TND (~42 €)', 'Amateurs de beaux panoramas'],
                    ['Raid Buggy Deux Places Sensations', '2h00', '220 TND (~65 €)', 'Couples, confort de pilotage'],
                    ['Expédition Bivouac Sahara Ksar Ghilane', '2 jours', '420 TND (~125 €)', 'Aventuriers, dépaysement total']
                ],
                'tip' => "Optez pour des vêtements amples à manches longues et un chèche traditionnel pour vous protéger du vent et de la poussière. Les guides partenaires Djerba Voyage fournissent des machines récentes et révisées quotidiennement.",
                'faq' => [
                    ['Faut-il un permis pour conduire un quad à Djerba ?', 'Le permis B n\'est pas obligatoire sur les pistes fermées, mais il faut avoir au moins 16 ans pour piloter en autonomie. Les enfants dès 6 ans peuvent monter en passager avec un adulte.'],
                    ['Quels équipements sont fournis lors de l\'excursion ?', 'Le casque homologué et les lunettes de protection anti-poussière sont systématiquement fournis et inclus dans le tarif.'],
                    ['Quelle est la meilleure période pour le quad à Djerba ?', 'Le quad se pratique toute l\'année à Djerba grâce à plus de 300 jours d\'ensoleillement par an, avec une météo idéale au printemps et à l\'automne.']
                ],
                'cta_url' => 'https://djerbavoyage.tn/services#excursion-quad-djerba',
                'cta_text' => 'Réserver votre excursion en Quad en direct'
            ],
            'pottery_heritage' => [
                'title_fr' => "Guide Artisanal : Visiter les Potiers de Guellala et leurs Ateliers Souterrains à Djerba",
                'title_en' => "Artisanal Guide: Visiting Guellala Potters and Cave Workshops in Djerba",
                'title_ar' => "دليل الحرف اليدوية: زيارة فخار قلالة وورش العمل تحت الأرض في جربة",
                'seo_description' => "Tout savoir sur Guellala à Djerba : ateliers troglodytiques, maîtres potiers berbères, fabrication des amphores et tarifs réels.",
                'lead' => "Perché sur la plus haute colline de l'île, le village berbère de Guellala abrite un savoir-faire céramique transmis sans interruption depuis plus de 3 000 ans.",
                'lead_en' => "Perched on the highest hill of the island, the Berber village of Guellala preserves ceramic craftsmanship handed down continuously for over 3,000 years.",
                'lead_ar' => "تقع قرية قلالة البربرية على أعلى تلة في الجزيرة، وتحتضن تراثاً عريقاً في صناعة الخزف والفخار يتوارثه الحرفيون منذ أكثر من 3000 عام.",
                'sections' => [
                    [
                        'title' => "Pourquoi les ateliers de poterie de Guellala sont-ils creusés sous terre ?",
                        'body' => "Pour préserver l'argile de la dessiccation brutale causée par le soleil méditerranéen et le sirocco, les potiers de Guellala ont creusé leurs ateliers à plusieurs mètres sous terre dans la roche calcaire tendre. Cette architecture troglodytique maintient une température constante d'environ 20°C et un taux d'humidité optimal toute l'année. En descendant les marches séculaires d'un atelier, vous pénétrez dans un sanctuaire où le maître artisan actionne au pied son tour en bois d'olivier avec une régularité fascinante, façonnant cruches, plats à couscous et gargoulettes sous vos yeux."
                    ],
                    [
                        'title' => "Quelles pièces authentiques ramener et comment reconnaître le travail manuel ?",
                        'body' => "Les pièces maîtresses de Guellala sont les grandes jarres à huile d'olive (amphores traditionnelles), les services à tajine émaillés aux oxydes naturels, et le surprenant « chameau magique ». Cette poterie ingénieuse ne peut être remplie que par un orifice situé sous sa base sans jamais déborder grâce à un siphon intérieur ingénieux. Préférez les ateliers où les fours à bois traditionnels, alimentés aux feuilles de palmier sèches, sont encore en activité : ils confèrent à la terre cuite des nuances ocres et beiges impossibles à reproduire dans des fours industriels."
                    ]
                ],
                'table_headers' => ['Activité / Pièce', 'Durée / Taille', 'Tarif indicatif', 'Conseil d\'achat'],
                'table_rows' => [
                    ['Visite commentée d\'un atelier troglodyte', '45 min', 'Gratuit / Pourboire', 'Échangez avec le maître artisan'],
                    ['Chameau magique traditionnel vernissé', 'Moyen', '18 TND (~5,5 €)', 'Vérifiez le fonctionnement avec de l\'eau'],
                    ['Grand plat à couscous traditionnel', 'Ø 40 cm', '35 TND (~11 €)', 'Idéal pour déco murale ou service'],
                    ['Musée du Patrimoine de Guellala', '1h30', '10 TND (~3 €)', 'Vue panoramique imprenable au sommet']
                ],
                'tip' => "Montez au sommet de la colline de Guellala vers 18h : c'est le point culminant de Djerba, offrant le coucher de soleil le plus spectaculaire de l'île sur le golfe de Bougrara.",
                'faq' => [
                    ['Où se situe Guellala et comment y accéder ?', 'Guellala se situe au sud de l\'île, à environ 20 km de Houmt Souk et 25 km de la zone touristique de Midoun. On y accède facilement en taxi ou via une excursion guidée.'],
                    ['Les poteries résistent-elles à la cuisson au four ?', 'Les poteries non vernissées en terre brute sont idéales pour la cuisson lente au four ou sur braise, après avoir été trempées dans l\'eau avant la première utilisation.'],
                    ['Peut-on expédier de grandes pièces volumineuses ?', 'Oui, la plupart des maîtres artisans de Guellala proposent un emballage renforcé et une expédition sécurisée vers l\'Europe.']
                ],
                'cta_url' => 'https://djerbavoyage.tn/services#visite-guidee-djerba',
                'cta_text' => 'Réserver une visite guidée privée de Guellala'
            ],
            'menzel_architecture' => [
                'title_fr' => "Comprendre les Menzel & Houchs Traditionnels de Djerba : Patrimoine Mondial UNESCO",
                'title_en' => "Understanding Traditional Menzel & Houch Architecture in Djerba: UNESCO Heritage",
                'title_ar' => "فهم العمارة التقليدية للمنازل والحوش الجربي: تراث عالمي لليونسكو",
                'seo_description' => "Histoire secrète, coupoles thermiques et art de vivre dans les Menzel fortifiés de Djerba : analyse du patrimoine bioclimatique.",
                'lead' => "Classé au patrimoine mondial de l'UNESCO, le paysage culturel de Djerba témoigne d'une ingéniosité architecturale sans équivalent en Méditerranée pour apprivoiser l'eau et le vent.",
                'lead_en' => "Inscribed on the UNESCO World Heritage list, the cultural landscape of Djerba bears witness to an unprecedented architectural ingenuity in the Mediterranean.",
                'lead_ar' => "يُعد المشهد الثقافي لجزيرة جربة، المُدرج على قائمة التراث العالمي لليونسكو، شاهداً على عبقرية معمارية فريدة في حوض البحر الأبيض المتوسط للتكيف مع الطبيعة والمناخ.",
                'sections' => [
                    [
                        'title' => "Qu'est-ce qu'un Menzel djerbien et comment fonctionne le Houch central ?",
                        'body' => "Contrairement aux villages groupés classiques, l'habitat traditionnel djerbien est dispersé à travers la campagne. Le « Menzel » désigne le domaine agricole ceint de hauts talus de terre plantés d'agaves et de figuiers de barbarie (les tabias). En son cœur s'élève le « Houch », une habitation fortifiée organisée autour d'une cour intérieure carrée baignée de lumière. Les façades extérieures sont aveugles et austères pour protéger l'intimité familiale et décourager les incursions maritimes historiques, tandis que les cours intérieures rayonnent de chaux éclatante, de bougainvilliers pourpres et de jasmin odorant."
                    ],
                    [
                        'title' => "Pourquoi l'architecture des toits en coupole est-elle une merveille bioclimatique ?",
                        'body' => "Les coupoles d'aération (les ghorfas) et les voûtes blanchies à la chaux ne répondent pas seulement à un souci esthétique : elles constituent une climatisation passive d'une efficacité redoutable. La forme sphérique réfléchit les rayons du soleil à n'importe quelle heure de la journée et accélère la circulation de l'air frais par convection naturelle. Chaque goutte d'eau de pluie est méticuleusement collectée par des pentes d'impluvium savamment calculées et acheminée vers les citernes souterraines (les majels et feskia), garantissant la survie des familles même pendant les années de sécheresse."
                    ]
                ],
                'table_headers' => ['Élément Architectural', 'Fonction Clé', 'Rôle Bioclimatique', 'Intérêt Voyageur'],
                'table_rows' => [
                    ['Le Houch (Patio central)', 'Cœur de vie familial', 'Fraîcheur nocturne emmagasinée', 'Calme absolu & lumière douce'],
                    ['Coupoles et Voûtes', 'Plafonds sans poutres', 'Réflecteur solaire & volume d\'air', 'Esthétique épurée envoûtante'],
                    ['Tabias (Murs végétaux)', 'Clôture du Menzel', 'Brise-vent & fixation du sable', 'Chemins de balade ruraux'],
                    ['Majel (Citerne souterraine)', 'Stockage d\'eau de pluie', 'Eau filtrée fraîche en été', 'Génie hydraulique millénaire']
                ],
                'tip' => "Pour une immersion authentique, réservez une nuitée dans un Menzel historique réhabilité en maison d'hôtes de charme : le silence de la nuit djerbienne sous la voûte céleste est une cure de jouvence.",
                'faq' => [
                    ['Quand Djerba a-t-elle été classée au patrimoine mondial de l\'UNESCO ?', 'Djerba a été officiellement inscrite sur la liste du patrimoine mondial de l\'UNESCO en septembre 2023 pour son témoignage exceptionnel d\'occupation humaine et d\'adaptation au milieu insulaire.'],
                    ['Peut-on visiter l\'intérieur d\'un vrai Houch habité ?', 'Oui, certains domaines familiaux ouvrent leurs portes lors de circuits culturels avec un guide local respectueux des traditions.'],
                    ['Combien coûte une nuit dans une maison d\'hôtes traditionnelle ?', 'Les tarifs varient de 180 TND (~55 €) pour une chambre de charme à 500 TND (~150 €) pour une suite privative haut de gamme avec piscine patio.']
                ],
                'cta_url' => 'https://djerbavoyage.tn/concierge',
                'cta_text' => 'Découvrir nos hébergements de charme et service conciergerie'
            ]
        ];
    }
}
