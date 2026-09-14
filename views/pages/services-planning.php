<!-- Planning & Espace Voyageur Post-Paiement -->
<section class="c-hero" style="background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.95) 100%), url('<?= asset('images/hero.png') ?>') center/cover no-repeat; padding: 3rem 1rem;">
  <div class="l-container" style="text-align: center; max-width: 800px;">
    <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10B981; color: #10B981; display: inline-flex; align-items: center; gap: 8px; padding: 6px 16px; border-radius: 50px; font-weight: 700; margin-bottom: 1rem; font-size: 0.88rem;">
      <i class="fi fi-rr-check-circle"></i> Réservation Confirmée & Places Bloquées
    </div>
    <h1 class="c-hero__title" style="color: #FFFFFF; margin-bottom: 0.75rem; font-size: 2rem;">
      Mon Séjour à Djerba : Accueil & Planning
    </h1>
    <p class="c-hero__subtitle" style="color: var(--clr-sand-100); margin-bottom: 1.5rem; font-size: 0.95rem;">
      Pass Référence : <strong style="color: #F59E0B;"><?= e($order->orderNumber) ?></strong> • Client : <?= e($order->customerEmail) ?>
    </p>

    <!-- Quick action links -->
    <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
      <a href="<?= url('/pass/voucher/' . $order->orderNumber) ?>" target="_blank" class="c-button c-button--outline" style="background: rgba(255,255,255,0.1); color: #fff; border-color: rgba(255,255,255,0.3); padding: 0.6rem 1.2rem; font-size: 0.88rem;">
        <i class="fi fi-rr-document-signed"></i> Bon d'Échange & QR Code
      </a>
      <a href="https://wa.me/21698000000?text=Bonjour,%20je%20suis%20le%20titulaire%20du%20Pass%20<?= urlencode($order->orderNumber) ?>" target="_blank" class="c-button c-button--primary" style="background: #25D366; border-color: #25D366; padding: 0.6rem 1.2rem; font-size: 0.88rem;">
        <i class="fi fi-rr-comment-alt"></i> Concierge WhatsApp 24/7
      </a>
    </div>
  </div>
</section>

<div class="l-container" style="margin: 3.5rem auto 5rem auto; max-width: 960px;">

  <!-- Notification Toast -->
  <div id="planningNotification" style="display: none; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 600; text-align: center;"></div>

  <!-- Section 1 : Accueil Aéroport Djerba-Zarzis -->
  <div class="c-card" style="margin-bottom: 3rem; border: 2px solid var(--clr-sea-400); background: #FFFFFF;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem;">
      <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 46px; height: 46px; border-radius: 12px; background: rgba(0, 119, 182, 0.1); display: flex; align-items: center; justify-content: center; color: var(--clr-sea-600); font-size: 1.4rem;">
          <i class="fi fi-rr-plane-arrival"></i>
        </div>
        <div>
          <h2 style="font-size: 1.25rem; font-family: var(--font-heading); color: var(--clr-dark-900); margin-bottom: 2px;">
            Accueil VIP & Chauffeur Privé Aéroport (DJE)
          </h2>
          <p class="text-muted" style="font-size: 0.85rem;">
            Votre chauffeur privé vous attendra à la sortie du terminal avec une pancarte à votre nom.
          </p>
        </div>
      </div>
      <span class="badge badge--gold" id="airportStatusBadge">
        <?= ($transfer && $transfer->flightNumber) ? '✓ Vol Enregistré' : 'À Compléter' ?>
      </span>
    </div>

    <form id="airportTransferForm" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
      <input type="hidden" name="order_id" value="<?= $order->id ?>">
      
      <div>
        <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px; color: var(--clr-dark-800);">N° de Vol</label>
        <input type="text" name="flight_number" value="<?= e($transfer->flightNumber ?? '') ?>" placeholder="Ex: TU 720 / BJ 515" class="input" style="width: 100%;">
      </div>

      <div>
        <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px; color: var(--clr-dark-800);">Compagnie Aérienne</label>
        <input type="text" name="airline" value="<?= e($transfer->airline ?? '') ?>" placeholder="Ex: Nouvelair / Tunisair" class="input" style="width: 100%;">
      </div>

      <div>
        <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px; color: var(--clr-dark-800);">Date d'Atterrissage</label>
        <input type="date" name="arrival_date" value="<?= e($transfer->arrivalDate ?? '') ?>" class="input" style="width: 100%;">
      </div>

      <div>
        <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px; color: var(--clr-dark-800);">Heure d'Atterrissage</label>
        <input type="time" name="arrival_time" value="<?= e($transfer->arrivalTime ?? '') ?>" class="input" style="width: 100%;">
      </div>

      <div>
        <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px; color: var(--clr-dark-800);">Lieu de Dépose (Hôtel ou Villa)</label>
        <input type="text" name="dropoff_location" value="<?= e($transfer->dropoffLocation ?? '') ?>" placeholder="Ex: Hôtel Hasdrubal / Dar Erriadh" class="input" style="width: 100%;">
      </div>

      <div>
        <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px; color: var(--clr-dark-800);">Téléphone / WhatsApp</label>
        <input type="tel" name="phone_whatsapp" value="<?= e($transfer->phoneWhatsapp ?? '') ?>" placeholder="+33 6 ..." class="input" style="width: 100%;">
      </div>

      <div style="grid-column: 1 / -1; display: flex; justify-content: flex-end; margin-top: 0.5rem;">
        <button type="submit" class="c-button c-button--primary" style="padding: 0.65rem 1.4rem; font-size: 0.9rem;">
          <i class="fi fi-rr-check"></i> Enregistrer mes Détails d'Arrivée
        </button>
      </div>
    </form>
  </div>

  <!-- Section 2 : Planificateur d'Activités Réservées -->
  <div>
    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.5rem;">
      <div>
        <h2 style="font-size: 1.4rem; font-family: var(--font-heading); color: var(--clr-dark-900);">
          Planification de vos Activités (Déjà Payées)
        </h2>
        <p class="text-muted" style="font-size: 0.88rem;">
          Choisissez le jour et le créneau idéal pour chaque expérience. Modifiable gratuitement jusqu'à 24h avant.
        </p>
      </div>
      <span class="badge badge--sea">
        <?= count($bookings) ?> Activité(s) dans votre Pass
      </span>
    </div>

    <?php if (empty($bookings)): ?>
      <div class="c-card" style="text-align: center; padding: 3rem;">
        <p class="text-muted">Aucune activité enregistrée sur ce pass.</p>
        <a href="<?= url('/services') ?>" class="c-button c-button--primary" style="margin-top: 1rem;">
          Découvrir les Activités
        </a>
      </div>
    <?php else: ?>
      <?php foreach ($bookings as $booking): ?>
        <?php $srv = $booking->service; ?>
        <div class="c-schedule-card <?= $booking->scheduledDate ? 'is-confirmed' : 'is-waiting' ?>" id="bookingCard-<?= $booking->id ?>">
          <div style="display: flex; gap: 1.25rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
            
            <div style="display: flex; gap: 1rem; align-items: center;">
              <img src="<?= asset('images/' . ($srv && $srv->imageUrl ? $srv->imageUrl : 'sidi_mahres.png')) ?>" alt="<?= e($srv ? $srv->name : 'Activité') ?>" style="width: 75px; height: 75px; object-fit: cover; border-radius: 12px;">
              <div>
                <div style="font-size: 0.78rem; font-weight: 700; color: var(--clr-sea-600); text-transform: uppercase;">
                  <?= e($srv ? $srv->locationLabel : 'Djerba') ?> • <?= e($srv ? $srv->durationLabel : '') ?>
                </div>
                <h3 style="font-size: 1.1rem; color: var(--clr-dark-900); margin: 2px 0;">
                  <?= e($srv ? $srv->name : 'Activité Locale') ?>
                </h3>
                <div style="font-size: 0.82rem; color: var(--clr-gray-500);">
                  <?= $booking->guestsCount ?> personne(s) • Total réglé : <strong><?= number_format($booking->totalPrice, 2) ?> €</strong>
                </div>
              </div>
            </div>

            <!-- Schedule Form per activity -->
            <form class="js-booking-schedule-form" data-id="<?= $booking->id ?>" style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
              <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 700; margin-bottom: 2px; color: var(--clr-dark-800);">Date choisie</label>
                <input type="date" name="date" required value="<?= e($booking->scheduledDate ?? '') ?>" class="input" style="padding: 0.4rem 0.6rem; font-size: 0.85rem;">
              </div>

              <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 700; margin-bottom: 2px; color: var(--clr-dark-800);">Créneau horaire</label>
                <select name="time" required class="input" style="padding: 0.4rem 0.6rem; font-size: 0.85rem;">
                  <option value="">Sélectionnez un créneau</option>
                  <option value="09:00" <?= ($booking->scheduledTime === '09:00') ? 'selected' : '' ?>>09h00 (Matinée calme)</option>
                  <option value="11:30" <?= ($booking->scheduledTime === '11:30') ? 'selected' : '' ?>>11h30 (Midi)</option>
                  <option value="15:00" <?= ($booking->scheduledTime === '15:00') ? 'selected' : '' ?>>15h00 (Après-midi)</option>
                  <option value="17:30" <?= ($booking->scheduledTime === '17:30') ? 'selected' : '' ?>>17h30 (Sunset / Coucher de soleil)</option>
                  <option value="19:30" <?= ($booking->scheduledTime === '19:30') ? 'selected' : '' ?>>19h30 (Soirée dîner)</option>
                </select>
              </div>

              <div style="align-self: flex-end;">
                <button type="submit" class="c-button c-button--primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                  <i class="fi fi-rr-check"></i> Valider
                </button>
              </div>
            </form>

          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- Reassurance Footer Banner -->
  <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 1.5rem; margin-top: 3rem; text-align: center;">
    <h4 style="font-size: 1rem; color: var(--clr-dark-900); margin-bottom: 0.4rem;">
      <i class="fi fi-rr-umbrella" style="color: var(--clr-terracotta-500);"></i> Garantie Flexibilité & Météo
    </h4>
    <p style="font-size: 0.85rem; color: var(--clr-gray-500); max-width: 650px; margin: 0 auto;">
      Si le vent ou l'état de la mer ne permet pas la pratique sécurisée de votre activité nautique, un report prioritaire ou un remboursement immédiat est garanti sans frais par votre conciergerie locale.
    </p>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const notif = document.getElementById('planningNotification');

  function showNotif(msg, isSuccess = true) {
    if (!notif) return;
    notif.style.display = 'block';
    notif.style.background = isSuccess ? '#D1FAE5' : '#FEE2E2';
    notif.style.color = isSuccess ? '#065F46' : '#991B1B';
    notif.textContent = msg;
    setTimeout(() => { notif.style.display = 'none'; }, 4000);
  }

  // Airport Form AJAX
  const airportForm = document.getElementById('airportTransferForm');
  if (airportForm) {
    airportForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(airportForm);
      const data = Object.fromEntries(formData.entries());

      try {
        const res = await fetch('/api/services/update-airport', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data)
        });
        const result = await res.json();
        if (result.success) {
          showNotif('Vos informations d\'accueil aéroport ont bien été enregistrées !');
          document.getElementById('airportStatusBadge').textContent = '✓ Vol Enregistré';
        } else {
          showNotif(result.error || 'Erreur lors de l\'enregistrement', false);
        }
      } catch (err) {
        showNotif('Erreur réseau. Veuillez réessayer.', false);
      }
    });
  }

  // Bookings Schedule Forms AJAX
  document.querySelectorAll('.js-booking-schedule-form').forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const id = form.dataset.id;
      const date = form.querySelector('input[name="date"]').value;
      const time = form.querySelector('select[name="time"]').value;

      try {
        const res = await fetch('/api/services/update-schedule', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ booking_id: id, date, time })
        });
        const result = await res.json();
        if (result.success) {
          showNotif('Créneau mis à jour avec succès !');
          const card = document.getElementById('bookingCard-' + id);
          if (card) {
            card.classList.remove('is-waiting');
            card.classList.add('is-confirmed');
          }
        } else {
          showNotif(result.error || 'Erreur lors de la mise à jour', false);
        }
      } catch (err) {
        showNotif('Erreur réseau.', false);
      }
    });
  });
});
</script>
