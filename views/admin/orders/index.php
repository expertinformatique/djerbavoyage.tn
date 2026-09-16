<?php
/**
 * Vue d'administration : Paiements & Commandes Enrichi
 * Informations clients complètes, détails de la demande, marquage de statut et modale
 */
?>

<div class="p-4 sm:p-6 space-y-6 max-w-7xl mx-auto">

  <!-- En-tête -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
        <a href="<?= url('/admin/dashboard') ?>" class="hover:text-slate-700 dark:hover:text-slate-300">Dashboard</a>
        <span>/</span>
        <span class="text-slate-900 dark:text-slate-100 font-medium">Ventes</span>
        <span>/</span>
        <span class="text-[#635bff] font-medium">Commandes</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
        <i class="fi fi-rr-receipt text-[#635bff]"></i>
        Paiements & Commandes
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
        Suivez les réservations de pass, ventes de guides et gérez les statuts de validation.
      </p>
    </div>
  </div>

  <!-- Messages Flash -->
  <?php if (!empty($flashSuccess)): ?>
    <div class="p-3.5 text-xs font-medium text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 rounded-lg flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="fi fi-rr-check-circle text-emerald-600 dark:text-emerald-400 text-sm"></i>
        <span><?= htmlspecialchars($flashSuccess, ENT_QUOTES, 'UTF-8') ?></span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm">&times;</button>
    </div>
  <?php endif; ?>

  <?php if (!empty($flashError)): ?>
    <div class="p-3.5 text-xs font-medium text-rose-800 dark:text-rose-300 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 rounded-lg flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="fi fi-rr-cross-circle text-rose-600 dark:text-rose-400 text-sm"></i>
        <span><?= htmlspecialchars($flashError, ENT_QUOTES, 'UTF-8') ?></span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 text-sm">&times;</button>
    </div>
  <?php endif; ?>

  <!-- KPI / Statistiques Rapides -->
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5">
    <div class="p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xs">
      <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Commandes</span>
      <span class="text-lg font-bold text-slate-900 dark:text-white mt-1 block"><?= (int)($stats['total_count'] ?? 0) ?></span>
    </div>
    <div class="p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xs">
      <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Revenus Encaissés</span>
      <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400 mt-1 block"><?= number_format((float)($stats['total_revenue'] ?? 0), 2) ?> €</span>
    </div>
    <div class="p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xs">
      <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Validées / Payées</span>
      <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400 mt-1 block"><?= (int)($stats['paid_count'] ?? 0) ?></span>
    </div>
    <div class="p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xs">
      <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">En Attente</span>
      <span class="text-lg font-bold text-amber-600 dark:text-amber-400 mt-1 block"><?= (int)($stats['pending_count'] ?? 0) ?></span>
    </div>
  </div>

  <!-- Barre de Recherche & Filtres -->
  <div class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 p-3.5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <form action="<?= url('/admin/orders') ?>" method="GET" class="flex flex-wrap items-center gap-2 flex-1">
      <div class="relative flex-1 min-w-[200px]">
        <i class="fi fi-rr-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
        <input type="text" name="search" value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>" placeholder="Rechercher par email, numéro..." class="w-full pl-8 pr-3 py-1.5 text-xs rounded-md bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
      </div>
      <div class="flex items-center gap-1.5 overflow-x-auto text-xs">
        <?php foreach (['all' => 'Tous', 'paid' => 'Validées', 'pending' => 'En attente', 'cancelled' => 'Annulées'] as $stKey => $stLabel): ?>
          <a href="<?= url('/admin/orders?status=' . $stKey . ($search ? '&search=' . urlencode($search) : '')) ?>" 
             class="px-2.5 py-1 rounded-md text-[11px] font-medium transition-colors <?= $status === $stKey ? 'bg-[#635bff] text-white font-semibold' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' ?>">
            <?= $stLabel ?>
          </a>
        <?php endforeach; ?>
      </div>
      <button type="submit" class="px-3 py-1.5 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 rounded-md text-xs font-semibold hover:opacity-90">Filtrer</button>
      <?php if ($search || $status !== 'all'): ?>
        <a href="<?= url('/admin/orders') ?>" class="px-2.5 py-1.5 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 text-xs">Réinitialiser</a>
      <?php endif; ?>
    </form>
  </div>

  <!-- Tableau des Commandes -->
  <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto w-full">
      <table class="w-full text-xs text-left border-collapse">
        <thead class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase bg-slate-50/75 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800 tracking-wider">
          <tr>
            <th class="px-4 py-3">Commande</th>
            <th class="px-4 py-3">Client</th>
            <th class="px-4 py-3">Détails de la Demande</th>
            <th class="px-4 py-3">Montant</th>
            <th class="px-4 py-3">Statut & Marquage</th>
            <th class="px-4 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
          <?php if (empty($orders)): ?>
            <tr>
              <td colspan="6" class="px-4 py-8 text-center text-slate-400">Aucune commande trouvée.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($orders as $order): ?>
              <?php
                $statusBadge = match($order->status) {
                  'paid'      => 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/60',
                  'pending'   => 'bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-800/60',
                  'cancelled' => 'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-800/60',
                  default     => 'bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700'
                };
                $statusText = match($order->status) {
                  'paid'      => 'Validée',
                  'pending'   => 'En attente',
                  'cancelled' => 'Annulée',
                  'refunded'  => 'Remboursée',
                  default     => ucfirst($order->status)
                };
              ?>
              <tr class="hover:bg-slate-50/75 dark:hover:bg-slate-800/50 transition-colors">
                <!-- Numéro & Date -->
                <td class="px-4 py-3">
                  <span class="font-bold text-slate-900 dark:text-white block"><?= htmlspecialchars($order->orderNumber, ENT_QUOTES, 'UTF-8') ?></span>
                  <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="text-[9px] uppercase font-bold px-1.5 py-0.2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded">
                      <?= htmlspecialchars($order->type, ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <span class="text-[10px] text-slate-400">
                      <?= $order->createdAt ? date('d/m/Y H:i', strtotime($order->createdAt)) : '-' ?>
                    </span>
                  </div>
                </td>

                <!-- Client -->
                <td class="px-4 py-3">
                  <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-slate-100 dark:bg-slate-800 text-[#635bff] font-bold flex items-center justify-center text-xs shrink-0 border border-slate-200 dark:border-slate-700">
                      <?= strtoupper(substr($order->customerEmail, 0, 1)) ?>
                    </div>
                    <div class="min-w-0">
                      <a href="mailto:<?= htmlspecialchars($order->customerEmail, ENT_QUOTES, 'UTF-8') ?>" class="font-semibold text-slate-900 dark:text-white hover:text-[#635bff] truncate block">
                        <?= htmlspecialchars($order->customerEmail, ENT_QUOTES, 'UTF-8') ?>
                      </a>
                      <?php if (!empty($order->customerPhone)): ?>
                        <div class="flex items-center gap-1 mt-0.5">
                          <span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono"><?= htmlspecialchars($order->customerPhone, ENT_QUOTES, 'UTF-8') ?></span>
                          <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $order->customerPhone) ?>" target="_blank" class="text-[9px] px-1 bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 rounded font-bold hover:opacity-80" title="Contacter sur WhatsApp">WA</a>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </td>

                <!-- Détails de la demande -->
                <td class="px-4 py-3">
                  <div class="font-medium text-slate-800 dark:text-slate-200">
                    <?= htmlspecialchars($order->summaryDescription ?: 'Prestation standard', ENT_QUOTES, 'UTF-8') ?>
                  </div>
                  <button type="button" onclick="openOrderDetails(<?= $order->id ?>)" class="text-[10px] text-[#635bff] hover:underline mt-0.5 inline-flex items-center gap-1">
                    <i class="fi fi-rr-eye text-[9px]"></i> Voir composition
                  </button>
                </td>

                <!-- Montant -->
                <td class="px-4 py-3">
                  <span class="font-bold text-slate-900 dark:text-white">
                    <?= number_format($order->totalAmount, 2) ?> <?= htmlspecialchars(strtoupper($order->currency), ENT_QUOTES, 'UTF-8') ?>
                  </span>
                </td>

                <!-- Statut & Marquage Rapide -->
                <td class="px-4 py-3">
                  <div class="flex flex-col sm:flex-row sm:items-center gap-1.5">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-bold border rounded-full shrink-0 <?= $statusBadge ?>">
                      <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                      <?= $statusText ?>
                    </span>
                    <!-- Actions de marquage rapide -->
                    <form method="POST" action="<?= url('/admin/orders/update-status') ?>" class="inline-flex items-center gap-1">
                      <input type="hidden" name="order_id" value="<?= $order->id ?>">
                      <?php if ($order->status !== 'paid'): ?>
                        <button type="submit" name="status" value="paid" class="px-1.5 py-0.5 text-[9px] font-semibold bg-emerald-100 hover:bg-emerald-200 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 rounded transition-colors" title="Valider / Marquer payée">
                          Valider
                        </button>
                      <?php endif; ?>
                      <?php if ($order->status !== 'pending'): ?>
                        <button type="submit" name="status" value="pending" class="px-1.5 py-0.5 text-[9px] font-semibold bg-amber-100 hover:bg-amber-200 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 rounded transition-colors" title="Mettre en attente">
                          En attente
                        </button>
                      <?php endif; ?>
                      <?php if ($order->status !== 'cancelled'): ?>
                        <button type="submit" name="status" value="cancelled" onclick="return confirm('Annuler la commande <?= htmlspecialchars(addslashes($order->orderNumber), ENT_QUOTES, 'UTF-8') ?> ?')" class="px-1.5 py-0.5 text-[9px] font-semibold bg-rose-100 hover:bg-rose-200 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300 rounded transition-colors" title="Annuler la commande">
                          Annuler
                        </button>
                      <?php endif; ?>
                    </form>
                  </div>
                </td>

                <!-- Actions -->
                <td class="px-4 py-3 text-right">
                  <button type="button" onclick="openOrderDetails(<?= $order->id ?>)" class="px-2.5 py-1 text-xs font-semibold text-slate-700 dark:text-slate-300 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-md transition-colors" title="Consulter la fiche complète">
                    <i class="fi fi-rr-search-alt"></i> Fiche
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php require __DIR__ . '/../partials/pagination.php'; ?>
  </div>
</div>

<!-- Composant Modale Détails & Script -->
<?php require __DIR__ . '/details_modal.php'; ?>
<script src="<?= asset('/assets/js/modules/admin-orders.js') ?>"></script>
