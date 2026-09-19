<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center <?= !empty($success) ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-400' : 'bg-rose-100 text-rose-600 dark:bg-rose-900/40 dark:text-rose-400' ?>">
                    <?php if (!empty($success)): ?>
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    <?php else: ?>
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    <?php endif; ?>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Connexion TikTok</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Statut de liaison avec la TikTok Content Posting API</p>
                </div>
            </div>

            <div class="p-4 rounded-xl mb-6 <?= !empty($success) ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-800' : 'bg-rose-50 dark:bg-rose-950/40 text-rose-800 dark:text-rose-200 border border-rose-200 dark:border-rose-800' ?>">
                <p class="font-medium"><?= e($message ?? '') ?></p>
                <?php if (!empty($openId)): ?>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Identifiant TikTok (OpenID) : <span class="font-mono"><?= e($openId) ?></span></p>
                <?php endif; ?>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <a href="/admin/settings" class="inline-flex justify-center items-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition shadow-sm">
                    Retour aux paramètres
                </a>
                <?php if (empty($success)): ?>
                    <a href="/admin/tiktok/connect" class="inline-flex justify-center items-center px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition">
                        Réessayer la connexion
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
