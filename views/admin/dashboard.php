<!-- Stripe Header & Tab Bar -->
<div class="mb-6">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
    <div>
      <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Tableau de bord</h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Suivi des paiements Stripe, ventes et réservations djerba voyage.</p>
    </div>
    <div class="flex items-center gap-2">
      <a href="<?= url('/admin/settings') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-md text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 shadow-sm transition-colors">
        <i class="fi fi-rr-settings text-slate-400"></i> Paramètres
      </a>
      <a href="<?= url('/admin/products/create') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#635bff] hover:bg-[#5851ea] text-white rounded-md text-xs font-semibold shadow-sm transition-colors">
        <i class="fi fi-rr-plus"></i> Nouveau Produit
      </a>
    </div>
  </div>

  <!-- Stripe Sub-Navigation Tabs -->
  <div class="flex border-b border-slate-200 dark:border-slate-800 space-x-6 text-xs font-medium">
    <a href="<?= url('/admin/dashboard') ?>" class="pb-2.5 text-[#635bff] border-b-2 border-[#635bff] font-semibold flex items-center gap-1.5">
      Vue d'ensemble
    </a>
    <a href="<?= url('/admin/orders') ?>" class="pb-2.5 text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
      Paiements & Commandes
    </a>
    <a href="<?= url('/admin/services-bookings') ?>" class="pb-2.5 text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
      Pass & Activités
    </a>
    <a href="<?= url('/admin/settings') ?>" class="pb-2.5 text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
      Clés API & Webhooks
    </a>
  </div>
</div>

<!-- Stripe Banner Notice -->
<div class="mb-6 p-4 rounded-xl bg-indigo-50/80 dark:bg-indigo-950/30 border border-indigo-100 dark:border-indigo-900/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-sm">
  <div class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed">
    <span class="font-semibold text-slate-900 dark:text-white">Paiements Stripe Opérationnels :</span>
    Intégrez vos formulaires de paiement et suivez les encaissements en direct depuis votre back-office.
  </div>
  <a href="<?= url('/admin/settings') ?>" class="text-xs font-semibold text-[#635bff] dark:text-indigo-400 hover:underline shrink-0">
    Consulter la documentation &rarr;
  </a>
</div>

<!-- Stripe KPI Metrics Cards (4 Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  
  <!-- Chiffre d'Affaires -->
  <div class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200/90 dark:border-slate-800 shadow-sm flex flex-col justify-between">
    <div class="flex items-center justify-between">
      <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Chiffre d'affaires brut</span>
      <span class="p-1.5 rounded-md bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 text-xs">
        <i class="fi fi-rr-dollar"></i>
      </span>
    </div>
    <div class="mt-3">
      <h3 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white"><?= number_format($totalRevenue, 2) ?> €</h3>
      <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium mt-1 flex items-center gap-1">
        <i class="fi fi-rr-arrow-trend-up"></i> Volume encaissé Stripe
      </p>
    </div>
  </div>

  <!-- Commandes Payées -->
  <div class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200/90 dark:border-slate-800 shadow-sm flex flex-col justify-between">
    <div class="flex items-center justify-between">
      <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Commandes payées</span>
      <span class="p-1.5 rounded-md bg-indigo-50 text-[#635bff] dark:bg-indigo-950/50 dark:text-indigo-400 text-xs">
        <i class="fi fi-rr-receipt"></i>
      </span>
    </div>
    <div class="mt-3">
      <h3 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white"><?= $paidCount ?></h3>
      <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium mt-1">
        Paiements finalisés avec succès
      </p>
    </div>
  </div>

  <!-- Tickets Conciergerie -->
  <div class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200/90 dark:border-slate-800 shadow-sm flex flex-col justify-between">
    <div class="flex items-center justify-between">
      <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Demandes Conciergerie</span>
      <span class="p-1.5 rounded-md bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400 text-xs">
        <i class="fi fi-rr-bell"></i>
      </span>
    </div>
    <div class="mt-3">
      <h3 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white"><?= (int)$pendingConcierge ?></h3>
      <p class="text-[11px] text-blue-600 dark:text-blue-400 font-medium mt-1">
        Tickets en attente de traitement
      </p>
    </div>
  </div>

  <!-- Leads Séjours IA -->
  <div class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200/90 dark:border-slate-800 shadow-sm flex flex-col justify-between">
    <div class="flex items-center justify-between">
      <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Projets Séjours IA</span>
      <span class="p-1.5 rounded-md bg-amber-50 text-amber-600 dark:bg-amber-950/50 dark:text-amber-400 text-xs">
        <i class="fi fi-rr-sparkles"></i>
      </span>
    </div>
    <div class="mt-3">
      <h3 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white"><?= (int)($pendingAiLeads ?? 0) ?></h3>
      <p class="text-[11px] text-amber-600 dark:text-amber-400 font-medium mt-1">
        Leads IA qualifiés
      </p>
    </div>
  </div>

</div>

<!-- Recent Transactions Section (Stripe Table Look) -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden mb-6">
  
  <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div>
      <h2 class="text-sm font-bold text-slate-900 dark:text-white">Dernières Transactions</h2>
      <p class="text-xs text-slate-500 dark:text-slate-400">Historique récent des commandes et paiements clients</p>
    </div>
    <a href="<?= url('/admin/orders') ?>" class="text-xs font-semibold text-[#635bff] dark:text-indigo-400 hover:underline flex items-center gap-1">
      Voir toutes les transactions &rarr;
    </a>
  </div>
  
  <div class="overflow-x-auto w-full">
    <table class="w-full text-xs text-left">
      <thead class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase bg-slate-50/75 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
        <tr>
          <th class="px-5 py-2.5">Numéro</th>
          <th class="px-5 py-2.5">Client</th>
          <th class="px-5 py-2.5">Montant</th>
          <th class="px-5 py-2.5">Type</th>
          <th class="px-5 py-2.5">Statut</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
        <?php if (empty($recentOrders)): ?>
          <tr>
            <td colspan="5" class="px-5 py-8 text-center text-slate-400">
              Aucune transaction enregistrée pour l'instant.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($recentOrders as $order): ?>
            <tr class="hover:bg-slate-50/75 dark:hover:bg-slate-800/50 transition-colors">
              <td class="px-5 py-3 font-semibold text-slate-900 dark:text-white">
                <?= e($order->orderNumber) ?>
              </td>
              <td class="px-5 py-3 text-slate-600 dark:text-slate-300">
                <?= e($order->customerEmail) ?>
              </td>
              <td class="px-5 py-3 font-semibold text-slate-900 dark:text-white">
                <?= number_format($order->totalAmount, 2) ?> €
              </td>
              <td class="px-5 py-3">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                  <?= e($order->type) ?>
                </span>
              </td>
              <td class="px-5 py-3">
                <?php if ($order->status === 'paid'): ?>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/80 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Payée
                  </span>
                <?php else: ?>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-amber-50 text-amber-700 border border-amber-200/80 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> <?= e($order->status) ?>
                  </span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Stripe API Key & System Status Box (Like in screenshot) -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-sm p-5">
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
    <div>
      <h3 class="text-sm font-bold text-slate-900 dark:text-white">Configuration des Clés Stripe</h3>
      <p class="text-xs text-slate-500 dark:text-slate-400">Authentification API et mode de traitement actif</p>
    </div>
    <a href="<?= url('/admin/settings') ?>" class="inline-flex items-center gap-1.5 px-3 py-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 shadow-sm">
      <i class="fi fi-rr-edit"></i> Modifier les clés
    </a>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="p-3.5 bg-slate-50 dark:bg-slate-800/40 rounded-lg border border-slate-200/70 dark:border-slate-800 flex items-center justify-between">
      <div>
        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Mode Traitement</span>
        <span class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5 mt-0.5">
          <span class="w-2 h-2 rounded-full bg-amber-400"></span> Mode Test (Sandbox)
        </span>
      </div>
      <span class="px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300 rounded">
        Stripe Test
      </span>
    </div>

    <div class="p-3.5 bg-slate-50 dark:bg-slate-800/40 rounded-lg border border-slate-200/70 dark:border-slate-800 flex items-center justify-between">
      <div class="min-w-0 pr-2">
        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Clé Publique (Publishable Key)</span>
        <code class="text-xs font-mono text-[#635bff] dark:text-indigo-400 truncate block mt-0.5">
          <?= !empty($settings->get('stripe_pub_key')) ? e(substr($settings->get('stripe_pub_key'), 0, 16) . '...') : 'pk_test_...' ?>
        </code>
      </div>
      <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 rounded shrink-0">
        Active
      </span>
    </div>
  </div>
</div>