import { ServicesPagination } from './services-pagination.js';

/**
 * Module Djerba Services Builder & Estimator
 * Version 3.0 - Panier Permanent avec Persistence LocalStorage
 */
export class ServicesBuilder {
  constructor(options = {}) {
    this.selected = {};
    this.includeAirport = true;
    this.paymentMode = 'full'; // 'full' or 'deposit'
    this.baseUrl = options.baseUrl || (window.APP_BASE_URL || '');
    this.currentCategory = 'all';
    this.pagination = new ServicesPagination({
      itemsPerPage: 6,
      onPageChange: () => this.applyFilter()
    });
    this.loadStateFromStorage();
    this.init();
  }

  loadStateFromStorage() {
    try {
      const saved = localStorage.getItem('dv_pass_cart');
      if (saved) {
        const data = JSON.parse(saved);
        if (data && typeof data === 'object') {
          this.selected = data.selected || {};
          if (typeof data.includeAirport === 'boolean') {
            this.includeAirport = data.includeAirport;
          }
          if (data.paymentMode === 'full' || data.paymentMode === 'deposit') {
            this.paymentMode = data.paymentMode;
          }
        }
      }
    } catch (e) {
      console.warn('[PassCart] Erreur chargement storage', e);
    }
  }

  saveStateToStorage() {
    try {
      localStorage.setItem('dv_pass_cart', JSON.stringify({
        selected: this.selected,
        includeAirport: this.includeAirport,
        paymentMode: this.paymentMode
      }));
    } catch (e) {
      console.warn('[PassCart] Erreur sauvegarde storage', e);
    }
  }

  clearStorage() {
    try {
      localStorage.removeItem('dv_pass_cart');
    } catch (e) {}
  }

  syncDOMWithState() {
    // Synchroniser les cartes de services
    document.querySelectorAll('.c-service-card').forEach(card => {
      const id = card.dataset.id;
      const addBtn = card.querySelector('.js-add-service-btn');
      const qtyVal = card.querySelector('.js-qty-val');

      if (this.selected[id]) {
        card.classList.add('is-selected');
        if (addBtn) {
          addBtn.innerHTML = '<i class="fi fi-rr-check"></i> Dans mon Pass';
          addBtn.className = 'c-button c-button--primary js-add-service-btn';
        }
        if (qtyVal) {
          qtyVal.textContent = this.selected[id].quantity || 1;
        }
      } else {
        card.classList.remove('is-selected');
        if (addBtn) {
          addBtn.innerHTML = '<i class="fi fi-rr-plus"></i> Ajouter au Pass';
          addBtn.className = 'c-button c-button--outline js-add-service-btn';
        }
      }
    });

    // Synchroniser le toggle navette aéroport
    const toggle = document.getElementById('airportTransferToggle');
    if (toggle) {
      toggle.checked = this.includeAirport;
    }

    // Synchroniser les cartes de mode de paiement
    const modeCards = document.querySelectorAll('.c-payment-mode-card');
    modeCards.forEach(card => {
      if (card.dataset.mode === this.paymentMode) {
        card.classList.add('active');
      } else {
        card.classList.remove('active');
      }
    });
  }

  init() {
    this.bindCategoryFilters();
    this.bindServiceCards();
    this.bindAirportToggle();
    this.bindPaymentModeSelector();
    this.bindCheckoutForm();
    this.bindCheckoutModalTrigger();
    this.syncDOMWithState();
    this.applyFilter();
    this.recalculate();
  }

  applyFilter() {
    const cards = Array.from(document.querySelectorAll('.c-service-card'));
    this.pagination.paginate(cards, this.currentCategory);
    this.syncDOMWithState();
  }

  bindCategoryFilters() {
    const chips = document.querySelectorAll('.c-filter-chip');

    chips.forEach(chip => {
      chip.addEventListener('click', () => {
        chips.forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        this.currentCategory = chip.dataset.category;
        this.pagination.reset();
        this.applyFilter();
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
        addBtn.addEventListener('click', (e) => {
          e.stopPropagation();
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

  bindCheckoutModalTrigger() {
    const btn = document.getElementById('openCheckoutModalBtn');
    if (btn) {
      btn.addEventListener('click', () => {
        if (!btn.disabled && window.ModalManager) {
          window.ModalManager.open('passCheckoutModal');
        }
      });
    }
  }

  async recalculate() {
    this.saveStateToStorage();
    const items = Object.values(this.selected);

    try {
      const endpoint = (this.baseUrl.replace(/\/$/, '') + '/api/services/estimate');
      const res = await fetch(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          items,
          include_airport: this.includeAirport,
          payment_mode: this.paymentMode
        })
      });

      if (!res.ok) throw new Error('Erreur estimation HTTP ' + res.status);
      const data = await res.json();
      this.updateUI(data);
    } catch (err) {
      console.warn('[Estimator API fallback to local calculation]', err);
      const localData = this.calculateLocalEstimate(items);
      this.updateUI(localData);
    }
  }

  calculateLocalEstimate(items) {
    let subtotal = 0;
    let totalItemsCount = 0;
    items.forEach(item => {
      subtotal += item.unit_price * item.quantity;
      totalItemsCount += item.quantity;
    });

    let discountPercent = 0;
    if (totalItemsCount >= 3) {
      discountPercent = 15;
    } else if (totalItemsCount === 2) {
      discountPercent = 10;
    }

    const discountAmount = subtotal * (discountPercent / 100);
    const subtotalAfterDiscount = subtotal - discountAmount;

    const isAirportFree = totalItemsCount >= 3;
    let airportCost = 0;
    if (this.includeAirport && !isAirportFree) {
      airportCost = 35.00;
    }

    const grandTotal = subtotalAfterDiscount + airportCost;
    const amountToPayNow = this.paymentMode === 'deposit' ? (grandTotal * 0.30) : grandTotal;
    const remainingBalance = this.paymentMode === 'deposit' ? (grandTotal * 0.70) : 0;

    let nextTierMsg = "Ajoutez des activités pour économiser !";
    if (totalItemsCount === 0) {
      nextTierMsg = "Sélectionnez 2 activités (-10%) ou 3+ (-15% + Navette Offerte)";
    } else if (totalItemsCount === 1) {
      nextTierMsg = "Encore 1 activité pour débloquer -10% de remise !";
    } else if (totalItemsCount === 2) {
      nextTierMsg = "Encore 1 activité pour passer à -15% et Navette Aéroport OFFERTE !";
    } else {
      nextTierMsg = "🎉 Remise Maximale -15% & Accueil Aéroport Offert !";
    }

    let packLabel = "Pass Découverte";
    if (totalItemsCount >= 3) packLabel = "Pass VIP Sur-Mesure (-15%)";
    else if (totalItemsCount === 2) packLabel = "Pass Duo (-10%)";

    return {
      subtotal,
      discount_percent: discountPercent,
      discount_amount: discountAmount,
      subtotal_after_discount: subtotalAfterDiscount,
      airport_transfer_free: isAirportFree,
      airport_cost: airportCost,
      grand_total: grandTotal,
      amount_to_pay_now: amountToPayNow,
      remaining_balance: remainingBalance,
      next_tier_message: nextTierMsg,
      pack_label: packLabel,
      items_count: totalItemsCount
    };
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
    const packBadgeTitle = document.getElementById('packBadgeTitle');

    if (subtotalEl) subtotalEl.textContent = data.subtotal.toFixed(2) + ' €';
    if (discountEl) {
      discountEl.textContent = data.discount_amount > 0 ? '-' + data.discount_amount.toFixed(2) + ' € (' + data.discount_percent + '%)' : '0.00 €';
    }
    if (totalEl) totalEl.textContent = data.amount_to_pay_now.toFixed(2) + ' €';

    if (packBadgeTitle && data.pack_label) {
      packBadgeTitle.textContent = data.pack_label;
    }

    if (depositNoticeEl) {
      if (this.paymentMode === 'deposit' && data.remaining_balance > 0) {
        depositNoticeEl.style.display = 'block';
        depositNoticeEl.innerHTML = `<i class="fi fi-rr-info"></i> Acompte de 30% réglé aujourd'hui. Reste à payer sur place : <strong>${data.remaining_balance.toFixed(2)} €</strong>`;
      } else {
        depositNoticeEl.style.display = 'none';
      }
    }

    if (nextTierEl) nextTierEl.textContent = data.next_tier_message;

    if (gaugeBar) {
      const pct = Math.min(100, Math.round((data.items_count / 3) * 100));
      gaugeBar.style.width = pct + '%';
    }

    if (airportBadgeEl && airportPriceEl) {
      if (data.airport_transfer_free) {
        airportBadgeEl.textContent = 'OFFERT';
        airportBadgeEl.className = 'badge badge--gold';
        airportPriceEl.innerHTML = '<del style="color:#94A3B8; font-size:0.85rem;">35 €</del> <strong style="color:#10B981;">0 €</strong>';
      } else {
        airportBadgeEl.textContent = 'En Option (35€)';
        airportBadgeEl.className = 'badge badge--sea';
        airportPriceEl.textContent = '35 €';
      }
    }

    if (itemsListEl) {
      const items = Object.values(this.selected);
      if (items.length === 0) {
        itemsListEl.innerHTML = `
          <div style="text-align:center; padding: 1.5rem 0; color:#94A3B8;">
            <i class="fi fi-rr-shopping-bag" style="font-size:2rem; margin-bottom:0.5rem; display:block; opacity:0.6;"></i>
            <p style="font-size:0.88rem; margin:0;">Votre Pass est actuellement vide.</p>
            <p style="font-size:0.78rem; margin-top:4px;">Cliquez sur <strong>"Ajouter au Pass"</strong> pour choisir vos activités.</p>
          </div>
        `;
      } else {
        itemsListEl.innerHTML = `
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 0.5rem; padding-bottom: 0.35rem; border-bottom: 1px solid #E2E8F0;">
            <span style="font-size:0.75rem; text-transform:uppercase; font-weight:700; color:#64748B;">Activités dans mon pass</span>
            <button type="button" class="js-clear-cart-btn" style="background:none; border:none; color:#EF4444; font-size:0.75rem; font-weight:600; cursor:pointer; padding:0; display:inline-flex; align-items:center; gap:3px;">
              <i class="fi fi-rr-trash"></i> Vider
            </button>
          </div>
        ` + items.map(item => `
          <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.88rem; padding:0.5rem 0; border-bottom:1px dashed #E2E8F0;">
            <span><strong style="color:var(--clr-sea-900);">${item.quantity}x</strong> ${item.name}</span>
            <span style="font-weight:700; color:var(--clr-sea-900);">${(item.unit_price * item.quantity).toFixed(2)} €</span>
          </div>
        `).join('');

        const clearBtn = itemsListEl.querySelector('.js-clear-cart-btn');
        if (clearBtn) {
          clearBtn.addEventListener('click', () => {
            this.selected = {};
            this.clearStorage();
            this.syncDOMWithState();
            this.recalculate();
          });
        }
      }
    }

    if (checkoutBtn) {
      const hasItems = data.items_count > 0;
      checkoutBtn.disabled = !hasItems;
      checkoutBtn.style.opacity = hasItems ? '1' : '0.5';
      checkoutBtn.style.cursor = hasItems ? 'pointer' : 'not-allowed';
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
          const endpoint = (this.baseUrl.replace(/\/$/, '') + '/api/services/checkout');
          const res = await fetch(endpoint, {
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

          this.clearStorage();
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
