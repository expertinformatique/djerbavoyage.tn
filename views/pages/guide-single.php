<?php
$partnerId = (isset($settings) && $settings) ? $settings->get('booking_partner_id', '8073836') : '8073836';

/** 
 * Vue Article Unique — Djerba Voyage (Magazine Luxe Méditerranéen)
 * Architecture MVC, Zéro style inline, Responsive fluide
 * 
 * @var App\Models\Article $article 
 * @var array $ctaServices 
 * @var array $relatedArticles 
 */

$activeLang = $_GET['lang'] ?? (\class_exists('Core\Lang') ? \Core\Lang::getLocale() : 'fr');
if (!in_array($activeLang, ['fr', 'en', 'ar'], true)) {
    $activeLang = 'fr';
}
$displayTitle = $article->getTitle($activeLang);
$displayContent = $article->getContent($activeLang);
$isRtl = ($activeLang === 'ar');

$readingMinutes = max(2, (int)ceil(str_word_count(strip_tags($displayContent)) / 180));
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
    <a href="<?= url('/') ?>"><?= __('blog_single.breadcrumb_home') ?></a>
    <i class="fi fi-rr-angle-small-right"></i>
    <a href="<?= url('/guide') ?>"><?= __('blog_single.breadcrumb_guides') ?></a>
    <i class="fi fi-rr-angle-small-right"></i>
    <span class="c-blog-breadcrumb__current"><?= htmlspecialchars($displayTitle, ENT_QUOTES, 'UTF-8') ?></span>
  </nav>
</div>

<div class="c-article-wrapper">
  <article class="c-article-card" <?= $isRtl ? 'dir="rtl"' : '' ?>>
    
    <!-- En-tête de l'article -->
    <header class="c-article-header">
      <div class="c-article-badges-row">
        <span class="c-article-badge c-article-badge--sea">
          <?= __('blog_single.badge_official') ?>
        </span>
        <span class="c-article-badge">
          <i class="fi fi-rr-clock"></i> <?= __('blog_single.reading_time', ['min' => $readingMinutes]) ?>
        </span>
      </div>

      <!-- Sélecteur de Langue du Guide -->
      <div class="c-article-badges-row" style="margin-top:0.5rem; gap:0.35rem;">
        <a href="<?= url('/guide/' . urlencode($article->slug) . '?lang=fr') ?>" 
           class="c-article-badge <?= $activeLang === 'fr' ? 'c-article-badge--sea' : '' ?>" style="text-decoration:none; cursor:pointer;">
          🇫🇷 Français
        </a>
        <?php if (!empty($article->titleEn) || !empty($article->contentEn)): ?>
          <a href="<?= url('/guide/' . urlencode($article->slug) . '?lang=en') ?>" 
             class="c-article-badge <?= $activeLang === 'en' ? 'c-article-badge--sea' : '' ?>" style="text-decoration:none; cursor:pointer;">
            🇬🇧 English
          </a>
        <?php endif; ?>
        <?php if (!empty($article->titleAr) || !empty($article->contentAr)): ?>
          <a href="<?= url('/guide/' . urlencode($article->slug) . '?lang=ar') ?>" 
             class="c-article-badge <?= $activeLang === 'ar' ? 'c-article-badge--sea' : '' ?>" style="text-decoration:none; cursor:pointer;">
            🇹🇳 العربية
          </a>
        <?php endif; ?>
      </div>

      <h1 class="c-article-title">
        <?= htmlspecialchars($displayTitle, ENT_QUOTES, 'UTF-8') ?>
      </h1>

      <div class="c-article-meta-bar">
        <div class="c-article-meta-items">
          <span><i class="fi fi-rr-calendar"></i> <?= date('d/m/Y', strtotime($article->publishedAt ?? 'now')) ?></span>
          <span class="c-article-author">
            <i class="fi fi-rr-user"></i> <?= htmlspecialchars($article->authorName ?? 'Rédaction Djerba Voyage', ENT_QUOTES, 'UTF-8') ?>
          </span>
          <span><i class="fi fi-rr-eye"></i> <?= __('blog_single.views', ['count' => (int)$article->viewsCount]) ?></span>
        </div>

        <div class="c-article-toolbar">
          <a href="https://api.whatsapp.com/send?text=<?= urlencode($article->titleFr . ' - ' . $currentUrl) ?>" 
             target="_blank" 
             rel="noopener noreferrer" 
             class="c-article-share-btn c-article-share-btn--whatsapp" 
             title="Partager sur WhatsApp">
            <i class="fi fi-rr-paper-plane"></i>
            <span>WhatsApp</span>
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($currentUrl) ?>" 
             target="_blank" 
             rel="noopener noreferrer" 
             class="c-article-share-btn c-article-share-btn--facebook" 
             title="Partager sur Facebook">
            <i class="fi fi-rr-share"></i>
            <span>Facebook</span>
          </a>
          <a href="https://twitter.com/intent/tweet?url=<?= urlencode($currentUrl) ?>&text=<?= urlencode($article->titleFr) ?>" 
             target="_blank" 
             rel="noopener noreferrer" 
             class="c-article-share-btn c-article-share-btn--twitter" 
             title="Partager sur X (Twitter)">
            <i class="fi fi-rr-share"></i>
            <span>X</span>
          </a>
          <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($currentUrl) ?>" 
             target="_blank" 
             rel="noopener noreferrer" 
             class="c-article-share-btn c-article-share-btn--linkedin" 
             title="Partager sur LinkedIn">
            <i class="fi fi-rr-share"></i>
            <span>LinkedIn</span>
          </a>
          <button type="button" 
                  class="c-article-share-btn" 
                  onclick="copyArticleLink(this)" 
                  title="Copier le lien du guide">
            <i class="fi fi-rr-copy"></i>
            <span class="btn-text"><?= __('blog_single.copy_btn') ?></span>
          </button>
          <a href="<?= url('/guide/' . urlencode($article->slug) . '/pdf') ?>" 
             target="_blank" 
             rel="nofollow"
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
          <i class="fi fi-rr-sparkles"></i> <?= __('blog_single.summary_title') ?>
        </h3>
        <div class="c-article-ai-summary__content">
          <?= htmlspecialchars($article->summaryAi, ENT_QUOTES, 'UTF-8') ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- Lecteur Vidéo Reel 9:16 Optimisé SEO & Parfaitement Centré -->
    <?php if (!empty($article->videoUrl)): ?>
      <section class="c-article-reel" aria-label="Immersion vidéo du guide">
        <div class="c-article-reel__header">
          <div class="c-article-reel__badges">
            <span class="c-article-reel__pill">
              <i class="fi fi-rr-play-alt"></i> <?= __('blog_single.reel_badge') ?>
            </span>
            <span class="c-article-reel__meta"><?= __('blog_single.reel_meta') ?></span>
          </div>
          <span class="c-article-reel__audio">
            <i class="fi fi-rr-volume"></i> <?= __('blog_single.reel_audio') ?>
          </span>
        </div>

        <div class="c-article-reel__frame-wrap">
          <div class="c-article-reel__frame">
            <video class="c-article-reel__video" 
                   controls 
                   playsinline 
                   preload="metadata" 
                   poster="<?= !empty($article->featuredImage) ? e(asset($article->featuredImage)) : '' ?>"
                   aria-label="<?= htmlspecialchars($article->titleFr, ENT_QUOTES, 'UTF-8') ?>">
              <source src="<?= e(asset($article->videoUrl)) ?>" type="video/mp4">
              Votre navigateur ne supporte pas la lecture de vidéo HTML5.
            </video>
          </div>
        </div>

        <p class="c-article-reel__caption">
          <?= __('blog_single.reel_caption') ?>
        </p>
      </section>
    <?php endif; ?>

    <!-- Corps Rédactionnel de l'article -->
    <div class="c-article-body" <?= $isRtl ? 'dir="rtl"' : '' ?>>
      <?= $displayContent ?>
    </div>

    <!-- Barre de Partage Réseaux Sociaux en bas d'article -->
    <div class="c-article-share-bar">
      <h4 class="c-article-share-bar__title">
        <i class="fi fi-rr-share"></i> <?= __('blog_single.share_title') ?>
      </h4>
      <div class="c-article-share-bar__buttons">
        <a href="https://api.whatsapp.com/send?text=<?= urlencode($displayTitle . ' - ' . $currentUrl) ?>" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="c-article-share-btn c-article-share-btn--whatsapp" 
           title="Partager sur WhatsApp">
          <i class="fi fi-rr-paper-plane"></i>
          <span>WhatsApp</span>
        </a>
        <a href="https://facebook.com/sharer/sharer.php?u=<?= urlencode($currentUrl) ?>" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="c-article-share-btn c-article-share-btn--facebook" 
           title="Partager sur Facebook">
          <i class="fi fi-rr-share"></i>
          <span>Facebook</span>
        </a>
        <a href="https://twitter.com/intent/tweet?url=<?= urlencode($currentUrl) ?>&text=<?= urlencode($displayTitle) ?>" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="c-article-share-btn c-article-share-btn--twitter" 
           title="Partager sur X (Twitter)">
          <i class="fi fi-rr-share"></i>
          <span>X / Twitter</span>
        </a>
        <a href="https://linkedin.com/sharing/share-offsite/?url=<?= urlencode($currentUrl) ?>" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="c-article-share-btn c-article-share-btn--linkedin" 
           title="Partager sur LinkedIn">
          <i class="fi fi-rr-share"></i>
          <span>LinkedIn</span>
        </a>
        <a href="https://t.me/share/url?url=<?= urlencode($currentUrl) ?>&text=<?= urlencode($article->titleFr) ?>" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="c-article-share-btn c-article-share-btn--telegram" 
           title="Partager sur Telegram">
          <i class="fi fi-rr-paper-plane"></i>
          <span>Telegram</span>
        </a>
        <button type="button" 
                class="c-article-share-btn" 
                onclick="copyArticleLink(this)" 
                title="Copier le lien du guide">
          <i class="fi fi-rr-copy"></i>
          <span class="btn-text"><?= __('blog_single.copy_btn') ?></span>
        </button>
      </div>
    </div>

    
    <!-- Bannière Affiliation Booking.com -->
    <div class="c-article-pdf-banner mb-4" style="background: linear-gradient(135deg, #003580 0%, #00224f 100%); color: #ffffff; border: 1px solid #001838; margin-top: 1.5rem; margin-bottom: 1.5rem; border-radius: 12px; padding: 1.25rem;">
      <div>
        <h3 class="c-article-pdf-banner__title" style="color: #ffffff; font-size: 1.15rem; font-weight: 800; margin-bottom: 0.35rem;">
          <i class="fi fi-rr-bed" style="color: #febb02; margin-right: 0.5rem;"></i> <?= __('blog_single.hotel_banner_title') ?>
        </h3>
        <p class="c-article-pdf-banner__text" style="color: rgba(255, 255, 255, 0.85); font-size: 0.9rem; margin: 0;">
          <?= __('blog_single.hotel_banner_desc') ?>
        </p>
      </div>
      <button type="button" class="c-button" style="background-color: #febb02; color: #003580; font-weight: 800; border: none; padding: 0.75rem 1.25rem; border-radius: 8px; cursor: pointer; white-space: nowrap; margin-top: 0.75rem;" onclick="openBookingHotelsModal('<?= e(addslashes($article->titleFr)) ?>', 'https://www.booking.com/city/tn/houmt-souk.html?aid=<?= e($partnerId) ?>')">
        <span><?= __('blog_single.hotel_banner_btn') ?></span>
        <i class="fi fi-rr-arrow-right" style="margin-left: 0.4rem;"></i>
      </button>
    </div>

    <!-- Bannière Téléchargement PDF -->
    <div class="c-article-pdf-banner">
      <div>
        <h3 class="c-article-pdf-banner__title">
          <i class="fi fi-rr-file-pdf"></i> <?= __('blog_single.pdf_banner_title') ?>
        </h3>
        <p class="c-article-pdf-banner__text">
          <?= __('blog_single.pdf_banner_desc') ?>
        </p>
      </div>
      <a href="<?= url('/guide/' . urlencode($article->slug) . '/pdf') ?>" target="_blank" rel="nofollow" class="c-button c-button--primary">
        <span><?= __('blog_single.pdf_download_btn') ?></span>
        <i class="fi fi-rr-download"></i>
      </a>
    </div>

    <!-- Activités Recommandées (Cross-selling) -->
    <?php include ROOT_PATH . '/views/partials/blog/article_cta_services.php'; ?>

    <!-- Bannière Conciergerie VIP -->
    <div class="c-article-concierge">
      <div>
        <h4 class="c-article-concierge__title"><?= __('blog_single.concierge_title') ?></h4>
        <p class="c-article-concierge__desc"><?= __('blog_single.concierge_desc') ?></p>
      </div>
      <a href="<?= url('/concierge') ?>" class="c-button c-button--primary">
        <?= __('blog_single.concierge_btn', ['price' => money(29)]) ?>
      </a>
    </div>

    <!-- Signature Éditoriale -->
    <div class="c-article-editorial">
      <div class="c-article-editorial__avatar">
        <i class="fi fi-rr-compass"></i>
      </div>
      <div>
        <h4 class="c-article-editorial__name"><?= __('blog_single.editorial_name') ?></h4>
        <p class="c-article-editorial__desc"><?= __('blog_single.editorial_desc') ?></p>
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