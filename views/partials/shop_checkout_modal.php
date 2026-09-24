<!-- Modal Checkout Produit Boutique -->
<div class="c-modal" id="shopProductModal" role="dialog" aria-hidden="true" onclick="if(event.target === this) closeShopModal()">
    <div class="c-modal__card" style="position: relative; max-width: 480px; width: 100%; background: #ffffff; border-radius: 20px; padding: 2rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); border: 1px solid var(--clr-sand-300);">
        
        <!-- Header du Modal -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(2, 132, 199, 0.1); color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;">
                    <i class="fi fi-rr-shopping-cart"></i>
                </div>
                <div>
                    <h3 style="font-size: 1.15rem; font-family: var(--font-heading); color: var(--clr-dark-900); font-weight: 800; margin: 0; line-height: 1.2;">
                        Commande Numérique Directe
                    </h3>
                    <span style="font-size: 0.75rem; color: #10B981; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; margin-top: 2px;">
                        <i class="fi fi-rr-bolt"></i> Téléchargement instantané 24/7
                    </span>
                </div>
            </div>
            <button type="button" onclick="closeShopModal()" 
                    style="background: var(--clr-sand-200); border: none; width: 34px; height: 34px; border-radius: 50%; font-size: 1.4rem; line-height: 1; cursor: pointer; color: var(--clr-dark-800); display: flex; align-items: center; justify-content: center; transition: all 0.2s;" 
                    title="Fermer" onmouseover="this.style.background='var(--clr-sand-300)'" onmouseout="this.style.background='var(--clr-sand-200)'">
                &times;
            </button>
        </div>

        <form id="shopCheckoutForm" onsubmit="submitShopOrder(event)">
            <input type="hidden" id="modalProductId" value="">
            
            <!-- Box Récapitulatif Produit -->
            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 1rem 1.25rem; margin-bottom: 1.25rem;">
                <div style="font-size: 0.75rem; color: var(--clr-gray-500); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Produit Sélectionné</div>
                <div id="modalProductTitle" style="font-weight: 800; font-size: 1.05rem; color: var(--clr-sea-900); margin: 4px 0 6px 0; line-height: 1.35;"></div>
                <div id="modalProductPrice" style="font-size: 1.35rem; font-weight: 800; color: #10B981; font-family: var(--font-heading);"></div>
            </div>

            <div id="shopFormError" style="color: #EF4444; font-size: 0.85rem; margin-bottom: 1rem; font-weight: 600; display: none; background: #FEF2F2; padding: 8px 12px; border-radius: 8px; border: 1px solid #FCA5A5;"></div>

            <div style="margin-bottom: 1.25rem;">
                <label for="shopClientEmail" style="display: block; font-size: 0.88rem; font-weight: 700; margin-bottom: 6px; color: var(--clr-dark-800);">
                    Votre Adresse Email (pour la livraison du PDF) *
                </label>
                <input type="email" id="shopClientEmail" required class="input" placeholder="nom@exemple.com" 
                       style="width: 100%; padding: 0.85rem 1rem; border-radius: 12px; border: 1.5px solid var(--clr-sand-300); font-size: 0.95rem; outline: none; background: #fff; box-sizing: border-box; transition: border-color 0.2s;"
                       onfocus="this.style.borderColor='#0284c7'" onblur="this.style.borderColor='var(--clr-sand-300)'">
                <small style="color: var(--clr-gray-500); font-size: 0.76rem; display: block; margin-top: 5px;">
                    Votre lien de téléchargement et votre reçu vous seront envoyés à cette adresse.
                </small>
            </div>

            <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 12px; padding: 0.85rem 1rem; font-size: 0.82rem; color: #065F46; line-height: 1.45; margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 8px;">
                <i class="fi fi-rr-shield-check" style="color: #10B981; font-size: 1.15rem; margin-top: 1px; flex-shrink: 0;"></i>
                <div>
                    <strong>Paiement sécurisé par Stripe :</strong> Réception automatique par e-mail en moins de 30 secondes.
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 0.75rem;">
                <button type="button" class="c-button" onclick="closeShopModal()" 
                        style="background: var(--clr-sand-200); color: var(--clr-dark-800); border: 1px solid var(--clr-sand-300); padding: 0.75rem 1.25rem; font-weight: 600; border-radius: 10px; cursor: pointer;">
                    Annuler
                </button>
                <button type="submit" class="c-button c-button--primary" id="submitShopBtn" 
                        style="font-weight: 700; padding: 0.75rem 1.5rem; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                    <i class="fi fi-rr-lock"></i> Régler via Stripe
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openShopCheckout(id, title, price) {
    document.getElementById('modalProductId').value = id;
    document.getElementById('modalProductTitle').textContent = title;
    document.getElementById('modalProductPrice').textContent = price.toFixed(2) + ' €';
    const errorEl = document.getElementById('shopFormError');
    if (errorEl) {
        errorEl.textContent = '';
        errorEl.style.display = 'none';
    }
    
    const modal = document.getElementById('shopProductModal');
    if (modal) {
        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            const input = document.getElementById('shopClientEmail');
            if (input) input.focus();
        }, 150);
    }
}

function closeShopModal() {
    const modal = document.getElementById('shopProductModal');
    if (modal) {
        modal.classList.remove('is-open');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeShopModal();
});

function submitShopOrder(e) {
    e.preventDefault();
    const id = document.getElementById('modalProductId').value;
    const email = document.getElementById('shopClientEmail').value.trim();
    const errorEl = document.getElementById('shopFormError');
    const submitBtn = document.getElementById('submitShopBtn');

    if (!email) {
        errorEl.textContent = 'Veuillez renseigner votre adresse e-mail.';
        errorEl.style.display = 'block';
        return;
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fi fi-rr-spinner fi-spin"></i> Redirection Stripe...';

    const endpoint = '<?= url('/api/checkout/session') ?>';

    fetch(endpoint, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ product_id: parseInt(id, 10), email: email })
    })
    .then(async res => {
        const data = await res.json().catch(() => null);
        if (!res.ok) {
            throw new Error((data && data.error) ? data.error : 'Une erreur est survenue lors de l\'initialisation du paiement.');
        }
        return data;
    })
    .then(data => {
        if (data && data.redirect_url) {
            window.location.href = data.redirect_url;
        } else {
            throw new Error((data && data.error) || 'Erreur lors de la création de la session Stripe.');
        }
    })
    .catch(err => {
        errorEl.textContent = err.message;
        errorEl.style.display = 'block';
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fi fi-rr-lock"></i> Régler via Stripe';
    });
}
</script>
