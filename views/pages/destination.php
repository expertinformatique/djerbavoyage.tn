<div class="l-container" style="margin:3rem auto;">
  <div style="margin-bottom:2rem;">
    <h1 style="font-family:var(--font-heading); font-size:2.4rem; color:var(--clr-dark-900);"><?= e($destination['name_fr']) ?></h1>
    <p style="font-size:1.1rem; color:#555;"><?= e($destination['description_fr']) ?></p>
  </div>

  <div class="c-tabs">
    <div class="c-tabs__header">
      <button class="c-tabs__button is-active" data-tab="hotels"><i class="fi fi-rr-hotel"></i> Hôtels & Ryads</button>
      <button class="c-tabs__button" data-tab="excursions"><i class="fi fi-rr-compass"></i> Excursions & Activités</button>
      <button class="c-tabs__button" data-tab="articles"><i class="fi fi-rr-document"></i> Guides & Articles</button>
    </div>

    <div class="c-tabs__content is-active" id="tab-hotels">
      <div style="background:#fff; padding:2rem; border-radius:12px; border:1px solid var(--clr-sand-200);">
        <h3>Sélection d'Hôtels à <?= e($destination['name_fr']) ?></h3>
        <p style="margin-bottom:1rem; color:#666;">Réservez votre hébergement vérifié au meilleur prix garanti via Booking.com :</p>
        <a href="https://www.booking.com/city/tn/houmt-souk.html?aid=<?= e($settings->get('booking_partner_id')) ?>" target="_blank" rel="sponsored noopener" class="c-button c-button--secondary">
          Voir les Hôtels sur Booking.com <i class="fi fi-rr-arrow-up-right"></i>
        </a>
      </div>
    </div>

    <div class="c-tabs__content" id="tab-excursions">
      <div style="background:#fff; padding:2rem; border-radius:12px; border:1px solid var(--clr-sand-200);">
        <h3>Excursions Populaires à <?= e($destination['name_fr']) ?></h3>
        <p style="margin-bottom:1rem; color:#666;">Réservez vos visites guidées et activités nautiques via GetYourGuide :</p>
        <a href="https://www.getyourguide.com/djerba-l32386/?partner_id=<?= e($settings->get('getyourguide_partner_id')) ?>" target="_blank" rel="sponsored noopener" class="c-button c-button--primary">
          Réserver une Excursion GetYourGuide <i class="fi fi-rr-arrow-up-right"></i>
        </a>
      </div>
    </div>

    <div class="c-tabs__content" id="tab-articles">
      <div class="l-grid-cards">
        <?php foreach ($articles as $art): ?>
          <article class="c-card">
            <div class="c-card__content">
              <h3 class="c-card__title"><?= e($art->titleFr) ?></h3>
              <a href="<?= url('/guide/' . e($art->slug)) ?>" class="c-button c-button--secondary" style="margin-top:1rem;">Lire l'article</a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>