<div class="l-container" style="max-width:800px; margin:3rem auto;">
  <article style="background:#fff; padding:2.5rem; border-radius:16px; box-shadow:var(--shadow-soft);">
    <h1 style="font-family:var(--font-heading); font-size:2.2rem; margin-bottom:1rem; color:var(--clr-dark-900);"><?= e($article->titleFr) ?></h1>
    <div style="color:#777; font-size:0.9rem; margin-bottom:2rem;">
      <span><i class="fi fi-rr-eye"></i> <?= $article->viewsCount ?> vues</span> | 
      <span>Publié le <?= date('d/m/Y', strtotime($article->publishedAt ?? 'now')) ?></span>
    </div>

    <div style="line-height:1.8; font-size:1.05rem; color:var(--clr-dark-800);">
      <?= $article->contentFr ?>
    </div>

    <div style="margin-top:3rem; padding:1.5rem; background:var(--clr-sand-200); border-radius:12px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
      <div>
        <h4 style="font-family:var(--font-heading);">Besoin d'un itinéraire sur-mesure ?</h4>
        <p style="font-size:0.9rem; color:#555;">Laissez notre conciergerie locale planifier votre séjour idéal.</p>
      </div>
      <a href="<?= url('/concierge') ?>" class="c-button c-button--primary">Demander mon itinéraire (29€)</a>
    </div>
  </article>
</div>