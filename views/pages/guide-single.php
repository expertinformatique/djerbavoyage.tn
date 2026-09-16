<?php
/** @var App\Models\Article $article */
/** @var array $ctaServices */
?>

<?php if (!empty($article->schemaJson)): ?>
<script type="application/ld+json">
<?= $article->schemaJson ?>
</script>
<?php endif; ?>

<div class="l-container" style="max-width: 900px; margin: 3rem auto;">
    <article style="background: #ffffff; padding: 2.5rem; border-radius: var(--radius-card, 20px); box-shadow: var(--shadow-soft); border: 1px solid var(--clr-sand-200, #F4ECE1);">
        
        <!-- Header & Category Badge -->
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; flex-wrap: wrap; font-size: 0.85rem; color: var(--clr-gray-500);">
            <span style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.25rem 0.75rem; background: var(--clr-sand-200, #F4ECE1); color: var(--clr-dark-900); font-weight: 600; font-size: 0.75rem; border-radius: 999px;">
                ✨ Guide mis à jour par IA
            </span>
            <span><i class="fi fi-rr-eye"></i> <?= $article->viewsCount ?> vues</span>
            <span>• Publié le <?= date('d/m/Y', strtotime($article->publishedAt ?? 'now')) ?></span>
        </div>

        <h1 style="font-family: var(--font-heading); font-size: 2.2rem; font-weight: 800; color: var(--clr-dark-900); margin-bottom: 1.5rem; line-height: 1.25;">
            <?= htmlspecialchars($article->titleFr, ENT_QUOTES, 'UTF-8') ?>
        </h1>

        <!-- Featured Image -->
        <?php if (!empty($article->featuredImage)): ?>
            <div style="margin-bottom: 2rem; overflow: hidden; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <img src="<?= htmlspecialchars($article->featuredImage, ENT_QUOTES, 'UTF-8') ?>" 
                     alt="<?= htmlspecialchars($article->titleFr, ENT_QUOTES, 'UTF-8') ?>" 
                     style="width: 100%; max-height: 460px; object-fit: cover; display: block;" 
                     loading="lazy" />
            </div>
        <?php endif; ?>

        <!-- AI Executive Summary Box for Readers & LLM Bots (GEO Optimization) -->
        <?php if (!empty($article->summaryAi)): ?>
            <div style="margin: 1.5rem 0; padding: 1.25rem 1.5rem; background: rgba(0, 180, 216, 0.08); border-left: 4px solid var(--clr-sea-600, #0077B6); border-radius: 0 12px 12px 0;">
                <h3 style="font-size: 0.9rem; font-weight: 700; color: var(--clr-sea-900, #03045E); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    ⚡ En résumé (Synthèse IA & Aperçu Rapide)
                </h3>
                <div style="font-size: 0.92rem; color: var(--clr-dark-800); white-space: pre-line; line-height: 1.6;">
                    <?= htmlspecialchars($article->summaryAi, ENT_QUOTES, 'UTF-8') ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Article Main Content -->
        <div style="line-height: 1.8; font-size: 1.05rem; color: var(--clr-dark-800); margin-bottom: 2.5rem;">
            <?= $article->contentFr ?>
        </div>

        <!-- Download PDF Printable Guide Section -->
        <div style="margin: 2.5rem 0; padding: 1.5rem; background: var(--clr-sand-100, #FDFBF7); border-radius: 16px; border: 1px solid var(--clr-sand-500, #D8C3A5); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3 style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: var(--clr-dark-900); margin-bottom: 0.25rem;">
                    📄 Emportez ce guide en version PDF
                </h3>
                <p style="font-size: 0.88rem; color: var(--clr-gray-500);">
                    Téléchargez ou imprimez la fiche pratique officielle pour votre voyage à Djerba.
                </p>
            </div>
            <a href="<?= url('/guide/' . urlencode($article->slug) . '/pdf') ?>" target="_blank" class="c-button c-button--primary" style="font-size: 0.88rem; padding: 0.65rem 1.25rem; font-weight: 700;">
                <span>Télécharger PDF</span>
                <i class="fi fi-rr-download" style="margin-left: 0.35rem;"></i>
            </a>
        </div>

        <!-- Cross-Selling CTAs for Platform Services -->
        <?php if (!empty($ctaServices)): ?>
            <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--clr-sand-200, #F4ECE1);">
                <h3 style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 700; color: var(--clr-dark-900); margin-bottom: 1.25rem;">
                    🎯 Excursions & Services recommandés
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem;">
                    <?php foreach ($ctaServices as $service): ?>
                        <div style="padding: 1rem 1.25rem; background: var(--clr-sand-100, #FDFBF7); border-radius: 12px; border: 1px solid var(--clr-sand-200, #F4ECE1); display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--clr-dark-900); margin-bottom: 0.25rem;">
                                    <?= htmlspecialchars($service->titleFr, ENT_QUOTES, 'UTF-8') ?>
                                </h4>
                                <p style="font-size: 0.82rem; color: var(--clr-sea-600); font-weight: 600;">
                                    À partir de <?= number_format($service->priceEur, 2) ?> €
                                </p>
                            </div>
                            <a href="<?= url('/services#' . urlencode($service->slug)) ?>" class="c-button c-button--secondary" style="font-size: 0.8rem; padding: 0.4rem 0.85rem;">
                                Réserver
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Concierge Banner -->
        <div style="margin-top: 2.5rem; padding: 1.75rem; background: var(--clr-dark-900, #0F172A); color: #ffffff; border-radius: 16px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h4 style="font-family: var(--font-heading); font-size: 1.15rem; font-weight: 700; margin-bottom: 0.35rem;">Besoin d'un itinéraire 100% sur-mesure ?</h4>
                <p style="font-size: 0.88rem; color: #94A3B8;">Laissez notre conciergerie locale planifier votre séjour idéal à Djerba.</p>
            </div>
            <a href="<?= url('/concierge') ?>" class="c-button c-button--primary" style="font-size: 0.88rem; padding: 0.65rem 1.25rem;">
                Demander mon itinéraire (29€)
            </a>
        </div>
    </article>
</div>