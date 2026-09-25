<?php
/**
 * Sélecteur de locale Desktop (Langue & Devise)
 */
$_currentLang     = \Core\Lang::getLocale();
$_currentCurrency = \Core\Currency::getCurrency();
?>
<div class="c-locale-switcher c-locale-switcher--desktop" id="localeSwitcher">
  <button type="button" class="c-locale-switcher__trigger" id="localeTrigger" aria-expanded="false" aria-haspopup="true">
    <span class="c-locale-switcher__flag"><?= \Core\Lang::flag($_currentLang) ?></span>
    <span class="c-locale-switcher__code"><?= strtoupper($_currentLang) ?></span>
    <span class="c-locale-switcher__sep">|</span>
    <span class="c-locale-switcher__currency-sym"><?= \Core\Currency::getSymbol() ?></span>
    <i class="fi fi-rr-angle-small-down arrow"></i>
  </button>

  <div class="c-locale-switcher__dropdown" id="localeDropdown" role="dialog" aria-label="<?= __('locale.language') ?> & <?= __('locale.currency') ?>">
    <form method="POST" action="<?= url('/api/locale') ?>" id="localeForm">

      <!-- Section Langue -->
      <p class="c-locale-switcher__section-title"><?= __('locale.language') ?></p>
      <div class="c-locale-switcher__options--lang" id="langOptions">
        <?php foreach (\Core\Lang::supported() as $_lng): ?>
        <button type="button"
          class="c-locale-switcher__option--lang <?= $_lng === $_currentLang ? 'is-active' : '' ?>"
          data-field="lang"
          data-value="<?= $_lng ?>"
          data-label="<?= strtoupper($_lng) ?>">
          <span class="lang-flag"><?= \Core\Lang::flag($_lng) ?></span>
          <span class="lang-name"><?= \Core\Lang::nativeName($_lng) ?></span>
        </button>
        <?php endforeach; ?>
      </div>

      <div class="c-locale-switcher__divider"></div>

      <!-- Section Devise -->
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

      <input type="hidden" name="lang" id="localeLang" value="<?= $_currentLang ?>">
      <input type="hidden" name="currency" id="localeCurrency" value="<?= $_currentCurrency ?>">

      <button type="submit" class="c-locale-switcher__apply" id="localeApplyBtn">
        <i class="fi fi-rr-check"></i> <?= __('locale.apply') ?>
      </button>
    </form>
  </div>
</div>
