<h1 style="font-family:var(--font-heading); margin-bottom:1.5rem;">Tableau de Bord Général</h1>

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:1.5rem; margin-bottom:2rem;">
  <div style="background:#fff; padding:1.5rem; border-radius:12px; box-shadow:var(--shadow-soft);">
    <span style="color:#666; font-size:0.9rem;">Commandes Payées</span>
    <h2 style="font-size:2rem; font-family:var(--font-heading); color:var(--clr-sea-600);"><?= $paidCount ?></h2>
  </div>
  <div style="background:#fff; padding:1.5rem; border-radius:12px; box-shadow:var(--shadow-soft);">
    <span style="color:#666; font-size:0.9rem;">Chiffre d'Affaires</span>
    <h2 style="font-size:2rem; font-family:var(--font-heading); color:var(--clr-terracotta-500);"><?= number_format($totalRevenue, 2) ?> €</h2>
  </div>
  <div style="background:#fff; padding:1.5rem; border-radius:12px; box-shadow:var(--shadow-soft);">
    <span style="color:#666; font-size:0.9rem;">Tickets Conciergerie</span>
    <h2 style="font-size:2rem; font-family:var(--font-heading); color:var(--clr-sea-900);"><?= (int)$pendingConcierge ?></h2>
  </div>
  <div style="background:#fff; padding:1.5rem; border-radius:12px; box-shadow:var(--shadow-soft);">
    <span style="color:#666; font-size:0.9rem;">Projets Séjours IA</span>
    <h2 style="font-size:2rem; font-family:var(--font-heading); color:#F59E0B;"><?= (int)($pendingAiLeads ?? 0) ?></h2>
  </div>
</div>

<h2 style="font-family:var(--font-heading); margin-bottom:1rem;">Dernières Commandes</h2>

<table class="c-table">
  <thead>
    <tr>
      <th>Numéro</th>
      <th>Client Email</th>
      <th>Montant</th>
      <th>Statut</th>
      <th>Type</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($recentOrders)): ?>
      <tr><td colspan="5" style="text-align:center; padding:1.5rem;">Aucune commande pour le moment.</td></tr>
    <?php else: ?>
      <?php foreach ($recentOrders as $order): ?>
        <tr>
          <td><?= e($order->orderNumber) ?></td>
          <td><?= e($order->customerEmail) ?></td>
          <td><?= number_format($order->totalAmount, 2) ?> €</td>
          <td><span style="background:#e0f2fe; color:#0369a1; padding:0.2rem 0.6rem; border-radius:4px; font-weight:600; font-size:0.85rem;"><?= e($order->status) ?></span></td>
          <td><?= e($order->type) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>