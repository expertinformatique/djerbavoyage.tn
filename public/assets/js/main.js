import { ModalManager } from './modules/ModalManager.js';
import { TabsManager } from './modules/TabsManager.js';
import { ScrollAnimate } from './modules/ScrollAnimate.js';

document.addEventListener('DOMContentLoaded', () => {
  TabsManager.init();
  ScrollAnimate.init();

  // Mobile Menu Toggle & Auto-close on link click
  const toggleBtn = document.getElementById('mobileMenuToggle');
  const menu = document.getElementById('mainNavMenu');

  if (toggleBtn && menu) {
    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      menu.classList.toggle('is-active');
    });

    // Close menu when tapping links inside menu
    menu.querySelectorAll('.c-navbar__link').forEach(link => {
      link.addEventListener('click', () => {
        menu.classList.remove('is-active');
      });
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!toggleBtn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove('is-active');
      }
    });
  }

  document.querySelectorAll('[data-open-modal]').forEach(btn => {
    btn.addEventListener('click', () => {
      const modalId = btn.getAttribute('data-open-modal');
      ModalManager.open(modalId);
    });
  });

  document.querySelectorAll('[data-close-modal]').forEach(btn => {
    btn.addEventListener('click', () => {
      const modalId = btn.getAttribute('data-close-modal');
      ModalManager.close(modalId);
    });
  });
});
