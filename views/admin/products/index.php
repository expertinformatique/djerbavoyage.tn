<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
  <div>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Catalogue de Produits</h1>
    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Gérez les produits digitaux, pass et services disponibles à la vente.</p>
  </div>
  <a href="<?= url('/admin/products/create') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#635bff] hover:bg-[#5851ea] text-white rounded-md text-xs font-semibold shadow-sm transition-colors">
    <i class="fi fi-rr-plus text-[11px]"></i> Ajouter un Produit
  </a>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden">
  <div class="overflow-x-auto w-full">
    <table class="w-full text-xs text-left">
      <thead class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase bg-slate-50/75 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
        <tr>
          <th class="px-5 py-2.5">ID</th>
          <th class="px-5 py-2.5">Nom du Produit</th>
          <th class="px-5 py-2.5">Identifiant URL (Slug)</th>
          <th class="px-5 py-2.5">Prix Unitaire</th>
          <th class="px-5 py-2.5">Disponibilité</th>
          <th class="px-5 py-2.5 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
        <?php if (empty($products)): ?>
          <tr>
            <td colspan="6" class="px-5 py-8 text-center text-slate-400">
              Aucun produit configuré dans le catalogue.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($products as $product): ?>
            <tr class="hover:bg-slate-50/75 dark:hover:bg-slate-800/50 transition-colors">
              <td class="px-5 py-3 font-mono text-slate-400 text-[11px]">
                #<?= $product->id ?>
              </td>
              <td class="px-5 py-3 font-semibold text-slate-900 dark:text-white">
                <?= e($product->titleFr) ?>
              </td>
              <td class="px-5 py-3 text-slate-500 dark:text-slate-400 font-mono text-[11px]">
                <?= e($product->slug) ?>
              </td>
              <td class="px-5 py-3 font-semibold text-slate-900 dark:text-white">
                <?= number_format($product->priceEur, 2) ?> €
              </td>
              <td class="px-5 py-3">
                <?php if ($product->isActive): ?>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/80 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Actif
                  </span>
                <?php else: ?>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-600 border border-slate-200 dark:bg-slate-800 dark:text-slate-400">
                    Inactif
                  </span>
                <?php endif; ?>
              </td>
              <td class="px-5 py-3 text-right">
                <div class="flex items-center justify-end gap-1.5">
                  <a href="<?= url('/admin/products/edit?id=' . $product->id) ?>" class="text-slate-600 hover:text-[#635bff] dark:text-slate-400 dark:hover:text-indigo-400 p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Modifier">
                    <i class="fi fi-rr-edit text-xs"></i>
                  </a>
                  <form action="<?= url('/admin/products/delete') ?>" method="POST" onsubmit="return confirm('Confirmer la suppression de ce produit ?');" class="inline">
                    <input type="hidden" name="id" value="<?= $product->id ?>">
                    <button type="submit" class="text-slate-400 hover:text-red-600 p-1.5 rounded hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors" title="Supprimer">
                      <i class="fi fi-rr-trash text-xs"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
