<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
  <div>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Configuration du Site & Paiements</h1>
    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Gérez les paramètres généraux, les clés API Stripe et la tarification.</p>
  </div>
</div>

<?php if (!empty($success)): ?>
  <div class="mb-6 p-3.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-900/50 text-emerald-700 dark:text-emerald-400 text-xs font-medium flex items-center gap-2">
    <i class="fi fi-rr-check-circle text-sm"></i>
    <?= e($success) ?>
  </div>
<?php endif; ?>

<form method="POST" action="<?= url('/admin/settings') ?>" class="space-y-6 max-w-3xl">
  
  <!-- Section 1 : Paramètres Stripe -->
  <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between">
      <div>
        <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
          <i class="fi fi-rr-credit-card text-[#635bff]"></i> Passerelle de Paiement Stripe
        </h2>
        <p class="text-xs text-slate-500 dark:text-slate-400">Mode de paiement et clés secrètes d'authentification</p>
      </div>
      <span class="px-2 py-0.5 text-[10px] font-bold bg-indigo-50 text-[#635bff] dark:bg-indigo-950/40 dark:text-indigo-400 rounded">
        Stripe Connect
      </span>
    </div>
    
    <div class="p-5 space-y-4">
      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Mode de Fonctionnement</label>
        <select name="stripe_mode" class="w-full max-w-xs rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#635bff]">
          <option value="test" <?= $settings->get('stripe_mode', 'test') === 'test' ? 'selected' : '' ?>>Environnement de Test (Sandbox)</option>
          <option value="live" <?= $settings->get('stripe_mode') === 'live' ? 'selected' : '' ?>>Production (Live)</option>
        </select>
        <p class="mt-1 text-[11px] text-slate-400">En mode test, les cartes de test Stripe peuvent être utilisées pour simuler les flux.</p>
      </div>

      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Clé Publique Stripe (Publishable Key)</label>
        <input type="text" name="stripe_pub_key" value="<?= e($settings->get('stripe_pub_key', $_ENV['STRIPE_PUB_KEY'] ?? '')) ?>" class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-xs font-mono bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#635bff]" placeholder="pk_test_...">
      </div>

      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Clé Secrète Stripe (Secret Key)</label>
        <input type="password" name="stripe_secret_key" value="<?= e($settings->get('stripe_secret_key', $_ENV['STRIPE_SECRET_KEY'] ?? '')) ?>" class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-xs font-mono bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#635bff]" placeholder="sk_test_...">
      </div>
    </div>
  </div>

  <!-- Section 2 : Paramètres Généraux -->
  <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
      <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
        <i class="fi fi-rr-globe text-slate-500"></i> Paramètres Généraux du Site
      </h2>
      <p class="text-xs text-slate-500 dark:text-slate-400">Identité visuelle et adresse email de notification</p>
    </div>
    
    <div class="p-5 space-y-4">
      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nom du Site</label>
        <input type="text" name="site_name" value="<?= e($settings->get('site_name')) ?>" class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#635bff]">
      </div>

      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email de Contact / Réception des alertes</label>
        <input type="email" name="contact_email" value="<?= e($settings->get('contact_email')) ?>" class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#635bff]">
      </div>
    </div>
  </div>

  <!-- Section 3 : Tarification & Affiliation -->
  <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
      <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
        <i class="fi fi-rr-tags text-slate-500"></i> Tarification & Affiliation
      </h2>
      <p class="text-xs text-slate-500 dark:text-slate-400">Frais de conciergerie et tracking partenaires</p>
    </div>
    
    <div class="p-5 space-y-4">
      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Prix Forfait Conciergerie (EUR)</label>
        <div class="relative max-w-xs">
          <input type="text" name="concierge_price" value="<?= e($settings->get('concierge_price')) ?>" class="w-full rounded-md border border-slate-300 dark:border-slate-700 pl-3 pr-8 py-2 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#635bff]">
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 text-xs">€</div>
        </div>
      </div>

      <div>
        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Identifiant Partenaire Booking.com</label>
        <input type="text" name="booking_partner_id" value="<?= e($settings->get('booking_partner_id')) ?>" class="w-full max-w-sm rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#635bff]">
      </div>
    </div>
  </div>

  <div class="flex justify-end">
    <button type="submit" class="px-4 py-2 bg-[#635bff] hover:bg-[#5851ea] text-white rounded-md text-xs font-semibold shadow-sm flex items-center gap-1.5 transition-colors">
      <i class="fi fi-rr-disk text-[11px]"></i> Enregistrer les paramètres
    </button>
  </div>
</form>