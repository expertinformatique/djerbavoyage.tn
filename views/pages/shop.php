<div class="l-container" style="margin: clamp(1.75rem, 3.5vw, 3.5rem) auto clamp(3rem, 5vw, 6rem) auto;">
    <div class="text-center" style="max-width: 780px; margin: 0 auto clamp(1.25rem, 2.5vw, 2.5rem) auto;">
        <span class="badge badge--gold" style="background: rgba(245, 158, 11, 0.18); border: 1px solid var(--clr-terracotta-500); color: #F59E0B; padding: 4px 16px; border-radius: 50px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px; font-size: 0.82rem;">
            <i class="fi fi-rr-sparkles"></i> Boutique 2026 — Téléchargement Immédiat
        </span>
        <h1 class="heading-1" style="margin-bottom: 8px; font-size: clamp(1.6rem, 3vw, 2.3rem);">Boutique & Guides Numériques</h1>
        <p class="text-muted hidden sm:block" style="color: var(--clr-gray-500); font-size: 1.05rem; line-height: 1.55;">
            Explorez nos 80+ guides PDF, cartes GPS interactives, billets d'excursion VIP et audio-guides. Téléchargement immédiat par e-mail après paiement sécurisé.
        </p>
        <p class="text-muted sm:hidden" style="color: var(--clr-gray-500); font-size: 0.9rem; line-height: 1.45;">
            Guides PDF, cartes GPS interactives et pass d'activités avec téléchargement immédiat.
        </p>
    </div>

    <!-- Banner Cadeau Artisanal Offert -->
    <div style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #fff; padding: clamp(1rem, 2.5vw, 1.5rem) clamp(1.15rem, 3vw, 2rem); border-radius: 20px; margin-bottom: 2rem; border: 1px solid var(--clr-terracotta-500); box-shadow: 0 15px 35px rgba(0,0,0,0.3); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 0.85rem; max-width: 100%;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(245, 158, 11, 0.2); border: 1px solid #F59E0B; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #F59E0B; flex-shrink: 0;">
                <i class="fi fi-rr-gift"></i>
            </div>
            <div>
                <div style="font-weight: 800; font-size: clamp(0.92rem, 2vw, 1.1rem); color: #F59E0B; letter-spacing: 0.2px;">CADEAU ARTISANAL INCLUS AVEC CHAQUE GUIDE !</div>
                <div class="hidden sm:block" style="font-size: 0.85rem; color: var(--clr-sand-500); margin-top: 2px; line-height: 1.4;">Recevez un coupon VIP pour retirer votre cadeau fait main (poterie Guellala, huile d'olive) à l'Aéroport DJE !</div>
            </div>
        </div>
        <button data-open-modal="personalizedPdfModal" class="c-button c-button--primary w-full sm:w-auto" style="padding: 0.75rem 1.25rem; font-size: 0.88rem; font-weight: 700; box-sizing: border-box; justify-content: center; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fi fi-rr-document-signed"></i> <span class="hidden sm:inline">Guide Personnalisé avec Nom & Photo</span><span class="sm:hidden">Guide Personnalisé</span> (9,90 €)
        </button>
    </div>

    <!-- Controls Bar: Search + Category Filters -->
    <div class="card" style="padding: clamp(1rem, 2.5vw, 1.5rem); margin-bottom: 2rem; background: #fff; border-radius: 20px; border: 1px solid var(--clr-sand-300); box-shadow: var(--shadow-soft);">
        <div style="display: flex; gap: 0.85rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
            <!-- Real-time Search -->
            <div style="flex: 1; min-width: 240px; position: relative;">
                <i class="fi fi-rr-search" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--clr-gray-500); font-size: 1.1rem;"></i>
                <input type="text" id="shopSearchInput" placeholder="Rechercher un guide, carte GPS, excursion..." 
                       style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border-radius: 30px; border: 1px solid var(--clr-sand-300); font-size: 0.92rem; outline: none; transition: all 0.25s ease;"
                       onkeyup="filterProducts()">
            </div>

            <!-- Sort By -->
            <div style="display: flex; align-items: center; gap: 8px;">
                <label for="shopSort" style="font-size: 0.85rem; font-weight: 700; color: var(--clr-dark-800); white-space: nowrap;">Trier par :</label>
                <select id="shopSort" onchange="sortProducts()" style="padding: 0.65rem 1rem; border-radius: 30px; border: 1px solid var(--clr-sand-300); font-size: 0.85rem; background: #fff; cursor: pointer; outline: none; font-weight: 600;">
                    <option value="default">Recommandés</option>
                    <option value="price-asc">Prix : Croissant</option>
                    <option value="price-desc">Prix : Décroissant</option>
                    <option value="title">Nom (A-Z)</option>
                </select>
            </div>
        </div>

        <!-- Filter Tabs (Single line horizontal scroll on mobile) -->
        <div class="tabs c-scroll-tabs" style="margin-top: 1.25rem; margin-bottom: 0; padding-bottom: 0; border-bottom: none; gap: 0.5rem;">
            <button class="tab-btn active" onclick="filterCategory('all', this)"><i class="fi fi-rr-apps"></i> Tous (<?= count($products) ?>)</button>
            <button class="tab-btn" onclick="filterCategory('guide', this)"><i class="fi fi-rr-book"></i> Guides PDF</button>
            <button class="tab-btn" onclick="filterCategory('gps', this)"><i class="fi fi-rr-map-marker"></i> Cartes GPS</button>
            <button class="tab-btn" onclick="filterCategory('pass', this)"><i class="fi fi-rr-ticket"></i> Pass Excursions</button>
            <button class="tab-btn" onclick="filterCategory('pack', this)"><i class="fi fi-rr-box"></i> Packs Complets</button>
            <button class="tab-btn" onclick="filterCategory('audio', this)"><i class="fi fi-rr-headphones"></i> Audio-Guides</button>
        </div>
    </div>

    <!-- Product Count Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem;">
        <span id="productCounter" style="font-size: 0.95rem; font-weight: 700; color: var(--clr-dark-800);">Affichage de <?= count($products) ?> produits</span>
        <span style="font-size: 0.88rem; color: #10B981; font-weight: 600; display: flex; align-items: center; gap: 6px;">
            <i class="fi fi-rr-lock"></i> Paiements 100% Sécurisés Stripe SSL (256-bit)
        </span>
    </div>

    <!-- Products Grid -->
    <div id="productsGrid" class="l-grid-cards" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 1.75rem;">
        <?php foreach ($products as $prod): 
            $titleLower = mb_strtolower($prod->titleFr);
            $catTag = 'guide';
            $thumbImage = 'shop_guide_pdf.jpg';

            if (str_contains($titleLower, 'carte gps') || str_contains($titleLower, 'map')) {
                $catTag = 'gps';
                $thumbImage = 'shop_gps_map.jpg';
            } elseif (str_contains($titleLower, 'pass') || str_contains($titleLower, 'excursion') || str_contains($titleLower, 'balade') || str_contains($titleLower, 'session') || str_contains($titleLower, 'jet') || str_contains($titleLower, 'quad')) {
                $catTag = 'pass';
                $thumbImage = str_contains($titleLower, 'jet') ? 'service_jetski.jpg' : (str_contains($titleLower, 'quad') ? 'service_quad.jpg' : 'service_bateau_pirate.jpg');
            } elseif (str_contains($titleLower, 'pack')) {
                $catTag = 'pack';
                $thumbImage = 'hero.png';
            } elseif (str_contains($titleLower, 'audio')) {
                $catTag = 'audio';
                $thumbImage = 'shop_audio_guide.jpg';
            }

            $isSelected = isset($selectedProduct) && $selectedProduct->id === $prod->id;
            $cardBorder = $isSelected ? 'border: 2px solid #F59E0B; box-shadow: 0 10px 30px rgba(245, 158, 11, 0.25);' : 'border: 1px solid var(--clr-sand-300); box-shadow: 0 4px 15px rgba(0,0,0,0.04);';
        ?>
            <article class="c-card product-item" 
                     id="product-<?= e($prod->slug) ?>"
                     data-id="<?= $prod->id ?>"
                     data-title="<?= e($titleLower) ?>" 
                     data-display-title="<?= e($prod->titleFr) ?>"
                     data-price="<?= $prod->priceEur ?>" 
                     data-category="<?= $catTag ?>"
                     style="background: #fff; border-radius: 20px; overflow: hidden; <?= $cardBorder ?> display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                
                <div>
                    <!-- Visual Thumb Image -->
                    <div style="position: relative; height: 170px; overflow: hidden; background: #0F172A;">
                        <img src="<?= asset('images/' . $thumbImage) ?>" alt="<?= e($prod->titleFr) ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;">
                        
                        <span style="position: absolute; top: 12px; left: 12px; background: rgba(15,23,42,0.85); backdrop-filter: blur(8px); color: #F59E0B; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                            <?php if ($catTag === 'gps'): ?><i class="fi fi-rr-map-marker"></i> Carte GPS
                            <?php elseif ($catTag === 'pass'): ?><i class="fi fi-rr-ticket"></i> Pass VIP
                            <?php elseif ($catTag === 'pack'): ?><i class="fi fi-rr-box"></i> Pack Voyage
                            <?php elseif ($catTag === 'audio'): ?><i class="fi fi-rr-headphones"></i> Audio MP3
                            <?php else: ?><i class="fi fi-rr-book"></i> Guide PDF<?php endif; ?>
                        </span>

                        <span style="position: absolute; top: 12px; right: 12px; background: rgba(16, 185, 129, 0.9); color: #fff; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.78rem; backdrop-filter: blur(6px); display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fi fi-rr-star"></i> 4.9 (98%)
                        </span>
                    </div>

                    <div style="padding: 1.25rem 1.25rem 0.5rem 1.25rem;">
                        <h3 class="c-card__title" style="font-size: 1.1rem; color: var(--clr-dark-900); line-height: 1.35; margin-bottom: 0.6rem; min-height: 46px; font-weight: 700;">
                            <?= e($prod->titleFr) ?>
                        </h3>
                        <p style="color: var(--clr-gray-500); font-size: 0.85rem; line-height: 1.45; margin-bottom: 0.75rem;">
                            Livraison numérique immédiate par e-mail avec token de téléchargement sécurisé + Coupon Cadeau DJE.
                        </p>
                    </div>
                </div>

                <div style="padding: 0 1.25rem 1.25rem 1.25rem;">
                    <div style="border-top: 1px dashed var(--clr-sand-300); padding-top: 0.9rem; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="font-size: 0.75rem; color: var(--clr-gray-500); text-transform: uppercase; font-weight: 600;">Prix Unique</span>
                            <div style="font-family: var(--font-heading); font-weight: 800; font-size: 1.4rem; color: var(--clr-sea-900);">
                                <?= number_format($prod->priceEur, 2) ?> €
                            </div>
                        </div>
                        <button class="c-button c-button--primary" onclick="openShopCheckout(<?= $prod->id ?>, '<?= e(addslashes($prod->titleFr)) ?>', <?= $prod->priceEur ?>)" style="padding: 0.65rem 1.15rem; font-size: 0.88rem; font-weight: 700;">
                            Acheter <i class="fi fi-rr-shopping-cart"></i>
                        </button>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal Checkout Produit Boutique -->
<div class="c-modal" id="shopProductModal" role="dialog" aria-hidden="true">
    <div class="c-modal__backdrop" onclick="closeShopModal()"></div>
    <div class="c-modal__dialog" style="max-width: 500px;">
        <div class="c-modal__header">
            <h3 style="font-size: 1.2rem; font-family: var(--font-heading); color: var(--clr-dark-900); display: flex; align-items: center; gap: 8px;">
                <i class="fi fi-rr-shopping-cart" style="color: var(--clr-sea-600);"></i> Commande Numérique Directe
            </h3>
            <button class="c-modal__close" onclick="closeShopModal()">&times;</button>
        </div>

        <form id="shopCheckoutForm" class="c-modal__body" style="padding: 1.5rem;" onsubmit="submitShopOrder(event)">
            <input type="hidden" id="modalProductId" value="">
            
            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 1rem; margin-bottom: 1.25rem;">
                <div style="font-size: 0.8rem; color: var(--clr-gray-500); text-transform: uppercase; font-weight: 700;">Produit Sélectionné</div>
                <div id="modalProductTitle" style="font-weight: 800; font-size: 1.05rem; color: var(--clr-sea-900); margin: 4px 0;"></div>
                <div id="modalProductPrice" style="font-size: 1.2rem; font-weight: 800; color: #10B981;"></div>
            </div>

            <div id="shopFormError" style="color: #EF4444; font-size: 0.85rem; margin-bottom: 1rem; font-weight: 600;"></div>

            <div style="margin-bottom: 1.25rem;">
                <label for="shopClientEmail" style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--clr-dark-800);">Votre Adresse Email (pour la livraison immédiate du PDF / Token)</label>
                <input type="email" id="shopClientEmail" required class="input" placeholder="exemple@domaine.com" style="width: 100%; padding: 0.8rem 1rem; border-radius: 10px; border: 1px solid var(--clr-sand-300);">
            </div>

            <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 10px; padding: 0.85rem; font-size: 0.82rem; color: #065F46; line-height: 1.4;">
                <i class="fi fi-rr-check-circle" style="color: #10B981;"></i> <strong>Garantie 100% :</strong> Réception automatique par e-mail en moins de 30 secondes après le règlement Stripe.
            </div>

            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" class="c-button c-button--outline" onclick="closeShopModal()">Annuler</button>
                <button type="submit" class="c-button c-button--primary" id="submitShopBtn" style="font-weight: 700;">
                    <i class="fi fi-rr-lock"></i> Régler via Stripe
                </button>
            </div>
        </form>
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

function openShopCheckout(id, title, price) {
    document.getElementById('modalProductId').value = id;
    document.getElementById('modalProductTitle').textContent = title;
    document.getElementById('modalProductPrice').textContent = price.toFixed(2) + ' €';
    document.getElementById('shopFormError').textContent = '';
    
    const modal = document.getElementById('shopProductModal');
    if (modal) {
        modal.classList.add('is-open');
    }
}

function closeShopModal() {
    const modal = document.getElementById('shopProductModal');
    if (modal) {
        modal.classList.remove('is-open');
    }
}

function submitShopOrder(e) {
    e.preventDefault();
    const id = document.getElementById('modalProductId').value;
    const email = document.getElementById('shopClientEmail').value.trim();
    const errorEl = document.getElementById('shopFormError');
    const submitBtn = document.getElementById('submitShopBtn');

    if (!email) {
        errorEl.textContent = 'Veuillez renseigner votre adresse e-mail.';
        return;
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fi fi-rr-spinner fi-spin"></i> Redirection Stripe...';

    const endpoint = '<?= url('/api/checkout/session') ?>';

    fetch(endpoint, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ product_id: parseInt(id, 10), email: email })
    })
    .then(res => res.json())
    .then(data => {
        if (data.redirect_url) {
            window.location.href = data.redirect_url;
        } else {
            throw new Error(data.error || 'Erreur lors de la création de la session Stripe.');
        }
    })
    .catch(err => {
        errorEl.textContent = err.message;
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fi fi-rr-lock"></i> Régler via Stripe';
    });
}

<?php if (!empty($selectedProduct)): ?>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('product-<?= e($selectedProduct->slug) ?>');
    if (el) {
        setTimeout(function() {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 150);
    }
});
<?php endif; ?>
</script>