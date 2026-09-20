<?php
/**
 * Module Activités Recommandées (Cross-Selling) dans un article
 * 
 * @var array $ctaServices
 */
if (empty($ctaServices)) {
    return;
}
?>
<div class="c-article-services-section">
  <h3 class="c-article-services-title">
    <i class="fi fi-rr-compass"></i> <?= __('blog_single.cta_services_title') ?>
  </h3>
  <div class="c-article-services-grid">
    <?php foreach ($ctaServices as $service): ?>
      <div class="c-article-service-card">
        <?php if (!empty($service->imageUrl)): ?>
          <div class="c-article-service-card__media">
            <img src="<?= e(asset($service->imageUrl)) ?>" 
                 alt="<?= htmlspecialchars($service->name, ENT_QUOTES, 'UTF-8') ?>" 
                 class="c-article-service-card__img" 
                 loading="lazy">
          </div>
        <?php endif; ?>
        <div class="c-article-service-card__info">
          <h4 class="c-article-service-card__name">
            <?= htmlspecialchars($service->name, ENT_QUOTES, 'UTF-8') ?>
          </h4>
          <p class="c-article-service-card__price">
            <?= __('activities.from_price') ?> <?= money($service->priceEur) ?>
          </p>
        </div>
        <a href="<?= url('/services#' . urlencode($service->slug)) ?>" class="c-button c-button--secondary">
          <?= __('activities.book_vip') ?>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</div>
