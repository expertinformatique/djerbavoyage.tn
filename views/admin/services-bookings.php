<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
  <div>
    <h1 style="font-family:var(--font-heading); margin-bottom:0.25rem;">Gestion des Pass Séjour & Activités</h1>
    <p style="color:#64748B; font-size:0.9rem;">Suivi des réservations d'activités, des plannings clients et des accueils aéroport.</p>
  </div>
  <a href="/services" target="_blank" class="c-button c-button--outline" style="background:#fff; font-size:0.85rem;">
    <i class="fi fi-rr-eye"></i> Voir le Configurateur
  </a>
</div>

<div style="background:#fff; border-radius:12px; padding:1.5rem; box-shadow:var(--shadow-soft); margin-bottom:2rem; overflow-x:auto;">
  <table class="c-table" style="width:100%;">
    <thead>
      <tr>
        <th style="padding:0.75rem 1rem; text-align:left;">Référence Pass</th>
        <th style="padding:0.75rem 1rem; text-align:left;">Client</th>
        <th style="padding:0.75rem 1rem; text-align:left;">Total Réglé</th>
        <th style="padding:0.75rem 1rem; text-align:left;">Vol Arrivée (DJE)</th>
        <th style="padding:0.75rem 1rem; text-align:left;">Accueil Chauffeur</th>
        <th style="padding:0.75rem 1rem; text-align:right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($passes)): ?>
        <tr><td colspan="6" style="text-align:center; padding:2rem; color:#94A3B8;">Aucune commande de pass séjour pour l'instant.</td></tr>
      <?php else: ?>
        <?php foreach ($passes as $p): ?>
          <tr style="border-bottom:1px solid #F1F5F9;">
            <td style="padding:0.75rem 1rem; font-weight:700; color:var(--clr-sea-900);">
              <?= e($p['order_number']) ?>
            </td>
            <td style="padding:0.75rem 1rem; font-size:0.9rem;">
              <?= e($p['customer_email']) ?>
            </td>
            <td style="padding:0.75rem 1rem; font-weight:700;">
              <?= number_format((float)$p['total_amount'], 2) ?> €
            </td>
            <td style="padding:0.75rem 1rem; font-size:0.85rem;">
              <?php if (!empty($p['flight_number'])): ?>
                <strong><?= e($p['flight_number']) ?></strong><br>
                <span style="color:#64748B;"><?= e($p['arrival_date']) ?> à <?= e($p['arrival_time']) ?></span>
              <?php else: ?>
                <span style="color:#F59E0B; font-style:italic;">En attente infos vol</span>
              <?php endif; ?>
            </td>
            <td style="padding:0.75rem 1rem;">
              <?php if (!empty($p['transfer_status'])): ?>
                <span style="background:<?= $p['transfer_status'] === 'confirmed' ? '#DCFCE7; color:#166534;' : '#FEF3C7; color:#92400E;' ?> padding:0.25rem 0.6rem; border-radius:20px; font-size:0.78rem; font-weight:700;">
                  <?= e($p['transfer_status']) ?>
                </span>
              <?php else: ?>
                <span style="color:#94A3B8; font-size:0.82rem;">Non requis</span>
              <?php endif; ?>
            </td>
            <td style="padding:0.75rem 1rem; text-align:right;">
              <a href="/reservation/planning/<?= urlencode($p['order_number']) ?>" target="_blank" class="c-button c-button--outline" style="padding:0.4rem 0.8rem; font-size:0.8rem;">
                <i class="fi fi-rr-calendar"></i> Planning
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
