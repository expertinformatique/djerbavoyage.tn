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
    </ul>

    <!-- Groupe Actions : Sélecteur Locale + Bouton CTA + Toggle Burger Mobile -->
    <div class="c-navbar__actions">

      <!-- Sélecteur Langue + Devise -->
      <div class="c-locale-switcher" id="localeSwitcher">
        <button type="button" class="c-locale-switcher__trigger" id="localeTrigger" aria-expanded="false" aria-haspopup="true">
          <span class="c-locale-switcher__flag"><?= \Core\Lang::flag($_currentLang) ?></span>
          <span class="c-locale-switcher__code"><?= strtoupper($_currentLang) ?></span>
          <span class="c-locale-switcher__sep">|</span>
          <span class="c-locale-switcher__currency-sym"><?= \Core\Currency::getSymbol() ?></span>
          <i class="fi fi-rr-angle-small-down arrow"></i>
        </button>

        <div class="c-locale-switcher__dropdown" id="localeDropdown" role="dialog" aria-label="<?= __('locale.language') ?> & <?= __('locale.currency') ?>">
          <form method="POST" action="<?= url('/api/locale') ?>" id="localeForm">

            <!-- Section Langue : 1 option par ligne -->
            <p class="c-locale-switcher__section-title"><?= __('locale.language') ?></p>
            <div class="c-locale-switcher__options--lang" id="langOptions">
              <?php foreach (\Core\Lang::supported() as $_lng): ?>
              <button type="button"
                class="c-locale-switcher__option--lang <?= $_lng === $_currentLang ? 'is-active' : '' ?>"
                data-field="lang"
                data-value="<?= $_lng ?>"
                data-flag="<?= \Core\Lang::flag($_lng) ?>"
                data-label="<?= strtoupper($_lng) ?>">
                <span class="lang-flag"><?= \Core\Lang::flag($_lng) ?></span>
                <span class="lang-name"><?= \Core\Lang::nativeName($_lng) ?></span>
              </button>
              <?php endforeach; ?>
            </div>

            <div class="c-locale-switcher__divider"></div>

            <!-- Section Devise : 3 colonnes compactes -->
            <p class="c-locale-switcher__section-title"><?= __('locale.currency') ?></p>
            <div class="c-locale-switcher__options--currency" id="currencyOptions">
              <?php foreach (\Core\Currency::supported() as $_cur): ?>
              <button type="button"
                class="c-locale-switcher__option--currency <?= $_cur === $_currentCurrency ? 'is-active' : '' ?>"
                data-field="currency"
                data-value="<?= $_cur ?>"
                data-symbol="<?= \Core\Currency::getSymbol($_cur) ?>"
                data-label="<?= $_cur ?>">
                <span class="cur-symbol"><?= \Core\Currency::getSymbol($_cur) ?></span>
                <span class="cur-code"><?= $_cur ?></span>
              </button>
              <?php endforeach; ?>
            </div>

            <input type="hidden" name="lang"     id="localeLang"     value="<?= $_currentLang ?>">
            <input type="hidden" name="currency" id="localeCurrency" value="<?= $_currentCurrency ?>">

            <button type="submit" class="c-locale-switcher__apply" id="localeApplyBtn">
              <i class="fi fi-rr-check"></i> <?= __('locale.apply') ?>
            </button>
          </form>
        </div>
      </div>


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

<script>
/* Locale Switcher — Toggle + sélection + mise à jour du trigger */
(function () {
  'use strict';

  var switcher    = document.getElementById('localeSwitcher');
  var trigger     = document.getElementById('localeTrigger');
  var dropdown    = document.getElementById('localeDropdown');
  var langInput   = document.getElementById('localeLang');
  var curInput    = document.getElementById('localeCurrency');
  var applyBtn    = document.getElementById('localeApplyBtn');

  if (!trigger || !dropdown) return;

  /* Éléments du trigger à mettre à jour dynamiquement */
  var triggerFlag    = trigger.querySelector('.c-locale-switcher__flag');
  var triggerCode    = trigger.querySelector('.c-locale-switcher__code');
  var triggerSymbol  = trigger.querySelector('.c-locale-switcher__currency-sym');

  /* ── Ouvrir / fermer ─────────────────────────── */
  trigger.addEventListener('click', function (e) {
    e.stopPropagation();
    var isOpen = switcher.classList.toggle('c-locale-switcher--open');
    trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });

  document.addEventListener('click', function (e) {
    if (!switcher.contains(e.target)) {
      switcher.classList.remove('c-locale-switcher--open');
      trigger.setAttribute('aria-expanded', 'false');
    }
  });

  /* Fermer sur Escape */
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      switcher.classList.remove('c-locale-switcher--open');
      trigger.setAttribute('aria-expanded', 'false');
      trigger.focus();
    }
  });

  /* ── Sélection d'une option ──────────────────── */
  dropdown.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-field]');
    if (!btn) return;

    var field = btn.dataset.field;
    var value = btn.dataset.value;

    /* Mettre à jour la classe active dans le groupe */
    dropdown.querySelectorAll('[data-field="' + field + '"]').forEach(function (b) {
      b.classList.remove('is-active');
    });
    btn.classList.add('is-active');

    /* Mettre à jour le champ hidden */
    if (field === 'lang') {
      langInput.value = value;
      /* Mise à jour visuelle du trigger */
      if (triggerFlag && btn.dataset.flag) triggerFlag.textContent = btn.dataset.flag;
      if (triggerCode && btn.dataset.label) triggerCode.textContent = btn.dataset.label;
    }
    if (field === 'currency') {
      curInput.value = value;
      /* Mise à jour visuelle du trigger */
      if (triggerSymbol && btn.dataset.symbol) triggerSymbol.textContent = btn.dataset.symbol;
    }
  });

  /* ── Clic hors du bouton submit dans le formulaire ── */
  applyBtn && applyBtn.addEventListener('click', function () {
    /* Soumission naturelle du formulaire */
  });

})();
</script>