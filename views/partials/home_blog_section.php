<?php
/**
 * Module Section Blog & Guides Récents — Page d'Accueil
 * Architecture MVC, zéro style inline, BEM luxury style méditerranéen
 *
 * @var array $articles
 */
$recentArticles = array_slice($articles ?? [], 0, 3);
if (empty($recentArticles)) {
    return;
}
?>

<section class="c-home-blog" id="homeBlog">
  <div class="l-container">
    
    <div class="c-blog-header">
      <span class="c-blog-header__badge">
        <i class="fi fi-rr-compass"></i> <?= __('blog.badge') ?>
      </span>
      <h2 class="c-blog-header__title">
        <?= __('blog.home_title') ?>
      </h2>
      <p class="c-blog-header__desc">
        <?= __('blog.home_subtitle') ?>
      </p>
    </div>

    <div class="c-blog-grid">
      <?php foreach ($recentArticles as $art): 
        $artTitle = $art->getTitle();
        $artContent = $art->getContent();
      ?>
        <article class="c-blog-card">
          <?php if (!empty($art->featuredImage)): ?>
            <div class="c-blog-card__media">
              <img src="<?= e(asset($art->featuredImage)) ?>" 
                   alt="<?= e($artTitle) ?>" 
                   class="c-blog-card__img" 
                   loading="lazy">
              <div class="c-blog-card__badge-overlay">
                <span class="c-blog-card__pill">
                  <i class="fi fi-rr-eye"></i> <?= (int)$art->viewsCount ?> vues
                </span>
              </div>
            </div>
          <?php endif; ?>

          <div class="c-blog-card__body">
            <div>
              <div class="c-blog-card__meta">
                <span><i class="fi fi-rr-calendar"></i> <?= date('d/m/Y', strtotime($art->publishedAt ?? 'now')) ?></span>
                <span class="c-blog-card__author">
                  <i class="fi fi-rr-user"></i> <?= e($art->authorName ?? 'IA Djerba') ?>
                </span>
              </div>

              <h3 class="c-blog-card__title">
                <a href="<?= url('/guide/' . e($art->slug)) ?>">
                  <?= e($artTitle) ?>
                </a>
              </h3>

              <p class="c-blog-card__excerpt">
                <?= e($art->seoDescription ?: substr(strip_tags($artContent), 0, 130)) ?>...
              </p>
            </div>

            <div class="c-blog-card__footer">
              <a href="<?= url('/guide/' . e($art->slug)) ?>" class="c-blog-card__read-link">
                <span><?= __('blog.read_guide') ?></span>
                <i class="fi fi-rr-arrow-right"></i>
              </a>
              <?php if (!empty($art->pdfEnabled)): ?>
                <a href="<?= url('/guide/' . e($art->slug) . '/pdf') ?>" target="_blank" class="c-blog-card__pdf-btn" title="Télécharger la fiche PDF">
                  <i class="fi fi-rr-file-pdf"></i>
                  <span>PDF</span>
                </a>
              <?php endif; ?>
            </div>


          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="c-home-blog__actions">
      <a href="<?= url('/guide') ?>" class="c-home-blog__cta">
        <span><?= __('blog.explore_all') ?></span>
        <i class="fi fi-rr-arrow-right"></i>
      </a>
    </div>

  </div>
</section>
