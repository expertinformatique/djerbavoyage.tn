<?php
/** @var array $articles */
?>

<div class="l-container" style="margin: 3rem auto;">
    <div style="margin-bottom: 2.5rem; text-align: center;">
        <span style="display: inline-block; padding: 0.35rem 0.85rem; background: rgba(0, 119, 182, 0.1); color: var(--clr-sea-600); font-weight: 600; font-size: 0.85rem; border-radius: 999px; margin-bottom: 0.75rem;">
            🏝️ Guide Djerba Voyage
        </span>
        <h1 style="font-family: var(--font-heading); font-size: 2.2rem; margin-bottom: 0.75rem; color: var(--clr-dark-900);">
            Tous nos Guides & Conseils de Voyage
        </h1>
        <p style="color: var(--clr-gray-500); max-width: 650px; margin: 0 auto; font-size: 1rem;">
            Découvrez nos articles complets, la météo en direct, les secrets locaux et conseils pratiques pour bien préparer votre séjour à Djerba.
        </p>
    </div>

    <div class="l-grid-cards">
        <?php foreach ($articles as $art): ?>
            <article class="c-card" style="display: flex; flex-direction: column; justify-content: space-between;">
                <?php if (!empty($art->featuredImage)): ?>
                    <div class="c-card__media">
                        <img src="<?= htmlspecialchars($art->featuredImage, ENT_QUOTES, 'UTF-8') ?>" 
                             alt="<?= htmlspecialchars($art->titleFr, ENT_QUOTES, 'UTF-8') ?>" 
                             class="c-card__image" 
                             loading="lazy" />
                    </div>
                <?php endif; ?>

                <div class="c-card__content" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="color: var(--clr-gray-500); font-size: 0.8rem; margin-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center;">
                            <span><i class="fi fi-rr-calendar"></i> <?= date('d/m/Y', strtotime($art->publishedAt ?? 'now')) ?></span>
                            <span><i class="fi fi-rr-eye"></i> <?= $art->viewsCount ?> vues</span>
                        </div>

                        <h3 class="c-card__title" style="font-size: 1.15rem; font-weight: 700; line-height: 1.35; margin-bottom: 0.75rem;">
                            <a href="<?= url('/guide/' . e($art->slug)) ?>" style="color: var(--clr-dark-900);">
                                <?= e($art->titleFr) ?>
                            </a>
                        </h3>

                        <p style="color: var(--clr-dark-800); font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                            <?= e($art->seoDescription ?: substr(strip_tags($art->contentFr), 0, 130)) ?>...
                        </p>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--clr-sand-200); padding-top: 0.85rem; margin-top: auto;">
                        <a href="<?= url('/guide/' . e($art->slug)) ?>" class="c-button c-button--secondary" style="font-size: 0.85rem; padding: 0.5rem 1rem;">
                            Lire le guide
                        </a>
                        <a href="<?= url('/guide/' . e($art->slug) . '/pdf') ?>" target="_blank" title="Télécharger PDF" style="color: var(--clr-terracotta-500); font-size: 1.1rem; padding: 0.25rem;">
                            <i class="fi fi-rr-file-pdf"></i>
                        </a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>