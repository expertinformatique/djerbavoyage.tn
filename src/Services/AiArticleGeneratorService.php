<?php
namespace App\Services;

use App\Models\Article;
use App\Repositories\PdoArticleRepository;

class AiArticleGeneratorService {
    private AiImageService $imageService;
    private ?array $lastFacebookResult = null;

    public function __construct(
        private DjerbaContextFetcherService $contextFetcher,
        private PdoArticleRepository $articleRepo,
        ?AiImageService $imageService = null,
        private ?SitemapService $sitemapService = null,
        private ?FacebookPublisherService $facebookPublisher = null
    ) {
        $this->imageService = $imageService ?? new AiImageService();
    }

    public function generateAndSave(): Article {
        $context = $this->contextFetcher->getContext();
        $apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY');

        if (!empty($apiKey)) {
            $articleData = $this->generateWithGemini($apiKey, $context);
        } else {
            $articleData = (new DjerbaStoryFallbackService())->generate($context);
        }

        // Nettoyage strict : titre épuré avec mot-clé Djerba, sans préfixe "ce jour" ni heure
        $articleData['title_fr'] = $this->cleanTitle($articleData['title_fr']);
        if (!empty($articleData['title_en'])) {
            $articleData['title_en'] = $this->cleanTitle($articleData['title_en'], true);
        }

        // Generation de Slug unique
        $baseSlug = $this->slugify($articleData['title_fr']);
        $uniqueSlug = $baseSlug . '-' . date('Ymd-His') . '-' . rand(10, 99);

        // Image IA créée spécifiquement pour le sujet de l'article
        $imagePrompt = $articleData['image_prompt'] ?? ($context['angle']['image_prompt'] ?? '');
        $featuredImage = $this->imageService->generateForArticle($imagePrompt, $uniqueSlug, $context);

        $summaryAi = is_array($articleData['summary_ai'] ?? null) ? "• " . implode("\n• ", $articleData['summary_ai']) : ($articleData['summary_ai'] ?? null);
        $metaKeywords = is_array($articleData['meta_keywords'] ?? null) ? implode(', ', $articleData['meta_keywords']) : ($articleData['meta_keywords'] ?? null);
        $seoDesc = is_array($articleData['seo_description'] ?? null) ? implode(' ', $articleData['seo_description']) : ($articleData['seo_description'] ?? null);

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
            seoDescription: $seoDesc,
            metaKeywords: $metaKeywords,
            summaryAi: $summaryAi,
            schemaJson: json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => $articleData['title_fr'],
                'description' => $seoDesc ?? '',
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

        $saved = $this->articleRepo->save($article);
        $this->sitemapService?->regenerateFile();

        if ($this->facebookPublisher !== null) {
            $this->lastFacebookResult = $this->facebookPublisher->publishArticle($saved);
        }

        return $saved;
    }

    public function getLastFacebookResult(): ?array {
        return $this->lastFacebookResult;
    }

    private function generateWithGemini(string $apiKey, array $context): array {
        $weather = $context['weather'];
        $angle = $context['angle'];

        $prompt = "Tu es un écrivain voyageur et conteur passionné, expert des légendes, de l'histoire et des traditions de l'île de Djerba en Tunisie.\n"
            . "Sujet de l'article : {$angle['theme']}\n"
            . "Ambiance & Météo actuelle : {$weather['temp_c']}°C, {$weather['condition']}.\n"
            . "MISSION CRITIQUE :\n"
            . "Écris un véritable RÉCIT D'AVENTURE ET D'HISTOIRE, immersif et captivant. Plonge le lecteur au cœur des traditions de Djerba, de son histoire millénaire et de ses légendes (les Lotophages d'Homère, les potiers berbères troglodytes, les marins d'Ajim, les caravanes sahariennes, les Menzel fortifiés, etc.).\n"
            . "Le texte ne doit pas être une banale liste publicitaire, mais une histoire vivante, sensorielle et pleine d'authenticité.\n"
            . "Format de réponse JSON strict avec les clés suivantes :\n"
            . "- title_fr: Titre direct et percutant avec le mot-clé 'Djerba' (Exemple: 'Secrets Millénaires des Potiers de Guellala à Djerba'). RÈGLE STRICTE: Ne JAMAIS mettre de préfixe comme 'Djerba :', 'Djerba ce jour :', 'Évasion à Djerba :' ni aucune heure ou horodatage.\n"
            . "- title_en: Direct engaging English title with keyword 'Djerba'. NEVER include prefixes or timestamps.\n"
            . "- content_fr: HTML complet et soigné avec <h2>, <h3>, <p>, <blockquote> (pour des citations ou anecdotes de vieux sages/marins), <ul>, <li> et des recommandations de voyage authentiques vers nos services\n"
            . "- content_en: Version anglaise condensée du récit d'aventure\n"
            . "- seo_description: Description Meta évocatrice de 150 caractères résumant l'aventure et l'histoire\n"
            . "- meta_keywords: Mots clés séparés par des virgules\n"
            . "- summary_ai: Résumé en 3 points clés pour moteurs IA (Perplexity, ChatGPT)\n"
            . "- image_prompt: Prompt en anglais TRÈS DÉTAILLÉ (35 à 50 mots) pour générer une photographie réaliste 8k qui illustre PRÉCISÉMENT la scène historique, traditionnelle ou d'aventure racontée (ex: mains de potier façonnant l'argile à Guellala, barques de pêcheurs d'éponges au port d'Ajim, quad au crépuscule sur les dunes, etc.). Aucun texte sur l'image.\n"
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

        return (new DjerbaStoryFallbackService())->generate($context);
    }

    public function cleanTitle(string $title, bool $isEn = false): string {
        $title = preg_replace('/\s*\(\s*\d{1,2}[:h]\d{2}\s*\)\s*/iu', ' ', $title);
        $title = preg_replace('/\b\d{1,2}[:h]\d{2}\b/iu', '', $title);
        $title = preg_replace('/^(\s*djerba\s+)?(ce\s+jour|aujourd\'hui|today)\s*:\s*/iu', '', $title);
        $title = preg_replace('/^(djerba|évasion\s+à\s+djerba|voyager\s+à\s+djerba|guide\s+djerba|djerba\s+guide|djerba\s+getaway|djerba\s+travel)\s*:\s*/iu', '', $title);
        $title = trim(preg_replace('/^[\s:\-]+|[\s:\-]+$/u', '', $title));
        if (!empty($title) && !preg_match('/djerba|djerbien/iu', $title)) {
            $title .= $isEn ? ' in Djerba' : ' à Djerba';
        }
        return preg_replace('/\s{2,}/', ' ', $title);
    }

    private function slugify(string $text): string {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        return empty($text) ? 'article-djerba' : substr($text, 0, 80);
    }
}
