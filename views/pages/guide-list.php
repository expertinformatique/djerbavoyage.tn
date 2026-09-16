<?php
/** @var array $articles */
?>

<div class="l-container">
  <div class="c-blog-header">
    <span class="c-blog-header__badge">
      <i class="fi fi-rr-compass"></i> Guide & Carnet de Voyage
    </span>
    <h1 class="c-blog-header__title">
      Tous nos Guides & Actualités de Djerba
    </h1>
    <p class="c-blog-header__desc">
      Météo en direct, bons plans locaux, itinéraires secrets et conseils pratiques pour vivre un séjour inoubliable sur l'île aux sables d'or.
    </p>
  </div>

  <div class="c-blog-grid">
    <?php foreach ($articles as $art): ?>
      <article class="c-blog-card">
        <?php if (!empty($art->featuredImage)): ?>
          <div class="c-blog-card__media">
            <img src="<?= e(asset($art->featuredImage)) ?>" 
                 alt="<?= htmlspecialchars($art->titleFr, ENT_QUOTES, 'UTF-8') ?>" 
                 class="c-blog-card__img" 
                 loading="lazy" />
            <div class="c-blog-card__badge-overlay">
              <span class="c-blog-card__pill">
                <i class="fi fi-rr-eye"></i> <?= $art->viewsCount ?> vues
              </span>
            </div>
          </div>
        <?php endif; ?>

        <div class="c-blog-card__body">
          <div>
            <div class="c-blog-card__meta">
              <span><i class="fi fi-rr-calendar"></i> <?= date('d/m/Y', strtotime($art->publishedAt ?? 'now')) ?></span>
              <span class="c-blog-card__author">
                <i class="fi fi-rr-user"></i> <?= htmlspecialchars($art->authorName ?? 'Djerba Voyage', ENT_QUOTES, 'UTF-8') ?>
              </span>
            </div>

            <h3 class="c-blog-card__title">
              <a href="<?= url('/guide/' . e($art->slug)) ?>">
                <?= e($art->titleFr) ?>
              </a>
            </h3>

            <p class="c-blog-card__excerpt">
              <?= e($art->seoDescription ?: substr(strip_tags($art->contentFr), 0, 130)) ?>...
            </p>
          </div>

          <div class="c-blog-card__footer">
            <a href="<?= url('/guide/' . e($art->slug)) ?>" class="c-blog-card__read-link">
              <span>Lire le guide</span>
              <i class="fi fi-rr-arrow-right"></i>
            </a>
            <a href="<?= url('/guide/' . e($art->slug) . '/pdf') ?>" target="_blank" class="c-blog-card__pdf-btn" title="Télécharger la fiche PDF">
              <i class="fi fi-rr-file-pdf"></i>
              <span>PDF</span>
            </a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</div>