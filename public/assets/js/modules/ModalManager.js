export class ModalManager {
  static activeModals = [];
  static baseZIndex = 1000;

  static open(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    const level = this.activeModals.length;
    modal.style.zIndex = this.baseZIndex + (level * 10);
    modal.classList.add('is-open');
    this.activeModals.push(modal);
  }

  static close(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    modal.classList.remove('is-open');
    this.activeModals = this.activeModals.filter(m => m !== modal);
  }
}
PHP,Description:
