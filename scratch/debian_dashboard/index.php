<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Multi-Bots IA Multi-Sites & Réseaux Sociaux — (192.168.0.129)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                            950: '#042f2e',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.1); }
        }
        .animate-pulse-slow { animation: pulse-slow 2s infinite ease-in-out; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 3px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #64748b; }
        .transition-theme { transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease; }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen antialiased flex flex-col selection:bg-teal-500 selection:text-white transition-theme">

    <!-- Top Navigation Header -->
    <header class="border-b border-slate-200 dark:border-slate-800 bg-white/90 dark:bg-slate-900/90 backdrop-blur sticky top-0 z-40 shadow-sm dark:shadow-none transition-theme">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <!-- Left Branding -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-teal-500 to-emerald-400 flex items-center justify-center text-slate-950 font-extrabold text-xl shadow-md shadow-teal-500/20 flex-shrink-0">
                    🌴
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <h1 class="font-bold text-base sm:text-lg text-slate-900 dark:text-white leading-tight">Studio Multi-Bots IA</h1>
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-teal-50 dark:bg-slate-800 text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-500/30">192.168.0.129</span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 hidden sm:block">Multi-Sites Web, Multi-Pages Facebook & Agents IA</p>
                </div>
            </div>

            <!-- Right Controls (Theme Switcher + Create Bot + Refresh) -->
            <div class="flex items-center space-x-2 sm:space-x-3">
                
                <!-- Theme Toggle Button -->
                <button onclick="toggleTheme()" id="btnThemeToggle" title="Basculer Mode Sombre / Clair" class="flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700 text-xs font-semibold transition active:scale-95">
                    <span id="themeIcon">☀️</span>
                    <span id="themeLabel" class="hidden sm:inline">Clair</span>
                </button>

                <!-- New Bot Button -->
                <button onclick="openBotModal()" class="flex items-center space-x-1.5 px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-slate-950 font-bold text-xs shadow-md shadow-teal-500/20 transition active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Nouveau Bot</span>
                </button>

                <!-- Refresh Button -->
                <button onclick="refreshAll()" title="Actualiser" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-300 dark:border-slate-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </button>
            </div>
        </div>

        <!-- Navigation Tabs Bar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex space-x-1 sm:space-x-3 border-t border-slate-200/80 dark:border-slate-800/80 overflow-x-auto text-xs">
            <button onclick="switchTab('tab-bots')" id="tabBtn-bots" class="tab-btn px-4 py-2.5 font-bold border-b-2 border-teal-500 text-teal-600 dark:text-teal-400 flex items-center space-x-2 transition">
                <span>🤖</span><span>Mes Bots</span><span id="badgeTabBotCount" class="px-1.5 py-0.2 bg-teal-100 dark:bg-teal-500/20 text-teal-800 dark:text-teal-300 rounded-full text-[10px] font-bold">3</span>
            </button>
            <button onclick="switchTab('tab-queue')" id="tabBtn-queue" class="tab-btn px-4 py-2.5 font-medium border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 flex items-center space-x-2 transition">
                <span>📚</span><span>File d'Attente (Sujets & Images)</span><span id="badgeTabQueueCount" class="px-1.5 py-0.2 bg-teal-100 dark:bg-teal-500/20 text-teal-800 dark:text-teal-300 rounded-full text-[10px] font-bold">0</span>
            </button>
            <button onclick="switchTab('tab-history')" id="tabBtn-history" class="tab-btn px-4 py-2.5 font-medium border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 flex items-center space-x-2 transition">
                <span>📜</span><span>Historique Publications</span><span id="badgeTabHistoryCount" class="px-1.5 py-0.2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-400 rounded-full text-[10px] font-medium">35</span>
            </button>
            <button onclick="switchTab('tab-agents')" id="tabBtn-agents" class="tab-btn px-4 py-2.5 font-medium border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 flex items-center space-x-2 transition">
                <span>🧠</span><span>Hub Agents IA</span>
            </button>
            <button onclick="switchTab('tab-logs')" id="tabBtn-logs" class="tab-btn px-4 py-2.5 font-medium border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 flex items-center space-x-2 transition">
                <span>💻</span><span>Terminal Logs</span>
            </button>
            <button onclick="switchTab('tab-system')" id="tabBtn-system" class="tab-btn px-4 py-2.5 font-medium border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 flex items-center space-x-2 transition">
                <span>⚙️</span><span>Système & Réseau</span>
            </button>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-1 w-full space-y-6">

        <!-- Top Global KPI Summary Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3.5">
            <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-3.5 flex flex-col justify-between shadow-sm dark:shadow-none transition-theme">
                <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold uppercase tracking-wider">Total Bots</span>
                <div class="flex items-baseline space-x-2 mt-1">
                    <span id="kpiTotalBots" class="text-2xl font-extrabold text-slate-900 dark:text-white">3</span>
                    <span id="kpiActiveBots" class="text-xs text-emerald-600 dark:text-emerald-400 font-bold">3 actifs</span>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-3.5 flex flex-col justify-between shadow-sm dark:shadow-none transition-theme">
                <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold uppercase tracking-wider">Articles Publiés</span>
                <div class="flex items-baseline space-x-2 mt-1">
                    <span id="kpiTotalRuns" class="text-2xl font-extrabold text-teal-600 dark:text-teal-400">--</span>
                    <span class="text-[11px] text-slate-400">au total</span>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-3.5 flex flex-col justify-between shadow-sm dark:shadow-none transition-theme">
                <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold uppercase tracking-wider">Taux de Succès</span>
                <div class="flex items-baseline space-x-2 mt-1">
                    <span id="kpiSuccessRate" class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400">100%</span>
                    <span class="text-[11px] text-slate-400">IA & Médias</span>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-3.5 flex flex-col justify-between shadow-sm dark:shadow-none transition-theme">
                <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold uppercase tracking-wider">Charge CPU</span>
                <div class="flex items-baseline space-x-2 mt-1">
                    <span id="kpiLoadAvg" class="text-sm font-bold text-cyan-600 dark:text-cyan-400 font-mono">--</span>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-3.5 flex flex-col justify-between shadow-sm dark:shadow-none col-span-2 sm:col-span-4 lg:col-span-1 transition-theme">
                <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold uppercase tracking-wider">Mémoire RAM</span>
                <div class="w-full bg-slate-200 dark:bg-slate-800 rounded-full h-2 mt-2 overflow-hidden">
                    <div id="kpiRamBar" class="bg-gradient-to-r from-teal-500 to-cyan-400 h-2 rounded-full" style="width: 33%"></div>
                </div>
                <div class="flex justify-between text-[10px] text-slate-500 dark:text-slate-400 mt-1 font-mono">
                    <span id="kpiRamText">-- MB</span>
                    <span id="kpiRamPercent" class="text-teal-600 dark:text-teal-400 font-bold">--%</span>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- TAB 1: MES BOTS -->
        <!-- ======================================================== -->
        <section id="tab-bots" class="tab-content space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Vos Bots d'Automatisation Éditoriale & Réseaux Sociaux</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Chaque bot est configuré avec son site web cible, sa page Facebook, ses agents IA et son rythme de publication autonome.</p>
                </div>
                <button onclick="openBotModal()" class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs shadow-lg shadow-teal-500/20 transition active:scale-95 self-start sm:self-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Créer un Bot</span>
                </button>
            </div>

            <!-- Bots Grid -->
            <div id="botsGridContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <!-- Populated dynamically by JS -->
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- TAB: FILE D'ATTENTE (SUJETS & IMAGES) -->
        <!-- ======================================================== -->
        <section id="tab-queue" class="tab-content hidden space-y-6">
            <!-- Header & Action Buttons -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center space-x-2">
                        <span>📚</span><span>File d'Attente & Pool de Contenus pour les Bots</span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Alimentez vos bots avec une file de sujets personnalisés et un pool d'images de référence avec quotas d'utilisation (<strong class="text-teal-600 dark:text-teal-400">max_uses</strong>). Les bots consomment automatiquement les éléments actifs pour enrichir leurs générations ou créer des bannières texte stylisées.
                    </p>
                </div>

                <!-- Action Buttons Toolbar -->
                <div class="flex flex-wrap items-center gap-2">
                    <button onclick="openTopicModal()" class="px-3 py-1.5 rounded-xl bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs shadow-md shadow-teal-500/20 transition active:scale-95 flex items-center space-x-1.5">
                        <span>➕</span><span>Nouveau Sujet</span>
                    </button>
                    <button onclick="openBatchTopicsModal()" class="px-3 py-1.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold text-xs shadow-md shadow-teal-600/20 transition active:scale-95 flex items-center space-x-1.5">
                        <span>⚡</span><span>Import Sujets (10+)</span>
                    </button>
                    <button onclick="openImageModal('upload')" class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold text-xs shadow-md shadow-emerald-500/20 transition active:scale-95 flex items-center space-x-1.5">
                        <span>📤</span><span>Uploader Image(s)</span>
                    </button>
                    <button onclick="openImageModal('url')" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition active:scale-95 flex items-center space-x-1.5">
                        <span>🔗</span><span>Ajouter par URL</span>
                    </button>
                    <button onclick="openBatchImagesModal('batch_files')" class="px-3 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs border border-slate-300 dark:border-slate-700 transition active:scale-95 flex items-center space-x-1.5">
                        <span>📁</span><span>Lot Multi-Images</span>
                    </button>
                    <button onclick="openBannerModal()" class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-slate-950 font-bold text-xs shadow-md shadow-amber-500/20 transition active:scale-95 flex items-center space-x-1.5">
                        <span>🎨</span><span>Bannière Texte</span>
                    </button>
                </div>
            </div>

            <!-- Queue KPI Mini Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5">
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-3.5 flex flex-col justify-between shadow-sm dark:shadow-none transition-theme">
                    <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold uppercase tracking-wider">Sujets Actifs</span>
                    <div class="flex items-baseline space-x-2 mt-1">
                        <span id="kpiQueueActiveTopics" class="text-2xl font-extrabold text-teal-600 dark:text-teal-400">0</span>
                        <span id="kpiQueueTotalTopics" class="text-xs text-slate-400">/ 0 au total</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-3.5 flex flex-col justify-between shadow-sm dark:shadow-none transition-theme">
                    <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold uppercase tracking-wider">Images Actives</span>
                    <div class="flex items-baseline space-x-2 mt-1">
                        <span id="kpiQueueActiveImages" class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400">0</span>
                        <span id="kpiQueueTotalImages" class="text-xs text-slate-400">/ 0 au total</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-3.5 flex flex-col justify-between shadow-sm dark:shadow-none transition-theme">
                    <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold uppercase tracking-wider">Sujets Épuisés</span>
                    <div class="flex items-baseline space-x-2 mt-1">
                        <span id="kpiQueueExhaustedTopics" class="text-2xl font-extrabold text-slate-500 dark:text-slate-400">0</span>
                        <span class="text-[11px] text-slate-400 font-mono">quota atteint</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-3.5 flex flex-col justify-between shadow-sm dark:shadow-none transition-theme">
                    <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold uppercase tracking-wider">Images Épuisées</span>
                    <div class="flex items-baseline space-x-2 mt-1">
                        <span id="kpiQueueExhaustedImages" class="text-2xl font-extrabold text-slate-500 dark:text-slate-400">0</span>
                        <span class="text-[11px] text-slate-400 font-mono">quota atteint</span>
                    </div>
                </div>
            </div>

            <!-- Global Category Filter Pills Toolbar -->
            <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-3 flex flex-wrap items-center justify-between gap-3 shadow-sm dark:shadow-none transition-theme">
                <div class="flex items-center space-x-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                    <span>🏷️</span>
                    <span>Filtrer par Catégorie :</span>
                </div>
                <div class="flex flex-wrap items-center gap-1.5" id="categoryFilterPills">
                    <button type="button" onclick="setQueueCategoryFilter('all')" data-cat="all" class="queue-cat-btn px-3 py-1.5 rounded-xl font-bold bg-teal-500 text-slate-950 text-xs transition shadow-sm">
                        🌐 Toutes les catégories
                    </button>
                    <button type="button" onclick="setQueueCategoryFilter('patrimoine')" data-cat="patrimoine" class="queue-cat-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs transition">
                        🏛️ Patrimoine & UNESCO
                    </button>
                    <button type="button" onclick="setQueueCategoryFilter('plages')" data-cat="plages" class="queue-cat-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs transition">
                        🏄‍♂️ Plages & Nautisme
                    </button>
                    <button type="button" onclick="setQueueCategoryFilter('excursions')" data-cat="excursions" class="queue-cat-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs transition">
                        🐪 Désert & Quad
                    </button>
                    <button type="button" onclick="setQueueCategoryFilter('gastronomie')" data-cat="gastronomie" class="queue-cat-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs transition">
                        🍽️ Gastronomie
                    </button>
                    <button type="button" onclick="setQueueCategoryFilter('hebergements')" data-cat="hebergements" class="queue-cat-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs transition">
                        🏡 Hébergements & Menzels
                    </button>
                    <button type="button" onclick="setQueueCategoryFilter('vie_pratique')" data-cat="vie_pratique" class="queue-cat-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs transition">
                        🧭 Vie Pratique
                    </button>
                    <button type="button" onclick="setQueueCategoryFilter('general')" data-cat="general" class="queue-cat-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs transition">
                        🌴 Général
                    </button>
                </div>
            </div>

            <!-- Two-Column Queue & Image Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Left Column: Topics Queue -->
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-3xl p-5 space-y-4 shadow-sm dark:shadow-none transition-theme flex flex-col">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div class="flex items-center space-x-2">
                            <span class="text-base">📝</span>
                            <h3 class="font-bold text-sm text-slate-900 dark:text-white">File d'Attente des Sujets</h3>
                            <span id="badgeTopicsActiveCount" class="px-2 py-0.5 rounded-full bg-teal-100 dark:bg-teal-500/20 text-teal-800 dark:text-teal-300 font-bold text-[10px]">0 actifs</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <select id="filterTopicBot" onchange="renderQueue()" class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-xs text-slate-800 dark:text-slate-200 rounded-xl px-2.5 py-1.5 focus:ring-1 focus:ring-teal-500 focus:outline-none">
                                <option value="all">Tous les Bots</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search Filter -->
                    <div class="relative">
                        <input type="text" id="searchTopicsInput" oninput="renderQueue()" placeholder="Filtrer les sujets par mot-clé..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-1.5 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 pl-8 focus:ring-1 focus:ring-teal-500 focus:outline-none">
                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <!-- Topics Container List -->
                    <div id="queueTopicsList" class="space-y-3 flex-1 overflow-y-auto max-h-[600px] custom-scrollbar pr-1">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- Right Column: Images & Text Banners Pool -->
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-3xl p-5 space-y-4 shadow-sm dark:shadow-none transition-theme flex flex-col">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div class="flex items-center space-x-2">
                            <span class="text-base">🖼️</span>
                            <h3 class="font-bold text-sm text-slate-900 dark:text-white">Pool d'Images & Bannières</h3>
                            <span id="badgeImagesActiveCount" class="px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 font-bold text-[10px]">0 actives</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <select id="filterImageType" onchange="renderQueue()" class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-xs text-slate-800 dark:text-slate-200 rounded-xl px-2.5 py-1.5 focus:ring-1 focus:ring-teal-500 focus:outline-none">
                                <option value="all">Tous les Styles</option>
                                <option value="reference">Photos Référence</option>
                                <option value="text_banner">Bannières Texte</option>
                                <option value="text_card">Cartes Graphiques</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search Filter -->
                    <div class="relative">
                        <input type="text" id="searchImagesInput" oninput="renderQueue()" placeholder="Filtrer les images..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-1.5 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 pl-8 focus:ring-1 focus:ring-teal-500 focus:outline-none">
                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <!-- Images Container List -->
                    <div id="queueImagesList" class="space-y-3 flex-1 overflow-y-auto max-h-[600px] custom-scrollbar pr-1">
                        <!-- Populated by JS -->
                    </div>
                </div>

            </div>
        </section>

        <!-- ======================================================== -->
        <!-- TAB 2: HISTORIQUE PUBLICATIONS -->
        <!-- ======================================================== -->
        <section id="tab-history" class="tab-content hidden space-y-5">
            <!-- Filter & Search Toolbar -->
            <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-3 shadow-sm dark:shadow-none transition-theme">
                <div class="flex flex-wrap items-center gap-2">
                    <!-- Filter Bot -->
                    <select id="filterHistoryBot" onchange="fetchHistory()" class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-xs text-slate-800 dark:text-slate-200 rounded-xl px-3 py-2 focus:ring-1 focus:ring-teal-500 focus:outline-none">
                        <option value="">🌐 Tous les Bots</option>
                    </select>

                    <!-- Filter Status -->
                    <select id="filterHistoryStatus" onchange="renderHistory()" class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-xs text-slate-800 dark:text-slate-200 rounded-xl px-3 py-2 focus:ring-1 focus:ring-teal-500 focus:outline-none">
                        <option value="all">Tous les Statuts</option>
                        <option value="success">✅ Succès uniquement</option>
                        <option value="error">❌ Échecs uniquement</option>
                    </select>

                    <!-- View Toggle -->
                    <div class="flex items-center bg-slate-100 dark:bg-slate-800 rounded-xl p-0.5 border border-slate-300 dark:border-slate-700">
                        <button onclick="setViewMode('cards')" id="btnViewCards" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-teal-500 text-slate-950 transition">Cartes</button>
                        <button onclick="setViewMode('table')" id="btnViewTable" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition">Tableau</button>
                    </div>
                </div>

                <!-- Search Input -->
                <div class="relative flex-1 max-w-xs">
                    <input type="text" id="inputHistorySearch" oninput="renderHistory()" placeholder="Rechercher par mot-clé..." class="w-full bg-slate-50 dark:bg-slate-800/80 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:ring-1 focus:ring-teal-500 focus:outline-none pl-9">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- Cards View -->
            <div id="historyCardsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <!-- Dynamically rendered -->
            </div>

            <!-- Table View -->
            <div id="historyTableContainer" class="hidden bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm dark:shadow-none transition-theme">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700 dark:text-slate-300">
                        <thead class="bg-slate-100 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-200 dark:border-slate-800">
                            <tr>
                                <th class="px-4 py-3">Article & Image</th>
                                <th class="px-4 py-3">Bot & Cible</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Facebook Photo</th>
                                <th class="px-4 py-3">Reel 9:16</th>
                                <th class="px-4 py-3">Story 9:16</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody" class="divide-y divide-slate-200 dark:divide-slate-800/60">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- TAB 3: HUB AGENTS IA -->
        <!-- ======================================================== -->
        <section id="tab-agents" class="tab-content hidden space-y-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Catalogue & Matrice des Agents IA</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Sélectionnez les modèles adaptés à chaque besoin rédactionnel, visuel et multimédia.</p>
            </div>

            <div class="space-y-6">
                <!-- 1. Text Agents -->
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-teal-600 dark:text-teal-400 flex items-center space-x-2">
                        <span>🤖</span><span>Agents IA Texte (Modèles LLM & Rédaction)</span>
                    </h3>
                    <div id="catalogTextAgents" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>
                </div>

                <!-- 2. Image Agents -->
                <div class="space-y-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <h3 class="text-sm font-bold text-emerald-600 dark:text-emerald-400 flex items-center space-x-2">
                        <span>🎨</span><span>Agents IA Image (Génération Photoréaliste HD 16:9)</span>
                    </h3>
                    <div id="catalogImageAgents" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4"></div>
                </div>

                <!-- 3. Video Agents -->
                <div class="space-y-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <h3 class="text-sm font-bold text-pink-600 dark:text-pink-400 flex items-center space-x-2">
                        <span>🎬</span><span>Agents IA Vidéo & Reels (Vertical 9:16 HD)</span>
                    </h3>
                    <div id="catalogVideoAgents" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- TAB 4: TERMINAL LOGS -->
        <!-- ======================================================== -->
        <section id="tab-logs" class="tab-content hidden space-y-4">
            <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-3 shadow-sm dark:shadow-none transition-theme">
                <div class="flex flex-wrap items-center gap-3">
                    <select id="selectLogBot" onchange="fetchLogs()" class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-xs text-slate-800 dark:text-slate-200 rounded-xl px-3 py-2 focus:ring-1 focus:ring-teal-500 focus:outline-none">
                        <option value="">🌐 Journal Global (/var/log/djerba_bot.log)</option>
                    </select>

                    <select id="selectLogLines" onchange="fetchLogs()" class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-xs text-slate-800 dark:text-slate-200 rounded-xl px-3 py-2 focus:ring-1 focus:ring-teal-500 focus:outline-none">
                        <option value="50">50 dernières lignes</option>
                        <option value="100" selected>100 dernières lignes</option>
                        <option value="250">250 dernières lignes</option>
                        <option value="500">500 dernières lignes</option>
                        <option value="1000">1000 dernières lignes</option>
                    </select>

                    <label class="flex items-center space-x-2 text-xs text-slate-600 dark:text-slate-300 cursor-pointer">
                        <input type="checkbox" id="checkAutoRefreshLogs" checked class="rounded bg-slate-200 dark:bg-slate-800 border-slate-300 dark:border-slate-700 text-teal-500 focus:ring-teal-500">
                        <span>Auto-refresh (5s)</span>
                    </label>
                </div>

                <div class="flex items-center space-x-2">
                    <button onclick="fetchLogs()" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-semibold border border-slate-300 dark:border-slate-700 transition">
                        Rafraîchir
                    </button>
                    <button onclick="clearLogs()" class="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 dark:bg-rose-500/20 dark:hover:bg-rose-500/30 text-rose-700 dark:text-rose-300 text-xs font-semibold border border-rose-200 dark:border-rose-500/30 transition">
                        Vider les Logs
                    </button>
                </div>
            </div>

            <!-- Terminal Window -->
            <div class="bg-slate-950 border border-slate-800 rounded-2xl p-4 shadow-xl">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-800 text-xs text-slate-400">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span id="labelLogFile" class="font-mono text-slate-400 text-[11px] ml-2">/var/log/djerba_bot.log</span>
                    </div>
                    <span id="logTotalLines" class="font-mono text-[11px]">0 lignes</span>
                </div>
                <pre id="logContent" class="font-mono text-[11px] text-slate-300 overflow-x-auto whitespace-pre-wrap leading-relaxed max-h-[600px] custom-scrollbar selection:bg-teal-500 selection:text-white">Chargement des logs...</pre>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- TAB 5: SYSTÈME & RÉSEAU -->
        <!-- ======================================================== -->
        <section id="tab-system" class="tab-content hidden space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Server Info Box -->
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-5 space-y-4 shadow-sm dark:shadow-none transition-theme">
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white flex items-center space-x-2">
                        <span>🖥️</span><span>Informations Serveur Debian</span>
                    </h3>
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-1.5 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400">Hôte & Système :</span>
                            <span id="sysHostname" class="text-slate-800 dark:text-slate-200 font-mono font-medium">debian12</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400">Version PHP :</span>
                            <span id="sysPhpVersion" class="text-teal-600 dark:text-teal-400 font-mono font-bold">8.2</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400">Heure Serveur (UTC) :</span>
                            <span id="sysServerTime" class="text-slate-800 dark:text-slate-200 font-mono">--</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400">Uptime :</span>
                            <span id="sysUptime" class="text-slate-800 dark:text-slate-200 font-medium">--</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400">Service Système Cron :</span>
                            <span id="sysCronService" class="text-emerald-600 dark:text-emerald-400 font-bold font-mono">active</span>
                        </div>
                        <div class="flex justify-between py-1.5">
                            <span class="text-slate-500 dark:text-slate-400">Espace Disque :</span>
                            <span id="sysDisk" class="text-slate-800 dark:text-slate-200 font-mono">--</span>
                        </div>
                    </div>
                </div>

                <!-- Custom URL Connectivity Tester Box -->
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-5 space-y-4 shadow-sm dark:shadow-none transition-theme">
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white flex items-center space-x-2">
                        <span>🌐</span><span>Outil de Test de Connectivité Multi-Sites</span>
                    </h3>
                    <div class="space-y-3 text-xs">
                        <p class="text-slate-500 dark:text-slate-400">Testez instantanément la joignabilité et la latence d'un site web cible ou webhook configuré.</p>
                        <div class="space-y-1">
                            <label class="font-semibold text-slate-700 dark:text-slate-300">URL du site cible à tester :</label>
                            <input type="url" id="inputCustomTestUrl" value="https://djerbavoyage.tn" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                        </div>
                        <button onclick="testCustomUrlLatency()" class="w-full py-2.5 rounded-xl bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs transition shadow-md shadow-teal-500/20">
                            Tester la Latence & le Statut HTTP
                        </button>
                        <div id="boxTestResult" class="hidden p-3 bg-slate-50 dark:bg-slate-950/60 rounded-xl border border-slate-200 dark:border-slate-800 text-xs space-y-1"></div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- ======================================================== -->
    <!-- MODAL : CRÉER / MODIFIER UN BOT (AVEC ONGLETS & CONFIG DÉTAILLÉE) -->
    <!-- ======================================================== -->
    <div id="botModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 hidden">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-3xl max-h-[92vh] flex flex-col shadow-2xl overflow-hidden transition-theme">
            
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-900/50">
                <div class="flex items-center space-x-3">
                    <span id="botModalIconPreview" class="text-2xl">🤖</span>
                    <div>
                        <h3 id="botModalTitle" class="font-bold text-sm sm:text-base text-slate-900 dark:text-white">Créer un Nouveau Bot</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Configurez les paramètres éditoriaux, plateformes de diffusion, modèles IA et clés d'accès.</p>
                    </div>
                </div>
                <button onclick="closeBotModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Tabs Bar -->
            <div class="px-6 border-b border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/50 flex space-x-1.5 overflow-x-auto text-xs py-2 custom-scrollbar">
                <button type="button" onclick="switchBotModalTab('botTab-general')" id="btnBotTab-general" class="bot-tab-btn px-3 py-1.5 rounded-xl font-bold bg-teal-500 text-slate-950 flex items-center space-x-1.5 transition whitespace-nowrap shadow-sm">
                    <span>📝</span><span>1. Identité</span>
                </button>
                <button type="button" onclick="switchBotModalTab('botTab-website')" id="btnBotTab-website" class="bot-tab-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 flex items-center space-x-1.5 transition whitespace-nowrap">
                    <span>🌐</span><span>2. Site Web</span>
                </button>
                <button type="button" onclick="switchBotModalTab('botTab-social')" id="btnBotTab-social" class="bot-tab-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 flex items-center space-x-1.5 transition whitespace-nowrap">
                    <span>📘</span><span>3. Réseaux & FB</span>
                </button>
                <button type="button" onclick="switchBotModalTab('botTab-ai')" id="btnBotTab-ai" class="bot-tab-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 flex items-center space-x-1.5 transition whitespace-nowrap">
                    <span>🧠</span><span>4. Agents IA</span>
                </button>
                <button type="button" onclick="switchBotModalTab('botTab-schedule')" id="btnBotTab-schedule" class="bot-tab-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 flex items-center space-x-1.5 transition whitespace-nowrap">
                    <span>⏱️</span><span>5. Cadence</span>
                </button>
                <button type="button" onclick="switchBotModalTab('botTab-custom-keys')" id="btnBotTab-custom-keys" class="bot-tab-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 flex items-center space-x-1.5 transition whitespace-nowrap">
                    <span>🔑</span><span>6. Clés & Consignes</span>
                </button>
            </div>

            <!-- Modal Form (Scrollable) -->
            <form id="formBot" onsubmit="saveBotForm(event)" class="px-6 py-5 overflow-y-auto space-y-4 text-xs custom-scrollbar flex-1">
                <input type="hidden" id="botInputId" value="">

                <!-- TAB 1 : IDENTITÉ & ORIENTATION ÉDITORIALE -->
                <div id="botTab-general" class="bot-tab-pane space-y-4">
                    <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-3">
                        <div class="font-bold text-slate-800 dark:text-slate-200 text-xs flex items-center space-x-2">
                            <span>📝</span><span>Profil & Rôle Éditorial du Bot</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                            <div class="sm:col-span-3 space-y-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">Nom du Bot *</label>
                                <input type="text" id="botInputName" required placeholder="ex: Bot Hébergements & Menzels" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            </div>
                            <div class="space-y-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">Icône Emoji</label>
                                <select id="botInputIcon" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none text-base">
                                    <option value="🌴">🌴 Palmier Djerba</option>
                                    <option value="🏛️">🏛️ Culture / UNESCO</option>
                                    <option value="🏡">🏡 Menzel / Hôtel</option>
                                    <option value="🏄‍♂️">🏄‍♂️ Kitesurf / Mer</option>
                                    <option value="🍽️">🍽️ Gastronomie</option>
                                    <option value="🐪">🐪 Excursion Désert</option>
                                    <option value="🏺">🏺 Poterie / Artisanat</option>
                                    <option value="⛵">⛵ Voilier / Lagune</option>
                                    <option value="🌟">🌟 Guide Prestige</option>
                                    <option value="📰">📰 Actualités & Médias</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">Niche Éditoriale / Thématique Cible</label>
                                <input type="text" id="botInputTheme" placeholder="ex: Culture, Patrimoine & UNESCO ou Gastronomie" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            </div>
                            <div class="space-y-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">État d'Activation</label>
                                <select id="botInputStatus" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                                    <option value="active">🟢 Actif (Planification en cours)</option>
                                    <option value="paused">⏸️ En Pause</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="font-semibold text-slate-700 dark:text-slate-300">Description & Orientation Éditoriale</label>
                            <textarea id="botInputDesc" rows="2" placeholder="Objectif général et ton de ce bot..." class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none"></textarea>
                        </div>

                        <!-- Multi-Categories Selector for Bot -->
                        <div class="space-y-2 pt-2 border-t border-slate-200/80 dark:border-slate-800/80">
                            <div class="flex items-center justify-between">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">Catégories Autorisées du Pool de Contenus</label>
                                <span class="text-[10px] text-teal-600 dark:text-teal-400 font-semibold">Ce bot piochera dans ces catégories</span>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs" id="botCategoriesCheckboxes">
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-teal-400 transition">
                                    <input type="checkbox" name="botCategories" value="all" id="catCheck_all" onchange="toggleAllBotCategories(this)" class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="font-bold text-slate-800 dark:text-slate-200">🌐 Toutes</span>
                                </label>
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-teal-400 transition">
                                    <input type="checkbox" name="botCategories" value="patrimoine" id="catCheck_patrimoine" onchange="toggleSingleBotCategory()" class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="text-slate-800 dark:text-slate-200">🏛️ Patrimoine</span>
                                </label>
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-teal-400 transition">
                                    <input type="checkbox" name="botCategories" value="plages" id="catCheck_plages" onchange="toggleSingleBotCategory()" class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="text-slate-800 dark:text-slate-200">🏄‍♂️ Plages</span>
                                </label>
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-teal-400 transition">
                                    <input type="checkbox" name="botCategories" value="excursions" id="catCheck_excursions" onchange="toggleSingleBotCategory()" class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="text-slate-800 dark:text-slate-200">🐪 Excursions</span>
                                </label>
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-teal-400 transition">
                                    <input type="checkbox" name="botCategories" value="gastronomie" id="catCheck_gastronomie" onchange="toggleSingleBotCategory()" class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="text-slate-800 dark:text-slate-200">🍽️ Gastronomie</span>
                                </label>
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-teal-400 transition">
                                    <input type="checkbox" name="botCategories" value="hebergements" id="catCheck_hebergements" onchange="toggleSingleBotCategory()" class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="text-slate-800 dark:text-slate-200">🏡 Hébergements</span>
                                </label>
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-teal-400 transition">
                                    <input type="checkbox" name="botCategories" value="vie_pratique" id="catCheck_vie_pratique" onchange="toggleSingleBotCategory()" class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="text-slate-800 dark:text-slate-200">🧭 Vie Pratique</span>
                                </label>
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-teal-400 transition">
                                    <input type="checkbox" name="botCategories" value="general" id="catCheck_general" onchange="toggleSingleBotCategory()" class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="text-slate-800 dark:text-slate-200">🌴 Général</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2 : DESTINATION SITE WEB & CMS -->
                <div id="botTab-website" class="bot-tab-pane space-y-4 hidden">
                    <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-3">
                        <div class="font-bold text-slate-800 dark:text-slate-200 text-xs flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span>🌐</span><span>Site Web & CMS Cible (Où publier l'article)</span>
                            </div>
                            <button type="button" onclick="testBotEndpoint()" class="text-[11px] text-teal-600 dark:text-teal-400 hover:underline font-bold flex items-center space-x-1">
                                <span>⚡</span><span>Tester ce Site</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="space-y-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">Nom du Site Cible</label>
                                <input type="text" id="botInputSiteName" placeholder="ex: Djerba Voyage" value="Djerba Voyage" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            </div>
                            <div class="sm:col-span-2 space-y-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">URL Principale du Site</label>
                                <input type="url" id="botInputSiteUrl" placeholder="https://djerbavoyage.tn ou https://monsite.com" value="https://djerbavoyage.tn" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="sm:col-span-2 space-y-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">Endpoint API de Génération</label>
                                <input type="url" id="botInputApiEndpoint" placeholder="https://djerbavoyage.tn/api/auto-blog/generate" value="https://djerbavoyage.tn/api/auto-blog/generate" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            </div>
                            <div class="space-y-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">Token Secret API</label>
                                <input type="text" id="botInputSecretToken" placeholder="djerba_secret_cron_key_2026" value="djerba_secret_cron_key_2026" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3 : RÉSEAUX SOCIAUX & FACEBOOK -->
                <div id="botTab-social" class="bot-tab-pane space-y-4 hidden">
                    <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-3">
                        <div class="font-bold text-slate-800 dark:text-slate-200 text-xs flex items-center space-x-2">
                            <span>📘</span><span>Page Facebook & Réseaux Sociaux Cibles</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">Nom de la Page Facebook</label>
                                <input type="text" id="botInputFbPageName" placeholder="ex: Djerba Voyage Officiel ou Mon Autre Page" value="Djerba Voyage Officiel" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            </div>
                            <div class="space-y-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">ID de la Page Facebook (Optionnel)</label>
                                <input type="text" id="botInputFbPageId" placeholder="ex: 104192661073862 (laisser vide si par défaut)" value="104192661073862" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="font-semibold text-slate-700 dark:text-slate-300">Jeton d'Accès Facebook Dédié (Optionnel)</label>
                            <input type="password" id="botInputFbToken" placeholder="Laisser vide pour utiliser le jeton global du serveur (.env)" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                        </div>
                    </div>
                </div>

                <!-- TAB 4 : SÉLECTION & TESTS DES AGENTS IA -->
                <div id="botTab-ai" class="bot-tab-pane space-y-4 hidden">
                    <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="font-bold text-slate-800 dark:text-slate-200 flex items-center space-x-2">
                                <span>🧠</span><span>Agents IA (Texte / Image / Vidéo)</span>
                            </div>
                            <span class="text-[11px] text-slate-400">Tests en temps réel avec latence</span>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <!-- Text Agent -->
                            <div class="space-y-2 flex flex-col justify-start">
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="font-semibold text-teal-700 dark:text-teal-400">Agent Texte (LLM)</label>
                                        <button type="button" onclick="testSelectedTextAgent()" id="btnTestText" class="px-2 py-0.5 rounded-lg bg-teal-100 hover:bg-teal-200 dark:bg-teal-500/20 dark:hover:bg-teal-500/30 text-teal-800 dark:text-teal-300 text-[11px] font-bold border border-teal-300 dark:border-teal-500/30 flex items-center space-x-1 transition active:scale-95">
                                            <span>⚡</span><span>Tester</span>
                                        </button>
                                    </div>
                                    <select id="botInputAgentText" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-2.5 py-2 text-slate-800 dark:text-slate-200 text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                                        <optgroup label="⭐ Modèles Google Gemini & Gemma (Recommandés)">
                                            <option value="gemini-2.5-flash">Google Gemini 2.5 Flash ⭐ (Recommandé)</option>
                                            <option value="gemini-2.5-pro">Google Gemini 2.5 Pro (Raisonnement & Fond)</option>
                                            <option value="gemini-2.0-flash">Google Gemini 2.0 Flash (Temps Réel)</option>
                                            <option value="gemini-2.0-flash-lite">Google Gemini 2.0 Flash Lite (Ultra-Léger)</option>
                                            <option value="gemini-2.0-pro-exp-02-05">Google Gemini 2.0 Pro Experimental</option>
                                            <option value="gemini-1.5-pro">Google Gemini 1.5 Pro (Mémoire 2M Tokens)</option>
                                            <option value="gemini-1.5-flash">Google Gemini 1.5 Flash (Éprouvé)</option>
                                            <option value="gemini-1.5-flash-8b">Google Gemini 1.5 Flash 8B (Micro-Modèle)</option>
                                            <option value="gemma-2-27b">Google Gemma 2 27B (Open Weights)</option>
                                            <option value="gemma-2-9b">Google Gemma 2 9B (Open Weights Compact)</option>
                                            <option value="learnlm-1.5-pro-experimental">Google LearnLM 1.5 Pro (Pédagogique)</option>
                                        </optgroup>
                                        <optgroup label="🆓 Modèles 100% Gratuits (Sans clé API requise)">
                                            <option value="pollinations-openai">Pollinations OpenAI (GPT-4o-mini Gratuit)</option>
                                            <option value="pollinations-qwen">Pollinations Qwen 2.5 72B (Gratuit • Très riche)</option>
                                            <option value="pollinations-mistral">Pollinations Mistral Nemo (Gratuit)</option>
                                            <option value="pollinations-llama">Pollinations Meta Llama 3.3 70B (Gratuit)</option>
                                            <option value="pollinations-deepseek">Pollinations DeepSeek R1 (Gratuit • Réflexion)</option>
                                        </optgroup>
                                        <optgroup label="⚡ Modèles Haute Vitesse Groq (Free Tier)">
                                            <option value="groq-llama-3.3-70b">Groq Meta Llama 3.3 70B (Ultra-Vitesse LPU)</option>
                                            <option value="groq-llama-3.1-8b">Groq Meta Llama 3.1 8B (Instantané)</option>
                                            <option value="groq-deepseek-r1-70b">Groq DeepSeek R1 70B (Raisonnement LPU)</option>
                                            <option value="groq-mixtral-8x7b">Groq Mistral Mixtral 8x7B MoE</option>
                                        </optgroup>
                                        <optgroup label="💎 Modèles Propriétaires Optionnels">
                                            <option value="deepseek-chat">DeepSeek V3 (Ultra-Économique)</option>
                                            <option value="gpt-4o">OpenAI GPT-4o (Flagship)</option>
                                            <option value="gpt-4o-mini">OpenAI GPT-4o Mini</option>
                                            <option value="claude-3-5-sonnet">Anthropic Claude 3.5 Sonnet</option>
                                            <option value="claude-3-5-haiku">Anthropic Claude 3.5 Haiku</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div id="resultTestText" class="hidden p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-xs space-y-1.5 shadow-sm"></div>
                            </div>

                            <!-- Image Agent -->
                            <div class="space-y-2 flex flex-col justify-start">
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="font-semibold text-emerald-700 dark:text-emerald-400">Agent Image</label>
                                        <button type="button" onclick="testSelectedImageAgent()" id="btnTestImage" class="px-2 py-0.5 rounded-lg bg-emerald-100 hover:bg-emerald-200 dark:bg-emerald-500/20 dark:hover:bg-emerald-500/30 text-emerald-800 dark:text-emerald-300 text-[11px] font-bold border border-emerald-300 dark:border-emerald-500/30 flex items-center space-x-1 transition active:scale-95">
                                            <span>⚡</span><span>Tester</span>
                                        </button>
                                    </div>
                                    <select id="botInputAgentImage" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-2.5 py-2 text-slate-800 dark:text-slate-200 text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                                        <optgroup label="⭐ Moteurs Google Imagen & Studio Dédié">
                                            <option value="nano-banana">Nano Banana HD ⭐ (Google Imagen / Photoréaliste)</option>
                                        </optgroup>
                                        <optgroup label="🆓 Modèles 100% Gratuits (Sans clé requise)">
                                            <option value="pollinations-flux">Pollinations Flux HD (Génération Rapide)</option>
                                            <option value="stability-sdxl">Stability SDXL Cinématique (Large 16:9)</option>
                                        </optgroup>
                                        <optgroup label="💎 Modèles Propriétaires (Clé API Dédiée)">
                                            <option value="dall-e-3">OpenAI DALL-E 3 (Architecture & Haute Précision)</option>
                                            <option value="dall-e-2">OpenAI DALL-E 2 (Format Carré 512x512)</option>
                                        </optgroup>
                                        <optgroup label="🎨 Studio Graphique Interne">
                                            <option value="djerba-banner">Studio Bannières & Cartes Graphiques</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div id="resultTestImage" class="hidden p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-xs space-y-1.5 shadow-sm"></div>
                            </div>

                            <!-- Video Agent -->
                            <div class="space-y-2 flex flex-col justify-start">
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="font-semibold text-pink-700 dark:text-pink-400">Agent Vidéo / Reel</label>
                                        <button type="button" onclick="testSelectedVideoAgent()" id="btnTestVideo" class="px-2 py-0.5 rounded-lg bg-pink-100 hover:bg-pink-200 dark:bg-pink-500/20 dark:hover:bg-pink-500/30 text-pink-800 dark:text-pink-300 text-[11px] font-bold border border-pink-300 dark:border-pink-500/30 flex items-center space-x-1 transition active:scale-95">
                                            <span>⚡</span><span>Tester</span>
                                        </button>
                                    </div>
                                    <select id="botInputAgentVideo" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-2.5 py-2 text-slate-800 dark:text-slate-200 text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                                        <option value="reel-5photo-kenburns">Reel 9:16 Ken Burns ⭐ (1080x1920 HD)</option>
                                        <option value="none">Désactivé (Photo seule)</option>
                                    </select>
                                </div>
                                <div id="resultTestVideo" class="hidden p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-xs space-y-1.5 shadow-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 5 : CADENCE & CANAUX DE DIFFUSION -->
                <div id="botTab-schedule" class="bot-tab-pane space-y-4 hidden">
                    <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">Fréquence de Génération (Cron)</label>
                                <select id="botInputSchedule" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                                    <option value="15m">Toutes les 15 minutes</option>
                                    <option value="30m">Toutes les 30 minutes</option>
                                    <option value="1h">Toutes les 1 heure</option>
                                    <option value="2h">Toutes les 2 heures</option>
                                    <option value="4h">Toutes les 4 heures</option>
                                    <option value="6h">Toutes les 6 heures</option>
                                    <option value="12h">Toutes les 12 heures</option>
                                    <option value="daily_08">Quotidien à 08h00</option>
                                    <option value="daily_12">Quotidien à 12h00</option>
                                    <option value="daily_18">Quotidien à 18h00</option>
                                    <option value="manual">Manuel uniquement</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="font-semibold text-slate-700 dark:text-slate-300">Canaux de Diffusion Actifs</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer">
                                    <input type="checkbox" id="botInputChWebsite" checked class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="text-slate-800 dark:text-slate-200">Site Web</span>
                                </label>
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer">
                                    <input type="checkbox" id="botInputChPdf" checked class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="text-slate-800 dark:text-slate-200">Guide PDF</span>
                                </label>
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer">
                                    <input type="checkbox" id="botInputChFbPhoto" checked class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="text-slate-800 dark:text-slate-200">Photo FB</span>
                                </label>
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer">
                                    <input type="checkbox" id="botInputChFbReel" checked class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="text-slate-800 dark:text-slate-200">Reel FB</span>
                                </label>
                                <label class="flex items-center space-x-2 bg-white dark:bg-slate-800 p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer col-span-2 sm:col-span-1">
                                    <input type="checkbox" id="botInputChFbStory" checked class="rounded bg-slate-200 dark:bg-slate-700 border-slate-300 dark:border-slate-600 text-teal-500">
                                    <span class="text-slate-800 dark:text-slate-200">Story (9:16)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 6 : CLÉS API & CONSIGNES PERSONNALISÉES -->
                <div id="botTab-custom-keys" class="bot-tab-pane space-y-4 hidden">
                    <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-4">
                        <div class="font-bold text-slate-800 dark:text-slate-200 text-xs flex items-center space-x-2">
                            <span>🔑</span><span>Clés API Dédiées & Instructions Système (System Prompt)</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-semibold text-slate-700 dark:text-slate-300">Clé API Google Gemini Dédiée</label>
                                    <span class="text-[10px] text-slate-400">Texte & Imagen</span>
                                </div>
                                <input type="password" id="botInputGeminiKey" placeholder="Laisser vide pour utiliser .env serveur" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            </div>

                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-semibold text-slate-700 dark:text-slate-300">Clé API Groq LPU Dédiée</label>
                                    <span class="text-[10px] text-slate-400">Texte Ultra-Rapide</span>
                                </div>
                                <input type="password" id="botInputGroqKey" placeholder="Laisser vide pour utiliser .env serveur" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            </div>

                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-semibold text-slate-700 dark:text-slate-300">Clé API OpenAI Dédiée</label>
                                    <span class="text-[10px] text-slate-400">DALL-E 3 & GPT-4o</span>
                                </div>
                                <input type="password" id="botInputOpenAiKey" placeholder="sk-... (Optionnel pour DALL-E 3)" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            </div>

                            <div class="space-y-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-semibold text-slate-700 dark:text-slate-300">Clé API Stability AI Dédiée</label>
                                    <span class="text-[10px] text-slate-400">SDXL 1.0 Cloud</span>
                                </div>
                                <input type="password" id="botInputStabilityKey" placeholder="sk-... (Optionnel pour Stability)" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <label class="font-semibold text-slate-700 dark:text-slate-300">Instructions & Consignes IA Dédiées (System Prompt)</label>
                                <span class="text-[10px] text-slate-400">Pour ce bot</span>
                            </div>
                            <textarea id="botInputCustomInstructions" rows="3" placeholder="ex: Tu es un guide touristique local tunisien passionné, adopte un ton chaleureux, poétique, mentionne les légendes de Djerba et valorise le patrimoine UNESCO..." class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none text-xs"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <button type="button" id="btnDeleteFromModal" onclick="confirmDeleteFromModal()" class="hidden px-3.5 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 dark:bg-rose-500/20 dark:hover:bg-rose-500/30 text-rose-700 dark:text-rose-300 font-bold text-xs border border-rose-200 dark:border-rose-500/30 transition">
                            🗑️ Supprimer ce bot
                        </button>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="button" onclick="closeBotModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs transition">
                            Annuler
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-slate-950 font-bold text-xs shadow-lg shadow-teal-500/20 transition active:scale-95">
                            Sauvegarder le Bot
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL : CONFIRMATION DE SUPPRESSION -->
    <!-- ======================================================== -->
    <div id="deleteModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 max-w-md w-full text-center space-y-4 shadow-2xl transition-theme">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 mx-auto flex items-center justify-center text-2xl">
                🗑️
            </div>
            <div class="space-y-1">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Supprimer ce Bot ?</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Cette action supprimera définitivement le bot, sa planification cron et son journal de logs dédié.</p>
            </div>
            <div class="p-3 bg-slate-50 dark:bg-slate-950/80 rounded-2xl border border-slate-200 dark:border-slate-800 text-xs font-semibold text-slate-800 dark:text-slate-200" id="deleteModalBotName">
                --
            </div>
            <div class="grid grid-cols-2 gap-3 pt-2">
                <button onclick="closeDeleteModal()" class="py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs transition">
                    Annuler
                </button>
                <button onclick="executeDeleteBot()" id="btnConfirmDelete" class="py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs shadow-lg shadow-rose-600/20 transition active:scale-95">
                    Oui, Supprimer
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL : EXÉCUTION D'UN CYCLE EN DIRECT -->
    <!-- ======================================================== -->
    <div id="executionModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 max-w-lg w-full text-center space-y-5 shadow-2xl transition-theme">
            <div id="modalSpinner" class="flex flex-col items-center space-y-3">
                <div class="w-14 h-14 rounded-full border-4 border-teal-500/20 border-t-teal-500 animate-spin"></div>
                <div class="text-xs text-teal-600 dark:text-teal-400 font-mono font-bold" id="modalTimer">0.0s</div>
            </div>
            <div id="modalSuccessIcon" class="hidden text-5xl">
                ✨
            </div>

            <div class="space-y-1">
                <h3 id="modalTitle" class="text-base font-bold text-slate-900 dark:text-white">Génération du Cycle IA en cours...</h3>
                <p id="modalDesc" class="text-xs text-slate-500 dark:text-slate-400">Exécution de la pipeline IA...</p>
            </div>

            <div id="modalArticlePreview" class="hidden text-left bg-slate-50 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-2 text-xs"></div>

            <button onclick="document.getElementById('executionModal').classList.add('hidden')" id="btnModalClose" class="hidden w-full py-2.5 rounded-xl bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs transition">
                Fermer & Voir l'Historique
            </button>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL : AJOUTER UN SUJET UNIQUE -->
    <!-- ======================================================== -->
    <div id="topicModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-xl shadow-2xl overflow-hidden transition-theme">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-900/50">
                <div class="flex items-center space-x-2.5">
                    <span class="text-xl">📝</span>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900 dark:text-white">Nouveau Sujet d'Article</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Ajoutez un sujet précis que le bot utilisera pour ses prochains cycles.</p>
                    </div>
                </div>
                <button onclick="closeTopicModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white p-1 rounded-lg">✕</button>
            </div>

            <form id="formTopic" onsubmit="saveTopicForm(event)" class="p-6 space-y-4 text-xs">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700 dark:text-slate-300">Titre ou Thème Précis du Sujet *</label>
                    <input type="text" id="topicInputTitle" required placeholder="ex: Les Meilleurs Spots Secrets de Kitesurf à la Lagune de Djerba" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Bot Cible Associé</label>
                        <select id="topicInputBotId" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            <option value="all">🌐 Tous les Bots (Partagé)</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Catégorie</label>
                        <select id="topicInputCategory" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            <option value="patrimoine">🏛️ Patrimoine & UNESCO</option>
                            <option value="plages">🏄‍♂️ Plages & Nautisme</option>
                            <option value="excursions">🐪 Excursions & Désert</option>
                            <option value="gastronomie">🍽️ Gastronomie</option>
                            <option value="hebergements">🏡 Hébergements & Menzels</option>
                            <option value="vie_pratique">🧭 Vie Pratique</option>
                            <option value="general" selected>🌴 Général / Découverte</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Utilisations Max</label>
                        <input type="number" id="topicInputMaxUses" min="1" max="100" value="1" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-slate-700 dark:text-slate-300">Mots-clés SEO (Optionnel)</label>
                    <input type="text" id="topicInputKeywords" placeholder="kitesurf, lagune, vent, spots secrets" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-slate-700 dark:text-slate-300">Consignes & Angle Éditorial pour l'IA (Optionnel)</label>
                    <textarea id="topicInputGuidelines" rows="2" placeholder="Précisez des angles, des points clés ou des conseils à aborder..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none"></textarea>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex justify-end space-x-2">
                    <button type="button" onclick="closeTopicModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold transition">Annuler</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold shadow-md shadow-teal-500/20 transition active:scale-95">Ajouter à la File</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL : IMPORT EN MASSE DE SUJETS (10+) -->
    <!-- ======================================================== -->
    <div id="batchTopicModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-xl shadow-2xl overflow-hidden transition-theme">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-900/50">
                <div class="flex items-center space-x-2.5">
                    <span class="text-xl">⚡</span>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900 dark:text-white">Import en Masse de Sujets</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Collez une liste de titres (ex: 10 sujets, un par ligne).</p>
                    </div>
                </div>
                <button onclick="closeBatchTopicsModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white p-1 rounded-lg">✕</button>
            </div>

            <form id="formBatchTopics" onsubmit="saveBatchTopicsForm(event)" class="p-6 space-y-4 text-xs">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700 dark:text-slate-300">Liste des Sujets (1 par ligne) *</label>
                    <textarea id="batchTopicsInputText" required rows="7" placeholder="Top 5 des plages secrètes de Djerba&#10;L'Histoire fascinante de la synagogue de la Ghriba&#10;Guide complet du Kitesurf à la lagune&#10;Les secrets des potiers de Guellala&#10;Où déguster les meilleurs poissons frais à Houmt Souk ?" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-[11px] focus:ring-1 focus:ring-teal-500 focus:outline-none"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Assigner au Bot</label>
                        <select id="batchTopicsInputBotId" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            <option value="all">🌐 Tous les Bots (Partagé)</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Catégorie du Lot</label>
                        <select id="batchTopicsInputCategory" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            <option value="patrimoine">🏛️ Patrimoine & UNESCO</option>
                            <option value="plages">🏄‍♂️ Plages & Nautisme</option>
                            <option value="excursions">🐪 Excursions & Désert</option>
                            <option value="gastronomie">🍽️ Gastronomie</option>
                            <option value="hebergements">🏡 Hébergements & Menzels</option>
                            <option value="vie_pratique">🧭 Vie Pratique</option>
                            <option value="general" selected>🌴 Général / Découverte</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Quota / Sujet</label>
                        <input type="number" id="batchTopicsInputMaxUses" min="1" max="50" value="1" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex justify-end space-x-2">
                    <button type="button" onclick="closeBatchTopicsModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold transition">Annuler</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold shadow-md shadow-teal-600/20 transition active:scale-95">Importer les Sujets</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL : AJOUTER / UPLOADER UNE IMAGE (FICHIER LOCAL OU URL) -->
    <!-- ======================================================== -->
    <div id="imageModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-xl max-h-[92vh] flex flex-col shadow-2xl overflow-hidden transition-theme">
            
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-900/50">
                <div class="flex items-center space-x-2.5">
                    <span class="text-xl">🖼️</span>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900 dark:text-white" id="imageModalHeaderTitle">Ajouter une Image au Pool</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Téléversez un fichier depuis votre ordinateur ou saisissez une URL.</p>
                    </div>
                </div>
                <button onclick="closeImageModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white p-1 rounded-lg">✕</button>
            </div>

            <!-- Sub-Tabs Switcher (Upload vs URL) -->
            <div class="px-6 pt-3 pb-1 border-b border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30 flex space-x-2 text-xs">
                <button type="button" onclick="switchImageModalSubTab('upload')" id="btnImageTab-upload" class="px-3.5 py-1.5 rounded-xl font-bold bg-teal-500 text-slate-950 flex items-center space-x-1.5 transition shadow-sm">
                    <span>📤</span><span>Fichier Local (Upload)</span>
                </button>
                <button type="button" onclick="switchImageModalSubTab('url')" id="btnImageTab-url" class="px-3.5 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 flex items-center space-x-1.5 transition">
                    <span>🔗</span><span>URL Web Directe</span>
                </button>
            </div>

            <form id="formImage" onsubmit="saveImageForm(event)" class="p-6 space-y-4 text-xs overflow-y-auto custom-scrollbar flex-1">
                
                <!-- PANE 1: DIRECT FILE UPLOAD (DRAG & DROP) -->
                <div id="imageModalPane-upload" class="space-y-3">
                    <div id="singleDropZone" onclick="document.getElementById('singleImageFileInput').click()" class="border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-teal-500 dark:hover:border-teal-400 rounded-2xl p-6 text-center cursor-pointer transition bg-slate-50/50 dark:bg-slate-950/40 space-y-2">
                        <input type="file" id="singleImageFileInput" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml" class="hidden" onchange="handleSingleFileSelect(this.files)">
                        <div class="w-12 h-12 mx-auto rounded-2xl bg-teal-50 dark:bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center text-2xl">
                            📤
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 dark:text-slate-200 text-xs">Glissez-déposez votre image ici ou <span class="text-teal-600 dark:text-teal-400 underline">parcourez</span></p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Formats: JPG, PNG, WEBP, GIF, SVG (Stockage local + Synchro FTP)</p>
                        </div>
                    </div>

                    <!-- Single File Preview Box -->
                    <div id="singleFilePreviewBox" class="hidden p-3 bg-slate-50 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 rounded-2xl flex items-center space-x-3">
                        <div class="w-16 h-14 rounded-xl bg-slate-950 overflow-hidden border border-slate-700 flex-shrink-0">
                            <img id="singleFilePreviewImg" src="" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 id="singleFileName" class="font-bold text-slate-900 dark:text-white truncate">image.jpg</h4>
                            <p id="singleFileSize" class="text-[10px] text-slate-400 font-mono">0 KB</p>
                        </div>
                        <button type="button" onclick="clearSingleFileSelect()" class="p-1.5 rounded-lg bg-rose-50 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 hover:bg-rose-100 text-xs">✕</button>
                    </div>
                </div>

                <!-- PANE 2: WEB URL INPUT -->
                <div id="imageModalPane-url" class="space-y-3 hidden">
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">URL Web de l'Image *</label>
                        <input type="url" id="imageInputUrl" placeholder="https://djerbavoyage.tn/assets/images/service_kitesurf.jpg" oninput="previewModalImage(this.value)" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-[11px] focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div id="boxImagePreviewModal" class="hidden aspect-video bg-slate-950 rounded-xl overflow-hidden border border-slate-700">
                        <img id="imgPreviewModal" src="" class="w-full h-full object-cover">
                    </div>
                </div>

                <!-- SHARED METADATA FIELDS -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 border-t border-slate-200/80 dark:border-slate-800">
                    <div class="sm:col-span-2 space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Titre ou Description du Visuel</label>
                        <input type="text" id="imageInputTitle" placeholder="ex: Kitesurfeur en vol turquoise" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Type / Style</label>
                        <select id="imageInputStyle" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            <option value="reference">Photo Référence</option>
                            <option value="text_banner">Bannière Texte</option>
                            <option value="text_card">Carte Graphique</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Bot Cible</label>
                        <select id="imageInputBotId" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            <option value="all">🌐 Tous les Bots</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Catégorie</label>
                        <select id="imageInputCategory" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            <option value="patrimoine">🏛️ Patrimoine & UNESCO</option>
                            <option value="plages">🏄‍♂️ Plages & Nautisme</option>
                            <option value="excursions">🐪 Excursions & Désert</option>
                            <option value="gastronomie">🍽️ Gastronomie</option>
                            <option value="hebergements">🏡 Hébergements & Menzels</option>
                            <option value="vie_pratique">🧭 Vie Pratique</option>
                            <option value="general" selected>🌴 Général / Découverte</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Quota d'Utilisations</label>
                        <input type="number" id="imageInputMaxUses" min="1" max="100" value="3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex justify-end space-x-2">
                    <button type="button" onclick="closeImageModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold transition">Annuler</button>
                    <button type="submit" id="btnSubmitSingleImage" class="px-5 py-2 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-slate-950 font-bold shadow-md shadow-teal-500/20 transition active:scale-95 flex items-center space-x-1.5">
                        <span>✨</span><span id="labelSubmitSingleImage">Ajouter au Pool</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL : IMPORT / TÉLÉVERSEMENT EN MASSE D'IMAGES (10+) -->
    <!-- ======================================================== -->
    <div id="batchImageModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-2xl max-h-[92vh] flex flex-col shadow-2xl overflow-hidden transition-theme">
            
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-900/50">
                <div class="flex items-center space-x-2.5">
                    <span class="text-xl">📁</span>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900 dark:text-white">Import & Téléversement Multiple d'Images</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Importez un lot complet de photos locales ou une liste d'URLs.</p>
                    </div>
                </div>
                <button onclick="closeBatchImagesModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white p-1 rounded-lg">✕</button>
            </div>

            <!-- Sub-Tabs Switcher (Multi-Files Upload vs URL List) -->
            <div class="px-6 pt-3 pb-1 border-b border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30 flex space-x-2 text-xs">
                <button type="button" onclick="switchBatchModalSubTab('batch_files')" id="btnBatchTab-files" class="px-3.5 py-1.5 rounded-xl font-bold bg-teal-500 text-slate-950 flex items-center space-x-1.5 transition shadow-sm">
                    <span>📁</span><span>Lot de Fichiers Locaux (Multi-Images)</span>
                </button>
                <button type="button" onclick="switchBatchModalSubTab('batch_urls')" id="btnBatchTab-urls" class="px-3.5 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 flex items-center space-x-1.5 transition">
                    <span>🔗</span><span>Liste d'URLs Web (1 par ligne)</span>
                </button>
            </div>

            <form id="formBatchImages" onsubmit="saveBatchImagesForm(event)" class="p-6 space-y-4 text-xs overflow-y-auto custom-scrollbar flex-1">
                
                <!-- PANE 1: MULTI-FILES LOCAL UPLOAD -->
                <div id="batchModalPane-files" class="space-y-3">
                    <div id="batchDropZone" onclick="document.getElementById('batchFilesInput').click()" class="border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-teal-500 dark:hover:border-teal-400 rounded-2xl p-6 text-center cursor-pointer transition bg-slate-50/50 dark:bg-slate-950/40 space-y-2">
                        <input type="file" id="batchFilesInput" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml" multiple class="hidden" onchange="handleBatchFilesSelect(this.files)">
                        <div class="w-12 h-12 mx-auto rounded-2xl bg-teal-50 dark:bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center text-2xl">
                            📁
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 dark:text-slate-200 text-xs">Glissez-déposez plusieurs images ici ou <span class="text-teal-600 dark:text-teal-400 underline">cliquez pour sélectionner</span></p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Sélection multiple supportée (1 à 50 images en une seule opération)</p>
                        </div>
                    </div>

                    <!-- Selected Files Grid Preview -->
                    <div id="batchFilesPreviewWrapper" class="hidden space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-800 dark:text-slate-200 text-xs" id="batchFilesSummaryText">0 fichier(s) sélectionné(s)</span>
                            <button type="button" onclick="clearBatchFilesSelect()" class="text-[11px] text-rose-500 hover:underline font-semibold">Tout effacer</button>
                        </div>
                        <div id="batchFilesPreviewGrid" class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 max-h-48 overflow-y-auto custom-scrollbar p-1">
                            <!-- Populated dynamically -->
                        </div>
                    </div>
                </div>

                <!-- PANE 2: URLS LIST INPUT -->
                <div id="batchModalPane-urls" class="space-y-2 hidden">
                    <label class="font-semibold text-slate-700 dark:text-slate-300">URLs des Images (1 par ligne) *</label>
                    <textarea id="batchImagesInputText" rows="6" placeholder="https://djerbavoyage.tn/assets/images/service_kitesurf.jpg&#10;https://djerbavoyage.tn/assets/images/concierge.png&#10;https://images.unsplash.com/photo-1507525428034-b723cf961d3e" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-[11px] focus:ring-1 focus:ring-teal-500 focus:outline-none"></textarea>
                </div>

                <!-- SHARED CONFIGURATION -->
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 pt-2 border-t border-slate-200/80 dark:border-slate-800">
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Style</label>
                        <select id="batchImagesInputStyle" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            <option value="reference">Photo Référence</option>
                            <option value="text_banner">Bannière Texte</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Bot Cible</label>
                        <select id="batchImagesInputBotId" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            <option value="all">🌐 Tous les Bots</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Catégorie</label>
                        <select id="batchImagesInputCategory" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            <option value="patrimoine">🏛️ Patrimoine & UNESCO</option>
                            <option value="plages">🏄‍♂️ Plages & Nautisme</option>
                            <option value="excursions">🐪 Excursions & Désert</option>
                            <option value="gastronomie">🍽️ Gastronomie</option>
                            <option value="hebergements">🏡 Hébergements & Menzels</option>
                            <option value="vie_pratique">🧭 Vie Pratique</option>
                            <option value="general" selected>🌴 Général / Découverte</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Quota / Image</label>
                        <input type="number" id="batchImagesInputMaxUses" min="1" max="50" value="3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex justify-end space-x-2">
                    <button type="button" onclick="closeBatchImagesModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold transition">Annuler</button>
                    <button type="submit" id="btnSubmitBatchImages" class="px-5 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold shadow-md shadow-teal-600/20 transition active:scale-95 flex items-center space-x-1.5">
                        <span>⚡</span><span id="labelSubmitBatchImages">Importer les Images</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL : GÉNÉRATEUR DE BANNIÈRES TEXTE ÉLÉGANTES -->
    <!-- ======================================================== -->
    <div id="bannerModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden transition-theme">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-900/50">
                <div class="flex items-center space-x-2.5">
                    <span class="text-xl">🎨</span>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900 dark:text-white">Studio de Bannières Texte Graphiques</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Générez une carte visuelle avec typographie soignée et badge catégorie.</p>
                    </div>
                </div>
                <button onclick="closeBannerModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white p-1 rounded-lg">✕</button>
            </div>

            <div class="p-6 space-y-4 text-xs">
                <!-- Preview Canvas Box -->
                <div class="w-full aspect-[16/9] rounded-2xl overflow-hidden border border-slate-300 dark:border-slate-700 bg-slate-950 shadow-inner flex items-center justify-center relative" id="bannerLivePreviewWrapper">
                    <img id="bannerLivePreviewImg" src="" class="w-full h-full object-contain">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Titre Principal du Visuel</label>
                        <input type="text" id="bannerInputTitle" value="Les Secrets Millénaires de l'Île de Djerba" oninput="updateBannerPreview()" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Catégorie / Badge</label>
                        <input type="text" id="bannerInputCategory" value="Patrimoine & Histoire" oninput="updateBannerPreview()" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Thème Couleur</label>
                        <select id="bannerInputTheme" onchange="updateBannerPreview()" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            <option value="emerald">🌴 Émeraude & Sarcelle</option>
                            <option value="ocean">🌊 Océan & Lagune</option>
                            <option value="sunset">🌅 Coucher de Soleil</option>
                            <option value="midnight">🌌 Nuit Étoilée</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Quota d'Utilisations</label>
                        <input type="number" id="bannerInputMaxUses" min="1" max="20" value="2" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 dark:text-slate-300">Bot Cible</label>
                        <select id="bannerInputBotId" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none">
                            <option value="all">🌐 Tous les Bots</option>
                        </select>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex justify-end space-x-2">
                    <button type="button" onclick="closeBannerModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold transition">Fermer</button>
                    <button type="button" onclick="saveBannerToQueuePool()" class="px-5 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-slate-950 font-bold shadow-md shadow-amber-500/20 transition active:scale-95">
                        ✨ Ajouter au Pool d'Images
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL : TEST INTERACTIF D'UN AGENT IA (TEXTE / IMAGE / VIDÉO) -->
    <!-- ======================================================== -->
    <div id="agentTestModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-2xl max-h-[90vh] flex flex-col shadow-2xl overflow-hidden transition-theme">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-900/50">
                <div class="flex items-center space-x-3">
                    <span id="agentTestModalIcon" class="text-2xl">🤖</span>
                    <div>
                        <h3 id="agentTestModalTitle" class="font-bold text-base text-slate-900 dark:text-white">Tester l'Agent IA</h3>
                        <p id="agentTestModalSubtitle" class="text-xs text-slate-500 dark:text-slate-400">Benchmark de latence, vérification du statut HTTP et rendu du modèle.</p>
                    </div>
                </div>
                <button onclick="closeAgentTestModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white p-1 rounded-lg">✕</button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto space-y-4 text-xs custom-scrollbar">
                <input type="hidden" id="testAgentId" value="">
                <input type="hidden" id="testAgentType" value="text">

                <!-- System Prompt / Custom Instructions -->
                <div id="boxTestInstructionsContainer" class="space-y-1.5">
                    <label class="font-semibold text-slate-700 dark:text-slate-300 flex items-center space-x-1">
                        <span>📋</span><span>Instructions & Consignes Personnalisées (System Prompt)</span>
                    </label>
                    <textarea id="testAgentInstructions" rows="2" placeholder="ex: Tu es un expert enthousiaste du patrimoine et tourisme à Djerba. Sois chaleureux, poétique, élégant et précis." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none text-xs"></textarea>
                </div>

                <!-- Custom API Key Field -->
                <div id="boxTestApiKeyContainer" class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="font-semibold text-slate-700 dark:text-slate-300 flex items-center space-x-1">
                            <span>🔑</span><span>Clé API Personnalisée pour ce Test</span>
                        </label>
                        <span class="text-[10px] text-slate-400">Optionnel (écrase .env serveur)</span>
                    </div>
                    <input type="password" id="testAgentApiKey" placeholder="Laisser vide pour utiliser la clé serveur par défaut (.env) ou saisissez votre clé..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-xs focus:ring-1 focus:ring-teal-500 focus:outline-none">
                </div>

                <!-- Prompt Configuration Box (for Text & Image) -->
                <div id="boxTestPromptContainer" class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="font-semibold text-slate-700 dark:text-slate-300 flex items-center space-x-1">
                            <span>💬</span><span>Prompt / Sujet de Test Envoyé au Modèle</span>
                        </label>
                        <span class="text-[10px] text-slate-400 font-mono" id="labelTestAgentModel">gemini-2.5-flash</span>
                    </div>
                    <textarea id="testAgentPrompt" rows="2" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white focus:ring-1 focus:ring-teal-500 focus:outline-none text-xs"></textarea>
                </div>

                <!-- Launch Button & Live Timer -->
                <div class="flex items-center justify-between pt-1">
                    <button type="button" onclick="runAgentModalTest()" id="btnExecuteAgentTest" class="px-4 py-2.5 rounded-xl bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs shadow-md shadow-teal-500/20 transition active:scale-95 flex items-center space-x-1.5">
                        <span>⚡</span><span id="btnExecuteAgentTestText">Lancer le Test & Mesurer la Latence</span>
                    </button>
                    <div class="flex items-center space-x-2">
                        <span id="agentTestTimer" class="font-mono text-teal-600 dark:text-teal-400 font-bold text-sm"></span>
                    </div>
                </div>

                <!-- Live Test Result Output Container -->
                <div id="agentTestResultBox" class="hidden space-y-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <!-- Dynamic rendering by JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- Application Javascript Logic -->
    <script>
        let botsList = [];
        let historyData = [];
        let aiAgentsCatalog = null;
        let viewMode = 'cards';
        let logInterval = null;
        let timerInterval = null;
        let botToDeleteId = null;
        let currentQueueCategoryFilter = 'all';

        function getCategoryBadge(catId) {
            const cats = {
                'all': '🌐 Toutes',
                'patrimoine': '🏛️ Patrimoine',
                'plages': '🏄‍♂️ Plages',
                'excursions': '🐪 Excursions',
                'gastronomie': '🍽️ Gastronomie',
                'hebergements': '🏡 Hébergements',
                'vie_pratique': '🧭 Vie Pratique',
                'general': '🌴 Général'
            };
            return cats[catId] || ('🌴 ' + (catId || 'Général'));
        }

        function setQueueCategoryFilter(cat) {
            currentQueueCategoryFilter = cat;
            document.querySelectorAll('.queue-cat-btn').forEach(btn => {
                const btnCat = btn.getAttribute('data-cat');
                if (btnCat === cat) {
                    btn.className = 'queue-cat-btn px-3 py-1.5 rounded-xl font-bold bg-teal-500 text-slate-950 text-xs transition shadow-sm';
                } else {
                    btn.className = 'queue-cat-btn px-3 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs transition';
                }
            });
            renderQueue();
        }

        function toggleAllBotCategories(masterCb) {
            const otherCheckboxes = document.querySelectorAll('input[name="botCategories"]:not(#catCheck_all)');
            if (masterCb.checked) {
                otherCheckboxes.forEach(cb => { cb.checked = false; });
            }
        }

        function toggleSingleBotCategory() {
            const allCb = document.getElementById('catCheck_all');
            const checkedOthers = document.querySelectorAll('input[name="botCategories"]:not(#catCheck_all):checked');
            if (checkedOthers.length > 0) {
                if (allCb) allCb.checked = false;
            } else {
                if (allCb) allCb.checked = true;
            }
        }

        function initTheme() {
            const savedTheme = localStorage.getItem('djerba_theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            applyTheme(savedTheme);
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            applyTheme(newTheme);
            localStorage.setItem('djerba_theme', newTheme);
        }

        function applyTheme(theme) {
            const icon = document.getElementById('themeIcon');
            const label = document.getElementById('themeLabel');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                if (icon) icon.textContent = '🌙';
                if (label) label.textContent = 'Sombre';
            } else {
                document.documentElement.classList.remove('dark');
                if (icon) icon.textContent = '☀️';
                if (label) label.textContent = 'Clair';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            initTheme();
            initApp();
            setInterval(fetchStatusOnly, 10000);
            logInterval = setInterval(() => {
                if (document.getElementById('checkAutoRefreshLogs')?.checked && !document.getElementById('tab-logs').classList.contains('hidden')) {
                    fetchLogs(true);
                }
            }, 5000);
        });

        async function initApp() {
            await Promise.all([
                fetchStatus(),
                fetchBots(),
                fetchQueue(),
                fetchHistory(),
                fetchAiAgents(),
                fetchLogs()
            ]);
        }

        async function refreshAll() {
            await Promise.all([
                fetchStatus(),
                fetchBots(),
                fetchQueue(),
                fetchHistory(),
                fetchLogs()
            ]);
        }

        async function fetchStatusOnly() {
            try {
                const res = await fetch('api.php?action=status');
                const data = await res.json();
                if (data.success) renderStatus(data);
            } catch (e) {
                console.error('Error fetching status', e);
            }
        }

        async function fetchStatus() {
            try {
                const res = await fetch('api.php?action=status');
                const data = await res.json();
                if (data.success) renderStatus(data);
            } catch (e) {
                console.error('Error fetching status', e);
            }
        }

        function renderStatus(data) {
            const o = data.overview;
            const s = data.system;

            document.getElementById('kpiTotalBots').textContent = o.total_bots;
            document.getElementById('kpiActiveBots').textContent = `${o.active_bots} actifs`;
            document.getElementById('kpiTotalRuns').textContent = o.total_runs;
            document.getElementById('kpiSuccessRate').textContent = `${o.success_rate}%`;
            document.getElementById('kpiLoadAvg').textContent = s.load_average;
            document.getElementById('kpiRamBar').style.width = `${s.memory.percent}%`;
            document.getElementById('kpiRamText').textContent = `${s.memory.used_mb} / ${s.memory.total_mb} MB`;
            document.getElementById('kpiRamPercent').textContent = `${s.memory.percent}%`;

            document.getElementById('sysHostname').textContent = s.hostname;
            document.getElementById('sysPhpVersion').textContent = s.php_version;
            document.getElementById('sysServerTime').textContent = s.server_time;
            document.getElementById('sysUptime').textContent = s.uptime;
            document.getElementById('sysCronService').textContent = o.cron_service;
            document.getElementById('sysDisk').textContent = `${s.disk.used_gb} / ${s.disk.total_gb} GB (${s.disk.percent}%)`;
        }

        async function fetchBots() {
            try {
                const res = await fetch('api.php?action=bots_list');
                const data = await res.json();
                if (!data.success) return;

                botsList = data.bots || [];
                document.getElementById('badgeTabBotCount').textContent = botsList.length;
                renderBotsGrid();
                populateBotSelectors();
            } catch (e) {
                console.error('Error fetching bots', e);
            }
        }

        function renderBotsGrid() {
            const container = document.getElementById('botsGridContainer');
            if (botsList.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full py-16 text-center border-2 border-dashed border-slate-300 dark:border-slate-800 rounded-3xl space-y-3">
                        <div class="text-4xl">🤖</div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base">Aucun Bot Configuré</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Créez votre premier bot pour démarrer l'automatisation multi-sites.</p>
                        <button onclick="openBotModal()" class="px-4 py-2 rounded-xl bg-teal-500 text-slate-950 font-bold text-xs">Créer un Bot</button>
                    </div>
                `;
                return;
            }

            container.innerHTML = botsList.map(bot => {
                const isActive = bot.status === 'active';
                const isRunning = bot.is_running;

                let statusBadge = '';
                if (isRunning) {
                    statusBadge = `<span class="px-2.5 py-0.5 rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-500/30 text-[10px] font-bold animate-pulse">⚡ En cours de génération</span>`;
                } else if (isActive) {
                    statusBadge = `<span class="px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-500/30 text-[10px] font-bold">🟢 Actif (${bot.schedule_label})</span>`;
                } else {
                    statusBadge = `<span class="px-2.5 py-0.5 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-300 dark:border-slate-700 text-[10px] font-bold">⏸️ En Pause</span>`;
                }

                const targetSite = bot.target_destination?.site_name || 'Djerba Voyage';
                const targetSiteUrl = bot.target_destination?.site_url || 'https://djerbavoyage.tn';
                const fbPage = bot.social_destinations?.facebook_page_name || 'Page Principale';

                return `
                    <div class="bg-white dark:bg-slate-900/80 border ${isActive ? 'border-slate-200 dark:border-slate-800 hover:border-teal-400/60 dark:hover:border-slate-700' : 'border-slate-200/60 dark:border-slate-800/50 opacity-80'} rounded-3xl p-5 flex flex-col justify-between space-y-4 shadow-sm dark:shadow-xl hover:shadow-md transition duration-200 group">
                        
                        <!-- Header Card -->
                        <div class="space-y-3">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-2xl shadow-inner flex-shrink-0">
                                        ${bot.icon || '🤖'}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-sm text-slate-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition leading-snug">${escapeHtml(bot.name)}</h3>
                                        <div class="text-[10px] text-teal-700 dark:text-teal-400 font-semibold">${escapeHtml(bot.theme || 'Général')}</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-1">
                                    <button onclick="toggleBot('${bot.id}')" title="${isActive ? 'Mettre en pause' : 'Activer'}" class="p-1.5 rounded-lg ${isActive ? 'bg-emerald-50 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-100 dark:hover:bg-emerald-500/30' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 hover:bg-slate-200'} border border-slate-200 dark:border-slate-700 transition">
                                        ${isActive ? '⏸️' : '▶️'}
                                    </button>
                                    <button onclick="openBotModal('${bot.id}')" title="Configurer" class="p-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 transition">
                                        ⚙️
                                    </button>
                                    <button onclick="openDeleteModal('${bot.id}', '${escapeHtml(bot.name)}')" title="Supprimer ce bot" class="p-1.5 rounded-lg bg-rose-50 dark:bg-rose-500/20 hover:bg-rose-100 dark:hover:bg-rose-500/30 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-500/30 transition">
                                        🗑️
                                    </button>
                                </div>
                            </div>

                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">${escapeHtml(bot.description || 'Bot d\'automatisation.')}</p>
                            
                            <!-- Destination Badges -->
                            <div class="flex flex-wrap gap-1.5">
                                <span class="px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 text-[10px] font-medium flex items-center space-x-1">
                                    <span>🌐</span><span class="truncate max-w-[120px]">${escapeHtml(targetSite)}</span>
                                </span>
                                ${fbPage ? `<span class="px-2 py-0.5 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-500/20 text-[10px] font-medium flex items-center space-x-1">
                                    <span>📘</span><span class="truncate max-w-[120px]">${escapeHtml(fbPage)}</span>
                                </span>` : ''}
                            </div>

                            <!-- Authorized Categories Badges -->
                            <div class="flex flex-wrap gap-1 pt-0.5">
                                ${(bot.categories && bot.categories.length > 0 && !bot.categories.includes('all')) 
                                    ? bot.categories.map(c => `<span class="px-2 py-0.5 rounded-full bg-teal-50 dark:bg-teal-500/10 text-teal-700 dark:text-teal-300 border border-teal-200 dark:border-teal-500/20 text-[10px] font-semibold">${getCategoryBadge(c)}</span>`).join('')
                                    : '<span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 text-[10px] font-semibold">🌐 Toutes Catégories</span>'
                                }
                            </div>

                            <div>${statusBadge}</div>
                        </div>

                        <!-- AI Stack Specs Box -->
                        <div class="bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-3 space-y-2 text-[11px] transition-theme">
                            <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                                <span class="flex items-center space-x-1"><span>🤖</span><span>Texte :</span></span>
                                <span class="text-teal-700 dark:text-teal-300 font-bold font-mono">${bot.ai_agents?.text || 'gemini-2.5-flash'}</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                                <span class="flex items-center space-x-1"><span>🎨</span><span>Image :</span></span>
                                <span class="text-emerald-700 dark:text-emerald-300 font-bold font-mono">${bot.ai_agents?.image || 'nano-banana'}</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                                <span class="flex items-center space-x-1"><span>🎬</span><span>Vidéo :</span></span>
                                <span class="text-pink-700 dark:text-pink-300 font-bold font-mono">${bot.ai_agents?.video === 'none' ? 'Désactivé' : 'Reel 9:16'}</span>
                            </div>
                        </div>

                        <!-- Stats & Last Run -->
                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400">
                            <div>
                                <span>Générations : <strong class="text-slate-800 dark:text-white font-bold">${bot.total_runs || 0}</strong></span>
                            </div>
                            <div class="text-right">
                                <span class="text-slate-400 dark:text-slate-500">${bot.last_run ? bot.last_run.substring(11, 16) : 'Jamais lancé'}</span>
                            </div>
                        </div>

                        <!-- Card Buttons -->
                        <div class="grid grid-cols-2 gap-2 pt-1">
                            <button onclick="triggerSpecificBot('${bot.id}', '${escapeHtml(bot.name)}')" class="py-2 px-3 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-slate-950 font-bold text-xs flex items-center justify-center space-x-1.5 shadow-md shadow-teal-500/20 transition active:scale-95">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                                <span>Lancer</span>
                            </button>
                            <button onclick="duplicateBotAction('${bot.id}')" class="py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold text-xs border border-slate-300 dark:border-slate-700 transition">
                                Dupliquer
                            </button>
                        </div>

                    </div>
                `;
            }).join('');
        }

        function populateBotSelectors() {
            const filterSelect = document.getElementById('filterHistoryBot');
            const logSelect = document.getElementById('selectLogBot');
            const topicBotSelect = document.getElementById('topicInputBotId');
            const batchTopicBotSelect = document.getElementById('batchTopicsInputBotId');
            const imageBotSelect = document.getElementById('imageInputBotId');
            const batchImageBotSelect = document.getElementById('batchImagesInputBotId');
            const bannerBotSelect = document.getElementById('bannerInputBotId');
            const filterTopicBotSelect = document.getElementById('filterTopicBot');

            const currentFilter = filterSelect ? filterSelect.value : '';
            const currentLog = logSelect ? logSelect.value : '';

            let filterOptions = '<option value="">🌐 Tous les Bots</option>';
            let logOptions = '<option value="">🌐 Journal Global (/var/log/djerba_bot.log)</option>';
            let modalOptions = '<option value="all">🌐 Tous les Bots (Partagé)</option>';
            let filterTopicOptions = '<option value="all">Tous les Bots</option>';

            botsList.forEach(b => {
                filterOptions += `<option value="${b.id}">${b.icon || '🤖'} ${escapeHtml(b.name)}</option>`;
                logOptions += `<option value="${b.id}">${b.icon || '🤖'} Log: ${escapeHtml(b.name)}</option>`;
                modalOptions += `<option value="${b.id}">${b.icon || '🤖'} ${escapeHtml(b.name)}</option>`;
                filterTopicOptions += `<option value="${b.id}">${b.icon || '🤖'} ${escapeHtml(b.name)}</option>`;
            });

            if (filterSelect) filterSelect.innerHTML = filterOptions;
            if (logSelect) logSelect.innerHTML = logOptions;
            if (topicBotSelect) topicBotSelect.innerHTML = modalOptions;
            if (batchTopicBotSelect) batchTopicBotSelect.innerHTML = modalOptions;
            if (imageBotSelect) imageBotSelect.innerHTML = modalOptions;
            if (batchImageBotSelect) batchImageBotSelect.innerHTML = modalOptions;
            if (bannerBotSelect) bannerBotSelect.innerHTML = modalOptions;
            if (filterTopicBotSelect) filterTopicBotSelect.innerHTML = filterTopicOptions;

            if (filterSelect) filterSelect.value = currentFilter;
            if (logSelect) logSelect.value = currentLog;
        }

        async function fetchHistory() {
            try {
                const botId = document.getElementById('filterHistoryBot')?.value || '';
                const res = await fetch(`api.php?action=history&limit=60${botId ? '&bot_id=' + encodeURIComponent(botId) : ''}`);
                const data = await res.json();
                if (!data.success) return;

                historyData = data.runs || [];
                document.getElementById('badgeTabHistoryCount').textContent = data.total || historyData.length;
                renderHistory();
            } catch (e) {
                console.error('Error fetching history', e);
            }
        }

        function renderHistory() {
            const search = document.getElementById('inputHistorySearch').value.toLowerCase();
            const statusFilter = document.getElementById('filterHistoryStatus').value;

            const filtered = historyData.filter(item => {
                const title = (item.title || '').toLowerCase();
                const slug = (item.slug || '').toLowerCase();
                const matchesSearch = title.includes(search) || slug.includes(search);
                const matchesStatus = statusFilter === 'all' || item.status === statusFilter;
                return matchesSearch && matchesStatus;
            });

            // Cards View
            const cardsContainer = document.getElementById('historyCardsContainer');
            if (filtered.length === 0) {
                cardsContainer.innerHTML = '<div class="col-span-full py-16 text-center text-slate-400 text-xs">Aucun article correspondant trouvé.</div>';
            } else {
                cardsContainer.innerHTML = filtered.map(item => {
                    const imgUrl = item.image 
                        ? (item.image.startsWith('http') ? item.image : `https://djerbavoyage.tn/assets/${item.image.replace(/^\/?assets\/?/, '')}`)
                        : 'https://djerbavoyage.tn/assets/images/service_kitesurf.jpg';

                    const fbBadge = item.facebook?.published 
                        ? `<span class="px-2 py-0.5 rounded bg-blue-100 dark:bg-blue-500/20 text-blue-800 dark:text-blue-300 border border-blue-300 dark:border-blue-500/30 text-[10px] font-bold">✓ Facebook Photo</span>`
                        : `<span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-500 text-[10px]">Facebook Off</span>`;

                    const reelBadge = item.reel?.published 
                        ? `<span class="px-2 py-0.5 rounded bg-pink-100 dark:bg-pink-500/20 text-pink-800 dark:text-pink-300 border border-pink-300 dark:border-pink-500/30 text-[10px] font-bold">🎬 Reel Publié</span>`
                        : `<span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-500 text-[10px]">Reel Off</span>`;

                    const storyBadge = item.story?.published 
                        ? `<span class="px-2 py-0.5 rounded bg-purple-100 dark:bg-purple-500/20 text-purple-800 dark:text-purple-300 border border-purple-300 dark:border-purple-500/30 text-[10px] font-bold">📱 Story Publiée</span>`
                        : `<span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-500 text-[10px]">Story Off</span>`;

                    return `
                        <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 hover:border-teal-400/60 dark:hover:border-slate-700 rounded-2xl overflow-hidden flex flex-col justify-between transition group shadow-sm dark:shadow-lg">
                            <div class="relative aspect-video bg-slate-950 overflow-hidden">
                                <img src="${imgUrl}" alt="${escapeHtml(item.title)}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-transparent"></div>
                                <span class="absolute top-2 left-2 text-[10px] bg-slate-950/80 backdrop-blur px-2.5 py-0.5 rounded text-teal-300 border border-teal-500/30 font-bold">
                                    ${escapeHtml(item.bot_name || 'Bot Guide')}
                                </span>
                                <span class="absolute bottom-2 left-2 text-[10px] bg-slate-950/80 backdrop-blur px-2 py-0.5 rounded text-slate-300 font-mono">
                                    ${item.published_at || 'Récent'}
                                </span>
                            </div>
                            <div class="p-4 space-y-3 flex-1 flex flex-col justify-between">
                                <h4 class="font-bold text-sm text-slate-900 dark:text-slate-100 line-clamp-2 leading-snug group-hover:text-teal-600 dark:group-hover:text-teal-400 transition">
                                    ${escapeHtml(item.title)}
                                </h4>
                                <div class="flex flex-wrap gap-1.5 pt-1">
                                    ${fbBadge}
                                    ${reelBadge}
                                    ${storyBadge}
                                </div>
                                <div class="pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-xs">
                                    ${item.slug ? `<a href="https://djerbavoyage.tn/guide/${item.slug}" target="_blank" class="text-teal-600 dark:text-teal-400 hover:underline font-bold flex items-center space-x-1"><span>Voir l'article</span><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></a>` : '<span></span>'}
                                    ${item.pdf_url ? `<a href="https://djerbavoyage.tn${item.pdf_url}" target="_blank" class="text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium">PDF Guide ⤓</a>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            }

            // Table View
            const tableBody = document.getElementById('historyTableBody');
            tableBody.innerHTML = filtered.map(item => {
                const imgUrl = item.image 
                    ? (item.image.startsWith('http') ? item.image : `https://djerbavoyage.tn/assets/${item.image.replace(/^\/?assets\/?/, '')}`)
                    : 'https://djerbavoyage.tn/assets/images/service_kitesurf.jpg';

                return `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                        <td class="px-4 py-3 flex items-center space-x-3">
                            <img src="${imgUrl}" class="w-12 h-8 rounded object-cover border border-slate-300 dark:border-slate-700 flex-shrink-0">
                            <div>
                                <div class="font-bold text-slate-900 dark:text-white line-clamp-1">${escapeHtml(item.title)}</div>
                                <div class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">${item.slug}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-teal-700 dark:text-teal-400 font-bold">${escapeHtml(item.bot_name || 'Bot Guide')}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-slate-500 dark:text-slate-400 font-mono">${item.published_at}</td>
                        <td class="px-4 py-3">${item.facebook?.published ? '<span class="text-blue-600 dark:text-blue-400 font-bold">✓ Photo</span>' : '<span class="text-slate-400">-</span>'}</td>
                        <td class="px-4 py-3">${item.reel?.published ? '<span class="text-pink-600 dark:text-pink-400 font-bold">✓ Reel</span>' : '<span class="text-slate-400">-</span>'}</td>
                        <td class="px-4 py-3">${item.story?.published ? '<span class="text-purple-600 dark:text-purple-400 font-bold">✓ Story</span>' : '<span class="text-slate-400">-</span>'}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="https://djerbavoyage.tn/guide/${item.slug}" target="_blank" class="text-teal-600 dark:text-teal-400 font-bold hover:underline">Voir ↗</a>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        async function fetchAiAgents() {
            try {
                const res = await fetch('api.php?action=ai_agents');
                const data = await res.json();
                if (!data.success) return;
                aiAgentsCatalog = data;
                renderAiAgentsHub();
            } catch (e) {
                console.error('Error fetching AI agents', e);
            }
        }

        function renderAiAgentsHub() {
            if (!aiAgentsCatalog) return;

            document.getElementById('catalogTextAgents').innerHTML = aiAgentsCatalog.text_agents.map(a => `
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-4 space-y-2.5 shadow-sm dark:shadow-none transition-theme flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="flex items-start justify-between">
                            <h4 class="font-bold text-sm text-slate-900 dark:text-white">${escapeHtml(a.name)}</h4>
                            <span class="px-2 py-0.5 rounded-full bg-teal-100 dark:bg-teal-500/20 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-500/30 text-[10px] font-bold">${escapeHtml(a.badge)}</span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">${escapeHtml(a.description)}</p>
                    </div>
                    <div class="pt-2.5 border-t border-slate-100 dark:border-slate-800 space-y-2">
                        <div class="text-[11px] text-slate-500 flex justify-between font-mono">
                            <span>Fournisseur: ${escapeHtml(a.provider)}</span>
                            <span class="text-teal-600 dark:text-teal-400 font-bold">${escapeHtml(a.speed)}</span>
                        </div>
                        <button type="button" onclick="openAgentTestModal('text', '${a.id}', '${escapeHtml(a.name)}')" class="w-full py-1.5 px-3 rounded-xl bg-teal-50 hover:bg-teal-100 dark:bg-teal-500/10 dark:hover:bg-teal-500/20 text-teal-700 dark:text-teal-300 font-bold text-xs border border-teal-200 dark:border-teal-500/30 flex items-center justify-center space-x-1.5 transition active:scale-95">
                            <span>⚡</span><span>Tester ce modèle LLM</span>
                        </button>
                    </div>
                </div>
            `).join('');

            document.getElementById('catalogImageAgents').innerHTML = aiAgentsCatalog.image_agents.map(a => `
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-4 space-y-2.5 shadow-sm dark:shadow-none transition-theme flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="flex items-start justify-between">
                            <h4 class="font-bold text-sm text-slate-900 dark:text-white">${escapeHtml(a.name)}</h4>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30 text-[10px] font-bold">${escapeHtml(a.badge)}</span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">${escapeHtml(a.description)}</p>
                        <div class="p-2.5 bg-slate-50 dark:bg-slate-950/60 rounded-xl text-[11px] text-slate-600 dark:text-slate-400 space-y-1">
                            <div><strong class="text-slate-800 dark:text-slate-300">Résolution:</strong> ${escapeHtml(a.resolution)}</div>
                            <div><strong class="text-slate-800 dark:text-slate-300">Spécificités:</strong> ${escapeHtml(a.features)}</div>
                        </div>
                    </div>
                    <div class="pt-2.5 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" onclick="openAgentTestModal('image', '${a.id}', '${escapeHtml(a.name)}')" class="w-full py-1.5 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-500/10 dark:hover:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 font-bold text-xs border border-emerald-200 dark:border-emerald-500/30 flex items-center justify-center space-x-1.5 transition active:scale-95">
                            <span>⚡</span><span>Tester le rendu image</span>
                        </button>
                    </div>
                </div>
            `).join('');

            document.getElementById('catalogVideoAgents').innerHTML = aiAgentsCatalog.video_agents.map(a => `
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-4 space-y-2.5 shadow-sm dark:shadow-none transition-theme flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="flex items-start justify-between">
                            <h4 class="font-bold text-sm text-slate-900 dark:text-white">${escapeHtml(a.name)}</h4>
                            <span class="px-2 py-0.5 rounded-full bg-pink-100 dark:bg-pink-500/20 text-pink-800 dark:text-pink-300 border border-pink-200 dark:border-pink-500/30 text-[10px] font-bold">${escapeHtml(a.badge)}</span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">${escapeHtml(a.description)}</p>
                        <div class="p-2.5 bg-slate-50 dark:bg-slate-950/60 rounded-xl text-[11px] text-slate-600 dark:text-slate-400 space-y-1">
                            <div><strong class="text-slate-800 dark:text-slate-300">Format:</strong> ${escapeHtml(a.format)}</div>
                            <div><strong class="text-slate-800 dark:text-slate-300">Spécificités:</strong> ${escapeHtml(a.features)}</div>
                        </div>
                    </div>
                    <div class="pt-2.5 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" onclick="openAgentTestModal('video', '${a.id}', '${escapeHtml(a.name)}')" class="w-full py-1.5 px-3 rounded-xl bg-pink-50 hover:bg-pink-100 dark:bg-pink-500/10 dark:hover:bg-pink-500/20 text-pink-700 dark:text-pink-300 font-bold text-xs border border-pink-200 dark:border-pink-500/30 flex items-center justify-center space-x-1.5 transition active:scale-95">
                            <span>⚡</span><span>Tester le format Reel</span>
                        </button>
                    </div>
                </div>
            `).join('');
        }

        // =========================================================
        // AI Agents Real-Time Testing & Benchmark Functions
        // =========================================================

        function switchBotModalTab(tabId) {
            document.querySelectorAll('.bot-tab-pane').forEach(el => el.classList.add('hidden'));
            const targetPane = document.getElementById(tabId);
            if (targetPane) targetPane.classList.remove('hidden');

            document.querySelectorAll('.bot-tab-btn').forEach(btn => {
                btn.classList.remove('bg-teal-500', 'text-slate-950', 'font-bold', 'shadow-sm');
                btn.classList.add('font-medium', 'text-slate-600', 'dark:text-slate-400', 'hover:bg-slate-200', 'dark:hover:bg-slate-800');
            });

            const activeBtn = document.getElementById('btn' + tabId.charAt(0).toUpperCase() + tabId.slice(1)) || document.getElementById('btn' + tabId) || document.querySelector(`[onclick*="${tabId}"]`);
            if (activeBtn) {
                activeBtn.classList.remove('font-medium', 'text-slate-600', 'dark:text-slate-400', 'hover:bg-slate-200', 'dark:hover:bg-slate-800');
                activeBtn.classList.add('bg-teal-500', 'text-slate-950', 'font-bold', 'shadow-sm');
            }
        }

        async function testSelectedTextAgent() {
            const agentId = document.getElementById('botInputAgentText').value;
            const resBox = document.getElementById('resultTestText');
            const btn = document.getElementById('btnTestText');
            const geminiKey = document.getElementById('botInputGeminiKey')?.value || '';
            const groqKey = document.getElementById('botInputGroqKey')?.value || '';
            const instructions = document.getElementById('botInputCustomInstructions')?.value || '';

            let apiKey = '';
            if (agentId.startsWith('gemini') || agentId.startsWith('gemma') || agentId.startsWith('learnlm')) {
                apiKey = geminiKey;
            } else if (agentId.startsWith('groq')) {
                apiKey = groqKey;
            }

            resBox.classList.remove('hidden');
            resBox.innerHTML = `
                <div class="flex items-center space-x-2 text-teal-600 dark:text-teal-400 font-semibold text-xs">
                    <div class="w-3.5 h-3.5 border-2 border-teal-500/20 border-t-teal-500 rounded-full animate-spin"></div>
                    <span>Test de <strong>${escapeHtml(agentId)}</strong>...</span>
                </div>
            `;
            btn.disabled = true;

            try {
                let url = `api.php?action=test_agent_text&agent_id=${encodeURIComponent(agentId)}`;
                if (apiKey) url += `&api_key=${encodeURIComponent(apiKey)}`;
                if (instructions) url += `&instructions=${encodeURIComponent(instructions)}`;

                const res = await fetch(url);
                const data = await res.json();
                btn.disabled = false;

                if (data.success) {
                    resBox.innerHTML = `
                        <div class="flex items-center justify-between">
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold flex items-center space-x-1">
                                <span>✅</span><span>${escapeHtml(data.model_name || agentId)}</span>
                            </span>
                            <span class="px-2 py-0.5 rounded-full bg-teal-100 dark:bg-teal-500/20 text-teal-800 dark:text-teal-300 font-mono font-bold text-[10px]">⚡ ${data.latency_ms} ms</span>
                        </div>
                        <p class="text-[11px] text-slate-700 dark:text-slate-300 italic bg-slate-50 dark:bg-slate-950/60 p-2 rounded-xl border border-slate-200/80 dark:border-slate-800/80 leading-relaxed">
                            "${escapeHtml(data.response_text)}"
                        </p>
                        <div class="flex justify-between items-center text-[10px] text-slate-400">
                            <span>Fournisseur: ${escapeHtml(data.provider || 'AI')}</span>
                            ${data.tokens ? `<span>${data.tokens} tokens</span>` : '<span class="text-emerald-500">Prêt</span>'}
                        </div>
                    `;
                } else {
                    resBox.innerHTML = `
                        <div class="flex items-center justify-between text-rose-600 dark:text-rose-400 font-bold">
                            <span>❌ Échec du test</span>
                            <span class="font-mono text-[10px]">${data.latency_ms || 0} ms</span>
                        </div>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-snug">
                            ${escapeHtml(data.error || 'Erreur lors de la communication')}
                        </p>
                    `;
                }
            } catch (err) {
                btn.disabled = false;
                resBox.innerHTML = `<div class="text-rose-600 dark:text-rose-400 font-bold">❌ Erreur réseau: ${escapeHtml(err.message)}</div>`;
            }
        }

        async function testSelectedImageAgent() {
            const agentId = document.getElementById('botInputAgentImage').value;
            const resBox = document.getElementById('resultTestImage');
            const btn = document.getElementById('btnTestImage');
            const geminiKey = document.getElementById('botInputGeminiKey')?.value || '';
            const openAiKey = document.getElementById('botInputOpenAiKey')?.value || '';
            const stabilityKey = document.getElementById('botInputStabilityKey')?.value || '';
            const instructions = document.getElementById('botInputCustomInstructions')?.value || '';

            let apiKey = '';
            if (agentId === 'nano-banana' || agentId.startsWith('gemini')) {
                apiKey = geminiKey;
            } else if (agentId === 'dall-e-3' || agentId === 'dall-e-2') {
                apiKey = openAiKey;
            } else if (agentId === 'stability-sdxl' || agentId === 'stability-sd3') {
                apiKey = stabilityKey;
            }

            resBox.classList.remove('hidden');
            resBox.innerHTML = `
                <div class="flex items-center space-x-2 text-emerald-600 dark:text-emerald-400 font-semibold text-xs">
                    <div class="w-3.5 h-3.5 border-2 border-emerald-500/20 border-t-emerald-500 rounded-full animate-spin"></div>
                    <span>Génération test avec <strong>${escapeHtml(agentId)}</strong>...</span>
                </div>
            `;
            btn.disabled = true;

            try {
                let url = `api.php?action=test_agent_image&agent_id=${encodeURIComponent(agentId)}`;
                if (apiKey) url += `&api_key=${encodeURIComponent(apiKey)}`;
                if (instructions) url += `&instructions=${encodeURIComponent(instructions)}`;

                const res = await fetch(url);
                const data = await res.json();
                btn.disabled = false;

                if (data.success) {
                    resBox.innerHTML = `
                        <div class="flex items-center justify-between">
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold flex items-center space-x-1">
                                <span>✅</span><span>${escapeHtml(data.model_name || agentId)}</span>
                            </span>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 font-mono font-bold text-[10px]">⚡ ${data.latency_ms} ms</span>
                        </div>
                        <div class="w-full aspect-[16/9] rounded-xl overflow-hidden bg-slate-950 border border-slate-200 dark:border-slate-800 relative group">
                            <img src="${data.image_url}" alt="Rendu de test" class="w-full h-full object-cover">
                            <a href="${data.image_url}" target="_blank" class="absolute inset-0 bg-slate-950/50 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white font-bold text-xs transition">
                                Ouvrir en HD ↗
                            </a>
                        </div>
                        <div class="flex justify-between items-center text-[10px] text-slate-400">
                            <span>Moteur: ${escapeHtml(data.provider || 'AI')}</span>
                            <span class="font-mono">${escapeHtml(data.resolution || '16:9')}</span>
                        </div>
                    `;
                } else {
                    resBox.innerHTML = `
                        <div class="p-3 bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 rounded-xl space-y-1">
                            <div class="text-rose-600 dark:text-rose-400 font-bold flex items-center space-x-1">
                                <span>❌</span><span>Échec du test (${escapeHtml(agentId)})</span>
                            </div>
                            <p class="text-[11px] text-slate-600 dark:text-slate-400 leading-snug">${escapeHtml(data.error || 'Erreur lors de la génération')}</p>
                        </div>
                    `;
                }
            } catch (err) {
                btn.disabled = false;
                resBox.innerHTML = `<div class="text-rose-600 dark:text-rose-400 font-bold">❌ Erreur réseau: ${escapeHtml(err.message)}</div>`;
            }
        }

        async function testSelectedVideoAgent() {
            const agentId = document.getElementById('botInputAgentVideo').value;
            const resBox = document.getElementById('resultTestVideo');
            const btn = document.getElementById('btnTestVideo');

            resBox.classList.remove('hidden');
            resBox.innerHTML = `
                <div class="flex items-center space-x-2 text-pink-600 dark:text-pink-400 font-semibold text-xs">
                    <div class="w-3.5 h-3.5 border-2 border-pink-500/20 border-t-pink-500 rounded-full animate-spin"></div>
                    <span>Validation du pipeline vidéo <strong>${escapeHtml(agentId)}</strong>...</span>
                </div>
            `;
            btn.disabled = true;

            try {
                const res = await fetch(`api.php?action=test_agent_video&agent_id=${encodeURIComponent(agentId)}`);
                const data = await res.json();
                btn.disabled = false;

                if (data.success) {
                    if (agentId === 'none') {
                        resBox.innerHTML = `
                            <div class="flex items-center justify-between text-slate-600 dark:text-slate-400 font-bold">
                                <span>⚪ Vidéo désactivée</span>
                                <span class="font-mono text-[10px]">Photo seule</span>
                            </div>
                            <p class="text-[11px] text-slate-500">Les publications Facebook contiendront uniquement la photo HD sans encodage vidéo MP4.</p>
                        `;
                    } else {
                        resBox.innerHTML = `
                            <div class="flex items-center justify-between">
                                <span class="text-pink-600 dark:text-pink-400 font-bold flex items-center space-x-1">
                                    <span>🎬</span><span>${escapeHtml(data.model_name)}</span>
                                </span>
                                <span class="px-2 py-0.5 rounded-full bg-pink-100 dark:bg-pink-500/20 text-pink-800 dark:text-pink-300 font-mono font-bold text-[10px]">⚡ ${data.latency_ms} ms</span>
                            </div>
                            <div class="p-2.5 bg-slate-50 dark:bg-slate-950/60 rounded-xl space-y-1 text-[11px]">
                                <div class="flex justify-between"><span class="text-slate-400">Format:</span><strong class="font-mono text-slate-800 dark:text-slate-200">${data.format}</strong></div>
                                <div class="flex justify-between"><span class="text-slate-400">Durée:</span><span class="font-mono text-teal-600 dark:text-teal-400 font-bold">${data.duration}</span></div>
                                <div class="flex justify-between"><span class="text-slate-400">Fréquence:</span><span class="font-mono text-slate-700 dark:text-slate-300">${data.fps} FPS</span></div>
                            </div>
                            ${data.sample_url ? `
                                <div class="pt-1">
                                    <a href="${data.sample_url}" target="_blank" class="w-full py-1.5 px-2 rounded-lg bg-pink-500 hover:bg-pink-400 text-slate-950 font-bold text-[11px] flex items-center justify-center space-x-1 transition">
                                        <span>▶</span><span>Visionner un Reel Exemple (MP4) ↗</span>
                                    </a>
                                </div>
                            ` : ''}
                        `;
                    }
                } else {
                    resBox.innerHTML = `<div class="text-rose-600 dark:text-rose-400 font-bold">❌ Échec: ${escapeHtml(data.error || 'Erreur vidéo')}</div>`;
                }
            } catch (err) {
                btn.disabled = false;
                resBox.innerHTML = `<div class="text-rose-600 dark:text-rose-400 font-bold">❌ Erreur réseau: ${escapeHtml(err.message)}</div>`;
            }
        }

        function openAgentTestModal(type, agentId, agentName) {
            const modal = document.getElementById('agentTestModal');
            const title = document.getElementById('agentTestModalTitle');
            const icon = document.getElementById('agentTestModalIcon');
            const subtitle = document.getElementById('agentTestModalSubtitle');
            const promptBox = document.getElementById('boxTestPromptContainer');
            const promptInput = document.getElementById('testAgentPrompt');
            const instructionsBox = document.getElementById('boxTestInstructionsContainer');
            const instructionsInput = document.getElementById('testAgentInstructions');
            const apiKeyBox = document.getElementById('boxTestApiKeyContainer');
            const apiKeyInput = document.getElementById('testAgentApiKey');
            const labelModel = document.getElementById('labelTestAgentModel');
            const resultBox = document.getElementById('agentTestResultBox');
            const timer = document.getElementById('agentTestTimer');

            document.getElementById('testAgentId').value = agentId;
            document.getElementById('testAgentType').value = type;
            labelModel.textContent = agentId;
            resultBox.classList.add('hidden');
            resultBox.innerHTML = '';
            timer.textContent = '';
            if (apiKeyInput) apiKeyInput.value = '';

            if (type === 'text') {
                icon.textContent = '🤖';
                title.textContent = `Tester: ${agentName || agentId}`;
                subtitle.textContent = "Testez la génération de texte, la cohérence du style et la vitesse de réponse du LLM.";
                promptBox.classList.remove('hidden');
                if (instructionsBox) instructionsBox.classList.remove('hidden');
                if (apiKeyBox) apiKeyBox.classList.remove('hidden');
                promptInput.value = "Rédige une accroche poétique et dynamique (2 phrases) pour présenter l'île de Djerba aux voyageurs.";
                if (instructionsInput) instructionsInput.value = "Tu es un guide touristique expert et chaleureux. Adopte un ton élégant et poétique.";
            } else if (type === 'image') {
                icon.textContent = '🎨';
                title.textContent = `Tester: ${agentName || agentId}`;
                subtitle.textContent = "Générez un visuel d'essai pour évaluer le photoréalisme, le rendu des couleurs et la netteté.";
                promptBox.classList.remove('hidden');
                if (instructionsBox) instructionsBox.classList.remove('hidden');
                if (apiKeyBox) apiKeyBox.classList.remove('hidden');
                promptInput.value = "Djerba traditional menzel white dome turquoise pool sunset palm trees hyperrealistic 8k cinematic lighting";
                if (instructionsInput) instructionsInput.value = "Cinematic photograph, vibrant Mediterranean lighting, 8k resolution, photorealistic.";
            } else if (type === 'video') {
                icon.textContent = '🎬';
                title.textContent = `Tester: ${agentName || agentId}`;
                subtitle.textContent = "Vérifiez les spécifications d'encodage MP4 9:16, le ratio 1080x1920 et le rendu Ken Burns.";
                promptBox.classList.add('hidden');
                if (instructionsBox) instructionsBox.classList.add('hidden');
                if (apiKeyBox) apiKeyBox.classList.add('hidden');
            }

            modal.classList.remove('hidden');
        }

        function closeAgentTestModal() {
            document.getElementById('agentTestModal').classList.add('hidden');
        }

        async function runAgentModalTest() {
            const type = document.getElementById('testAgentType').value;
            const agentId = document.getElementById('testAgentId').value;
            const prompt = document.getElementById('testAgentPrompt').value;
            const instructions = document.getElementById('testAgentInstructions')?.value || '';
            const apiKey = document.getElementById('testAgentApiKey')?.value || '';
            const resultBox = document.getElementById('agentTestResultBox');
            const btn = document.getElementById('btnExecuteAgentTest');
            const btnText = document.getElementById('btnExecuteAgentTestText');
            const timer = document.getElementById('agentTestTimer');

            resultBox.classList.remove('hidden');
            resultBox.innerHTML = `
                <div class="py-8 flex flex-col items-center justify-center space-y-3">
                    <div class="w-8 h-8 border-4 border-teal-500/20 border-t-teal-500 rounded-full animate-spin"></div>
                    <span class="text-xs text-slate-500 dark:text-slate-400">Interrogation du modèle en direct...</span>
                </div>
            `;
            btn.disabled = true;
            btnText.textContent = "Test en cours...";

            let startTime = Date.now();
            let testInterval = setInterval(() => {
                timer.textContent = `${((Date.now() - startTime) / 1000).toFixed(1)}s`;
            }, 100);

            try {
                let url = '';
                if (type === 'text') {
                    url = `api.php?action=test_agent_text&agent_id=${encodeURIComponent(agentId)}&prompt=${encodeURIComponent(prompt)}`;
                    if (instructions) url += `&instructions=${encodeURIComponent(instructions)}`;
                    if (apiKey) url += `&api_key=${encodeURIComponent(apiKey)}`;
                } else if (type === 'image') {
                    url = `api.php?action=test_agent_image&agent_id=${encodeURIComponent(agentId)}&prompt=${encodeURIComponent(prompt)}`;
                    if (instructions) url += `&instructions=${encodeURIComponent(instructions)}`;
                    if (apiKey) url += `&api_key=${encodeURIComponent(apiKey)}`;
                } else {
                    url = `api.php?action=test_agent_video&agent_id=${encodeURIComponent(agentId)}`;
                }

                const res = await fetch(url);
                const data = await res.json();

                clearInterval(testInterval);
                btn.disabled = false;
                btnText.textContent = "Relancer le Test";

                if (data.success) {
                    if (type === 'text') {
                        resultBox.innerHTML = `
                            <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-emerald-500 font-bold">✅ Modèle Opérationnel</span>
                                        <span class="px-2 py-0.5 rounded-full bg-teal-100 dark:bg-teal-500/20 text-teal-800 dark:text-teal-300 font-mono font-bold text-[10px]">⚡ ${data.latency_ms} ms</span>
                                    </div>
                                    <button onclick="copyToClipboard('${escapeHtml(data.response_text).replace(/'/g, "\\'")}')" class="px-2.5 py-1 rounded-lg bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 text-slate-700 dark:text-slate-300 text-[11px] font-semibold transition">
                                        📋 Copier
                                    </button>
                                </div>

                                <div class="p-3 bg-white dark:bg-slate-900 rounded-xl border border-slate-200/80 dark:border-slate-800 text-slate-800 dark:text-slate-200 text-xs leading-relaxed font-sans">
                                    ${escapeHtml(data.response_text)}
                                </div>

                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-[11px] text-slate-500 dark:text-slate-400">
                                    <div><strong>Fournisseur:</strong> ${escapeHtml(data.provider)}</div>
                                    <div><strong>Modèle:</strong> <span class="font-mono text-teal-600 dark:text-teal-400">${escapeHtml(data.model_name)}</span></div>
                                    <div><strong>Statut HTTP:</strong> <span class="text-emerald-600 dark:text-emerald-400 font-bold font-mono">200 OK</span></div>
                                </div>
                            </div>
                        `;
                    } else if (type === 'image') {
                        resultBox.innerHTML = `
                            <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-emerald-500 font-bold">✅ Rendu Photoréaliste Généré</span>
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 font-mono font-bold text-[10px]">⚡ ${data.latency_ms} ms</span>
                                </div>

                                <div class="w-full aspect-[16/9] rounded-2xl overflow-hidden bg-slate-950 border border-slate-200 dark:border-slate-700 shadow-md relative group">
                                    <img src="${data.image_url}" alt="Rendu de test" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition p-4">
                                        <a href="${data.image_url}" target="_blank" class="px-4 py-2 rounded-xl bg-white text-slate-950 font-bold text-xs shadow-lg">
                                            Ouvrir l'image en taille réelle (1200x675 HD) ↗
                                        </a>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-[11px] text-slate-500 dark:text-slate-400">
                                    <div><strong>Résolution:</strong> ${escapeHtml(data.resolution)}</div>
                                    <div><strong>Seed Aléatoire:</strong> <span class="font-mono">${data.seed}</span></div>
                                    <div><strong>Moteur:</strong> ${escapeHtml(data.provider)}</div>
                                </div>
                            </div>
                        `;
                    } else if (type === 'video') {
                        resultBox.innerHTML = `
                            <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-pink-600 dark:text-pink-400 font-bold flex items-center space-x-1.5">
                                        <span>🎬</span><span>${escapeHtml(data.model_name)}</span>
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full bg-pink-100 dark:bg-pink-500/20 text-pink-800 dark:text-pink-300 font-mono font-bold text-[10px]">⚡ ${data.latency_ms} ms</span>
                                </div>

                                <div class="grid grid-cols-2 gap-2 text-[11px]">
                                    <div class="p-2.5 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                                        <div class="text-slate-400">Format & Ratio</div>
                                        <div class="font-bold text-slate-900 dark:text-white font-mono">${data.format}</div>
                                    </div>
                                    <div class="p-2.5 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                                        <div class="text-slate-400">Durée & Scènes</div>
                                        <div class="font-bold text-teal-600 dark:text-teal-400 font-mono">${data.duration}</div>
                                    </div>
                                    <div class="p-2.5 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                                        <div class="text-slate-400">Fréquence d'Images</div>
                                        <div class="font-bold text-slate-900 dark:text-white font-mono">${data.fps || 60} FPS Ultra-Fluide</div>
                                    </div>
                                    <div class="p-2.5 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                                        <div class="text-slate-400">Audio</div>
                                        <div class="font-bold text-slate-900 dark:text-white">${data.audio || 'Stéréo 44.1kHz'}</div>
                                    </div>
                                </div>

                                <div class="space-y-1 text-[11px]">
                                    <strong class="text-slate-700 dark:text-slate-300">Fonctionnalités Multimédia :</strong>
                                    <ul class="list-disc pl-4 space-y-0.5 text-slate-500 dark:text-slate-400">
                                        ${(data.features || []).map(f => `<li>${escapeHtml(f)}</li>`).join('')}
                                    </ul>
                                </div>

                                ${data.sample_url ? `
                                    <div class="pt-2">
                                        <a href="${data.sample_url}" target="_blank" class="w-full py-2 px-3 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold text-xs shadow-md shadow-pink-500/20 flex items-center justify-center space-x-2 transition active:scale-95">
                                            <span>▶</span><span>Visionner un Reel 9:16 Ken Burns en direct (MP4 HD) ↗</span>
                                        </a>
                                    </div>
                                ` : ''}
                            </div>
                        `;
                    }
                } else {
                    resultBox.innerHTML = `
                        <div class="p-4 bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 rounded-2xl text-rose-700 dark:text-rose-300 space-y-1">
                            <div class="font-bold flex items-center space-x-1">
                                <span>❌</span><span>Échec du test</span>
                            </div>
                            <p class="text-xs">${escapeHtml(data.error || 'Erreur lors du test')}</p>
                        </div>
                    `;
                }
            } catch (err) {
                clearInterval(testInterval);
                btn.disabled = false;
                btnText.textContent = "Relancer le Test";
            }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Texte copié dans le presse-papier !');
            }).catch(() => {});
        }


        async function fetchLogs(silent = false) {
            try {
                const botId = document.getElementById('selectLogBot')?.value || '';
                const lines = document.getElementById('selectLogLines')?.value || 100;
                const res = await fetch(`api.php?action=logs&lines=${lines}${botId ? '&bot_id=' + encodeURIComponent(botId) : ''}`);
                const data = await res.json();
                if (!data.success) return;

                document.getElementById('labelLogFile').textContent = data.target_file || '/var/log/djerba_bot.log';
                document.getElementById('logTotalLines').textContent = `${data.total_lines || 0} lignes`;
                const pre = document.getElementById('logContent');
                pre.textContent = data.content || 'Aucun log disponible.';
            } catch (e) {
                console.error('Error fetching logs', e);
            }
        }

        async function triggerSpecificBot(botId, botName) {
            const modal = document.getElementById('executionModal');
            const spinner = document.getElementById('modalSpinner');
            const successIcon = document.getElementById('modalSuccessIcon');
            const title = document.getElementById('modalTitle');
            const desc = document.getElementById('modalDesc');
            const preview = document.getElementById('modalArticlePreview');
            const btnClose = document.getElementById('btnModalClose');
            const timer = document.getElementById('modalTimer');

            modal.classList.remove('hidden');
            spinner.classList.remove('hidden');
            successIcon.classList.add('hidden');
            preview.classList.add('hidden');
            btnClose.classList.add('hidden');
            title.textContent = `Exécution du ${botName}...`;
            desc.textContent = "Pipeline IA en cours...";

            let startTime = Date.now();
            if (timerInterval) clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                timer.textContent = `${((Date.now() - startTime) / 1000).toFixed(1)}s`;
            }, 100);

            try {
                const res = await fetch('api.php?action=bot_trigger', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: botId })
                });
                const data = await res.json();

                clearInterval(timerInterval);
                spinner.classList.add('hidden');
                successIcon.classList.remove('hidden');
                btnClose.classList.remove('hidden');

                if (data.success) {
                    title.textContent = `✅ Cycle terminé avec succès (${data.duration_seconds}s)`;
                    desc.textContent = "Le contenu a été généré et diffusé sur les canaux configurés.";

                    if (data.last_article) {
                        const art = data.last_article;
                        preview.classList.remove('hidden');
                        preview.innerHTML = `
                            <div class="font-bold text-slate-900 dark:text-white text-sm">${escapeHtml(art.title)}</div>
                            <div class="text-[11px] text-teal-600 dark:text-teal-400 font-mono font-bold">Slug: ${art.slug}</div>
                            <div class="pt-2 flex items-center justify-between border-t border-slate-200 dark:border-slate-800 text-[11px]">
                                <a href="https://djerbavoyage.tn/guide/${art.slug}" target="_blank" class="text-teal-600 dark:text-teal-400 underline font-bold">Ouvrir l'article en direct ↗</a>
                                <span class="text-emerald-600 dark:text-emerald-400 font-bold">Statut: En ligne</span>
                            </div>
                        `;
                    }
                } else {
                    title.textContent = "❌ Échec de l'Exécution";
                    desc.textContent = data.message || "Une erreur est survenue lors de l'appel de l'API.";
                }

                refreshAll();
            } catch (e) {
                clearInterval(timerInterval);
                spinner.classList.add('hidden');
                btnClose.classList.remove('hidden');
                title.textContent = "❌ Erreur de Communication";
                desc.textContent = e.message;
            }
        }

        async function toggleBot(botId) {
            try {
                const res = await fetch('api.php?action=bot_toggle', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: botId })
                });
                const data = await res.json();
                if (data.success) {
                    fetchBots();
                    fetchStatusOnly();
                }
            } catch (e) {
                console.error('Error toggling bot', e);
            }
        }

        async function duplicateBotAction(botId) {
            try {
                const res = await fetch('api.php?action=bot_duplicate', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: botId })
                });
                const data = await res.json();
                if (data.success) {
                    fetchBots();
                }
            } catch (e) {
                console.error('Error duplicating bot', e);
            }
        }

        function openDeleteModal(botId, botName) {
            botToDeleteId = botId;
            document.getElementById('deleteModalBotName').textContent = botName;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            botToDeleteId = null;
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function confirmDeleteFromModal() {
            const botId = document.getElementById('botInputId').value;
            const botName = document.getElementById('botInputName').value;
            closeBotModal();
            openDeleteModal(botId, botName);
        }

        async function executeDeleteBot() {
            if (!botToDeleteId) return;
            const btn = document.getElementById('btnConfirmDelete');
            btn.textContent = 'Suppression...';
            btn.disabled = true;

            try {
                const res = await fetch('api.php?action=bot_delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: botToDeleteId })
                });
                const data = await res.json();
                btn.textContent = 'Oui, Supprimer';
                btn.disabled = false;

                if (data.success) {
                    closeDeleteModal();
                    fetchBots();
                    fetchStatusOnly();
                    fetchHistory();
                } else {
                    alert(data.message || 'Erreur lors de la suppression');
                }
            } catch (e) {
                btn.textContent = 'Oui, Supprimer';
                btn.disabled = false;
                console.error('Error deleting bot', e);
            }
        }

        function openBotModal(botId = null) {
            const modal = document.getElementById('botModal');
            const title = document.getElementById('botModalTitle');
            const iconPreview = document.getElementById('botModalIconPreview');
            const btnDelete = document.getElementById('btnDeleteFromModal');

            switchBotModalTab('botTab-general');

            // Reset all category checkboxes first
            document.querySelectorAll('input[name="botCategories"]').forEach(cb => cb.checked = false);

            if (botId) {
                const bot = botsList.find(b => b.id === botId);
                if (bot) {
                    title.textContent = `Modifier: ${bot.name}`;
                    iconPreview.textContent = bot.icon || '🤖';
                    btnDelete.classList.remove('hidden');
                    document.getElementById('botInputId').value = bot.id;
                    document.getElementById('botInputName').value = bot.name;
                    document.getElementById('botInputIcon').value = bot.icon || '🌴';
                    document.getElementById('botInputTheme').value = bot.theme || 'Général';
                    document.getElementById('botInputDesc').value = bot.description || '';
                    document.getElementById('botInputAgentText').value = bot.ai_agents?.text || 'gemini-2.5-flash';
                    document.getElementById('botInputAgentImage').value = bot.ai_agents?.image || 'nano-banana';
                    document.getElementById('botInputAgentVideo').value = bot.ai_agents?.video || 'reel-5photo-kenburns';
                    document.getElementById('botInputSchedule').value = bot.schedule || '1h';
                    document.getElementById('botInputStatus').value = bot.status || 'active';
                    document.getElementById('botInputChWebsite').checked = bot.channels?.website ?? true;
                    document.getElementById('botInputChPdf').checked = bot.channels?.pdf ?? true;
                    document.getElementById('botInputChFbPhoto').checked = bot.channels?.facebook_photo ?? true;
                    document.getElementById('botInputChFbReel').checked = bot.channels?.facebook_reel ?? true;
                    document.getElementById('botInputChFbStory').checked = bot.channels?.facebook_story ?? true;

                    // Categories setup
                    const botCats = (bot.categories && bot.categories.length > 0) ? bot.categories : ['all'];
                    if (botCats.includes('all')) {
                        const allCb = document.getElementById('catCheck_all');
                        if (allCb) allCb.checked = true;
                    } else {
                        botCats.forEach(c => {
                            const cb = document.getElementById(`catCheck_${c}`);
                            if (cb) cb.checked = true;
                        });
                    }

                    // Destination fields
                    document.getElementById('botInputSiteName').value = bot.target_destination?.site_name || 'Djerba Voyage';
                    document.getElementById('botInputSiteUrl').value = bot.target_destination?.site_url || 'https://djerbavoyage.tn';
                    document.getElementById('botInputApiEndpoint').value = bot.target_destination?.api_endpoint || 'https://djerbavoyage.tn/api/auto-blog/generate';
                    document.getElementById('botInputSecretToken').value = bot.target_destination?.api_secret_token || 'djerba_secret_cron_key_2026';
                    
                    document.getElementById('botInputFbPageName').value = bot.social_destinations?.facebook_page_name || 'Djerba Voyage Officiel';
                    document.getElementById('botInputFbPageId').value = bot.social_destinations?.facebook_page_id || '104192661073862';
                    document.getElementById('botInputFbToken').value = bot.social_destinations?.facebook_access_token || '';

                    // Custom API keys and instructions
                    document.getElementById('botInputGeminiKey').value = bot.custom_api_keys?.gemini_api_key || '';
                    document.getElementById('botInputGroqKey').value = bot.custom_api_keys?.groq_api_key || '';
                    document.getElementById('botInputOpenAiKey').value = bot.custom_api_keys?.openai_api_key || '';
                    document.getElementById('botInputStabilityKey').value = bot.custom_api_keys?.stability_api_key || '';
                    document.getElementById('botInputCustomInstructions').value = bot.custom_instructions || '';
                }
            } else {
                title.textContent = "Créer un Nouveau Bot";
                iconPreview.textContent = '🤖';
                btnDelete.classList.add('hidden');
                document.getElementById('botInputId').value = '';
                document.getElementById('botInputName').value = '';
                document.getElementById('botInputIcon').value = '🌴';
                document.getElementById('botInputTheme').value = 'Culture, Patrimoine & UNESCO';
                document.getElementById('botInputDesc').value = '';
                document.getElementById('botInputAgentText').value = 'gemini-2.5-flash';
                document.getElementById('botInputAgentImage').value = 'nano-banana';
                document.getElementById('botInputAgentVideo').value = 'reel-5photo-kenburns';
                document.getElementById('botInputSchedule').value = '1h';
                document.getElementById('botInputStatus').value = 'active';
                document.getElementById('botInputChWebsite').checked = true;
                document.getElementById('botInputChPdf').checked = true;
                document.getElementById('botInputChFbPhoto').checked = true;
                document.getElementById('botInputChFbReel').checked = true;
                document.getElementById('botInputChFbStory').checked = true;

                // Default all categories checked
                const allCb = document.getElementById('catCheck_all');
                if (allCb) allCb.checked = true;

                document.getElementById('botInputSiteName').value = 'Djerba Voyage';
                document.getElementById('botInputSiteUrl').value = 'https://djerbavoyage.tn';
                document.getElementById('botInputApiEndpoint').value = 'https://djerbavoyage.tn/api/auto-blog/generate';
                document.getElementById('botInputSecretToken').value = 'djerba_secret_cron_key_2026';
                document.getElementById('botInputFbPageName').value = 'Djerba Voyage Officiel';
                document.getElementById('botInputFbPageId').value = '104192661073862';
                document.getElementById('botInputFbToken').value = '';

                document.getElementById('botInputGeminiKey').value = '';
                document.getElementById('botInputGroqKey').value = '';
                document.getElementById('botInputOpenAiKey').value = '';
                document.getElementById('botInputStabilityKey').value = '';
                document.getElementById('botInputCustomInstructions').value = '';
            }

            modal.classList.remove('hidden');
        }

        function closeBotModal() {
            document.getElementById('botModal').classList.add('hidden');
        }

        async function saveBotForm(e) {
            e.preventDefault();
            
            // Gather selected categories
            const selectedCats = Array.from(document.querySelectorAll('input[name="botCategories"]:checked')).map(cb => cb.value);
            const finalCategories = (selectedCats.length === 0 || selectedCats.includes('all')) ? ['all'] : selectedCats;

            const botData = {
                id: document.getElementById('botInputId').value,
                name: document.getElementById('botInputName').value,
                icon: document.getElementById('botInputIcon').value,
                theme: document.getElementById('botInputTheme').value,
                description: document.getElementById('botInputDesc').value,
                status: document.getElementById('botInputStatus').value,
                schedule: document.getElementById('botInputSchedule').value,
                categories: finalCategories,
                target_destination: {
                    site_name: document.getElementById('botInputSiteName').value,
                    site_url: document.getElementById('botInputSiteUrl').value,
                    api_endpoint: document.getElementById('botInputApiEndpoint').value,
                    api_secret_token: document.getElementById('botInputSecretToken').value
                },
                social_destinations: {
                    facebook_page_name: document.getElementById('botInputFbPageName').value,
                    facebook_page_id: document.getElementById('botInputFbPageId').value,
                    facebook_access_token: document.getElementById('botInputFbToken').value
                },
                ai_agents: {
                    text: document.getElementById('botInputAgentText').value,
                    image: document.getElementById('botInputAgentImage').value,
                    video: document.getElementById('botInputAgentVideo').value,
                },
                custom_api_keys: {
                    gemini_api_key: document.getElementById('botInputGeminiKey').value,
                    groq_api_key: document.getElementById('botInputGroqKey').value,
                    openai_api_key: document.getElementById('botInputOpenAiKey').value,
                    stability_api_key: document.getElementById('botInputStabilityKey').value
                },
                custom_instructions: document.getElementById('botInputCustomInstructions').value,
                channels: {
                    website: document.getElementById('botInputChWebsite').checked,
                    pdf: document.getElementById('botInputChPdf').checked,
                    facebook_photo: document.getElementById('botInputChFbPhoto').checked,
                    facebook_reel: document.getElementById('botInputChFbReel').checked,
                    facebook_story: document.getElementById('botInputChFbStory').checked
                }
            };

            try {
                const res = await fetch('api.php?action=bot_save', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(botData)
                });
                const data = await res.json();
                if (data.success) {
                    closeBotModal();
                    fetchBots();
                    fetchStatusOnly();
                } else {
                    alert(data.message || 'Erreur lors de l\'enregistrement');
                }
            } catch (e) {
                console.error('Error saving bot', e);
            }
        }

        async function testBotEndpoint() {
            const url = document.getElementById('botInputSiteUrl').value || 'https://djerbavoyage.tn';
            const res = await fetch(`api.php?action=test_api&target=${encodeURIComponent(url)}`);
            const data = await res.json();
            if (data.success) {
                alert(`✅ Connexion réussie à ${url} (HTTP ${data.http_code} en ${Math.round(data.latency_seconds * 1000)}ms)`);
            } else {
                alert(`❌ Impossible de joindre ${url} (Erreur: ${data.error || 'Code HTTP ' + data.http_code})`);
            }
        }

        async function testCustomUrlLatency() {
            const url = document.getElementById('inputCustomTestUrl').value;
            const box = document.getElementById('boxTestResult');
            box.classList.remove('hidden');
            box.innerHTML = '<span class="text-amber-500 font-bold">Test en cours...</span>';

            const res = await fetch(`api.php?action=test_api&target=${encodeURIComponent(url)}`);
            const data = await res.json();
            if (data.success) {
                box.innerHTML = `
                    <div class="flex justify-between items-center text-emerald-600 dark:text-emerald-400 font-bold">
                        <span>✅ Succès : HTTP ${data.http_code} OK</span>
                        <span>${Math.round(data.latency_seconds * 1000)} ms</span>
                    </div>
                    <div class="text-[11px] text-slate-500">Cible validée : ${escapeHtml(data.target)}</div>
                `;
            } else {
                box.innerHTML = `
                    <div class="text-rose-600 dark:text-rose-400 font-bold">
                        ❌ Échec de connexion (HTTP ${data.http_code || 'N/A'})
                    </div>
                    <div class="text-[11px] text-slate-500">${escapeHtml(data.error || 'Délai d\'attente dépassé')}</div>
                `;
            }
        }

        async function clearLogs() {
            const botId = document.getElementById('selectLogBot')?.value || '';
            if (!confirm('Confirmez-vous la réinitialisation de ce journal de logs ?')) return;
            const res = await fetch('api.php?action=clear_logs', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ bot_id: botId })
            });
            const data = await res.json();
            if (data.success) fetchLogs();
        }

        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = 'tab-btn px-4 py-2.5 font-medium border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 flex items-center space-x-2 transition';
            });

            document.getElementById(tabId)?.classList.remove('hidden');
            const activeBtn = document.getElementById(`tabBtn-${tabId.replace('tab-', '')}`);
            if (activeBtn) {
                activeBtn.className = 'tab-btn px-4 py-2.5 font-bold border-b-2 border-teal-500 text-teal-600 dark:text-teal-400 flex items-center space-x-2 transition';
            }

            if (tabId === 'tab-queue') fetchQueue();
            if (tabId === 'tab-logs') fetchLogs();
            if (tabId === 'tab-history') fetchHistory();
        }

        // =========================================================
        // Content Queue & Image Pool Logic
        // =========================================================
        let queueData = { topics: [], images: [], stats: {} };

        async function fetchQueue() {
            try {
                const res = await fetch('api.php?action=queue_list');
                const data = await res.json();
                if (!data.success) return;
                queueData = data;
                renderQueue();
            } catch (e) {
                console.error('Error fetching queue', e);
            }
        }

        function renderQueue() {
            if (!queueData) return;
            const stats = queueData.stats || {};
            const topics = queueData.topics || [];
            const images = queueData.images || [];

            const activeTopics = stats.active_topics ?? 0;
            const totalTopics = stats.total_topics ?? topics.length;
            const activeImages = stats.active_images ?? 0;
            const totalImages = stats.total_images ?? images.length;

            const badgeTab = document.getElementById('badgeTabQueueCount');
            if (badgeTab) badgeTab.textContent = stats.pending_total ?? (activeTopics + activeImages);

            const elActiveTopics = document.getElementById('kpiQueueActiveTopics');
            if (elActiveTopics) elActiveTopics.textContent = activeTopics;
            const elTotalTopics = document.getElementById('kpiQueueTotalTopics');
            if (elTotalTopics) elTotalTopics.textContent = `/ ${totalTopics} au total`;

            const elActiveImages = document.getElementById('kpiQueueActiveImages');
            if (elActiveImages) elActiveImages.textContent = activeImages;
            const elTotalImages = document.getElementById('kpiQueueTotalImages');
            if (elTotalImages) elTotalImages.textContent = `/ ${totalImages} au total`;

            const elExhaustedTopics = document.getElementById('kpiQueueExhaustedTopics');
            if (elExhaustedTopics) elExhaustedTopics.textContent = stats.exhausted_topics ?? 0;
            const elExhaustedImages = document.getElementById('kpiQueueExhaustedImages');
            if (elExhaustedImages) elExhaustedImages.textContent = stats.exhausted_images ?? 0;

            const elBadgeTopicsActive = document.getElementById('badgeTopicsActiveCount');
            if (elBadgeTopicsActive) elBadgeTopicsActive.textContent = `${activeTopics} actifs`;
            const elBadgeImagesActive = document.getElementById('badgeImagesActiveCount');
            if (elBadgeImagesActive) elBadgeImagesActive.textContent = `${activeImages} actives`;

            // Filter Topics
            const topicSearch = (document.getElementById('searchTopicsInput')?.value || '').toLowerCase();
            const topicBotFilter = document.getElementById('filterTopicBot')?.value || 'all';

            const filteredTopics = topics.filter(t => {
                const matchText = (t.title || '').toLowerCase().includes(topicSearch) || (t.keywords || '').toLowerCase().includes(topicSearch);
                const matchBot = topicBotFilter === 'all' || t.bot_id === topicBotFilter || t.bot_id === 'all';
                const matchCat = currentQueueCategoryFilter === 'all' || (t.category || 'general') === currentQueueCategoryFilter;
                return matchText && matchBot && matchCat;
            });

            const topicsContainer = document.getElementById('queueTopicsList');
            if (topicsContainer) {
                if (filteredTopics.length === 0) {
                    topicsContainer.innerHTML = `
                        <div class="py-12 text-center text-slate-400 text-xs border border-dashed border-slate-200 dark:border-slate-800 rounded-2xl space-y-2">
                            <div class="text-2xl">📭</div>
                            <p>Aucun sujet dans la file d'attente pour ce filtre.</p>
                            <button onclick="openTopicModal()" class="px-3 py-1 rounded-xl bg-teal-500 text-slate-950 font-bold text-[11px]">➕ Ajouter un sujet</button>
                        </div>
                    `;
                } else {
                    topicsContainer.innerHTML = filteredTopics.map(t => {
                        const maxUses = t.max_uses || 1;
                        const uses = t.uses_count || 0;
                        const isExhausted = uses >= maxUses || t.status === 'exhausted';
                        const pct = Math.min(100, Math.round((uses / maxUses) * 100));

                        const targetBot = botsList.find(b => b.id === t.bot_id);
                        const botLabel = t.bot_id === 'all' ? '🌐 Tous les Bots' : (targetBot ? `${targetBot.icon || '🤖'} ${targetBot.name}` : t.bot_id);

                        return `
                            <div class="p-3.5 bg-slate-50 dark:bg-slate-950/60 border ${isExhausted ? 'border-slate-200 dark:border-slate-800/50 opacity-60' : 'border-slate-200/90 dark:border-slate-800 hover:border-teal-400/50'} rounded-2xl space-y-2.5 transition">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="space-y-1 flex-1 min-w-0">
                                        <h4 class="font-bold text-xs text-slate-900 dark:text-white leading-snug">${escapeHtml(t.title)}</h4>
                                        <div class="flex flex-wrap items-center gap-1.5 text-[10px]">
                                            <span class="px-2 py-0.5 rounded bg-teal-50 dark:bg-teal-500/10 text-teal-700 dark:text-teal-300 font-semibold border border-teal-200 dark:border-teal-500/20 truncate max-w-[180px]">${escapeHtml(botLabel)}</span>
                                            <span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold border border-slate-200 dark:border-slate-700 text-[10px]">${getCategoryBadge(t.category || 'general')}</span>
                                            ${t.keywords ? `<span class="text-slate-400 font-mono">🔑 ${escapeHtml(t.keywords)}</span>` : ''}
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-1 flex-shrink-0">
                                        ${isExhausted ? `
                                            <button onclick="resetQueueItem('topic', '${t.id}')" title="Réinitialiser le quota" class="p-1.5 rounded-lg bg-teal-50 dark:bg-teal-500/20 text-teal-700 dark:text-teal-300 hover:bg-teal-100 text-xs transition">🔄</button>
                                        ` : ''}
                                        <button onclick="deleteQueueItem('topic', '${t.id}')" title="Supprimer" class="p-1.5 rounded-lg bg-rose-50 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 hover:bg-rose-100 text-xs transition">🗑️</button>
                                    </div>
                                </div>

                                ${t.guidelines ? `<p class="text-[11px] text-slate-500 dark:text-slate-400 italic bg-white dark:bg-slate-900/60 p-2 rounded-xl border border-slate-200/60 dark:border-slate-800/60">💡 ${escapeHtml(t.guidelines)}</p>` : ''}

                                <div class="space-y-1">
                                    <div class="flex justify-between text-[10px] font-semibold text-slate-500 dark:text-slate-400">
                                        <span>${isExhausted ? '⏹️ Épuisé' : '🟢 Actif'}</span>
                                        <span class="font-mono ${isExhausted ? 'text-amber-500' : 'text-teal-600 dark:text-teal-400'}">${uses} / ${maxUses} utilisations (${pct}%)</span>
                                    </div>
                                    <div class="w-full bg-slate-200 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                        <div class="h-1.5 rounded-full ${isExhausted ? 'bg-amber-500' : 'bg-gradient-to-r from-teal-500 to-emerald-400'}" style="width: ${pct}%"></div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join('');
                }
            }

            // Filter Images
            const imageSearch = (document.getElementById('searchImagesInput')?.value || '').toLowerCase();
            const imageStyleFilter = document.getElementById('filterImageType')?.value || 'all';

            const filteredImages = images.filter(img => {
                const matchText = (img.title || '').toLowerCase().includes(imageSearch) || (img.image_url || '').toLowerCase().includes(imageSearch);
                const matchStyle = imageStyleFilter === 'all' || img.style === imageStyleFilter;
                const matchCat = currentQueueCategoryFilter === 'all' || (img.category || 'general') === currentQueueCategoryFilter;
                return matchText && matchStyle && matchCat;
            });

            const imagesContainer = document.getElementById('queueImagesList');
            if (imagesContainer) {
                if (filteredImages.length === 0) {
                    imagesContainer.innerHTML = `
                        <div class="py-12 text-center text-slate-400 text-xs border border-dashed border-slate-200 dark:border-slate-800 rounded-2xl space-y-2">
                            <div class="text-2xl">🖼️</div>
                            <p>Aucune image dans le pool pour ce filtre.</p>
                            <button onclick="openImageModal()" class="px-3 py-1 rounded-xl bg-emerald-500 text-slate-950 font-bold text-[11px]">➕ Ajouter une image</button>
                        </div>
                    `;
                } else {
                    imagesContainer.innerHTML = filteredImages.map(img => {
                        const maxUses = img.max_uses || 1;
                        const uses = img.uses_count || 0;
                        const isExhausted = uses >= maxUses || img.status === 'exhausted';
                        const pct = Math.min(100, Math.round((uses / maxUses) * 100));

                        let styleBadge = '<span class="px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 font-bold border border-emerald-200 dark:border-emerald-500/20 text-[10px]">📷 Photo</span>';
                        if (img.style === 'text_banner' || img.style === 'text_card') {
                            styleBadge = '<span class="px-2 py-0.5 rounded bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-300 font-bold border border-amber-200 dark:border-amber-500/20 text-[10px]">🎨 Bannière Texte</span>';
                        }

                        return `
                            <div class="p-3 bg-slate-50 dark:bg-slate-950/60 border ${isExhausted ? 'border-slate-200 dark:border-slate-800/50 opacity-60' : 'border-slate-200/90 dark:border-slate-800 hover:border-emerald-400/50'} rounded-2xl space-y-2.5 transition flex gap-3">
                                <div class="w-24 h-20 rounded-xl overflow-hidden bg-slate-950 border border-slate-200 dark:border-slate-700 flex-shrink-0 relative">
                                    <img src="${img.image_url}" alt="${escapeHtml(img.title || '')}" loading="lazy" class="w-full h-full object-cover">
                                </div>

                                <div class="flex-1 min-w-0 space-y-2 flex flex-col justify-between">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="space-y-0.5 min-w-0">
                                            <h4 class="font-bold text-xs text-slate-900 dark:text-white truncate">${escapeHtml(img.title || 'Visuel sans titre')}</h4>
                                            <div class="text-[10px] text-slate-400 font-mono truncate">${escapeHtml(img.image_url)}</div>
                                        </div>
                                        <div class="flex items-center space-x-1 flex-shrink-0">
                                            ${isExhausted ? `
                                                <button onclick="resetQueueItem('image', '${img.id}')" title="Réinitialiser le quota" class="p-1 rounded bg-emerald-50 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 text-xs transition">🔄</button>
                                            ` : ''}
                                            <button onclick="deleteQueueItem('image', '${img.id}')" title="Supprimer" class="p-1 rounded bg-rose-50 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 text-xs transition">🗑️</button>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-1.5">
                                        ${styleBadge}
                                        <span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold border border-slate-200 dark:border-slate-700 text-[10px]">${getCategoryBadge(img.category || 'general')}</span>
                                        <span class="text-[10px] font-mono font-bold ml-auto ${isExhausted ? 'text-amber-500' : 'text-emerald-600 dark:text-emerald-400'}">${uses} / ${maxUses} (${pct}%)</span>
                                    </div>

                                    <div class="w-full bg-slate-200 dark:bg-slate-800 rounded-full h-1 overflow-hidden">
                                        <div class="h-1 rounded-full ${isExhausted ? 'bg-amber-500' : 'bg-gradient-to-r from-emerald-500 to-teal-400'}" style="width: ${pct}%"></div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join('');
                }
            }
        }

        // --- Modals & CRUD Actions ---
        function openTopicModal() {
            document.getElementById('topicInputTitle').value = '';
            document.getElementById('topicInputKeywords').value = '';
            document.getElementById('topicInputGuidelines').value = '';
            document.getElementById('topicInputMaxUses').value = '1';
            if (document.getElementById('topicInputCategory')) document.getElementById('topicInputCategory').value = 'general';
            document.getElementById('topicModal').classList.remove('hidden');
        }

        function closeTopicModal() {
            document.getElementById('topicModal').classList.add('hidden');
        }

        async function saveTopicForm(e) {
            e.preventDefault();
            const payload = {
                title: document.getElementById('topicInputTitle').value,
                bot_id: document.getElementById('topicInputBotId').value,
                category: document.getElementById('topicInputCategory')?.value || 'general',
                max_uses: document.getElementById('topicInputMaxUses').value,
                keywords: document.getElementById('topicInputKeywords').value,
                guidelines: document.getElementById('topicInputGuidelines').value
            };

            try {
                const res = await fetch('api.php?action=queue_add_topic', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                if (data.success) {
                    closeTopicModal();
                    fetchQueue();
                } else {
                    alert(data.message || 'Erreur lors de l\'ajout du sujet');
                }
            } catch (err) {
                console.error('Error adding topic', err);
            }
        }

        function openBatchTopicsModal() {
            document.getElementById('batchTopicsInputText').value = '';
            document.getElementById('batchTopicsInputMaxUses').value = '1';
            if (document.getElementById('batchTopicsInputCategory')) document.getElementById('batchTopicsInputCategory').value = 'general';
            document.getElementById('batchTopicModal').classList.remove('hidden');
        }

        function closeBatchTopicsModal() {
            document.getElementById('batchTopicModal').classList.add('hidden');
        }

        async function saveBatchTopicsForm(e) {
            e.preventDefault();
            const payload = {
                batch_text: document.getElementById('batchTopicsInputText').value,
                bot_id: document.getElementById('batchTopicsInputBotId').value,
                category: document.getElementById('batchTopicsInputCategory')?.value || 'general',
                max_uses: document.getElementById('batchTopicsInputMaxUses').value
            };

            try {
                const res = await fetch('api.php?action=queue_batch_topics', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                if (data.success) {
                    closeBatchTopicsModal();
                    fetchQueue();
                } else {
                    alert(data.message || 'Erreur lors de l\'import des sujets');
                }
            } catch (err) {
                console.error('Error importing batch topics', err);
            }
        }

        // -------------------------------------------------------------
        // Single Image Modal Logic (Upload File vs URL)
        // -------------------------------------------------------------
        let currentImageModalSubTab = 'upload';
        let selectedSingleFile = null;

        function switchImageModalSubTab(tab) {
            currentImageModalSubTab = tab;
            const btnUpload = document.getElementById('btnImageTab-upload');
            const btnUrl = document.getElementById('btnImageTab-url');
            const paneUpload = document.getElementById('imageModalPane-upload');
            const paneUrl = document.getElementById('imageModalPane-url');
            const headerTitle = document.getElementById('imageModalHeaderTitle');
            const submitLabel = document.getElementById('labelSubmitSingleImage');

            if (tab === 'upload') {
                btnUpload.className = 'px-3.5 py-1.5 rounded-xl font-bold bg-teal-500 text-slate-950 flex items-center space-x-1.5 transition shadow-sm';
                btnUrl.className = 'px-3.5 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 flex items-center space-x-1.5 transition';
                paneUpload.classList.remove('hidden');
                paneUrl.classList.add('hidden');
                if (headerTitle) headerTitle.textContent = "Téléverser une Image sur le Serveur";
                if (submitLabel) submitLabel.textContent = "Téléverser & Ajouter au Pool";
            } else {
                btnUrl.className = 'px-3.5 py-1.5 rounded-xl font-bold bg-teal-500 text-slate-950 flex items-center space-x-1.5 transition shadow-sm';
                btnUpload.className = 'px-3.5 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 flex items-center space-x-1.5 transition';
                paneUrl.classList.remove('hidden');
                paneUpload.classList.add('hidden');
                if (headerTitle) headerTitle.textContent = "Ajouter une Image par URL Web";
                if (submitLabel) submitLabel.textContent = "Ajouter au Pool";
            }
        }

        function handleSingleFileSelect(files) {
            if (!files || files.length === 0) return;
            const file = files[0];
            if (!file.type.startsWith('image/')) {
                alert('Veuillez sélectionner un fichier image valide (JPG, PNG, WebP, GIF, SVG)');
                return;
            }

            selectedSingleFile = file;
            const previewBox = document.getElementById('singleFilePreviewBox');
            const previewImg = document.getElementById('singleFilePreviewImg');
            const nameEl = document.getElementById('singleFileName');
            const sizeEl = document.getElementById('singleFileSize');
            const titleInput = document.getElementById('imageInputTitle');

            if (previewBox && previewImg) {
                previewImg.src = URL.createObjectURL(file);
                previewBox.classList.remove('hidden');
            }
            if (nameEl) nameEl.textContent = file.name;
            if (sizeEl) sizeEl.textContent = `${(file.size / 1024).toFixed(1)} KB`;
            
            // Auto-fill title if empty
            if (titleInput && !titleInput.value.trim()) {
                const base = file.name.substring(0, file.name.lastIndexOf('.')) || file.name;
                titleInput.value = base.replace(/[_-]/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            }
        }

        function clearSingleFileSelect() {
            selectedSingleFile = null;
            const fileInput = document.getElementById('singleImageFileInput');
            if (fileInput) fileInput.value = '';
            const previewBox = document.getElementById('singleFilePreviewBox');
            if (previewBox) previewBox.classList.add('hidden');
        }

        function openImageModal(initialTab = 'upload') {
            clearSingleFileSelect();
            document.getElementById('imageInputUrl').value = '';
            document.getElementById('imageInputTitle').value = '';
            document.getElementById('imageInputMaxUses').value = '3';
            if (document.getElementById('imageInputCategory')) document.getElementById('imageInputCategory').value = 'general';
            if (document.getElementById('boxImagePreviewModal')) document.getElementById('boxImagePreviewModal').classList.add('hidden');
            
            switchImageModalSubTab(initialTab);
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            clearSingleFileSelect();
            document.getElementById('imageModal').classList.add('hidden');
        }

        function previewModalImage(url) {
            const box = document.getElementById('boxImagePreviewModal');
            const img = document.getElementById('imgPreviewModal');
            if (url && (url.startsWith('http://') || url.startsWith('https://') || url.startsWith('data:image'))) {
                img.src = url;
                box.classList.remove('hidden');
            } else {
                box.classList.add('hidden');
            }
        }

        async function saveImageForm(e) {
            e.preventDefault();
            const btnSubmit = document.getElementById('btnSubmitSingleImage');
            const labelSubmit = document.getElementById('labelSubmitSingleImage');
            const prevText = labelSubmit ? labelSubmit.textContent : 'Ajouter';

            if (currentImageModalSubTab === 'upload') {
                if (!selectedSingleFile) {
                    alert('Veuillez sélectionner ou glisser-déposer une image depuis votre ordinateur');
                    return;
                }

                const formData = new FormData();
                formData.append('image_file', selectedSingleFile);
                formData.append('title', document.getElementById('imageInputTitle').value);
                formData.append('style', document.getElementById('imageInputStyle').value);
                formData.append('bot_id', document.getElementById('imageInputBotId').value);
                formData.append('category', document.getElementById('imageInputCategory')?.value || 'general');
                formData.append('max_uses', document.getElementById('imageInputMaxUses').value);

                try {
                    btnSubmit.disabled = true;
                    if (labelSubmit) labelSubmit.textContent = 'Téléversement & Synchro...';

                    const res = await fetch('api.php?action=queue_upload_image', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await res.json();
                    btnSubmit.disabled = false;
                    if (labelSubmit) labelSubmit.textContent = prevText;

                    if (data.success) {
                        closeImageModal();
                        fetchQueue();
                    } else {
                        alert(data.message || 'Erreur lors du téléversement de l\'image');
                    }
                } catch (err) {
                    btnSubmit.disabled = false;
                    if (labelSubmit) labelSubmit.textContent = prevText;
                    console.error('Error uploading image', err);
                    alert('Erreur réseau lors du transfert');
                }
            } else {
                const url = document.getElementById('imageInputUrl').value.trim();
                if (!url) {
                    alert('Veuillez saisir une URL d\'image');
                    return;
                }

                const payload = {
                    image_url: url,
                    title: document.getElementById('imageInputTitle').value,
                    style: document.getElementById('imageInputStyle').value,
                    bot_id: document.getElementById('imageInputBotId').value,
                    category: document.getElementById('imageInputCategory')?.value || 'general',
                    max_uses: document.getElementById('imageInputMaxUses').value
                };

                try {
                    btnSubmit.disabled = true;
                    if (labelSubmit) labelSubmit.textContent = 'Enregistrement...';

                    const res = await fetch('api.php?action=queue_add_image', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(payload)
                    });
                    const data = await res.json();
                    btnSubmit.disabled = false;
                    if (labelSubmit) labelSubmit.textContent = prevText;

                    if (data.success) {
                        closeImageModal();
                        fetchQueue();
                    } else {
                        alert(data.message || 'Erreur lors de l\'ajout de l\'image');
                    }
                } catch (err) {
                    btnSubmit.disabled = false;
                    if (labelSubmit) labelSubmit.textContent = prevText;
                    console.error('Error adding image by url', err);
                }
            }
        }

        // -------------------------------------------------------------
        // Batch Images Modal Logic (Multi-Files Upload vs URL List)
        // -------------------------------------------------------------
        let currentBatchModalSubTab = 'batch_files';
        let selectedBatchFiles = [];

        function switchBatchModalSubTab(tab) {
            currentBatchModalSubTab = tab;
            const btnFiles = document.getElementById('btnBatchTab-files');
            const btnUrls = document.getElementById('btnBatchTab-urls');
            const paneFiles = document.getElementById('batchModalPane-files');
            const paneUrls = document.getElementById('batchModalPane-urls');
            const labelSubmit = document.getElementById('labelSubmitBatchImages');

            if (tab === 'batch_files') {
                btnFiles.className = 'px-3.5 py-1.5 rounded-xl font-bold bg-teal-500 text-slate-950 flex items-center space-x-1.5 transition shadow-sm';
                btnUrls.className = 'px-3.5 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 flex items-center space-x-1.5 transition';
                paneFiles.classList.remove('hidden');
                paneUrls.classList.add('hidden');
                if (labelSubmit) labelSubmit.textContent = selectedBatchFiles.length > 0 ? `Téléverser ${selectedBatchFiles.length} image(s)` : "Téléverser les Fichiers";
            } else {
                btnUrls.className = 'px-3.5 py-1.5 rounded-xl font-bold bg-teal-500 text-slate-950 flex items-center space-x-1.5 transition shadow-sm';
                btnFiles.className = 'px-3.5 py-1.5 rounded-xl font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 flex items-center space-x-1.5 transition';
                paneUrls.classList.remove('hidden');
                paneFiles.classList.add('hidden');
                if (labelSubmit) labelSubmit.textContent = "Importer les URLs";
            }
        }

        function handleBatchFilesSelect(files) {
            if (!files || files.length === 0) return;
            for (let i = 0; i < files.length; i++) {
                const f = files[i];
                if (f.type.startsWith('image/')) {
                    selectedBatchFiles.push(f);
                }
            }
            renderBatchFilesGrid();
        }

        function removeBatchFile(index) {
            selectedBatchFiles.splice(index, 1);
            renderBatchFilesGrid();
        }

        function clearBatchFilesSelect() {
            selectedBatchFiles = [];
            const input = document.getElementById('batchFilesInput');
            if (input) input.value = '';
            renderBatchFilesGrid();
        }

        function renderBatchFilesGrid() {
            const wrapper = document.getElementById('batchFilesPreviewWrapper');
            const grid = document.getElementById('batchFilesPreviewGrid');
            const summary = document.getElementById('batchFilesSummaryText');
            const labelSubmit = document.getElementById('labelSubmitBatchImages');

            if (!wrapper || !grid) return;

            if (selectedBatchFiles.length === 0) {
                wrapper.classList.add('hidden');
                if (labelSubmit && currentBatchModalSubTab === 'batch_files') labelSubmit.textContent = "Téléverser les Fichiers";
                return;
            }

            wrapper.classList.remove('hidden');
            let totalBytes = selectedBatchFiles.reduce((acc, f) => acc + f.size, 0);
            const totalMb = (totalBytes / (1024 * 1024)).toFixed(2);
            if (summary) summary.textContent = `${selectedBatchFiles.length} image(s) sélectionnée(s) (${totalMb} Mo au total)`;
            if (labelSubmit && currentBatchModalSubTab === 'batch_files') labelSubmit.textContent = `Téléverser ${selectedBatchFiles.length} image(s)`;

            grid.innerHTML = selectedBatchFiles.map((file, idx) => {
                const objUrl = URL.createObjectURL(file);
                return `
                    <div class="p-2 bg-slate-50 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 rounded-xl space-y-1.5 relative group">
                        <div class="w-full h-16 rounded-lg overflow-hidden bg-slate-950">
                            <img src="${objUrl}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-slate-700 dark:text-slate-300 font-semibold truncate max-w-[80px]" title="${escapeHtml(file.name)}">${escapeHtml(file.name)}</span>
                            <span class="text-[9px] text-slate-400 font-mono">${(file.size / 1024).toFixed(0)}k</span>
                        </div>
                        <button type="button" onclick="removeBatchFile(${idx})" class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-rose-500 text-white text-[10px] font-bold flex items-center justify-center hover:bg-rose-600 shadow transition">✕</button>
                    </div>
                `;
            }).join('');
        }

        function openBatchImagesModal(initialTab = 'batch_files') {
            clearBatchFilesSelect();
            document.getElementById('batchImagesInputText').value = '';
            document.getElementById('batchImagesInputMaxUses').value = '3';
            if (document.getElementById('batchImagesInputCategory')) document.getElementById('batchImagesInputCategory').value = 'general';
            
            switchBatchModalSubTab(initialTab);
            document.getElementById('batchImageModal').classList.remove('hidden');
        }

        function closeBatchImagesModal() {
            clearBatchFilesSelect();
            document.getElementById('batchImageModal').classList.add('hidden');
        }

        async function saveBatchImagesForm(e) {
            e.preventDefault();
            const btnSubmit = document.getElementById('btnSubmitBatchImages');
            const labelSubmit = document.getElementById('labelSubmitBatchImages');
            const prevText = labelSubmit ? labelSubmit.textContent : 'Importer';

            if (currentBatchModalSubTab === 'batch_files') {
                if (selectedBatchFiles.length === 0) {
                    alert('Veuillez sélectionner au moins une image locale à téléverser');
                    return;
                }

                const formData = new FormData();
                for (let i = 0; i < selectedBatchFiles.length; i++) {
                    formData.append('image_files[]', selectedBatchFiles[i]);
                }
                formData.append('style', document.getElementById('batchImagesInputStyle').value);
                formData.append('bot_id', document.getElementById('batchImagesInputBotId').value);
                formData.append('category', document.getElementById('batchImagesInputCategory')?.value || 'general');
                formData.append('max_uses', document.getElementById('batchImagesInputMaxUses').value);

                try {
                    btnSubmit.disabled = true;
                    if (labelSubmit) labelSubmit.textContent = `Téléversement (${selectedBatchFiles.length})...`;

                    const res = await fetch('api.php?action=queue_upload_batch_images', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await res.json();
                    btnSubmit.disabled = false;
                    if (labelSubmit) labelSubmit.textContent = prevText;

                    if (data.success) {
                        closeBatchImagesModal();
                        fetchQueue();
                    } else {
                        alert(data.message || 'Erreur lors du téléversement en lot');
                    }
                } catch (err) {
                    btnSubmit.disabled = false;
                    if (labelSubmit) labelSubmit.textContent = prevText;
                    console.error('Error uploading batch images', err);
                    alert('Erreur réseau lors du transfert en lot');
                }
            } else {
                const rawUrls = document.getElementById('batchImagesInputText').value.trim();
                if (!rawUrls) {
                    alert('Veuillez saisir au moins une URL');
                    return;
                }

                const payload = {
                    batch_urls: rawUrls,
                    style: document.getElementById('batchImagesInputStyle').value,
                    bot_id: document.getElementById('batchImagesInputBotId').value,
                    category: document.getElementById('batchImagesInputCategory')?.value || 'general',
                    max_uses: document.getElementById('batchImagesInputMaxUses').value
                };

                try {
                    btnSubmit.disabled = true;
                    if (labelSubmit) labelSubmit.textContent = 'Importation en cours...';

                    const res = await fetch('api.php?action=queue_batch_images', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(payload)
                    });
                    const data = await res.json();
                    btnSubmit.disabled = false;
                    if (labelSubmit) labelSubmit.textContent = prevText;

                    if (data.success) {
                        closeBatchImagesModal();
                        fetchQueue();
                    } else {
                        alert(data.message || 'Erreur lors de l\'import des images');
                    }
                } catch (err) {
                    btnSubmit.disabled = false;
                    if (labelSubmit) labelSubmit.textContent = prevText;
                    console.error('Error importing batch images by url', err);
                }
            }
        }

        // --- Banner Generator Modal & Live Preview ---
        let currentBannerDataUri = null;

        function openBannerModal() {
            document.getElementById('bannerModal').classList.remove('hidden');
            updateBannerPreview();
        }

        function closeBannerModal() {
            document.getElementById('bannerModal').classList.add('hidden');
        }

        function updateBannerPreview() {
            const title = document.getElementById('bannerInputTitle').value || 'Titre de la Carte Visuelle';
            const category = document.getElementById('bannerInputCategory').value || 'Guide & Patrimoine';
            const theme = document.getElementById('bannerInputTheme').value || 'emerald';

            let gradStart = '#0f172a';
            let gradEnd = '#134e4a';
            let accentColor = '#14b8a6';
            let badgeBg = '#0d9488';

            if (theme === 'ocean') {
                gradStart = '#082f49';
                gradEnd = '#0369a1';
                accentColor = '#38bdf8';
                badgeBg = '#0284c7';
            } else if (theme === 'sunset') {
                gradStart = '#4c0519';
                gradEnd = '#9a3412';
                accentColor = '#fb923c';
                badgeBg = '#ea580c';
            } else if (theme === 'midnight') {
                gradStart = '#030712';
                gradEnd = '#1e1b4b';
                accentColor = '#818cf8';
                badgeBg = '#4f46e5';
            }

            const titlePart1 = title.length > 40 ? title.substring(0, 40) + '...' : title;

            const svg = `
                <svg xmlns="http://www.w3.org/2000/svg" width="800" height="450" viewBox="0 0 800 450">
                    <defs>
                        <linearGradient id="g" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="${gradStart}" />
                            <stop offset="100%" stop-color="${gradEnd}" />
                        </linearGradient>
                    </defs>
                    <rect width="800" height="450" fill="url(#g)" rx="24"/>
                    <circle cx="720" cy="80" r="140" fill="${accentColor}" opacity="0.15"/>
                    <circle cx="80" cy="380" r="180" fill="${accentColor}" opacity="0.10"/>
                    <rect x="40" y="40" width="720" height="370" fill="#0f172a" fill-opacity="0.45" stroke="#334155" rx="20"/>
                    <rect x="70" y="70" width="220" height="36" rx="10" fill="${badgeBg}"/>
                    <text x="85" y="93" fill="#ffffff" font-family="system-ui, sans-serif" font-size="12" font-weight="bold">🌴 ${escapeHtml(category.toUpperCase())}</text>
                    <text x="70" y="190" fill="#ffffff" font-family="system-ui, sans-serif" font-size="26" font-weight="bold">${escapeHtml(titlePart1)}</text>
                    <line x1="70" y1="330" x2="730" y2="330" stroke="${accentColor}" stroke-width="1.5" stroke-opacity="0.5"/>
                    <text x="70" y="365" fill="#94a3b8" font-family="system-ui, sans-serif" font-size="14">djerbavoyage.tn</text>
                    <text x="560" y="365" fill="${accentColor}" font-family="system-ui, sans-serif" font-size="14" font-weight="bold">Guide Touristique</text>
                </svg>
            `;

            currentBannerDataUri = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svg)));
            document.getElementById('bannerLivePreviewImg').src = currentBannerDataUri;
        }

        async function saveBannerToQueuePool() {
            if (!currentBannerDataUri) updateBannerPreview();
            const payload = {
                image_url: currentBannerDataUri,
                title: document.getElementById('bannerInputTitle').value || 'Bannière Graphique Texte',
                style: 'text_banner',
                bot_id: document.getElementById('bannerInputBotId').value,
                category: 'patrimoine',
                max_uses: document.getElementById('bannerInputMaxUses').value
            };

            try {
                const res = await fetch('api.php?action=queue_add_image', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                if (data.success) {
                    closeBannerModal();
                    fetchQueue();
                } else {
                    alert(data.message || 'Erreur lors de l\'enregistrement de la bannière');
                }
            } catch (err) {
                console.error('Error saving banner', err);
            }
        }

        async function deleteQueueItem(type, id) {
            if (!confirm(`Supprimer cet élément (${type}) de la file ?`)) return;
            try {
                const res = await fetch('api.php?action=queue_delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ type: type, id: id })
                });
                const data = await res.json();
                if (data.success) fetchQueue();
            } catch (err) {
                console.error('Error deleting item', err);
            }
        }

        async function resetQueueItem(type, id) {
            try {
                const res = await fetch('api.php?action=queue_reset', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ type: type, id: id })
                });
                const data = await res.json();
                if (data.success) fetchQueue();
            } catch (err) {
                console.error('Error resetting item', err);
            }
        }

        function setViewMode(mode) {
            viewMode = mode;
            const btnCards = document.getElementById('btnViewCards');
            const btnTable = document.getElementById('btnViewTable');
            const cardsContainer = document.getElementById('historyCardsContainer');
            const tableContainer = document.getElementById('historyTableContainer');

            if (mode === 'cards') {
                btnCards.className = 'px-3 py-1.5 rounded-lg text-xs font-bold bg-teal-500 text-slate-950 transition';
                btnTable.className = 'px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition';
                cardsContainer.classList.remove('hidden');
                tableContainer.classList.add('hidden');
            } else {
                btnTable.className = 'px-3 py-1.5 rounded-lg text-xs font-bold bg-teal-500 text-slate-950 transition';
                btnCards.className = 'px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition';
                cardsContainer.classList.add('hidden');
                tableContainer.classList.remove('hidden');
            }
        }

        function escapeHtml(text) {
            if (!text) return '';
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return text.replace(/[&<>"']/g, m => map[m]);
        }

        // Setup Drag & Drop Handlers for Drop Zones
        function initDragAndDrop() {
            const setupZone = (zoneId, inputId, onFilesDropped) => {
                const zone = document.getElementById(zoneId);
                const input = document.getElementById(inputId);
                if (!zone) return;

                ['dragenter', 'dragover'].forEach(eventName => {
                    zone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        zone.classList.add('border-teal-500', 'bg-teal-50/20', 'dark:bg-teal-500/10');
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    zone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        zone.classList.remove('border-teal-500', 'bg-teal-50/20', 'dark:bg-teal-500/10');
                    }, false);
                });

                zone.addEventListener('drop', (e) => {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    if (files && files.length > 0) {
                        onFilesDropped(files);
                    }
                }, false);
            };

            setupZone('singleDropZone', 'singleImageFileInput', handleSingleFileSelect);
            setupZone('batchDropZone', 'batchFilesInput', handleBatchFilesSelect);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initDragAndDrop);
        } else {
            initDragAndDrop();
        }
    </script>
</body>
</html>
