/**
 * AI Recommendation Catalog — Real services, multiple variants & secret spots for Djerba
 */
export const ROTATING_BADGES = [
    '✨ Coup de Cœur',
    '🔥 Tendance',
    '💎 Pépite',
    '🌿 Éco-Chic',
    '⭐ Top Choix',
    '🌊 Incontournable'
];

export const SECRET_TIPS = [
    { title: "La Criée du Port d'Houmt Souk", desc: "Arrivez à 16h au port pour assister aux enchères traditionnelles de poissons à la corde : spectacle authentique garanti !" },
    { title: "Coucher de soleil aux Salines d'Aghir", desc: "Moins fréquenté que Sidi Mahres, le bord des salines offre un miroir d'eau rose spectaculaire au crépuscule." },
    { title: "Les Potiers Souterrains de Guellala", desc: "Demandez à visiter les ateliers troglodytes creusés dans l'argile, où la température reste fraîche toute l'année." },
    { title: "Thé à la menthe chez Chichkhan", desc: "Savourez un thé aux pignons et cornes de gazelle dans l'une des cours intérieures les plus secrètes d'Houmt Souk." },
    { title: "La Plage Sauvage de Seguiet", desc: "Une eau transparente peu profonde et un lagon paisible, parfait pour une balade matinale loin de l'agitation." },
    { title: "Fresques Cachées de Djerbahood", desc: "Empruntez les venelles secondaires vers l'est du village d'Erriadh pour découvrir les fresques préservées des artistes internationaux." }
];

export const RECOMMENDATION_VARIANTS = {
    culture: [
        {
            title: "Immersion Patrimoine, Menzels & Ruelles d'Art",
            itineraryTitle: "Circuit Djerbahood, Souks & Ateliers de Guellala",
            itineraryDesc: "Jour 1 : Djerbahood & Synagogue de la Ghriba. Jour 2 : Fondouks d'Houmt Souk & Musée de Guellala. Jour 3 : Fort Borj El Kebir.",
            hotel: "Dar Dhiafa (Erriadh)",
            hotelDesc: "Menzel historique séculaire avec patio fleuri, fontaines et suites d'exception.",
            altHotel: "Dar Bibine (Maison d'hôtes design & art)",
            activities: [
                { name: "Randonnée Dromadaire Ateliers de Guellala", price: "38 €", slug: "chameau-caravane-plage" },
                { name: "Pack Duo Quad & Dromadaire", price: "45 €", slug: "quad-lagune-sunset" }
            ],
            restaurant: "Dar Hassine (Cour ombragée & briks artisanales)"
        },
        {
            title: "Odyssée Historique, Forts & Traditions Ancestrales",
            itineraryTitle: "De la Chaussée Romaine aux Ports de Pêcheurs",
            itineraryDesc: "Jour 1 : Houmt Souk & marché aux épices. Jour 2 : Potiers de Guellala & côte sud. Jour 3 : Mosquées fortifiées et port d'Ajim.",
            hotel: "Dar El Gaïed (Houmt Souk)",
            hotelDesc: "Demeure patricienne du XIXe restaurée avec jardins intérieurs calmes.",
            altHotel: "Dar Sultan (Luxe & Hammam privé)",
            activities: [
                { name: "Circuit Quad Pistes Sauvages d'Erriadh", price: "35 €", slug: "quad-lagune-sunset" },
                { name: "Traversée Bateau Pirate Île Flamants Roses", price: "35 €", slug: "base-nautique-jet-ski" }
            ],
            restaurant: "Le Caravansérail (Dîner aux chandelles dans un fondouk)"
        }
    ],
    beach: [
        {
            title: "Plage Privée, Lagon Turquoise & Thalasso Marine",
            itineraryTitle: "Sidi Mahres, Île aux Flamants Roses & Soirée Mer",
            itineraryDesc: "Jour 1 : Farniente sur le sable blanc de Sidi Mahres. Jour 2 : Excursion bateau pirate. Jour 3 : Rituel spa & thalasso.",
            hotel: "Radisson Blu Palace Resort & Thalasso 5★",
            hotelDesc: "Pieds dans l'eau avec parcours marin thalasso d'exception.",
            altHotel: "Iberostar Selection Djerba Beach 4★",
            activities: [
                { name: "Vol Parachute Ascensionnel Lagon", price: "40 €", slug: "base-nautique-jet-ski" },
                { name: "Traversée Bateau Pirate Flamants Roses", price: "35 €", slug: "base-nautique-jet-ski" }
            ],
            restaurant: "Le Moussaillon (Grillades de poissons & calamars frais)"
        },
        {
            title: "Échappée Lagon Sauvage, Catamaran & Coucher de Soleil",
            itineraryTitle: "Lagune d'Aghir, Bains de Soleil & Croisière Sunset",
            itineraryDesc: "Jour 1 : Navigation catamaran au sunset. Jour 2 : Paddle translucide sur lagon calme. Jour 3 : Détente piscine et massage aux huiles.",
            hotel: "Hasdrubal Prestige Thalassa 5★",
            hotelDesc: "Resort de prestige bordé d'un immense lagon d'eau de mer privée.",
            altHotel: "Sentido Djerba Beach 4★",
            activities: [
                { name: "Excursion Catamaran Luxe & Sunset", price: "45 €", slug: "base-nautique-jet-ski" },
                { name: "Location Stand-Up Paddle & Kayak Translucide", price: "20 €", slug: "base-nautique-jet-ski" }
            ],
            restaurant: "La Lagune Sunset Lounge (Tapas de la mer & vue coucher de soleil)"
        }
    ],
    adventure: [
        {
            title: "Sensations Pures : Raid Quad Salines & Kitesurf",
            itineraryTitle: "Pistes Oasiennes, Dunes Blanches & Glisse Aérienne",
            itineraryDesc: "Jour 1 : Randonnée quad coucher de soleil vers la lagune. Jour 2 : Session kitesurf ou jet-ski à Aghir. Jour 3 : Galop pur-sang sur la plage.",
            hotel: "Menzel Cajou Aghir",
            hotelDesc: "Boutique-hôtel avec piscine lagon, à 5 minutes des meilleurs spots de glisse.",
            altHotel: "Seabel Rives Bleues Resort & Spa",
            activities: [
                { name: "Randonnée Quad & Buggy Coucher de Soleil", price: "40 €", slug: "quad-lagune-sunset" },
                { name: "Session & Stage Kitesurf Lagon", price: "90 €", slug: "base-nautique-kitesurf" }
            ],
            restaurant: "Table d'Hôtes Al Jazeera (Plats rustiques & agneau grillé)"
        },
        {
            title: "Aventure Tout-Terrain & Safari Nocturne Nomade",
            itineraryTitle: "Raid Buggy 800cc, Salines Sauvages & Feu de Camp",
            itineraryDesc: "Jour 1 : Pilotage buggy Can-Am dans les pistes salées. Jour 2 : Jet-ski grand large. Jour 3 : Safari quad nocturne sous les étoiles.",
            hotel: "Sentido Djerba Beach 4★",
            hotelDesc: "Hôtel convivial en bord de mer, base parfaite pour les sports.",
            altHotel: "Houch El Khadra (Éco-domaine oasien)",
            activities: [
                { name: "Randonnée Buggy Can-Am Extreme 800cc", price: "75 €", slug: "quad-lagune-sunset" },
                { name: "Safari Quad Nocturne & Feux de Camp", price: "50 €", slug: "quad-lagune-sunset" }
            ],
            restaurant: "Dîner Barbecue Poisson dans une Cabane de Pêcheur"
        }
    ],
    food: [
        {
            title: "Haute Gastronomie Insulaire, Vins Fins & Ryads",
            itineraryTitle: "Dégustation Poissons Nobles & Dîner aux Chandelles",
            itineraryDesc: "Jour 1 : Poissons frais et langoustes au port. Jour 2 : Atelier dégustation huiles d'olive bio & vins. Jour 3 : Dîner gastronomique en ryad.",
            hotel: "Hasdrubal Prestige Thalassa 5★",
            hotelDesc: "Palace réputé pour sa table gastronomique et son service haut de gamme.",
            altHotel: "Dar Zahra (Suite de charme avec jacuzzi)",
            activities: [
                { name: "Dîner Gastronomique Haroun Port", price: "45 €", slug: "diner-spectacle-bedouin" },
                { name: "Dîner Romantique Privé sur la Plage aux Bougies", price: "75 €", slug: "diner-spectacle-bedouin" }
            ],
            restaurant: "Le Haroun (Port d'Houmt Souk — Poissons du jour & fruits de mer)"
        },
        {
            title: "Terroir Authentique : Couscous Djerbien & Gargoulette",
            itineraryTitle: "Marché des Épices, Gargoulette sous Terre & Pâtisseries",
            itineraryDesc: "Jour 1 : Dégustation d'agneau à la gargoulette cuite à l'étouffée. Jour 2 : Dîner spectacle nomade. Jour 3 : Thé à la menthe et douceurs de Djerba.",
            hotel: "Dar Dhiafa (Erriadh)",
            hotelDesc: "Immersion dans un ryad d'exception avec petits-déjeuners gourmands du terroir.",
            altHotel: "Menzel Tazi (Potager bio & cuisine maison)",
            activities: [
                { name: "Dîner Spectacle Bédouin sous Tente", price: "38 €", slug: "diner-spectacle-bedouin" },
                { name: "Soirée Gargoulette d'Agneau sous Terre", price: "36 €", slug: "diner-spectacle-bedouin" }
            ],
            restaurant: "Es Sofra (Couscous traditionnel au mérou & gargoulette djerbienne)"
        }
    ],
    sahara: [
        {
            title: "Expédition Portes du Sahara, Matmata & Source Chaude",
            itineraryTitle: "De Djerba aux Dunes du Grand Sud en 4x4",
            itineraryDesc: "Jour 1 : Maisons troglodytes de Matmata & décors Star Wars. Jour 2 : Baignade source chaude de Ksar Ghilane. Jour 3 : Coucher de soleil sur l'Erg.",
            hotel: "Nuit Insolite dans un Ksar Berbère / Bivouac Saharien",
            hotelDesc: "Expérience inoubliable sous le ciel étoilé du grand désert.",
            altHotel: "Radisson Blu Palace (Retour confort à Djerba)",
            activities: [
                { name: "Excursion Grand Sud & Portes du Sahara (4x4)", price: "95 €", slug: "sahara-ksar-ghilane" },
                { name: "Bain Thermal Source Chaude Ksar Ghilane", price: "70 €", slug: "sahara-ksar-ghilane" }
            ],
            restaurant: "Dîner Bédouin dans les Dunes sous les Étoiles"
        },
        {
            title: "Grand Raid Sud : Ksour de Tataouine & Chenini Berbère",
            itineraryTitle: "Villages Perchés, Greniers Fortifiés & Pistes du Sud",
            itineraryDesc: "Jour 1 : Traversée vers Tataouine & Ksar Ouled Soltane. Jour 2 : Village berbère millénaire de Chenini. Jour 3 : Retour par la Chaussée Romaine.",
            hotel: "Hôtel Troglodyte Matmata & Menzel de Charme Djerba",
            hotelDesc: "Architecture souterraine millénaire puis détente au bord de l'eau.",
            altHotel: "Dar El Gaïed (Maison patricienne Houmt Souk)",
            activities: [
                { name: "Excursion 4x4 Ksour de Tataouine & Chenini", price: "85 €", slug: "sahara-ksar-ghilane" },
                { name: "Caravane Dromadaire avec Thé Bédouin", price: "30 €", slug: "chameau-caravane-plage" }
            ],
            restaurant: "Table Berbère Traditionnelle de Chenini"
        }
    ]
};
