<div style="max-width:400px; margin:5rem auto; background:#fff; padding:2.5rem; border-radius:16px; box-shadow:var(--shadow-soft);">
  <h2 style="font-family:var(--font-heading); text-align:center; margin-bottom:1.5rem; color:var(--clr-dark-900);">
    Connexion Back-Office
  </h2>

  <?php if (!empty($error)): ?>
    <div style="background:#ffdddd; color:#c00; padding:0.8rem; border-radius:8px; margin-bottom:1rem; text-align:center;">
      <?= e($error) ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="/admin/login">
    <div style="margin-bottom:1rem;">
      <label style="display:block; font-weight:600; margin-bottom:0.4rem;">Identifiant / E-mail</label>
      <input type="text" name="username" required style="width:100%; padding:0.8rem; border:1px solid #ccc; border-radius:8px;">
    </div>
    <div style="margin-bottom:1.5rem;">
      <label style="display:block; font-weight:600; margin-bottom:0.4rem;">Mot de passe</label>
      <input type="password" name="password" required style="width:100%; padding:0.8rem; border:1px solid #ccc; border-radius:8px;">
    </div>
    <button type="submit" class="c-button c-button--primary" style="width:100%; justify-content:center;">
      Se Connecter <i class="fi fi-rr-sign-in-alt"></i>
    </button>
  </form>
</div>