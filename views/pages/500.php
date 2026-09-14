<div class="l-container" style="max-width:600px; margin:5rem auto; text-align:center;">
  <h1 style="font-size:5rem; font-family:var(--font-heading); color:var(--clr-terracotta-500);">500</h1>
  <h2 style="font-family:var(--font-heading); margin-bottom:1rem;">Erreur Interne Serveur</h2>
  <p style="color:#666; margin-bottom:2rem;">Une erreur est survenue sur nos serveurs. L'incident a été consigné dans le journal d'audit et dans error.log.</p>
  <a href="/" class="c-button c-button--primary">Retourner à l'accueil</a>

  <?php if (isset($_GET['debug']) && isset($e) && $e instanceof \Throwable): ?>
    <div style="margin-top:2rem; padding:1.25rem; background:#fee2e2; border:1px solid #ef4444; border-radius:12px; text-align:left; font-family:monospace; font-size:0.85rem; color:#991b1b; word-break:break-word;">
      <strong>Détail Technique (Mode Debug) :</strong><br>
      <?= htmlspecialchars($e->getMessage()) ?><br><br>
      <small>Fichier : <?= htmlspecialchars($e->getFile()) ?> (Ligne <?= $e->getLine() ?>)</small>
    </div>
  <?php endif; ?>
</div>