<?php
/**
 * Barre de navigation principale avec sous-menus déroulants + sélecteur locale
 * Règle 1, 3, 4, 6 : MVC, 0 style inline, Responsive, < 200 lignes
 */
$_currentLang     = \Core\Lang::getLocale();
$_currentCurrency = \Core\Currency::getCurrency();
?>
<nav class="c-navbar">
  <div class="l-container c-navbar__inner">
    
    <!-- Logo Officiel Djerba Voyage -->
    <a href="<?= url('/') ?>" class="c-navbar__logo">
      <img src="<?= asset('images/logo.png') ?>" alt="Logo Djerba Voyage" class="c-navbar__logo-img">
      <div class="c-navbar__logo-text">
        <span class="c-navbar__brand-main">DJERBA<span class="c-navbar__brand-accent">VOYAGE</span></span>
        <span class="c-navbar__brand-sub">Guide 2026</span>
      </div>
    </a>
    
    <!-- Menu Principal avec Sous-Menus Groupés -->
    <ul class="c-navbar__menu" id="mainNavMenu">
      <li class="c-navbar__item">
        <a href="<?= url('/') ?>" class="c-navbar__link"><?= __('nav.home') ?></a>
      </li>

      <!-- Sous-menu 1 : Découvrir Djerba -->
      <li class="c-navbar__item c-navbar__item--has-dropdown">
        <button type="button" class="c-navbar__link" aria-expanded="false">
          <span><?= __('nav.discover') ?></span>
          <i class="fi fi-rr-angle-small-down c-navbar__dropdown-arrow"></i>
        </button>
        <div class="c-navbar__dropdown-menu c-navbar__dropdown-menu--wide">
          <a href="<?= url('/activites') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--amber">
              <i class="fi fi-rr-map-marker"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.activities') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.activities.desc') ?></span>
            </span>
          </a>
          <a href="<?= url('/itineraires') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--sky">
              <i class="fi fi-rr-route"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.itineraries') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.itineraries.desc') ?></span>
            </span>
          </a>
          <a href="<?= url('/hotels-restaurants') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--terracotta">
              <i class="fi fi-rr-hotel"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.hotels') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.hotels.desc') ?></span>
            </span>
          </a>
          <a href="<?= url('/gastronomie') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--emerald">
              <i class="fi fi-rr-restaurant"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.gastronomy') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.gastronomy.desc') ?></span>
            </span>
          </a>
          <a href="<?= url('/transports') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--sky">
              <i class="fi fi-rr-taxi"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.transport') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.transport.desc') ?></span>
            </span>
          </a>
          <a href="<?= url('/meteo-climat') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--amber">
              <i class="fi fi-rr-sun"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.weather') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.weather.desc') ?></span>
            </span>
          </a>
          <a href="<?= url('/guide') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--emerald">
              <i class="fi fi-rr-book-alt"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.guides') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.guides.desc') ?></span>
            </span>
          </a>
        </div>
      </li>


      <!-- Sous-menu 2 : Pass & Services VIP -->
      <li class="c-navbar__item c-navbar__item--has-dropdown">
        <button type="button" class="c-navbar__link c-navbar__link--highlight" aria-expanded="false">
          <i class="fi fi-rr-sparkles"></i>
          <span><?= __('nav.pass') ?></span>
          <i class="fi fi-rr-angle-small-down c-navbar__dropdown-arrow"></i>
        </button>
        <div class="c-navbar__dropdown-menu c-navbar__dropdown-menu--wide">
          <a href="<?= url('/services') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--terracotta">
              <i class="fi fi-rr-ticket"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.pass_activities') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.pass_activities.desc') ?></span>
            </span>
            <span class="c-navbar__dropdown-tag">-15%</span>
          </a>
          <a href="<?= url('/concierge') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--amber">
              <i class="fi fi-rr-crown"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.concierge') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.concierge.desc') ?></span>
            </span>
            <span class="c-navbar__dropdown-tag">VIP</span>
          </a>
          <a href="<?= url('/shop') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--emerald">
              <i class="fi fi-rr-shopping-bag"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.shop') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.shop.desc') ?></span>
            </span>
          </a>
          <button type="button" data-open-modal="personalizedPdfModal" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--sky">
              <i class="fi fi-rr-magic-wand"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.pdf_personalized') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.pdf_personalized.desc') ?></span>
            </span>
            <span class="c-navbar__dropdown-tag"><?= __('nav.souvenir_tag') ?></span>
          </button>
        </div>
      </li>

      <!-- Sous-menu 3 : Club & Infos -->
      <li class="c-navbar__item c-navbar__item--has-dropdown">
        <button type="button" class="c-navbar__link" aria-expanded="false">
          <span><?= __('nav.club') ?></span>
          <i class="fi fi-rr-angle-small-down c-navbar__dropdown-arrow"></i>
        </button>
        <div class="c-navbar__dropdown-menu c-navbar__dropdown-menu--right">
          <a href="<?= url('/newsletter') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--amber">
              <i class="fi fi-rr-crown"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.vip_circle') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.vip_circle.desc') ?></span>
            </span>
            <span class="c-navbar__dropdown-tag">-10%</span>
          </a>
          <a href="<?= url('/avis') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--emerald">
              <i class="fi fi-rr-star"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.reviews') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.reviews.desc') ?></span>
            </span>
            <span class="c-navbar__dropdown-tag">4.9/5</span>
          </a>
          <a href="<?= url('/faq') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--sky">
              <i class="fi fi-rr-interrogation"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.faq') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.faq.desc') ?></span>
            </span>
          </a>
          <a href="<?= url('/a-propos') ?>" class="c-navbar__dropdown-item">
            <span class="c-navbar__dropdown-icon c-navbar__dropdown-icon--terracotta">
              <i class="fi fi-rr-info"></i>
            </span>
            <span class="c-navbar__dropdown-info">
              <span class="c-navbar__dropdown-title"><?= __('nav.about') ?></span>
              <span class="c-navbar__dropdown-desc"><?= __('nav.about.desc') ?></span>
            </span>
          </a>
        </div>
      </li>

      <!-- Lien Contact Direct -->
      <li class="c-navbar__item">
        <a href="<?= url('/contact') ?>" class="c-navbar__link">
          <i class="fi fi-rr-envelope"></i>
          <span><?= __('nav.contact') ?></span>
        </a>
      </li>

      <!-- Sélecteur Langue & Devise Mobile (Intégré dans le tiroir mobile) -->
      <?php require __DIR__ . '/locale_switcher_mobile.php'; ?>
    </ul>

    <!-- Groupe Actions : Sélecteur Locale Desktop + Bouton CTA (Desktop) + Toggle Burger Mobile -->
    <div class="c-navbar__actions">

      <!-- Sélecteur Langue + Devise Desktop -->
      <?php require __DIR__ . '/locale_switcher.php'; ?>

      <button data-open-modal="personalizedPdfModal" class="c-navbar__cta">
        <i class="fi fi-rr-star"></i>
        <span class="cta-label-full"><?= __('nav.pdf_cta') ?> (<?= money(9.90) ?>)</span>
        <span class="cta-label-short"><?= money(9.90) ?></span>
      </button>

      <button class="c-navbar__toggle" id="mobileMenuToggle" aria-label="<?= __('nav.menu_label') ?>">
        <i class="fi fi-rr-menu-burger"></i>
      </button>
    </div>

  </div>
</nav>