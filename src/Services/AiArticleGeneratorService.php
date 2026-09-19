<?php
namespace App\Services;

use App\Models\Article;
use App\Repositories\PdoArticleRepository;

class AiArticleGeneratorService {
    private ?FacebookReelPublisherService $reelPublisher = null;
    private ?ReelVideoProviderService $reelVideoProvider = null;
    private ?array $lastReelResult = null;
    private ?array $lastTikTokResult = null;

    public function __construct(
        private DjerbaContextFetcherService $contextFetcher,
        private PdoArticleRepository $articleRepo,
        ?AiImageService $imageService = null,
        private ?SitemapService $sitemapService = null,
        private ?FacebookPublisherService $facebookPublisher = null,
        ?FacebookReelPublisherService $reelPublisher = null,
        ?ReelVideoProviderService $reelVideoProvider = null,
        private ?TikTokPublisherService $tiktokPublisher = null
    ) {
        $this->imageService = $imageService ?? new AiImageService();
        $this->reelPublisher = $reelPublisher;
        $this->reelVideoProvider = $reelVideoProvider ?? new ReelVideoProviderService();
    }


    public function generateAndSave(): Article {
        $recentArticles = $this->articleRepo->getAllPublished(15);
        $existingTitles = array_map(fn($a) => $a->titleFr, $recentArticles);
        $context = $this->contextFetcher->getContext($existingTitles);
        $context['existing_titles'] = $existingTitles;
        $context['guide_links'] = array_map(fn($a) => [
            'url'   => 'https://djerbavoyage.tn/guide/' . $a->slug,
            'titre' => $a->titleFr
        ], array_slice($recentArticles, 0, 4));

        // Règle Facebook : 1 publication sur 3 sans lien externe pour booster le reach
        $totalCount = $this->articleRepo->countPublished();
        $facebookMode = (($totalCount + 1) % 3 === 0) ? 'SANS_LIEN' : 'AVEC_LIEN';
        $context['facebook_mode'] = $facebookMode;


        $apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY');
        if (!empty($apiKey)) {
            $articleData = $this->generateWithGemini($apiKey, $context);
        } else {
            $articleData = (new DjerbaStoryFallbackService())->generate($context);
        }

        $articleData['title_fr'] = $this->cleanTitle($articleData['title_fr']);
        if (!empty($articleData['title_en'])) {
            $articleData['title_en'] = $this->cleanTitle($articleData['title_en'], true);
        }

        $baseSlug = $this->slugify($articleData['title_fr']);
        $uniqueSlug = $baseSlug . '-' . date('Ymd-His') . '-' . rand(10, 99);
        $imagePrompt = $articleData['image_prompt'] ?? ($context['angle']['image_prompt'] ?? '');
        $featuredImage = $this->imageService->generateForArticle($imagePrompt, $uniqueSlug, $context);

        $summaryAi = is_array($articleData['summary_ai'] ?? null)
            ? "• " . implode("\n• ", $articleData['summary_ai'])
            : ($articleData['summary_ai'] ?? null);
        $metaKeywords = is_array($articleData['meta_keywords'] ?? null)
            ? implode(', ', $articleData['meta_keywords'])
            : ($articleData['meta_keywords'] ?? null);
        $seoDesc = is_array($articleData['seo_description'] ?? null)
            ? implode(' ', $articleData['seo_description'])
            : ($articleData['seo_description'] ?? null);

        $themeKey = $this->reelVideoProvider->resolveThemeKey($articleData['title_fr']);
        $videoRel = 'assets/videos/reels/' . $themeKey . '.mp4';
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        $videoPath = $rootPath . '/public/' . $videoRel;
        $videoUrl = (file_exists($videoPath) && filesize($videoPath) > 10000) ? $videoRel : null;

        $schemaData = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $articleData['title_fr'],
            'description' => $seoDesc ?? '',
            'image' => $featuredImage,
            'author' => ['@type' => 'Organization', 'name' => 'Rédaction Djerba Voyage'],
            'publisher' => ['@type' => 'Organization', 'name' => 'Djerba Voyage'],
            'datePublished' => date('Y-m-d\TH:i:sP'),
        ];
        if ($videoUrl) {
            $absVideo = 'https://djerbavoyage.tn/' . ltrim($videoUrl, '/');
            $absImg = str_starts_with($featuredImage, 'http') ? $featuredImage : 'https://djerbavoyage.tn/' . ltrim($featuredImage, '/');
            $schemaData['video'] = [
                '@type' => 'VideoObject',
                'name' => $articleData['title_fr'] . ' - Djerba Reel',
                'description' => $seoDesc ?? 'Immersion vidéo et découverte à Djerba',
                'thumbnailUrl' => $absImg,
                'uploadDate' => date('Y-m-d\TH:i:sP'),
                'contentUrl' => $absVideo,
                'duration' => 'PT19S',
                'embedUrl' => 'https://djerbavoyage.tn/guide/' . $uniqueSlug
            ];
        }

        $article = new Article(
            id: null,
            destinationId: 1,
            slug: $uniqueSlug,
            titleFr: $articleData['title_fr'],
            titleEn: $articleData['title_en'] ?? null,
            contentFr: $articleData['content_fr'],
            contentEn: $articleData['content_en'] ?? null,
            featuredImage: $featuredImage,
            status: 'published',
            viewsCount: rand(25, 110),
            publishedAt: date('Y-m-d H:i:s'),
            seoDescription: $seoDesc,
            metaKeywords: $metaKeywords,
            summaryAi: $summaryAi,
            schemaJson: json_encode($schemaData, JSON_UNESCAPED_UNICODE),
            pdfEnabled: true,
            pdfPriceEur: 2.99,
            ctaServicesJson: json_encode($articleData['cta_services'] ?? []),
            authorName: 'Rédaction Djerba Voyage',
            videoUrl: $videoUrl
        );

        $saved = $this->articleRepo->save($article);
        $this->sitemapService?->regenerateFile();

        if ($this->facebookPublisher !== null) {
            $customCaption = $articleData['facebook_text'] ?? null;
            $this->lastFacebookResult = $this->facebookPublisher->publishArticle($saved, $customCaption, $facebookMode);
        }

        // Publication d'un Reel tous les 3 cycles pour dynamiser le format vidéo (ou forcé via ?force_reel=1)
        $forceReel = isset($_GET['force_reel']) && $_GET['force_reel'] === '1';
        if ($this->reelPublisher !== null && (($totalCount + 1) % 3 === 0 || $forceReel)) {
            $videoPath = $this->reelVideoProvider->getVideoPathForTheme($articleData['title_fr']);
            if ($videoPath && file_exists($videoPath)) {
                $reelCaption = "🌴 " . $articleData['title_fr'] . " !\n\n"
                    . ($articleData['seo_description'] ?? '') . "\n\n"
                    . "#Djerba #Reels #Tunisie #Voyage #PhotoDjerba";
                $this->lastReelResult = $this->reelPublisher->publishReel($videoPath, $reelCaption);

                if ($this->tiktokPublisher !== null && $this->tiktokPublisher->isEnabled()) {
                    $tikTokCaption = $this->tiktokPublisher->buildCaption($articleData['title_fr']);
                    $this->lastTikTokResult = $this->tiktokPublisher->publishVideo($videoPath, $tikTokCaption);
                }
            }
        }

        return $saved;
    }

    public function getLastFacebookResult(): ?array {
        return $this->lastFacebookResult;
    }

    public function getLastReelResult(): ?array {
        return $this->lastReelResult;
    }

    public function getLastTikTokResult(): ?array {
        return $this->lastTikTokResult;
    }


    private function generateWithGemini(string $apiKey, array $context): array {
        $prompt = $this->buildPrompt($context);
        $models = ['gemini-flash-lite-latest', 'gemini-3.5-flash-lite', 'gemini-2.5-flash', 'gemini-1.5-flash'];

        foreach ($models as $model) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $apiKey;
            $payload = json_encode([
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => [
                    'response_mime_type' => 'application/json',
                    'temperature' => 0.7,
                    'maxOutputTokens' => 4096
                ]
            ]);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $resData = json_decode($response, true);
                $text = $resData['candidates'][0]['content']['parts'][0]['text'] ?? '';
                $json = json_decode(trim($text), true);
                if (is_array($json) && isset($json['title_fr'], $json['content_fr'])) {
                    return $json;
                }
            }
        }

        return (new DjerbaStoryFallbackService())->generate($context);
    }

    private function buildPrompt(array $context): string {
        $weather = $context['weather'];
        $angle = $context['angle'];
        $fbMode = $context['facebook_mode'] ?? 'AVEC_LIEN';
        $existing = !empty($context['existing_titles']) ? implode("\n- ", $context['existing_titles']) : 'Aucun';
        $servicesCatalog = json_encode($context['catalog_links'] ?? [], JSON_UNESCAPED_UNICODE);
        $guideCatalog = json_encode($context['guide_links'] ?? [], JSON_UNESCAPED_UNICODE);

        return "RÔLE : Rédacteur en chef expert pour djerbavoyage.tn (guide et conciergerie à Djerba).\n"
            . "OBJECTIF GOOGLE : Article de référence qualifié de HAUTE QUALITÉ (critères Google EEAT & Helpful Content), 1000 à 1400 mots.\n"
            . "THÈME : {$angle['theme']}\n"
            . "FAITS VÉRIFIÉS : {$angle['facts']}\n"
            . "MÉTÉO ACTUELLE : {$weather['temp_c']}°C, {$weather['condition']}.\n"
            . "MODE FACEBOOK : {$fbMode}\n"
            . "SERVICES DU SITE (À MAILLER & RECOMMANDER) : {$servicesCatalog}\n"
            . "AUTRES GUIDES DU SITE (À MAILLER) : {$guideCatalog}\n"
            . "CONSIGNES ÉDITORIALES :\n"
            . "1. Accroche directe répondant à l'intention du voyageur dès le premier paragraphe.\n"
            . "2. 4 à 6 <h2> formulés comme des questions concrètes de voyageurs.\n"
            . "3. Un tableau <table> comparatif avec colonnes : Activité/Spot, Durée conseillée, Prix indicatif (TND/EUR), Pour qui.\n"
            . "4. Un encadré '<blockquote>💡 <strong>Le conseil de terrain Djerba Voyage :</strong> [astuce exclusive locale]</blockquote>'.\n"
            . "5. Une FAQ finale de 3 questions avec réponses directes de 2-3 phrases.\n"
            . "6. MAILLAGE & CONVERSION : Insère 2 liens vers d'autres guides et 2 liens vers nos services (/services#...) avec des CTA convaincants pour réserver sur le site.\n"
            . "7. Zéro cliché : interdiction de 'perle de la Méditerranée', 'véritable joyau', 'plongez au cœur', 'dans cet article', 'en conclusion'.\n"
            . "8. Facebook : texte de 350-450 car. Si SANS_LIEN, AUCUNE mention d'URL ni de lien. Si AVEC_LIEN, teaser percutant sans URL (le système l'ajoute).\n"
            . "Format JSON strict :\n"
            . "{\n"
            . '  "title_fr": "Titre engageant avec \'Djerba\'",' . "\n"
            . '  "title_en": "Direct engaging English title with \'Djerba\'",' . "\n"
            . '  "content_fr": "HTML riche (h2, h3, p, table, blockquote, ul, li, a)",' . "\n"
            . '  "content_en": "Summary in English (100 words)",' . "\n"
            . '  "seo_description": "Meta description (140-155 car.)",' . "\n"
            . '  "meta_keywords": "6-8 mots-clés séparés par des virgules",' . "\n"
            . '  "summary_ai": ["Point clé 1", "Point clé 2", "Point clé 3"],' . "\n"
            . '  "image_prompt": "English 40-50 words realistic photography prompt, no text, no watermark",' . "\n"
            . '  "facebook_text": "Texte Facebook optimisé (accroche, valeur, question, hashtags)",' . "\n"
            . '  "cta_services": ' . json_encode($angle['suggested_services'] ?? []) . "\n"
            . "}";
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
