/**
 * Module Djerba Services Builder & Estimator
 */
export class ServicesBuilder {
  constructor() {
    this.selected = {};
    this.includeAirport = false;
    this.paymentMode = 'full'; // 'full' or 'deposit'
    this.init();
  }

  init() {
    this.bindCategoryFilters();
    this.bindServiceCards();
    this.bindAirportToggle();
    this.bindPaymentModeSelector();
    this.bindCheckoutForm();
    this.recalculate();
  }

  bindCategoryFilters() {
    const chips = document.querySelectorAll('.c-filter-chip');
    const cards = document.querySelectorAll('.c-service-card');

    chips.forEach(chip => {
      chip.addEventListener('click', () => {
        chips.forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        const cat = chip.dataset.category;

        cards.forEach(card => {
          if (cat === 'all' || card.dataset.category === cat) {
            card.style.display = 'flex';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  }

  bindServiceCards() {
    document.querySelectorAll('.c-service-card').forEach(card => {
      const id = card.dataset.id;
      const price = parseFloat(card.dataset.price || '0');
      const category = card.dataset.category;
      const name = card.dataset.name;
      const addBtn = card.querySelector('.js-add-service-btn');
      const qtyVal = card.querySelector('.js-qty-val');
      const plusBtn = card.querySelector('.js-qty-plus');
      const minusBtn = card.querySelector('.js-qty-minus');

      if (addBtn) {
        addBtn.addEventListener('click', () => {
          if (this.selected[id]) {
            delete this.selected[id];
            card.classList.remove('is-selected');
            addBtn.innerHTML = '<i class="fi fi-rr-plus"></i> Ajouter au Pass';
            addBtn.className = 'c-button c-button--outline js-add-service-btn';
          } else {
            const qty = parseInt(qtyVal?.textContent || '1', 10);
            this.selected[id] = { service_id: id, unit_price: price, quantity: qty, category, name };
            card.classList.add('is-selected');
            addBtn.innerHTML = '<i class="fi fi-rr-check"></i> Dans mon Pass';
            addBtn.className = 'c-button c-button--primary js-add-service-btn';
          }
          this.recalculate();
        });
      }

      if (plusBtn && minusBtn && qtyVal) {
        plusBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          let current = parseInt(qtyVal.textContent, 10) + 1;
          qtyVal.textContent = current;
          if (this.selected[id]) {
            this.selected[id].quantity = current;
            this.recalculate();
          }
        });

        minusBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          let current = Math.max(1, parseInt(qtyVal.textContent, 10) - 1);
          qtyVal.textContent = current;
          if (this.selected[id]) {
            this.selected[id].quantity = current;
            this.recalculate();
          }
        });
      }
    });
  }

  bindAirportToggle() {
    const toggle = document.getElementById('airportTransferToggle');
    if (toggle) {
      toggle.addEventListener('change', (e) => {
        this.includeAirport = e.target.checked;
        this.recalculate();
      });
    }
  }

  bindPaymentModeSelector() {
    const modeCards = document.querySelectorAll('.c-payment-mode-card');
    modeCards.forEach(card => {
      card.addEventListener('click', () => {
        modeCards.forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        this.paymentMode = card.dataset.mode;
        this.recalculate();
      });
    });
  }

  async recalculate() {
    const items = Object.values(this.selected);

    try {
      const res = await fetch('/api/services/estimate', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          items,
          include_airport: this.includeAirport,
          payment_mode: this.paymentMode
        })
      });

      if (!res.ok) throw new Error('Erreur estimation');
      const data = await res.json();
      this.updateUI(data);
    } catch (err) {
      console.error('[Estimator Error]', err);
    }
  }

  updateUI(data) {
    const subtotalEl = document.getElementById('passSubtotal');
    const discountEl = document.getElementById('passDiscount');
    const totalEl = document.getElementById('passTotal');
    const depositNoticeEl = document.getElementById('passDepositNotice');
    const gaugeBar = document.getElementById('discountGaugeBar');
    const nextTierEl = document.getElementById('nextTierMessage');
    const airportBadgeEl = document.getElementById('airportPerkBadge');
    const airportPriceEl = document.getElementById('airportPerkPrice');
    const itemsListEl = document.getElementById('selectedItemsList');
    const checkoutBtn = document.getElementById('openCheckoutModalBtn');

    if (subtotalEl) subtotalEl.textContent = data.subtotal.toFixed(2) + ' €';
    if (discountEl) {
      discountEl.textContent = data.discount_amount > 0 ? '-' + data.discount_amount.toFixed(2) + ' € (' + data.discount_percent + '%)' : '0.00 €';
    }
    if (totalEl) totalEl.textContent = data.amount_to_pay_now.toFixed(2) + ' €';

    if (depositNoticeEl) {
      if (this.paymentMode === 'deposit') {
        depositNoticeEl.style.display = 'block';
        depositNoticeEl.innerHTML = `<i class="fi fi-rr-info"></i> Acompte de 30% réglé aujourd'hui. Reste à payer sur place : <strong>${data.remaining_balance.toFixed(2)} €</strong>`;
      } else {
        depositNoticeEl.style.display = 'none';
      }
    }

    if (nextTierEl) nextTierEl.textContent = data.next_tier_message;

    if (gaugeBar) {
      const pct = Math.min(100, Math.round((data.items_count / 4) * 100));
      gaugeBar.style.width = pct + '%';
    }

    if (airportBadgeEl && airportPriceEl) {
      if (data.airport_transfer_free) {
        airportBadgeEl.textContent = 'OFFERT';
        airportBadgeEl.className = 'badge badge--gold';
        airportPriceEl.innerHTML = '<del style="color:#94A3B8; font-size:0.85rem;">35 €</del> <strong>0 €</strong>';
      } else {
        airportBadgeEl.textContent = 'En Option';
        airportBadgeEl.className = 'badge badge--sea';
        airportPriceEl.textContent = '35 €';
      }
    }

    if (itemsListEl) {
      const items = Object.values(this.selected);
      if (items.length === 0) {
        itemsListEl.innerHTML = '<p style="color:#94A3B8; font-size:0.85rem; font-style:italic;">Aucune activité ajoutée pour le moment. Cliquez sur "Ajouter au Pass" pour composer votre séjour.</p>';
      } else {
        itemsListEl.innerHTML = items.map(item => `
          <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.85rem; padding:0.4rem 0; border-bottom:1px dashed #E2E8F0;">
            <span><strong>${item.quantity}x</strong> ${item.name}</span>
            <span style="font-weight:700; color:var(--clr-sea-900);">${(item.unit_price * item.quantity).toFixed(2)} €</span>
          </div>
        `).join('');
      }
    }

    if (checkoutBtn) {
      checkoutBtn.disabled = data.items_count === 0;
      checkoutBtn.style.opacity = data.items_count === 0 ? '0.5' : '1';
    }
  }

  bindCheckoutForm() {
    const form = document.getElementById('passCheckoutForm');
    const errorEl = document.getElementById('checkoutFormError');
    const submitBtn = document.getElementById('submitPassOrderBtn');

    if (form) {
      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('clientEmail')?.value;
        const name = document.getElementById('clientName')?.value;
        const phone = document.getElementById('clientPhone')?.value;

        if (!email) {
          if (errorEl) errorEl.textContent = 'Veuillez saisir votre adresse email.';
          return;
        }

        if (submitBtn) {
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<i class="fi fi-rr-spinner fi-spin"></i> Traitement sécurisé...';
        }

        try {
          const res = await fetch('/api/services/checkout', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
              email,
              name,
              phone,
              items: Object.values(this.selected),
              include_airport: this.includeAirport,
              payment_mode: this.paymentMode
            })
          });

          const data = await res.json();
          if (!res.ok || data.error) {
            throw new Error(data.error || 'Erreur lors de la réservation.');
          }

          window.location.href = data.redirect_url;
        } catch (err) {
          if (errorEl) errorEl.textContent = err.message;
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fi fi-rr-lock"></i> Valider & Bloquer mon Tarif';
          }
        }
      });
    }
  }
}
