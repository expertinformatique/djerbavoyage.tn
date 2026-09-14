<div class="l-container" style="margin: 3rem auto 5rem auto;">
    <div class="text-center" style="max-width: 750px; margin: 0 auto 2rem auto;">
        <span class="badge badge--gold" style="background: rgba(212,175,55,0.15); color: #F59E0B; padding: 6px 16px; border-radius: 50px; font-weight: 700; display: inline-block; margin-bottom: 10px;">Catalogue Exclusif 2026</span>
        <h1 class="heading-1" style="margin-bottom: 12px;">Boutique Numérique & Expériences Djerba</h1>
        <p class="text-muted" style="color: var(--clr-gray-500); font-size: 1.1rem; line-height: 1.6;">
            Explorez nos 80+ guides PDF, cartes GPS interactives, billets d'excursion VIP et audio-guides. Téléchargement instantané par e-mail après paiement sécurisé.
        </p>
    </div>

    <!-- Banner Cadeau Artisanal Offert -->
    <div style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #fff; padding: 1.25rem 1.75rem; border-radius: 16px; margin-bottom: 2rem; border: 1px solid var(--clr-terracotta-500); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="font-size: 2.2rem;">🎁</div>
            <div>
                <div style="font-weight: 800; font-size: 1.1rem; color: #F59E0B;">BON CADEAU ARTISANAL INCLUS AVEC CHAQUE GUIDE PDF !</div>
                <div style="font-size: 0.88rem; color: var(--clr-sand-500);">Recevez un coupon VIP pour retirer votre produit artisanal fait main (poterie Guellala, fiole d'huile d'olive ou éponge marine) dès votre arrivée à l'Aéroport DJE !</div>
            </div>
        </div>
        <button data-open-modal="personalizedPdfModal" class="c-button c-button--primary" style="padding: 0.65rem 1.25rem; font-size: 0.88rem; white-space: nowrap;">
            <i class="fi fi-rr-star"></i> PDF Personnalisé (9,90 €)
        </button>
    </div>

    <!-- Controls Bar: Search + Category Filters -->
    <div class="card" style="padding: 1.5rem; margin-bottom: 2.5rem; background: #fff; border-radius: 16px; border: 1px solid var(--clr-sand-300); box-shadow: var(--shadow-soft);">
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
            <!-- Real-time Search -->
            <div style="flex: 1; min-width: 260px; position: relative;">
                <i class="fi fi-rr-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--clr-gray-500);"></i>
                <input type="text" id="shopSearchInput" placeholder="Rechercher un guide, carte GPS, excursion..." 
                       style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.8rem; border-radius: 30px; border: 1px solid var(--clr-sand-300); font-size: 0.95rem; outline: none; transition: border-color 0.2s;"
                       onkeyup="filterProducts()">
            </div>

            <!-- Sort By -->
            <div style="display: flex; align-items: center; gap: 10px;">
                <label for="shopSort" style="font-size: 0.9rem; font-weight: 600; color: var(--clr-dark-800); white-space: nowrap;">Trier par :</label>
                <select id="shopSort" onchange="sortProducts()" style="padding: 0.75rem 1.25rem; border-radius: 30px; border: 1px solid var(--clr-sand-300); font-size: 0.9rem; background: #fff; cursor: pointer; outline: none;">
                    <option value="default">Recommandés</option>
                    <option value="price-asc">Prix : Croissant</option>
                    <option value="price-desc">Prix : Décroissant</option>
                    <option value="title">Nom (A-Z)</option>
                </select>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="tabs" style="margin-top: 1.25rem; margin-bottom: 0; padding-bottom: 0; border-bottom: none; gap: 0.5rem; flex-wrap: wrap;">
            <button class="tab-btn active" onclick="filterCategory('all', this)">Tous (<?= count($products) ?>)</button>
            <button class="tab-btn" onclick="filterCategory('guide', this)">📖 Guides PDF</button>
            <button class="tab-btn" onclick="filterCategory('gps', this)">🗺️ Cartes GPS</button>
            <button class="tab-btn" onclick="filterCategory('pass', this)">🎟️ Pass Excursions</button>
            <button class="tab-btn" onclick="filterCategory('pack', this)">📦 Packs Complets</button>
            <button class="tab-btn" onclick="filterCategory('audio', this)">🎧 Audio-Guides</button>
        </div>
    </div>

    <!-- Product Count Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <span id="productCounter" style="font-size: 0.95rem; font-weight: 600; color: var(--clr-gray-500);">Affichage de <?= count($products) ?> produits</span>
        <span style="font-size: 0.85rem; color: var(--clr-sea-600);"><i class="fi fi-rr-lock"></i> Paiements sécurisés Stripe SSL</span>
    </div>

    <!-- Products Grid -->
    <div id="productsGrid" class="l-grid-cards" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.75rem;">
        <?php foreach ($products as $prod): 
            $titleLower = mb_strtolower($prod->titleFr);
            $catTag = 'guide';
            if (str_contains($titleLower, 'carte gps') || str_contains($titleLower, 'map')) $catTag = 'gps';
            elseif (str_contains($titleLower, 'pass') || str_contains($titleLower, 'excursion') || str_contains($titleLower, 'balade') || str_contains($titleLower, 'session')) $catTag = 'pass';
            elseif (str_contains($titleLower, 'pack')) $catTag = 'pack';
            elseif (str_contains($titleLower, 'audio')) $catTag = 'audio';
        ?>
            <article class="c-card product-item" 
                     data-title="<?= e($titleLower) ?>" 
                     data-price="<?= $prod->priceEur ?>" 
                     data-category="<?= $catTag ?>"
                     style="background: #fff; border-radius: 16px; padding: 1.5rem; border: 1px solid var(--clr-sand-300); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <span style="background: rgba(0, 119, 182, 0.1); color: var(--clr-sea-600); padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.78rem; font-weight: 700;">
                            <?php if ($catTag === 'gps'): ?>🗺️ Carte GPS
                            <?php elseif ($catTag === 'pass'): ?>🎟️ Pass VIP
                            <?php elseif ($catTag === 'pack'): ?>📦 Pack Voyage
                            <?php elseif ($catTag === 'audio'): ?>🎧 Audio MP3
                            <?php else: ?>📖 Guide PDF<?php endif; ?>
                        </span>
                        <span style="color: #F59E0B; font-weight: 700; font-size: 0.85rem;">★ 4.9</span>
                    </div>

                    <h3 class="c-card__title" style="font-size: 1.15rem; color: var(--clr-dark-900); line-height: 1.35; margin-bottom: 0.75rem; min-height: 48px;">
                        <?= e($prod->titleFr) ?>
                    </h3>
                    <p style="color: var(--clr-gray-500); font-size: 0.85rem; line-height: 1.45; margin-bottom: 1rem;">
                        Livraison numérique immédiate par e-mail avec token de téléchargement sécurisé.
                    </p>
                </div>

                <div style="border-top: 1px solid var(--clr-sand-200); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                    <div>
                        <span style="font-size: 0.75rem; color: var(--clr-gray-500); text-transform: uppercase;">Prix TTC</span>
                        <div style="font-family: var(--font-heading); font-weight: 800; font-size: 1.4rem; color: var(--clr-sea-900);">
                            <?= number_format($prod->priceEur, 2) ?> €
                        </div>
                    </div>
                    <button class="c-button c-button--primary" onclick="buyProduct(<?= $prod->id ?>, '<?= e(addslashes($prod->titleFr)) ?>')" style="padding: 0.65rem 1.15rem; font-size: 0.88rem;">
                        Acheter <i class="fi fi-rr-shopping-cart"></i>
                    </button>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>

<script>
let currentCat = 'all';

function filterProducts() {
    const searchVal = document.getElementById('shopSearchInput').value.toLowerCase().trim();
    const items = document.querySelectorAll('.product-item');
    let visibleCount = 0;

    items.forEach(item => {
        const title = item.dataset.title;
        const cat = item.dataset.category;
        
        const matchesSearch = !searchVal || title.includes(searchVal);
        const matchesCat = currentCat === 'all' || cat === currentCat;

        if (matchesSearch && matchesCat) {
            item.style.display = 'flex';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    document.getElementById('productCounter').textContent = 'Affichage de ' + visibleCount + ' produits';
}

function filterCategory(cat, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentCat = cat;
    filterProducts();
}

function sortProducts() {
    const sortVal = document.getElementById('shopSort').value;
    const grid = document.getElementById('productsGrid');
    const items = Array.from(grid.querySelectorAll('.product-item'));

    items.sort((a, b) => {
        if (sortVal === 'price-asc') return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
        if (sortVal === 'price-desc') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
        if (sortVal === 'title') return a.dataset.title.localeCompare(b.dataset.title);
        return 0;
    });

    items.forEach(item => grid.appendChild(item));
}

function buyProduct(id, title) {
    const email = prompt("Veuillez saisir votre adresse e-mail pour recevoir la commande '" + title + "' :");
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
            alert(data.error || 'Erreur lors de la création de la session Stripe.');
        }
    })
    .catch(err => {
        alert('Erreur réseau. Veuillez réessayer.');
    });
}
</script>