<!DOCTYPE html>
<html lang="<?= \Core\Lang::getLocale() ?>" dir="<?= \Core\Lang::getDir() ?>">
<head>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-GFH621GF28"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-GFH621GF28');
  </script>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($seoTitle ?? 'Djerba Voyage 2026 : Guide Officiel, Excursions et Activités') ?></title>
  <meta name="description" content="<?= e($seoDescription ?? 'Préparez votre voyage à Djerba : guides complets, réservation d\'excursions, quads, sorties en mer et conciergerie VIP.') ?>">
  <meta name="keywords" content="Djerba, voyage Djerba, guide Djerba 2026, excursion Djerba, jet ski Djerba, quad Djerba, hôtel Djerba, Djerbahood, Houmt Souk, Sidi Mahres">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

  <!-- Canonical & International SEO (Hreflang) -->
  <?php 
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http');
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $baseUrl = $scheme . '://' . $host;
    $currentPath = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    $cleanUrl = $baseUrl . $currentPath;
    $currentLocale = \Core\Lang::getLocale();
    $canonicalUrl = ($currentLocale === 'fr') ? $cleanUrl : ($cleanUrl . '?lang=' . $currentLocale);
    $videoAbsoluteUrl = !empty($ogVideo) ? (str_starts_with($ogVideo, 'http') ? $ogVideo : ($baseUrl . '/' . ltrim($ogVideo, '/'))) : '';

    $ogLocaleMap = [
      'fr' => 'fr_FR',
      'en' => 'en_US',
      'ar' => 'ar_TN'
    ];
    $currentOgLocale = $ogLocaleMap[$currentLocale] ?? 'fr_FR';
  ?>
  <link rel="canonical" href="<?= e($canonicalUrl) ?>">
  <link rel="alternate" hreflang="fr" href="<?= e($cleanUrl) ?>">
  <link rel="alternate" hreflang="en" href="<?= e($cleanUrl) ?>?lang=en">
  <link rel="alternate" hreflang="ar" href="<?= e($cleanUrl) ?>?lang=ar">
  <link rel="alternate" hreflang="x-default" href="<?= e($cleanUrl) ?>">

  <!-- Open Graph / Facebook / WhatsApp -->
  <meta property="og:type" content="<?= !empty($ogVideo) ? 'video.other' : 'website' ?>">
  <meta property="og:url" content="<?= e($canonicalUrl) ?>">
  <meta property="og:title" content="<?= e($seoTitle ?? 'Djerba Voyage 2026 : Guide Officiel, Activités & Excursions') ?>">
  <meta property="og:description" content="<?= e($seoDescription ?? 'Préparez votre séjour à Djerba : guides complets, réservation d\'excursions, quads, sorties en mer et conciergerie VIP sur-mesure.') ?>">
  <meta property="og:image" content="<?= e(!empty($ogImage) ? $ogImage : asset('images/hero.png')) ?>">
  <?php if (!empty($ogVideo)): ?>
  <meta property="og:video" content="<?= e($videoAbsoluteUrl) ?>">
  <meta property="og:video:secure_url" content="<?= e($videoAbsoluteUrl) ?>">
  <meta property="og:video:type" content="video/mp4">
  <meta property="og:video:width" content="720">
  <meta property="og:video:height" content="1280">
  <?php endif; ?>
  <meta property="og:locale" content="<?= e($currentOgLocale) ?>">
  <?php foreach ($ogLocaleMap as $locKey => $locValue): ?>
    <?php if ($locKey !== $currentLocale): ?>
  <meta property="og:locale:alternate" content="<?= e($locValue) ?>">
    <?php endif; ?>
  <?php endforeach; ?>
  <meta property="og:site_name" content="Djerba Voyage">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="<?= !empty($ogVideo) ? 'player' : 'summary_large_image' ?>">
  <meta name="twitter:title" content="<?= e($seoTitle ?? 'Djerba Voyage 2026 : Guide Officiel, Activités & Excursions') ?>">
  <meta name="twitter:description" content="<?= e($seoDescription ?? 'Préparez votre séjour à Djerba : guides complets, réservation d\'excursions, quads, sorties en mer et conciergerie VIP sur-mesure.') ?>">
  <meta name="twitter:image" content="<?= e(!empty($ogImage) ? $ogImage : asset('images/hero.png')) ?>">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= asset('images/favicon.png') ?>">
  <link rel="shortcut icon" href="<?= asset('images/favicon.png') ?>">
  
  <!-- Flaticon UIcons -->
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  
  <!-- CSS Main & Modules -->
  <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/cards.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/blog.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/nav.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/mobile-nav.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/tabs.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/services-builder.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/sales-funnel-quiz.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/newsletter.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/contact.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/personalized-pdf-editor.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/components/locale-switcher.css') ?>">
<?php if (\Core\Lang::isRtl()): ?>
  <link rel="stylesheet" href="<?= asset('css/rtl.css') ?>">
<?php endif; ?>

  <!-- JSON-LD Structured Data Injection (Schema.org) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "WebSite",
        "@id": "<?= e($baseUrl) ?>/#website",
        "url": "<?= e($baseUrl) ?>/",
        "name": "Djerba Voyage",
        "description": "Guide touristique officiel et agence d'excursions sur l'île de Djerba en Tunisie.",
        "inLanguage": "<?= \Core\Lang::getLocale() ?>",
        "potentialAction": {
          "@type": "SearchAction",
          "target": "<?= e($baseUrl) ?>/guide?q={search_term_string}",
          "query-input": "required name=search_term_string"
        }
      },
      {
        "@type": ["TravelAgency", "TouristInformationCenter"],
        "@id": "<?= e($baseUrl) ?>/#organization",
        "name": "Djerba Voyage",
        "url": "<?= e($baseUrl) ?>/",
        "logo": "<?= e($baseUrl) ?>/assets/images/logo-djerba-voyage-guide-officiel.png",
        "image": "<?= e($baseUrl) ?>/assets/images/hero.png",
        "description": "Plateforme indépendante de voyage et conciergerie à Djerba : réservation d'excursions, quads, kitesurf, sorties bateau et guides personnalisés.",
        "telephone": "+216 98 000 000",
        "priceRange": "€€",
        "knowsLanguage": ["fr", "en", "ar"],
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "Zone Touristique",
          "addressLocality": "Houmt Souk",
          "addressRegion": "Médenine",
          "postalCode": "4180",
          "addressCountry": "TN"
        },
        "geo": {
          "@type": "GeoCoordinates",
          "latitude": 33.8750,
          "longitude": 10.8575
        },
        "sameAs": [
          "https://www.facebook.com/photo.djerba",
          "https://www.tiktok.com/@djerbavoyage"
        ]
      }
    ]
  }
  </script>
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

  <footer class="c-footer">
    <div class="l-container c-footer__grid">
      <div class="c-footer__col">
        <h3 class="c-footer__brand-title">
          <i class="fi fi-rr-map-marker c-footer__brand-icon"></i> <?= e((isset($settings) && $settings) ? $settings->get('site_name', 'Djerba Voyage') : 'Djerba Voyage') ?>
        </h3>
        <p class="c-footer__brand-desc">
          <?= __('footer.description') ?>
        </p>
      </div>

      <div class="c-footer__col">
        <h4 class="c-footer__title"><?= __('footer.exploration') ?></h4>
        <ul class="c-footer__list">
          <li><a href="<?= url('/') ?>" class="c-footer__link"><?= __('footer.home') ?></a></li>
          <li><a href="<?= url('/activites') ?>" class="c-footer__link"><?= __('footer.activities') ?></a></li>
          <li><a href="<?= url('/itineraires') ?>" class="c-footer__link"><?= __('footer.itineraries') ?></a></li>
          <li><a href="<?= url('/guide') ?>" class="c-footer__link"><?= __('footer.guides') ?></a></li>
          <li><a href="<?= url('/shop') ?>" class="c-footer__link"><?= __('footer.shop') ?></a></li>
          <li><a href="<?= url('/concierge') ?>" class="c-footer__link"><?= __('footer.concierge') ?></a></li>
        </ul>
      </div>

      <div class="c-footer__col">
        <h4 class="c-footer__title"><?= __('footer.information') ?></h4>
        <ul class="c-footer__list">
          <li><a href="<?= url('/a-propos') ?>" class="c-footer__link"><?= __('footer.about') ?></a></li>
          <li><a href="<?= url('/contact') ?>" class="c-footer__link"><?= __('footer.contact') ?></a></li>
          <li><a href="<?= url('/avis') ?>" class="c-footer__link"><?= __('footer.reviews') ?></a></li>
          <li><a href="<?= url('/faq') ?>" class="c-footer__link"><?= __('footer.faq') ?></a></li>
          <li><a href="<?= url('/newsletter') ?>" class="c-footer__link"><?= __('footer.newsletter') ?></a></li>
          <li class="c-footer__phone-item">
            <a href="tel:+353896110430" class="c-footer__phone-link" aria-label="Appeler Irlande +353 89 611 0430">
              <i class="fi fi-rr-phone-call c-footer__phone-icon"></i>
              <span class="c-footer__phone-flag">🇮🇪</span>
              <span class="c-footer__phone-num">+353 89 611 0430</span>
            </a>
          </li>
          <li class="c-footer__phone-item">
            <a href="tel:+21622168875" class="c-footer__phone-link" aria-label="Appeler Tunisie +216 22 168 875">
              <i class="fi fi-rr-phone-call c-footer__phone-icon"></i>
              <span class="c-footer__phone-flag">🇹🇳</span>
              <span class="c-footer__phone-num">+216 22 168 875</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="c-footer__col">
        <h4 class="c-footer__title"><?= __('footer.legal') ?></h4>
        <ul class="c-footer__list">
          <li><a href="<?= url('/politique-de-confidentialite') ?>" class="c-footer__link"><?= __('footer.privacy') ?></a></li>
          <li><a href="<?= url('/divulgation-affiliation') ?>" class="c-footer__link"><?= __('footer.affiliation') ?></a></li>
        </ul>
      </div>
    </div>

    <div class="l-container c-footer__bottom">
      <p><?= __('footer.copyright', ['year' => date('Y'), 'name' => e((isset($settings) && $settings) ? $settings->get('site_name', 'Djerba Voyage') : 'Djerba Voyage')]) ?></p>
      <p><?= __('footer.payments') ?> <i class="fi fi-rr-lock c-footer__lock-icon"></i> <strong>Stripe</strong></p>
    </div>
  </footer>

  <?php require __DIR__ . '/../partials/personalized_pdf_modal.php'; ?>
  <?php require __DIR__ . '/../partials/booking_hotels_modal.php'; ?>

  <script type="module" src="<?= asset('js/main.js') ?>"></script>
</body>
</html>