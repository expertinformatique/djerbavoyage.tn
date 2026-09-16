<div class="w-full max-w-sm bg-white dark:bg-slate-900 p-8 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xl mx-auto">
  <div class="flex flex-col items-center mb-6 text-center">
    <div class="w-12 h-12 rounded-xl bg-[#635bff] text-white font-bold flex items-center justify-center text-base shadow-md mb-3">
      DV
    </div>
    <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
      Djerba Voyage Admin
    </h2>
    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Connectez-vous pour accéder au tableau de bord</p>
  </div>

  <?php if (!empty($error)): ?>
    <div class="mb-5 p-3 rounded-lg bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900/50 text-red-700 dark:text-red-400 text-xs font-medium text-center">
      <?= e($error) ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="<?= url('/admin/login') ?>" class="space-y-4">
    <div>
      <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Identifiant / E-mail</label>
      <input type="text" name="username" required autofocus class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#635bff] focus:border-[#635bff] transition-all">
    </div>

    <div>
      <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Mot de passe</label>
      <input type="password" name="password" required class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#635bff] focus:border-[#635bff] transition-all">
    </div>

    <button type="submit" class="w-full py-2.5 px-4 bg-[#635bff] hover:bg-[#5851ea] text-white rounded-md text-xs font-semibold shadow-sm transition-all flex items-center justify-center gap-1.5 mt-2 active:scale-[0.99]">
      <span>Se connecter</span>
      <i class="fi fi-rr-arrow-right text-[10px]"></i>
    </button>
  </form>
</div>