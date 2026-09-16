/**
 * Sales Funnel Quiz Engine — Typewriter Effect & Staggered Options Reveal
 */
import { ROTATING_BADGES, SECRET_TIPS, RECOMMENDATION_VARIANTS } from './ai-recommendation-catalog.js';
import { processAiLeadSubmission } from './ai-lead-form.js';

const STORAGE_KEYS = {
    VISITS: 'dv_ai_visit_count',
    ANSWERS: 'dv_ai_last_answers',
    COMPLETED: 'dv_ai_has_completed',
    SEED: 'dv_ai_msg_seed'
};

const GREETINGS_FIRST_VISIT = [
    "Bienvenue à Djerba ! Prenez 30 secondes pour trouver la formule idéale pour votre séjour.",
    "Ravi de vous accueillir ! Laissez notre IA vous guider vers les plus beaux trésors de l'île.",
    "Bienvenue ! En quelques questions rapides, découvrez vos activités et hébergements idéaux."
];

const GREETINGS_HESITATING = [
    "Vous hésitez encore ? Testez notre simulateur gratuit, il vous donnera de superbes idées d'itinéraires !",
    "Toujours indécis pour votre séjour ? Laissez notre IA vous inspirer en 30 secondes, c'est 100% gratuit.",
    "Besoin d'inspiration pour Djerba ? Notre planificateur gratuit est là pour vous donner un coup de pouce !"
];

const GREETINGS_RETURNING_CHOSEN = [
    "Votre choix précédent ne vous plaît plus ? Pourquoi ne pas essayer autre chose, c'est toujours gratuit !",
    "Envie d'explorer d'autres horizons ? Notre IA a de nouvelles variantes d'itinéraires à vous proposer !",
    "Nous avons de nombreux choix ! N'hésitez pas à <a href='/contact' class='c-ai-quiz__banner-link'>nous contacter ici</a> pour un conseil personnalisé."
];

const STEP_LABELS = { 1: 'Voyageurs', 2: 'Ambiance', 3: 'Hébergement', 4: 'Rythme', 5: 'Durée' };
const STEP_TITLES = {
    1: '1. Vos compagnons de voyage ?',
    2: '2. Votre ambiance recherchée ?',
    3: "3. Votre style d'hébergement ?",
    4: '4. Le rythme de vos journées ?',
    5: '5. La durée de votre séjour ?'
};

const quizState = {
    step: 1,
    variantIndex: 0,
    answers: { traveler: 'couple', style: 'culture', lodging: 'menzel', pace: 'balanced', duration: '5j' }
};

export function initSalesFunnelQuiz() {
    const quizElem = document.getElementById('salesFunnelQuiz');
    if (!quizElem) return;

    handleReturningVisitor();
    applyRotatingBadges();
    setupEventListeners();
    setupIntersectionObserver(quizElem);
}

function handleReturningVisitor() {
    const visits = parseInt(localStorage.getItem(STORAGE_KEYS.VISITS) || '0', 10) + 1;
    localStorage.setItem(STORAGE_KEYS.VISITS, visits.toString());

    const seed = parseInt(localStorage.getItem(STORAGE_KEYS.SEED) || '0', 10) + 1;
    localStorage.setItem(STORAGE_KEYS.SEED, seed.toString());

    const hasChosen = localStorage.getItem(STORAGE_KEYS.COMPLETED) === '1';
    const returnBanner = document.getElementById('aiReturnBanner');

    if (returnBanner) {
        let msg = visits <= 1 ? GREETINGS_FIRST_VISIT[seed % GREETINGS_FIRST_VISIT.length]
            : (!hasChosen ? GREETINGS_HESITATING[seed % GREETINGS_HESITATING.length]
            : GREETINGS_RETURNING_CHOSEN[seed % GREETINGS_RETURNING_CHOSEN.length]);
        returnBanner.innerHTML = `<i class="fi fi-rr-sparkles c-trust-icon--gold"></i> ${msg}`;
        returnBanner.style.display = 'block';
    }

    const saved = localStorage.getItem(STORAGE_KEYS.ANSWERS);
    if (saved) {
        try { Object.assign(quizState.answers, JSON.parse(saved)); } catch (e) {}
    }
}

function applyRotatingBadges() {
    const visits = parseInt(localStorage.getItem(STORAGE_KEYS.VISITS) || '1', 10);
    document.querySelectorAll('.quiz-opt-btn[data-rotate-badge]').forEach((btn, idx) => {
        const badgeElem = btn.querySelector('.quiz-opt-btn__badge');
        if (badgeElem) badgeElem.textContent = ROTATING_BADGES[(visits + idx) % ROTATING_BADGES.length];
    });
}

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
            textTarget.textContent += fullText.charAt(index++);
            setTimeout(streamChar, speed);
        } else {
            if (cursor) setTimeout(() => { cursor.style.display = 'none'; }, 300);
            if (typeof onComplete === 'function') onComplete();
        }
    }
    streamChar();
}

function hideStepOptions(stepId) {
    const step = document.getElementById(stepId);
    if (!step) return;
    step.querySelectorAll('.quiz-opt-btn').forEach(btn => {
        btn.style.opacity = '0';
        btn.style.transform = 'translateY(16px)';
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
        }, (index + 1) * 160); // apparaît lentement un par un
    });
}

function setupIntersectionObserver(quizElem) {
    let observed = false;
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !observed) {
                observed = true;
                startAiIntro();
            }
        });
    }, { threshold: 0.2 });
    observer.observe(quizElem);
}

function startAiIntro() {
    hideStepOptions('quizStep1');
    typeText('aiTypedHeader', "Votre Séjour Sur-Mesure par IA", 18, () => {
        typeText('aiTypedSubtitle', "Itinéraire optimisé, pépites secrètes & meilleures adresses en 30s.", 12, () => {
            goToStep(1);
        });
    });
}

export function goToStep(stepNum) {
    if (stepNum < 1 || stepNum > 5) return;
    quizState.step = stepNum;

    document.querySelectorAll('.quiz-step').forEach(s => s.style.display = 'none');
    const target = document.getElementById('quizStep' + stepNum);
    if (target) target.style.display = 'block';

    hideStepOptions('quizStep' + stepNum);

    const pct = stepNum * 20;
    const pBar = document.getElementById('quizProgressBar');
    if (pBar) pBar.style.width = pct + '%';

    const stepLbl = document.getElementById('quizStepLabel');
    if (stepLbl) stepLbl.textContent = `Étape ${stepNum} sur 5 • ${STEP_LABELS[stepNum]}`;

    const pctLbl = document.getElementById('quizPercentLabel');
    if (pctLbl) pctLbl.textContent = `${pct}% complété`;

    for (let i = 1; i <= 5; i++) {
        const pill = document.getElementById('stepPill' + i);
        if (pill) pill.classList.toggle('active', i <= stepNum);
    }

    typeText('step' + stepNum + 'Title', STEP_TITLES[stepNum], 16, () => {
        revealOptionsSequentially('quizStep' + stepNum);
    });
}

export function selectOption(key, val, nextStep) {
    quizState.answers[key] = val;
    localStorage.setItem(STORAGE_KEYS.ANSWERS, JSON.stringify(quizState.answers));
    goToStep(nextStep);
}

export function finishQuiz(durationVal) {
    quizState.answers.duration = durationVal;
    localStorage.setItem(STORAGE_KEYS.ANSWERS, JSON.stringify(quizState.answers));
    localStorage.setItem(STORAGE_KEYS.COMPLETED, '1');

    document.querySelectorAll('.quiz-step').forEach(s => s.style.display = 'none');
    const aiBox = document.getElementById('aiAnalyzingBox');
    if (aiBox) aiBox.style.display = 'block';

    typeText('aiAnalyzingText', "Calcul de votre formule optimale par l'IA...", 18, () => {
        setTimeout(() => {
            if (aiBox) aiBox.style.display = 'none';
            const leadStep = document.getElementById('quizLeadStep');
            if (leadStep) {
                leadStep.style.display = 'block';
                leadStep.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                renderRecommendation();
            }
        }, 350);
    });
}

export function switchRecommendationVariant() {
    quizState.variantIndex++;
    renderRecommendation();
}

function renderRecommendation() {
    const resElem = document.getElementById('quizResult');
    if (!resElem) return;
    resElem.style.display = 'block';

    const style = quizState.answers.style || 'culture';
    const variants = RECOMMENDATION_VARIANTS[style] || RECOMMENDATION_VARIANTS.culture;
    const variant = variants[quizState.variantIndex % variants.length];

    const matchRates = ['🔥 99% Recommandé • Spécial Séjour Sur-Mesure', '⭐ 98% Match Parfait • Certifié Djerba Voyage'];
    const matchBadge = document.getElementById('resMatchBadge');
    if (matchBadge) matchBadge.textContent = matchRates[quizState.variantIndex % matchRates.length];

    const travelerLabels = { couple: 'Couple', family: 'Famille', solo: 'Solo Nomad', friends: 'Amis' };
    const dur = (quizState.answers.duration || '5j').toUpperCase();
    const trav = travelerLabels[quizState.answers.traveler] || 'Voyageurs';

    typeText('resTitle', `${variant.title} (${dur} • Formule ${trav})`, 16, () => {
        typeText('resDesc', `Itinéraire optimisé selon vos préférences : hébergement ${quizState.answers.lodging} et rythme ${quizState.answers.pace}.`, 10);
    });

    const itHead = document.getElementById('resItinerary');
    const itSub = document.getElementById('resItineraryDetails');
    if (itHead) itHead.textContent = variant.itineraryTitle;
    if (itSub) itSub.textContent = variant.itineraryDesc;

    const hHead = document.getElementById('resHotel');
    const hSub = document.getElementById('resHotelDetails');
    const hAlt = document.getElementById('resHotelAlt');
    if (hHead) hHead.textContent = variant.hotel;
    if (hSub) hSub.textContent = variant.hotelDesc;
    if (hAlt) hAlt.textContent = variant.altHotel;

    const actContainer = document.getElementById('resActivitiesList');
    if (actContainer) {
        actContainer.innerHTML = variant.activities.map(a => `
            <div class="c-ai-quiz__activity-item">
                <a href="/services#${a.slug}"><i class="fi fi-rr-arrow-small-right"></i> ${a.name}</a>
                <span class="c-ai-quiz__activity-price">${a.price}</span>
            </div>
        `).join('');
    }

    const restElem = document.getElementById('resRestaurant');
    if (restElem) restElem.textContent = variant.restaurant;

    const tip = SECRET_TIPS[(quizState.variantIndex + Math.floor(Math.random() * 2)) % SECRET_TIPS.length];
    const tipTitle = document.getElementById('resTipTitle');
    const tipDesc = document.getElementById('resTipDesc');
    if (tipTitle) tipTitle.textContent = `Secret Local de l'IA : ${tip.title}`;
    if (tipDesc) tipDesc.textContent = tip.desc;

    resElem.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function setupEventListeners() {
    window.selectQuizOption = (key, val, nextStep) => selectOption(key, val, nextStep);
    window.finishQuiz = (durationVal) => finishQuiz(durationVal);
    window.switchRecommendationVariant = () => switchRecommendationVariant();
    window.restartQuiz = () => goToStep(1);
    window.goToStep = (step) => goToStep(step);
    window.handleAiLeadSubmit = (e) => {
        e.preventDefault();
        processAiLeadSubmission(e.target, quizState, () => {
            const leadStep = document.getElementById('quizLeadStep');
            if (leadStep) leadStep.style.display = 'none';
            renderRecommendation();
        });
    };
    window.skipLeadStep = () => {
        const leadStep = document.getElementById('quizLeadStep');
        if (leadStep) leadStep.style.display = 'none';
        renderRecommendation();
    };
}

document.addEventListener('DOMContentLoaded', initSalesFunnelQuiz);
