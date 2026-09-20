/**
 * Sales Funnel Quiz Engine — Typewriter Effect & Staggered Options Reveal
 * Multi-language support (FR / AR / EN)
 */
import { ROTATING_BADGES, SECRET_TIPS, RECOMMENDATION_VARIANTS } from './ai-recommendation-catalog.js';
import { processAiLeadSubmission } from './ai-lead-form.js';

const STORAGE_KEYS = {
    VISITS: 'dv_ai_visit_count',
    ANSWERS: 'dv_ai_last_answers',
    COMPLETED: 'dv_ai_has_completed',
    SEED: 'dv_ai_msg_seed'
};

const IS_AR = typeof document !== 'undefined' && document.documentElement.lang === 'ar';
const IS_EN = typeof document !== 'undefined' && document.documentElement.lang === 'en';

const GREETINGS_FIRST_VISIT = IS_AR ? [
    "مرحباً بك في جربة! خذ 30 ثانية لاكتشاف البرنامج المثالي لإقامتك.",
    "يسعدنا استقبالك! دع الذكاء الاصطناعي يرشدك لأجمل كنوز الجزيرة.",
    "أهلاً بك! في أسئلة سريعة، اكتشف الأنشطة والإقامة المثالية لك."
] : (IS_EN ? [
    "Welcome to Djerba! Take 30 seconds to find the ideal formula for your stay.",
    "Delighted to welcome you! Let our AI guide you to the island's finest treasures.",
    "Welcome! Answer a few quick questions to discover your ideal activities and lodging."
] : [
    "Bienvenue à Djerba ! Prenez 30 secondes pour trouver la formule idéale pour votre séjour.",
    "Ravi de vous accueillir ! Laissez notre IA vous guider vers les plus beaux trésors de l'île.",
    "Bienvenue ! En quelques questions rapides, découvrez vos activités et hébergements idéaux."
]);

const GREETINGS_HESITATING = IS_AR ? [
    "هل ما زلت متردداً؟ جرب محاكينا المجاني للحصول على أفكار مسارات رائعة!",
    "لم تقرر بعد إقامتك؟ دع الذكاء الاصطناعي يلهمك في 30 ثانية مجاناً.",
    "تحتاج إلى إلهام لرحلة جربة؟ مخططنا المجاني هنا لمساعدتك!"
] : (IS_EN ? [
    "Still hesitating? Try our free simulator for great itinerary ideas!",
    "Undecided about your stay? Let our AI inspire you in 30 seconds, 100% free.",
    "Need inspiration for Djerba? Our free planner is here to help!"
] : [
    "Vous hésitez encore ? Testez notre simulateur gratuit, il vous donnera de superbes idées d'itinéraires !",
    "Toujours indécis pour votre séjour ? Laissez notre IA vous inspirer en 30 secondes, c'est 100% gratuit.",
    "Besoin d'inspiration pour Djerba ? Notre planificateur gratuit est là pour vous donner un coup de pouce !"
]);

const GREETINGS_RETURNING_CHOSEN = IS_AR ? [
    "هل ترغب في تجربة خيارات أخرى؟ جرب الاستكشاف مجدداً مجاناً!",
    "تود استكشاف آفاق جديدة؟ لدى الذكاء الاصطناعي مقترحات مسارات جديدة لك!",
    "لدينا العديد من الخيارات! يمكنك <a href='/contact' class='c-ai-quiz__banner-link'>التواصل معنا هنا</a> للحصول على استشارة مخصصة."
] : (IS_EN ? [
    "Want to try a different option? Feel free to explore again for free!",
    "Want to explore new horizons? Our AI has fresh itinerary variants for you!",
    "We have plenty of choices! Feel free to <a href='/contact' class='c-ai-quiz__banner-link'>contact us here</a> for custom advice."
] : [
    "Votre choix précédent ne vous plaît plus ? Pourquoi ne pas essayer autre chose, c'est toujours gratuit !",
    "Envie d'explorer d'autres horizons ? Notre IA a de nouvelles variantes d'itinéraires à vous proposer !",
    "Nous avons de nombreux choix ! N'hésitez pas à <a href='/contact' class='c-ai-quiz__banner-link'>nous contacter ici</a> pour un conseil personnalisé."
]);

const STEP_LABELS = IS_AR ? { 1: 'المسافرون', 2: 'الأجواء', 3: 'الإقامة', 4: 'النسق', 5: 'المدة' }
                  : (IS_EN ? { 1: 'Travelers', 2: 'Atmosphere', 3: 'Lodging', 4: 'Pace', 5: 'Duration' }
                           : { 1: 'Voyageurs', 2: 'Ambiance', 3: 'Hébergement', 4: 'Rythme', 5: 'Durée' });

const STEP_TITLES = IS_AR ? {
    1: '1. من هم رفقاؤك في السفر؟',
    2: '2. ما الأجواء التي تبحث عنها؟',
    3: '3. ما نمط الإقامة المفضّل؟',
    4: '4. ما نسق أيامك؟',
    5: '5. كم مدة إقامتك؟'
} : (IS_EN ? {
    1: '1. Who are your travel companions?',
    2: '2. What atmosphere are you looking for?',
    3: '3. What is your accommodation style?',
    4: '4. What pace for your days?',
    5: '5. What is the length of your stay?'
} : {
    1: '1. Vos compagnons de voyage ?',
    2: '2. Votre ambiance recherchée ?',
    3: "3. Votre style d'hébergement ?",
    4: '4. Le rythme de vos journées ?',
    5: '5. La durée de votre séjour ?'
});

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
            textTarget.textContent += fullText.charAt(index);
            index++;
            setTimeout(streamChar, speed);
        } else {
            if (cursor) cursor.style.display = 'none';
            if (typeof onComplete === 'function') onComplete();
        }
    }
    streamChar();
}

function setupIntersectionObserver(quizElem) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                startQuizHeaderTypewriter();
                observer.disconnect();
            }
        });
    }, { threshold: 0.15 });

    observer.observe(quizElem);
}

function startQuizHeaderTypewriter() {
    const headerTitle = IS_AR ? "مخطط الرحلات بالذكاء الاصطناعي" : (IS_EN ? "AI Travel Planner 2026" : "Planificateur de Séjour IA 2026");
    const headerSub = IS_AR ? "أجب عن 5 أسئلة سريعة لاكتشاف أفضل مسار لك في جربة" : (IS_EN ? "Answer 5 quick questions to get your custom Djerba plan" : "Répondez à 5 questions rapides pour obtenir votre formule idéale à Djerba");

    typeText('aiTypedHeader', headerTitle, 22, () => {
        typeText('aiTypedSubtitle', headerSub, 14, () => {
            typeStepHeader(1);
        });
    });
}

function updateProgressMeta(step) {
    const stepLabel = document.getElementById('quizStepLabel');
    const pctLabel = document.getElementById('quizPercentLabel');
    const barFill = document.getElementById('quizProgressBar');

    const pct = Math.round((step / 5) * 100);
    const label = STEP_LABELS[step] || '';

    if (stepLabel) {
        stepLabel.textContent = IS_AR ? `الخطوة ${step} من 5 • ${label}` : (IS_EN ? `Step ${step} of 5 • ${label}` : `Étape ${step} sur 5 • ${label}`);
    }
    if (pctLabel) {
        pctLabel.textContent = IS_AR ? `${pct}% مكتمل` : (IS_EN ? `${pct}% completed` : `${pct}% complété`);
    }
    if (barFill) {
        barFill.style.width = `${pct}%`;
    }

    for (let i = 1; i <= 5; i++) {
        const pill = document.getElementById(`stepPill${i}`);
        if (pill) {
            pill.classList.toggle('active', i === step);
            pill.classList.toggle('completed', i < step);
        }
    }
}

function revealOptionsSequentially(stepId) {
    const stepElem = document.getElementById(stepId);
    if (!stepElem) return;

    const options = stepElem.querySelectorAll('.quiz-opt-btn');
    options.forEach((opt, i) => {
        opt.style.opacity = '0';
        opt.style.transform = 'translateY(10px)';
        setTimeout(() => {
            opt.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
            opt.style.opacity = '1';
            opt.style.transform = 'translateY(0)';
        }, i * 60);
    });
}

export function goToStep(stepNum) {
    if (stepNum < 1 || stepNum > 5) return;
    quizState.step = stepNum;

    document.querySelectorAll('.quiz-step').forEach(s => s.style.display = 'none');
    const targetStep = document.getElementById('quizStep' + stepNum);
    if (targetStep) targetStep.style.display = 'block';

    updateProgressMeta(stepNum);
    typeStepHeader(stepNum);
}

function typeStepHeader(stepNum) {
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

    const loadingMsg = IS_AR ? "جاري حساب صيغتك المثالية بالذكاء الاصطناعي..." : (IS_EN ? "Calculating your optimal formula with AI..." : "Calcul de votre formule optimale par l'IA...");

    typeText('aiAnalyzingText', loadingMsg, 18, () => {
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

    const matchRates = IS_AR ? ['🔥 99% موصى به • برنامج مخصص', '⭐ 98% تطابق ممتاز • توثيق جربة فواياج']
                     : (IS_EN ? ['🔥 99% Recommended • Bespoke Stay', '⭐ 98% Perfect Match • Verified Djerba Voyage']
                              : ['🔥 99% Recommandé • Spécial Séjour Sur-Mesure', '⭐ 98% Match Parfait • Certifié Djerba Voyage']);
    const matchBadge = document.getElementById('resMatchBadge');
    if (matchBadge) matchBadge.textContent = matchRates[quizState.variantIndex % matchRates.length];

    const travelerLabels = IS_AR ? { couple: 'زوجان', family: 'عائلة', solo: 'مسافر مفرد', friends: 'أصدقاء' }
                         : (IS_EN ? { couple: 'Couple', family: 'Family', solo: 'Solo Nomad', friends: 'Friends' }
                                  : { couple: 'Couple', family: 'Famille', solo: 'Solo Nomad', friends: 'Amis' });
    const dur = (quizState.answers.duration || '5j').toUpperCase();
    const trav = travelerLabels[quizState.answers.traveler] || (IS_AR ? 'مسافرون' : (IS_EN ? 'Travelers' : 'Voyageurs'));

    const descTxt = IS_AR ? `مسار محسّن حسب تفضيلاتك: إقامة ${quizState.answers.lodging} ونسق ${quizState.answers.pace}.`
                  : (IS_EN ? `Optimized itinerary based on your preferences: ${quizState.answers.lodging} lodging and ${quizState.answers.pace} pace.`
                           : `Itinéraire optimisé selon vos préférences : hébergement ${quizState.answers.lodging} et rythme ${quizState.answers.pace}.`);

    typeText('resTitle', `${variant.title} (${dur} • ${trav})`, 16, () => {
        typeText('resDesc', descTxt, 10);
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
    const tipPrefix = IS_AR ? "سر الذكاء الاصطناعي المحلي:" : (IS_EN ? "AI Local Secret:" : "Secret Local de l'IA :");
    if (tipTitle) tipTitle.textContent = `${tipPrefix} ${tip.title}`;
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
