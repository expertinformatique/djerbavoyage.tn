<!-- Modale Détails de la Commande -->
<div id="orderDetailsModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4 hidden">
  <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden animate-in fade-in zoom-in-95 duration-150">
    
    <!-- En-tête Modale -->
    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/75 dark:bg-slate-800/50">
      <div>
        <div class="flex items-center gap-2">
          <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Détails de la Commande</span>
          <span id="modalOrderType" class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300"></span>
        </div>
        <h3 id="modalOrderNumber" class="text-lg font-bold text-slate-900 dark:text-white mt-0.5"></h3>
      </div>
      <button type="button" onclick="closeOrderDetailsModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-xl leading-none p-1 rounded hover:bg-slate-100 dark:hover:bg-slate-800">&times;</button>
    </div>

    <!-- Corps de la Modale (Scrollable) -->
    <div class="p-5 overflow-y-auto space-y-5 text-xs flex-1">
      
      <!-- État de chargement -->
      <div id="modalLoading" class="py-12 text-center">
        <div class="inline-block w-7 h-7 border-2 border-[#635bff] border-t-transparent rounded-full animate-spin"></div>
        <p class="mt-2 text-slate-500 font-medium">Chargement des données...</p>
      </div>

      <!-- Contenu chargé -->
      <div id="modalContent" class="space-y-5 hidden">
        
        <!-- Informations Client & Transaction -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 bg-slate-50 dark:bg-slate-800/40 p-3.5 rounded-lg border border-slate-200/80 dark:border-slate-800">
          <div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Client & Contact</span>
            <div class="mt-1 font-semibold text-slate-900 dark:text-white" id="modalCustomerName"></div>
            <a id="modalCustomerEmail" href="#" class="text-[#635bff] hover:underline block mt-0.5 truncate"></a>
            <div id="modalCustomerPhoneRow" class="mt-1 flex items-center gap-1.5 hidden">
              <i class="fi fi-rr-phone-call text-emerald-600 dark:text-emerald-400 text-xs"></i>
              <span id="modalCustomerPhone" class="font-medium text-slate-700 dark:text-slate-300"></span>
              <a id="modalCustomerWhatsapp" href="#" target="_blank" class="text-[10px] px-1.5 py-0.2 bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 rounded font-bold hover:opacity-80">WhatsApp</a>
            </div>
          </div>
          <div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Paiement & Montant</span>
            <div class="mt-1 text-base font-bold text-slate-900 dark:text-white" id="modalTotalAmount"></div>
            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Date : <span id="modalCreatedAt"></span></div>
            <div class="text-[10px] text-slate-400 mt-0.5 truncate font-mono" title="Stripe Session ID">Session : <span id="modalStripeSession"></span></div>
          </div>
        </div>

        <!-- Section Activités & Prestations Réservées -->
        <div id="modalBookingsSection" class="hidden">
          <h4 class="font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-1.5">
            <i class="fi fi-rr-compass text-[#635bff]"></i>
            Activités & Prestations du Pass
          </h4>
          <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden">
            <table class="w-full text-left">
              <thead class="bg-slate-50 dark:bg-slate-800/60 text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                <tr>
                  <th class="px-3 py-2">Activité</th>
                  <th class="px-3 py-2">Date / Heure</th>
                  <th class="px-3 py-2">Participants</th>
                  <th class="px-3 py-2 text-right">Prix</th>
                </tr>
              </thead>
              <tbody id="modalBookingsTable" class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300"></tbody>
            </table>
          </div>
        </div>

        <!-- Section Transfert Aéroport VIP -->
        <div id="modalTransferSection" class="hidden bg-sky-50/60 dark:bg-sky-950/30 p-3.5 rounded-lg border border-sky-200/80 dark:border-sky-800/50">
          <h4 class="font-bold text-sky-900 dark:text-sky-300 mb-1.5 flex items-center gap-1.5">
            <i class="fi fi-rr-plane-arrival text-sky-600 dark:text-sky-400"></i>
            Navette Aéroport Djerba-Zarzis
          </h4>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-[11px] text-slate-700 dark:text-slate-300 mt-2">
            <div><span class="text-slate-400 text-[10px] block">N° de Vol</span><strong id="modalFlightNumber">-</strong></div>
            <div><span class="text-slate-400 text-[10px] block">Compagnie</span><span id="modalAirline">-</span></div>
            <div><span class="text-slate-400 text-[10px] block">Arrivée</span><span id="modalArrivalDateTime">-</span></div>
            <div><span class="text-slate-400 text-[10px] block">Passagers</span><span id="modalPassengers">-</span></div>
            <div class="col-span-2"><span class="text-slate-400 text-[10px] block">Lieu de dépose</span><span id="modalDropoff">-</span></div>
          </div>
        </div>

        <!-- Section Produits Digitaux Téléchargés -->
        <div id="modalProductsSection" class="hidden">
          <h4 class="font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-1.5">
            <i class="fi fi-rr-book-alt text-[#635bff]"></i>
            Guides & Fichiers Numériques
          </h4>
          <div id="modalProductsList" class="space-y-1.5"></div>
        </div>

        <!-- Modification Rapide du Statut -->
        <div class="p-3.5 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-800">
          <h4 class="font-bold text-slate-900 dark:text-white mb-2 text-xs">Modifier le marquage de la commande</h4>
          <form method="POST" action="<?= url('/admin/orders/update-status') ?>" class="flex flex-wrap items-center gap-2">
            <input type="hidden" name="order_id" id="modalStatusOrderId">
            <select name="status" id="modalStatusSelect" class="px-3 py-1.5 text-xs font-semibold rounded-md border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:ring-1 focus:ring-[#635bff]">
              <option value="paid">Validée / Payée</option>
              <option value="pending">En attente</option>
              <option value="cancelled">Annulée</option>
              <option value="refunded">Remboursée</option>
            </select>
            <button type="submit" class="px-3.5 py-1.5 bg-[#635bff] hover:bg-[#5349e0] text-white rounded-md font-semibold text-xs transition-colors">
              Mettre à jour
            </button>
          </form>
        </div>

      </div>
    </div>

    <!-- Pied Modale -->
    <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex justify-end">
      <button type="button" onclick="closeOrderDetailsModal()" class="px-4 py-1.5 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md transition-colors">
        Fermer
      </button>
    </div>

  </div>
</div>
