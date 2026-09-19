<?php
namespace App\Services;

class DjerbaContextFetcherService {
    private array $angles = [
        'desert_ksar_ghilane' => [
            'theme' => 'Excursion à Ksar Ghilane : Source Chaude et Dunes du Sahara depuis Djerba',
            'keywords' => ['ksar ghilane', 'source thermale', 'dunes grand sud', 'bivouac sahara', 'tataouine'],
            'suggested_services' => ['circuit-sahara-2-jours', 'excursion-quad-djerba'],
            'facts' => 'Source thermale à 34°C au milieu du désert, environ 150 km au sud de Djerba par la chaussée romaine.',
            'image_prompt' => 'Dramatic high resolution photography of natural warm thermal spring oasis surrounded by golden Sahara sand dunes in Ksar Ghilane Tunisia, palm trees at sunset, warm cinematic lighting',
            'fallback_local_image' => 'images/service_quad.jpg'
        ],
        'pottery_heritage' => [
            'theme' => 'Secrets Millénaires des Potiers de Guellala à Djerba',
            'keywords' => ['potiers guellala', 'argile souterraine', 'amphores traditionnelles', 'savoir-faire berbère', 'artisanat djerba'],
            'suggested_services' => ['visite-guidee-djerba', 'pass-conciergerie-premium'],
            'facts' => 'Ateliers troglodytes creusés dans la colline argileuse de Guellala, fours à bois traditionnels millénaires.',
            'image_prompt' => 'Artisan master potter shaping terracotta clay amphora on ancient wooden foot wheel inside cave workshop in Guellala Djerba Tunisia, shafts of golden morning sunlight',
            'fallback_local_image' => 'images/guellala.png'
        ],
        'sponge_fishers' => [
            'theme' => 'Mémoire des Marins et Pêcheurs d\'Éponges d\'Ajim à Djerba',
            'keywords' => ['pêcheurs éponges ajim', 'felouques en bois', 'histoire maritime djerba', 'port ajim', 'détroit ajim'],
            'suggested_services' => ['visite-guidee-djerba', 'excursion-jet-ski'],
            'facts' => 'Ajim est le port historique des pêcheurs sous-marins d\'éponges naturelles et point de passage du bac vers le continent.',
            'image_prompt' => 'Traditional wooden fishing boats moored at rocky stone pier in Ajim Djerba Tunisia, natural sea sponges on rustic wooden crates, serene turquoise sea at dawn',
            'fallback_local_image' => 'images/ajim.png'
        ],
        'djerbahood_erriadh' => [
            'theme' => 'Contes d\'Erriadh & Ruelles Mystiques de Djerbahood',
            'keywords' => ['djerbahood street art', 'village antique erriadh', 'synagogue la ghriba', 'portes bleues cloutées', 'galerie ciel ouvert'],
            'suggested_services' => ['visite-guidee-djerba', 'pass-conciergerie-premium'],
            'facts' => 'Plus de 250 fresques d\'artistes internationaux peintes sur les murs de chaux blanche du village millénaire d\'Erriadh.',
            'image_prompt' => 'Charming sunlit whitewashed alley in Erriadh Djerbahood Tunisia, colorful street art mural on historic stone facade, pink bougainvillea, classic arched studded doorway',
            'fallback_local_image' => 'images/djerbahood.png'
        ],
        'flamants_roses_island' => [
            'theme' => 'Échappée en Mer vers la Presqu\'île des Flamants Roses à Djerba',
            'keywords' => ['île aux flamants roses', 'presqu\'île ras rmel', 'bateau pirate djerba', 'oiseaux migrateurs', 'banc de sable'],
            'suggested_services' => ['excursion-bateau-pirate', 'excursion-jet-ski'],
            'facts' => 'Ras Rmel est une bande de sable sauvage où se rassemblent des colonies de flamants roses entre lagune et mer.',
            'image_prompt' => 'Flock of pink flamingos wading in shallow crystal clear turquoise lagoon waters in Djerba Ras Rmel Tunisia, white sandspit in distance, bright blue sky',
            'fallback_local_image' => 'images/sidi_mahres.png'
        ],
        'quad_sunset_aghir' => [
            'theme' => 'Aventure en Quad entre Dunes et Lagunes Sauvages d\'Aghir',
            'keywords' => ['quad djerba', 'lagune aghir', 'phare ras taguernes', 'sensations coucher soleil', 'pistes djerba'],
            'suggested_services' => ['excursion-quad-djerba', 'transfert-aeroport-djerba'],
            'facts' => 'Circuits guidés longeant les pistes sableuses entre le phare du Nadhour et les rivages préservés d\'Aghir.',
            'image_prompt' => 'Adventure quad riders traversing sandy coastal trail between palm trees and sea dunes in Aghir Djerba Tunisia at golden sunset, warm backlight, dust spray',
            'fallback_local_image' => 'images/service_quad.jpg'
        ],
        'culinary_poissonnade' => [
            'theme' => 'Tradition de la Poissonnade et Criée aux Poissons de Houmt Souk',
            'keywords' => ['criée houmt souk', 'poissonnade traditionnelle', 'riz djerbien épices', 'marché central', 'dorade rouget djerba'],
            'suggested_services' => ['pack-produits-locaux-djerba', 'pass-conciergerie-premium'],
            'facts' => 'À la criée de Houmt Souk, les poissons frais sont vendus aux enchères à la ficelle puis grillés minute dans les gargotes voisines.',
            'image_prompt' => 'Vibrant fish auction market in Houmt Souk Djerba Tunisia, fresh sea bream and red mullet on crushed ice, lively local market ambiance, warm Mediterranean light',
            'fallback_local_image' => 'images/houmt_souk.png'
        ],
        'menzel_unesco' => [
            'theme' => 'L\'Âme Secrète des Menzel & Houchs Blancs Classés UNESCO à Djerba',
            'keywords' => ['menzel fortifié', 'houch djerbien', 'architecture unesco', 'puits traditionnels', 'patrimoine djerba'],
            'suggested_services' => ['pass-conciergerie-premium', 'transfert-aeroport-djerba'],
            'facts' => 'Le Menzel djerbien associe houch familial, coupoles d\'aération thermiques et impluvium de récupération des eaux de pluie.',
            'image_prompt' => 'Traditional authentic Djerbian Menzel courtyard with whitewashed domes, internal patio, blooming jasmine, ancient olive trees, warm afternoon Mediterranean light',
            'fallback_local_image' => 'images/concierge.png'
        ],
        'kitesurf_lagoon' => [
            'theme' => 'Glisse et Kitesurf sur la Lagune Turquoise de Djerba',
            'keywords' => ['kitesurf lagune djerba', 'spot kitesurf tunisie', 'eau peu profonde', 'vent constant', 'glisse nautique'],
            'suggested_services' => ['stage-kitesurf-djerba', 'excursion-jet-ski'],
            'facts' => 'La lagune offre une vaste zone d\'eau plate et peu profonde avec plus de 300 jours de vent par an, idéale pour tous niveaux.',
            'image_prompt' => 'Dynamic kitesurfer catching air above shallow translucent turquoise lagoon in Djerba Tunisia, vibrant kite canopy against deep blue sky, sunlit spray',
            'fallback_local_image' => 'images/service_kitesurf.jpg'
        ],
        'tataouine_ksour' => [
            'theme' => 'Sur les Traces des Ksour et Villages Berbères de Tataouine depuis Djerba',
            'keywords' => ['ksour tataouine', 'chenini village berbère', 'greniers fortifiés', 'star wars décors', 'sud tunisien'],
            'suggested_services' => ['circuit-sahara-2-jours', 'visite-guidee-djerba'],
            'facts' => 'Chenini et Guermassa sont des villages berbères perchés sur des crêtes rocheuses avec leurs ghorfas fortifiées millénaires.',
            'image_prompt' => 'Breathtaking panoramic view of ancient Berber mountain village Chenini near Tataouine, tiered stone dwellings built into cliffside, dramatic desert sun',
            'fallback_local_image' => 'images/service_quad.jpg'
        ],
        'borj_ghazi_mustapha' => [
            'theme' => 'La Forteresse Borj Ghazi Mustapha : Gardienne Historique de Houmt Souk',
            'keywords' => ['borj el kebir', 'borj ghazi mustapha', 'forteresse espagnole', 'histoire djerba', 'dragut corsaire'],
            'suggested_services' => ['visite-guidee-djerba', 'pass-conciergerie-premium'],
            'facts' => 'Fort maritime du XIIIe siècle rénové au XVIe siècle face à la mer, témoin des batailles maritimes entre corsaires et chevaliers.',
            'image_prompt' => 'Majestic medieval stone fortress Borj Ghazi Mustapha overlooking calm deep blue sea in Houmt Souk Djerba Tunisia, ancient ramparts, dramatic sky at dusk',
            'fallback_local_image' => 'images/houmt_souk.png'
        ],
        'sidi_mahrez_beach' => [
            'theme' => 'Plage de Sidi Mahrez : Sable Fin et Eaux Cristallines de la Côte Nord',
            'keywords' => ['plage sidi mahrez', 'sable fin djerba', 'baignade famille', 'activités nautiques', 'eaux calmes'],
            'suggested_services' => ['excursion-jet-ski', 'transfert-aeroport-djerba'],
            'facts' => 'La plus célèbre plage de Djerba, bordée d\'eaux calmes en pente douce et de palmiers longeant le littoral nord-est.',
            'image_prompt' => 'Endless pristine white sandy beach at Sidi Mahrez Djerba Tunisia, crystal clear turquoise calm water, gentle waves, scattered palms under warm summer sun',
            'fallback_local_image' => 'images/sidi_mahres.png'
        ]
    ];

    public function getAngles(): array {
        return $this->angles;
    }

    public function getInternalLinksCatalog(): array {
        return [
            ['url' => 'https://djerbavoyage.tn/services', 'titre' => 'Catalogue des Excursions & Activités à Djerba', 'type' => 'service'],
            ['url' => 'https://djerbavoyage.tn/services#excursion-quad-djerba', 'titre' => 'Excursion en Quad à Djerba', 'type' => 'service'],
            ['url' => 'https://djerbavoyage.tn/services#circuit-sahara-2-jours', 'titre' => 'Circuit Sahara & Ksar Ghilane 2 Jours', 'type' => 'service'],
            ['url' => 'https://djerbavoyage.tn/services#excursion-jet-ski', 'titre' => 'Sortie Jet-Ski & Sensations Nautiques', 'type' => 'service'],
            ['url' => 'https://djerbavoyage.tn/services#visite-guidee-djerba', 'titre' => 'Visite Guidée Historique de Djerba', 'type' => 'service'],
            ['url' => 'https://djerbavoyage.tn/services#transfert-aeroport-djerba', 'titre' => 'Transfert Privé Aéroport Djerba-Zarzis', 'type' => 'service'],
            ['url' => 'https://djerbavoyage.tn/concierge', 'titre' => 'Service de Conciergerie VIP Djerba Voyage', 'type' => 'service'],
            ['url' => 'https://djerbavoyage.tn/destinations/houmt-souk', 'titre' => 'Guide de Houmt Souk', 'type' => 'guide'],
            ['url' => 'https://djerbavoyage.tn/destinations/midoun', 'titre' => 'Guide de Midoun & Djerbahood', 'type' => 'guide'],
            ['url' => 'https://djerbavoyage.tn/destinations/guellala', 'titre' => 'Guide du Village des Potiers de Guellala', 'type' => 'guide'],
            ['url' => 'https://djerbavoyage.tn/destinations/sidi-mahres', 'titre' => 'Guide de la Plage de Sidi Mahrez', 'type' => 'guide'],
            ['url' => 'https://djerbavoyage.tn/contact', 'titre' => 'Assistance & Réservation Djerba Voyage', 'type' => 'contact']
        ];
    }

    public function getContext(array $recentTitles = []): array {
        $weather = $this->fetchLiveWeather();
        $availableAngles = $this->angles;

        if (!empty($recentTitles)) {
            $filtered = [];
            foreach ($this->angles as $key => $angle) {
                $alreadyUsed = false;
                foreach ($recentTitles as $title) {
                    if (stripos($title, $angle['theme']) !== false) {
                        $alreadyUsed = true;
                        break;
                    }
                    foreach ($angle['keywords'] as $kw) {
                        if (stripos($title, $kw) !== false) {
                            $alreadyUsed = true;
                            break;
                        }
                    }
                }
                if (!$alreadyUsed) {
                    $filtered[$key] = $angle;
                }
            }
            if (!empty($filtered)) {
                $availableAngles = $filtered;
            }
        }

        $angleKey = array_rand($availableAngles);
        $angle = $availableAngles[$angleKey];

        return [
            'timestamp' => date('Y-m-d H:i:s'),
            'weather' => $weather,
            'angle' => $angle,
            'catalog_links' => $this->getInternalLinksCatalog(),
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
            // Fallback silencieux
        }

        return [
            'temp_c' => rand(24, 30),
            'wind_speed' => 14,
            'condition' => 'Soleil radieux & Brise marine',
        ];
    }
}
