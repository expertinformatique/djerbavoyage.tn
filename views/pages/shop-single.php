<?php
use App\Services\ProductLocalizationService;

$activeLang = \Core\Lang::getLocale();
$isRtl = \Core\Lang::isRtl();
$displayTitle = ProductLocalizationService::getTitle($product, $activeLang);
$displayDesc = ProductLocalizationService::getDescription($product, $activeLang);
$catTag = ProductLocalizationService::getCategoryTag($product->titleFr);
$thumbImage = ProductLocalizationService::getProductImage($product);
?>

<div class="l-container" style="margin: clamp(1.5rem, 3vw, 3rem) auto clamp(3rem, 5vw, 6rem) auto;" <?= $isRtl ? 'dir="rtl"' : '' ?>>
    <!-- Fil d'Ariane -->
    <nav class="c-blog-breadcrumb" aria-label="Fil d'Ariane" style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.88rem; color: var(--clr-gray-500); margin-bottom: 1.5rem;">
        <a href="<?= url('/') ?>" style="color: inherit; text-decoration: none;"><?= __('shop.breadcrumb_home') ?></a>
        <i class="fi fi-rr-angle-small-<?= $isRtl ? 'left' : 'right' ?>"></i>
        <a href="<?= url('/shop') ?>" style="color: inherit; text-decoration: none;"><?= __('shop.breadcrumb_shop') ?></a>
        <i class="fi fi-rr-angle-small-<?= $isRtl ? 'left' : 'right' ?>"></i>
        <span class="c-blog-breadcrumb__current" style="color: var(--clr-dark-900); font-weight: 700;"><?= e($displayTitle) ?></span>
    </nav>

    <!-- Fiche Détaillée Produit -->
    <div id="product-<?= e($product->slug) ?>" class="card" style="background: #fff; border-radius: 24px; padding: clamp(1.25rem, 3vw, 2.5rem); border: 1px solid var(--clr-sand-300); box-shadow: var(--shadow-soft); margin-bottom: 3.5rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: clamp(1.5rem, 4vw, 3rem); align-items: start;">
            
            <!-- Colonne Visuel Produit -->
            <div>
                <div style="position: relative; border-radius: 20px; overflow: hidden; background: #0F172A; box-shadow: 0 15px 35px rgba(0,0,0,0.12);">
                    <img src="<?= asset('images/' . $thumbImage) ?>" alt="<?= e($displayTitle) ?>" style="width: 100%; height: auto; aspect-ratio: 4/3; object-fit: cover; display: block;">
                    
                    <span style="position: absolute; top: 16px; <?= $isRtl ? 'right: 16px;' : 'left: 16px;' ?> background: rgba(15,23,42,0.88); backdrop-filter: blur(8px); color: #F59E0B; padding: 6px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                        <?php if ($catTag === 'gps'): ?><i class="fi fi-rr-map-marker"></i> <?= __('shop.tab_gps') ?>
                        <?php elseif ($catTag === 'pass'): ?><i class="fi fi-rr-ticket"></i> <?= __('shop.tab_pass') ?>
                        <?php elseif ($catTag === 'pack'): ?><i class="fi fi-rr-box"></i> <?= __('shop.tab_packs') ?>
                        <?php elseif ($catTag === 'audio'): ?><i class="fi fi-rr-headphones"></i> <?= __('shop.tab_audio') ?>
                        <?php else: ?><i class="fi fi-rr-book"></i> <?= __('shop.tab_guides') ?><?php endif; ?>
                    </span>

                    <span style="position: absolute; top: 16px; <?= $isRtl ? 'left: 16px;' : 'right: 16px;' ?> background: rgba(16, 185, 129, 0.95); color: #fff; padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 0.82rem; backdrop-filter: blur(6px); display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fi fi-rr-star"></i> 4.9 (128 avis)
                    </span>
                </div>

                <!-- Sélecteur de Langue de la Fiche -->
                <div style="margin-top: 1.25rem; padding: 0.85rem 1rem; background: var(--clr-sand-100); border-radius: 14px; border: 1px solid var(--clr-sand-200); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--clr-dark-800);">
                        <i class="fi fi-rr-globe"></i> <?= __('shop.choose_language') ?>
                    </span>
                    <div style="display: flex; gap: 0.4rem;">
                        <a href="<?= url('/shop/' . $product->slug . '?lang=fr') ?>" 
                           style="text-decoration:none; padding: 4px 10px; border-radius: 8px; font-size: 0.82rem; font-weight: 600; border: 1px solid var(--clr-sand-300); background: <?= $activeLang === 'fr' ? '#0284C7' : '#fff' ?>; color: <?= $activeLang === 'fr' ? '#fff' : 'var(--clr-dark-800)' ?>;">
                           🇫🇷 FR
                        </a>
                        <a href="<?= url('/shop/' . $product->slug . '?lang=en') ?>" 
                           style="text-decoration:none; padding: 4px 10px; border-radius: 8px; font-size: 0.82rem; font-weight: 600; border: 1px solid var(--clr-sand-300); background: <?= $activeLang === 'en' ? '#0284C7' : '#fff' ?>; color: <?= $activeLang === 'en' ? '#fff' : 'var(--clr-dark-800)' ?>;">
                           🇬🇧 EN
                        </a>
                        <a href="<?= url('/shop/' . $product->slug . '?lang=ar') ?>" 
                           style="text-decoration:none; padding: 4px 10px; border-radius: 8px; font-size: 0.82rem; font-weight: 600; border: 1px solid var(--clr-sand-300); background: <?= $activeLang === 'ar' ? '#0284C7' : '#fff' ?>; color: <?= $activeLang === 'ar' ? '#fff' : 'var(--clr-dark-800)' ?>;">
                           🇹🇳 AR
                        </a>
                    </div>
                </div>
            </div>

            <!-- Colonne Informations & Achat -->
            <div>
                <span class="badge badge--gold" style="background: rgba(245, 158, 11, 0.15); border: 1px solid #F59E0B; color: #D97706; padding: 4px 12px; border-radius: 50px; font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 0.75rem;">
                    <i class="fi fi-rr-sparkles"></i> <?= __('shop.single_badge') ?>
                </span>

                <h1 style="font-size: clamp(1.5rem, 2.5vw, 2.1rem); line-height: 1.3; color: var(--clr-dark-900); font-weight: 800; margin-bottom: 1rem; font-family: var(--font-heading);">
                    <?= e($displayTitle) ?>
                </h1>

                <!-- Prix et format -->
                <div style="display: flex; align-items: baseline; gap: 1rem; margin-bottom: 1.25rem;">
                    <div style="font-family: var(--font-heading); font-weight: 800; font-size: 2.2rem; color: var(--clr-sea-900);">
                        <?= money($product->priceEur) ?>
                    </div>
                    <span style="font-size: 0.88rem; color: #10B981; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="fi fi-rr-bolt"></i> <?= __('shop.instant_download') ?>
                    </span>
                </div>

                <p style="color: var(--clr-gray-600); font-size: 1rem; line-height: 1.6; margin-bottom: 1.5rem;">
                    <?= e($displayDesc) ?>
                </p>

                <!-- Ce qui est inclus -->
                <div style="background: var(--clr-sand-100); border-radius: 16px; padding: 1.25rem; border: 1px solid var(--clr-sand-200); margin-bottom: 1.75rem;">
                    <h4 style="font-size: 0.95rem; font-weight: 800; color: var(--clr-dark-900); margin-bottom: 0.75rem;">
                        <?= __('shop.whats_included') ?>
                    </h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.6rem; font-size: 0.9rem; color: var(--clr-dark-800);">
                        <li style="display: flex; align-items: flex-start; gap: 8px;">
                            <i class="fi fi-rr-check-circle" style="color: #10B981; margin-top: 2px;"></i>
                            <span><?= __('shop.inc_1') ?></span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 8px;">
                            <i class="fi fi-rr-check-circle" style="color: #10B981; margin-top: 2px;"></i>
                            <span><?= __('shop.inc_2') ?></span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 8px;">
                            <i class="fi fi-rr-check-circle" style="color: #10B981; margin-top: 2px;"></i>
                            <span><?= __('shop.inc_3') ?></span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 8px;">
                            <i class="fi fi-rr-check-circle" style="color: #10B981; margin-top: 2px;"></i>
                            <span><?= __('shop.inc_4') ?></span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 8px;">
                            <i class="fi fi-rr-check-circle" style="color: #10B981; margin-top: 2px;"></i>
                            <span><?= __('shop.inc_5') ?></span>
                        </li>
                    </ul>
                </div>

                <!-- Boutons d'action -->
                <div style="display: flex; gap: 0.85rem; flex-wrap: wrap; align-items: center;">
                    <button class="c-button c-button--primary w-full sm:w-auto" 
                            onclick="openShopCheckout(<?= $product->id ?>, '<?= e(addslashes($displayTitle)) ?>', <?= $product->priceEur ?>)" 
                            style="padding: 0.9rem 1.75rem; font-size: 1rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fi fi-rr-shopping-cart"></i> <?= __('shop.buy_now') ?>
                    </button>
                    <a href="<?= url('/shop') ?>" class="c-button w-full sm:w-auto" 
                       style="padding: 0.9rem 1.4rem; font-size: 0.92rem; font-weight: 600; background: #fff; border: 1px solid var(--clr-sand-300); color: var(--clr-dark-800); text-decoration: none; text-align: center;">
                        <i class="fi fi-rr-arrow-<?= $isRtl ? 'right' : 'left' ?>"></i> <?= __('shop.back_to_catalog') ?>
                    </a>
                </div>

                <div style="margin-top: 1rem; font-size: 0.8rem; color: var(--clr-gray-500); display: flex; align-items: center; gap: 6px;">
                    <i class="fi fi-rr-lock" style="color: #10B981;"></i> <?= __('shop.secure_ssl') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Produits Similaires -->
    <?php 
    $related = array_filter($products, fn($p) => $p->id !== $product->id);
    $related = array_slice($related, 0, 3);
    if (!empty($related)):
    ?>
    <div>
        <h3 style="font-size: 1.35rem; font-family: var(--font-heading); color: var(--clr-dark-900); margin-bottom: 1.25rem;">
            <?= __('shop.related_title') ?>
        </h3>
        <div class="l-grid-cards" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
            <?php foreach ($related as $relProd): 
                $relTitle = ProductLocalizationService::getTitle($relProd, $activeLang);
                $relImg = ProductLocalizationService::getProductImage($relProd);
            ?>
            <article class="c-card" style="background: #fff; border-radius: 16px; border: 1px solid var(--clr-sand-300); overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <a href="<?= url('/shop/' . $relProd->slug) ?>" style="display: block; height: 150px; overflow: hidden; background: #0F172A;" title="<?= e($relTitle) ?>">
                        <img src="<?= asset('images/' . $relImg) ?>" alt="<?= e($relTitle) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </a>
                    <div style="padding: 1rem;">
                        <h4 style="font-size: 1rem; line-height: 1.35; margin-bottom: 0.5rem; min-height: 42px; font-weight: 700;">
                            <a href="<?= url('/shop/' . $relProd->slug) ?>" style="color: inherit; text-decoration: none;">
                                <?= e($relTitle) ?>
                            </a>
                        </h4>
                    </div>
                </div>
                <div style="padding: 0 1rem 1rem 1rem; border-top: 1px dashed var(--clr-sand-200); display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 800; font-size: 1.15rem; color: var(--clr-sea-900);">
                        <?= money($relProd->priceEur) ?>
                    </span>
                    <a href="<?= url('/shop/' . $relProd->slug) ?>" class="c-button c-button--primary" style="padding: 0.5rem 1rem; font-size: 0.82rem; font-weight: 700; text-decoration: none;">
                        <?= __('shop.details_btn') ?>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../partials/shop_checkout_modal.php'; ?>
