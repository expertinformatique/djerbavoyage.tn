<?php
namespace App\Services;

use Exception;

/**
 * Service Google Gemini AI — Concierge Virtuel Djerba Voyage
 */
class GoogleAiService
{
    private string $apiKey;
    private string $model;
    private int $timeout;
    private float $temperature;
    private bool $dryRun;

    public function __construct(?array $config = null, bool $dryRun = false)
    {
        $this->apiKey = $config['api_key'] ?? ($_ENV['GEMINI_API_KEY'] ?? (getenv('GEMINI_API_KEY') ?: ''));
        $this->model = $config['model'] ?? 'gemini-2.5-flash';
        $this->timeout = (int)($config['timeout'] ?? 8);
        $this->temperature = (float)($config['temperature'] ?? 0.65);
        $this->dryRun = $dryRun;
    }

    public function generateNaturalReply(string $userMsg, array $history = [], string $lang = 'fr'): ?array
    {
        if ($this->dryRun) {
            return [
                'reply' => "Simulation Gemini: Réponse pour: " . htmlspecialchars($userMsg),
                'action' => 'view_activities',
                'action_label' => "🌴 Découvrir les Activités",
                'detected_need' => 'Excursion & Découverte'
            ];
        }

        if (empty($this->apiKey)) {
            return null;
        }

        try {
            $contents = $this->buildContents($userMsg, $history);
            $systemInstruction = $this->getSystemPrompt($lang);

            $payload = [
                'systemInstruction' => ['parts' => [['text' => $systemInstruction]]],
                'contents' => $contents,
                'generationConfig' => [
                    'temperature' => $this->temperature,
                    'responseMimeType' => 'application/json'
                ]
            ];

            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key=" . urlencode($this->apiKey);
            $raw = $this->executeCurl($url, $payload);
            if (!$raw) return null;

            $json = json_decode($raw, true);
            $responseText = $json['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if (!$responseText) return null;

            $parsed = json_decode($responseText, true);
            if (!is_array($parsed) || empty($parsed['reply'])) return null;

            return [
                'reply' => trim($parsed['reply']),
                'action' => !empty($parsed['action']) ? $parsed['action'] : null,
                'action_label' => !empty($parsed['action_label']) ? $parsed['action_label'] : null,
                'detected_need' => !empty($parsed['detected_need']) ? $parsed['detected_need'] : null,
            ];
        } catch (Exception $e) {
            $this->logError("Gemini generateNaturalReply: " . $e->getMessage());
            return null;
        }
    }

    private function buildContents(string $currentMsg, array $history): array
    {
        $contents = [];
        $trimmedHistory = array_slice($history, -8);

        foreach ($trimmedHistory as $item) {
            $role = ($item['role'] ?? '') === 'assistant' ? 'model' : 'user';
            $text = trim($item['content'] ?? '');
            if ($text === '') continue;

            if (!empty($contents) && end($contents)['role'] === $role) {
                $lastIndex = count($contents) - 1;
                $contents[$lastIndex]['parts'][0]['text'] .= "\n" . $text;
            } else {
                $contents[] = [
                    'role' => $role,
                    'parts' => [['text' => $text]]
                ];
            }
        }

        if (empty($contents) || end($contents)['role'] !== 'user') {
            $contents[] = ['role' => 'user', 'parts' => [['text' => $currentMsg]]];
        } else {
            $lastIndex = count($contents) - 1;
            $contents[$lastIndex]['parts'][0]['text'] .= "\n" . $currentMsg;
        }

        return $contents;
    }

    private function getSystemPrompt(string $lang): string
    {
        return <<<PROMPT
Tu es le Concierge Virtuel et Conseiller Expert Djerba Voyage (Djerba Voyage IA).
Tu accueilles les voyageurs qui préparent leur séjour sur l'île de Djerba en Tunisie.

PÉRIMÈTRE & SERVICES :
- Excursions & activités (quads dans les dunes, bateau pirate vers l'île aux flamants roses, kitesurf lagon, balade dromadaire au coucher de soleil, musée de Guellala, street art Djerbahood).
- Pass Djerba Expérience (remises, pack tout compris, navette aéroport VIP offerte dès 3 activités).
- Hébergements & Hôtels de charme (Dar Dhiafa Erriadh, Radisson Blu, Hasdrubal Prestige, Dar Bibine).
- Transports (navettes privées aéroport Djerba-Zarzis, chauffeurs fiables).
- Gastronomie djerbienne authentique (couscous au poisson, gargoulette, marchés de Houmt Souk).

RÈGLES STRICTES :
1. RÉPONSES TRÈS COURTES (25 à 45 mots, 1 à 2 phrases max) : Chaleureux, précis et inspirant.
2. ACTIONS POSSIBLES DANS LE JSON :
   - "view_activities" (label: "🌴 Découvrir les Excursions")
   - "view_pass" (label: "🎟️ Voir le Pass Djerba Expérience")
   - "view_transports" (label: "🚗 Navettes & Chauffeurs")
   - "open_custom_stay" (label: "✨ Devis Séjour Sur-Mesure")
   - "ask_contact" (label: "📋 Renseigner mes coordonnées")
3. Dès 3 réponses sans email client connu, suggère d'enregistrer ses coordonnées pour recevoir une proposition personnalisée.

Langue de réponse : {$lang}. Format JSON strict :
{
  "reply": "Ta réponse d'expert local (1 à 2 phrases max)",
  "action": "view_activities" | "view_pass" | "view_transports" | "open_custom_stay" | "ask_contact" | null,
  "action_label": "Libellé du bouton" | null,
  "detected_need": "Nom court du besoin"
}
PROMPT;
    }

    private function executeCurl(string $url, array $payload): ?string
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err || $status !== 200) {
            $this->logError("cURL Gemini HTTP {$status}: {$err} | Resp: {$result}");
            return null;
        }

        return $result;
    }

    private function logError(string $msg): void
    {
        $root = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        @error_log('[' . date('Y-m-d H:i:s') . '] [AI_SERVICE] ' . $msg . PHP_EOL, 3, $root . '/error.log');
    }
}
