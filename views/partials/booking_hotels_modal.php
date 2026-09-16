<?php
/**
 * Modal Grande Popup avec iframe Booking.com — Reste sur le site sans redirection externe
 */
$partnerId = $settings->get('booking_partner_id', 'booking_djerba_123');
?>
<div class="c-modal" id="bookingHotelsModal" role="dialog" aria-hidden="true">
  <div class="c-modal__card" style="width: 98vw; height: 96vh; max-width: 98vw; max-height: 96vh; display: flex; flex-direction: column; padding: 1rem 1.25rem; border-radius: 16px;">
    
    <!-- Modal Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid var(--clr-sand-300); shrink-0;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0, 119, 182, 0.1); color: var(--clr-sea-600); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
          <i class="fi fi-rr-hotel"></i>
        </div>
        <div>
          <h3 id="bookingModalTitle" style="font-family: var(--font-heading); font-size: 1.2rem; color: var(--clr-dark-900); font-weight: 800; margin: 0; line-height: 1.2;">
            Hôtels, Menzels & Ryads de Charme à Djerba
          </h3>
          <span style="font-size: 0.78rem; color: #10B981; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; margin-top: 2px;">
            <i class="fi fi-rr-check-circle"></i> Intégration Directe Booking.com VIP • Meilleur Tarif Garanti
          </span>
        </div>
      </div>
      
      <div style="display: flex; align-items: center; gap: 10px;">
        <button type="button" class="c-modal__close" onclick="closeBookingHotelsModal()" style="background: rgba(15, 23, 42, 0.06); border: none; width: 36px; height: 36px; border-radius: 50%; font-size: 1.5rem; cursor: pointer; color: var(--clr-dark-900); display: flex; align-items: center; justify-content: center; transition: background 0.2s;">&times;</button>
      </div>
    </div>

    <!-- Modal Content Body with Iframe -->
    <div style="flex: 1; margin: 1rem 0; position: relative; border-radius: 14px; overflow: hidden; background: #f8fafc; border: 1px solid var(--clr-sand-300);">
      
      <!-- Loading Spinner Indicator -->
      <div id="bookingIframeLoader" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #ffffff; z-index: 5; transition: opacity 0.3s ease;">
        <div style="width: 44px; height: 44px; border: 4px solid var(--clr-sand-200); border-top-color: var(--clr-sea-600); border-radius: 50%; animation: spinIframe 0.8s linear infinite;"></div>
        <p style="margin-top: 1rem; font-size: 0.9rem; font-weight: 700; color: var(--clr-dark-800);">Chargement des hôtels en direct...</p>
        <p style="font-size: 0.8rem; color: var(--clr-gray-500);">Recherche des meilleures offres Booking.com à Djerba</p>
      </div>

      <!-- Live Booking.com Iframe -->
      <iframe id="bookingIframe"
              src="about:blank"
              style="width: 100%; height: 100%; border: none; border-radius: 14px;"
              onload="onBookingIframeLoaded()"
              allow="geolocation; payment"
              loading="lazy">
      </iframe>
    </div>

    <!-- Modal Footer -->
    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.5rem; border-top: 1px solid var(--clr-sand-300); shrink-0;">
      <span style="font-size: 0.82rem; color: var(--clr-gray-500); display: flex; align-items: center; gap: 6px;">
        <i class="fi fi-rr-shield-check" style="color: #10B981;"></i> Navigation 100% sécurisée sur notre site
      </span>
      <button type="button" class="c-button c-button--outline" onclick="closeBookingHotelsModal()" style="font-size: 0.85rem; padding: 0.5rem 1.25rem;">
        Fermer la fenêtre
      </button>
    </div>

  </div>
</div>

<style>
@keyframes spinIframe {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<script>
const DEFAULT_BOOKING_URL = "https://www.booking.com/city/tn/houmt-souk.html?aid=<?= e($partnerId) ?>";

function openBookingHotelsModal(destinationName, customUrl) {
  const modal = document.getElementById('bookingHotelsModal');
  const titleElem = document.getElementById('bookingModalTitle');
  const iframe = document.getElementById('bookingIframe');
  const loader = document.getElementById('bookingIframeLoader');

  if (destinationName && titleElem) {
    titleElem.textContent = 'Hôtels & Ryads de Charme à ' + destinationName;
  }

  const targetUrl = customUrl || DEFAULT_BOOKING_URL;

  if (loader) {
    loader.style.opacity = '1';
    loader.style.display = 'flex';
  }

  if (iframe && iframe.src !== targetUrl) {
    iframe.src = targetUrl;
  }

  if (modal) {
    modal.classList.add('is-open');
  }
}

function onBookingIframeLoaded() {
  const loader = document.getElementById('bookingIframeLoader');
  if (loader) {
    loader.style.opacity = '0';
    setTimeout(() => {
      loader.style.display = 'none';
    }, 300);
  }
}

function closeBookingHotelsModal() {
  const modal = document.getElementById('bookingHotelsModal');
  if (modal) {
    modal.classList.remove('is-open');
  }
}
</script>
