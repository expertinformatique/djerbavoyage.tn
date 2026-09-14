import { ModalManager } from './ModalManager.js';

export class ExitIntent {
  static init(modalId = 'exit-intent-modal') {
    let triggered = false;
    document.addEventListener('mouseleave', (e) => {
      if (e.clientY <= 0 && !triggered) {
        triggered = true;
        ModalManager.open(modalId);
      }
    });
  }
}

