<?php
/**
 * Module Recommandation IA — Vente, Confiance, Zéro Défilement & Zéro Chevauchement
 */
$stepsData = [
    1 => [
        'param' => 'traveler', 'next' => 2,
        'title' => __('quiz.step1_title'),
        'items' => [
            ['val' => 'couple', 'title' => __('quiz.opt_couple_title'), 'desc' => __('quiz.opt_couple_desc'), 'icon' => 'heart', 'color' => 'rose'],
            ['val' => 'family', 'title' => __('quiz.opt_family_title'), 'desc' => __('quiz.opt_family_desc'), 'icon' => 'users', 'color' => 'blue'],
            ['val' => 'solo', 'title' => __('quiz.opt_solo_title'), 'desc' => __('quiz.opt_solo_desc'), 'icon' => 'user', 'color' => 'gold'],
            ['val' => 'friends', 'title' => __('quiz.opt_friends_title'), 'desc' => __('quiz.opt_friends_desc'), 'icon' => 'drink-alt', 'color' => 'emerald'],
        ]
    ],
    2 => [
        'param' => 'style', 'next' => 3, 'gridClass' => 'c-ai-quiz__grid--5col',
        'title' => __('quiz.step2_title'),
        'items' => [
            ['val' => 'culture', 'title' => __('quiz.opt_culture_title'), 'desc' => __('quiz.opt_culture_desc'), 'icon' => 'museum', 'color' => 'gold'],
            ['val' => 'beach', 'title' => __('quiz.opt_beach_title'), 'desc' => __('quiz.opt_beach_desc'), 'icon' => 'umbrella-beach', 'color' => 'teal'],
            ['val' => 'adventure', 'title' => __('quiz.opt_adventure_title'), 'desc' => __('quiz.opt_adventure_desc'), 'icon' => 'motorcycle', 'color' => 'rose'],
            ['val' => 'food', 'title' => __('quiz.opt_food_title'), 'desc' => __('quiz.opt_food_desc'), 'icon' => 'restaurant', 'color' => 'emerald'],
            ['val' => 'sahara', 'title' => __('quiz.opt_sahara_title'), 'desc' => __('quiz.opt_sahara_desc'), 'icon' => 'compass', 'color' => 'purple'],
        ]
    ],
    3 => [
        'param' => 'lodging', 'next' => 4,
        'title' => __('quiz.step3_title'),
        'items' => [
            ['val' => 'menzel', 'title' => __('quiz.opt_menzel_title'), 'desc' => __('quiz.opt_menzel_desc'), 'icon' => 'home', 'color' => 'gold'],
            ['val' => 'resort', 'title' => __('quiz.opt_resort_title'), 'desc' => __('quiz.opt_resort_desc'), 'icon' => 'hotel', 'color' => 'teal'],
            ['val' => 'villa', 'title' => __('quiz.opt_villa_title'), 'desc' => __('quiz.opt_villa_desc'), 'icon' => 'key', 'color' => 'rose'],
            ['val' => 'club', 'title' => __('quiz.opt_club_title'), 'desc' => __('quiz.opt_club_desc'), 'icon' => 'smile', 'color' => 'blue'],
        ]
    ],
    4 => [
        'param' => 'pace', 'next' => 5,
        'title' => __('quiz.step4_title'),
        'items' => [
            ['val' => 'relax', 'title' => __('quiz.opt_relax_title'), 'desc' => __('quiz.opt_relax_desc'), 'icon' => 'sun', 'color' => 'teal'],
            ['val' => 'balanced', 'title' => __('quiz.opt_balanced_title'), 'desc' => __('quiz.opt_balanced_desc'), 'icon' => 'balance-scale', 'color' => 'emerald'],
            ['val' => 'active', 'title' => __('quiz.opt_active_title'), 'desc' => __('quiz.opt_active_desc'), 'icon' => 'flame', 'color' => 'rose'],
            ['val' => 'desert', 'title' => __('quiz.opt_desert_title'), 'desc' => __('quiz.opt_desert_desc'), 'icon' => 'moon', 'color' => 'gold'],
        ]
    ],
    5 => [
        'param' => 'duration', 'next' => 'finish',
        'title' => __('quiz.step5_title'),
        'items' => [
            ['val' => '3j', 'title' => __('quiz.opt_3j_title'), 'desc' => __('quiz.opt_3j_desc'), 'icon' => 'time-fast', 'color' => 'gold'],
            ['val' => '5j', 'title' => __('quiz.opt_5j_title'), 'desc' => __('quiz.opt_5j_desc'), 'icon' => 'calendar', 'color' => 'emerald'],
            ['val' => '8j', 'title' => __('quiz.opt_8j_title'), 'desc' => __('quiz.opt_8j_desc'), 'icon' => 'world', 'color' => 'rose'],
        ]
    ]
];
?>
<div class="c-ai-quiz-container" id="salesFunnelQuiz">
    <!-- Statut IA & Confiance -->
    <div class="c-ai-quiz__status-bar">
        <span class="c-ai-quiz__status-dot"></span>
        <span class="c-ai-quiz__status-text"><i class="fi fi-rr-sparkles"></i> <?= __('quiz.status_online') ?></span>
    </div>
    
    <div id="aiReturnBanner" class="c-ai-quiz__return-banner"></div>

    <div class="c-ai-quiz__header">
        <span class="c-ai-quiz__badge"><i class="fi fi-rr-sparkles"></i> <?= __('quiz.badge') ?></span>
        <h2 id="aiTypedHeader" class="c-ai-quiz__title"><span class="ai-text-target"></span><span class="ai-cursor"></span></h2>
        <p id="aiTypedSubtitle" class="c-ai-quiz__subtitle"><span class="ai-text-target"></span><span class="ai-cursor"></span></p>
        
        <!-- Éléments de Réassurance & Confiance -->
        <div class="c-ai-quiz__trust-bar">
            <span class="c-ai-quiz__trust-item"><i class="fi fi-rr-star c-trust-icon--gold"></i> <strong>4.9/5</strong> <?= __('quiz.trust_reviews') ?></span>
            <span class="c-ai-quiz__trust-item"><i class="fi fi-rr-shield-check c-trust-icon--green"></i> <?= __('quiz.trust_free') ?></span>
            <span class="c-ai-quiz__trust-item"><i class="fi fi-rr-bolt c-trust-icon--blue"></i> <?= __('quiz.trust_instant') ?></span>
        </div>
    </div>

    <!-- Barre de Progression Fluide (Zéro ascenseur) -->
    <div class="c-ai-quiz__progress-wrap">
        <div class="c-ai-quiz__progress-meta">
            <span id="quizStepLabel" class="c-ai-quiz__progress-step"><?= __('quiz.step_meta', ['step' => 1, 'total' => 5, 'label' => __('quiz.label_travelers')]) ?></span>
            <span id="quizPercentLabel" class="c-ai-quiz__progress-pct"><?= __('quiz.pct_completed', ['pct' => 20]) ?></span>
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
            <span id="resMatchBadge" class="c-ai-quiz__match-badge"><?= __('quiz_res.match_badge') ?></span>
            <h3 id="resTitle" class="c-ai-quiz__result-title"><span class="ai-text-target"></span><span class="ai-cursor"></span></h3>
            <p id="resDesc" class="c-ai-quiz__result-desc"><span class="ai-text-target"></span><span class="ai-cursor"></span></p>
        </div>

        <div class="c-ai-quiz__result-grid">
            <div class="c-ai-quiz__result-card">
                <div class="c-ai-quiz__result-card-tag"><i class="fi fi-rr-compass"></i> <?= __('quiz_res.itinerary') ?></div>
                <div id="resItinerary" class="c-ai-quiz__result-card-head"></div>
                <div id="resItineraryDetails" class="c-ai-quiz__result-card-sub"></div>
            </div>
            <div class="c-ai-quiz__result-card">
                <div class="c-ai-quiz__result-card-tag"><i class="fi fi-rr-hotel"></i> <?= __('quiz_res.hotel') ?></div>
                <div id="resHotel" class="c-ai-quiz__result-card-head"></div>
                <div id="resHotelDetails" class="c-ai-quiz__result-card-sub"></div>
                <div class="c-ai-quiz__alt-box"><span class="c-ai-quiz__alt-lbl"><i class="fi fi-rr-star"></i> <?= __('quiz_res.other_suggestion') ?> :</span><span id="resHotelAlt"></span></div>
            </div>
            <div class="c-ai-quiz__result-card">
                <div class="c-ai-quiz__result-card-tag"><i class="fi fi-rr-ticket"></i> <?= __('quiz_res.activities') ?></div>
                <div id="resActivitiesList" class="c-ai-quiz__activities-list"></div>
            </div>
            <div class="c-ai-quiz__result-card">
                <div class="c-ai-quiz__result-card-tag"><i class="fi fi-rr-restaurant"></i> <?= __('quiz_res.dining') ?></div>
                <div id="resRestaurant" class="c-ai-quiz__result-card-head"></div>
                <div class="c-ai-quiz__result-card-sub"><?= __('quiz_res.dining_desc') ?></div>
            </div>
        </div>

        <!-- Secret Local de l'IA -->
        <div class="c-ai-quiz__secret-tip">
            <i class="fi fi-rr-bulb c-ai-quiz__secret-icon"></i>
            <div>
                <div id="resTipTitle" class="c-ai-quiz__secret-title"><?= __('quiz_res.secret_tip') ?></div>
                <div id="resTipDesc" class="c-ai-quiz__secret-text"></div>
            </div>
        </div>

        <!-- Bannière d'incitation à la vente / Réassurance -->
        <div class="c-ai-quiz__deal-banner">
            <i class="fi fi-rr-badge-percent c-trust-icon--gold"></i>
            <span><?= __('quiz_res.pass_deal') ?></span>
        </div>

        <!-- Actions de Conversion Rapide -->
        <div class="c-ai-quiz__result-actions">
            <button class="c-button c-button--primary" data-open-modal="personalizedPdfModal">
                <i class="fi fi-rr-document-signed"></i> <?= __('quiz_res.order_guide', ['price' => money(9.90)]) ?>
            </button>
            <a href="<?= url('/services') ?>" class="c-button c-button--secondary">
                <i class="fi fi-rr-ticket"></i> <?= __('quiz_res.book_pass') ?>
            </a>
            <button class="c-ai-quiz__refresh-btn" onclick="switchRecommendationVariant()">
                <i class="fi fi-rr-refresh"></i> <?= __('quiz_res.other_suggestion') ?>
            </button>
            <button class="c-ai-quiz__refresh-btn" onclick="restartQuiz()">
                <i class="fi fi-rr-settings-sliders"></i> <?= __('quiz_res.modify') ?>
            </button>
        </div>
    </div>
</div>

<script type="module" src="<?= asset('js/modules/sales-funnel-quiz.js') ?>"></script>
