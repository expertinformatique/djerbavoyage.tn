/**
 * Module Éditeur Exclusivité Voyageur — Personnalisation PDF avec Nom, Message et Photo
 * Règle 6 & 8 : Fichier modulaire, non-bloquant
 */

let currentPhotoSrc = '/images/pdf_custom.png';

function getPdfEndpoint(path) {
    let base = window.APP_BASE_URL;
    if (typeof base === 'undefined') {
        const curPath = window.location.pathname;
        base = curPath.includes('/djerbavoyage') ? '/djerbavoyage' : '';
    }
    const cleanPath = path.startsWith('/') ? path : '/' + path;
    return (base.replace(/\/$/, '') + cleanPath);
}

export function initPersonalizedPdfEditor() {
    const nameInput = document.getElementById('customName');
    const msgInput = document.getElementById('customMessage');
    const datesInput = document.getElementById('customDates');
    const fileInput = document.getElementById('customPhotoFile');

    if (nameInput) nameInput.addEventListener('input', updatePdfPreview);
    if (msgInput) msgInput.addEventListener('input', updatePdfPreview);
    if (datesInput) datesInput.addEventListener('input', updatePdfPreview);

    if (fileInput) {
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (evt) => {
                    currentPhotoSrc = evt.target.result;
                    const img = document.getElementById('previewCoverImg');
                    if (img) img.src = currentPhotoSrc;
                    document.querySelectorAll('.c-pdf-photo-thumb').forEach(t => t.classList.remove('is-selected'));
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Galerie de photos rapides
    document.querySelectorAll('.c-pdf-photo-thumb').forEach(thumb => {
        thumb.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.c-pdf-photo-thumb').forEach(t => t.classList.remove('is-selected'));
            thumb.classList.add('is-selected');
            const imgPath = thumb.dataset.photo;
            if (imgPath) {
                currentPhotoSrc = imgPath;
                const img = document.getElementById('previewCoverImg');
                if (img) img.src = currentPhotoSrc;
            }
        });
    });

    window.updatePdfPreview = updatePdfPreview;
    window.previewPersonalizedPdf = previewPersonalizedPdf;
    window.submitPersonalizedPdf = submitPersonalizedPdf;
}

function updatePdfPreview() {
    const nameVal = document.getElementById('customName')?.value.trim() || '';
    const msgVal = document.getElementById('customMessage')?.value.trim() || '';
    const datesVal = document.getElementById('customDates')?.value.trim() || '';

    const titleElem = document.getElementById('previewTitle');
    const datesElem = document.getElementById('previewDates');
    const msgElem = document.getElementById('previewMessage');

    if (titleElem) {
        titleElem.textContent = nameVal ? 'Guide Djerba de ' + nameVal : 'Guide Djerba de Marie & Julien';
    }
    if (datesElem) {
        datesElem.textContent = datesVal ? 'Séjour : ' + datesVal : 'Séjour du 15 au 22 Octobre 2026';
    }
    if (msgElem) {
        msgElem.textContent = msgVal ? '« ' + msgVal + ' »' : '« Pour notre merveilleux séjour à Djerba, entre plages dorées et souvenirs inoubliables ! »';
    }
}

function previewPersonalizedPdf() {
    const name = encodeURIComponent(document.getElementById('customName')?.value.trim() || 'Marie & Julien');
    const message = encodeURIComponent(document.getElementById('customMessage')?.value.trim() || 'Pour notre séjour de rêve à Djerba');
    const dates = encodeURIComponent(document.getElementById('customDates')?.value.trim() || 'Octobre 2026');
    const photo = encodeURIComponent(currentPhotoSrc);

    window.open(getPdfEndpoint(`/pdf/preview?name=${name}&message=${message}&dates=${dates}&photo=${photo}`), '_blank');
}

async function submitPersonalizedPdf(e) {
    e.preventDefault();
    const name = document.getElementById('customName')?.value.trim();
    const email = document.getElementById('customEmail')?.value.trim();
    const message = document.getElementById('customMessage')?.value.trim() || '';
    const dates = document.getElementById('customDates')?.value.trim() || '';

    if (!name || !email) {
        return;
    }

    const btn = e.target.querySelector('button[type="submit"]');
    const origText = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = 'Génération en cours...';
    }

    try {
        const endpoint = getPdfEndpoint('/api/checkout/session');
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({
                product_id: 1,
                email: email,
                custom_name: name,
                custom_message: message,
                custom_dates: dates,
                custom_photo: currentPhotoSrc.length < 500 ? currentPhotoSrc : '/images/pdf_custom.png'
            })
        });
        const data = await response.json();
        if (data.redirect_url) {
            window.location.href = data.redirect_url;
        } else {
            previewPersonalizedPdf();
        }
    } catch (err) {
        console.error('[Personalized PDF] Error:', err);
        previewPersonalizedPdf();
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = origText;
        }
    }
}

document.addEventListener('DOMContentLoaded', initPersonalizedPdfEditor);
