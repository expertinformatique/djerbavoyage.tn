<?php
$partnerId = (isset($settings) && $settings) ? $settings->get('booking_partner_id', '8073836') : '8073836';

/** 
 * Vue Liste des Guides — Djerba Voyage
 * Style Classique Méditerranéen & Cartes Riches
 * 
 * @var array $articles 
 */

$getCategory = function(string $title, string $desc = ''): array {
    $text = mb_strtolower($title . ' ' . $desc, 'UTF-8');
    if (str_contains($text, 'météo') || str_contains($text, 'meteo') || str_contains($text, 'baignade') || str_contains($text, 'climat') || str_contains($text, 'soleil')) {
        return ['tag' => 'meteo', 'label' => 'Météo & Plages', 'pill' => '☀️ Météo'];
    }
    if (str_contains($text, 'quad') || str_contains($text, 'désert') || str_contains($text, 'desert') || str_contains($text, 'buggy') || str_contains($text, 'dunes') || str_contains($text, 'caravane')) {
        return ['tag' => 'aventure', 'label' => 'Quads & Aventure', 'pill' => '🏎️ Aventure'];
    }
    if (str_contains($text, 'art') || str_contains($text, 'guellala') || str_contains($text, 'djerbahood') || str_contains($text, 'culture') || str_contains($text, 'histoire') || str_contains($text, 'menzel')) {
        return ['tag' => 'culture', 'label' => 'Culture & Histoire', 'pill' => '🎨 Culture'];
    }
    if (str_contains($text, 'gastronomie') || str_contains($text, 'poisson') || str_contains($text, 'restaurant') || str_contains($text, 'souk') || str_contains($text, 'cuisine')) {
        return ['tag' => 'gastronomie', 'label' => 'Gastronomie', 'pill' => '🍤 Saveurs'];
    }
    if (str_contains($text, 'kitesurf') || str_contains($text, 'jet') || str_contains($text, 'mer') || str_contains($text, 'nautique') || str_contains($text, 'lagune')) {
        return ['tag' => 'mer', 'label' => 'Nautisme & Mer', 'pill' => '🏄 Nautisme'];
    }
    return ['tag' => 'guide', 'label' => 'Guide Pratique', 'pill' => '🏝️ Guide'];
};
?>

<style>
.c-button--booking-affiliate {
  background-color: #003580;
  color: #ffffff !important;
  border: 1px solid #00224f;
  padding: 0.75rem 1.4rem;
  font-weight: 700;
  font-size: 0.95rem;
  border-radius: 10px;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  box-shadow: 0 4px 12px rgba(0, 53, 128, 0.25);
  transition: all 0.25s ease;
  cursor: pointer;
  text-decoration: none;
}
.c-button--booking-affiliate:hover {
  background-color: #00224f;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 53, 128, 0.35);
  color: #ffffff !important;
}
.c-button--booking-affiliate .badge-discount {
  background: #febb02;
  color: #003580;
  font-size: 0.72rem;
  font-weight: 800;
  padding: 2px 7px;
  border-radius: 12px;
  margin-left: 4px;
}
</style>
<div class="l-container">
  
  <!-- En-tête Classique Méditerranéen (Ancien Style Conservé) -->
  <div class="c-guide-header text-center">
    <span class="badge badge--gold">
      <i class="fi fi-rr-compass"></i> Guides & Carnet de Voyage 2026
    </span>
    <h1 class="heading-1">
      Tous nos Guides & Conseils de Voyage
    </h1>
    <p class="text-muted">
      Conseils pratiques, météo en direct, excursions incontournables et bons plans vérifiés pour préparer et vivre un séjour inoubliable à Djerba.
    </p>

    <!-- Bouton Affiliation Booking.com -->
    <div style="margin-top: 1.25rem; display: flex; justify-content: center; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
      <button type="button" class="c-button--booking-affiliate" onclick="openBookingHotelsModal('Hôtels & Hébergements à Djerba', 'https://www.booking.com/city/tn/houmt-souk.html?aid=<?= e($partnerId) ?>')">
        <i class="fi fi-rr-bed" style="font-size: 1.1rem;"></i>
        <span>Réserver un Hôtel à Djerba (Booking.com)</span>
        <span class="badge-discount">-15% Partenaire</span>
      </button>
    </div>
  </div>

  <!-- Barre de Recherche et Filtres par Thématiques -->
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

  <!-- Grille Homogène des Guides (Structure c-card dans l-grid-cards) -->
  <div class="l-grid-cards c-blog-grid--classic" id="blogGrid">
    <?php if (empty($articles)): ?>
      <div class="c-blog-no-results">
        <i class="fi fi-rr-document c-blog-no-results__icon"></i>
        <h3 class="c-blog-no-results__title">Aucun guide disponible pour le moment</h3>
        <p class="c-blog-no-results__text">Nos reporters et concierges préparent de nouveaux carnets de voyage.</p>
      </div>
    <?php else: ?>
      <?php foreach ($articles as $art): 
        $cat = $getCategory($art->titleFr, $art->seoDescription ?? '');
        $readTime = max(2, (int)ceil(str_word_count(strip_tags($art->contentFr)) / 180));
        $excerpt = $art->seoDescription ?: substr(strip_tags($art->contentFr), 0, 140);
      ?>
        <article class="c-card c-card--blog" 
                 data-category="<?= $cat['tag'] ?>" 
                 data-title="<?= htmlspecialchars(mb_strtolower($art->titleFr, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>" 
                 data-excerpt="<?= htmlspecialchars(mb_strtolower($excerpt, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>">
          
          <?php if (!empty($art->featuredImage)): ?>
            <div class="c-card__media">
              <img src="<?= e(asset($art->featuredImage)) ?>" 
                   alt="<?= htmlspecialchars($art->titleFr, ENT_QUOTES, 'UTF-8') ?>" 
                   class="c-card__image" 
                   loading="lazy">
              <div class="c-card__badge-overlay">
                <span class="c-card__pill"><?= $cat['pill'] ?></span>
                <span class="c-card__pill">
                  <i class="fi fi-rr-eye"></i> <?= (int)$art->viewsCount ?>
                </span>
              </div>
            </div>
          <?php endif; ?>

          <div class="c-card__content">
            <div>
              <div class="c-card__meta">
                <span><i class="fi fi-rr-calendar"></i> <?= date('d/m/Y', strtotime($art->publishedAt ?? 'now')) ?></span>
                <span><i class="fi fi-rr-clock"></i> <?= $readTime ?> min</span>
              </div>

              <h3 class="c-card__title">
                <a href="<?= url('/guide/' . e($art->slug)) ?>">
                  <?= htmlspecialchars($art->titleFr, ENT_QUOTES, 'UTF-8') ?>
                </a>
              </h3>

              <p class="c-card__excerpt">
                <?= htmlspecialchars($excerpt, ENT_QUOTES, 'UTF-8') ?>...
              </p>
            </div>

            <div class="c-card__footer">
              <a href="<?= url('/guide/' . e($art->slug)) ?>" class="c-button c-button--secondary c-button--sm">
                <span>Lire le guide</span>
                <i class="fi fi-rr-arrow-right"></i>
              </a>
              <div class="c-card__actions-group">
                <button type="button" class="c-card__booking-btn" title="Voir les Hôtels proches sur Booking.com" onclick="openBookingHotelsModal('<?= e(addslashes($art->titleFr)) ?>', 'https://www.booking.com/city/tn/houmt-souk.html?aid=<?= e($partnerId) ?>')">
                  <i class="fi fi-rr-bed"></i>
                  <span>Hôtels</span>
                </button>
                <a href="<?= url('/guide/' . e($art->slug) . '/pdf') ?>" target="_blank" class="c-card__pdf-btn" title="Télécharger la fiche pratique PDF">
                  <i class="fi fi-rr-file-pdf"></i>
                  <span>PDF</span>
                </a>
              </div>
            </div>


          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- Pagination des Guides -->
  <?php if (!empty($totalPages) && $totalPages > 1): ?>
    <nav class="c-blog-pagination" id="blogPagination" aria-label="Pagination des guides">
      <div class="c-blog-pagination__info">
        Page <strong><?= (int)$page ?></strong> sur <strong><?= (int)$totalPages ?></strong> (<strong><?= number_format((int)$total) ?></strong> guides au total)
      </div>
      <div class="c-blog-pagination__list">
        <?php if ($page > 1): ?>
          <a href="<?= url('/guide?page=' . ($page - 1)) ?>" class="c-blog-pagination__btn" title="Page précédente">
            <i class="fi fi-rr-angle-left"></i>
            <span>Précédent</span>
          </a>
        <?php else: ?>
          <span class="c-blog-pagination__btn is-disabled">
            <i class="fi fi-rr-angle-left"></i>
            <span>Précédent</span>
          </span>
        <?php endif; ?>

        <?php
        $startPage = max(1, $page - 2);
        $endPage   = min($totalPages, $page + 2);
        
        if ($startPage > 1): ?>
          <a href="<?= url('/guide?page=1') ?>" class="c-blog-pagination__num">1</a>
          <?php if ($startPage > 2): ?>
            <span class="c-blog-pagination__dots">&hellip;</span>
          <?php endif; ?>
        <?php endif; ?>

        <?php for ($p = $startPage; $p <= $endPage; $p++): ?>
          <?php if ($p == $page): ?>
            <span class="c-blog-pagination__num is-active"><?= $p ?></span>
          <?php else: ?>
            <a href="<?= url('/guide?page=' . $p) ?>" class="c-blog-pagination__num"><?= $p ?></a>
          <?php endif; ?>
        <?php endfor; ?>

        <?php if ($endPage < $totalPages): ?>
          <?php if ($endPage < $totalPages - 1): ?>
            <span class="c-blog-pagination__dots">&hellip;</span>
          <?php endif; ?>
          <a href="<?= url('/guide?page=' . $totalPages) ?>" class="c-blog-pagination__num"><?= $totalPages ?></a>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
          <a href="<?= url('/guide?page=' . ($page + 1)) ?>" class="c-blog-pagination__btn" title="Page suivante">
            <span>Suivant</span>
            <i class="fi fi-rr-angle-right"></i>
          </a>
        <?php else: ?>
          <span class="c-blog-pagination__btn is-disabled">
            <span>Suivant</span>
            <i class="fi fi-rr-angle-right"></i>
          </span>
        <?php endif; ?>
      </div>
    </nav>
  <?php endif; ?>

  <div class="c-blog-no-results c-blog-no-results--hidden" id="blogSearchEmpty">
    <i class="fi fi-rr-search c-blog-no-results__icon"></i>
    <h3 class="c-blog-no-results__title">Aucun guide ne correspond à votre recherche</h3>
    <p class="c-blog-no-results__text">Essayez un autre mot-clé ou sélectionnez une autre thématique ci-dessus.</p>

    <!-- Bouton Affiliation Booking.com -->
    <div style="margin-top: 1.25rem; display: flex; justify-content: center; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
      <button type="button" class="c-button--booking-affiliate" onclick="openBookingHotelsModal('Hôtels & Hébergements à Djerba', 'https://www.booking.com/city/tn/houmt-souk.html?aid=<?= e($partnerId) ?>')">
        <i class="fi fi-rr-bed" style="font-size: 1.1rem;"></i>
        <span>Réserver un Hôtel à Djerba (Booking.com)</span>
        <span class="badge-discount">-15% Partenaire</span>
      </button>
    </div>
  </div>

</div>

<script>
/* Recherche en direct et filtre par catégorie */
(function() {
  var searchInput = document.getElementById('blogSearchInput');
  var clearBtn    = document.getElementById('blogSearchClear');
  var filterGroup = document.getElementById('blogFilterGroup');
  var counterEl   = document.getElementById('blogCounter');
  var emptyMsg    = document.getElementById('blogSearchEmpty');
  var paginationEl= document.getElementById('blogPagination');
  var cards       = document.querySelectorAll('.c-card--blog');
  var currentCategory = 'all';

  function applyFilters() {
    var query = (searchInput ? searchInput.value.toLowerCase().trim() : '');
    if (clearBtn) clearBtn.style.display = query.length > 0 ? 'block' : 'none';

    var visibleCount = 0;
    cards.forEach(function(card) {
      var cat = card.getAttribute('data-category');
      var title = card.getAttribute('data-title') || '';
      var excerpt = card.getAttribute('data-excerpt') || '';

      var matchesCat = (currentCategory === 'all' || cat === currentCategory);
      var matchesSearch = (!query || title.indexOf(query) !== -1 || excerpt.indexOf(query) !== -1);

      if (matchesCat && matchesSearch) {
        card.style.display = '';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    if (counterEl) {
      counterEl.textContent = visibleCount + ' article' + (visibleCount > 1 ? 's' : '') + ' trouvé' + (visibleCount > 1 ? 's' : '');
    }

    if (paginationEl) {
      if (query.length > 0 || currentCategory !== 'all') {
        paginationEl.style.display = 'none';
      } else {
        paginationEl.style.display = '';
      }
    }

    if (emptyMsg) {
      if (visibleCount === 0) {
        emptyMsg.classList.remove('c-blog-no-results--hidden');
      } else {
        emptyMsg.classList.add('c-blog-no-results--hidden');
      }
    }
  }

  if (searchInput) searchInput.addEventListener('input', applyFilters);
  if (clearBtn) clearBtn.addEventListener('click', function() {
    searchInput.value = '';
    applyFilters();
    searchInput.focus();
  });

  if (filterGroup) {
    filterGroup.addEventListener('click', function(e) {
      var btn = e.target.closest('.c-blog-filter-btn');
      if (!btn) return;
      filterGroup.querySelectorAll('.c-blog-filter-btn').forEach(function(b) { b.classList.remove('is-active'); });
      btn.classList.add('is-active');
      currentCategory = btn.getAttribute('data-filter') || 'all';
      applyFilters();
    });
  }
})();
</script>