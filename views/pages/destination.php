<?php
  $_curLocale = \Core\Lang::getLocale();
  $destName = $destination['name_' . $_curLocale] ?? $destination['name_fr'];
  $destDesc = $destination['description_' . $_curLocale] ?? $destination['description_fr'];
?>
<div class="l-container" style="margin:3rem auto;">
  <div style="margin-bottom:2rem;">
    <h1 style="font-family:var(--font-heading); font-size:2.4rem; color:var(--clr-dark-900);"><?= e($destName) ?></h1>
    <p style="font-size:1.1rem; color:#555;"><?= e($destDesc) ?></p>
  </div>

  <div class="c-tabs">
    <div class="c-tabs__header">
      <button class="c-tabs__button is-active" data-tab="hotels"><i class="fi fi-rr-hotel"></i> <?= __('destinations.tab_hotels') ?></button>
      <button class="c-tabs__button" data-tab="excursions"><i class="fi fi-rr-compass"></i> <?= __('destinations.tab_excursions') ?></button>
      <button class="c-tabs__button" data-tab="articles"><i class="fi fi-rr-document"></i> <?= __('destinations.tab_articles') ?></button>
    </div>

    <div class="c-tabs__content is-active" id="tab-hotels">
      <div style="background:#fff; padding:2rem; border-radius:16px; border:1px solid var(--clr-sand-300); box-shadow:var(--shadow-soft);">
        <h3 style="font-family:var(--font-heading); font-size:1.4rem; color:var(--clr-dark-900); margin-bottom:0.5rem;"><?= __('destinations.hotels_title', ['name' => e($destName)]) ?></h3>
        <p style="margin-bottom:1.5rem; color:#666; font-size:1rem;"><?= __('destinations.hotels_desc') ?></p>
        <button type="button" onclick="openBookingHotelsModal('<?= e(addslashes($destName)) ?>')" class="c-button c-button--secondary" style="font-weight:700; font-size:0.95rem; padding:0.85rem 1.6rem;">
          <i class="fi fi-rr-hotel"></i> <?= __('destinations.hotels_btn') ?> <i class="fi fi-rr-arrow-up-right"></i>
        </button>
      </div>
    </div>

    <div class="c-tabs__content" id="tab-excursions">
      <div style="background:#fff; padding:2rem; border-radius:16px; border:1px solid var(--clr-sand-300); box-shadow:var(--shadow-soft);">
        <h3 style="font-family:var(--font-heading); font-size:1.4rem; color:var(--clr-dark-900); margin-bottom:0.5rem;"><?= __('destinations.excursions_title', ['name' => e($destName)]) ?></h3>
        <p style="margin-bottom:1.5rem; color:#666; font-size:1rem;"><?= __('destinations.excursions_desc') ?></p>
        <a href="https://www.getyourguide.com/djerba-l32386/?partner_id=<?= e((isset($settings) && $settings) ? $settings->get('getyourguide_partner_id', '8073836') : '8073836') ?>" target="_blank" rel="sponsored noopener" class="c-button c-button--primary" style="font-weight:700; font-size:0.95rem; padding:0.85rem 1.6rem;">
          <?= __('destinations.excursions_btn') ?> <i class="fi fi-rr-arrow-up-right"></i>
        </a>
      </div>
    </div>

    <div class="c-tabs__content" id="tab-articles">
      <div class="l-grid-cards">
        <?php foreach ($articles as $art): ?>
          <article class="c-card" style="background:#fff; border-radius:16px; border:1px solid var(--clr-sand-300);">
            <div class="c-card__content">
              <h3 class="c-card__title" style="font-size:1.15rem; font-family:var(--font-heading);"><?= e($art->getTitle()) ?></h3>
              <a href="<?= url('/guide/' . e($art->slug)) ?>" class="c-button c-button--secondary" style="margin-top:1rem; font-size:0.85rem;"><?= __('destinations.read_article') ?></a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>