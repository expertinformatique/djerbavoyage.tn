<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
  <div>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
      <?= $product ? 'Modifier le Produit' : 'Créer un Produit' ?>
    </h1>
    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Configurez les caractéristiques, le tarif et la disponibilité du produit.</p>
  </div>
  <a href="<?= url('/admin/products') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 rounded-md text-xs font-semibold hover:bg-slate-50 shadow-sm transition-colors">
    <i class="fi fi-rr-arrow-left text-[10px]"></i> Retour à la liste
  </a>
</div>

<?php if (!empty($error)): ?>
  <div class="mb-6 p-3.5 rounded-lg bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900/50 text-red-700 dark:text-red-400 text-xs font-medium flex items-center gap-2">
    <i class="fi fi-rr-cross-circle text-sm"></i>
    <?= e($error) ?>
  </div>
<?php endif; ?>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden max-w-2xl">
  <form action="" method="POST" class="p-6 space-y-5">
    
    <div>
      <label for="title_fr" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
        Nom du Produit (FR) <span class="text-red-500">*</span>
      </label>
      <input type="text" id="title_fr" name="title_fr" required value="<?= $product ? e($product->titleFr) : '' ?>" class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#635bff] transition-shadow">
    </div>

    <div>
      <label for="slug" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
        Slug (Identifiant URL unique) <span class="text-red-500">*</span>
      </label>
      <input type="text" id="slug" name="slug" required value="<?= $product ? e($product->slug) : '' ?>" class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-xs bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white font-mono focus:outline-none focus:ring-1 focus:ring-[#635bff] transition-shadow" placeholder="guide-voyage-djerba-2026">
      <p class="mt-1 text-[11px] text-slate-400">Identifiant technique pour les URL et l'API Stripe.</p>
    </div>

    <div>
      <label for="price_eur" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
        Prix (EUR) <span class="text-red-500">*</span>
      </label>
      <div class="relative max-w-xs">
        <input type="number" step="0.01" min="0" id="price_eur" name="price_eur" required value="<?= $product ? $product->priceEur : '0.00' ?>" class="w-full rounded-md border border-slate-300 dark:border-slate-700 pl-3 pr-8 py-2 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#635bff] transition-shadow">
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 text-xs">€</div>
      </div>
    </div>

    <div>
      <label for="file_path" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
        Emplacement du fichier numérique
      </label>
      <input type="text" id="file_path" name="file_path" value="<?= $product ? e($product->filePath) : '' ?>" class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#635bff] transition-shadow" placeholder="storage/downloads/guide-djerba.pdf">
    </div>

    <div class="flex items-center pt-2">
      <input type="checkbox" id="is_active" name="is_active" <?= (!$product || $product->isActive) ? 'checked' : '' ?> class="h-4 w-4 text-[#635bff] focus:ring-[#635bff] border-slate-300 rounded">
      <label for="is_active" class="ml-2.5 block text-xs font-medium text-slate-800 dark:text-slate-300">
        Produit disponible à la vente en ligne (Actif)
      </label>
    </div>

    <div class="pt-5 border-t border-slate-200 dark:border-slate-800 flex justify-end gap-2.5">
      <a href="<?= url('/admin/products') ?>" class="px-3.5 py-1.5 border border-slate-300 dark:border-slate-700 rounded-md text-xs font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 transition-colors">
        Annuler
      </a>
      <button type="submit" class="px-3.5 py-1.5 bg-[#635bff] hover:bg-[#5851ea] text-white rounded-md text-xs font-semibold shadow-sm transition-colors">
        <?= $product ? 'Enregistrer les modifications' : 'Créer le produit' ?>
      </button>
    </div>
  </form>
</div>
