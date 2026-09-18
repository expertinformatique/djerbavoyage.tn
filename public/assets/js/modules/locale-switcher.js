/**
 * Module Locale Switcher (Desktop Dropdown & Mobile Selectors)
 */
export function initLocaleSwitcher() {
  const switcher = document.getElementById('localeSwitcher');
  const trigger = document.getElementById('localeTrigger');
  const dropdown = document.getElementById('localeDropdown');
  const langInput = document.getElementById('localeLang');
  const curInput = document.getElementById('localeCurrency');
  const applyBtn = document.getElementById('localeApplyBtn');

  if (!trigger || !dropdown || !switcher) return;

  const triggerFlag = trigger.querySelector('.c-locale-switcher__flag');
  const triggerCode = trigger.querySelector('.c-locale-switcher__code');
  const triggerSymbol = trigger.querySelector('.c-locale-switcher__currency-sym');

  // Ouvrir / fermer le menu desktop
  trigger.addEventListener('click', (e) => {
    e.stopPropagation();
    const isOpen = switcher.classList.toggle('c-locale-switcher--open');
    trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });

  document.addEventListener('click', (e) => {
    if (!switcher.contains(e.target)) {
      switcher.classList.remove('c-locale-switcher--open');
      trigger.setAttribute('aria-expanded', 'false');
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      switcher.classList.remove('c-locale-switcher--open');
      trigger.setAttribute('aria-expanded', 'false');
      trigger.focus();
    }
  });

  // Sélection d'options dans le menu desktop
  dropdown.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-field]');
    if (!btn) return;

    const field = btn.dataset.field;
    const value = btn.dataset.value;

    dropdown.querySelectorAll(`[data-field="${field}"]`).forEach((b) => {
      b.classList.remove('is-active');
    });
    btn.classList.add('is-active');

    if (field === 'lang') {
      langInput.value = value;
      if (triggerFlag && btn.dataset.flag) triggerFlag.textContent = btn.dataset.flag;
      if (triggerCode && btn.dataset.label) triggerCode.textContent = btn.dataset.label;
    }
    if (field === 'currency') {
      curInput.value = value;
      if (triggerSymbol && btn.dataset.symbol) triggerSymbol.textContent = btn.dataset.symbol;
    }
  });
}
