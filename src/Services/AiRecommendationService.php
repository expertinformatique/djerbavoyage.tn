<?php
namespace App\Services;

class AiRecommendationService {
    public const VALID_TRAVELERS = ['couple', 'family', 'solo', 'friends'];
    public const VALID_STYLES = ['culture', 'beach', 'adventure', 'food', 'sahara'];
    public const VALID_LODGINGS = ['menzel', 'resort', 'villa', 'club'];
    public const VALID_PACES = ['relax', 'balanced', 'active', 'desert'];
    public const VALID_DURATIONS = ['3j', '5j', '8j'];

    public const ROTATING_BADGES = [
        '✨ Pépite du Moment',
        '🔥 Tendance 2026',
        '💎 Coup de Cœur Insulaire',
        '🌿 Éco-Responsable',
        '⭐ Top Vente Locale',
        '🌊 Exclusivité Djerba'
    ];

    public function getBadgeForVisit(int $visitCount, int $itemIndex): string {
        $count = count(self::ROTATING_BADGES);
        $idx = ($visitCount + $itemIndex) % $count;
        return self::ROTATING_BADGES[$idx];
    }

    public const GREETINGS_FIRST_VISIT = [
        "Bienvenue à Djerba ! Prenez 30 secondes pour trouver la formule idéale pour vos vacances.",
        "Ravi de vous accueillir ! Laissez notre IA vous guider vers les plus beaux trésors de l'île.",
        "Bienvenue ! En quelques questions rapides, découvrez vos activités et hébergements idéaux."
    ];

    public const GREETINGS_HESITATING = [
        "Vous hésitez encore ? Testez notre simulateur gratuit, il vous donnera de superbes idées d'itinéraires !",
        "Toujours indécis pour votre séjour ? Laissez notre IA vous inspirer en 30 secondes, c'est 100% gratuit.",
        "Besoin d'inspiration pour Djerba ? Notre planificateur gratuit est là pour vous donner un coup de pouce !"
    ];

    public const GREETINGS_RETURNING_CHOSEN = [
        "Votre choix précédent ne vous plaît plus ? Pourquoi ne pas essayer autre chose, c'est toujours gratuit !",
        "Envie d'explorer d'autres horizons ? Notre IA a de nouvelles variantes d'itinéraires à vous proposer !",
        "Nous avons de nombreux choix ! N'hésitez pas à <a href='/contact' class='c-ai-quiz__banner-link'>nous contacter ici</a> pour un conseil personnalisé."
    ];

    public function getBehavioralGreeting(int $visitCount, bool $hasChosenBefore, int $seed = 0): string {
        if ($visitCount <= 1) {
            return self::GREETINGS_FIRST_VISIT[$seed % count(self::GREETINGS_FIRST_VISIT)];
        }
        if (!$hasChosenBefore) {
            return self::GREETINGS_HESITATING[$seed % count(self::GREETINGS_HESITATING)];
        }
        return self::GREETINGS_RETURNING_CHOSEN[$seed % count(self::GREETINGS_RETURNING_CHOSEN)];
    }

    public function calculateMatchScore(array $criteria): int {
        $score = 85;
        if (!empty($criteria['traveler']) && in_array($criteria['traveler'], self::VALID_TRAVELERS, true)) {
            $score += 3;
        }
        if (!empty($criteria['style']) && in_array($criteria['style'], self::VALID_STYLES, true)) {
            $score += 4;
        }
        if (!empty($criteria['lodging']) && in_array($criteria['lodging'], self::VALID_LODGINGS, true)) {
            $score += 3;
        }
        if (!empty($criteria['pace']) && in_array($criteria['pace'], self::VALID_PACES, true)) {
            $score += 2;
        }
        if (!empty($criteria['duration']) && in_array($criteria['duration'], self::VALID_DURATIONS, true)) {
            $score += 2;
        }
        return min(99, $score);
    }

    public function generateRecommendation(array $criteria, int $variantIndex = 0): array {
        $style = in_array($criteria['style'] ?? '', self::VALID_STYLES, true) ? $criteria['style'] : 'culture';
        $duration = in_array($criteria['duration'] ?? '', self::VALID_DURATIONS, true) ? strtoupper($criteria['duration']) : '5J';
        $traveler = $criteria['traveler'] ?? 'couple';

        $variants = [
            'culture' => [
                [
                    'title' => "Immersion Patrimoine, Menzels & Ruelles d'Art",
                    'itinerary' => "Circuit Djerbahood, Souks & Ateliers de Guellala",
                    'hotel' => "Dar Dhiafa (Erriadh)",
                    'alt_hotel' => "Dar Bibine (Maison d'hôtes design)",
                    'restaurant' => "Dar Hassine (Cour ombragée)"
                ],
                [
                    'title' => "Odyssée Historique, Forts & Traditions Ancestrales",
                    'itinerary' => "De la Chaussée Romaine aux Ports de Pêcheurs",
                    'hotel' => "Dar El Gaïed (Houmt Souk)",
                    'alt_hotel' => "Dar Sultan (Luxe & Hammam)",
                    'restaurant' => "Le Caravansérail (Dîner aux chandelles)"
                ]
            ],
            'beach' => [
                [
                    'title' => "Plage Privée, Lagon Turquoise & Thalasso Marine",
                    'itinerary' => "Sidi Mahres, Île aux Flamants Roses & Soirée Mer",
                    'hotel' => "Radisson Blu Palace Resort & Thalasso 5★",
                    'alt_hotel' => "Iberostar Selection Djerba Beach 4★",
                    'restaurant' => "Le Moussaillon (Grillades de poisson)"
                ],
                [
                    'title' => "Échappée Lagon Sauvage, Catamaran & Coucher de Soleil",
                    'itinerary' => "Lagune d'Aghir, Bains de Soleil & Croisière Sunset",
                    'hotel' => "Hasdrubal Prestige Thalassa 5★",
                    'alt_hotel' => "Sentido Djerba Beach 4★",
                    'restaurant' => "La Lagune Sunset Lounge"
                ]
            ],
            'adventure' => [
                [
                    'title' => "Sensations Pures : Raid Quad Salines & Kitesurf",
                    'itinerary' => "Pistes Oasiennes, Dunes Blanches & Glisse Aérienne",
                    'hotel' => "Menzel Cajou Aghir",
                    'alt_hotel' => "Seabel Rives Bleues",
                    'restaurant' => "Table d'Hôtes Al Jazeera"
                ],
                [
                    'title' => "Aventure Tout-Terrain & Safari Nocturne Nomade",
                    'itinerary' => "Raid Buggy 800cc, Salines Sauvages & Feu de Camp",
                    'hotel' => "Sentido Djerba Beach 4★",
                    'alt_hotel' => "Houch El Khadra",
                    'restaurant' => "Barbecue Cabane de Pêcheur"
                ]
            ],
            'food' => [
                [
                    'title' => "Haute Gastronomie Insulaire, Vins Fins & Ryads",
                    'itinerary' => "Dégustation Poissons Nobles & Dîner aux Chandelles",
                    'hotel' => "Hasdrubal Prestige Thalassa 5★",
                    'alt_hotel' => "Dar Zahra",
                    'restaurant' => "Le Haroun (Port d'Houmt Souk)"
                ],
                [
                    'title' => "Terroir Authentique : Couscous Djerbien & Gargoulette",
                    'itinerary' => "Marché des Épices & Gargoulette sous Terre",
                    'hotel' => "Dar Dhiafa (Erriadh)",
                    'alt_hotel' => "Menzel Tazi",
                    'restaurant' => "Es Sofra (Couscous & Gargoulette)"
                ]
            ],
            'sahara' => [
                [
                    'title' => "Expédition Portes du Sahara, Matmata & Source Chaude",
                    'itinerary' => "De Djerba aux Dunes du Grand Sud en 4x4",
                    'hotel' => "Nuit Insolite dans un Ksar Berbère",
                    'alt_hotel' => "Radisson Blu Palace",
                    'restaurant' => "Dîner Bédouin dans les Dunes"
                ],
                [
                    'title' => "Grand Raid Sud : Ksour de Tataouine & Chenini Berbère",
                    'itinerary' => "Villages Perchés & Greniers Fortifiés",
                    'hotel' => "Hôtel Troglodyte Matmata",
                    'alt_hotel' => "Dar El Gaïed",
                    'restaurant' => "Table Berbère de Chenini"
                ]
            ]
        ];

        $styleVariants = $variants[$style] ?? $variants['culture'];
        $chosen = $styleVariants[$variantIndex % count($styleVariants)];

        return [
            'title' => "{$chosen['title']} ({$duration} • Profil " . ucfirst($traveler) . ")",
            'itinerary' => $chosen['itinerary'],
            'hotel' => $chosen['hotel'],
            'alt_hotel' => $chosen['alt_hotel'],
            'restaurant' => $chosen['restaurant'],
            'match_score' => $this->calculateMatchScore($criteria),
            'variant_index' => $variantIndex
        ];
    }
}
