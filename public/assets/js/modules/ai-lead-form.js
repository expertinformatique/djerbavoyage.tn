/**
 * Module Gestion Formulaire Lead IA & Envoi Coordonnées
 * Règle 6 & 8 : Fichier modulaire, non-bloquant
 */

function getLeadEndpoint(path) {
    let base = window.APP_BASE_URL;
    if (typeof base === 'undefined') {
        const curPath = window.location.pathname;
        base = curPath.includes('/djerbavoyage') ? '/djerbavoyage' : '';
    }
    const cleanPath = path.startsWith('/') ? path : '/' + path;
    return (base.replace(/\/$/, '') + cleanPath);
}

export async function sendAiLead(payload) {
    try {
        const endpoint = getLeadEndpoint('/api/ai-lead/submit');
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const text = await response.text();
        try {
            return JSON.parse(text);
        } catch (jsonErr) {
            console.error('[AI Lead] Non-JSON response from', endpoint, text.substring(0, 200));
            return { success: false, message: 'Le serveur a renvoyé une réponse inattendue (' + response.status + ').' };
        }
    } catch (err) {
        console.error('[AI Lead] Network error:', err);
        return { success: false, message: 'Erreur de connexion. Veuillez réessayer.' };
    }
}

export function showLeadFeedback(msg, isError = true) {
    const fb = document.getElementById('aiLeadFeedback');
    if (!fb) return;
    fb.textContent = msg;
    fb.className = 'c-ai-lead__feedback ' + (isError ? 'c-ai-lead__feedback--error' : 'c-ai-lead__feedback--success');
}

export async function processAiLeadSubmission(formElem, quizState, onComplete) {
    const btn = document.getElementById('aiLeadSubmitBtn');
    const originalText = btn ? btn.innerHTML : '';
    
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fi fi-rr-spinner c-ai-lead-spin"></i> Envoi en cours...';
    }

    const formData = new FormData(formElem);
    const payload = {
        name: formData.get('name') || '',
        email: formData.get('email') || '',
        phone: formData.get('phone') || '',
        travel_date: formData.get('travel_date') || '',
        notes: formData.get('notes') || '',
        preferences: {
            ...quizState.answers,
            variantIndex: quizState.variantIndex
        }
    };

    const res = await sendAiLead(payload);

    if (btn) {
        btn.disabled = false;
        btn.innerHTML = originalText;
    }

    if (!res.success) {
        showLeadFeedback(res.message || 'Une erreur est survenue.', true);
        return false;
    }

    try {
        localStorage.setItem('djv_lead_sent', '1');
        localStorage.setItem('djv_lead_name', payload.name);
    } catch (e) {}

    const banner = document.getElementById('resLeadSuccessBanner');
    if (banner) {
        banner.innerHTML = `✨ <strong>Merci ${escapeHtml(payload.name)} !</strong> Votre projet a été transmis à notre équipe locale (<a href="mailto:reservation@djerbavoyage.tn" class="c-ai-lead-email-link">reservation@djerbavoyage.tn</a>). Voici votre programme sur-mesure :`;
        banner.style.display = 'block';
    }

    if (typeof onComplete === 'function') {
        onComplete();
    }
    return true;
}

function escapeHtml(str) {
    return String(str).replace(/[&<>"']/g, m => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
    }[m]));
}
