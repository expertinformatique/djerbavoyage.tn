<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($seoTitle ?? 'Djerba Voyage') ?></title>
  <meta name="description" content="<?= e($seoDescription ?? 'Guide touristique de Djerba') ?>">
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= asset('images/favicon.png') ?>">
  <link rel="shortcut icon" href="<?= asset('images/favicon.png') ?>">
  
  <!-- Flaticon UIcons -->
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  
  <!-- CSS Main -->
  <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
</head>
<body>

  <?php require __DIR__ . '/../partials/navbar.php'; ?>

  <?= $content ?>

  <footer style="background:var(--clr-dark-900); color:#fff; padding:4rem 0 2rem 0; margin-top:5rem;">
    <div class="l-container" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:2.5rem; margin-bottom:3rem;">
      <div>
        <h3 style="font-family:var(--font-heading); margin-bottom:1rem; color:var(--clr-sand-100); display:flex; align-items:center; gap:0.5rem;">
          <i class="fi fi-rr-compass" style="color:var(--clr-terracotta-500);"></i> <?= e($settings->get('site_name', 'Djerba Voyage')) ?>
        </h3>
        <p style="color:var(--clr-sand-500); font-size:0.9rem; line-height:1.7;">
          Guide touristique indépendant & conciergerie privée. Découvrez l'île de Djerba en Tunisie en toute sérénité.
        </p>
      </div>

      <div>
        <h4 style="font-family:var(--font-heading); color:#fff; margin-bottom:1rem; font-size:1.1rem;">Exploration</h4>
        <ul style="list-style:none; display:flex; flex-direction:column; gap:0.6rem; font-size:0.9rem;">
          <li><a href="<?= url('/') ?>" style="color:var(--clr-sand-500);">Accueil</a></li>
          <li><a href="<?= url('/activites') ?>" style="color:var(--clr-sand-500);">Excursions & Activités</a></li>
          <li><a href="<?= url('/itineraires') ?>" style="color:var(--clr-sand-500);">Itinéraires 3, 5 & 7 Jours</a></li>
          <li><a href="<?= url('/guide') ?>" style="color:var(--clr-sand-500);">Guides & Blog</a></li>
          <li><a href="<?= url('/shop') ?>" style="color:var(--clr-sand-500);">Boutique Guides PDF</a></li>
          <li><a href="<?= url('/concierge') ?>" style="color:var(--clr-sand-500);">Conciergerie VIP</a></li>
        </ul>
      </div>

      <div>
        <h4 style="font-family:var(--font-heading); color:#fff; margin-bottom:1rem; font-size:1.1rem;">Informations</h4>
        <ul style="list-style:none; display:flex; flex-direction:column; gap:0.6rem; font-size:0.9rem;">
          <li><a href="<?= url('/a-propos') ?>" style="color:var(--clr-sand-500);">À Propos de Nous</a></li>
          <li><a href="<?= url('/contact') ?>" style="color:var(--clr-sand-500);">Nous Contactez</a></li>
          <li><a href="<?= url('/avis') ?>" style="color:var(--clr-sand-500);">Avis Voyageurs</a></li>
          <li><a href="<?= url('/faq') ?>" style="color:var(--clr-sand-500);">Foire Aux Questions (FAQ)</a></li>
          <li><a href="<?= url('/newsletter') ?>" style="color:var(--clr-sand-500);">Newsletter & Offres VIP</a></li>
        </ul>
      </div>

      <div>
        <h4 style="font-family:var(--font-heading); color:#fff; margin-bottom:1rem; font-size:1.1rem;">Mentions & Legals</h4>
        <ul style="list-style:none; display:flex; flex-direction:column; gap:0.6rem; font-size:0.9rem;">
          <li><a href="<?= url('/politique-de-confidentialite') ?>" style="color:var(--clr-sand-500);">Politique de Confidentialité</a></li>
          <li><a href="<?= url('/divulgation-affiliation') ?>" style="color:var(--clr-sand-500);">Divulgation d'Affiliation</a></li>
        </ul>
      </div>
    </div>

    <div class="l-container" style="border-top:1px solid rgba(255,255,255,0.1); padding-top:1.5rem; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; color:var(--clr-sand-500); font-size:0.85rem;">
      <p>&copy; <?= date('Y') ?> <?= e($settings->get('site_name', 'Djerba Voyage')) ?>. Tous droits réservés.</p>
      <p>Paiements 100% Sécurisés par <i class="fi fi-rr-lock" style="color:var(--clr-terracotta-500);"></i> <strong>Stripe</strong></p>
    </div>
  </footer>

  <script type="module" src="<?= asset('js/main.js') ?>"></script>
</body>
</html>