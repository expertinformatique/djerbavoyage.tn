<?php
/**
 * Vue d'administration : Listing des Articles de Blog & Guides
 */
?>

<div class="p-4 sm:p-6 space-y-6 max-w-7xl mx-auto">

  <!-- En-tête -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
        <a href="<?= url('/admin/dashboard') ?>" class="hover:text-slate-700 dark:hover:text-slate-300">Dashboard</a>
        <span>/</span>
        <span class="text-slate-900 dark:text-slate-100 font-medium">Contenu</span>
        <span>/</span>
        <span class="text-[#635bff] font-medium">Articles & Blog</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
        <i class="fi fi-rr-document-signed text-[#635bff]"></i>
        Gestion des Articles & Guides
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
        Rédigez, éditez et générez automatiquement vos articles de voyage pour Djerba.
      </p>
    </div>

    <!-- Actions globales -->
    <div class="flex items-center gap-2.5">
      <form method="POST" action="<?= url('/admin/articles/generate-ai') ?>" onsubmit="return confirm('Lancer la génération automatique d\'un article de blog optimisé SEO avec Gemini IA ?')">
        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-purple-700 dark:text-purple-300 bg-purple-50 dark:bg-purple-950/50 hover:bg-purple-100 dark:hover:bg-purple-900/60 border border-purple-200 dark:border-purple-800 rounded-md shadow-xs transition-colors">
          <i class="fi fi-rr-sparkles"></i>
          <span>Générer avec l'IA</span>
        </button>
      </form>
      <a href="<?= url('/admin/articles/create') ?>" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-[#635bff] hover:bg-[#5349e0] rounded-md shadow-xs transition-colors">
        <i class="fi fi-rr-plus"></i>
        <span>Nouvel Article</span>
      </a>
    </div>
  </div>

  <!-- Messages Flash -->
  <?php if (!empty($flashSuccess)): ?>
    <div class="p-3.5 text-xs font-medium text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 rounded-lg flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="fi fi-rr-check-circle text-emerald-600 dark:text-emerald-400 text-sm"></i>
        <span><?= htmlspecialchars($flashSuccess, ENT_QUOTES, 'UTF-8') ?></span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm">&times;</button>
    </div>
  <?php endif; ?>

  <?php if (!empty($flashError)): ?>
    <div class="p-3.5 text-xs font-medium text-rose-800 dark:text-rose-300 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 rounded-lg flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="fi fi-rr-cross-circle text-rose-600 dark:text-rose-400 text-sm"></i>
        <span><?= htmlspecialchars($flashError, ENT_QUOTES, 'UTF-8') ?></span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 text-sm">&times;</button>
    </div>
  <?php endif; ?>

  <!-- KPI Metrics -->
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5">
    <div class="p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xs">
      <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Articles</span>
      <span class="text-lg font-bold text-slate-900 dark:text-white mt-1 block"><?= (int)($stats['total_count'] ?? 0) ?></span>
    </div>
    <div class="p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xs">
      <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Articles Publiés</span>
      <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400 mt-1 block"><?= (int)($stats['published_count'] ?? 0) ?></span>
    </div>
    <div class="p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xs">
      <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Brouillons</span>
      <span class="text-lg font-bold text-amber-600 dark:text-amber-400 mt-1 block"><?= (int)($stats['draft_count'] ?? 0) ?></span>
    </div>
    <div class="p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xs">
      <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Lectures Totales</span>
      <span class="text-lg font-bold text-[#635bff] mt-1 block"><?= number_format((int)($stats['total_views'] ?? 0)) ?></span>
    </div>
  </div>

  <!-- Barre de Recherche & Filtres -->
  <div class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 p-3.5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <form action="<?= url('/admin/articles') ?>" method="GET" class="flex flex-wrap items-center gap-2 flex-1">
      <div class="relative flex-1 min-w-[200px]">
        <i class="fi fi-rr-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
        <input type="text" name="search" value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>" placeholder="Rechercher par titre ou mot-clé..." class="w-full pl-8 pr-3 py-1.5 text-xs rounded-md bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
      </div>
      <div class="flex items-center gap-1.5 text-xs">
        <?php foreach (['all' => 'Tous', 'published' => 'Publiés', 'draft' => 'Brouillons'] as $stKey => $stLabel): ?>
          <a href="<?= url('/admin/articles?status=' . $stKey . ($search ? '&search=' . urlencode($search) : '')) ?>" 
             class="px-2.5 py-1 rounded-md text-[11px] font-medium transition-colors <?= $status === $stKey ? 'bg-[#635bff] text-white font-semibold' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' ?>">
            <?= $stLabel ?>
          </a>
        <?php endforeach; ?>
      </div>
      <button type="submit" class="px-3 py-1.5 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 rounded-md text-xs font-semibold hover:opacity-90">Filtrer</button>
      <?php if ($search || $status !== 'all'): ?>
        <a href="<?= url('/admin/articles') ?>" class="px-2.5 py-1.5 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 text-xs">Réinitialiser</a>
      <?php endif; ?>
    </form>
  </div>

  <!-- Tableau des Articles -->
  <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto w-full">
      <table class="w-full text-xs text-left border-collapse">
        <thead class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase bg-slate-50/75 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800 tracking-wider">
          <tr>
            <th class="px-4 py-3">Article</th>
            <th class="px-4 py-3">Statut</th>
            <th class="px-4 py-3">Vues</th>
            <th class="px-4 py-3">Date</th>
            <th class="px-4 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
          <?php if (empty($articles)): ?>
            <tr>
              <td colspan="5" class="px-4 py-8 text-center text-slate-400">Aucun article trouvé.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($articles as $article): ?>
              <?php
                $isPublished = ($article->status === 'published');
                $imgSrc = $article->featuredImage ? asset($article->featuredImage) : asset('sidi_mahres.png');
              ?>
              <tr class="hover:bg-slate-50/75 dark:hover:bg-slate-800/50 transition-colors">
                <!-- Titre & Miniature -->
                <td class="px-4 py-3">
                  <div class="flex items-center gap-3">
                    <img src="<?= htmlspecialchars($imgSrc, ENT_QUOTES, 'UTF-8') ?>" alt="" class="w-12 h-10 object-cover rounded-md border border-slate-200 dark:border-slate-700 shrink-0">
                    <div class="min-w-0">
                      <a href="<?= url('/admin/articles/edit?id=' . $article->id) ?>" class="font-semibold text-slate-900 dark:text-white hover:text-[#635bff] line-clamp-1 block">
                        <?= htmlspecialchars($article->titleFr, ENT_QUOTES, 'UTF-8') ?>
                      </a>
                      <span class="text-[10px] text-slate-400 font-mono block mt-0.5 truncate max-w-xs sm:max-w-md">/guide/<?= htmlspecialchars($article->slug, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                  </div>
                </td>

                <!-- Statut -->
                <td class="px-4 py-3">
                  <?php if ($isPublished): ?>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 rounded-full">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Publié
                    </span>
                  <?php else: ?>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-bold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 rounded-full">
                      <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Brouillon
                    </span>
                  <?php endif; ?>
                </td>

                <!-- Vues -->
                <td class="px-4 py-3 text-slate-600 dark:text-slate-300 font-medium">
                  <?= number_format($article->viewsCount) ?>
                </td>

                <!-- Date -->
                <td class="px-4 py-3 text-slate-400 text-[11px] whitespace-nowrap">
                  <?= $article->publishedAt ? date('d/m/Y H:i', strtotime($article->publishedAt)) : '-' ?>
                </td>

                <!-- Actions -->
                <td class="px-4 py-3 text-right">
                  <div class="inline-flex items-center gap-1">
                    <a href="<?= url('/guide/' . urlencode($article->slug)) ?>" target="_blank" class="p-1.5 text-slate-400 hover:text-[#635bff] rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Aperçu public">
                      <i class="fi fi-rr-eye text-xs"></i>
                    </a>
                    <a href="<?= url('/admin/articles/edit?id=' . $article->id) ?>" class="p-1.5 text-slate-500 hover:text-[#635bff] rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Modifier l'article">
                      <i class="fi fi-rr-edit text-xs"></i>
                    </a>
                    <form method="POST" action="<?= url('/admin/articles/delete') ?>" onsubmit="return confirm('Supprimer définitivement cet article ?')" class="inline">
                      <input type="hidden" name="id" value="<?= $article->id ?>">
                      <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Supprimer">
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

    <!-- Pagination -->
    <?php require __DIR__ . '/../partials/pagination.php'; ?>
  </div>
</div>
