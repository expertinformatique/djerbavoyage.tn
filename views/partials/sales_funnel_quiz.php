<!-- Tunnel de Vente / Planificateur de Séjour Sur-Mesure IA -->
<div class="c-ai-quiz-container" id="salesFunnelQuiz">
    
    <!-- AI Status Indicator Header -->
    <div class="c-ai-quiz__status-bar">
        <span class="c-ai-quiz__status-dot"></span>
        <span class="c-ai-quiz__status-text">
            <i class="fi fi-rr-sparkles" style="color: #10B981; font-size: 0.9rem;"></i> Assistant IA Djerba • En Ligne
        </span>
    </div>

    <div class="c-ai-quiz__header">
        <span class="c-ai-quiz__badge">
            <i class="fi fi-rr-sparkles"></i> Recommandation par Intelligence Artificielle
        </span>
        
        <h2 id="aiTypedHeader" class="c-ai-quiz__title">
            <span class="ai-text-target"></span><span class="ai-cursor"></span>
        </h2>
        
        <p id="aiTypedSubtitle" class="c-ai-quiz__subtitle">
            <span class="ai-text-target"></span><span class="ai-cursor"></span>
        </p>
    </div>

    <!-- Wizard Steps Indicators with Connecting Line -->
    <div class="c-ai-quiz__steps-nav">
        <div class="c-ai-quiz__step-item active" id="stepInd1">
            <span class="c-ai-quiz__step-num">1</span>
            <span class="c-ai-quiz__step-lbl">Voyageurs</span>
        </div>
        <div class="c-ai-quiz__step-line" id="stepLine1"></div>
        <div class="c-ai-quiz__step-item" id="stepInd2">
            <span class="c-ai-quiz__step-num">2</span>
            <span class="c-ai-quiz__step-lbl">Objectif</span>
        </div>
        <div class="c-ai-quiz__step-line" id="stepLine2"></div>
        <div class="c-ai-quiz__step-item" id="stepInd3">
            <span class="c-ai-quiz__step-num">3</span>
            <span class="c-ai-quiz__step-lbl">Durée</span>
        </div>
    </div>

    <!-- Step 1: Type de Voyageur -->
    <div class="quiz-step" id="quizStep1" style="display: block;">
        <h3 id="step1Title" class="c-ai-quiz__step-title">
            <span class="ai-text-target"></span><span class="ai-cursor"></span>
        </h3>
        <div class="c-ai-quiz__grid">
            <button class="quiz-opt-btn" onclick="selectQuizOption('traveler', 'couple', 2)">
                <div class="quiz-opt-btn__icon quiz-opt-btn__icon--rose">
                    <i class="fi fi-rr-heart"></i>
                </div>
                <div class="quiz-opt-btn__title">En Couple</div>
                <div class="quiz-opt-btn__desc">Romantique & Détente</div>
            </button>
            <button class="quiz-opt-btn" onclick="selectQuizOption('traveler', 'family', 2)">
                <div class="quiz-opt-btn__icon quiz-opt-btn__icon--blue">
                    <i class="fi fi-rr-users"></i>
                </div>
                <div class="quiz-opt-btn__title">En Famille</div>
                <div class="quiz-opt-btn__desc">Activités Tous Âges</div>
            </button>
            <button class="quiz-opt-btn" onclick="selectQuizOption('traveler', 'solo', 2)">
                <div class="quiz-opt-btn__icon quiz-opt-btn__icon--gold">
                    <i class="fi fi-rr-user"></i>
                </div>
                <div class="quiz-opt-btn__title">Solo / Nomad</div>
                <div class="quiz-opt-btn__desc">Découverte & Liberté</div>
            </button>
            <button class="quiz-opt-btn" onclick="selectQuizOption('traveler', 'friends', 2)">
                <div class="quiz-opt-btn__icon quiz-opt-btn__icon--emerald">
                    <i class="fi fi-rr-drink-alt"></i>
                </div>
                <div class="quiz-opt-btn__title">Entre Amis</div>
                <div class="quiz-opt-btn__desc">Fête, Quad & Sports</div>
            </button>
        </div>
    </div>

    <!-- Step 2: Style de Séjour -->
    <div class="quiz-step" id="quizStep2" style="display: none;">
        <h3 id="step2Title" class="c-ai-quiz__step-title">
            <span class="ai-text-target"></span><span class="ai-cursor"></span>
        </h3>
        <div class="c-ai-quiz__grid">
            <button class="quiz-opt-btn" onclick="selectQuizOption('style', 'culture', 3)">
                <div class="quiz-opt-btn__icon quiz-opt-btn__icon--gold">
                    <i class="fi fi-rr-museum"></i>
                </div>
                <div class="quiz-opt-btn__title">Culture & Souks</div>
                <div class="quiz-opt-btn__desc">Djerbahood & Guellala</div>
            </button>
            <button class="quiz-opt-btn" onclick="selectQuizOption('style', 'beach', 3)">
                <div class="quiz-opt-btn__icon quiz-opt-btn__icon--teal">
                    <i class="fi fi-rr-umbrella-beach"></i>
                </div>
                <div class="quiz-opt-btn__title">Détente & Plage</div>
                <div class="quiz-opt-btn__desc">Sidi Mahres & Spas</div>
            </button>
            <button class="quiz-opt-btn" onclick="selectQuizOption('style', 'adventure', 3)">
                <div class="quiz-opt-btn__icon quiz-opt-btn__icon--rose">
                    <i class="fi fi-rr-motorcycle"></i>
                </div>
                <div class="quiz-opt-btn__title">Sensations & Quad</div>
                <div class="quiz-opt-btn__desc">Kitesurf & Désert</div>
            </button>
            <button class="quiz-opt-btn" onclick="selectQuizOption('style', 'food', 3)">
                <div class="quiz-opt-btn__icon quiz-opt-btn__icon--emerald">
                    <i class="fi fi-rr-restaurant"></i>
                </div>
                <div class="quiz-opt-btn__title">Gastronomie Luxe</div>
                <div class="quiz-opt-btn__desc">Ryads & Poisson frais</div>
            </button>
        </div>
    </div>

    <!-- Step 3: Durée -->
    <div class="quiz-step" id="quizStep3" style="display: none;">
        <h3 id="step3Title" class="c-ai-quiz__step-title">
            <span class="ai-text-target"></span><span class="ai-cursor"></span>
        </h3>
        <div class="c-ai-quiz__grid c-ai-quiz__grid--3col">
            <button class="quiz-opt-btn" onclick="finishQuiz('3j')">
                <div class="quiz-opt-btn__icon quiz-opt-btn__icon--gold">
                    <i class="fi fi-rr-time-fast"></i>
                </div>
                <div class="quiz-opt-btn__title" style="color: #F59E0B; font-size: 1.2rem;">3 Jours</div>
                <div class="quiz-opt-btn__desc">Week-end Express</div>
            </button>
            <button class="quiz-opt-btn" onclick="finishQuiz('5j')">
                <div class="quiz-opt-btn__icon quiz-opt-btn__icon--rose">
                    <i class="fi fi-rr-calendar"></i>
                </div>
                <div class="quiz-opt-btn__title" style="color: #F59E0B; font-size: 1.2rem;">5 Jours</div>
                <div class="quiz-opt-btn__desc">Équilibre Parfait</div>
            </button>
            <button class="quiz-opt-btn" onclick="finishQuiz('7j')">
                <div class="quiz-opt-btn__icon quiz-opt-btn__icon--teal">
                    <i class="fi fi-rr-sun"></i>
                </div>
                <div class="quiz-opt-btn__title" style="color: #F59E0B; font-size: 1.2rem;">7 Jours +</div>
                <div class="quiz-opt-btn__desc">Immersion Totale</div>
            </button>
        </div>
    </div>

    <!-- Loading Shimmer while AI analyzes -->
    <div id="aiAnalyzingBox" class="c-ai-quiz__loader-box">
        <div class="c-ai-quiz__loader-icon">
            <i class="fi fi-rr-sparkles"></i>
        </div>
        <div id="aiAnalyzingText" class="c-ai-quiz__loader-text">
            <span class="ai-text-target"></span><span class="ai-cursor"></span>
        </div>
        <div class="c-ai-quiz__loader-bar">
            <div class="c-ai-quiz__loader-fill"></div>
        </div>
    </div>

    <!-- Step Result Recommendation -->
    <div class="quiz-step" id="quizResult" class="c-ai-quiz__result-box" style="display: none;">
        <div class="c-ai-quiz__result-header">
            <div class="c-ai-quiz__result-icon">
                <i class="fi fi-rr-badge-check"></i>
            </div>
            <h3 id="resTitle" class="c-ai-quiz__result-title">
                <span class="ai-text-target"></span><span class="ai-cursor"></span>
            </h3>
            <p id="resDesc" class="c-ai-quiz__result-desc">
                <span class="ai-text-target"></span><span class="ai-cursor"></span>
            </p>
        </div>

        <div class="c-ai-quiz__result-grid">
            <div class="c-ai-quiz__result-card">
                <div class="c-ai-quiz__result-card-tag">
                    <i class="fi fi-rr-compass"></i> Itinéraire Recommandé
                </div>
                <div id="resItinerary" class="c-ai-quiz__result-card-head">
                    <span class="ai-text-target"></span><span class="ai-cursor"></span>
                </div>
                <div id="resItineraryDetails" class="c-ai-quiz__result-card-sub">
                    <span class="ai-text-target"></span><span class="ai-cursor"></span>
                </div>
            </div>

            <div class="c-ai-quiz__result-card">
                <div class="c-ai-quiz__result-card-tag">
                    <i class="fi fi-rr-hotel"></i> Hôtel Sélectionné
                </div>
                <div id="resHotel" class="c-ai-quiz__result-card-head">
                    <span class="ai-text-target"></span><span class="ai-cursor"></span>
                </div>
                <div id="resHotelDetails" class="c-ai-quiz__result-card-sub">
                    <span class="ai-text-target"></span><span class="ai-cursor"></span>
                </div>
            </div>
        </div>

        <div class="c-ai-quiz__result-actions">
            <button class="c-button c-button--primary" onclick="openPersonalizedModalFromQuiz()" style="padding: 0.95rem 1.85rem; font-weight: 700; box-shadow: 0 8px 25px rgba(224, 122, 95, 0.4);">
                <i class="fi fi-rr-document-signed"></i> Commander Mon Guide Personnalisé (9,90 €)
            </button>
            <a href="<?= url('/hotels-restaurants') ?>" class="c-button c-button--secondary" style="padding: 0.95rem 1.85rem; background: rgba(255,255,255,0.08); color: #fff; border: 1px solid rgba(255,255,255,0.2);">
                <i class="fi fi-rr-hotel"></i> Voir la sélection Hôtels & Restaurants
            </a>
        </div>
    </div>
</div>

<style>
/* Main Container Styling */
.c-ai-quiz-container {
    background: linear-gradient(145deg, #0F172A 0%, #1E293B 60%, #0F172A 100%);
    color: #fff;
    border-radius: 28px;
    padding: 3rem 2.5rem;
    border: 1px solid rgba(245, 158, 11, 0.35);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.1);
    max-width: 920px;
    margin: 3.5rem auto;
    position: relative;
    overflow: hidden;
}

.c-ai-quiz-container::before {
    content: '';
    position: absolute;
    top: -120px;
    right: -120px;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, rgba(224, 122, 95, 0) 70%);
    pointer-events: none;
    border-radius: 50%;
}

/* AI Status Header Bar */
.c-ai-quiz__status-bar {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-bottom: 1.5rem;
}

.c-ai-quiz__status-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #10B981;
    box-shadow: 0 0 12px #10B981;
    animation: pulseGlow 1.8s ease-in-out infinite;
}

.c-ai-quiz__status-text {
    font-size: 0.8rem;
    font-weight: 700;
    color: #10B981;
    letter-spacing: 1.2px;
    text-transform: uppercase;
}

/* Header Text & Badge */
.c-ai-quiz__header {
    text-align: center;
    margin-bottom: 2.25rem;
}

.c-ai-quiz__badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(245, 158, 11, 0.15);
    color: #F59E0B;
    border: 1px solid rgba(245, 158, 11, 0.3);
    padding: 6px 18px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.85rem;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.1);
}

.c-ai-quiz__title {
    font-size: 2.1rem;
    font-weight: 800;
    margin: 1rem 0 0.5rem;
    color: #FFFFFF;
    min-height: 55px;
    line-height: 1.3;
    letter-spacing: -0.5px;
}

.c-ai-quiz__subtitle {
    color: var(--clr-sand-500, #CBD5E1);
    font-size: 1rem;
    min-height: 48px;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Steps Indicators Navigation */
.c-ai-quiz__steps-nav {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 2.5rem;
    max-width: 450px;
    margin-left: auto;
    margin-right: auto;
}

.c-ai-quiz__step-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    border-radius: 50px;
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.12);
    color: #94A3B8;
    transition: all 0.4s ease;
}

.c-ai-quiz__step-item.active {
    background: linear-gradient(135deg, var(--clr-terracotta-500, #E07A5F) 0%, #F59E0B 100%);
    border-color: #F59E0B;
    color: #FFFFFF;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.35);
}

.c-ai-quiz__step-num {
    font-weight: 800;
    font-size: 0.9rem;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.c-ai-quiz__step-lbl {
    font-size: 0.85rem;
    font-weight: 700;
}

.c-ai-quiz__step-line {
    flex: 1;
    height: 2px;
    background: rgba(255, 255, 255, 0.12);
    border-radius: 2px;
    transition: background 0.4s ease;
}

.c-ai-quiz__step-line.active {
    background: linear-gradient(90deg, var(--clr-terracotta-500, #E07A5F), #F59E0B);
}

.c-ai-quiz__step-title {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    text-align: center;
    color: #F8FAFC;
    min-height: 38px;
}

/* Option Cards Grid & Professional Buttons */
.c-ai-quiz__grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 1.25rem;
}

.c-ai-quiz__grid--3col {
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
}

.quiz-opt-btn {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 20px;
    padding: 1.5rem 1.25rem;
    color: #fff;
    text-align: center;
    cursor: pointer;
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    opacity: 0;
    transform: translateY(18px);
    pointer-events: none;
    position: relative;
    overflow: hidden;
}

.quiz-opt-btn:hover {
    background: linear-gradient(145deg, rgba(224, 122, 95, 0.18) 0%, rgba(245, 158, 11, 0.12) 100%);
    border-color: rgba(245, 158, 11, 0.6);
    transform: translateY(-5px) scale(1.02) !important;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4), 0 0 20px rgba(245, 158, 11, 0.25);
}

.quiz-opt-btn__icon {
    width: 54px;
    height: 54px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto 0.85rem;
    transition: transform 0.3s ease;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.quiz-opt-btn:hover .quiz-opt-btn__icon {
    transform: scale(1.12) rotate(-3deg);
}

/* Icon Gradient Color Variants */
.quiz-opt-btn__icon--rose {
    background: linear-gradient(135deg, rgba(224, 122, 95, 0.3), rgba(224, 122, 95, 0.1));
    color: #E07A5F;
    border: 1px solid rgba(224, 122, 95, 0.4);
}

.quiz-opt-btn__icon--blue {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(59, 130, 246, 0.1));
    color: #60A5FA;
    border: 1px solid rgba(59, 130, 246, 0.4);
}

.quiz-opt-btn__icon--gold {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.1));
    color: #F59E0B;
    border: 1px solid rgba(245, 158, 11, 0.4);
}

.quiz-opt-btn__icon--emerald {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.3), rgba(16, 185, 129, 0.1));
    color: #34D399;
    border: 1px solid rgba(16, 185, 129, 0.4);
}

.quiz-opt-btn__icon--teal {
    background: linear-gradient(135deg, rgba(20, 184, 166, 0.3), rgba(20, 184, 166, 0.1));
    color: #2DD4BF;
    border: 1px solid rgba(20, 184, 166, 0.4);
}

.quiz-opt-btn__title {
    font-weight: 700;
    font-size: 1.05rem;
    color: #FFFFFF;
    margin-bottom: 4px;
}

.quiz-opt-btn__desc {
    font-size: 0.82rem;
    color: #94A3B8;
    line-height: 1.4;
}

/* AI Analyzing Loading Shimmer Box */
.c-ai-quiz__loader-box {
    text-align: center;
    padding: 3rem 1.5rem;
}

.c-ai-quiz__loader-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(224, 122, 95, 0.2));
    border: 1px solid #F59E0B;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #F59E0B;
    margin-bottom: 1.25rem;
    animation: spinGlow 2.5s linear infinite;
    box-shadow: 0 0 25px rgba(245, 158, 11, 0.3);
}

.c-ai-quiz__loader-text {
    font-weight: 700;
    font-size: 1.25rem;
    color: #F59E0B;
    margin-bottom: 1rem;
    min-height: 34px;
}

.c-ai-quiz__loader-bar {
    max-width: 420px;
    height: 6px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    margin: 1.5rem auto 0;
    overflow: hidden;
}

.c-ai-quiz__loader-fill {
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, #E07A5F, #F59E0B, #10B981);
    animation: loadingPulse 1.4s ease-in-out infinite;
}

/* Result Box */
.c-ai-quiz__result-box {
    background: rgba(15, 23, 42, 0.7);
    border-radius: 24px;
    padding: 2.25rem;
    border: 1px solid rgba(245, 158, 11, 0.4);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
}

.c-ai-quiz__result-header {
    text-align: center;
    margin-bottom: 2rem;
}

.c-ai-quiz__result-icon {
    font-size: 3rem;
    color: #F59E0B;
    margin-bottom: 0.5rem;
    display: inline-block;
}

.c-ai-quiz__result-title {
    font-size: 1.6rem;
    font-weight: 800;
    color: #F59E0B;
    margin-bottom: 0.5rem;
    min-height: 44px;
}

.c-ai-quiz__result-desc {
    color: #E2E8F0;
    font-size: 1rem;
    max-width: 650px;
    margin: 0 auto;
    min-height: 38px;
}

.c-ai-quiz__result-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.c-ai-quiz__result-card {
    background: rgba(30, 41, 59, 0.8);
    padding: 1.5rem;
    border-radius: 18px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.c-ai-quiz__result-card-tag {
    font-size: 0.8rem;
    color: #F59E0B;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 6px;
}

.c-ai-quiz__result-card-head {
    font-weight: 700;
    font-size: 1.15rem;
    color: #FFFFFF;
    margin-bottom: 6px;
    min-height: 30px;
}

.c-ai-quiz__result-card-sub {
    font-size: 0.88rem;
    color: #94A3B8;
    line-height: 1.5;
    min-height: 44px;
}

.c-ai-quiz__result-actions {
    display: flex;
    gap: 1.25rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Ultra Sleek AI Typewriter Cursor */
.ai-cursor {
    display: inline-block;
    width: 3px;
    height: 1.15em;
    background: linear-gradient(180deg, #F59E0B 0%, #E07A5F 100%);
    border-radius: 3px;
    vertical-align: -0.15em;
    margin-left: 4px;
    animation: blinkCursor 0.75s ease-in-out infinite;
    box-shadow: 0 0 10px rgba(245, 158, 11, 0.7);
}

@keyframes blinkCursor {
    0%, 100% { opacity: 1; transform: scaleY(1); }
    50% { opacity: 0.15; transform: scaleY(0.7); }
}

@keyframes pulseGlow {
    0% { opacity: 0.4; transform: scale(0.92); }
    50% { opacity: 1; transform: scale(1.18); }
    100% { opacity: 0.4; transform: scale(0.92); }
}

@keyframes loadingPulse {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

@keyframes spinGlow {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@media (max-width: 600px) {
    .c-ai-quiz-container {
        padding: 2rem 1.25rem;
        border-radius: 20px;
    }

    .c-ai-quiz__title {
        font-size: 1.5rem;
        min-height: 65px;
    }

    .c-ai-quiz__grid {
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
    }

    .quiz-opt-btn {
        padding: 1.1rem 0.85rem;
    }

    .quiz-opt-btn__icon {
        width: 44px;
        height: 44px;
        font-size: 1.25rem;
        border-radius: 12px;
    }

    .c-ai-quiz__step-lbl {
        display: none;
    }
}
</style>

<script>
// Typewriter AI Streaming Engine
function typeText(elementId, fullText, speed = 18, onComplete = null) {
    const container = document.getElementById(elementId);
    if (!container) return;

    const textTarget = container.querySelector('.ai-text-target') || container;
    const cursor = container.querySelector('.ai-cursor');
    
    textTarget.textContent = '';
    if (cursor) cursor.style.display = 'inline-block';

    let index = 0;

    function streamChar() {
        if (index < fullText.length) {
            textTarget.textContent += fullText.charAt(index);
            index++;
            setTimeout(streamChar, speed);
        } else {
            if (cursor) {
                setTimeout(() => { cursor.style.display = 'none'; }, 600);
            }
            if (typeof onComplete === 'function') onComplete();
        }
    }

    streamChar();
}

function hideStepOptions(stepId) {
    const step = document.getElementById(stepId);
    if (!step) return;
    const buttons = step.querySelectorAll('.quiz-opt-btn');
    buttons.forEach(btn => {
        btn.style.opacity = '0';
        btn.style.transform = 'translateY(18px)';
        btn.style.pointerEvents = 'none';
    });
}

function revealOptionsSequentially(stepId) {
    const step = document.getElementById(stepId);
    if (!step) return;
    const buttons = step.querySelectorAll('.quiz-opt-btn');
    buttons.forEach((btn, index) => {
        setTimeout(() => {
            btn.style.opacity = '1';
            btn.style.transform = 'translateY(0)';
            btn.style.pointerEvents = 'auto';
        }, index * 160); // Staggered: 0ms, 160ms, 320ms, 480ms
    });
}

// Scroll Trigger via IntersectionObserver
let quizObserved = false;
document.addEventListener('DOMContentLoaded', () => {
    const quizElem = document.getElementById('salesFunnelQuiz');
    if (!quizElem) return;

    hideStepOptions('quizStep1');
    hideStepOptions('quizStep2');
    hideStepOptions('quizStep3');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !quizObserved) {
                quizObserved = true;
                startAiQuizIntro();
            }
        });
    }, { threshold: 0.25 });

    observer.observe(quizElem);
});

function startAiQuizIntro() {
    typeText('aiTypedHeader', "Trouvez la Formule Idéale pour Votre Séjour à Djerba", 20, () => {
        typeText('aiTypedSubtitle', "Bonjour ! Je suis votre Assistant IA Djerba. Répondez à 3 questions rapides pour obtenir votre itinéraire sur-mesure et nos meilleures adresses.", 12, () => {
            typeText('step1Title', "1. Avec qui voyagez-vous pour ce séjour ?", 16, () => {
                revealOptionsSequentially('quizStep1');
            });
        });
    });
}

const quizAnswers = {
    traveler: 'couple',
    style: 'culture',
    duration: '5j'
};

function selectQuizOption(key, val, nextStep) {
    quizAnswers[key] = val;
    
    document.querySelectorAll('.quiz-step').forEach(step => step.style.display = 'none');
    const nextElem = document.getElementById('quizStep' + nextStep);
    nextElem.style.display = 'block';

    // Update step indicators
    for (let i = 1; i <= 3; i++) {
        const ind = document.getElementById('stepInd' + i);
        if (ind) {
            if (i <= nextStep) {
                ind.classList.add('active');
            } else {
                ind.classList.remove('active');
            }
        }
    }
    for (let i = 1; i <= 2; i++) {
        const line = document.getElementById('stepLine' + i);
        if (line) {
            if (i < nextStep) {
                line.classList.add('active');
            } else {
                line.classList.remove('active');
            }
        }
    }

    if (nextStep === 2) {
        hideStepOptions('quizStep2');
        typeText('step2Title', "2. Quel est votre objectif principal pour vos vacances ?", 16, () => {
            revealOptionsSequentially('quizStep2');
        });
    } else if (nextStep === 3) {
        hideStepOptions('quizStep3');
        typeText('step3Title', "3. Quelle sera la durée de votre séjour à Djerba ?", 16, () => {
            revealOptionsSequentially('quizStep3');
        });
    }
}

function finishQuiz(durationVal) {
    quizAnswers.duration = durationVal;
    
    document.querySelectorAll('.quiz-step').forEach(step => step.style.display = 'none');
    
    // Show AI Shimmer Box
    const aiBox = document.getElementById('aiAnalyzingBox');
    aiBox.style.display = 'block';

    typeText('aiAnalyzingText', "Analyse de vos critères en cours par l'IA Djerba...", 18, () => {
        setTimeout(() => {
            aiBox.style.display = 'none';
            const resElem = document.getElementById('quizResult');
            resElem.style.display = 'block';

            let titleText = "", itinName = "", itinDetails = "", hotelName = "", hotelDetails = "";

            if (quizAnswers.style === 'culture') {
                titleText = "Formule Immersion Culture & Patrimoine (" + durationVal.toUpperCase() + ")";
                itinName = "Circuit Djerbahood, Souks & Ateliers de Guellala";
                itinDetails = "Poteries de Guellala, fresques d'Erriadh et ruelles d'Houmt Souk.";
                hotelName = "Dar Dhiafa (Erriadh)";
                hotelDetails = "Menzel authentique avec cour djerbienne traditionnelle et suites d'exception.";
            } else if (quizAnswers.style === 'beach') {
                titleText = "Formule Plage, Détente & Spa Oriental (" + durationVal.toUpperCase() + ")";
                itinName = "Détente Sidi Mahres & Balade Bateau Flamants Roses";
                itinDetails = "Eaux turquoise, massages aux huiles essentielles et farniente.";
                hotelName = "Radisson Blu Palace Djerba";
                hotelDetails = "Resort 5★ en bord de mer avec thalassothérapie d'exception.";
            } else if (quizAnswers.style === 'adventure') {
                titleText = "Formule Aventure, Quad & Kitesurf (" + durationVal.toUpperCase() + ")";
                itinName = "Pistes Désertiques & Spot Kitesurf Aghir";
                itinDetails = "Randonnée Quad au coucher du soleil et initiation kitesurf.";
                hotelName = "Menzel Cajou Aghir";
                hotelDetails = "Boutique-hôtel proche de la lagune et des dunes.";
            } else {
                titleText = "Formule Gastronomie, Luxe & Ryads (" + durationVal.toUpperCase() + ")";
                itinName = "Tables Secrètes & Dégustation Gourmande";
                itinDetails = "Poisson frais au port et dîners aux huiles bio djerbiennes.";
                hotelName = "Hasdrubal Prestige Thalassa";
                hotelDetails = "Resort de luxe avec gastronomie fine et suites impériales.";
            }

            typeText('resTitle', titleText, 18, () => {
                typeText('resDesc', "Voici la sélection d'itinéraires et d'hôtels idéale générée spécialement pour votre profil.", 12, () => {
                    typeText('resItinerary', itinName, 16, () => {
                        typeText('resItineraryDetails', itinDetails, 12);
                    });
                    typeText('resHotel', hotelName, 16, () => {
                        typeText('resHotelDetails', hotelDetails, 12);
                    });
                });
            });

        }, 300);
    });
}

function openPersonalizedModalFromQuiz() {
    ModalManager.open('personalizedPdfModal');
}
</script>
