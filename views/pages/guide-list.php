<?php
/** @var array $articles */
?>

<div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
    <!-- Header Section -->
    <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 text-xs font-semibold rounded-full mb-3">
            🏝️ Guide Djerba Voyage
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-4">
            Tous nos Guides & Actualités de Voyage
        </h1>
        <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
            Conseils pratiques, météo en direct, excursions incontournables et bons plans pour vivre un séjour inoubliable à Djerba.
        </p>
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        <?php foreach ($articles as $art): ?>
            <article class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group">
                <!-- Image Container -->
                <div class="relative h-48 sm:h-52 overflow-hidden bg-gray-100 dark:bg-gray-700">
                    <?php if (!empty($art->featuredImage)): ?>
                        <img src="<?= htmlspecialchars($art->featuredImage, ENT_QUOTES, 'UTF-8') ?>" 
                             alt="<?= htmlspecialchars($art->titleFr, ENT_QUOTES, 'UTF-8') ?>" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                             loading="lazy" />
                    <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg">
                            Djerba Voyage
                        </div>
                    <?php endif; ?>
                    <div class="absolute top-3 left-3 flex gap-2">
                        <span class="px-2.5 py-1 bg-black/60 backdrop-blur-md text-white text-[11px] font-medium rounded-full">
                            <i class="fi fi-rr-eye"></i> <?= $art->viewsCount ?> vues
                        </span>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-5 md:p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-2 font-medium flex items-center justify-between">
                            <span><?= date('d/m/Y', strtotime($art->publishedAt ?? 'now')) ?></span>
                            <span class="text-amber-600 dark:text-amber-400 font-semibold">
                                <?= htmlspecialchars($art->authorName ?? 'IA Djerba', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2 mb-3 leading-snug">
                            <a href="<?= url('/guide/' . htmlspecialchars($art->slug, ENT_QUOTES, 'UTF-8')) ?>">
                                <?= htmlspecialchars($art->titleFr, ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </h3>
                        <p class="text-xs md:text-sm text-gray-600 dark:text-gray-300 line-clamp-3 mb-4 leading-relaxed">
                            <?= htmlspecialchars($art->seoDescription ?: substr(strip_tags($art->contentFr), 0, 140), ENT_QUOTES, 'UTF-8') ?>...
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
                        <a href="<?= url('/guide/' . htmlspecialchars($art->slug, ENT_QUOTES, 'UTF-8')) ?>" 
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                            <span>Lire l'article complet</span>
                            <i class="fi fi-rr-arrow-right text-[10px]"></i>
                        </a>
                        <a href="<?= url('/guide/' . htmlspecialchars($art->slug, ENT_QUOTES, 'UTF-8') . '/pdf') ?>" 
                           target="_blank" 
                           title="Télécharger PDF"
                           class="p-1.5 text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                            <i class="fi fi-rr-file-pdf text-base"></i>
                        </a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>