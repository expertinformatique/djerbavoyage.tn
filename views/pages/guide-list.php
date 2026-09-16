<?php
/** @var array $articles */

$getCategory = function(string $title, string $desc = ''): array {
    $text = mb_strtolower($title . ' ' . $desc, 'UTF-8');
    if (str_contains($text, 'météo') || str_contains($text, 'meteo') || str_contains($text, 'baignade') || str_contains($text, 'climat') || str_contains($text, 'soleil')) {
        return ['tag' => 'meteo', 'label' => 'Météo & Plages', 'pill' => '☀️ Météo'];
    }
    if (str_contains($text, 'quad') || str_contains($text, 'désert') || str_contains($text, 'desert') || str_contains($text, 'buggy') || str_contains($text, 'dunes')) {
        return ['tag' => 'aventure', 'label' => 'Quads & Aventure', 'pill' => '🏎️ Aventure'];
    }
    if (str_contains($text, 'art') || str_contains($text, 'guellala') || str_contains($text, 'djerbahood') || str_contains($text, 'culture') || str_contains($text, 'histoire') || str_contains($text, 'cantina')) {
        return ['tag' => 'culture', 'label' => 'Culture & Histoire', 'pill' => '🎨 Culture'];
    }
    if (str_contains($text, 'gastronomie') || str_contains($text, 'poisson') || str_contains($text, 'restaurant') || str_contains($text, 'souk') || str_contains($text, 'thé')) {
        return ['tag' => 'gastronomie', 'label' => 'Gastronomie', 'pill' => '🍤 Saveurs'];
    }
    if (str_contains($text, 'kitesurf') || str_contains($text, 'jet') || str_contains($text, 'mer') || str_contains($text, 'nautique') || str_contains($text, 'lagune')) {
        return ['tag' => 'mer', 'label' => 'Nautisme & Mer', 'pill' => '🏄 Nautisme'];
    }
    return ['tag' => 'guide', 'label' => 'Guide Pratique', 'pill' => '🏝️ Guide'];
};

$featured = !empty($articles) ? $articles[0] : null;
$listArticles = !empty($articles) ? array_slice($articles, 1) : [];
?>

<!-- Hero Section Guide & Blog -->
<section class="c-hero c-hero--blog">
  <div class="l-container">
    <div class="c-hero__badge">
      <i class="fi fi-rr-compass"></i> Guide Officiel & Carnet de Voyage 2026
    </div>
    <h1 class="c-hero__title">
      Tous nos Guides & Actualités de Djerba
    </h1>
    <p class="c-hero__subtitle">
      Météo en direct, bons plans locaux, itinéraires secrets et conseils pratiques pour vivre un séjour inoubliable sur l'île aux sables d'or.
    </p>
  </div>
</section>

<div class="l-container">

  <!-- Contrôles de Recherche et Filtres par Catégorie -->
  <div class="c-blog-controls">
    <div class="c-blog-search-wrap">
      <i class="fi fi-rr-search c-blog-search-icon"></i>
      <input type="text" 
             id="blogSearchInput" 
             class="c-blog-search-input" 
             placeholder="Rechercher un guide, un lieu, une activité (quad, plage, météo, souk)..." 
             autocomplete="off">
      <button type="button" id="blogSearchClear" class="c-blog-search-clear" aria-label="Effacer la recherche">
        <i class="fi fi-rr-cross-small"></i>
      </button>
    </div>

    <div class="c-blog-filters" id="blogFilterGroup">
      <button type="button" class="c-blog-filter-btn is-active" data-filter="all">
        <i class="fi fi-rr-apps"></i> Tous les guides
      </button>
      <button type="button" class="c-blog-filter-btn" data-filter="meteo">
        ☀️ Météo & Plages
      </button>
      <button type="button" class="c-blog-filter-btn" data-filter="aventure">
        🏎️ Quads & Aventure
      </button>
      <button type="button" class="c-blog-filter-btn" data-filter="culture">
        🎨 Culture & Street Art
      </button>
      <button type="button" class="c-blog-filter-btn" data-filter="gastronomie">
        🍤 Gastronomie & Souks
      </button>
      <button type="button" class="c-blog-filter-btn" data-filter="mer">
        🏄 Nautisme & Kitesurf
      </button>
    </div>

    <div class="c-blog-counter" id="blogCounter">
      <?= count($articles) ?> articles et guides disponibles
    </div>
  </div>

  <!-- Article Vedette (À la Une) -->
  <?php if ($featured): 
    $featCat = $getCategory($featured->titleFr, $featured->seoDescription ?? '');
    $featReadTime = max(2, (int)ceil(str_word_count(strip_tags($featured->contentFr)) / 180));
    $featExcerpt = $featured->seoDescription ?: substr(strip_tags($featured->contentFr), 0, 190);
  ?>
    <article class="c-blog-featured" 
             data-category="<?= $featCat['tag'] ?>" 
             data-title="<?= htmlspecialchars(mb_strtolower($featured->titleFr, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>" 
             data-excerpt="<?= htmlspecialchars(mb_strtolower($featExcerpt, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>">
      <?php if (!empty($featured->featuredImage)): ?>
        <div class="c-blog-featured__media">
          <img src="<?= e(asset($featured->featuredImage)) ?>" 
               alt="<?= htmlspecialchars($featured->titleFr, ENT_QUOTES, 'UTF-8') ?>" 
               class="c-blog-featured__img" 
               loading="eager">
          <div class="c-blog-featured__badges">
            <span class="c-blog-badge c-blog-badge--gold"><i class="fi fi-rr-star"></i> À la Une</span>
            <span class="c-blog-badge c-blog-badge--dark"><?= $featCat['pill'] ?></span>
          </div>
        </div>
      <?php endif; ?>

      <div class="c-blog-featured__body">
        <div class="c-blog-card__meta">
          <span><i class="fi fi-rr-calendar"></i> <?= date('d/m/Y', strtotime($featured->publishedAt ?? 'now')) ?></span>
          <span><i class="fi fi-rr-clock"></i> <?= $featReadTime ?> min de lecture</span>
          <span class="c-blog-card__author"><i class="fi fi-rr-user"></i> <?= htmlspecialchars($featured->authorName ?? 'Djerba Voyage', ENT_QUOTES, 'UTF-8') ?></span>
        </div>

        <h2 class="c-blog-featured__title">
          <a href="<?= url('/guide/' . e($featured->slug)) ?>">
            <?= htmlspecialchars($featured->titleFr, ENT_QUOTES, 'UTF-8') ?>
          </a>
        </h2>

        <p class="c-blog-featured__excerpt">
          <?= htmlspecialchars($featExcerpt, ENT_QUOTES, 'UTF-8') ?>...
        </p>

        <div class="c-blog-featured__footer">
          <a href="<?= url('/guide/' . e($featured->slug)) ?>" class="c-button c-button--primary">
            <span>Lire le guide complet</span>
            <i class="fi fi-rr-arrow-right"></i>
          </a>
          <a href="<?= url('/guide/' . e($featured->slug) . '/pdf') ?>" target="_blank" class="c-blog-card__pdf-btn" title="Télécharger la fiche PDF">
            <i class="fi fi-rr-file-pdf"></i>
            <span>Fiche PDF</span>
          </a>
        </div>
      </div>
    </article>
  <?php endif; ?>

  <!-- Grille des Guides Réguliers -->
  <div class="c-blog-grid" id="blogGrid">
    <?php foreach ($listArticles as $art): 
      $cat = $getCategory($art->titleFr, $art->seoDescription ?? '');
      $readTime = max(2, (int)ceil(str_word_count(strip_tags($art->contentFr)) / 180));
      $excerpt = $art->seoDescription ?: substr(strip_tags($art->contentFr), 0, 130);
    ?>
      <article class="c-blog-card" 
               data-category="<?= $cat['tag'] ?>" 
               data-title="<?= htmlspecialchars(mb_strtolower($art->titleFr, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>" 
               data-excerpt="<?= htmlspecialchars(mb_strtolower($excerpt, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>">
        <?php if (!empty($art->featuredImage)): ?>
          <div class="c-blog-card__media">
            <img src="<?= e(asset($art->featuredImage)) ?>" 
                 alt="<?= htmlspecialchars($art->titleFr, ENT_QUOTES, 'UTF-8') ?>" 
                 class="c-blog-card__img" 
                 loading="lazy">
            <div class="c-blog-card__badge-overlay">
              <span class="c-blog-card__pill"><?= $cat['pill'] ?></span>
              <span class="c-blog-card__pill">
                <i class="fi fi-rr-eye"></i> <?= (int)$art->viewsCount ?>
              </span>
            </div>
          </div>
        <?php endif; ?>

        <div class="c-blog-card__body">
          <div>
            <div class="c-blog-card__meta">
              <span><i class="fi fi-rr-calendar"></i> <?= date('d/m/Y', strtotime($art->publishedAt ?? 'now')) ?></span>
              <span><i class="fi fi-rr-clock"></i> <?= $readTime ?> min</span>
            </div>

            <h3 class="c-blog-card__title">
              <a href="<?= url('/guide/' . e($art->slug)) ?>">
                <?= htmlspecialchars($art->titleFr, ENT_QUOTES, 'UTF-8') ?>
              </a>
            </h3>

            <p class="c-blog-card__excerpt">
              <?= htmlspecialchars($excerpt, ENT_QUOTES, 'UTF-8') ?>...
            </p>
          </div>

          <div class="c-blog-card__footer">
            <a href="<?= url('/guide/' . e($art->slug)) ?>" class="c-blog-card__read-link">
              <span>Lire le guide</span>
              <i class="fi fi-rr-arrow-right"></i>
            </a>
            <a href="<?= url('/guide/' . e($art->slug) . '/pdf') ?>" target="_blank" class="c-blog-card__pdf-btn" title="Télécharger la fiche PDF">
              <i class="fi fi-rr-file-pdf"></i>
              <span>PDF</span>
            </a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>

    <!-- Message Aucun Résultat -->
    <div class="c-blog-no-results" id="blogNoResults" style="display: none;">
      <div class="c-blog-no-results__icon">
        <i class="fi fi-rr-search-alt"></i>
      </div>
      <h3 class="c-blog-no-results__title">Aucun guide ne correspond à votre recherche</h3>
      <p class="c-blog-no-results__text">Essayez un autre mot-clé ou réinitialisez les filtres.</p>
      <button type="button" class="c-button c-button--secondary" onclick="resetBlogFilters()">
        Voir tous les guides
      </button>
    </div>
  </div>

</div>

<script>
/* Filtrage dynamique & Recherche instantanée du blog */
(function() {
  var searchInput = document.getElementById('blogSearchInput');
  var clearBtn = document.getElementById('blogSearchClear');
  var filterGroup = document.getElementById('blogFilterGroup');
  var counter = document.getElementById('blogCounter');
  var noResults = document.getElementById('blogNoResults');
  var articles = document.querySelectorAll('.c-blog-card, .c-blog-featured');
  var activeCategory = 'all';

  function applyFilters() {
    var query = (searchInput ? searchInput.value : '').trim().toLowerCase();
    if (clearBtn) clearBtn.style.display = query.length > 0 ? 'block' : 'none';
    var visibleCount = 0;

    articles.forEach(function(el) {
      var cat = el.getAttribute('data-category') || '';
      var title = el.getAttribute('data-title') || '';
      var excerpt = el.getAttribute('data-excerpt') || '';

      var matchesCat = (activeCategory === 'all' || cat === activeCategory);
      var matchesQuery = !query || title.indexOf(query) !== -1 || excerpt.indexOf(query) !== -1;

      if (matchesCat && matchesQuery) {
        el.style.display = '';
        visibleCount++;
      } else {
        el.style.display = 'none';
      }
    });

    if (counter) {
      counter.textContent = visibleCount + (visibleCount > 1 ? ' guides trouvés' : ' guide trouvé');
    }
    if (noResults) {
      noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }
  }

  if (filterGroup) {
    filterGroup.addEventListener('click', function(e) {
      var btn = e.target.closest('.c-blog-filter-btn');
      if (!btn) return;
      filterGroup.querySelectorAll('.c-blog-filter-btn').forEach(function(b) { b.classList.remove('is-active'); });
      btn.classList.add('is-active');
      activeCategory = btn.getAttribute('data-filter') || 'all';
      applyFilters();
    });
  }

  if (searchInput) {
    searchInput.addEventListener('input', applyFilters);
  }
  if (clearBtn) {
    clearBtn.addEventListener('click', function() {
      searchInput.value = '';
      applyFilters();
      searchInput.focus();
    });
  }

  window.resetBlogFilters = function() {
    if (searchInput) searchInput.value = '';
    activeCategory = 'all';
    if (filterGroup) {
      filterGroup.querySelectorAll('.c-blog-filter-btn').forEach(function(b) { b.classList.remove('is-active'); });
      var allBtn = filterGroup.querySelector('[data-filter="all"]');
      if (allBtn) allBtn.classList.add('is-active');
    }
    applyFilters();
  };
})();
</script>