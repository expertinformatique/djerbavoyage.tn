<div class="l-container" style="max-width:700px; margin:4rem auto; text-align:center;">
  <div style="background:#fff; padding:3.5rem 2.5rem; border-radius:var(--radius-card); box-shadow:var(--shadow-soft);">
    <i class="fi fi-rr-envelope-open" style="font-size:3.5rem; color:var(--clr-terracotta-500);"></i>
    <h1 style="font-family:var(--font-heading); font-size:2.2rem; margin:1rem 0 0.5rem 0; color:var(--clr-dark-900);">Rejoignez le Club Djerba Voyage</h1>
    <p style="color:var(--clr-gray-500); margin-bottom:2rem;">Recevez nos offres privées, nos réductions secrètes d'hôtels et nos nouveaux guides PDF directement par e-mail.</p>

    <?php if (!empty($success)): ?>
      <div style="background:#e6fffa; color:#234e52; padding:1.25rem; border-radius:12px; margin-bottom:2rem; border:1px solid #b2f5ea; font-weight:600;">
        <i class="fi fi-rr-check-circle"></i> <?= e($success) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="/newsletter" style="max-width:500px; margin:0 auto;">
      <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
        <input type="email" name="email" placeholder="Votre adresse e-mail..." required style="flex:1; padding:0.9rem; border:1px solid var(--clr-sand-200); border-radius:var(--radius-pill); font-family:var(--font-body); min-width:240px;">
        <button type="submit" class="c-button c-button--primary">S'inscrire <i class="fi fi-rr-paper-plane"></i></button>
      </div>
      <p style="font-size:0.8rem; color:#888; margin-top:1rem;">Pas de spam. Désinscription possible à tout moment en 1 clic.</p>
    </form>
  </div>
</div>

