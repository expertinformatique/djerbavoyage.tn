<?php
namespace App\Services;

class DjerbaContextFetcherService {
    private array $angles = [
        'beaches_weather' => [
            'theme' => 'Météo, Plages & Baignade à Djerba',
            'keywords' => ['plage Lella Hadria', 'lagune djerba', 'météo soleil', 'baignade eau turquoise', 'sidi mahrez'],
            'suggested_services' => ['excursion-quad-djerba', 'transfert-aeroport-djerba'],
            'realistic_images' => [
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'water_sports' => [
            'theme' => 'Kitesurf, Jet Ski & Sports Nautiques',
            'keywords' => ['kitesurf lagune', 'jet ski djerba', 'paddle', 'activités nautiques', 'sensations fortes'],
            'suggested_services' => ['stage-kitesurf-djerba', 'excursion-jet-ski'],
            'realistic_images' => [
                'https://images.unsplash.com/photo-1502680390469-be75c86b636f?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'desert_adventure' => [
            'theme' => 'Excursion Désert, Buggy & Quad depuis Djerba',
            'keywords' => ['ksar ghilane', 'tataouine star wars', 'quad djerba', 'nuit sous tente désert', 'dunes de sable'],
            'suggested_services' => ['excursion-quad-djerba', 'circuit-sahara-2-jours'],
            'realistic_images' => [
                'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1473580044384-7ba9967e16a0?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'culture_heritage' => [
            'theme' => 'Culture, Djerbahood & Artisanat de Guellala',
            'keywords' => ['djerbahood erriadh', 'poterie guellala', 'souk houmt souk', 'synagogue la ghriba', 'musée lalla hadria'],
            'suggested_services' => ['visite-guidee-djerba', 'pass-conciergerie-premium'],
            'realistic_images' => [
                'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1541961017774-22349e4a1262?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'hotels_spa' => [
            'theme' => 'Hôtels de Charme, Thalasso & Détente à Djerba',
            'keywords' => ['thalasso djerba', 'hôtel de charme djerba', 'spa hammam', 'séjour détente', 'hôtels zone touristique'],
            'suggested_services' => ['pass-conciergerie-premium', 'transfert-aeroport-djerba'],
            'realistic_images' => [
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80'
            ]
        ],
        'gastronomy' => [
            'theme' => 'Gastronomie Djerbienne & Poissonnade au Souk',
            'keywords' => ['poissonnade houmt souk', 'riz djerbien', 'brik à l oeuf', 'thé à la menthe djerba', 'produits du terroir'],
            'suggested_services' => ['pack-produits-locaux-djerba', 'pass-conciergerie-premium'],
            'realistic_images' => [
                'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=80'
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
