export class TabsManager {
  static init(containerSelector = '.c-tabs') {
    document.querySelectorAll(containerSelector).forEach(container => {
      const buttons = container.querySelectorAll('.c-tabs__button');
      const contents = container.querySelectorAll('.c-tabs__content');

      buttons.forEach(btn => {
        btn.addEventListener('click', () => {
          const target = btn.getAttribute('data-tab');

          buttons.forEach(b => b.classList.remove('is-active'));
          contents.forEach(c => c.classList.remove('is-active'));

          btn.classList.add('is-active');
          const targetEl = container.querySelector('#tab-' + target);
          if (targetEl) targetEl.classList.add('is-active');
        });
      });
    });
  }
}
PHP,Description:
