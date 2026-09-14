<div class="l-container" style="max-width:900px; margin:4rem auto;">
  <div style="text-align:center; margin-bottom:3rem;">
    <span style="color:var(--clr-sea-600); font-weight:700; text-transform:uppercase; letter-spacing:1px; font-size:0.85rem;">Une question ?</span>
    <h1 style="font-family:var(--font-heading); font-size:2.5rem; margin-top:0.5rem; color:var(--clr-dark-900);">Contactez l'Équipe Djerba Voyage</h1>
    <p style="color:var(--clr-gray-500); max-width:600px; margin:0.5rem auto 0 auto;">Nous sommes à votre disposition pour répondre à toutes vos interrogations sur nos guides PDF ou notre service de conciergerie.</p>
  </div>

  <?php if (!empty($success)): ?>
    <div style="background:#e6fffa; color:#234e52; padding:1.25rem; border-radius:12px; margin-bottom:2rem; border:1px solid #b2f5ea; text-align:center; font-weight:600;">
      <i class="fi fi-rr-check-circle"></i> <?= e($success) ?>
    </div>
  <?php endif; ?>

  <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:2.5rem;">
    <div style="background:#fff; padding:2.5rem; border-radius:var(--radius-card); box-shadow:var(--shadow-soft);">
      <form method="POST" action="/contact">
        <div style="margin-bottom:1.25rem;">
          <label style="display:block; font-weight:600; margin-bottom:0.4rem;">Votre Nom</label>
          <input type="text" name="name" required style="width:100%; padding:0.85rem; border:1px solid var(--clr-sand-200); border-radius:8px; font-family:var(--font-body);">
        </div>

        <div style="margin-bottom:1.25rem;">
          <label style="display:block; font-weight:600; margin-bottom:0.4rem;">Adresse E-mail</label>
          <input type="email" name="email" required style="width:100%; padding:0.85rem; border:1px solid var(--clr-sand-200); border-radius:8px; font-family:var(--font-body);">
        </div>

        <div style="margin-bottom:1.5rem;">
          <label style="display:block; font-weight:600; margin-bottom:0.4rem;">Votre Message</label>
          <textarea name="message" rows="5" required style="width:100%; padding:0.85rem; border:1px solid var(--clr-sand-200); border-radius:8px; font-family:var(--font-body);"></textarea>
        </div>

        <button type="submit" class="c-button c-button--primary" style="width:100%; justify-content:center;">
          Envoyer le Message <i class="fi fi-rr-paper-plane"></i>
        </button>
      </form>
    </div>

    <div style="display:flex; flex-direction:column; gap:1.5rem;">
      <div style="background:#fff; padding:2rem; border-radius:var(--radius-card); box-shadow:var(--shadow-soft);">
        <h3 style="font-family:var(--font-heading); margin-bottom:0.75rem; color:var(--clr-sea-900);"><i class="fi fi-rr-envelope" style="color:var(--clr-terracotta-500);"></i> E-mail Support</h3>
        <p style="color:var(--clr-gray-500);"><?= e($settings->get('contact_email', 'contact@djerba-voyage.tn')) ?></p>
      </div>

      <div style="background:#fff; padding:2rem; border-radius:var(--radius-card); box-shadow:var(--shadow-soft);">
        <h3 style="font-family:var(--font-heading); margin-bottom:0.75rem; color:var(--clr-sea-900);"><i class="fi fi-rr-time-fast" style="color:var(--clr-sea-600);"></i> Délai de Réponse</h3>
        <p style="color:var(--clr-gray-500);">Notre équipe locale répond sous 24 heures ouvrées.</p>
      </div>

      <div style="background:#fff; padding:2rem; border-radius:var(--radius-card); box-shadow:var(--shadow-soft);">
        <h3 style="font-family:var(--font-heading); margin-bottom:0.75rem; color:var(--clr-sea-900);"><i class="fi fi-rr-marker" style="color:var(--clr-terracotta-500);"></i> Localisation</h3>
        <p style="color:var(--clr-gray-500);">Houmt Souk & Sidi Mahres, Île de Djerba, Tunisie.</p>
      </div>
    </div>
  </div>
</div>
PHP,Description:
