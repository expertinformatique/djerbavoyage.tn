<?php
/** @var App\Models\Article $article */
/** @var array $ctaServices */
?>

<?php if (!empty($article->schemaJson)): ?>
<script type="application/ld+json">
<?= $article->schemaJson ?>
</script>
<?php endif; ?>

<div class="max-w-4xl mx-auto px-4 py-8 md:py-12">
    <article class="bg-white dark:bg-gray-800 rounded-2xl p-6 md:p-10 shadow-lg border border-gray-100 dark:border-gray-700 transition-colors">
        
        <!-- Header & Category Badge -->
        <div class="flex items-center gap-3 mb-4 flex-wrap">
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300 text-xs font-semibold rounded-full">
                ✨ Guide mis à jour par IA
            </span>
            <span class="text-xs text-gray-500 dark:text-gray-400">
                <i class="fi fi-rr-eye"></i> <?= $article->viewsCount ?> vues
            </span>
            <span class="text-xs text-gray-500 dark:text-gray-400">
                • Publié le <?= date('d/m/Y', strtotime($article->publishedAt ?? 'now')) ?>
            </span>
        </div>

        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-6 leading-tight">
            <?= htmlspecialchars($article->titleFr, ENT_QUOTES, 'UTF-8') ?>
        </h1>

        <!-- Featured Image -->
        <?php if (!empty($article->featuredImage)): ?>
            <div class="mb-8 overflow-hidden rounded-xl shadow-md border border-gray-100 dark:border-gray-700">
                <img src="<?= htmlspecialchars($article->featuredImage, ENT_QUOTES, 'UTF-8') ?>" 
                     alt="<?= htmlspecialchars($article->titleFr, ENT_QUOTES, 'UTF-8') ?>" 
                     class="w-full h-[320px] md:h-[450px] object-cover hover:scale-105 transition-transform duration-500" 
                     loading="lazy" />
            </div>
        <?php endif; ?>

        <!-- AI Executive Summary Box for Readers & LLM Bots (GEO Optimization) -->
        <?php if (!empty($article->summaryAi)): ?>
            <div class="my-6 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-800 border-l-4 border-blue-600 rounded-r-xl shadow-sm">
                <h3 class="text-sm font-bold text-blue-900 dark:text-blue-300 uppercase tracking-wide mb-2 flex items-center gap-2">
                    ⚡ En résumé (Optimisé Moteurs IA & Aperçu Rapide)
                </h3>
                <div class="text-sm text-gray-700 dark:text-gray-200 whitespace-pre-line leading-relaxed">
                    <?= htmlspecialchars($article->summaryAi, ENT_QUOTES, 'UTF-8') ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Article Main Content -->
        <div class="prose dark:prose-invert max-w-none text-gray-800 dark:text-gray-200 leading-relaxed space-y-4">
            <?= $article->contentFr ?>
        </div>

        <!-- Download PDF Printable Guide Section -->
        <div class="my-8 p-6 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-950/30 dark:to-orange-950/30 rounded-2xl border border-amber-200 dark:border-amber-800/50 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    📄 Emportez ce guide en PDF
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                    Téléchargez ou imprimez la fiche pratique de cet article pour votre voyage à Djerba.
                </p>
            </div>
            <a href="<?= url('/guide/' . urlencode($article->slug) . '/pdf') ?>" target="_blank" 
               class="inline-flex items-center gap-2 px-5 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                <span>Télécharger PDF</span>
                <i class="fi fi-rr-download"></i>
            </a>
        </div>

        <!-- Cross-Selling CTAs for Platform Services -->
        <?php if (!empty($ctaServices)): ?>
            <div class="mt-10 pt-8 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                    🎯 Activités recommandées pour cet itinéraire
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($ctaServices as $service): ?>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600 flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm">
                                    <?= htmlspecialchars($service->titleFr, ENT_QUOTES, 'UTF-8') ?>
                                </h4>
                                <p class="text-xs text-amber-600 dark:text-amber-400 font-semibold mt-1">
                                    À partir de <?= number_format($service->priceEur, 2) ?> €
                                </p>
                            </div>
                            <a href="<?= url('/services#' . urlencode($service->slug)) ?>" 
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-colors">
                                Réserver
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Concierge Banner -->
        <div class="mt-8 p-6 bg-gray-900 text-white rounded-2xl flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h4 class="text-lg font-bold">Besoin d'un itinéraire 100% sur-mesure ?</h4>
                <p class="text-sm text-gray-300 mt-1">Laissez notre conciergerie locale planifier votre séjour idéal à Djerba.</p>
            </div>
            <a href="<?= url('/concierge') ?>" class="px-5 py-3 bg-amber-500 hover:bg-amber-600 text-gray-900 font-bold text-sm rounded-xl transition-all whitespace-nowrap">
                Demander mon itinéraire (29€)
            </a>
        </div>
    </article>
</div>