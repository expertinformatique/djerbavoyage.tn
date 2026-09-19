<div class="l-container" style="max-width: 680px; margin: clamp(1.5rem, 3vw, 3rem) auto;">
  <div style="text-align: center; margin-bottom: clamp(1.25rem, 2.5vw, 2rem);">
    <span class="badge badge--gold" style="background: rgba(212,175,55,0.15); color: #F59E0B; padding: 4px 14px; border-radius: 50px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px; font-size: 0.82rem;">
      <i class="fi fi-rr-crown"></i> Service Privé VIP
    </span>
    <h1 style="font-family: var(--font-heading); font-size: clamp(1.5rem, 3.2vw, 2.2rem); color: var(--clr-dark-900); margin-bottom: 6px;">Conciergerie Djerba sur-mesure</h1>
    <p style="font-size: clamp(0.92rem, 1.8vw, 1.05rem); color: var(--clr-gray-500); line-height: 1.5;">Recevez un itinéraire 100% personnalisé adapté à vos dates, vos envies et votre budget sous 48h.</p>
  </div>

  <div style="background: #fff; padding: clamp(1.15rem, 3.5vw, 2.25rem); border-radius: 20px; border: 1px solid var(--clr-sand-300); box-shadow: var(--shadow-soft);">
    <div id="concierge-error" style="display:none; background:#fee2e2; color:#b91c1c; padding:0.75rem 1rem; border-radius:8px; margin-bottom:1.25rem; font-size:0.88rem; font-weight:600;"></div>

    <form id="concierge-form" onsubmit="handleConciergeSubmit(event)">
      <div style="margin-bottom: 1.15rem;">
        <label style="display:block; font-weight:700; margin-bottom:0.4rem; font-size: 0.88rem; color: var(--clr-dark-800);">Votre Nom complet</label>
        <input type="text" id="c_name" required placeholder="Prénom et Nom" style="width:100%; padding:0.75rem 1rem; border:1px solid var(--clr-sand-300); border-radius:10px; font-size: 0.95rem; outline: none; transition: border-color 0.2s ease;">
      </div>

      <div style="margin-bottom: 1.15rem;">
        <label style="display:block; font-weight:700; margin-bottom:0.4rem; font-size: 0.88rem; color: var(--clr-dark-800);">Votre Adresse E-mail</label>
        <input type="email" id="c_email" required placeholder="nom@exemple.com" style="width:100%; padding:0.75rem 1rem; border:1px solid var(--clr-sand-300); border-radius:10px; font-size: 0.95rem; outline: none; transition: border-color 0.2s ease;">
      </div>

      <div style="margin-bottom: 1.25rem;">
        <label style="display:block; font-weight:700; margin-bottom:0.4rem; font-size: 0.88rem; color: var(--clr-dark-800);">Dates prévues de votre voyage</label>
        <input type="text" id="c_dates" placeholder="Ex: Du 15 au 22 mai 2026" required style="width:100%; padding:0.75rem 1rem; border:1px solid var(--clr-sand-300); border-radius:10px; font-size: 0.95rem; outline: none; transition: border-color 0.2s ease;">
      </div>

      <div style="background: var(--clr-sand-100); padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.25rem; border: 1px solid var(--clr-sand-300);">
        <h4 style="font-family: var(--font-heading); margin-bottom: 0.25rem; font-size: 1rem; color: var(--clr-dark-900);">Frais Fixes de Planification : <?= e($conciergePrice) ?> €</h4>
        <p style="font-size: 0.85rem; color: var(--clr-gray-500); line-height: 1.45; margin: 0;">Ce montant garantit la prise en charge personnalisée de votre séjour par un concierge résident 7j/7.</p>
      </div>

      <button type="submit" id="concierge-submit-btn" class="c-button c-button--primary" style="width:100%; justify-content:center; padding:0.85rem 1.25rem; font-weight:700; font-size: 0.95rem; display: flex; align-items: center; gap: 8px;">
        Valider et Régler <?= e($conciergePrice) ?> € via Stripe <i class="fi fi-rr-lock"></i>
      </button>
    </form>
  </div>
</div>

<script>
function handleConciergeSubmit(e) {
  e.preventDefault();
  const name = document.getElementById('c_name').value.trim();
  const email = document.getElementById('c_email').value.trim();
  const dates = document.getElementById('c_dates').value.trim();
  const errorEl = document.getElementById('concierge-error');
  const btn = document.getElementById('concierge-submit-btn');

  errorEl.style.display = 'none';

  if (!name || !email || !dates) {
    errorEl.textContent = 'Veuillez remplir tous les champs.';
    errorEl.style.display = 'block';
    return;
  }

  btn.disabled = true;
  btn.innerHTML = '<i class="fi fi-rr-spinner fi-spin"></i> Redirection vers Stripe...';

  const endpoint = '<?= url('/api/concierge/checkout') ?>';

  fetch(endpoint, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ name: name, email: email, dates: dates })
  })
  .then(res => res.json())
  .then(data => {
    if (data.redirect_url) {
      window.location.href = data.redirect_url;
    } else {
      throw new Error(data.error || 'Erreur lors de l\'initialisation du paiement Stripe.');
    }
  })
  .catch(err => {
    errorEl.textContent = err.message;
    errorEl.style.display = 'block';
    btn.disabled = false;
    btn.innerHTML = 'Valider et Régler <?= e($conciergePrice) ?> € via Stripe <i class="fi fi-rr-lock"></i>';
  });
}
</script>