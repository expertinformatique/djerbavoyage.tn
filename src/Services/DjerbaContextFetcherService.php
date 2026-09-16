<?php
namespace App\Services;

class DjerbaContextFetcherService {
    private array $angles = [
        'beaches_weather' => [
            'theme' => 'Météo, Plages & Baignade à Djerba',
            'keywords' => ['plage Lella Hadria', 'lagune djerba', 'météo soleil', 'baignade eau turquoise', 'sidi mahrez'],
            'suggested_services' => ['excursion-quad-djerba', 'transfert-aeroport-djerba']
        ],
        'water_sports' => [
            'theme' => 'Kitesurf, Jet Ski & Sports Nautiques',
            'keywords' => ['kitesurf lagune', 'jet ski djerba', 'paddle', 'activités nautiques', 'sensations fortes'],
            'suggested_services' => ['stage-kitesurf-djerba', 'excursion-jet-ski']
        ],
        'desert_adventure' => [
            'theme' => 'Excursion Désert, Buggy & Quad depuis Djerba',
            'keywords' => ['ksar ghilane', 'tataouine star wars', 'quad djerba', 'nuit sous tente désert', 'dunes de sable'],
            'suggested_services' => ['excursion-quad-djerba', 'circuit-sahara-2-jours']
        ],
        'culture_heritage' => [
            'theme' => 'Culture, Djerbahood & Artisanat de Guellala',
            'keywords' => ['djerbahood erriadh', 'poterie guellala', 'souk houmt souk', 'synagogue la ghriba', 'musée lalla hadria'],
            'suggested_services' => ['visite-guidee-djerba', 'pass-conciergerie-premium']
        ],
        'hotels_spa' => [
            'theme' => 'Hôtels de Charme, Thalasso & Détente à Djerba',
            'keywords' => ['thalasso djerba', 'hôtel de charme djerba', 'spa hammam', 'séjour détente', 'hôtels zone touristique'],
            'suggested_services' => ['pass-conciergerie-premium', 'transfert-aeroport-djerba']
        ],
        'gastronomy' => [
            'theme' => 'Gastronomie Djerbienne & Poissonnade au Souk',
            'keywords' => ['poissonnade houmt souk', 'riz djerbien', 'brik à l oeuf', 'thé à la menthe djerba', 'produits du terroir'],
            'suggested_services' => ['pack-produits-locaux-djerba', 'pass-conciergerie-premium']
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
