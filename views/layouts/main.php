<!DOCTYPE html>
<html lang="<?= \Core\Lang::getLocale() ?>" dir="<?= \Core\Lang::getDir() ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($seoTitle ?? 'Djerba Voyage 2026 | Guide Officiel, Activités & Conciergerie VIP') ?></title>
  <meta name="description" content="<?= e($seoDescription ?? 'Guide touristique indépendant de l\'île de Djerba en Tunisie. Organisez votre séjour sur-mesure : excursions, quads, kitesurf, hôtels de charme et guides PDF.') ?>">
  <meta name="keywords" content="Djerba, voyage Djerba, guide Djerba 2026, excursion Djerba, jet ski Djerba, quad Djerba, hôtel Djerba, Djerbahood, Houmt Souk, Sidi Mahres">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

  <!-- Canonical URL -->
  <?php 
    $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
  ?>
  <link rel="canonical" href="<?= e($currentUrl) ?>">

  <!-- Open Graph / Facebook / WhatsApp -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= e($currentUrl) ?>">
  <meta property="og:title" content="<?= e($seoTitle ?? 'Djerba Voyage 2026 | Guide Officiel & Excursions VIP') ?>">
  <meta property="og:description" content="<?= e($seoDescription ?? 'Découvrez l\'île de Djerba en Tunisie : guides PDF interactifs, cartes GPS, pass activités et conciergerie VIP.') ?>">
  <meta property="og:image" content="<?= asset('images/hero.png') ?>">
  <meta property="og:locale" content="fr_FR">
  <meta property="og:site_name" content="Djerba Voyage">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= e($seoTitle ?? 'Djerba Voyage 2026') ?>">
  <meta name="twitter:description" content="<?= e($seoDescription ?? 'Guide touristique officiel & réservation d\'activités à Djerba.') ?>">
  <meta name="twitter:image" content="<?= asset('images/hero.png') ?>">

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
  
  <!-- CSS Main & Modules -->
  <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/nav.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/services-builder.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/sales-funnel-quiz.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/newsletter.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/contact.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/personalized-pdf-editor.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/locale-switcher.css') ?>">
<?php if (\Core\Lang::isRtl()): ?>
  <link rel="stylesheet" href="<?= asset('css/rtl.css') ?>">
<?php endif; ?>

  <!-- JSON-LD Structured Data Injection -->
  <?= $jsonLd ?? '' ?>

  <!-- Global App Base URL & Locale Configuration -->
  <script>
    window.APP_BASE_URL = '<?= rtrim(url(''), '/') ?>';
    window.LOCALE       = '<?= \Core\Lang::getLocale() ?>';
    window.CURRENCY     = '<?= \Core\Currency::getCurrency() ?>';
    window.CURRENCY_RATES = <?= json_encode(\Core\Currency::rates()) ?>;
  </script>
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
          <?= __('footer.description') ?>
        </p>
      </div>

      <div>
        <h4 style="font-family:var(--font-heading); color:#fff; margin-bottom:1rem; font-size:1.1rem;"><?= __('footer.exploration') ?></h4>
        <ul style="list-style:none; display:flex; flex-direction:column; gap:0.6rem; font-size:0.9rem;">
          <li><a href="<?= url('/') ?>" style="color:var(--clr-sand-500);"><?= __('footer.home') ?></a></li>
          <li><a href="<?= url('/activites') ?>" style="color:var(--clr-sand-500);"><?= __('footer.activities') ?></a></li>
          <li><a href="<?= url('/itineraires') ?>" style="color:var(--clr-sand-500);"><?= __('footer.itineraries') ?></a></li>
          <li><a href="<?= url('/guide') ?>" style="color:var(--clr-sand-500);"><?= __('footer.guides') ?></a></li>
          <li><a href="<?= url('/shop') ?>" style="color:var(--clr-sand-500);"><?= __('footer.shop') ?></a></li>
          <li><a href="<?= url('/concierge') ?>" style="color:var(--clr-sand-500);"><?= __('footer.concierge') ?></a></li>
        </ul>
      </div>

      <div>
        <h4 style="font-family:var(--font-heading); color:#fff; margin-bottom:1rem; font-size:1.1rem;"><?= __('footer.information') ?></h4>
        <ul style="list-style:none; display:flex; flex-direction:column; gap:0.6rem; font-size:0.9rem;">
          <li><a href="<?= url('/a-propos') ?>" style="color:var(--clr-sand-500);"><?= __('footer.about') ?></a></li>
          <li><a href="<?= url('/contact') ?>" style="color:var(--clr-sand-500);"><?= __('footer.contact') ?></a></li>
          <li><a href="<?= url('/avis') ?>" style="color:var(--clr-sand-500);"><?= __('footer.reviews') ?></a></li>
          <li><a href="<?= url('/faq') ?>" style="color:var(--clr-sand-500);"><?= __('footer.faq') ?></a></li>
          <li><a href="<?= url('/newsletter') ?>" style="color:var(--clr-sand-500);"><?= __('footer.newsletter') ?></a></li>
          <li><a href="tel:+353896110430" style="color:var(--clr-sand-500);">📞 🇮🇪 +353 89 611 0430</a></li>
          <li><a href="tel:+21622168875" style="color:var(--clr-sand-500);">📞 🇹🇳 +216 22 168 875</a></li>
        </ul>
      </div>

      <div>
        <h4 style="font-family:var(--font-heading); color:#fff; margin-bottom:1rem; font-size:1.1rem;"><?= __('footer.legal') ?></h4>
        <ul style="list-style:none; display:flex; flex-direction:column; gap:0.6rem; font-size:0.9rem;">
          <li><a href="<?= url('/politique-de-confidentialite') ?>" style="color:var(--clr-sand-500);"><?= __('footer.privacy') ?></a></li>
          <li><a href="<?= url('/divulgation-affiliation') ?>" style="color:var(--clr-sand-500);"><?= __('footer.affiliation') ?></a></li>
        </ul>
      </div>
    </div>

    <div class="l-container" style="border-top:1px solid rgba(255,255,255,0.1); padding-top:1.5rem; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; color:var(--clr-sand-500); font-size:0.85rem;">
      <p><?= __('footer.copyright', ['year' => date('Y'), 'name' => e($settings->get('site_name', 'Djerba Voyage'))]) ?></p>
      <p><?= __('footer.payments') ?> <i class="fi fi-rr-lock" style="color:var(--clr-terracotta-500);"></i> <strong>Stripe</strong></p>
    </div>
  </footer>

  <?php require __DIR__ . '/../partials/personalized_pdf_modal.php'; ?>

  <script type="module" src="<?= asset('js/main.js') ?>"></script>
</body>
</html>