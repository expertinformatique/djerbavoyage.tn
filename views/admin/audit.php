<h1 style="font-family:var(--font-heading); margin-bottom:1.5rem;"><i class="fi fi-rr-shield-check"></i> Journal d'Audit & Détection Anti-Fraude</h1>

<table class="c-table">
  <thead>
    <tr>
      <th>Date</th>
      <th>Événement</th>
      <th>Sévérité</th>
      <th>Message</th>
      <th>IP</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($logs)): ?>
      <tr><td colspan="5" style="text-align:center; padding:1.5rem;">Aucun événement d'audit enregistré.</td></tr>
    <?php else: ?>
      <?php foreach ($logs as $log): ?>
        <tr>
          <td><?= e($log['created_at']) ?></td>
          <td><code><?= e($log['event_type']) ?></code></td>
          <td><span style="background:<?= $log['severity'] === 'critical' ? '#fee2e2; color:#991b1b' : '#fef3c7; color:#92400e' ?>; padding:0.2rem 0.6rem; border-radius:4px; font-weight:600; font-size:0.85rem;"><?= e(strtoupper($log['severity'])) ?></span></td>
          <td><?= e($log['message']) ?></td>
          <td><?= e($log['ip_address']) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>