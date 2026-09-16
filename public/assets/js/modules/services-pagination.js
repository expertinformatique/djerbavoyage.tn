/**
 * Module Pagination Catalogue d'Expériences
 * Règle 6 : Modulaire et découplé
 */
export class ServicesPagination {
  constructor(options = {}) {
    this.itemsPerPage = options.itemsPerPage || 6;
    this.currentPage = 1;
    this.containerId = options.containerId || 'servicesPagination';
    this.onPageChange = options.onPageChange || null;
  }

  reset() {
    this.currentPage = 1;
  }

  paginate(cards, currentCategory) {
    const container = document.getElementById(this.containerId);
    const matching = cards.filter(c => currentCategory === 'all' || c.dataset.category === currentCategory);
    const isAll = currentCategory === 'all';
    const totalItems = matching.length;
    const totalPages = isAll ? Math.ceil(totalItems / this.itemsPerPage) : 1;

    if (!isAll || totalPages <= 1) {
      cards.forEach(card => {
        const show = currentCategory === 'all' || card.dataset.category === currentCategory;
        card.style.display = show ? 'flex' : 'none';
      });
      if (container) container.innerHTML = '';
      return;
    }

    const start = (this.currentPage - 1) * this.itemsPerPage;
    const end = start + this.itemsPerPage;

    cards.forEach(card => card.style.display = 'none');
    matching.forEach((card, idx) => {
      if (idx >= start && idx < end) {
        card.style.display = 'flex';
      }
    });

    if (container) {
      this.renderControls(container, totalPages, totalItems, start + 1, Math.min(end, totalItems));
    }
  }

  renderControls(container, totalPages, totalItems, startCount, endCount) {
    let html = `
      <div class="c-pagination__info">
        Affichage de <strong>${startCount}</strong> à <strong>${endCount}</strong> sur <strong>${totalItems}</strong> expériences
      </div>
      <div class="c-pagination__buttons">
        <button type="button" class="c-pagination__btn ${this.currentPage === 1 ? 'is-disabled' : ''}" data-page="${this.currentPage - 1}" ${this.currentPage === 1 ? 'disabled' : ''}>
          <i class="fi fi-rr-angle-small-left"></i> Précédent
        </button>
    `;

    for (let p = 1; p <= totalPages; p++) {
      html += `
        <button type="button" class="c-pagination__btn c-pagination__num ${p === this.currentPage ? 'is-active' : ''}" data-page="${p}">
          ${p}
        </button>
      `;
    }

    html += `
        <button type="button" class="c-pagination__btn ${this.currentPage === totalPages ? 'is-disabled' : ''}" data-page="${this.currentPage + 1}" ${this.currentPage === totalPages ? 'disabled' : ''}>
          Suivant <i class="fi fi-rr-angle-small-right"></i>
        </button>
      </div>
    `;

    container.innerHTML = html;

    container.querySelectorAll('.c-pagination__btn[data-page]').forEach(btn => {
      btn.addEventListener('click', () => {
        const target = parseInt(btn.dataset.page, 10);
        if (target >= 1 && target <= totalPages && target !== this.currentPage) {
          this.currentPage = target;
          if (this.onPageChange) this.onPageChange();
        }
      });
    });
  }
}
