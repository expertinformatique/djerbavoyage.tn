<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
  <div>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Newsletter & Club Privé</h1>
    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Suivi des abonnés à la liste de diffusion et configuration SMTP.</p>
  </div>
</div>

<!-- Info Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
  <div class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200/90 dark:border-slate-800 shadow-sm">
    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Abonnés Actifs</span>
    <h3 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white mt-1"><?= (int)$activeCount ?></h3>
    <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium mt-1">
      Opt-in confirmés
    </p>
  </div>

  <div class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200/90 dark:border-slate-800 shadow-sm">
    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Serveur SMTP Sortant</span>
    <h4 class="text-sm font-bold text-slate-900 dark:text-white mt-1">mail.djerbavoyage.tn:465</h4>
    <p class="text-[11px] text-emerald-600 font-medium mt-1 flex items-center gap-1">
      <i class="fi fi-rr-lock"></i> SSL/TLS Chiffré
    </p>
  </div>

  <div class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200/90 dark:border-slate-800 shadow-sm">
    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Boîte de Réception</span>
    <h4 class="text-sm font-bold text-[#635bff] dark:text-indigo-400 mt-1 truncate">reservation@djerbavoyage.tn</h4>
    <p class="text-[11px] text-slate-400 font-medium mt-1">
      IMAP 993 / POP3 995
    </p>
  </div>
</div>

<!-- Subscribers Table -->
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden">
  <div class="p-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Liste des Inscrits</h2>
    <p class="text-xs text-slate-500 dark:text-slate-400">Carnet d'adresses pour les campagnes promotionnelles</p>
  </div>
  
  <div class="overflow-x-auto w-full">
    <table class="w-full text-xs text-left">
      <thead class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase bg-slate-50/75 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
        <tr>
          <th class="px-5 py-2.5">ID</th>
          <th class="px-5 py-2.5">Adresse E-mail</th>
          <th class="px-5 py-2.5">Statut</th>
          <th class="px-5 py-2.5">Adresse IP</th>
          <th class="px-5 py-2.5">Date Inscription</th>
          <th class="px-5 py-2.5">Désinscription</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
        <?php if (empty($subscribers)): ?>
          <tr>
            <td colspan="6" class="px-5 py-8 text-center text-slate-400">
              Aucun abonné enregistré pour le moment.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($subscribers as $sub): ?>
            <tr class="hover:bg-slate-50/75 dark:hover:bg-slate-800/50 transition-colors">
              <td class="px-5 py-3 font-mono text-slate-400 text-[11px]">
                #<?= (int)$sub['id'] ?>
              </td>
              <td class="px-5 py-3 font-semibold text-slate-900 dark:text-white">
                <?= e($sub['email']) ?>
              </td>
              <td class="px-5 py-3">
                <?php if ($sub['status'] === 'active'): ?>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/80 dark:bg-emerald-950/40 dark:text-emerald-400">
                    Actif
                  </span>
                <?php else: ?>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-red-50 text-red-700 border border-red-200 dark:bg-red-950/40 dark:text-red-400">
                    Désinscrit
                  </span>
                <?php endif; ?>
              </td>
              <td class="px-5 py-3 text-slate-500 dark:text-slate-400 font-mono text-[11px]">
                <?= e($sub['ip_address'] ?? '-') ?>
              </td>
              <td class="px-5 py-3 text-slate-500 dark:text-slate-400 whitespace-nowrap">
                <?= e($sub['created_at']) ?>
              </td>
              <td class="px-5 py-3 text-slate-400 whitespace-nowrap">
                <?= e($sub['unsubscribed_at'] ?? '-') ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
