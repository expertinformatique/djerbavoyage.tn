<?php
namespace App\Services;

class DjerbaContextFetcherService {
    private array $angles = [
        'beaches_weather' => [
            'theme' => 'Météo, Plages & Baignade à Djerba',
            'keywords' => ['plage Lella Hadria', 'lagune djerba', 'météo soleil', 'baignade eau turquoise', 'sidi mahrez'],
            'suggested_services' => ['excursion-quad-djerba', 'transfert-aeroport-djerba'],
            'image_prompt' => 'Pristine white sand beach in Djerba Tunisia with crystal turquoise Mediterranean sea, traditional straw umbrellas, sunny blue sky, beautiful travel photography',
            'fallback_local_image' => 'images/sidi_mahres.png',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'water_sports' => [
            'theme' => 'Kitesurf, Jet Ski & Sports Nautiques',
            'keywords' => ['kitesurf lagune', 'jet ski djerba', 'paddle', 'activités nautiques', 'sensations fortes'],
            'suggested_services' => ['stage-kitesurf-djerba', 'excursion-jet-ski'],
            'image_prompt' => 'Action photography of kitesurfers and jet-ski on shallow turquoise lagoon in Djerba Tunisia, colorful kite in bright sky, water spray, dynamic watersport',
            'fallback_local_image' => 'images/service_kitesurf.jpg',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1502680390469-be75c86b636f?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'desert_adventure' => [
            'theme' => 'Excursion Désert, Buggy & Quad depuis Djerba',
            'keywords' => ['ksar ghilane', 'tataouine star wars', 'quad djerba', 'nuit sous tente désert', 'dunes de sable'],
            'suggested_services' => ['excursion-quad-djerba', 'circuit-sahara-2-jours'],
            'image_prompt' => 'Exciting desert quad bike adventure in golden sand dunes near Djerba Sahara desert, dramatic warm sunset lighting, sand dust trail, adventurous action',
            'fallback_local_image' => 'images/service_quad.jpg',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1473580044384-7ba9967e16a0?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'culture_heritage' => [
            'theme' => 'Culture, Djerbahood & Artisanat de Guellala',
            'keywords' => ['djerbahood erriadh', 'poterie guellala', 'souk houmt souk', 'synagogue la ghriba', 'musée lalla hadria'],
            'suggested_services' => ['visite-guidee-djerba', 'pass-conciergerie-premium'],
            'image_prompt' => 'Authentic sunlit alleyway in Erriadh Djerbahood Tunisia, artistic painted street art mural on traditional white stucco wall, blooming bougainvillea flowers, rustic blue door',
            'fallback_local_image' => 'images/djerbahood.png',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'hotels_spa' => [
            'theme' => 'Hôtels de Charme, Thalasso & Détente à Djerba',
            'keywords' => ['thalasso djerba', 'hôtel de charme djerba', 'spa hammam', 'séjour détente', 'hôtels zone touristique'],
            'suggested_services' => ['pass-conciergerie-premium', 'transfert-aeroport-djerba'],
            'image_prompt' => 'Luxury boutique hotel swimming pool in Djerba Tunisia, traditional white domes and arches, palm trees reflection on turquoise water, peaceful sunny relaxation ambiance',
            'fallback_local_image' => 'images/concierge.png',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'gastronomy' => [
            'theme' => 'Gastronomie Djerbienne & Poissonnade au Souk',
            'keywords' => ['poissonnade houmt souk', 'riz djerbien', 'brik à l oeuf', 'thé à la menthe djerba', 'produits du terroir'],
            'suggested_services' => ['pack-produits-locaux-djerba', 'pass-conciergerie-premium'],
            'image_prompt' => 'Appetizing traditional Tunisian seafood dish in Djerba, freshly grilled Mediterranean fish, crispy brik, lemon slices, pottery bowl on rustic sunny restaurant terrace',
            'fallback_local_image' => 'images/houmt_souk.png',
            'realistic_images' => [
                'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
    ];

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
