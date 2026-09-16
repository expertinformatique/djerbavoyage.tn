<h1 style="font-family:var(--font-heading); margin-bottom:1.5rem;">Gestion de la Newsletter & Club Privé</h1>

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:1.5rem; margin-bottom:2rem;">
  <div style="background:#fff; padding:1.5rem; border-radius:12px; box-shadow:var(--shadow-soft);">
    <span style="color:#666; font-size:0.9rem;">Abonnés Actifs</span>
    <h2 style="font-size:2rem; font-family:var(--font-heading); color:var(--clr-sea-600);"><?= (int)$activeCount ?></h2>
  </div>
  <div style="background:#fff; padding:1.5rem; border-radius:12px; box-shadow:var(--shadow-soft);">
    <span style="color:#666; font-size:0.9rem;">Serveur SMTP Sortant</span>
    <div style="font-weight:700; font-size:1.1rem; color:var(--clr-sea-900); margin-top:0.4rem;">mail.djerbavoyage.tn:465</div>
    <span style="font-size:0.75rem; color:#10B981;">SSL/TLS Actif</span>
  </div>
  <div style="background:#fff; padding:1.5rem; border-radius:12px; box-shadow:var(--shadow-soft);">
    <span style="color:#666; font-size:0.9rem;">Boîte de Réception</span>
    <div style="font-weight:700; font-size:1.1rem; color:var(--clr-terracotta-500); margin-top:0.4rem;">reservation@djerbavoyage.tn</div>
    <span style="font-size:0.75rem; color:#64748B;">IMAP 993 / POP3 995</span>
  </div>
</div>

<h2 style="font-family:var(--font-heading); margin-bottom:1rem;">Liste des Inscrits</h2>

<table class="c-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Adresse E-mail</th>
      <th>Statut</th>
      <th>IP</th>
      <th>Date Inscription</th>
      <th>Désinscription</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($subscribers)): ?>
      <tr>
        <td colspan="6" style="text-align:center; padding:1.5rem;">Aucun inscrit pour le moment.</td>
      </tr>
    <?php else: ?>
      <?php foreach ($subscribers as $sub): ?>
        <tr>
          <td><?= (int)$sub['id'] ?></td>
          <td><strong><?= e($sub['email']) ?></strong></td>
          <td>
            <?php if ($sub['status'] === 'active'): ?>
              <span style="background:#dcfce7; color:#15803d; padding:0.2rem 0.6rem; border-radius:4px; font-weight:600; font-size:0.85rem;">Actif</span>
            <?php else: ?>
              <span style="background:#fee2e2; color:#b91c1c; padding:0.2rem 0.6rem; border-radius:4px; font-weight:600; font-size:0.85rem;">Désinscrit</span>
            <?php endif; ?>
          </td>
          <td><?= e($sub['ip_address'] ?? '-') ?></td>
          <td><?= e($sub['created_at']) ?></td>
          <td><?= e($sub['unsubscribed_at'] ?? '-') ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>
