export class AjaxTable {
  constructor(tableId, endpoint) {
    this.table = document.getElementById(tableId);
    this.endpoint = endpoint;
    if (this.table) this.init();
  }

  init() {
    this.tbody = this.table.querySelector('tbody');
    this.pagination = this.table.querySelector('.c-pagination');
  }

  async load(page = 1) {
    try {
      const res = await fetch(`${this.endpoint}?page=${page}`);
      const data = await res.json();
      if (data.success) {
        this.renderRows(data.data);
      }
    } catch (err) {
      console.error('Erreur AjaxTable:', err);
    }
  }

  renderRows(items) {
    if (!this.tbody) return;
    this.tbody.innerHTML = items.map(item => `
      <tr>
        <td>${item.id}</td>
        <td>${item.customer_email || item.title_fr}</td>
        <td>${item.total_amount ? item.total_amount + ' €' : '-'}</td>
        <td><span class="c-badge">${item.status}</span></td>
      </tr>
    `).join('');
  }
}

