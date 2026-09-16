<?php
/**
 * Composant de Pagination Réutilisable pour l'Admin
 * 
 * Variables attendues :
 * - int $page : page actuelle (ex: 1)
 * - int $totalPages : nombre total de pages (ex: 5)
 * - int $total : nombre total d'enregistrements (ex: 42)
 * - int $limit : éléments par page (ex: 15)
 * - string|null $baseUrl : URL de base (optionnel, déduit de REQUEST_URI si absent)
 * - array|null $params : paramètres GET à conserver (optionnel, déduit de $_GET si absent)
 */

$page       = max(1, (int)($page ?? 1));
$totalPages = max(1, (int)($totalPages ?? 1));
$total      = max(0, (int)($total ?? 0));
$limit      = max(1, (int)($limit ?? 15));

$startItem = $total > 0 ? (($page - 1) * $limit) + 1 : 0;
$endItem   = min($page * $limit, $total);

$baseUrl = $baseUrl ?? parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
$params  = $params ?? $_GET;
unset($params['page']);

$buildUrl = function(int $targetPage) use ($baseUrl, $params): string {
    $merged = array_merge($params, ['page' => $targetPage]);
    $qs = http_build_query($merged);
    return htmlspecialchars($baseUrl . ($qs ? '?' . $qs : ''), ENT_QUOTES, 'UTF-8');
};

// Plage de numéros de pages à afficher
$pagesToShow = [];
if ($totalPages <= 7) {
    for ($i = 1; $i <= $totalPages; $i++) {
        $pagesToShow[] = $i;
    }
} else {
    $pagesToShow = [1];
    $start = max(2, $page - 1);
    $end   = min($totalPages - 1, $page + 1);

    if ($start > 2) {
        $pagesToShow[] = '...';
    }
    for ($i = $start; $i <= $end; $i++) {
        $pagesToShow[] = $i;
    }
    if ($end < $totalPages - 1) {
        $pagesToShow[] = '...';
    }
    $pagesToShow[] = $totalPages;
}
?>

<div class="px-4 py-3 border-t border-slate-200/90 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
  <!-- Compteur d'éléments -->
  <div class="text-slate-500 dark:text-slate-400 text-[11px] font-medium text-center sm:text-left">
    <?php if ($total > 0): ?>
      Affichage de <span class="font-bold text-slate-700 dark:text-slate-200"><?= $startItem ?></span> à <span class="font-bold text-slate-700 dark:text-slate-200"><?= $endItem ?></span> sur <span class="font-bold text-slate-900 dark:text-white"><?= number_format($total) ?></span> résultat<?= $total > 1 ? 's' : '' ?>
    <?php else: ?>
      Aucun résultat
    <?php endif; ?>
  </div>

  <!-- Contrôles de navigation -->
  <?php if ($totalPages > 1): ?>
    <nav class="inline-flex items-center -space-x-px rounded-md shadow-2xs isolate" aria-label="Pagination">
      <!-- Bouton Précédent -->
      <?php if ($page > 1): ?>
        <a href="<?= $buildUrl($page - 1) ?>" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-l-md border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" title="Page précédente">
          <i class="fi fi-rr-angle-small-left text-xs"></i>
          <span class="hidden sm:inline">Préc.</span>
        </a>
      <?php else: ?>
        <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-l-md border border-slate-200/60 dark:border-slate-800/60 bg-slate-50 dark:bg-slate-900/40 text-slate-400 dark:text-slate-600 cursor-not-allowed">
          <i class="fi fi-rr-angle-small-left text-xs"></i>
          <span class="hidden sm:inline">Préc.</span>
        </span>
      <?php endif; ?>

      <!-- Numéros de page -->
      <?php foreach ($pagesToShow as $p): ?>
        <?php if ($p === '...'): ?>
          <span class="inline-flex items-center px-2.5 py-1.5 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-400 dark:text-slate-600 text-xs">
            &hellip;
          </span>
        <?php elseif ($p === $page): ?>
          <span aria-current="page" class="z-10 inline-flex items-center px-3 py-1.5 border border-[#635bff] bg-[#635bff] text-white font-bold text-xs">
            <?= $p ?>
          </span>
        <?php else: ?>
          <a href="<?= $buildUrl($p) ?>" class="inline-flex items-center px-3 py-1.5 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-xs">
            <?= $p ?>
          </a>
        <?php endif; ?>
      <?php endforeach; ?>

      <!-- Bouton Suivant -->
      <?php if ($page < $totalPages): ?>
        <a href="<?= $buildUrl($page + 1) ?>" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-r-md border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" title="Page suivante">
          <span class="hidden sm:inline">Suiv.</span>
          <i class="fi fi-rr-angle-small-right text-xs"></i>
        </a>
      <?php else: ?>
        <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-r-md border border-slate-200/60 dark:border-slate-800/60 bg-slate-50 dark:bg-slate-900/40 text-slate-400 dark:text-slate-600 cursor-not-allowed">
          <span class="hidden sm:inline">Suiv.</span>
          <i class="fi fi-rr-angle-small-right text-xs"></i>
        </span>
      <?php endif; ?>
    </nav>
  <?php endif; ?>
</div>
