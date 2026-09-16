<?php
/**
 * Module Articles Similaires / Poursuivre la lecture
 * 
 * @var array $relatedArticles
 */
if (empty($relatedArticles)) {
    return;
}
?>
<section class="c-article-related">
  <h3 class="c-article-related__title">
    <i class="fi fi-rr-bookmark"></i> Poursuivre votre lecture
  </h3>
  <div class="c-article-related__grid">
    <?php foreach ($relatedArticles as $rel): ?>
      <article class="c-card c-card--blog">
        <?php if (!empty($rel->featuredImage)): ?>
          <div class="c-card__media">
            <img src="<?= e(asset($rel->featuredImage)) ?>" 
                 alt="<?= htmlspecialchars($rel->titleFr, ENT_QUOTES, 'UTF-8') ?>" 
                 class="c-card__image" 
                 loading="lazy">
          </div>
        <?php endif; ?>
        <div class="c-card__content">
          <div>
            <div class="c-card__meta">
              <span><i class="fi fi-rr-calendar"></i> <?= date('d/m/Y', strtotime($rel->publishedAt ?? 'now')) ?></span>
            </div>
            <h4 class="c-card__title">
              <a href="<?= url('/guide/' . e($rel->slug)) ?>">
                <?= htmlspecialchars($rel->titleFr, ENT_QUOTES, 'UTF-8') ?>
              </a>
            </h4>
          </div>
          <div class="c-card__footer">
            <a href="<?= url('/guide/' . e($rel->slug)) ?>" class="c-button c-button--secondary c-button--sm">
              <span>Lire le guide</span>
              <i class="fi fi-rr-arrow-right"></i>
            </a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>
