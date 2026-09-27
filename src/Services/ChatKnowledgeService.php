<?php
namespace App\Services;

/**
 * Service de Connaissance Métier & Fallback IA — Djerba Voyage
 */
class ChatKnowledgeService
{
    private GoogleAiService $googleAi;

    private array $intents = [
        'pass' => ['pass', 'forfait', 'pack', 'formule', 'tout compris', 'economie', 'remise', 'tarifs', 'combien', 'prix'],
        'activities' => ['activite', 'excursion', 'quad', 'kitesurf', 'bateau', 'flamant', 'jet ski', 'dromadaire', 'chameau', 'plongee', 'parapente', 'visite'],
        'hotel' => ['hotel', 'dar', 'menzel', 'hebergement', 'logement', 'chambre', 'dhiafa', 'bibine', 'radisson', 'hasdrubal', 'resort', 'thalasso', 'houch'],
        'transfer' => ['transfert', 'navette', 'aeroport', 'chauffeur', 'taxi', 'vol', 'djerba-zarzis', 'transport', 'arrivee'],
        'culture' => ['djerbahood', 'erriadh', 'guellala', 'poterie', 'synagogue', 'ghriba', 'patrimoine', 'histoire', 'souk', 'houmt souk'],
        'sahara' => ['sahara', 'desert', 'ksar', 'ghilane', 'matmata', 'tataouine', 'troglodyte', 'bivouac', 'dune', 'sud'],
        'gastronomie' => ['restaurant', 'manger', 'plat', 'gastronomie', 'couscous', 'poisson', 'brik', 'fondouk', 'haroun', 'harissa'],
        'meteo' => ['meteo', 'climat', 'temperature', 'soleil', 'pluie', 'saison', 'periode', 'quand partir'],
        'custom' => ['sur mesure', 'devis', 'sejour', 'famille', 'groupe', 'concierge', 'conseil', 'programme']
    ];

    public function __construct(?GoogleAiService $googleAi = null)
    {
        $this->googleAi = $googleAi ?? new GoogleAiService();
    }

    public function analyzeIntent(string $message): array
    {
        $normalized = mb_strtolower(trim($message), 'UTF-8');
        $detectedCategory = 'general';
        $bestScore = 0;

        foreach ($this->intents as $cat => $keywords) {
            $score = 0;
            foreach ($keywords as $kw) {
                if (str_contains($normalized, $kw)) $score++;
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $detectedCategory = $cat;
            }
        }

        return [
            'category' => $detectedCategory,
            'need_label' => $this->getNeedLabel($detectedCategory),
        ];
    }

    public function generateReply(string $message, array $history = [], string $lang = 'fr'): array
    {
        $aiReply = $this->googleAi->generateNaturalReply($message, $history, $lang);
        if ($aiReply !== null && !empty($aiReply['reply'])) {
            return [
                'text' => $aiReply['reply'],
                'action' => $aiReply['action'] ?? null,
                'action_label' => $aiReply['action_label'] ?? null,
                'detected_need' => $aiReply['detected_need'] ?? $this->analyzeIntent($message)['need_label']
            ];
        }

        return $this->generateFallbackReply($message, $history, $lang);
    }

    public function generateFallbackReply(string $message, array $history = [], string $lang = 'fr'): array
    {
        $intent = $this->analyzeIntent($message);
        $cat = $intent['category'];
        $response = $this->buildDomainResponse($cat, $lang);
        $response['detected_need'] = $intent['need_label'];

        $assistantCount = 0;
        foreach ($history as $h) {
            if (($h['role'] ?? '') === 'assistant' || ($h['role'] ?? '') === 'model') $assistantCount++;
        }

        if ($assistantCount >= 2) {
            $response['action'] = 'ask_contact';
            $response['action_label'] = match($lang) {
                'ar' => "📋 تسجيل بياناتي للحجز",
                'en' => "📋 Provide My Contact Details",
                default => "📋 Renseigner mes coordonnées"
            };
            $response['text'] .= match($lang) {
                'ar' => " لتزويدك ببرنامج مخصص وعروض حصرية، هل يمكنك تزويدنا باسمك وبريدك الإلكتروني ؟",
                'en' => " To prepare your tailor-made itinerary, could you provide your Name and Email?",
                default => " Pour vous adresser un itinéraire personnalisé et nos remises, pourriez-vous m'indiquer votre Nom et Email ?"
            };
        }

        return $response;
    }

    public function buildSummary(array $messages, string $detectedNeed): string
    {
        $count = count($messages);
        $topics = [];
        foreach ($messages as $m) {
            if (($m['role'] ?? '') === 'user') {
                $topics[] = mb_substr(trim($m['content'] ?? ''), 0, 80);
            }
        }
        $points = implode(' | ', array_slice($topics, 0, 3));
        return "Besoin : {$detectedNeed}. {$count} messages. Sujets : {$points}.";
    }

    private function getNeedLabel(string $category): string
    {
        return match ($category) {
            'pass' => 'Pass Djerba Expérience & Forfaits',
            'activities' => 'Réservation Excursions & Quads',
            'hotel' => 'Hôtels & Demeures de Charme',
            'transfer' => 'Navette Aéroport & Chauffeur VIP',
            'culture' => 'Patrimoine Djerbahood & Guellala',
            'sahara' => 'Excursion Sud Tunisien & Ksar Ghilane',
            'gastronomie' => 'Gastronomie & Bonnes Tables',
            'meteo' => 'Conseil Météo & Période Idéale',
            'custom' => 'Séjour Sur-Mesure & Conciergerie',
            default => 'Information Voyage Djerba'
        };
    }

    private function buildDomainResponse(string $cat, string $lang): array
    {
        if ($lang === 'en') {
            return $this->buildDomainResponseEn($cat);
        }
        if ($lang === 'ar') {
            return $this->buildDomainResponseAr($cat);
        }
        return $this->buildDomainResponseFr($cat);
    }

    private function buildDomainResponseFr(string $cat): array
    {
        return match ($cat) {
            'pass' => [
                'text' => "Le Pass Djerba Expérience vous donne accès à 3 activités majeures avec remises exclusives et la navette aéroport offerte !",
                'action' => 'view_pass',
                'action_label' => "🎟️ Découvrir le Pass Djerba"
            ],
            'transfer' => [
                'text' => "Nos navettes privées aéroport Djerba-Zarzis vous garantissent un accueil ponctuel avec chauffeur dédié directement à votre terminal.",
                'action' => 'view_transports',
                'action_label' => "🚗 Voir Navettes & Tarifs"
            ],
            'hotel' => [
                'text' => "De la maison d'hôtes d'art (Dar Dhiafa, Dar Bibine) aux resorts thalasso 5★ en bord de mer, nous vous orientons vers les meilleures adresses.",
                'action' => 'view_hotels',
                'action_label' => "🏨 Voir Hôtels Recommandés"
            ],
            'activities' => [
                'text' => "Découvrez nos sorties phares : balade en quad dans les dunes, bateau pirate vers l'île aux flamants roses et session de kitesurf dans le lagon.",
                'action' => 'view_activities',
                'action_label' => "🌴 Voir Toutes les Excursions"
            ],
            default => [
                'text' => "Bienvenue chez Djerba Voyage ! Je suis votre Concierge Virtuel pour organiser excursions, navettes aéroport et séjours d'exception sur l'île.",
                'action' => 'view_activities',
                'action_label' => "🌴 Découvrir les Excursions"
            ]
        };
    }

    private function buildDomainResponseEn(string $cat): array
    {
        return match ($cat) {
            'pass' => [
                'text' => "The Djerba Experience Pass gives you 3 top excursions with exclusive discounts plus free private airport transfer!",
                'action' => 'view_pass',
                'action_label' => "🎟️ View Djerba Pass"
            ],
            'transfer' => [
                'text' => "Our private airport shuttles ensure a VIP welcoming at Djerba-Zarzis airport with dedicated driver straight to your hotel.",
                'action' => 'view_transports',
                'action_label' => "🚗 View Airport Shuttles"
            ],
            default => [
                'text' => "Welcome to Djerba Voyage! I am your AI Concierge ready to help you plan top excursions, quad tours, and private transfers.",
                'action' => 'view_activities',
                'action_label' => "🌴 Explore Activities"
            ]
        };
    }

    private function buildDomainResponseAr(string $cat): array
    {
        return match ($cat) {
            'pass' => [
                'text' => "تمنحك باقة تجربة جربة أفضل 3 أنشطة بأسعار مميزة مع نقل مجاني من وإلى مطار جربة جرجيس الدولي !",
                'action' => 'view_pass',
                'action_label' => "🎟️ استكشف باقة جربة"
            ],
            'transfer' => [
                'text' => "نوفر خدمات نقل خاصة من وإلى مطار جربة جرجيس مع سائقين محترفين وسيارة مكيفة حتى باب فندقك.",
                'action' => 'view_transports',
                'action_label' => "🚗 خدمات النقل والمطار"
            ],
            default => [
                'text' => "مرحباً بكم في جربة فواياج ! أنا مرشدكم الذكي لمساعدتكم في حجز أفضل الرحلات والأنشطة في جزيرة جربة.",
                'action' => 'view_activities',
                'action_label' => "🌴 استكشف الأنشطة"
            ]
        };
    }
}
