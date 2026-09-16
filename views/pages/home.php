<!-- Hero Section with Bespoke Background -->
<section class="c-hero" style="background: linear-gradient(180deg, rgba(15, 23, 42, 0.75) 0%, rgba(15, 23, 42, 0.95) 100%), url('<?= asset('images/hero.png') ?>') center/cover no-repeat;">
  <div class="l-container" data-animate style="text-align: center; max-width: 850px;">
    <div class="c-hero__badge" style="background: rgba(212, 175, 55, 0.15); border: 1px solid var(--clr-terracotta-500); color: #F59E0B; display: inline-flex; align-items: center; gap: 8px; padding: 6px 16px; border-radius: 50px; font-weight: 600; margin-bottom: 1.5rem;">
      <i class="fi fi-rr-star" style="color:#F59E0B;"></i> <?= __('hero.badge') ?>
    </div>
    <h1 class="c-hero__title" style="color: #FFFFFF; margin-bottom: 1.25rem;">
      <?= __('hero.title') ?>
    </h1>
    <p class="c-hero__subtitle" style="color: var(--clr-sand-100); margin-bottom: 2.5rem;">
      <?= __('hero.subtitle') ?>
    </p>
    <div style="display:flex; justify-content:center; gap:1.25rem; flex-wrap:wrap;">
      <button data-open-modal="personalizedPdfModal" class="c-button c-button--primary">
        <i class="fi fi-rr-document-signed"></i> <?= __('hero.cta_pdf') ?> (<?= money(9.90) ?>)
      </button>
      <a href="<?= url('/concierge') ?>" class="c-button c-button--secondary" style="background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.3);">
        <i class="fi fi-rr-compass"></i> <?= __('hero.cta_concierge') ?> (<?= money(29) ?>)
      </a>
    </div>
  </div>
</section>

<!-- Highlights Counter Bar -->
<section style="background: var(--clr-dark-900); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 2rem 0; color: #fff;">
  <div class="l-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; text-align: center;">
    <div>
      <div style="font-size: 2rem; font-weight: 800; color: var(--clr-terracotta-500);">300+</div>
      <div style="font-size: 0.85rem; color: var(--clr-sand-500);"><?= __('stats.sun_days') ?></div>
    </div>
    <div>
      <div style="font-size: 2rem; font-weight: 800; color: var(--clr-terracotta-500);">6</div>
      <div style="font-size: 0.85rem; color: var(--clr-sand-500);"><?= __('stats.destinations') ?></div>
    </div>
    <div>
      <div style="font-size: 2rem; font-weight: 800; color: var(--clr-terracotta-500);">80+</div>
      <div style="font-size: 0.85rem; color: var(--clr-sand-500);"><?= __('stats.guides') ?></div>
    </div>
    <div>
      <div style="font-size: 2rem; font-weight: 800; color: var(--clr-terracotta-500);">4.9 ★</div>
      <div style="font-size: 0.85rem; color: var(--clr-sand-500);"><?= __('stats.satisfaction') ?></div>
    </div>
  </div>
</section>

<!-- NOUVEAU : Bandeau Pass Séjour & Activités Sur-Mesure -->
<section style="background: linear-gradient(135deg, #03045E 0%, #0077B6 100%); color: #fff; padding: 3rem 0; margin-top: 2rem;">
  <div class="l-container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 2rem;">
    <div style="max-width: 680px;">
      <span style="background: rgba(245, 158, 11, 0.25); border: 1px solid #F59E0B; color: #F59E0B; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">
        <i class="fi fi-rr-sparkles"></i> <?= __('pass.badge') ?>
      </span>
      <h2 style="font-size: 1.85rem; margin: 10px 0; font-weight: 800; line-height: 1.25; color: #fff;">
        <?= __('pass.title') ?>
      </h2>
      <p style="font-size: 0.95rem; opacity: 0.9; line-height: 1.6;">
        <?= __('pass.subtitle') ?>
      </p>
    </div>
    <div>
      <a href="<?= url('/services') ?>" class="c-button c-button--primary" style="background: #F59E0B; border-color: #F59E0B; color: #0F172A; padding: 1rem 1.8rem; font-weight: 800; font-size: 1.05rem; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.4); display: inline-flex; align-items: center; gap: 8px;">
        <i class="fi fi-rr-sparkles"></i> <?= __('pass.cta') ?> <i class="fi fi-rr-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- Promotional Banner: Personalized PDF with Name & Photo -->
<section style="background: linear-gradient(135deg, #E07A5F 0%, #C85A3C 100%); color: #fff; padding: 2.5rem 0; margin: 3rem 0;">
  <div class="l-container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
    <div style="max-width: 650px;">
      <span style="background: rgba(255,255,255,0.2); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; text-transform: uppercase;">✨ EXCLUSIVITÉ VOYAGEUR</span>
      <h2 style="font-size: 1.75rem; margin: 8px 0; font-weight: 800; line-height: 1.2;">Votre Guide PDF Souvenir avec votre Nom & Photo de Couverture</h2>
      <p style="font-size: 0.95rem; opacity: 0.95; line-height: 1.5;">
        Personnalisez votre guide de voyage avec les noms de votre famille ou couple, vos dates et la photo de votre choix ! Génération immédiate en format PDF HD.
      </p>
    </div>
    <button data-open-modal="personalizedPdfModal" class="c-button" style="background: #ffffff; color: var(--clr-terracotta-600); padding: 0.9rem 1.75rem; font-weight: 800; font-size: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
      Personnaliser Mon PDF (9,90 €) <i class="fi fi-rr-arrow-right"></i>
    </button>
  </div>
</section>

<!-- Module Tunnel de Vente (Quiz Planificateur) -->
<div class="l-container">
  <?php require __DIR__ . '/../partials/sales_funnel_quiz.php'; ?>
</div>

<style>
/* Animation Vidéo Continue : Zoom Léger & Balayage Directionnel */
.c-destination-card {
  padding: 0 !important;
  border-radius: 16px !important;
  overflow: hidden !important;
  border: 1px solid var(--clr-sand-300) !important;
  background: #ffffff !important;
  transition: transform 0.35s ease, box-shadow 0.35s ease !important;
}

.c-destination-card:hover {
  transform: translateY(-8px) !important;
  box-shadow: 0 20px 40px rgba(0, 119, 182, 0.18) !important;
}

.c-destination-media {
  position: relative !important;
  height: 225px !important;
  width: 100% !important;
  overflow: hidden !important;
  background: #0f172a !important;
  border-radius: 16px 16px 0 0 !important;
}

.c-destination-media img.c-card__video-img {
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
  display: block !important;
  transform-origin: center center !important;
  will-change: transform !important;
  backface-visibility: hidden !important;
}

/* 6 Variantes CSS de Balayage Directionnel & Zoom Vidéo Continu */
.video-anim-1 {
  animation: djerbaPan1 5.5s ease-in-out infinite alternate !important;
}
@keyframes djerbaPan1 {
  0% { transform: scale(1.06) translate(-8%, 0%); }
  100% { transform: scale(1.26) translate(8%, 0%); }
}

.video-anim-2 {
  animation: djerbaPan2 6.2s ease-in-out infinite alternate !important;
}
@keyframes djerbaPan2 {
  0% { transform: scale(1.26) translate(0%, -6%); }
  100% { transform: scale(1.06) translate(0%, 6%); }
}

.video-anim-3 {
  animation: djerbaPan3 5.8s ease-in-out infinite alternate !important;
}
@keyframes djerbaPan3 {
  0% { transform: scale(1.08) translate(-6%, 6%); }
  100% { transform: scale(1.28) translate(6%, -6%); }
}

.video-anim-4 {
  animation: djerbaPan4 6.5s ease-in-out infinite alternate !important;
}
@keyframes djerbaPan4 {
  0% { transform: scale(1.26) translate(7%, -3%); }
  100% { transform: scale(1.08) translate(-7%, 3%); }
}

.video-anim-5 {
  animation: djerbaPan5 5.6s ease-in-out infinite alternate !important;
}
@keyframes djerbaPan5 {
  0% { transform: scale(1.06) translate(0%, 7%); }
  100% { transform: scale(1.26) translate(0%, -7%); }
}

.video-anim-6 {
  animation: djerbaPan6 6.0s ease-in-out infinite alternate !important;
}
@keyframes djerbaPan6 {
  0% { transform: scale(1.28) translate(6%, -5%); }
  100% { transform: scale(1.06) translate(-6%, 5%); }
}
</style>

<!-- Destinations Section (6 Destinations) -->
<section class="l-container" style="margin: 4rem auto;">
  <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:2rem; flex-wrap:wrap; gap:1rem;">
    <div>
      <span style="color:var(--clr-sea-600); font-weight:700; text-transform:uppercase; letter-spacing:1px; font-size:0.85rem;">Incontournables</span>
      <h2 style="font-family:var(--font-heading); font-size:2.2rem; color:var(--clr-dark-900); margin-top: 5px;">
        Les 6 Destinations Phares à Djerba
      </h2>
    </div>
    <a href="<?= url('/hotels-restaurants') ?>" style="font-family:var(--font-heading); font-weight:700; color: var(--clr-terracotta-500);">Découvrir Hôtels & Restaurants <i class="fi fi-rr-arrow-right"></i></a>
  </div>
  
  <div class="l-grid-cards" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.75rem;">
    <?php foreach ($destinations as $index => $dest): ?>
      <article class="c-card c-destination-card" data-animate>
        <div class="c-destination-media">
          <img src="<?= asset($dest['image_url'] ?? 'images/hero.png') ?>" alt="<?= e($dest['name_fr']) ?>" class="c-card__video-img video-anim-<?= ($index % 6) + 1 ?>">
          <span style="position: absolute; top: 12px; left: 12px; background: rgba(15,23,42,0.7); backdrop-filter: blur(4px); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; z-index: 2;">Djerba 2026</span>
        </div>
        <div class="c-card__content" style="padding: 1.25rem;">
          <h3 class="c-card__title" style="font-size: 1.25rem; margin-bottom: 0.5rem; color: var(--clr-dark-900);"><?= e($dest['name_fr']) ?></h3>
          <p style="color:var(--clr-gray-500); font-size:0.88rem; margin-bottom:1rem; line-height:1.45; min-height: 52px;"><?= e($dest['description_fr']) ?></p>
          <a href="<?= url('/destinations/' . e($dest['slug'])) ?>" class="c-button c-button--secondary" style="width:100%; justify-content:center; padding: 0.65rem 1rem; font-size: 0.88rem;">
            Explorer le Guide <i class="fi fi-rr-arrow-right"></i>
          </a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>

  <script>
  (function() {
    function startVideoMotion() {
      const motions = [
        { start: 'scale(1.06) translate(-8%, 0%)', end: 'scale(1.26) translate(8%, 0%)', duration: 5500 },
        { start: 'scale(1.26) translate(0%, -6%)', end: 'scale(1.06) translate(0%, 6%)', duration: 6200 },
        { start: 'scale(1.08) translate(-6%, 6%)', end: 'scale(1.28) translate(6%, -6%)', duration: 5800 },
        { start: 'scale(1.26) translate(7%, -3%)', end: 'scale(1.08) translate(-7%, 3%)', duration: 6500 },
        { start: 'scale(1.06) translate(0%, 7%)', end: 'scale(1.26) translate(0%, -7%)', duration: 5600 },
        { start: 'scale(1.28) translate(6%, -5%)', end: 'scale(1.06) translate(-6%, 5%)', duration: 6000 }
      ];

      const images = document.querySelectorAll('.c-destination-media img.c-card__video-img');
      images.forEach((img, i) => {
        const m = motions[i % motions.length];
        if (typeof img.animate === 'function') {
          img.animate([
            { transform: m.start },
            { transform: m.end }
          ], {
            duration: m.duration,
            iterations: Infinity,
            direction: 'alternate',
            easing: 'ease-in-out'
          });
        }
      });
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', startVideoMotion);
    } else {
      startVideoMotion();
    }
  })();
  </script>
</section>

<!-- VIP Concierge Feature Banner -->
<section style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #fff; padding: 4rem 0; margin: 4rem 0;">
  <div class="l-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem; align-items: center;">
    <div>
      <span style="background: rgba(212, 175, 55, 0.2); color: #F59E0B; padding: 6px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;">Service VIP Exclusif</span>
      <h2 style="font-size: 2.1rem; margin: 0.85rem 0 1rem; font-weight: 800; line-height: 1.2;">Votre Assistant Concierge Personnel sur WhatsApp</h2>
      <p style="color: var(--clr-sand-500); line-height: 1.6; margin-bottom: 1.75rem;">
        Besoin d'un quad au coucher du soleil, d'une table réservée dans un ryad secret ou d'un transfert aéroport VIP ? Notre concierge djerbien s'occupe de toutes vos réservations en temps réel.
      </p>
      <a href="<?= url('/concierge') ?>" class="c-button c-button--primary" style="padding: 0.9rem 1.75rem;">
        <i class="fi fi-rr-paper-plane"></i> Commander ma Conciergerie (29€)
      </a>
    </div>
    <div style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.1);">
      <img src="<?= asset('images/concierge.png') ?>" alt="Conciergerie VIP Djerba" style="width: 100%; height: 100%; display: block; object-fit: cover;">
    </div>
  </div>
</section>

<!-- Shop Products Section (Curated Preview & Classified Families) -->
<section style="background:var(--clr-sand-200); padding:4.5rem 0;">
  <div class="l-container">
    <div style="text-align:center; max-width:650px; margin:0 auto 3rem auto;">
      <span style="color:var(--clr-terracotta-600); font-weight:700; text-transform:uppercase; letter-spacing:1px; font-size:0.85rem;">Boutique Numérique</span>
      <h2 style="font-family:var(--font-heading); font-size:2.2rem; color:var(--clr-dark-900); margin-top: 5px;">
        Sélection de Guides PDF & Cartes Secrètes
      </h2>
      <p style="color:var(--clr-gray-500); margin-top:0.5rem;">Guides classés par familles de voyage avec téléchargement immédiat.</p>
    </div>

    <!-- Featured Curated Grid (6 Items) -->
    <div class="l-grid-cards" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.75rem;">
      <?php 
        $featured = array_slice($products, 0, 6);
        foreach ($featured as $prod): 
      ?>
        <article class="c-card" data-animate style="background: #fff; border-radius: 16px; padding: 1.5rem; border: 1px solid var(--clr-sand-300); display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.85rem;">
              <span style="background:rgba(0, 119, 182, 0.1); color:var(--clr-sea-600); padding:0.35rem 0.75rem; border-radius:20px; font-size:0.78rem; font-weight:700;">
                <i class="fi fi-rr-file-pdf"></i> Format Numérique
              </span>
              <span style="color: #F59E0B; font-weight: 700; font-size: 0.85rem;">★ 4.9</span>
            </div>
            <h3 class="c-card__title" style="font-size:1.15rem; color: var(--clr-dark-900); line-height: 1.35; margin-bottom: 0.75rem; min-height: 48px;"><?= e($prod->titleFr) ?></h3>
            <p style="color: var(--clr-gray-500); font-size: 0.85rem; line-height: 1.45;">Recommandations d'experts locaux avec cartes interactives et bons plans.</p>
          </div>
          <div style="margin-top:1.25rem; display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--clr-sand-200); padding-top:1rem;">
            <span style="font-family:var(--font-heading); font-weight:800; font-size:1.4rem; color:var(--clr-sea-900);"><?= number_format($prod->priceEur, 2) ?> €</span>
            <button class="c-button c-button--primary" onclick="buyProduct(<?= $prod->id ?>, '<?= e(addslashes($prod->titleFr)) ?>')" style="padding: 0.65rem 1.15rem; font-size: 0.88rem;">
              Acheter <i class="fi fi-rr-shopping-cart"></i>
            </button>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <!-- Prominent "Voir Plus" Button -->
    <div style="text-align: center; margin-top: 3rem;">
      <a href="<?= url('/shop') ?>" class="c-button c-button--secondary" style="padding: 1rem 2.25rem; font-size: 1.05rem;">
        Voir Tous les Guides & Cartes (80+ Produits) <i class="fi fi-rr-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- Section Blog & Guides de Voyage Récents -->
<?php require __DIR__ . '/../partials/home_blog_section.php'; ?>

<!-- Section Newsletter & Cercle Privé VIP -->
<?php require __DIR__ . '/../partials/newsletter_section.php'; ?>

<script>
function buyProduct(id, title) {
  const email = prompt("Veuillez saisir votre adresse e-mail pour recevoir le produit '" + title + "' :");
  if (!email) return;

  fetch('<?= url('/api/checkout/session') ?>', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({ product_id: id, email: email })
  })
  .then(res => res.json())
  .then(data => {
    if (data.redirect_url) {
      window.location.href = data.redirect_url;
    } else {
      alert(data.error || 'Erreur de checkout');
    }
  });
}
</script>