<?php
namespace App\Services;

use App\Models\Article;
use App\Repositories\PdoArticleRepository;

class AiArticleGeneratorService {
    private AiImageService $imageService;

    public function __construct(
        private DjerbaContextFetcherService $contextFetcher,
        private PdoArticleRepository $articleRepo,
        ?AiImageService $imageService = null
    ) {
        $this->imageService = $imageService ?? new AiImageService();
    }

    public function generateAndSave(): Article {
        $context = $this->contextFetcher->getContext();
        $apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY');

        if (!empty($apiKey)) {
            $articleData = $this->generateWithGemini($apiKey, $context);
        } else {
            $articleData = $this->generateFallbackArticle($context);
        }

        // Nettoyage strict : interdiction de l'heure dans le titre
        $cleanT = fn(string $t, bool $en = false) => ltrim(preg_replace('/\s+/', ' ', trim(preg_replace(
            $en ? '/\s*today\s*(\(\d{1,2}[:h]\d{2}\))?\s*:\s*|\s*\(\d{1,2}[:h]\d{2}\)\s*/i' : '/\s*ce jour\s*(\(\d{1,2}[:h]\d{2}\))?\s*:\s*|\s*\(\d{1,2}[:h]\d{2}\)\s*/i',
            ' : ',
            $t
        ))), ' :');
        $articleData['title_fr'] = $cleanT($articleData['title_fr']);
        if (!empty($articleData['title_en'])) {
            $articleData['title_en'] = $cleanT($articleData['title_en'], true);
        }

        // Generation de Slug unique
        $baseSlug = $this->slugify($articleData['title_fr']);
        $uniqueSlug = $baseSlug . '-' . date('Ymd-His') . '-' . rand(10, 99);

        // Image IA créée spécifiquement pour le sujet de l'article
        $imagePrompt = $articleData['image_prompt'] ?? ($context['angle']['image_prompt'] ?? '');
        $featuredImage = $this->imageService->generateForArticle($imagePrompt, $uniqueSlug, $context);

        $summaryAi = $articleData['summary_ai'] ?? null;
        if (is_array($summaryAi)) {
            $summaryAi = "• " . implode("\n• ", $summaryAi);
        }

        $metaKeywords = $articleData['meta_keywords'] ?? null;
        if (is_array($metaKeywords)) {
            $metaKeywords = implode(', ', $metaKeywords);
        }

        $article = new Article(
            id: null,
            destinationId: 1, // Djerba
            slug: $uniqueSlug,
            titleFr: $articleData['title_fr'],
            titleEn: $articleData['title_en'] ?? null,
            contentFr: $articleData['content_fr'],
            contentEn: $articleData['content_en'] ?? null,
            featuredImage: $featuredImage,
            status: 'published',
            viewsCount: rand(15, 85),
            publishedAt: date('Y-m-d H:i:s'),
            seoDescription: is_array($articleData['seo_description'] ?? null) ? implode(' ', $articleData['seo_description']) : ($articleData['seo_description'] ?? null),
            metaKeywords: $metaKeywords,
            summaryAi: $summaryAi,
            schemaJson: json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => $articleData['title_fr'],
                'description' => is_array($articleData['seo_description'] ?? null) ? implode(' ', $articleData['seo_description']) : ($articleData['seo_description'] ?? ''),
                'image' => $featuredImage,
                'author' => ['@type' => 'Person', 'name' => 'IA Voyageur Djerba'],
                'publisher' => ['@type' => 'Organization', 'name' => 'Djerba Voyage'],
                'datePublished' => date('Y-m-d\TH:i:sP'),
            ], JSON_UNESCAPED_UNICODE),
            pdfEnabled: true,
            pdfPriceEur: 2.99,
            ctaServicesJson: json_encode($articleData['cta_services'] ?? []),
            authorName: 'IA Voyageur Djerba'
        );

        return $this->articleRepo->save($article);
    }

    private function generateWithGemini(string $apiKey, array $context): array {
        $weather = $context['weather'];
        $angle = $context['angle'];

        $prompt = "Tu es un rédacteur web expert en tourisme à Djerba, Tunisie. Écris un article captivant, unique et optimisé SEO/GEO.\n"
            . "Thème: {$angle['theme']}\n"
            . "Météo actuelle à Djerba: {$weather['temp_c']}°C, {$weather['condition']}, vent {$weather['wind_speed']} km/h.\n"
            . "Format de réponse JSON strict avec les clés suivantes :\n"
            . "- title_fr: Titre accrocheur et incitatif (IMPORTANT: ne JAMAIS mentionner d'heure comme '14:30', '(21:55)' ou 'ce jour' dans le titre)\n"
            . "- title_en: Titre traduit en anglais (NEVER include timestamps or hours in title)\n"
            . "- content_fr: HTML complet de l'article avec <h2>, <h3>, <p>, <ul>, <li> et des appels à l'action vers la réservation d'excursions à Djerba\n"
            . "- content_en: Version anglaise condensée du contenu\n"
            . "- seo_description: Description Meta de 150 caractères\n"
            . "- meta_keywords: Mots clés séparés par des virgules\n"
            . "- summary_ai: Résumé en 3 puces clé pour les moteurs IA (Perplexity, ChatGPT)\n"
            . "- image_prompt: Prompt en anglais TRÈS DÉTAILLÉ (30 à 50 mots) pour générer une photographie réaliste 8k qui illustre PRÉCISÉMENT le sujet de cet article (ex: si quad/désert -> quad in Sahara dunes near Djerba at sunset ; si gastronomie -> traditional seafood feast ; si poterie -> pottery workshop in Guellala ; etc.). Ne pas faire de prompt de plage si le sujet est différent. Aucun texte sur l'image.\n"
            . "- cta_services: Tableau des slugs de services suggérés : " . json_encode($angle['suggested_services']);

        $models = ['gemini-3.6-flash', 'gemini-2.5-flash', 'gemini-1.5-flash'];
        foreach ($models as $model) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $apiKey;
            $payload = json_encode([
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => [
                    'response_mime_type' => 'application/json',
                    'temperature' => 0.7
                ]
            ]);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_TIMEOUT, 12);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $resData = json_decode($response, true);
                $text = $resData['candidates'][0]['content']['parts'][0]['text'] ?? '';
                $jsonParsed = json_decode(trim($text), true);
                if (is_array($jsonParsed) && isset($jsonParsed['title_fr'], $jsonParsed['content_fr'])) {
                    return $jsonParsed;
                }
            } else if ($response) {
                $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
                @error_log("[" . date('Y-m-d H:i:s') . "] Gemini API ({$model}) HTTP {$httpCode}: {$response}" . PHP_EOL, 3, $rootPath . '/error.log');
            }
        }

        return $this->generateFallbackArticle($context);
    }

    private function generateFallbackArticle(array $context): array {
        $weather = $context['weather'];
        $angle = $context['angle'];

        $templatesFr = [
            "Djerba : {$angle['theme']} sous {$weather['temp_c']}°C",
            "Guide Djerba : Tout savoir sur {$angle['theme']}",
            "Évasion à Djerba : {$angle['theme']} sous le soleil ({$weather['temp_c']}°C)",
            "Voyager à Djerba : {$angle['theme']} et météo {$weather['condition']}"
        ];
        $templatesEn = [
            "Djerba: {$angle['theme']} under {$weather['temp_c']}°C",
            "Djerba Guide: Explore {$angle['theme']}",
            "Djerba Getaway: {$angle['theme']} with {$weather['temp_c']}°C weather",
            "Djerba Travel: Best tips for {$angle['theme']}"
        ];

        $idx = abs(crc32($angle['theme'] . date('YmdH'))) % count($templatesFr);
        $titleFr = $templatesFr[$idx];
        $titleEn = $templatesEn[$idx];

        $contentFr = "<p class='lead'>En ce moment à Djerba, le thermomètre affiche <strong>{$weather['temp_c']}°C</strong> avec un temps <em>{$weather['condition']}</em>. C'est le moment parfait pour explorer l'île aux sables d'or !</p>";
        $contentFr .= "<h2>Pourquoi visiter Djerba aujourd'hui ?</h2>";
        $contentFr .= "<p>L'île de Djerba offre une expérience unique mêlant détente balnéaire, aventures sahariennes et patrimoine millénaire. Que vous souhaitiez piloter un quad dans les pistes oasiennes, rider en kitesurf sur la lagune turquoise ou vous détendre sur le sable fin de Sidi Mahres, l'île réserve des moments magiques aux voyageurs.</p>";

        $contentFr .= "<div class='c-article-tip'>";
        $contentFr .= "<h3>💡 Conseil d'expert Djerba Voyage</h3>";
        $contentFr .= "<p>Pensez à planifier vos excursions et vos transferts aéroport à l'avance. Cela vous garantit les meilleurs guides certifiés et une prise en charge VIP dès votre atterrissage.</p>";
        $contentFr .= "</div>";

        $contentFr .= "<h2>Les temps forts & suggestions d'itinéraires</h2><ul>";
        foreach ($angle['keywords'] as $kw) {
            $contentFr .= "<li><strong>" . ucfirst($kw) . "</strong> : Une étape incontournable pour vivre pleinement l'expérience djerbienne.</li>";
        }
        $contentFr .= "</ul>";

        return [
            'title_fr' => $titleFr,
            'title_en' => $titleEn,
            'content_fr' => $contentFr,
            'content_en' => "<p>Discover {$angle['theme']} in Djerba today. Current temperature is {$weather['temp_c']}°C.</p>",
            'seo_description' => "Découvrez notre guide actualisé sur {$angle['theme']} à Djerba. Météo : {$weather['temp_c']}°C. Conseils et réservation d'activités.",
            'meta_keywords' => implode(', ', $angle['keywords']),
            'summary_ai' => "• Météo en direct : {$weather['temp_c']}°C à Djerba.\n• Thème vedette : {$angle['theme']}.\n• Réservation directe d'activités et transferts VIP sur Djerba Voyage.",
            'image_prompt' => $angle['image_prompt'] ?? "scenic photography of {$angle['theme']} in Djerba Tunisia, Mediterranean lighting",
            'cta_services' => $angle['suggested_services']
        ];
    }

    private function slugify(string $text): string {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        return empty($text) ? 'article-djerba' : substr($text, 0, 80);
    }
}
