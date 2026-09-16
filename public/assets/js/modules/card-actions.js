/**
 * Module Actions Cartes (WhatsApp, Copier Lien, PDF, Booking.com)
 * Règle 6 & 8 : Fichier modulaire, non-bloquant
 */

export function initCardActions() {
    window.shareOnWhatsApp = function(title, customUrl) {
        const targetUrl = customUrl || window.location.href;
        const text = encodeURIComponent(`Découvrez "${title}" sur Djerba Voyage 🌴 : ${targetUrl}`);
        window.open(`https://wa.me/?text=${text}`, '_blank');
    };

    window.copyCardLink = function(title, customUrl, btnElem) {
        const targetUrl = customUrl || window.location.href;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(targetUrl).then(() => {
                showCopyToast(btnElem);
            }).catch(() => {
                fallbackCopyText(targetUrl, btnElem);
            });
        } else {
            fallbackCopyText(targetUrl, btnElem);
        }
    };

    window.openPdfModalForCard = function(title) {
        const modal = document.getElementById('personalizedPdfModal');
        const nameInput = document.getElementById('customName');
        if (nameInput && title) {
            nameInput.value = title;
            if (typeof window.updatePdfPreview === 'function') {
                window.updatePdfPreview();
            }
        }
        if (modal) {
            modal.classList.add('is-open');
        } else {
            window.print();
        }
    };
}

function showCopyToast(btnElem) {
    if (btnElem) {
        const origIcon = btnElem.innerHTML;
        btnElem.innerHTML = '<i class="fi fi-rr-check" style="color:#10B981;"></i>';
        btnElem.title = 'Copié !';
        setTimeout(() => {
            btnElem.innerHTML = origIcon;
            btnElem.title = 'Copier le lien';
        }, 2000);
    }
    showFloatingToast('Lien copié dans votre presse-papier !');
}

function fallbackCopyText(text, btnElem) {
    const input = document.createElement('input');
    input.value = text;
    document.body.appendChild(input);
    input.select();
    document.execCommand('copy');
    document.body.removeChild(input);
    showCopyToast(btnElem);
}

function showFloatingToast(message) {
    let toast = document.getElementById('globalActionToast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'globalActionToast';
        toast.className = 'c-toast';
        document.body.appendChild(toast);
    }
    toast.innerHTML = `<i class="fi fi-rr-check-circle" style="color:#10B981;font-size:1.1rem;"></i> ${message}`;
    toast.classList.add('is-visible');
    setTimeout(() => {
        toast.classList.remove('is-visible');
    }, 2800);
}

document.addEventListener('DOMContentLoaded', initCardActions);
