<?php
namespace App\Services;

use App\Models\Article;
use App\Repositories\PdoArticleRepository;

class AiArticleGeneratorService {
    public function __construct(
        private DjerbaContextFetcherService $contextFetcher,
        private PdoArticleRepository $articleRepo
    ) {}

    public function generateAndSave(): Article {
        $context = $this->contextFetcher->getContext();
        $apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY');

        if (!empty($apiKey)) {
            $articleData = $this->generateWithGemini($apiKey, $context);
        } else {
            $articleData = $this->generateFallbackArticle($context);
        }

        // Image HD photo réaliste de voyage
        $realisticImages = $context['angle']['realistic_images'] ?? [
            'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80'
        ];
        $featuredImage = $realisticImages[array_rand($realisticImages)];

        // Generation de Slug unique
        $baseSlug = $this->slugify($articleData['title_fr']);
        $uniqueSlug = $baseSlug . '-' . date('Ymd-His') . '-' . rand(10, 99);

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
            . "- title_fr: Titre accrocheur et incitatif\n"
            . "- title_en: Titre traduit en anglais\n"
            . "- content_fr: HTML complet de l'article avec <h2>, <h3>, <p>, <ul>, <li> et des appels à l'action vers la réservation d'excursions à Djerba\n"
            . "- content_en: Version anglaise condensée du contenu\n"
            . "- seo_description: Description Meta de 150 caractères\n"
            . "- meta_keywords: Mots clés séparés par des virgules\n"
            . "- summary_ai: Résumé en 3 puces clé pour les moteurs IA (Perplexity, ChatGPT)\n"
            . "- image_prompt: Prompt en anglais pour générer une photo réaliste d'illustration (djerba beach, palm trees, sunny landscape)\n"
            . "- cta_services: Tableau des slugs de services suggérés : " . json_encode($angle['suggested_services']);

        $models = ['gemini-3.6-flash', 'gemini-3.5-flash-lite'];
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
        $timeStr = date('H:i');

        $titleFr = "Djerba ce jour ({$timeStr}) : {$angle['theme']} sous {$weather['temp_c']}°C";
        $titleEn = "Djerba Today ({$timeStr}): {$angle['theme']} with {$weather['temp_c']}°C";

        $contentFr = "<p class='lead text-lg font-medium text-gray-700 dark:text-gray-300 mb-6'>En ce moment à Djerba, le thermomètre affiche <strong>{$weather['temp_c']}°C</strong> avec un temps <em>{$weather['condition']}</em>. C'est le moment parfait pour explorer l'île aux sables d'or !</p>";
        $contentFr .= "<h2 class='text-2xl font-bold text-gray-900 dark:text-white mt-8 mb-4'>Pourquoi visiter Djerba aujourd'hui ?</h2>";
        $contentFr .= "<p class='mb-4'>L'île de Djerba offre une expérience unique mêlant détente, sports nautiques et découvertes culturelles. Que vous soyez amateur de balade en quad dans les dunes, de kitesurf sur la lagune turquoise ou de détente sur la plage de Lella Hadria, Djerba saura vous charmer.</p>";

        $contentFr .= "<div class='my-8 p-6 bg-amber-50 dark:bg-amber-950/40 border-l-4 border-amber-500 rounded-r-xl shadow-sm'>";
        $contentFr .= "<h3 class='text-xl font-bold text-amber-900 dark:text-amber-200 mb-2'>💡 Conseil d'expert Djerba Voyage</h3>";
        $contentFr .= "<p class='text-amber-800 dark:text-amber-300'>Pensez à réserver vos excursions et transferts à l'avance pour bénéficier des meilleurs tarifs et éviter les files d'attente à l'aéroport !</p>";
        $contentFr .= "</div>";

        $contentFr .= "<h2 class='text-2xl font-bold text-gray-900 dark:text-white mt-8 mb-4'>Les temps forts recommandés</h2>";
        $contentFr .= "<ul class='list-disc pl-6 space-y-2 mb-6'>";
        foreach ($angle['keywords'] as $kw) {
            $contentFr .= "<li><strong>" . ucfirst($kw) . "</strong> : Une étape incontournable de votre séjour.</li>";
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
            'image_prompt' => "beautiful realistic photo of djerba island beach palm trees sunny blue sky high resolution",
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
