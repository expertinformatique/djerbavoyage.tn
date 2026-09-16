<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
  <div>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Pass Séjour & Activités</h1>
    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Suivi des plannings d'excursions, accueils aéroport et réservations d'activités.</p>
  </div>
  <a href="<?= url('/services') ?>" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-md text-xs font-semibold hover:bg-slate-50 shadow-sm transition-colors">
    <i class="fi fi-rr-eye text-slate-400"></i> Voir le Configurateur
  </a>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden">
  <div class="overflow-x-auto w-full">
    <table class="w-full text-xs text-left">
      <thead class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase bg-slate-50/75 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
        <tr>
          <th class="px-5 py-2.5">Référence Pass</th>
          <th class="px-5 py-2.5">Client</th>
          <th class="px-5 py-2.5">Total Réglé</th>
          <th class="px-5 py-2.5">Vol Arrivée (DJE)</th>
          <th class="px-5 py-2.5">Transfert Chauffeur</th>
          <th class="px-5 py-2.5 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
        <?php if (empty($passes)): ?>
          <tr>
            <td colspan="6" class="px-5 py-8 text-center text-slate-400">
              Aucune commande de pass séjour pour l'instant.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($passes as $p): ?>
            <tr class="hover:bg-slate-50/75 dark:hover:bg-slate-800/50 transition-colors">
              <td class="px-5 py-3 font-semibold text-slate-900 dark:text-white">
                <?= e($p['order_number']) ?>
              </td>
              <td class="px-5 py-3 text-slate-600 dark:text-slate-300">
                <?= e($p['customer_email']) ?>
              </td>
              <td class="px-5 py-3 font-semibold text-slate-900 dark:text-white">
                <?= number_format((float)$p['total_amount'], 2) ?> €
              </td>
              <td class="px-5 py-3">
                <?php if (!empty($p['flight_number'])): ?>
                  <span class="font-semibold text-slate-900 dark:text-white"><?= e($p['flight_number']) ?></span><br>
                  <span class="text-slate-400 text-[11px]"><?= e($p['arrival_date']) ?> à <?= e($p['arrival_time']) ?></span>
                <?php else: ?>
                  <span class="text-amber-500 italic text-[11px]">En attente infos vol</span>
                <?php endif; ?>
              </td>
              <td class="px-5 py-3">
                <?php if (!empty($p['transfer_status'])): ?>
                  <?php if ($p['transfer_status'] === 'confirmed'): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/80 dark:bg-emerald-950/40 dark:text-emerald-400">
                      Confirmé
                    </span>
                  <?php else: ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-amber-50 text-amber-700 border border-amber-200/80 dark:bg-amber-950/40 dark:text-amber-400">
                      <?= e($p['transfer_status']) ?>
                    </span>
                  <?php endif; ?>
                <?php else: ?>
                  <span class="text-slate-400 text-[11px]">Non requis</span>
                <?php endif; ?>
              </td>
              <td class="px-5 py-3 text-right">
                <a href="/reservation/planning/<?= urlencode($p['order_number']) ?>" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-[#635bff] bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/50 dark:text-indigo-400 rounded transition-colors">
                  <i class="fi fi-rr-calendar text-[10px]"></i> Planning
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
