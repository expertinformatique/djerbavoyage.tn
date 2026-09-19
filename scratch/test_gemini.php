<?php
$env = file_get_contents(__DIR__ . '/../.env');
preg_match('/GEMINI_API_KEY=(.+)/', $env, $m);
$key = trim($m[1]);
echo 'KEY: ' . substr($key, 0, 8) . '...' . PHP_EOL;

$url = 'https://generativelanguage.googleapis.com/v1beta/models?key=' . $key;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
curl_close($ch);
$data = json_decode($res, true);
$model = 'gemini-flash-lite-latest';
$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $key;

$prompt = "RÔLE : Tu es le rédacteur en chef de djerbavoyage.tn, guide touristique de référence à Djerba.\n"
    . "MISSION : Rédige un guide de voyage complet, immersif et ultra-qualitatif (1000 à 1400 mots) qualifié de HAUTE QUALITÉ par Google (critères EEAT).\n"
    . "SUJET : Aventure en Quad dans les Dunes et Lagunes Sauvages d'Aghir à Djerba\n"
    . "FAITS RÉELS : Tarifs indicatifs 120 TND (environ 35€) pour 2h, départ depuis Aghir ou Midoun, passage par le phare de Taguernes (le Nadhour), casque et lunettes fournis, accessible dès 16 ans au guidon ou dès 6 ans en passager.\n"
    . "MODE_FACEBOOK : AVEC_LIEN\n"
    . "DIRECTIVES STRICTES :\n"
    . "- ZÉRO CLICHÉ : interdiction absolue de 'perle de la Méditerranée', 'véritable joyau', 'plongez au cœur', 'dans cet article', 'en conclusion'.\n"
    . "- Répondre à l'intention dès les 2 premières phrases.\n"
    . "- 4 à 6 <h2> formulés comme de vraies questions de voyageurs.\n"
    . "- Un tableau <table> récapitulatif des formules, durées et prix indicatifs.\n"
    . "- Encadré <blockquote>💡 <strong>Le conseil de l'équipe Djerba Voyage :</strong> [conseil inédit]</blockquote>\n"
    . "- Section FAQ de 3 vraies questions avec réponses courtes.\n"
    . "- Liens internes vers nos services : <a href=\"https://djerbavoyage.tn/services#excursion-quad-djerba\">Réserver l'excursion quad</a> et <a href=\"https://djerbavoyage.tn/concierge\">Conciergerie Djerba Voyage</a>.\n"
    . "- Bloc CTA conversion à la fin.\n"
    . "- Facebook caption (350 à 450 car.) : Ligne 1 accroche percutante avant 'Voir plus', 2 lignes de valeur, 1 question ouverte.\n"
    . "Format JSON strict : {\"title\": \"...\", \"content_html\": \"...\", \"meta_description\": \"...\", \"excerpt\": \"...\", \"facebook\": \"...\", \"summary_ai\": [\"...\", \"...\"]}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'contents' => [['parts' => [['text' => $prompt]]]],
    'generationConfig' => [
        'response_mime_type' => 'application/json',
        'temperature' => 0.7
    ]
]));
$res = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "CODE: " . $code . PHP_EOL;
$json = json_decode($res, true);
$text = $json['candidates'][0]['content']['parts'][0]['text'] ?? '';
$parsed = json_decode(trim($text), true);
if ($parsed) {
    echo "=== HTML FULL OUTPUT ===" . PHP_EOL;
    echo $parsed['content_html'] . PHP_EOL;
}

echo "CODE: " . $code . PHP_EOL;
$json = json_decode($res, true);
$text = $json['candidates'][0]['content']['parts'][0]['text'] ?? '';
echo "TEXT LENGTH: " . strlen($text) . PHP_EOL;
$parsed = json_decode(trim($text), true);
if ($parsed) {
    echo "TITLE: " . ($parsed['title'] ?? $parsed['title_fr'] ?? 'N/A') . PHP_EOL;
    echo "CONTENT HTML LEN: " . strlen($parsed['content_html'] ?? $parsed['content_fr'] ?? '') . PHP_EOL;
    echo "IMAGE: " . json_encode($parsed['image'] ?? []) . PHP_EOL;
    echo "FACEBOOK: " . json_encode($parsed['facebook'] ?? []) . PHP_EOL;
} else {
    echo "RAW (first 500): " . substr($text, 0, 500) . PHP_EOL;
}
