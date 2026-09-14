<!-- Tunnel de Vente / Planificateur de Séjour Sur-Mesure IA -->
<div class="card" id="salesFunnelQuiz" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #fff; border-radius: 24px; padding: 2.5rem; border: 1px solid var(--clr-terracotta-500); box-shadow: 0 20px 40px rgba(0,0,0,0.4); max-width: 900px; margin: 3rem auto; position: relative;">
    
    <!-- AI Status Indicator Header -->
    <div style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-bottom: 1.25rem;">
        <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: #10B981; box-shadow: 0 0 10px #10B981; animation: pulseGlow 1.5s infinite;"></span>
        <span style="font-size: 0.78rem; font-weight: 700; color: #10B981; letter-spacing: 1px; text-transform: uppercase;">Assistant IA Djerba • En Ligne</span>
    </div>

    <div style="text-align: center; margin-bottom: 2rem;">
        <span class="badge badge--gold" style="background: rgba(212,175,55,0.2); color: #F59E0B; padding: 6px 16px; border-radius: 50px; font-weight: 700; font-size: 0.85rem;">
            🎯 Recommandation par Intelligence Artificielle
        </span>
        
        <h2 id="aiTypedHeader" style="font-size: 2rem; font-weight: 800; margin: 0.75rem 0 0.5rem; color: #fff; min-height: 50px;">
            <span class="ai-text-target"></span><span class="ai-cursor">▋</span>
        </h2>
        
        <p id="aiTypedSubtitle" style="color: var(--clr-sand-500); font-size: 0.95rem; min-height: 44px; max-width: 680px; margin: 0 auto;">
            <span class="ai-text-target"></span><span class="ai-cursor">▋</span>
        </p>
    </div>

    <!-- Wizard Steps Indicators -->
    <div style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 2rem;">
        <div class="quiz-step-indicator active" id="stepInd1" style="width: 35px; height: 35px; border-radius: 50%; background: var(--clr-terracotta-500); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">1</div>
        <div class="quiz-step-indicator" id="stepInd2" style="width: 35px; height: 35px; border-radius: 50%; background: rgba(255,255,255,0.1); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">2</div>
        <div class="quiz-step-indicator" id="stepInd3" style="width: 35px; height: 35px; border-radius: 50%; background: rgba(255,255,255,0.1); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">3</div>
    </div>

    <!-- Step 1: Type de Voyageur -->
    <div class="quiz-step" id="quizStep1" style="display: block;">
        <h3 id="step1Title" style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.25rem; text-align: center; color: var(--clr-sand-100); min-height: 32px;">
            <span class="ai-text-target"></span><span class="ai-cursor">▋</span>
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
            <button class="quiz-opt-btn" onclick="selectQuizOption('traveler', 'couple', 2)" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 1.25rem; color: #fff; text-align: center; cursor: pointer; transition: all 0.3s ease; opacity: 0; transform: translateY(15px); pointer-events: none;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">👩‍❤️‍👨</div>
                <div style="font-weight: 700; font-size: 1rem;">En Couple</div>
                <div style="font-size: 0.8rem; color: var(--clr-sand-500); margin-top: 4px;">Romantique & Détente</div>
            </button>
            <button class="quiz-opt-btn" onclick="selectQuizOption('traveler', 'family', 2)" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 1.25rem; color: #fff; text-align: center; cursor: pointer; transition: all 0.3s ease; opacity: 0; transform: translateY(15px); pointer-events: none;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">👨‍👩‍👧‍👦</div>
                <div style="font-weight: 700; font-size: 1rem;">En Famille</div>
                <div style="font-size: 0.8rem; color: var(--clr-sand-500); margin-top: 4px;">Activités Tous Âges</div>
            </button>
            <button class="quiz-opt-btn" onclick="selectQuizOption('traveler', 'solo', 2)" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 1.25rem; color: #fff; text-align: center; cursor: pointer; transition: all 0.3s ease; opacity: 0; transform: translateY(15px); pointer-events: none;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎒</div>
                <div style="font-weight: 700; font-size: 1rem;">Solo / Nomad</div>
                <div style="font-size: 0.8rem; color: var(--clr-sand-500); margin-top: 4px;">Découverte & Liberté</div>
            </button>
            <button class="quiz-opt-btn" onclick="selectQuizOption('traveler', 'friends', 2)" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 1.25rem; color: #fff; text-align: center; cursor: pointer; transition: all 0.3s ease; opacity: 0; transform: translateY(15px); pointer-events: none;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🥳</div>
                <div style="font-weight: 700; font-size: 1rem;">Entre Amis</div>
                <div style="font-size: 0.8rem; color: var(--clr-sand-500); margin-top: 4px;">Fête, Quad & Sports</div>
            </button>
        </div>
    </div>

    <!-- Step 2: Style de Séjour -->
    <div class="quiz-step" id="quizStep2" style="display: none;">
        <h3 id="step2Title" style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.25rem; text-align: center; color: var(--clr-sand-100); min-height: 32px;">
            <span class="ai-text-target"></span><span class="ai-cursor">▋</span>
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
            <button class="quiz-opt-btn" onclick="selectQuizOption('style', 'culture', 3)" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 1.25rem; color: #fff; text-align: center; cursor: pointer; transition: all 0.3s ease; opacity: 0; transform: translateY(15px); pointer-events: none;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🏺</div>
                <div style="font-weight: 700; font-size: 1rem;">Culture & Souks</div>
                <div style="font-size: 0.8rem; color: var(--clr-sand-500); margin-top: 4px;">Djerbahood & Guellala</div>
            </button>
            <button class="quiz-opt-btn" onclick="selectQuizOption('style', 'beach', 3)" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 1.25rem; color: #fff; text-align: center; cursor: pointer; transition: all 0.3s ease; opacity: 0; transform: translateY(15px); pointer-events: none;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🏖️</div>
                <div style="font-weight: 700; font-size: 1rem;">Détente & Plage</div>
                <div style="font-size: 0.8rem; color: var(--clr-sand-500); margin-top: 4px;">Sidi Mahres & Spas</div>
            </button>
            <button class="quiz-opt-btn" onclick="selectQuizOption('style', 'adventure', 3)" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 1.25rem; color: #fff; text-align: center; cursor: pointer; transition: all 0.3s ease; opacity: 0; transform: translateY(15px); pointer-events: none;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🏄‍♂️</div>
                <div style="font-weight: 700; font-size: 1rem;">Sensations & Quad</div>
                <div style="font-size: 0.8rem; color: var(--clr-sand-500); margin-top: 4px;">Kitesurf & Désert</div>
            </button>
            <button class="quiz-opt-btn" onclick="selectQuizOption('style', 'food', 3)" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 1.25rem; color: #fff; text-align: center; cursor: pointer; transition: all 0.3s ease; opacity: 0; transform: translateY(15px); pointer-events: none;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🦞</div>
                <div style="font-weight: 700; font-size: 1rem;">Gastronomie Luxe</div>
                <div style="font-size: 0.8rem; color: var(--clr-sand-500); margin-top: 4px;">Ryads & Poisson frais</div>
            </button>
        </div>
    </div>

    <!-- Step 3: Durée -->
    <div class="quiz-step" id="quizStep3" style="display: none;">
        <h3 id="step3Title" style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.25rem; text-align: center; color: var(--clr-sand-100); min-height: 32px;">
            <span class="ai-text-target"></span><span class="ai-cursor">▋</span>
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <button class="quiz-opt-btn" onclick="finishQuiz('3j')" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 1.25rem; color: #fff; text-align: center; cursor: pointer; transition: all 0.3s ease; opacity: 0; transform: translateY(15px); pointer-events: none;">
                <div style="font-size: 1.8rem; font-weight: 800; color: #F59E0B; margin-bottom: 0.2rem;">3 Jours</div>
                <div style="font-weight: 700; font-size: 0.95rem;">Week-end Express</div>
            </button>
            <button class="quiz-opt-btn" onclick="finishQuiz('5j')" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 1.25rem; color: #fff; text-align: center; cursor: pointer; transition: all 0.3s ease; opacity: 0; transform: translateY(15px); pointer-events: none;">
                <div style="font-size: 1.8rem; font-weight: 800; color: #F59E0B; margin-bottom: 0.2rem;">5 Jours</div>
                <div style="font-weight: 700; font-size: 0.95rem;">Équilibre Parfait</div>
            </button>
            <button class="quiz-opt-btn" onclick="finishQuiz('7j')" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 1.25rem; color: #fff; text-align: center; cursor: pointer; transition: all 0.3s ease; opacity: 0; transform: translateY(15px); pointer-events: none;">
                <div style="font-size: 1.8rem; font-weight: 800; color: #F59E0B; margin-bottom: 0.2rem;">7 Jours +</div>
                <div style="font-weight: 700; font-size: 0.95rem;">Immersion Totale</div>
            </button>
        </div>
    </div>

    <!-- Loading Shimmer while AI analyzes -->
    <div id="aiAnalyzingBox" style="display: none; text-align: center; padding: 3rem 1rem;">
        <div style="font-size: 2.5rem; margin-bottom: 1rem; animation: spinGlow 2s linear infinite; display: inline-block;">🤖</div>
        <div id="aiAnalyzingText" style="font-weight: 700; font-size: 1.2rem; color: #F59E0B; margin-bottom: 0.5rem;">
            <span class="ai-text-target"></span><span class="ai-cursor">▋</span>
        </div>
        <div style="max-width: 400px; height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; margin: 1.5rem auto; overflow: hidden;">
            <div style="width: 100%; height: 100%; background: linear-gradient(90deg, #E07A5F, #F59E0B); animation: loadingPulse 1.2s ease-in-out infinite;"></div>
        </div>
    </div>

    <!-- Step Result Recommendation -->
    <div class="quiz-step" id="quizResult" style="display: none; background: rgba(255,255,255,0.05); border-radius: 20px; padding: 2rem; border: 1px solid var(--clr-terracotta-500);">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">✨🎉</div>
            <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--clr-terracotta-500); margin-bottom: 0.5rem; min-height: 40px;" id="resTitle">
                <span class="ai-text-target"></span><span class="ai-cursor">▋</span>
            </h3>
            <p style="color: var(--clr-sand-100); font-size: 0.95rem; max-width: 600px; margin: 0 auto; min-height: 36px;" id="resDesc">
                <span class="ai-text-target"></span><span class="ai-cursor">▋</span>
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
            <div style="background: rgba(15,23,42,0.6); padding: 1.25rem; border-radius: 14px; border: 1px solid rgba(255,255,255,0.1);">
                <div style="font-size: 0.78rem; color: var(--clr-terracotta-500); font-weight: 700; text-transform: uppercase;">Itinéraire Recommandé</div>
                <div style="font-weight: 700; font-size: 1.05rem; color: #fff; margin: 4px 0; min-height: 28px;" id="resItinerary">
                    <span class="ai-text-target"></span><span class="ai-cursor">▋</span>
                </div>
                <div style="font-size: 0.85rem; color: var(--clr-sand-500); min-height: 40px;" id="resItineraryDetails">
                    <span class="ai-text-target"></span><span class="ai-cursor">▋</span>
                </div>
            </div>

            <div style="background: rgba(15,23,42,0.6); padding: 1.25rem; border-radius: 14px; border: 1px solid rgba(255,255,255,0.1);">
                <div style="font-size: 0.78rem; color: var(--clr-terracotta-500); font-weight: 700; text-transform: uppercase;">Hôtel Sélectionné</div>
                <div style="font-weight: 700; font-size: 1.05rem; color: #fff; margin: 4px 0; min-height: 28px;" id="resHotel">
                    <span class="ai-text-target"></span><span class="ai-cursor">▋</span>
                </div>
                <div style="font-size: 0.85rem; color: var(--clr-sand-500); min-height: 40px;" id="resHotelDetails">
                    <span class="ai-text-target"></span><span class="ai-cursor">▋</span>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <button class="c-button c-button--primary" onclick="openPersonalizedModalFromQuiz()" style="padding: 0.9rem 1.75rem;">
                <i class="fi fi-rr-document-signed"></i> Commander Mon Guide Personnalisé (9,90 €)
            </button>
            <a href="<?= url('/hotels-restaurants') ?>" class="c-button c-button--secondary" style="padding: 0.9rem 1.75rem; background: rgba(255,255,255,0.1); color: #fff;">
                Voir la sélection Hôtels & Restaurants
            </a>
        </div>
    </div>
</div>

<style>
@keyframes pulseGlow {
    0% { opacity: 0.4; transform: scale(0.95); }
    50% { opacity: 1; transform: scale(1.15); }
    100% { opacity: 0.4; transform: scale(0.95); }
}

@keyframes loadingPulse {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

@keyframes spinGlow {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.ai-cursor {
    display: inline-block;
    color: #F59E0B;
    font-weight: bold;
    animation: blinkCursor 0.6s infinite;
    margin-left: 2px;
}

@keyframes blinkCursor {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
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
        btn.style.transform = 'translateY(15px)';
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

    document.querySelectorAll('.quiz-step-indicator').forEach((ind, i) => {
        if (i + 1 <= nextStep) {
            ind.style.background = 'var(--clr-terracotta-500)';
        } else {
            ind.style.background = 'rgba(255,255,255,0.1)';
        }
    });

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

    typeText('aiAnalyzingText', "🤖 Analyse de vos critères en cours par l'IA Djerba...", 18, () => {
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
