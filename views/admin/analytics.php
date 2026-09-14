<h1 style="font-family:var(--font-heading); margin-bottom:1.5rem;"><i class="fi fi-rr-chart-histogram"></i> Dashboard Analytics GA-Like</h1>

<div style="background:#0f172a; color:#fff; padding:1rem 1.5rem; border-radius:12px; display:inline-flex; align-items:center; gap:0.75rem; margin-bottom:2rem;">
  <span style="width:12px; height:12px; background:#10b981; border-radius:50%; display:inline-block; box-shadow:0 0 10px #10b981;"></span>
  <span><strong><?= $realtimeActive ?></strong> visiteurs actuellement en direct sur le site</span>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1.5rem; margin-bottom:2rem;">
  <div style="background:#fff; padding:1.5rem; border-radius:12px; box-shadow:var(--shadow-soft);">
    <span style="color:#666;">Pages Vues Totales</span>
    <h2 style="font-size:2rem; font-family:var(--font-heading);"><?= $totalViews ?></h2>
  </div>
  <div style="background:#fff; padding:1.5rem; border-radius:12px; box-shadow:var(--shadow-soft);">
    <span style="color:#666;">Sessions Uniques</span>
    <h2 style="font-size:2rem; font-family:var(--font-heading);"><?= $uniqueSessions ?></h2>
  </div>
</div>

<h2 style="font-family:var(--font-heading); margin-bottom:1rem;">Top Pages les plus Consultées</h2>

<table class="c-table">
  <thead>
    <tr>
      <th>URL / Chemin</th>
      <th>Nombre de Vues</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($topPages as $page): ?>
      <tr>
        <td><?= e($page['url_path']) ?></td>
        <td><strong><?= $page['views'] ?></strong></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>