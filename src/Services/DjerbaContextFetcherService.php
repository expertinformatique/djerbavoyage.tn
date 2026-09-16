<?php
namespace App\Services;

class DjerbaContextFetcherService {
    private array $angles = [
        'desert_adventure' => [
            'theme' => 'Aventure Saharienne & Traces des Caravanes depuis Djerba',
            'keywords' => ['ksar ghilane', 'dunes sahara', 'bivouac sous les étoiles', 'quad grand sud', 'caravanes djerba'],
            'suggested_services' => ['excursion-quad-djerba', 'circuit-sahara-2-jours'],
            'image_prompt' => 'Dramatic photography of quad bike expedition through rolling golden Sahara sand dunes near Djerba at sunset, warm cinematic lighting, authentic adventure',
            'fallback_local_image' => 'images/service_quad.jpg',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1473580044384-7ba9967e16a0?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'pottery_heritage' => [
            'theme' => 'Secrets Millénaires des Potiers de Guellala à Djerba',
            'keywords' => ['potiers guellala', 'argile souterraine', 'amphores traditionnelles', 'savoir-faire berbère', 'artisanat djerba'],
            'suggested_services' => ['visite-guidee-djerba', 'pass-conciergerie-premium'],
            'image_prompt' => 'Artisan potter shaping terracotta clay on ancient wooden wheel inside subterranean cave workshop in Guellala Djerba Tunisia, warm sunlight, authentic pottery jars',
            'fallback_local_image' => 'images/guellala.png',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'sponge_fishers' => [
            'theme' => 'Mémoire des Marins et Pêcheurs d\'Éponges d\'Ajim à Djerba',
            'keywords' => ['pêcheurs éponges ajim', 'felouques en bois', 'histoire maritime djerba', 'port ajim', 'légendes marines'],
            'suggested_services' => ['visite-guidee-djerba', 'excursion-jet-ski'],
            'image_prompt' => 'Traditional wooden fishing boats and natural sea sponges drying on stone dock at sunrise in Ajim Djerba Tunisia, turquoise Mediterranean sea, rustic maritime heritage',
            'fallback_local_image' => 'images/ajim.png',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1502680390469-be75c86b636f?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'lotophages_beaches' => [
            'theme' => 'Légende des Lotophages & Rivages Sauvages de Djerba',
            'keywords' => ['odyssée homère ulysse', 'lotophages djerba', 'plage sauvage sidi mahres', 'lagune préservée', 'eaux turquoise'],
            'suggested_services' => ['excursion-quad-djerba', 'transfert-aeroport-djerba'],
            'image_prompt' => 'Pristine secluded Mediterranean beach in Djerba Tunisia with turquoise water, ancient olive and palm trees on white sand, soft golden morning light, serene mythical atmosphere',
            'fallback_local_image' => 'images/sidi_mahres.png',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'djerbahood_story' => [
            'theme' => 'Contes d\'Erriadh & Ruelles Mystiques de Djerbahood',
            'keywords' => ['djerbahood street art', 'village antique erriadh', 'synagogue la ghriba', 'portes bleues cloutées', 'histoire multiculturelle'],
            'suggested_services' => ['visite-guidee-djerba', 'pass-conciergerie-premium'],
            'image_prompt' => 'Traditional sunlit whitewashed alley in Erriadh Djerbahood Tunisia, vibrant street art mural on historic stone wall, blooming bougainvillea, classic arched doorway',
            'fallback_local_image' => 'images/djerbahood.png',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'culinary_traditions' => [
            'theme' => 'Tradition de la Poissonnade et Secrets Culinaires de Djerba',
            'keywords' => ['criée houmt souk', 'poissonnade traditionnelle', 'riz djerbien épices', 'recettes ancestrales', 'marché aux épices'],
            'suggested_services' => ['pack-produits-locaux-djerba', 'pass-conciergerie-premium'],
            'image_prompt' => 'Authentic fresh Mediterranean fish platter seasoned with traditional spices, clay tagine dish, lemons and mint tea at outdoor souk in Houmt Souk Djerba, rustic culinary scene',
            'fallback_local_image' => 'images/houmt_souk.png',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'menzel_architecture' => [
            'theme' => 'L\'Âme Secrète des Menzel & Houchs Blancs de Djerba',
            'keywords' => ['menzel fortifié', 'houch djerbien', 'architecture vernaculaire', 'patrimoine unesco', 'puits traditionnels'],
            'suggested_services' => ['pass-conciergerie-premium', 'transfert-aeroport-djerba'],
            'image_prompt' => 'Stunning traditional Djerbian Menzel courtyard with brilliant whitewashed domes and fortified stone walls, surrounded by peaceful palm trees, warm golden hour sunlight',
            'fallback_local_image' => 'images/concierge.png',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'lagoon_adventure' => [
            'theme' => 'Aventure en Kitesurf sur la Lagune Turquoise de Djerba',
            'keywords' => ['kitesurf lagune djerba', 'glisse vent sensations', 'spot mythique', 'eau turquoise peu profonde', 'aventure maritime'],
            'suggested_services' => ['stage-kitesurf-djerba', 'excursion-jet-ski'],
            'image_prompt' => 'Dynamic action photography of kitesurfer gliding across crystal clear turquoise shallow lagoon in Djerba Tunisia, colorful kite against bright blue sky, water spray',
            'fallback_local_image' => 'images/service_kitesurf.jpg',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1502680390469-be75c86b636f?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
    ];

    public function getAngles(): array {
        return $this->angles;
    }

    public function getContext(): array {
        $weather = $this->fetchLiveWeather();
        $angleKey = array_rand($this->angles);
        $angle = $this->angles[$angleKey];

        return [
            'timestamp' => date('Y-m-d H:i:s'),
            'weather' => $weather,
            'angle' => $angle,
            'location' => 'Djerba, Tunisie',
            'currency' => 'EUR / TND',
        ];
    }

    public function fetchLiveWeather(): array {
        try {
            $url = "https://api.open-meteo.com/v1/forecast?latitude=33.8076&longitude=10.8451&current_weather=true";
            $ctx = stream_context_create(['http' => ['timeout' => 2]]);
            $json = @file_get_contents($url, false, $ctx);
            if ($json) {
                $data = json_decode($json, true);
                if (isset($data['current_weather'])) {
                    $cw = $data['current_weather'];
                    return [
                        'temp_c' => round($cw['temperature']),
                        'wind_speed' => $cw['windspeed'],
                        'condition' => $cw['weathercode'] <= 3 ? 'Ensoleillé & Ciel Dégagé' : 'Beau temps doux',
                    ];
                }
            }
        } catch (\Throwable $e) {
            // Silence & fallback
        }

        return [
            'temp_c' => rand(24, 31),
            'wind_speed' => 14,
            'condition' => 'Soleil radieux & Brise marine',
        ];
    }
}
