<div class="l-container" style="max-width: 680px; margin: 4rem auto; text-align: center;">
  <div style="background: #fff; padding: 3rem 2rem; border-radius: 24px; box-shadow: var(--shadow-soft); border: 1px solid var(--clr-sand-300);">
    <i class="fi fi-rr-check-circle" style="font-size: 4.5rem; color: #2ec4b6;"></i>
    <h1 class="heading-1" style="margin: 1rem 0 0.5rem; font-size: 2rem;">Félicitations ! Paiement Validé</h1>
    <p style="color: var(--clr-gray-500); margin-bottom: 2rem; font-size: 1.05rem;">Votre commande a été traitée avec succès et votre guide vous a été envoyé par e-mail.</p>

    <?php if (!empty($token)): ?>
      <div style="background: linear-gradient(135deg, rgba(0,119,182,0.08) 0%, rgba(0,119,182,0.02) 100%); padding: 1.75rem; border-radius: 16px; margin-bottom: 2rem; border: 1px solid rgba(0,119,182,0.2);">
        <h3 class="heading-3" style="margin-bottom: 0.5rem; color: var(--clr-sea-900);">Votre Guide PDF Numérique</h3>
        <p style="font-size: 0.88rem; color: var(--clr-gray-500); margin-bottom: 1.25rem;">Cliquez ci-dessous pour télécharger votre fichier PDF sécurisé (5 téléchargements autorisés).</p>
        <a href="<?= url('/download?token=' . e($token)) ?>" class="c-button c-button--primary" style="width: 100%; justify-content: center; padding: 0.9rem; font-size: 1rem;">
          <i class="fi fi-rr-download"></i> Télécharger Mon Guide PDF
        </a>
      </div>
    <?php endif; ?>

    <!-- FREE ARTISANAL GIFT VOUCHER AT DJERBA AIRPORT -->
    <div style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #fff; padding: 2rem; border-radius: 20px; text-align: left; position: relative; overflow: hidden; border: 2px dashed var(--clr-terracotta-500);">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <span style="background: var(--clr-terracotta-500); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
          🎁 Bon Cadeau Inclus
        </span>
        <span style="font-size: 0.8rem; color: var(--clr-sand-500);">Aéroport DJE / Guellala / Ajim</span>
      </div>

      <h3 style="font-weight: 800; font-size: 1.3rem; color: #fff; margin-bottom: 0.5rem;">
        Votre Produit Artisanal Offered à l'Arrivée !
      </h3>
      <p style="font-size: 0.88rem; color: var(--clr-sand-500); line-height: 1.5; margin-bottom: 1.25rem;">
        Présentez ce coupon à l'accueil partenaire dès votre arrivée à l'Aéroport de Djerba-Zarzis (DJE) ou dans nos ateliers de potiers à Guellala & Ajim pour recevoir au choix :
      </p>

      <ul style="font-size: 0.85rem; color: var(--clr-sand-100); margin-left: 1.25rem; margin-bottom: 1.25rem; line-height: 1.6;">
        <li>🏺 <strong>Une mini-poterie djerbienne faite main</strong> à l'atelier de Guellala</li>
        <li>🌿 <strong>Une fiole d'huile d'olive bio djerbienne</strong> pressée à froid</li>
        <li>🧽 <strong>Une éponge marine naturelle</strong> du port d'Ajim</li>
      </ul>

      <div style="background: rgba(255,255,255,0.1); border-radius: 12px; padding: 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
          <div style="font-size: 0.7rem; color: var(--clr-sand-500); text-transform: uppercase;">Code VIP Cadeau</div>
          <div style="font-family: monospace; font-size: 1.2rem; font-weight: 800; color: #F59E0B; letter-spacing: 2px;">DJE-ARTISAN-2026</div>
        </div>
        <button onclick="window.print()" class="c-button" style="padding: 0.5rem 1rem; font-size: 0.8rem; background: rgba(255,255,255,0.2); color: #fff;">
          <i class="fi fi-rr-print"></i> Imprimer / Enregistrer le Bon
        </button>
      </div>
    </div>

    <div style="margin-top: 2rem;">
      <a href="<?= url('/') ?>" class="c-button c-button--secondary">Retourner à l'Accueil</a>
    </div>
  </div>
</div>