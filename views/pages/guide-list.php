<div class="l-container" style="margin:3rem auto;">
  <h1 style="font-family:var(--font-heading); font-size:2.2rem; margin-bottom:1rem;">Tous nos Guides & Conseils de Voyage</h1>
  <p style="color:#666; margin-bottom:2rem;">Découvrez nos articles complets pour préparer votre séjour à Djerba.</p>

  <div class="l-grid-cards">
    <?php foreach ($articles as $art): ?>
      <article class="c-card">
        <div class="c-card__content">
          <h3 class="c-card__title"><?= e($art->titleFr) ?></h3>
          <p style="color:#666; font-size:0.9rem; margin-bottom:1rem;"><?= substr(strip_tags($art->contentFr), 0, 120) ?>...</p>
          <a href="<?= url('/guide/' . e($art->slug)) ?>" class="c-button c-button--secondary">Lire le guide complet</a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</div>