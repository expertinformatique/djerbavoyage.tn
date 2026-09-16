<?php
/** 
 * Vue Article Unique — Djerba Voyage (Magazine Luxe Méditerranéen)
 * Architecture MVC, Zéro style inline, Responsive fluide
 * 
 * @var App\Models\Article $article 
 * @var array $ctaServices 
 * @var array $relatedArticles 
 */

$readingMinutes = max(2, (int)ceil(str_word_count(strip_tags($article->contentFr)) / 180));
$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
?>

<?php if (!empty($article->schemaJson)): ?>
<script type="application/ld+json">
<?= $article->schemaJson ?>
</script>
<?php endif; ?>

<!-- Barre de Progression de Lecture Flottante -->
<div class="c-article-progress" id="readingProgress"></div>

<!-- Fil d'Ariane -->
<div class="l-container">
  <nav class="c-blog-breadcrumb" aria-label="Fil d'Ariane">
    <a href="<?= url('/') ?>">Accueil</a>
    <i class="fi fi-rr-angle-small-right"></i>
    <a href="<?= url('/guide') ?>">Guides & Carnet de Voyage</a>
    <i class="fi fi-rr-angle-small-right"></i>
    <span class="c-blog-breadcrumb__current"><?= htmlspecialchars($article->titleFr, ENT_QUOTES, 'UTF-8') ?></span>
  </nav>
</div>

<div class="c-article-wrapper">
  <article class="c-article-card">
    
    <!-- En-tête de l'article -->
    <header class="c-article-header">
      <div class="c-article-badges-row">
        <span class="c-article-badge c-article-badge--sea">
          ✨ Guide Officiel Djerba Voyage
        </span>
        <span class="c-article-badge">
          <i class="fi fi-rr-clock"></i> <?= $readingMinutes ?> min de lecture
        </span>
      </div>

      <h1 class="c-article-title">
        <?= htmlspecialchars($article->titleFr, ENT_QUOTES, 'UTF-8') ?>
      </h1>

      <div class="c-article-meta-bar">
        <div class="c-article-meta-items">
          <span><i class="fi fi-rr-calendar"></i> <?= date('d/m/Y', strtotime($article->publishedAt ?? 'now')) ?></span>
          <span class="c-article-author">
            <i class="fi fi-rr-user"></i> <?= htmlspecialchars($article->authorName ?? 'Rédaction Djerba Voyage', ENT_QUOTES, 'UTF-8') ?>
          </span>
          <span><i class="fi fi-rr-eye"></i> <?= (int)$article->viewsCount ?> lectures</span>
        </div>

        <div class="c-article-toolbar">
          <a href="https://api.whatsapp.com/send?text=<?= urlencode($article->titleFr . ' - ' . $currentUrl) ?>" 
             target="_blank" 
             rel="noopener noreferrer" 
             class="c-article-share-btn c-article-share-btn--whatsapp" 
             title="Partager sur WhatsApp">
            <i class="fi fi-rr-share"></i>
            <span>WhatsApp</span>
          </a>
          <button type="button" 
                  class="c-article-share-btn" 
                  onclick="copyArticleLink(this)" 
                  title="Copier le lien du guide">
            <i class="fi fi-rr-copy"></i>
            <span class="btn-text">Copier</span>
          </button>
          <a href="<?= url('/guide/' . urlencode($article->slug) . '/pdf') ?>" 
             target="_blank" 
             class="c-article-share-btn c-article-share-btn--pdf" 
             title="Télécharger la fiche pratique PDF">
            <i class="fi fi-rr-file-pdf"></i>
            <span>PDF</span>
          </a>
        </div>
      </div>
    </header>

    <!-- Image Hero Principale -->
    <?php if (!empty($article->featuredImage)): ?>
      <div class="c-article-hero-media">
        <img src="<?= e(asset($article->featuredImage)) ?>" 
             alt="<?= htmlspecialchars($article->titleFr, ENT_QUOTES, 'UTF-8') ?>" 
             class="c-article-hero-img" 
             loading="eager" />
        <div class="c-article-hero-caption">
          <i class="fi fi-rr-camera"></i> Djerba, Tunisie
        </div>
      </div>
    <?php endif; ?>

    <!-- Encadré Résumé IA (GEO & Synthèse Voyageur) -->
    <?php if (!empty($article->summaryAi)): ?>
      <div class="c-article-ai-summary">
        <h3 class="c-article-ai-summary__title">
          <i class="fi fi-rr-sparkles"></i> L'Essentiel en Bref (Synthèse & Points Clés)
        </h3>
        <div class="c-article-ai-summary__content">
          <?= htmlspecialchars($article->summaryAi, ENT_QUOTES, 'UTF-8') ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- Corps Rédactionnel de l'article -->
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
          Téléchargez la fiche pratique officielle prête à imprimer ou à consulter hors-ligne pour votre séjour à Djerba.
        </p>
      </div>
      <a href="<?= url('/guide/' . urlencode($article->slug) . '/pdf') ?>" target="_blank" class="c-button c-button--primary">
        <span>Télécharger PDF</span>
        <i class="fi fi-rr-download"></i>
      </a>
    </div>

    <!-- Activités Recommandées (Cross-selling) -->
    <?php include ROOT_PATH . '/views/partials/blog/article_cta_services.php'; ?>

    <!-- Bannière Conciergerie VIP -->
    <div class="c-article-concierge">
      <div>
        <h4 class="c-article-concierge__title">Besoin d'un itinéraire 100% sur-mesure ?</h4>
        <p class="c-article-concierge__desc">Laissez notre conciergerie locale planifier vos journées idéales à Djerba (hôtels, quads, restos secrets).</p>
      </div>
      <a href="<?= url('/concierge') ?>" class="c-button c-button--primary">
        Demander mon itinéraire (29€)
      </a>
    </div>

    <!-- Signature Éditoriale -->
    <div class="c-article-editorial">
      <div class="c-article-editorial__avatar">
        <i class="fi fi-rr-compass"></i>
      </div>
      <div>
        <h4 class="c-article-editorial__name">Rédaction & Concierges Djerba Voyage</h4>
        <p class="c-article-editorial__desc">Nos experts locaux et guides passionnés sillonnent quotidiennement l'île pour vous offrir des conseils vérifiés, la météo en temps réel et des adresses authentiques.</p>
      </div>
    </div>

    <!-- Poursuivre votre lecture (Articles Similaires) -->
    <?php include ROOT_PATH . '/views/partials/blog/article_related.php'; ?>

  </article>
</div>

<script>
/* Indicateur de progression de lecture & Copie de lien */
(function() {
  var progressBar = document.getElementById('readingProgress');
  window.addEventListener('scroll', function() {
    var winScroll = document.documentElement.scrollTop || document.body.scrollTop;
    var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    var scrolled = height > 0 ? (winScroll / height) * 100 : 0;
    if (progressBar) progressBar.style.width = Math.min(100, Math.max(0, scrolled)) + '%';
  }, { passive: true });

  window.copyArticleLink = function(btn) {
    var textEl = btn.querySelector('.btn-text');
    navigator.clipboard.writeText(window.location.href).then(function() {
      if (textEl) textEl.textContent = 'Copié !';
      setTimeout(function() {
        if (textEl) textEl.textContent = 'Copier';
      }, 2000);
    });
  };
})();
</script>