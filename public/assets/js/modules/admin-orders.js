/**
 * Gestionnaire Frontend des Commandes Admin
 * Chargement dynamique des détails, coordonnées client et changement de statut
 */

window.openOrderDetails = async function(orderId) {
  const modal = document.getElementById('orderDetailsModal');
  const loader = document.getElementById('modalLoading');
  const content = document.getElementById('modalContent');
  if (!modal) return;

  modal.classList.remove('hidden');
  loader.classList.remove('hidden');
  content.classList.add('hidden');

  try {
    const res = await fetch(`/api/admin/orders/details?id=${orderId}`);
    if (!res.ok) throw new Error("Erreur lors de la récupération des détails.");
    const data = await res.json();
    const order = data.order || {};

    // Métadonnées générales
    document.getElementById('modalOrderNumber').textContent = order.orderNumber || `CMD #${order.id}`;
    document.getElementById('modalOrderType').textContent = (order.type || '').toUpperCase();
    document.getElementById('modalTotalAmount').textContent = `${Number(order.totalAmount || 0).toFixed(2)} ${(order.currency || 'EUR').toUpperCase()}`;
    document.getElementById('modalCreatedAt').textContent = order.createdAt ? new Date(order.createdAt).toLocaleString('fr-FR') : '-';
    document.getElementById('modalStripeSession').textContent = order.stripeSessionId || 'N/A';
    document.getElementById('modalStatusOrderId').value = order.id;
    document.getElementById('modalStatusSelect').value = order.status || 'pending';

    // Client
    const customerName = data.customer_name || 'Voyageur Djerba';
    document.getElementById('modalCustomerName').textContent = customerName;
    
    const emailEl = document.getElementById('modalCustomerEmail');
    emailEl.textContent = order.customerEmail || 'Non spécifié';
    emailEl.href = order.customerEmail ? `mailto:${order.customerEmail}` : '#';

    // Téléphone / WhatsApp
    const phoneRow = document.getElementById('modalCustomerPhoneRow');
    const phone = data.customer_phone || '';
    if (phone) {
      phoneRow.classList.remove('hidden');
      document.getElementById('modalCustomerPhone').textContent = phone;
      const cleanPhone = phone.replace(/[^0-9]/g, '');
      const waLink = document.getElementById('modalCustomerWhatsapp');
      waLink.href = `https://wa.me/${cleanPhone}`;
    } else {
      phoneRow.classList.add('hidden');
    }

    // Activités / Pass
    const bookingsSec = document.getElementById('modalBookingsSection');
    const bookingsTbody = document.getElementById('modalBookingsTable');
    bookingsTbody.innerHTML = '';
    if (data.bookings && data.bookings.length > 0) {
      bookingsSec.classList.remove('hidden');
      data.bookings.forEach(b => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-slate-50/50 dark:hover:bg-slate-800/30';
        const dateTime = [b.scheduled_date, b.scheduled_time].filter(Boolean).join(' à ') || 'Non planifié';
        tr.innerHTML = `
          <td class="px-3 py-2 font-semibold text-slate-900 dark:text-white">${escapeHtml(b.service_name || 'Service')}</td>
          <td class="px-3 py-2 text-slate-500 dark:text-slate-400">${escapeHtml(dateTime)}</td>
          <td class="px-3 py-2">${b.guests_count || 1} pers.</td>
          <td class="px-3 py-2 text-right font-semibold text-slate-900 dark:text-white">${Number(b.total_price || 0).toFixed(2)} €</td>
        `;
        bookingsTbody.appendChild(tr);
      });
    } else {
      bookingsSec.classList.add('hidden');
    }

    // Navette Aéroport
    const transferSec = document.getElementById('modalTransferSection');
    if (data.transfer) {
      transferSec.classList.remove('hidden');
      document.getElementById('modalFlightNumber').textContent = data.transfer.flight_number || 'Non renseigné';
      document.getElementById('modalAirline').textContent = data.transfer.airline || '-';
      const arrival = [data.transfer.arrival_date, data.transfer.arrival_time].filter(Boolean).join(' à ') || '-';
      document.getElementById('modalArrivalDateTime').textContent = arrival;
      document.getElementById('modalPassengers').textContent = `${data.transfer.passengers_count || 1} pers.`;
      document.getElementById('modalDropoff').textContent = data.transfer.dropoff_location || 'Hôtel / Adresse à Djerba';
    } else {
      transferSec.classList.add('hidden');
    }

    // Produits digitaux
    const prodSec = document.getElementById('modalProductsSection');
    const prodList = document.getElementById('modalProductsList');
    prodList.innerHTML = '';
    if (data.products && data.products.length > 0) {
      prodSec.classList.remove('hidden');
      data.products.forEach(p => {
        const div = document.createElement('div');
        div.className = 'p-2 rounded bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex justify-between items-center';
        div.innerHTML = `
          <div>
            <strong class="text-slate-900 dark:text-white">${escapeHtml(p.product_title || 'Guide PDF')}</strong>
            <span class="text-[10px] text-slate-400 block font-mono">Token: ${escapeHtml(p.token || '')}</span>
          </div>
          <span class="px-2 py-0.5 text-[10px] font-bold bg-purple-50 text-purple-700 dark:bg-purple-950/50 dark:text-purple-300 rounded">
            ${p.downloads_left || 0} téléchargements restants
          </span>
        `;
        prodList.appendChild(div);
      });
    } else {
      prodSec.classList.add('hidden');
    }

    loader.classList.add('hidden');
    content.classList.remove('hidden');
  } catch (err) {
    loader.innerHTML = `<p class="text-rose-600 font-semibold text-xs">${escapeHtml(err.message)}</p>`;
  }
};

window.closeOrderDetailsModal = function() {
  const modal = document.getElementById('orderDetailsModal');
  if (modal) modal.classList.add('hidden');
};

function escapeHtml(str) {
  if (!str) return '';
  return String(str).replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[m]);
}
