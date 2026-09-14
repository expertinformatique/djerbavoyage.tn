<nav class="c-navbar">
  <div class="l-container c-navbar__inner">
    
    <!-- Ultra-Visible Compact Responsive Logo Brand -->
    <a href="<?= url('/') ?>" class="c-navbar__logo">
      <img src="<?= asset('images/logo.png') ?>" alt="Logo Djerba Voyage" class="c-navbar__logo-img">
      <div class="c-navbar__logo-text">
        <span class="c-navbar__brand-main">DJERBA<span style="color: var(--clr-terracotta-500);">VOYAGE</span></span>
        <span class="c-navbar__brand-sub">Guide 2026</span>
      </div>
    </a>
    
    <!-- Primary Menu Links -->
    <ul class="c-navbar__menu" id="mainNavMenu">
      <li><a href="<?= url('/') ?>" class="c-navbar__link">Accueil</a></li>
      <li><a href="<?= url('/activites') ?>" class="c-navbar__link">Activités</a></li>
      <li><a href="<?= url('/itineraires') ?>" class="c-navbar__link">Itinéraires</a></li>
      <li><a href="<?= url('/hotels-restaurants') ?>" class="c-navbar__link">Hôtels & Restos</a></li>
      <li><a href="<?= url('/shop') ?>" class="c-navbar__link">Boutique PDF</a></li>
      <li><a href="<?= url('/concierge') ?>" class="c-navbar__link">Conciergerie VIP</a></li>

      <!-- Secondary Items inside Mobile drawer -->
      <li class="nav-secondary"><a href="<?= url('/gastronomie') ?>" class="c-navbar__link">Gastronomie</a></li>
      <li class="nav-secondary"><a href="<?= url('/transports') ?>" class="c-navbar__link">Transports</a></li>
      <li class="nav-secondary"><a href="<?= url('/meteo-climat') ?>" class="c-navbar__link">Météo</a></li>
      <li class="nav-secondary"><a href="<?= url('/avis') ?>" class="c-navbar__link">Avis</a></li>
      <li class="nav-secondary"><a href="<?= url('/faq') ?>" class="c-navbar__link">FAQ</a></li>
    </ul>

    <!-- Action Group: Compact CTA + Always-Visible Burger Toggle -->
    <div class="c-navbar__actions">
      <button data-open-modal="personalizedPdfModal" class="c-navbar__cta">
        <i class="fi fi-rr-star"></i> <span class="cta-label-full">PDF Perso (9,90€)</span><span class="cta-label-short">PDF 9€</span>
      </button>

      <button class="c-navbar__toggle" id="mobileMenuToggle" aria-label="Afficher le menu">
        <i class="fi fi-rr-menu-burger"></i>
      </button>
    </div>

  </div>
</nav>