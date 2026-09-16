<?php
/**
 * Module Recommandation IA — Vente, Confiance, Zéro Défilement & Zéro Chevauchement
 */
$stepsData = [
    1 => [
        'param' => 'traveler', 'next' => 2,
        'title' => '1. Vos compagnons de voyage ?',
        'items' => [
            ['val' => 'couple', 'title' => 'En Couple', 'desc' => 'Romantique & Détente', 'icon' => 'heart', 'color' => 'rose'],
            ['val' => 'family', 'title' => 'En Famille', 'desc' => 'Activités tous âges', 'icon' => 'users', 'color' => 'blue'],
            ['val' => 'solo', 'title' => 'Solo Nomad', 'desc' => 'Liberté & Découverte', 'icon' => 'user', 'color' => 'gold'],
            ['val' => 'friends', 'title' => 'Entre Amis', 'desc' => 'Sensations & Fun', 'icon' => 'drink-alt', 'color' => 'emerald'],
        ]
    ],
    2 => [
        'param' => 'style', 'next' => 3, 'gridClass' => 'c-ai-quiz__grid--5col',
        'title' => '2. Votre ambiance recherchée ?',
        'items' => [
            ['val' => 'culture', 'title' => 'Culture & Arts', 'desc' => 'Djerbahood & Souks', 'icon' => 'museum', 'color' => 'gold'],
            ['val' => 'beach', 'title' => 'Plage & Spa', 'desc' => 'Sidi Mahres & Lagon', 'icon' => 'umbrella-beach', 'color' => 'teal'],
            ['val' => 'adventure', 'title' => 'Quad & Glisse', 'desc' => 'Kitesurf & Sensations', 'icon' => 'motorcycle', 'color' => 'rose'],
            ['val' => 'food', 'title' => 'Gastronomie', 'desc' => 'Ryads & Terroir', 'icon' => 'restaurant', 'color' => 'emerald'],
            ['val' => 'sahara', 'title' => 'Grand Sud', 'desc' => 'Sahara & Bivouac', 'icon' => 'compass', 'color' => 'purple'],
        ]
    ],
    3 => [
        'param' => 'lodging', 'next' => 4,
        'title' => "3. Votre style d'hébergement ?",
        'items' => [
            ['val' => 'menzel', 'title' => 'Menzel & Houch', 'desc' => 'Patio fleuri typique', 'icon' => 'home', 'color' => 'gold'],
            ['val' => 'resort', 'title' => 'Resort 5★ & Spa', 'desc' => 'Pieds dans l\'eau', 'icon' => 'hotel', 'color' => 'teal'],
            ['val' => 'villa', 'title' => 'Villa Privée', 'desc' => 'Piscine & Intimité', 'icon' => 'key', 'color' => 'rose'],
            ['val' => 'club', 'title' => 'Club Convivial', 'desc' => 'Animations & Plage', 'icon' => 'smile', 'color' => 'blue'],
        ]
    ],
    4 => [
        'param' => 'pace', 'next' => 5,
        'title' => '4. Le rythme de vos journées ?',
        'items' => [
            ['val' => 'relax', 'title' => 'Doux & Zen', 'desc' => 'Farniente & Détente', 'icon' => 'sun', 'color' => 'teal'],
            ['val' => 'balanced', 'title' => 'Équilibré', 'desc' => 'Matin actif, ap-midi mer', 'icon' => 'balance-scale', 'color' => 'emerald'],
            ['val' => 'active', 'title' => 'Intense & Actif', 'desc' => 'Exploration non-stop', 'icon' => 'flame', 'color' => 'rose'],
            ['val' => 'desert', 'title' => 'Évasion Sud', 'desc' => 'Bivouac & Étoiles', 'icon' => 'moon', 'color' => 'gold'],
        ]
    ],
    5 => [
        'param' => 'duration', 'next' => 'finish',
        'title' => '5. La durée de votre séjour ?',
        'items' => [
            ['val' => '3j', 'title' => '3-4 Jours', 'desc' => 'Escapade Express', 'icon' => 'time-fast', 'color' => 'gold'],
            ['val' => '5j', 'title' => '5-7 Jours', 'desc' => 'Équilibre Idéal', 'icon' => 'calendar', 'color' => 'emerald'],
            ['val' => '8j', 'title' => '8-10+ Jours', 'desc' => 'Grand Tour', 'icon' => 'world', 'color' => 'rose'],
        ]
    ]
];
?>
<div class="c-ai-quiz-container" id="salesFunnelQuiz">
    <!-- Statut IA & Confiance -->
    <div class="c-ai-quiz__status-bar">
        <span class="c-ai-quiz__status-dot"></span>
        <span class="c-ai-quiz__status-text"><i class="fi fi-rr-sparkles"></i> Assistant IA Djerba • En Ligne</span>
    </div>
    
    <div id="aiReturnBanner" class="c-ai-quiz__return-banner"></div>

    <div class="c-ai-quiz__header">
        <span class="c-ai-quiz__badge"><i class="fi fi-rr-sparkles"></i> Recommandation IA 2026</span>
        <h2 id="aiTypedHeader" class="c-ai-quiz__title"><span class="ai-text-target"></span><span class="ai-cursor"></span></h2>
        <p id="aiTypedSubtitle" class="c-ai-quiz__subtitle"><span class="ai-text-target"></span><span class="ai-cursor"></span></p>
        
        <!-- Éléments de Réassurance & Confiance -->
        <div class="c-ai-quiz__trust-bar">
            <span class="c-ai-quiz__trust-item"><i class="fi fi-rr-star c-trust-icon--gold"></i> <strong>4.9/5</strong> (+1 200 avis)</span>
            <span class="c-ai-quiz__trust-item"><i class="fi fi-rr-shield-check c-trust-icon--green"></i> 100% Gratuit & Sans engagement</span>
            <span class="c-ai-quiz__trust-item"><i class="fi fi-rr-bolt c-trust-icon--blue"></i> Résultat instantané</span>
        </div>
    </div>

    <!-- Barre de Progression Fluide (Zéro ascenseur) -->
    <div class="c-ai-quiz__progress-wrap">
        <div class="c-ai-quiz__progress-meta">
            <span id="quizStepLabel" class="c-ai-quiz__progress-step">Étape 1 sur 5 • Voyageurs</span>
            <span id="quizPercentLabel" class="c-ai-quiz__progress-pct">20% complété</span>
        </div>
        <div class="c-ai-quiz__progress-track">
            <div id="quizProgressBar" class="c-ai-quiz__progress-bar"></div>
        </div>
        <div class="c-ai-quiz__progress-pills">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <button type="button" class="c-ai-quiz__pill <?= $i === 1 ? 'active' : '' ?>" id="stepPill<?= $i ?>" onclick="goToStep(<?= $i ?>)"><?= $i ?></button>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Étapes du Quiz -->
    <?php foreach ($stepsData as $stepNum => $step): ?>
        <div class="quiz-step" id="quizStep<?= $stepNum ?>" <?= $stepNum > 1 ? 'style="display:none;"' : '' ?>>
            <h3 id="step<?= $stepNum ?>Title" class="c-ai-quiz__step-title"><span class="ai-text-target"></span><span class="ai-cursor"></span></h3>
            <div class="c-ai-quiz__grid <?= $step['gridClass'] ?? '' ?>">
                <?php foreach ($step['items'] as $item): ?>
                    <?php $act = $step['next'] === 'finish' ? "finishQuiz('{$item['val']}')" : "selectQuizOption('{$step['param']}', '{$item['val']}', {$step['next']})"; ?>
                    <button class="quiz-opt-btn" data-rotate-badge="1" onclick="<?= $act ?>">
                        <span class="quiz-opt-btn__badge"></span>
                        <div class="quiz-opt-btn__icon quiz-opt-btn__icon--<?= $item['color'] ?>"><i class="fi fi-rr-<?= $item['icon'] ?>"></i></div>
                        <div class="quiz-opt-btn__title"><?= $item['title'] ?></div>
                        <div class="quiz-opt-btn__desc"><?= $item['desc'] ?></div>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- AI Loading Shimmer -->
    <div id="aiAnalyzingBox" class="c-ai-quiz__loader-box" style="display: none;">
        <div class="c-ai-quiz__loader-icon"><i class="fi fi-rr-sparkles"></i></div>
        <div id="aiAnalyzingText" class="c-ai-quiz__loader-text"><span class="ai-text-target"></span><span class="ai-cursor"></span></div>
        <div class="c-ai-quiz__loader-bar"><div class="c-ai-quiz__loader-fill"></div></div>
    </div>

    <!-- Étape Formulaire Coordonnées Contact (Lead Capture) -->
    <?php require __DIR__ . '/ai_lead_step.php'; ?>

    <!-- Résultat du Recommandeur IA -->
    <div class="quiz-step c-ai-quiz__result-box" id="quizResult" style="display: none;">
        <div id="resLeadSuccessBanner" class="c-ai-quiz__lead-success-banner" style="display: none;"></div>
        <div class="c-ai-quiz__result-header">
            <span id="resMatchBadge" class="c-ai-quiz__match-badge">🔥 99% Match Parfait • Recommandation Certifiée</span>
            <h3 id="resTitle" class="c-ai-quiz__result-title"><span class="ai-text-target"></span><span class="ai-cursor"></span></h3>
            <p id="resDesc" class="c-ai-quiz__result-desc"><span class="ai-text-target"></span><span class="ai-cursor"></span></p>
        </div>

        <div class="c-ai-quiz__result-grid">
            <div class="c-ai-quiz__result-card">
                <div class="c-ai-quiz__result-card-tag"><i class="fi fi-rr-compass"></i> Itinéraire Conseillé</div>
                <div id="resItinerary" class="c-ai-quiz__result-card-head"></div>
                <div id="resItineraryDetails" class="c-ai-quiz__result-card-sub"></div>
            </div>
            <div class="c-ai-quiz__result-card">
                <div class="c-ai-quiz__result-card-tag"><i class="fi fi-rr-hotel"></i> Hébergement Idéal</div>
                <div id="resHotel" class="c-ai-quiz__result-card-head"></div>
                <div id="resHotelDetails" class="c-ai-quiz__result-card-sub"></div>
                <div class="c-ai-quiz__alt-box"><span class="c-ai-quiz__alt-lbl"><i class="fi fi-rr-star"></i> Alternative :</span><span id="resHotelAlt"></span></div>
            </div>
            <div class="c-ai-quiz__result-card">
                <div class="c-ai-quiz__result-card-tag"><i class="fi fi-rr-ticket"></i> Activités Recommandées</div>
                <div id="resActivitiesList" class="c-ai-quiz__activities-list"></div>
            </div>
            <div class="c-ai-quiz__result-card">
                <div class="c-ai-quiz__result-card-tag"><i class="fi fi-rr-restaurant"></i> Table & Saveurs</div>
                <div id="resRestaurant" class="c-ai-quiz__result-card-head"></div>
                <div class="c-ai-quiz__result-card-sub">Poissons frais de la criée, épices du terroir et cadre authentique.</div>
            </div>
        </div>

        <!-- Secret Local de l'IA -->
        <div class="c-ai-quiz__secret-tip">
            <i class="fi fi-rr-bulb c-ai-quiz__secret-icon"></i>
            <div>
                <div id="resTipTitle" class="c-ai-quiz__secret-title">Pépite Secrète de l'IA</div>
                <div id="resTipDesc" class="c-ai-quiz__secret-text"></div>
            </div>
        </div>

        <!-- Bannière d'incitation à la vente / Réassurance -->
        <div class="c-ai-quiz__deal-banner">
            <i class="fi fi-rr-badge-percent c-trust-icon--gold"></i>
            <span><strong>Avantage Pass :</strong> Économisez jusqu'à <strong>-15%</strong> dès 3 activités réservées + Transfert Aéroport Privé Offert !</span>
        </div>

        <!-- Actions de Conversion Rapide -->
        <div class="c-ai-quiz__result-actions">
            <button class="c-button c-button--primary" data-open-modal="personalizedPdfModal">
                <i class="fi fi-rr-document-signed"></i> Commander Mon Guide Personnalisé (9,90 €)
            </button>
            <a href="<?= url('/services') ?>" class="c-button c-button--secondary">
                <i class="fi fi-rr-ticket"></i> Réserver ces Activités au Pass
            </a>
            <button class="c-ai-quiz__refresh-btn" onclick="switchRecommendationVariant()">
                <i class="fi fi-rr-refresh"></i> Autre Suggestion IA
            </button>
            <button class="c-ai-quiz__refresh-btn" onclick="restartQuiz()">
                <i class="fi fi-rr-settings-sliders"></i> Modifier
            </button>
        </div>
    </div>
</div>

<script type="module" src="<?= asset('js/modules/sales-funnel-quiz.js') ?>"></script>
