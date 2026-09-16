<?php
/** @var App\Models\Article $article */
/** @var array $ctaServices */
?>

<?php if (!empty($article->schemaJson)): ?>
<script type="application/ld+json">
<?= $article->schemaJson ?>
</script>
<?php endif; ?>

<div class="c-article-wrapper">
  <article class="c-article-card">
    
    <!-- En-tête de l'article -->
    <div class="c-article-header">
      <div class="c-article-meta">
        <span class="c-article-badge">
          ✨ Guide Djerba Voyage
        </span>
        <span><i class="fi fi-rr-calendar"></i> <?= date('d/m/Y', strtotime($article->publishedAt ?? 'now')) ?></span>
        <span><i class="fi fi-rr-eye"></i> <?= $article->viewsCount ?> vues</span>
      </div>

      <h1 class="c-article-title">
        <?= htmlspecialchars($article->titleFr, ENT_QUOTES, 'UTF-8') ?>
      </h1>
    </div>

    <!-- Image Hero -->
    <?php if (!empty($article->featuredImage)): ?>
      <div class="c-article-hero-media">
        <img src="<?= htmlspecialchars($article->featuredImage, ENT_QUOTES, 'UTF-8') ?>" 
             alt="<?= htmlspecialchars($article->titleFr, ENT_QUOTES, 'UTF-8') ?>" 
             class="c-article-hero-img" 
             loading="lazy" />
      </div>
    <?php endif; ?>

    <!-- Encadré Résumé IA (GEO & Synthèse) -->
    <?php if (!empty($article->summaryAi)): ?>
      <div class="c-article-ai-summary">
        <h3 class="c-article-ai-summary__title">
          <i class="fi fi-rr-sparkles"></i> En résumé (Points Clés & Synthèse Voyageur)
        </h3>
        <div class="c-article-ai-summary__content">
          <?= htmlspecialchars($article->summaryAi, ENT_QUOTES, 'UTF-8') ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- Corps de l'article -->
    <div class="c-article-body">
      <?= $article->contentFr ?>
    </div>

    <!-- Bannière Téléchargement PDF -->
    <div class="c-article-pdf-banner">
      <div>
        <h3 class="c-article-pdf-banner__title">
          <i class="fi fi-rr-file-pdf"></i> Emportez ce guide en version PDF
        </h3>
        <p class="c-article-pdf-banner__text">
          Téléchargez ou imprimez la fiche pratique officielle pour votre séjour à Djerba.
        </p>
      </div>
      <a href="<?= url('/guide/' . urlencode($article->slug) . '/pdf') ?>" target="_blank" class="c-button c-button--primary">
        <span>Télécharger PDF</span>
        <i class="fi fi-rr-download"></i>
      </a>
    </div>

    <!-- Activités recommandées (Cross-selling) -->
    <?php if (!empty($ctaServices)): ?>
      <div class="c-article-services-section">
        <h3 class="c-article-services-title">
          🎯 Activités & Excursions recommandées pour cet itinéraire
        </h3>
        <div class="c-article-services-grid">
          <?php foreach ($ctaServices as $service): ?>
            <div class="c-article-service-card">
              <div>
                <h4 class="c-article-service-card__name">
                  <?= htmlspecialchars($service->titleFr, ENT_QUOTES, 'UTF-8') ?>
                </h4>
                <p class="c-article-service-card__price">
                  À partir de <?= number_format($service->priceEur, 2) ?> €
                </p>
              </div>
              <a href="<?= url('/services#' . urlencode($service->slug)) ?>" class="c-button c-button--secondary">
                Réserver
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- Bannière Conciergerie VIP -->
    <div class="c-article-concierge">
      <div>
        <h4 class="c-article-concierge__title">Besoin d'un itinéraire 100% sur-mesure ?</h4>
        <p class="c-article-concierge__desc">Laissez notre conciergerie locale planifier votre séjour idéal à Djerba.</p>
      </div>
      <a href="<?= url('/concierge') ?>" class="c-button c-button--primary">
        Demander mon itinéraire (29€)
      </a>
    </div>

  </article>
</div>