<div class="l-container" style="max-width:800px; margin:4rem auto;">
  <article style="background:#fff; padding:3rem; border-radius:var(--radius-card); box-shadow:var(--shadow-soft);">
    <h1 style="font-family:var(--font-heading); font-size:2.2rem; margin-bottom:1.5rem; color:var(--clr-dark-900);">Politique de Confidentialité & Protection des Données (RGPD)</h1>
    <p style="color:var(--clr-gray-500); margin-bottom:2rem;">Dernière mise à jour : 13 septembre 2026</p>

    <div style="line-height:1.8; color:var(--clr-dark-800);">
      <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin:1.5rem 0 0.5rem 0;">1. Données Collectées</h2>
      <p>Dans le cadre de l'utilisation du site Djerba Voyage, nous sommes amenés à collecter les données suivantes :</p>
      <ul style="margin-left:1.5rem; margin-top:0.5rem;">
        <li>Votre adresse e-mail lors de l'achat d'un guide PDF ou d'une demande de conciergerie.</li>
        <li>Les détails de vos préférences de voyage (dates, groupe, budget) soumis dans le formulaire de conciergerie.</li>
        <li>Les données anonymisées de navigation (adresse IP hachée, pages vues, type d'appareil).</li>
      </ul>

      <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin:1.5rem 0 0.5rem 0;">2. Paiements Sécurisés (Stripe)</h2>
      <p>Toutes les transactions bancaires sont traitées de manière hautement sécurisée par notre prestataire de paiement agréé <strong>Stripe</strong>. Aucune donnée de carte bancaire n'est stockée ni hébergée sur nos serveurs.</p>

      <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin:1.5rem 0 0.5rem 0;">3. Vos Droits (Accès & Suppression)</h2>
      <p>Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez d'un droit d'accès, de rectification et de suppression de vos données personnelles sur simple e-mail à : <code><?= e((isset($settings) && $settings) ? $settings->get('contact_email', 'contact@djerba-voyage.tn') : 'contact@djerba-voyage.tn') ?></code>.</p>
    </div>
  </article>
</div>

