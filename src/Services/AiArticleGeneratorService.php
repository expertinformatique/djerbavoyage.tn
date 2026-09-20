<?php
namespace App\Services;

use App\Models\Article;
use App\Repositories\PdoArticleRepository;

class AiArticleGeneratorService {
    private ?FacebookReelPublisherService $reelPublisher = null;
    private ?FacebookStoryPublisherService $storyPublisher = null;
    private ?ReelVideoProviderService $reelVideoProvider = null;
    private ?ContentQueueService $queueService = null;
    private ?TextImageBannerService $bannerService = null;
    private ?array $lastReelResult = null;
    private ?array $lastTikTokResult = null;
    private ?array $lastStoryResult = null;

    public function __construct(
        private DjerbaContextFetcherService $contextFetcher,
        private PdoArticleRepository $articleRepo,
        ?AiImageService $imageService = null,
        private ?SitemapService $sitemapService = null,
        private ?FacebookPublisherService $facebookPublisher = null,
        ?FacebookReelPublisherService $reelPublisher = null,
        ?ReelVideoProviderService $reelVideoProvider = null,
        private ?TikTokPublisherService $tiktokPublisher = null,
        ?FacebookStoryPublisherService $storyPublisher = null,
        ?ContentQueueService $queueService = null,
        ?TextImageBannerService $bannerService = null
    ) {
        $this->imageService = $imageService ?? new AiImageService();
        $this->reelPublisher = $reelPublisher;
        $this->storyPublisher = $storyPublisher;
        $this->reelVideoProvider = $reelVideoProvider ?? new ReelVideoProviderService();
        $this->queueService = $queueService;
        $this->bannerService = $bannerService ?? new TextImageBannerService();
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

        $botId = $_GET['bot_id'] ?? $_POST['bot_id'] ?? null;
        $botCategories = $_GET['categories'] ?? $_POST['categories'] ?? null;
        $queuedTopic = $this->queueService?->getNextAvailableTopic($botId, $botCategories);
        if ($queuedTopic !== null) {
            $context['angle'] = [
                'theme' => $queuedTopic['title'],
                'keywords' => !empty($queuedTopic['keywords']) ? array_map('trim', explode(',', $queuedTopic['keywords'])) : ['djerba', 'guide'],
                'facts' => !empty($queuedTopic['guidelines']) ? $queuedTopic['guidelines'] : 'Informations authentiques et conseils pratiques de Djerba.',
                'image_prompt' => 'High quality photorealistic photography of ' . $queuedTopic['title'] . ' Djerba Tunisia, natural Mediterranean light',
                'fallback_local_image' => 'images/service_kitesurf.jpg'
            ];
        }

        $queuedImage = $this->queueService?->getNextAvailableImage($botId, $botCategories);


        // Règle Facebook : 1 publication sur 3 sans lien externe pour booster le reach
        $totalCount = $this->articleRepo->countPublished();
        $facebookMode = (($totalCount + 1) % 3 === 0) ? 'SANS_LIEN' : 'AVEC_LIEN';
        $context['facebook_mode'] = $facebookMode;


        $requestedTextAgent = $_GET['text_agent'] ?? $_POST['text_agent'] ?? 'gemini-2.5-flash';
        $articleData = null;

        // 1. Si un agent gratuit Pollinations est sélectionné (aucun jeton requis)
        if (str_starts_with($requestedTextAgent, 'pollinations-')) {
            $articleData = $this->generateWithPollinations($requestedTextAgent, $context);
        }

        // 2. Si un agent Groq est sélectionné
        if ($articleData === null && str_starts_with($requestedTextAgent, 'groq-')) {
            $articleData = $this->generateWithGroq($requestedTextAgent, $context);
        }

        // 3. Modèles Google Gemini & Gemma
        $apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY');
        if ($articleData === null && !empty($apiKey)) {
            $articleData = $this->generateWithGemini($apiKey, $context, $requestedTextAgent);
        }

        // 4. Cascade de secours gratuite : Pollinations OpenAI (100% gratuit sans clé)
        if ($articleData === null) {
            $articleData = $this->generateWithPollinations('pollinations-openai', $context);
        }

        // 5. Secours hors-ligne ultime
        if ($articleData === null) {
            $articleData = (new DjerbaStoryFallbackService())->generate($context);
        }

        $articleData['title_fr'] = $this->cleanTitle($articleData['title_fr'] ?? '', 'fr');
        if (!empty($articleData['title_en'])) {
            $articleData['title_en'] = $this->cleanTitle($articleData['title_en'], 'en');
        }
        if (!empty($articleData['title_ar'])) {
            $articleData['title_ar'] = $this->cleanTitle($articleData['title_ar'], 'ar');
        }

        $baseSlug = $this->slugify($articleData['title_fr']);
        $uniqueSlug = $baseSlug . '-' . date('Ymd-His') . '-' . rand(10, 99);
        $imagePrompt = $articleData['image_prompt'] ?? ($context['angle']['image_prompt'] ?? '');
        $usedImages = $this->articleRepo->getAllUsedFeaturedImages();
        $context['used_images'] = $usedImages;

        if ($queuedImage !== null && ($queuedImage['style'] ?? '') === 'text_card' && $this->bannerService !== null) {
            $featuredImage = $this->bannerService->generateBanner($articleData['title_fr'], $context['angle']['theme'] ?? 'Djerba Voyage');
        } elseif ($queuedImage !== null && !empty($queuedImage['image_url'])) {
            $featuredImage = $queuedImage['image_url'];
        } else {
            $featuredImage = $this->imageService->generateForArticle($imagePrompt, $uniqueSlug, $context);

            // Règle d'or : Aucune réutilisation d'image autorisée
            $attempts = 0;
            while (in_array($featuredImage, $usedImages, true) && $attempts < 3) {
                $attempts++;
                $retrySlug = $uniqueSlug . '-alt-' . mt_rand(100, 999);
                $altPrompt = $imagePrompt . " (vue unique Djerba #" . mt_rand(1000, 9999) . ")";
                $retryImage = $this->imageService->generateForArticle($altPrompt, $retrySlug, $context);
                if (!empty($retryImage) && !in_array($retryImage, $usedImages, true)) {
                    $featuredImage = $retryImage;
                    break;
                }
            }
        }

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
            titleAr: $articleData['title_ar'] ?? null,
            contentFr: $articleData['content_fr'],
            contentEn: $articleData['content_en'] ?? null,
            contentAr: $articleData['content_ar'] ?? null,
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

        // Publication d'une Story (9:16) si activée ou demandée
        $forceStory = isset($_GET['story']) || isset($_GET['force_story']) || isset($_GET['fb_story']);
        if ($this->storyPublisher !== null && ($forceStory || ($totalCount % 2 === 0))) {
            $storyVideoPath = $this->reelVideoProvider->getVideoPathForTheme($articleData['title_fr']);
            $storyText = "🌴 " . $articleData['title_fr'] . " ✨ #Djerba #Story";
            $this->lastStoryResult = $this->storyPublisher->publishStory($saved, $storyVideoPath, $storyText);
        }

        if ($queuedTopic !== null && $this->queueService !== null) {
            $this->queueService->incrementTopicUsage($queuedTopic['id']);
        }
        if ($queuedImage !== null && $this->queueService !== null) {
            $this->queueService->incrementImageUsage($queuedImage['id']);
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

    public function getLastStoryResult(): ?array {
        return $this->lastStoryResult;
    }


    private function generateWithGemini(string $apiKey, array $context, string $preferredModel = 'gemini-2.5-flash'): ?array {
        $prompt = $this->buildPrompt($context);
        
        $allGoogleModels = [
            'gemini-2.5-flash',
            'gemini-2.5-pro',
            'gemini-2.0-flash',
            'gemini-2.0-flash-lite',
            'gemini-2.0-pro-exp-02-05',
            'gemini-1.5-flash',
            'gemini-1.5-flash-8b',
            'gemini-1.5-pro',
            'gemma-2-27b',
            'gemma-2-9b',
            'learnlm-1.5-pro-experimental',
            'nano-banana-pro-preview',
            'gemini-flash-lite-latest',
            'gemini-3.5-flash-lite'
        ];

        $modelsToTry = array_unique(array_merge([$preferredModel], $allGoogleModels));

        foreach ($modelsToTry as $model) {
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
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_TIMEOUT => 20
            ]);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && !empty($response)) {
                $resData = json_decode($response, true);
                $text = $resData['candidates'][0]['content']['parts'][0]['text'] ?? '';
                $json = json_decode(trim($text), true);
                if (is_array($json) && isset($json['title_fr'], $json['content_fr'])) {
                    return $json;
                }
            }
        }

        return null;
    }

    private function generateWithPollinations(string $agentId, array $context): ?array {
        $prompt = $this->buildPrompt($context);
        $modelMap = [
            'pollinations-openai' => 'openai',
            'pollinations-mistral' => 'mistral',
            'pollinations-qwen' => 'qwen',
            'pollinations-llama' => 'llama',
            'pollinations-deepseek' => 'deepseek',
        ];
        $pollinationsModel = $modelMap[$agentId] ?? 'openai';

        $payload = json_encode([
            'messages' => [
                ['role' => 'system', 'content' => 'Tu es un rédacteur et traducteur trilingue expert. Réponds UNIQUEMENT avec un JSON strict contenant title_fr, content_fr, title_en, content_en, title_ar, content_ar, seo_description, meta_keywords, summary_ai, image_prompt, facebook_text.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'model' => $pollinationsModel,
            'jsonMode' => true
        ]);

        $ch = curl_init('https://text.pollinations.ai/');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT => 25,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && !empty($response)) {
            $json = json_decode(trim($response), true);
            if (!is_array($json) && preg_match('/```(?:json)?\s*(\{.*?\})\s*```/s', (string)$response, $matches)) {
                $json = json_decode(trim($matches[1]), true);
            }
            if (is_array($json) && isset($json['title_fr'], $json['content_fr'])) {
                return $json;
            }
        }
        return null;
    }

    private function generateWithGroq(string $agentId, array $context): ?array {
        $apiKey = $_ENV['GROQ_API_KEY'] ?? getenv('GROQ_API_KEY');
        if (empty($apiKey)) {
            return null;
        }
        $prompt = $this->buildPrompt($context);
        $modelMap = [
            'groq-llama-3.3-70b' => 'llama-3.3-70b-versatile',
            'groq-llama-3.1-8b' => 'llama-3.1-8b-instant',
            'groq-deepseek-r1-70b' => 'deepseek-r1-distill-llama-70b',
            'groq-mixtral-8x7b' => 'mixtral-8x7b-32768',
        ];
        $groqModel = $modelMap[$agentId] ?? 'llama-3.3-70b-versatile';

        $payload = json_encode([
            'model' => $groqModel,
            'messages' => [
                ['role' => 'system', 'content' => 'Tu es un rédacteur web professionnel. Tu réponds UNIQUEMENT avec un objet JSON valide.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'response_format' => ['type' => 'json_object'],
            'temperature' => 0.7,
            'max_tokens' => 4096
        ]);

        $ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey
            ],
            CURLOPT_TIMEOUT => 20
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && !empty($response)) {
            $data = json_decode((string)$response, true);
            $content = $data['choices'][0]['message']['content'] ?? '';
            $json = json_decode(trim($content), true);
            if (is_array($json) && isset($json['title_fr'], $json['content_fr'])) {
                return $json;
            }
        }
        return null;
    }

    private function buildPrompt(array $context): string {
        $weather = $context['weather'];
        $angle = $context['angle'];
        $fbMode = $context['facebook_mode'] ?? 'AVEC_LIEN';
        $servicesCatalog = json_encode($context['catalog_links'] ?? [], JSON_UNESCAPED_UNICODE);
        $guideCatalog = json_encode($context['guide_links'] ?? [], JSON_UNESCAPED_UNICODE);

        return "RÔLE : Rédacteur en chef et traducteur trilingue d'élite pour djerbavoyage.tn (guide et conciergerie à Djerba).\n"
            . "OBJECTIF : Générer un article complet, immersif et structuré en TROIS LANGUES (Français, Anglais, Arabe littéraire).\n"
            . "CRITÈRES GOOGLE : Haute qualité (Google EEAT & Helpful Content), 1000 à 1400 mots en français, version anglaise et arabe structurées.\n"
            . "THÈME : {$angle['theme']}\n"
            . "FAITS VÉRIFIÉS : {$angle['facts']}\n"
            . "MÉTÉO ACTUELLE : {$weather['temp_c']}°C, {$weather['condition']}.\n"
            . "MODE FACEBOOK : {$fbMode}\n"
            . "SERVICES DU SITE (À MAILLER & RECOMMANDER) : {$servicesCatalog}\n"
            . "AUTRES GUIDES DU SITE (À MAILLER) : {$guideCatalog}\n"
            . "CONSIGNES ÉDITORIALES PAR LANGUE :\n"
            . "1. FRANÇAIS (title_fr, content_fr) : Accroche directe, 4-6 <h2> sous forme de questions de voyageurs, tableau <table> comparatif, encadré <blockquote>💡 <strong>Le conseil de terrain Djerba Voyage :</strong> ...</blockquote>, FAQ de 3 questions/réponses et maillage interne (/services#...).\n"
            . "2. ANGLAIS (title_en, content_en) : Full comprehensive structured English version with h2 headings, comparative table, local tip blockquote, and FAQ.\n"
            . "3. ARABE (title_ar, content_ar) : مقال سياحي شامل ومفصل باللغة العربية الفصحى يتضمن عناوين فرعية h2، جدول مقارن للأنشطة والأسعار، نصيحة محلية وإجابات على الأسئلة الشائعة.\n"
            . "4. Facebook : Texte engageant de 350-450 car. avec emojis et hashtags.\n"
            . "5. IMAGE UNIQUE : Le 'image_prompt' doit être ultra-spécifique au contenu de l'article en anglais (50-60 mots, photoréaliste).\n"
            . "Format JSON strict :\n"
            . "{\n"
            . '  "title_fr": "Titre engageant en français avec \'Djerba\'",' . "\n"
            . '  "title_en": "Engaging English title with \'Djerba\'",' . "\n"
            . '  "title_ar": "عنوان جذاب وشامل باللغة العربية مع \'جربة\'",' . "\n"
            . '  "content_fr": "HTML riche en français (h2, h3, p, table, blockquote, ul, li, a)",' . "\n"
            . '  "content_en": "Rich structured HTML in English (h2, h3, p, table, blockquote, ul, li, a)",' . "\n"
            . '  "content_ar": "محتوى منسق غني بلغة HTML باللغة العربية (h2, h3, p, table, blockquote, ul, li, a)",' . "\n"
            . '  "seo_description": "Meta description (140-155 car.)",' . "\n"
            . '  "meta_keywords": "6-8 mots-clés séparés par des virgules",' . "\n"
            . '  "summary_ai": ["Point clé 1", "Point clé 2", "Point clé 3"],' . "\n"
            . '  "image_prompt": "English 50-60 words highly specific realistic photography prompt, uniquely tailored to the article content, no text, no watermark",' . "\n"
            . '  "facebook_text": "Texte Facebook optimisé (accroche, valeur, question, hashtags)",' . "\n"
            . '  "cta_services": ' . json_encode($angle['suggested_services'] ?? []) . "\n"
            . "}";
    }

    public function cleanTitle(string $title, string|bool $lang = 'fr'): string {
        $langStr = is_bool($lang) ? ($lang ? 'en' : 'fr') : $lang;
        $title = preg_replace('/\s*\(\s*\d{1,2}[:h]\d{2}\s*\)\s*/iu', ' ', $title);
        $title = preg_replace('/\b\d{1,2}[:h]\d{2}\b/iu', '', $title);
        $title = preg_replace('/^(\s*djerba\s+)?(ce\s+jour|aujourd\'hui|today)\s*:\s*/iu', '', $title);
        $title = preg_replace('/^(djerba|évasion\s+à\s+djerba|voyager\s+à\s+djerba|guide\s+djerba|djerba\s+guide|djerba\s+getaway|djerba\s+travel)\s*:\s*/iu', '', $title);
        $title = trim(preg_replace('/^[\s:\-]+|[\s:\-]+$/u', '', $title));
        if (!empty($title)) {
            if ($langStr === 'en' && !preg_match('/djerba/iu', $title)) {
                $title .= ' in Djerba';
            } elseif ($langStr === 'ar' && !preg_match('/جربة|جربي/u', $title)) {
                $title .= ' في جربة';
            } elseif ($langStr === 'fr' && !preg_match('/djerba|djerbien/iu', $title)) {
                $title .= ' à Djerba';
            }
        }
        return preg_replace('/\s{2,}/u', ' ', $title);
    }

    private function slugify(string $text): string {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        return empty($text) ? 'article-djerba' : substr($text, 0, 80);
    }
}
