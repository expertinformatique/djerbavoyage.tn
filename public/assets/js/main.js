import { ModalManager } from './modules/ModalManager.js';
import { TabsManager } from './modules/TabsManager.js';
import { ScrollAnimate } from './modules/ScrollAnimate.js';
import { initCardActions } from './modules/card-actions.js';
import { initLocaleSwitcher } from './modules/locale-switcher.js';

document.addEventListener('DOMContentLoaded', () => {
  TabsManager.init();
  ScrollAnimate.init();
  initCardActions();
  initLocaleSwitcher();

  // Mobile Menu Toggle, Accordion & Auto-close
  const toggleBtn = document.getElementById('mobileMenuToggle');
  const menu = document.getElementById('mainNavMenu');

  if (toggleBtn && menu) {
    const toggleIcon = toggleBtn.querySelector('i');
    const dropdownItems = menu.querySelectorAll('.c-navbar__item--has-dropdown');

    const closeMobileMenu = () => {
      menu.classList.remove('is-active');
      toggleBtn.classList.remove('is-active');
      if (toggleIcon) toggleIcon.className = 'fi fi-rr-menu-burger';
      document.body.classList.remove('u-no-scroll');
      dropdownItems.forEach((item) => {
        item.classList.remove('is-open');
        item.querySelector('.c-navbar__link')?.setAttribute('aria-expanded', 'false');
      });
    };

    const toggleMobileMenu = () => {
      const isOpen = menu.classList.toggle('is-active');
      toggleBtn.classList.toggle('is-active', isOpen);
      if (toggleIcon) {
        toggleIcon.className = isOpen ? 'fi fi-rr-cross' : 'fi fi-rr-menu-burger';
      }
      document.body.classList.toggle('u-no-scroll', isOpen);
    };

    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleMobileMenu();
    });

    // Dropdown Toggles on Mobile / Touch
    dropdownItems.forEach((item) => {
      const trigger = item.querySelector('.c-navbar__link');
      if (trigger) {
        trigger.addEventListener('click', (e) => {
          if (window.innerWidth <= 992 || trigger.tagName === 'BUTTON') {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = item.classList.contains('is-open');
            dropdownItems.forEach((other) => {
              if (other !== item) {
                other.classList.remove('is-open');
                other.querySelector('.c-navbar__link')?.setAttribute('aria-expanded', 'false');
              }
            });
            item.classList.toggle('is-open', !isOpen);
            trigger.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
          }
        });
      }
    });

    // Close menu when tapping direct links or dropdown items
    menu.querySelectorAll('a.c-navbar__link, .c-navbar__dropdown-item').forEach((link) => {
      link.addEventListener('click', closeMobileMenu);
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!toggleBtn.contains(e.target) && !menu.contains(e.target)) {
        closeMobileMenu();
      }
    });
  }

  document.querySelectorAll('[data-open-modal]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const modalId = btn.getAttribute('data-open-modal');
      ModalManager.open(modalId);
    });
  });

  document.querySelectorAll('[data-close-modal]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const modalId = btn.getAttribute('data-close-modal');
      ModalManager.close(modalId);
    });
  });
});
