<div class="l-container" style="max-width:800px; margin:3rem auto;">
  <div style="text-align:center; margin-bottom:2rem;">
    <h1 style="font-family:var(--font-heading); font-size:2.2rem; color:var(--clr-dark-900);">Conciergerie Djerba sur-mesure</h1>
    <p style="font-size:1.1rem; color:#555;">Recevez un itinéraire 100% personnalisé adapté à vos dates, vos envies et votre budget sous 48h.</p>
  </div>

  <div style="background:#fff; padding:2.5rem; border-radius:16px; box-shadow:var(--shadow-soft);">
    <div id="concierge-error" style="display:none; background:#fee2e2; color:#b91c1c; padding:0.8rem 1rem; border-radius:8px; margin-bottom:1.5rem; font-size:0.9rem; font-weight:600;"></div>

    <form id="concierge-form" onsubmit="handleConciergeSubmit(event)">
      <div style="margin-bottom:1.5rem;">
        <label style="display:block; font-weight:600; margin-bottom:0.5rem;">Votre Nom complet</label>
        <input type="text" id="c_name" required style="width:100%; padding:0.8rem; border:1px solid var(--clr-sand-200); border-radius:8px;">
      </div>

      <div style="margin-bottom:1.5rem;">
        <label style="display:block; font-weight:600; margin-bottom:0.5rem;">Votre Adresse E-mail</label>
        <input type="email" id="c_email" required style="width:100%; padding:0.8rem; border:1px solid var(--clr-sand-200); border-radius:8px;">
      </div>

      <div style="margin-bottom:1.5rem;">
        <label style="display:block; font-weight:600; margin-bottom:0.5rem;">Dates prévues de votre voyage</label>
        <input type="text" id="c_dates" placeholder="Ex: Du 15 au 22 mai 2026" required style="width:100%; padding:0.8rem; border:1px solid var(--clr-sand-200); border-radius:8px;">
      </div>

      <div style="background:var(--clr-sand-100); padding:1.5rem; border-radius:8px; margin-bottom:1.5rem;">
        <h4 style="font-family:var(--font-heading); margin-bottom:0.5rem;">Frais Fixes de Planification : <?= e($conciergePrice) ?> €</h4>
        <p style="font-size:0.9rem; color:#666;">Ce montant garantit la prise en charge personnalisée de votre dossier par un expert local.</p>
      </div>

      <button type="submit" id="concierge-submit-btn" class="c-button c-button--primary" style="width:100%; justify-content:center; padding:1rem; font-weight:700;">
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