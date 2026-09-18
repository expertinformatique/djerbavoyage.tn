<?php
/**
 * Sélecteur de locale Mobile (Langue & Devise intégré au Drawer)
 */
$_currentLang     = \Core\Lang::getLocale();
$_currentCurrency = \Core\Currency::getCurrency();
?>
<li class="c-navbar__item c-navbar__item--mobile-locale">
  <div class="c-mobile-locale">
    <form method="POST" action="<?= url('/api/locale') ?>" class="c-mobile-locale__form">
      <!-- Choix Langue -->
      <div class="c-mobile-locale__section">
        <div class="c-mobile-locale__title">
          <i class="fi fi-rr-globe"></i>
          <span><?= __('locale.language') ?></span>
        </div>
        <div class="c-mobile-locale__grid">
          <?php foreach (\Core\Lang::supported() as $_lng): ?>
          <button type="submit" name="lang" value="<?= $_lng ?>"
            class="c-mobile-locale__btn <?= $_lng === $_currentLang ? 'is-active' : '' ?>"
            aria-label="<?= \Core\Lang::nativeName($_lng) ?>">
            <span class="c-mobile-locale__flag"><?= \Core\Lang::flag($_lng) ?></span>
            <span class="c-mobile-locale__name"><?= \Core\Lang::nativeName($_lng) ?></span>
          </button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Choix Devise -->
      <div class="c-mobile-locale__section">
        <div class="c-mobile-locale__title">
          <i class="fi fi-rr-coins"></i>
          <span><?= __('locale.currency') ?></span>
        </div>
        <div class="c-mobile-locale__grid">
          <?php foreach (\Core\Currency::supported() as $_cur): ?>
          <button type="submit" name="currency" value="<?= $_cur ?>"
            class="c-mobile-locale__btn <?= $_cur === $_currentCurrency ? 'is-active' : '' ?>"
            aria-label="<?= $_cur ?>">
            <span class="c-mobile-locale__symbol"><?= \Core\Currency::getSymbol($_cur) ?></span>
            <span class="c-mobile-locale__code"><?= $_cur ?></span>
          </button>
          <?php endforeach; ?>
        </div>
      </div>
    </form>
  </div>
</li>
