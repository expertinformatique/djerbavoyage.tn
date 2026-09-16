<?php
/**
 * Modal Grande Popup — Sélection d'Hôtels & Ryads de Charme à Djerba (Booking.com)
 */
$partnerId = $settings->get('booking_partner_id', 'booking_djerba_123');
?>
<div class="c-modal" id="bookingHotelsModal" role="dialog" aria-hidden="true">
  <div class="c-modal__card" style="max-width: 860px; width: 95%; max-height: 90vh; display: flex; flex-direction: column;">
    
    <!-- Modal Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 1rem; border-bottom: 1px solid var(--clr-sand-300);">
      <div>
        <span style="font-size: 0.75rem; font-weight: 700; color: #F59E0B; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 2px;">
          ⭐ PARTENAIRE OFFICIEL BOOKING.COM
        </span>
        <h3 id="bookingModalTitle" style="font-family: var(--font-heading); font-size: 1.3rem; color: var(--clr-dark-900); font-weight: 800; margin: 0;">
          Hôtels, Menzels & Ryads de Charme
        </h3>
      </div>
      <button type="button" class="c-modal__close" onclick="closeBookingHotelsModal()" style="background: none; border: none; font-size: 2rem; cursor: pointer; color: var(--clr-gray-500); line-height: 1;">&times;</button>
    </div>

    <!-- Modal Content Body -->
    <div style="padding: 1.25rem 0; overflow-y: auto; flex: 1;">
      <div style="background: rgba(0, 119, 182, 0.06); border: 1px solid rgba(0, 119, 182, 0.2); border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; items-center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem;">
        <div style="font-size: 0.88rem; color: var(--clr-dark-800); line-height: 1.4;">
          <strong>Meilleur prix garanti :</strong> Annulation gratuite sur la plupart des hébergements et paiement directement sur place.
        </div>
        <span style="font-size: 0.82rem; font-weight: 700; color: #10B981; display: inline-flex; align-items: center; gap: 4px;">
          <i class="fi fi-rr-check-circle"></i> Disponibilités 2026 en Direct
        </span>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.25rem;">
        
        <!-- Hotel 1 -->
        <div class="c-card" style="padding: 0; overflow: hidden; border: 1px solid var(--clr-sand-300); border-radius: 16px; display: flex; flex-direction: column; justify-content: space-between;">
          <div style="height: 140px; position: relative;">
            <img src="<?= asset('images/concierge.png') ?>" alt="Dar Dhiafa Erriadh" style="width: 100%; height: 100%; object-fit: cover;">
            <span style="position: absolute; top: 10px; left: 10px; background: rgba(15,23,42,0.85); color: #fff; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
              Menzel de Charme
            </span>
            <span style="position: absolute; top: 10px; right: 10px; background: #F59E0B; color: #fff; padding: 3px 8px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
              ★ 4.9
            </span>
          </div>
          <div style="padding: 1rem;">
            <h4 style="font-family: var(--font-heading); font-size: 1.05rem; font-weight: 800; color: var(--clr-dark-900); margin-bottom: 4px;">
              Dar Dhiafa - Maisons du Houss
            </h4>
            <p style="font-size: 0.8rem; color: var(--clr-gray-500); margin-bottom: 1rem; line-height: 1.4;">
              Niché à Erriadh (Djerbahood). Cours intérieures avec palmiers et piscines traditionnelles.
            </p>
            <a href="https://www.booking.com/city/tn/houmt-souk.html?aid=<?= e($partnerId) ?>" target="_blank" rel="sponsored noopener" class="c-button c-button--primary" style="width: 100%; justify-content: center; padding: 0.5rem; font-size: 0.82rem; font-weight: 700;">
              Voir sur Booking.com <i class="fi fi-rr-arrow-up-right"></i>
            </a>
          </div>
        </div>

        <!-- Hotel 2 -->
        <div class="c-card" style="padding: 0; overflow: hidden; border: 1px solid var(--clr-sand-300); border-radius: 16px; display: flex; flex-direction: column; justify-content: space-between;">
          <div style="height: 140px; position: relative;">
            <img src="<?= asset('images/sidi_mahres.png') ?>" alt="Radisson Blu Palace Djerba" style="width: 100%; height: 100%; object-fit: cover;">
            <span style="position: absolute; top: 10px; left: 10px; background: rgba(15,23,42,0.85); color: #fff; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
              Resort 5★ Thalasso
            </span>
            <span style="position: absolute; top: 10px; right: 10px; background: #F59E0B; color: #fff; padding: 3px 8px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
              ★ 4.8
            </span>
          </div>
          <div style="padding: 1rem;">
            <h4 style="font-family: var(--font-heading); font-size: 1.05rem; font-weight: 800; color: var(--clr-dark-900); margin-bottom: 4px;">
              Radisson Blu Palace Thalasso
            </h4>
            <p style="font-size: 0.8rem; color: var(--clr-gray-500); margin-bottom: 1rem; line-height: 1.4;">
              Front de mer direct sur la plage de Sidi Mahres. Centre de thalassothérapie d'exception.
            </p>
            <a href="https://www.booking.com/city/tn/houmt-souk.html?aid=<?= e($partnerId) ?>" target="_blank" rel="sponsored noopener" class="c-button c-button--primary" style="width: 100%; justify-content: center; padding: 0.5rem; font-size: 0.82rem; font-weight: 700;">
              Voir sur Booking.com <i class="fi fi-rr-arrow-up-right"></i>
            </a>
          </div>
        </div>

        <!-- Hotel 3 -->
        <div class="c-card" style="padding: 0; overflow: hidden; border: 1px solid var(--clr-sand-300); border-radius: 16px; display: flex; flex-direction: column; justify-content: space-between;">
          <div style="height: 140px; position: relative;">
            <img src="<?= asset('images/aghir.png') ?>" alt="Hasdrubal Prestige Djerba" style="width: 100%; height: 100%; object-fit: cover;">
            <span style="position: absolute; top: 10px; left: 10px; background: rgba(15,23,42,0.85); color: #fff; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
              Luxury Suites & Spa
            </span>
            <span style="position: absolute; top: 10px; right: 10px; background: #F59E0B; color: #fff; padding: 3px 8px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
              ★ 4.95
            </span>
          </div>
          <div style="padding: 1rem;">
            <h4 style="font-family: var(--font-heading); font-size: 1.05rem; font-weight: 800; color: var(--clr-dark-900); margin-bottom: 4px;">
              Hasdrubal Prestige Thalassa
            </h4>
            <p style="font-size: 0.8rem; color: var(--clr-gray-500); margin-bottom: 1rem; line-height: 1.4;">
              Suites d'exception avec lagon à 3 niveaux et spa thermal d'eau de mer de 5000 m².
            </p>
            <a href="https://www.booking.com/city/tn/houmt-souk.html?aid=<?= e($partnerId) ?>" target="_blank" rel="sponsored noopener" class="c-button c-button--primary" style="width: 100%; justify-content: center; padding: 0.5rem; font-size: 0.82rem; font-weight: 700;">
              Voir sur Booking.com <i class="fi fi-rr-arrow-up-right"></i>
            </a>
          </div>
        </div>

      </div>
    </div>

    <!-- Modal Footer -->
    <div style="padding-top: 1rem; border-top: 1px solid var(--clr-sand-300); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
      <button type="button" class="c-button c-button--outline" onclick="closeBookingHotelsModal()" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;">
        Fermer
      </button>
      <a href="https://www.booking.com/city/tn/houmt-souk.html?aid=<?= e($partnerId) ?>" target="_blank" rel="sponsored noopener" class="c-button c-button--secondary" style="font-weight: 800; font-size: 0.88rem;">
        Consulter tous les Hôtels sur Booking.com <i class="fi fi-rr-arrow-up-right"></i>
      </a>
    </div>

  </div>
</div>

<script>
function openBookingHotelsModal(destinationName) {
  const modal = document.getElementById('bookingHotelsModal');
  const titleElem = document.getElementById('bookingModalTitle');
  if (destinationName && titleElem) {
    titleElem.textContent = 'Hôtels & Ryads de Charme à ' + destinationName;
  }
  if (modal) {
    modal.classList.add('is-open');
  }
}

function closeBookingHotelsModal() {
  const modal = document.getElementById('bookingHotelsModal');
  if (modal) {
    modal.classList.remove('is-open');
  }
}
</script>
