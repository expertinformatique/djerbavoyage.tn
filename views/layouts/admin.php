<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Back-Office Administration | Djerba Voyage</title>
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
  <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
</head>
<body style="background:#f4f6f8;">
  <?php if (!empty($_SESSION['admin_logged'])): ?>
    <div style="display:flex; min-height:100vh;">
      <aside style="width:250px; background:var(--clr-dark-900); color:#fff; padding:1.5rem;">
        <h2 style="font-size:1.2rem; margin-bottom:2rem; font-family:var(--font-heading); color:var(--clr-sand-100);">
          <i class="fi fi-rr-settings"></i> Admin Panel
        </h2>
        <ul style="list-style:none; display:flex; flex-direction:column; gap:1rem;">
          <li><a href="/admin/dashboard" style="color:#fff;"><i class="fi fi-rr-dashboard"></i> Tableau de bord</a></li>
          <li><a href="/admin/services-bookings" style="color:#fff;"><i class="fi fi-rr-plane-arrival"></i> Pass & Activités</a></li>
          <li><a href="/admin/analytics" style="color:#fff;"><i class="fi fi-rr-chart-histogram"></i> Analytics GA-Like</a></li>
          <li><a href="/admin/settings" style="color:#fff;"><i class="fi fi-rr-settings-sliders"></i> Configuration Site</a></li>
          <li><a href="/admin/newsletter" style="color:#fff;"><i class="fi fi-rr-envelope"></i> Newsletter</a></li>
          <li><a href="/admin/audit" style="color:#fff;"><i class="fi fi-rr-shield-check"></i> Audit & Anti-Fraude</a></li>
          <li style="margin-top:2rem;"><a href="/admin/logout" style="color:var(--clr-terracotta-500);"><i class="fi fi-rr-sign-out-alt"></i> Déconnexion</a></li>
        </ul>
      </aside>

      <main style="flex:1; padding:2rem;">
        <?= $content ?>
      </main>
    </div>
  <?php else: ?>
    <?= $content ?>
  <?php endif; ?>
</body>
</html>