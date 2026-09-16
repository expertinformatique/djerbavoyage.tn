<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
  <div>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Statistiques de Fréquentation (GA)</h1>
    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Mesure d'audience en temps réel et performances des pages clés.</p>
  </div>
  <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#0a2540] text-white rounded-lg text-xs font-semibold shadow-sm">
    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
    <span><strong><?= $realtimeActive ?></strong> visiteurs en direct</span>
  </div>
</div>

<!-- Metric Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
  <div class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200/90 dark:border-slate-800 shadow-sm flex items-center justify-between">
    <div>
      <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Pages Vues Totales</span>
      <h3 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white mt-1"><?= number_format($totalViews) ?></h3>
    </div>
    <span class="p-2 rounded-lg bg-indigo-50 text-[#635bff] dark:bg-indigo-950/50 dark:text-indigo-400">
      <i class="fi fi-rr-eye text-lg"></i>
    </span>
  </div>

  <div class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200/90 dark:border-slate-800 shadow-sm flex items-center justify-between">
    <div>
      <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Sessions Uniques</span>
      <h3 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white mt-1"><?= number_format($uniqueSessions) ?></h3>
    </div>
    <span class="p-2 rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400">
      <i class="fi fi-rr-users text-lg"></i>
    </span>
  </div>
</div>

<!-- Top Pages Table -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden">
  <div class="p-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Top des Pages les plus Consultées</h2>
    <p class="text-xs text-slate-500 dark:text-slate-400">Pages générant le plus fort engagement</p>
  </div>
  
  <div class="overflow-x-auto w-full">
    <table class="w-full text-xs text-left">
      <thead class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase bg-slate-50/75 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
        <tr>
          <th class="px-5 py-2.5">Chemin URL</th>
          <th class="px-5 py-2.5 text-right">Vues Enregistrées</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
        <?php if (empty($topPages)): ?>
          <tr>
            <td colspan="2" class="px-5 py-8 text-center text-slate-400">
              Aucune donnée de trafic pour le moment.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($topPages as $page): ?>
            <tr class="hover:bg-slate-50/75 dark:hover:bg-slate-800/50 transition-colors">
              <td class="px-5 py-3 font-mono text-slate-800 dark:text-slate-200">
                <?= e($page['url_path']) ?>
              </td>
              <td class="px-5 py-3 font-bold text-slate-900 dark:text-white text-right">
                <?= number_format($page['views']) ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>