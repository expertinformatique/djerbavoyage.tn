<!-- Hero Section Configurateur de Pass -->
<section class="c-hero" style="background: linear-gradient(180deg, rgba(15, 23, 42, 0.82) 0%, rgba(15, 23, 42, 0.95) 100%), url('<?= asset('images/hero.png') ?>') center/cover no-repeat;">
  <div class="l-container" data-animate style="text-align: center; max-width: 860px;">
    <div style="background: rgba(245, 158, 11, 0.18); border: 1px solid var(--clr-terracotta-500); color: #F59E0B; display: inline-flex; align-items: center; gap: 8px; padding: 6px 18px; border-radius: 50px; font-weight: 700; margin-bottom: 1.25rem; font-size: 0.88rem;">
      <i class="fi fi-rr-sparkles"></i> Djerba Experience Pass 2026 — Tout-en-Un
    </div>
    <h1 class="c-hero__title" style="color: #FFFFFF; margin-bottom: 1rem;">
      Composez Votre Séjour & Vos Activités à Djerba
    </h1>
    <p class="c-hero__subtitle" style="color: var(--clr-sand-100); margin-bottom: 2rem;">
      Combinez vos activités favorites, profitez d'une remise dégressive jusqu'à <strong>-15%</strong> et débloquez l'<strong>Accueil Aéroport VIP OFFERT</strong>. Bloquez votre tarif dès aujourd'hui et planifiez vos dates en toute sérénité !
    </p>

    <!-- Trust Badges Bar -->
    <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 1rem; color: #fff; font-size: 0.85rem; font-weight: 600;">
      <span style="background: rgba(255,255,255,0.12); backdrop-filter: blur(8px); padding: 6px 14px; border-radius: 30px; display: inline-flex; align-items: center; gap: 6px;">
        <i class="fi fi-rr-shield-check" style="color:#10B981;"></i> Annulation Gratuite 24h
      </span>
      <span style="background: rgba(255,255,255,0.12); backdrop-filter: blur(8px); padding: 6px 14px; border-radius: 30px; display: inline-flex; align-items: center; gap: 6px;">
        <i class="fi fi-rr-calendar-clock" style="color:#38BDF8;"></i> Flexi-Planning (dates modifiables)
      </span>
      <span style="background: rgba(255,255,255,0.12); backdrop-filter: blur(8px); padding: 6px 14px; border-radius: 30px; display: inline-flex; align-items: center; gap: 6px;">
        <i class="fi fi-rr-cloud-sun" style="color:#F59E0B;"></i> Garantie Météo Sérénité
      </span>
      <span style="background: rgba(255,255,255,0.12); backdrop-filter: blur(8px); padding: 6px 14px; border-radius: 30px; display: inline-flex; align-items: center; gap: 6px;">
        <i class="fi fi-rr-plane-arrival" style="color:#F43F5E;"></i> Navette Aéroport Offerte
      </span>
    </div>
  </div>
</section>

<!-- Main Builder Layout -->
<div class="l-container" style="margin: 3.5rem auto 5rem auto;">

  <!-- Category Filter Chips -->
  <div class="c-filter-chips" style="margin-bottom: 2rem;">
    <button class="c-filter-chip active" data-category="all">
      <i class="fi fi-rr-apps"></i> Toutes les Expériences
    </button>
    <button class="c-filter-chip" data-category="nautisme">
      <i class="fi fi-rr-water"></i> Base Nautique & Kitesurf
    </button>
    <button class="c-filter-chip" data-category="quad">
      <i class="fi fi-rr-motorcycle"></i> Quads & Buggy
    </button>
    <button class="c-filter-chip" data-category="chameau">
      <i class="fi fi-rr-paw"></i> Dromadaire & Plage
    </button>
    <button class="c-filter-chip" data-category="sahara">
      <i class="fi fi-rr-sun"></i> Excursion Sahara 4x4
    </button>
    <button class="c-filter-chip" data-category="diner">
      <i class="fi fi-rr-restaurant"></i> Dîner Bédouin
    </button>
    <button class="c-filter-chip" data-category="hotel">
      <i class="fi fi-rr-bed"></i> Hôtels 4*
    </button>
    <button class="c-filter-chip" data-category="maison">
      <i class="fi fi-rr-home"></i> Maisons d'Hôtes / Menzel
    </button>
  </div>

  <div class="c-builder-layout">
    
    <!-- Left Column: Services Catalog -->
    <div>
      <div class="l-grid-cards" style="grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));">
        <?php foreach ($services as $service): ?>
          <?php if ($service->category === 'transfert') continue; ?>
          <article class="c-service-card" data-id="<?= $service->id ?>" data-price="<?= $service->priceEur ?>" data-category="<?= e($service->category) ?>" data-name="<?= e($service->name) ?>">
            <div class="c-service-card__thumb">
              <img src="<?= asset('images/' . ($service->imageUrl ?: 'sidi_mahres.png')) ?>" alt="<?= e($service->name) ?>" class="c-service-card__img">
              <?php if ($service->badge): ?>
                <span class="c-service-card__badge"><?= e($service->badge) ?></span>
              <?php endif; ?>
              <span style="position: absolute; top: 12px; right: 12px; background: rgba(15,23,42,0.85); color: #F59E0B; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.8rem; backdrop-filter: blur(6px); display: inline-flex; align-items: center; gap: 4px;">
                <i class="fi fi-rr-star"></i> 4.9
              </span>
            </div>
            
            <div class="c-service-card__body">
              <div class="c-service-card__meta">
                <span><i class="fi fi-rr-marker"></i> <?= e($service->locationLabel) ?></span>
                <span><i class="fi fi-rr-clock"></i> <?= e($service->durationLabel) ?></span>
                <span style="color: #10B981; font-weight: 700; margin-left: auto; display: inline-flex; align-items: center; gap: 4px;">
                  <i class="fi fi-rr-check-circle"></i> Vérifié
                </span>
              </div>
              <h3 class="heading-3" style="font-size: 1.1rem; margin-bottom: 0.4rem; color: var(--clr-dark-900);">
                <?= e($service->name) ?>
              </h3>
              <p class="text-muted" style="font-size: 0.88rem; line-height: 1.45; margin-bottom: 1.25rem; flex: 1;">
                <?= e($service->shortDescription) ?>
              </p>

              <div style="border-top: 1px solid #F1F5F9; padding-top: 0.9rem; display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                <div>
                  <div style="font-weight: 800; font-size: 1.25rem; color: var(--clr-sea-900);">
                    <?= number_format($service->priceEur, 2) ?> €
                  </div>
                  <div style="font-size: 0.75rem; color: var(--clr-gray-500);"><?= e($service->unitLabel) ?></div>
                </div>

                <div style="display: flex; align-items: center; gap: 0.6rem;">
                  <div class="c-service-card__qty-control">
                    <button type="button" class="c-service-card__qty-btn js-qty-minus">-</button>
                    <span class="js-qty-val" style="font-size: 0.85rem; font-weight: 700; min-width: 14px; text-align: center;">1</span>
                    <button type="button" class="c-service-card__qty-btn js-qty-plus">+</button>
                  </div>
                  <button type="button" class="c-button c-button--outline js-add-service-btn" style="padding: 0.5rem 0.9rem; font-size: 0.82rem;">
                    <i class="fi fi-rr-plus"></i> Ajouter
                  </button>
                </div>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Right Column: Sticky Pass Estimator -->
    <aside>
      <div class="c-pass-summary">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
          <h3 style="font-size: 1.2rem; font-family: var(--font-heading); color: var(--clr-dark-900); display: flex; align-items: center; gap: 0.5rem;">
            <i class="fi fi-rr-receipt" style="color: var(--clr-sea-600);"></i> Mon Pass Séjour
          </h3>
          <span class="badge badge--sea" id="packBadgeTitle">Tarif Standard</span>
        </div>

        <!-- Incentive Progress Gauge -->
        <div style="margin-bottom: 1.25rem;">
          <div style="display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: 700; color: var(--clr-gray-500);">
            <span>Remise Pack</span>
            <span id="nextTierMessage" style="color: var(--clr-terracotta-500);">Ajoutez des activités pour économiser !</span>
          </div>
          <div class="c-discount-gauge">
            <div class="c-discount-gauge__bar" id="discountGaugeBar" style="width: 0%;"></div>
          </div>
        </div>

        <!-- Selected Items Container -->
        <div id="selectedItemsList" style="max-height: 220px; overflow-y: auto; margin-bottom: 1.25rem; padding-right: 4px;">
          <!-- Injecté dynamiquement par JS -->
        </div>

        <!-- Airport Transfer Perk Box -->
        <div class="c-free-perk-box">
          <input type="checkbox" id="airportTransferToggle" checked style="width: 18px; height: 18px; margin-top: 2px; accent-color: var(--clr-sea-600); cursor: pointer;">
          <div style="flex: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <strong style="font-size: 0.88rem; color: var(--clr-dark-900);">Accueil & Navette Aéroport (DJE)</strong>
              <span id="airportPerkPrice" style="font-weight: 700; font-size: 0.95rem; color: var(--clr-sea-900);">35 €</span>
            </div>
            <p style="font-size: 0.78rem; color: var(--clr-gray-500); margin-top: 2px; line-height: 1.35;">
              Chauffeur privé à la sortie avec pancarte nominative, eau fraîche et carte SIM locale.
            </p>
            <span class="badge badge--gold" id="airportPerkBadge" style="margin-top: 4px; display: inline-block;">En Option</span>
          </div>
        </div>

        <!-- Breakdown Calculations -->
        <div style="border-top: 1px solid #E2E8F0; padding-top: 1rem; margin-top: 0.5rem; display: flex; flex-direction: column; gap: 0.4rem; font-size: 0.9rem;">
          <div style="display: flex; justify-content: space-between; color: var(--clr-gray-500);">
            <span>Sous-total activités :</span>
            <strong id="passSubtotal" style="color: var(--clr-dark-800);">0.00 €</strong>
          </div>
          <div style="display: flex; justify-content: space-between; color: #10B981;">
            <span>Économie Pack :</span>
            <strong id="passDiscount">0.00 €</strong>
          </div>
          <div style="display: flex; justify-content: space-between; align-items: baseline; margin-top: 0.5rem; padding-top: 0.6rem; border-top: 2px solid #E2E8F0;">
            <span style="font-weight: 800; font-size: 1.1rem; color: var(--clr-dark-900);">Total Net :</span>
            <span id="passTotal" style="font-weight: 800; font-size: 1.5rem; color: var(--clr-sea-900);">0.00 €</span>
          </div>
        </div>

        <div id="passDepositNotice" style="display: none; font-size: 0.78rem; color: #0284C7; background: #E0F2FE; padding: 6px 10px; border-radius: 8px; margin-top: 0.5rem;"></div>

        <!-- CTA Action Button -->
        <button type="button" class="c-button c-button--primary" id="openCheckoutModalBtn" data-open-modal="passCheckoutModal" style="width: 100%; margin-top: 1.25rem; padding: 0.85rem; font-size: 0.98rem; justify-content: center;" disabled>
          <i class="fi fi-rr-check-circle"></i> Réserver & Bloquer mon Tarif
        </button>

        <p style="text-align: center; font-size: 0.78rem; color: var(--clr-gray-500); margin-top: 0.75rem;">
          <i class="fi fi-rr-lock" style="color: #10B981;"></i> Paiement 100% sécurisé Stripe • Planification libre après paiement
        </p>
      </div>
    </aside>

  </div>
</div>

<!-- Modal Checkout Pass -->
<div class="c-modal" id="passCheckoutModal" role="dialog" aria-hidden="true">
  <div class="c-modal__backdrop" data-close-modal="passCheckoutModal"></div>
  <div class="c-modal__dialog" style="max-width: 540px;">
    <div class="c-modal__header">
      <h3 style="font-size: 1.25rem; font-family: var(--font-heading); color: var(--clr-dark-900); display: flex; align-items: center; gap: 8px;">
        <i class="fi fi-rr-shopping-bag" style="color: var(--clr-sea-600);"></i> Finaliser ma Réservation
      </h3>
      <button class="c-modal__close" data-close-modal="passCheckoutModal">&times;</button>
    </div>

    <form id="passCheckoutForm" class="c-modal__body" style="padding: 1.5rem;">
      <div id="checkoutFormError" style="color: #EF4444; font-size: 0.85rem; margin-bottom: 1rem; font-weight: 600;"></div>

      <!-- Payment Mode Toggle -->
      <label style="display: block; font-size: 0.88rem; font-weight: 700; color: var(--clr-dark-900); margin-bottom: 0.5rem;">
        Choisissez votre formule de paiement :
      </label>
      <div class="c-payment-mode-grid">
        <div class="c-payment-mode-card active" data-mode="full">
          <div style="font-weight: 700; color: var(--clr-sea-900); font-size: 0.95rem;">Paiement Intégral</div>
          <div style="font-size: 0.75rem; color: var(--clr-gray-500); margin-top: 2px;">Remise maximale appliquée</div>
        </div>
        <div class="c-payment-mode-card" data-mode="deposit">
          <div style="font-weight: 700; color: var(--clr-sea-900); font-size: 0.95rem;">Acompte 30%</div>
          <div style="font-size: 0.75rem; color: var(--clr-gray-500); margin-top: 2px;">Bloque les places, solde sur place</div>
        </div>
      </div>

      <!-- Contact Fields -->
      <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
        <div>
          <label for="clientName" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; color: var(--clr-dark-800);">Prénom & Nom</label>
          <input type="text" id="clientName" required class="input" placeholder="Ex: Thomas Dubois" style="width: 100%;">
        </div>
        <div>
          <label for="clientEmail" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; color: var(--clr-dark-800);">Adresse Email (pour vos vouchers)</label>
          <input type="email" id="clientEmail" required class="input" placeholder="thomas@example.com" style="width: 100%;">
        </div>
        <div>
          <label for="clientPhone" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; color: var(--clr-dark-800);">Numéro Téléphone / WhatsApp</label>
          <input type="tel" id="clientPhone" class="input" placeholder="+33 6 12 34 56 78 (pour le chauffeur)" style="width: 100%;">
        </div>
      </div>

      <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 0.85rem; margin-top: 1.25rem; font-size: 0.82rem; color: var(--clr-gray-500); line-height: 1.4;">
        <i class="fi fi-rr-info" style="color: var(--clr-sea-600);"></i> <strong>Étape suivante :</strong> Dès validation, vous accédez directement à votre planning pour choisir la date et l'heure de chacune de vos activités et renseigner votre vol.
      </div>

      <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 0.75rem;">
        <button type="button" class="c-button c-button--outline" data-close-modal="passCheckoutModal">Annuler</button>
        <button type="submit" class="c-button c-button--primary" id="submitPassOrderBtn">
          <i class="fi fi-rr-lock"></i> Valider & Bloquer mon Tarif
        </button>
      </div>
    </form>
  </div>
</div>

<script type="module">
  import { ServicesBuilder } from '<?= asset('js/modules/services-builder.js') ?>';
  import { ModalManager } from '<?= asset('js/modules/ModalManager.js') ?>';

  window.ModalManager = ModalManager;
  window.APP_BASE_URL = '<?= url('') ?>';

  document.addEventListener('DOMContentLoaded', () => {
    new ServicesBuilder({ baseUrl: '<?= url('') ?>' });
  });
</script>
