<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
  <div>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Journal d'Audit & Sécurité</h1>
    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Surveillance des événements système et tentatives d'intrusion.</p>
  </div>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden">
  <div class="p-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Événements de Sécurité Récent</h2>
    <p class="text-xs text-slate-500 dark:text-slate-400">Traces d'exécution et détection d'anomalies</p>
  </div>
  
  <div class="overflow-x-auto w-full">
    <table class="w-full text-xs text-left">
      <thead class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase bg-slate-50/75 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
        <tr>
          <th class="px-5 py-2.5">Date & Heure</th>
          <th class="px-5 py-2.5">Type d'Événement</th>
          <th class="px-5 py-2.5">Sévérité</th>
          <th class="px-5 py-2.5">Description</th>
          <th class="px-5 py-2.5">Adresse IP</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
        <?php if (empty($logs)): ?>
          <tr>
            <td colspan="5" class="px-5 py-8 text-center text-slate-400">
              Aucun événement d'audit enregistré.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($logs as $log): ?>
            <tr class="hover:bg-slate-50/75 dark:hover:bg-slate-800/50 transition-colors">
              <td class="px-5 py-3 text-slate-500 dark:text-slate-400 whitespace-nowrap">
                <?= e($log['created_at']) ?>
              </td>
              <td class="px-5 py-3 font-mono text-slate-800 dark:text-slate-200">
                <code><?= e($log['event_type']) ?></code>
              </td>
              <td class="px-5 py-3">
                <?php if ($log['severity'] === 'critical'): ?>
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800 dark:bg-red-950/50 dark:text-red-300">
                    CRITIQUE
                  </span>
                <?php else: ?>
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/50 dark:text-amber-300">
                    <?= e(strtoupper($log['severity'])) ?>
                  </span>
                <?php endif; ?>
              </td>
              <td class="px-5 py-3 text-slate-700 dark:text-slate-300">
                <?= e($log['message']) ?>
              </td>
              <td class="px-5 py-3 font-mono text-slate-500 dark:text-slate-400 text-[11px]">
                <?= e($log['ip_address']) ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <?php require __DIR__ . '/partials/pagination.php'; ?>
</div>