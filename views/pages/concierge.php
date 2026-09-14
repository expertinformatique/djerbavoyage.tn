<div class="l-container" style="max-width:800px; margin:3rem auto;">
  <div style="text-align:center; margin-bottom:2rem;">
    <h1 style="font-family:var(--font-heading); font-size:2.2rem; color:var(--clr-dark-900);">Conciergerie Djerba sur-mesure</h1>
    <p style="font-size:1.1rem; color:#555;">Recevez un itinéraire 100% personnalisé adapté à vos dates, vos envies et votre budget sous 48h.</p>
  </div>

  <div style="background:#fff; padding:2.5rem; border-radius:16px; box-shadow:var(--shadow-soft);">
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

      <button type="submit" class="c-button c-button--primary" style="width:100%; justify-content:center; padding:1rem;">
        Valider et Régler <?= e($conciergePrice) ?> € via Stripe <i class="fi fi-rr-lock"></i>
      </button>
    </form>
  </div>
</div>

<script>
function handleConciergeSubmit(e) {
  e.preventDefault();
  alert("Demande enregistrée ! Redirection vers la page de paiement sécurisée Stripe...");
  window.location.href = "/checkout/success?session_id=cs_concierge_dev_sample";
}
</script>