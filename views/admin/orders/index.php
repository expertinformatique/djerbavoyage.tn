<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
  <div>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Paiements & Commandes</h1>
    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Consultez l'historique complet des paiements Stripe et des commandes clients.</p>
  </div>
</div>

<!-- Search & Filter Card -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden mb-6">
  
  <div class="p-3.5 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <form action="" method="GET" class="flex items-center gap-2 max-w-md w-full">
      <div class="relative flex-1">
        <i class="fi fi-rr-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
        <input type="text" name="search" value="<?= e($search) ?>" placeholder="Rechercher par email client ou numéro..." class="w-full pl-8 pr-3 py-1.5 text-xs rounded-md bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-700 focus:outline-none focus:ring-1 focus:ring-[#635bff] placeholder-slate-400">
      </div>
      <button type="submit" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 dark:bg-slate-100 dark:hover:bg-white text-white dark:text-slate-900 rounded-md text-xs font-semibold shadow-sm transition-colors">
        Filtrer
      </button>
      <?php if ($search): ?>
        <a href="<?= url('/admin/orders') ?>" class="px-3 py-1.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-300 rounded-md text-xs font-medium hover:bg-slate-50 transition-colors">
          Réinitialiser
        </a>
      <?php endif; ?>
    </form>
  </div>
  
  <div class="overflow-x-auto w-full">
    <table class="w-full text-xs text-left">
      <thead class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase bg-slate-50/75 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
        <tr>
          <th class="px-5 py-2.5">Numéro</th>
          <th class="px-5 py-2.5">Client</th>
          <th class="px-5 py-2.5">Type</th>
          <th class="px-5 py-2.5">Montant</th>
          <th class="px-5 py-2.5">Statut</th>
          <th class="px-5 py-2.5">Date & Heure</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
        <?php if (empty($orders)): ?>
          <tr>
            <td colspan="6" class="px-5 py-8 text-center text-slate-400">
              Aucune commande trouvée.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($orders as $order): ?>
            <tr class="hover:bg-slate-50/75 dark:hover:bg-slate-800/50 transition-colors">
              <td class="px-5 py-3 font-semibold text-slate-900 dark:text-white">
                <?= e($order->orderNumber) ?>
              </td>
              <td class="px-5 py-3 text-slate-600 dark:text-slate-300">
                <?= e($order->customerEmail) ?>
              </td>
              <td class="px-5 py-3">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                  <?= e($order->type) ?>
                </span>
              </td>
              <td class="px-5 py-3 font-semibold text-slate-900 dark:text-white">
                <?= number_format($order->totalAmount, 2) ?> <?= e(strtoupper($order->currency)) ?>
              </td>
              <td class="px-5 py-3">
                <?php if ($order->status === 'paid'): ?>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/80 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Payée
                  </span>
                <?php elseif ($order->status === 'pending'): ?>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-amber-50 text-amber-700 border border-amber-200/80 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> En attente
                  </span>
                <?php else: ?>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-300">
                    <?= e($order->status) ?>
                  </span>
                <?php endif; ?>
              </td>
              <td class="px-5 py-3 text-slate-500 dark:text-slate-400 whitespace-nowrap">
                <?= (new DateTime($order->createdAt))->format('d/m/Y H:i') ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
  <div class="flex justify-center mt-6">
    <nav class="inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?><?= $search ? '&search='.urlencode($search) : '' ?>" class="relative inline-flex items-center px-3 py-1.5 border text-xs font-semibold <?= $i === $page ? 'bg-[#635bff] border-[#635bff] text-white z-10' : 'bg-white border-slate-300 text-slate-600 hover:bg-slate-50 dark:bg-slate-900 dark:border-slate-700 dark:text-slate-300' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>
    </nav>
  </div>
<?php endif; ?>
