<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord | Djerba Voyage Admin</title>
  
  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
  <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
  
  <!-- Tailwind CSS v3 CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
          },
          colors: {
            brand: {
              50: '#f8fafc',
              100: '#f1f5f9',
              200: '#e2e8f0',
              500: '#635bff',
              600: '#5851ea',
              700: '#4338ca',
              900: '#0a2540'
            },
            stripe: {
              navy: '#0a2540',
              purple: '#635bff',
              purpleHover: '#5851ea',
              bg: '#f8fafc',
              border: '#e3e8ee'
            }
          }
        }
      }
    }
  </script>
  <style>
    body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
    ::-webkit-scrollbar { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
    .stripe-nav-link {
      display: flex;
      align-items: center;
      gap: 0.65rem;
      padding: 0.45rem 0.75rem;
      border-radius: 0.375rem;
      font-size: 0.8125rem;
      font-weight: 500;
      color: #475569;
      transition: all 0.15s ease-in-out;
    }
    .stripe-nav-link:hover {
      background-color: #f1f5f9;
      color: #0f172a;
    }
    .dark .stripe-nav-link {
      color: #94a3b8;
    }
    .dark .stripe-nav-link:hover {
      background-color: #1e293b;
      color: #f8fafc;
    }
    .stripe-nav-link.active {
      background-color: #eef2ff;
      color: #635bff;
      font-weight: 600;
    }
    .dark .stripe-nav-link.active {
      background-color: rgba(99, 91, 255, 0.15);
      color: #818cf8;
    }
  </style>
</head>
<body class="bg-[#f8fafc] dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen flex flex-col font-sans antialiased overflow-x-hidden">
  
  <?php if (!empty($_SESSION['admin_logged'])): ?>
    <?php
      $currentUri = $_SERVER['REQUEST_URI'] ?? '';
      $isActive = fn($path) => strpos($currentUri, $path) !== false ? 'active' : '';
    ?>
    <!-- 1. Stripe Test Environment Banner -->
    <div class="bg-[#0a2540] text-white px-4 py-1.5 text-xs flex items-center justify-between z-50 shrink-0 border-b border-slate-800">
      <div class="flex items-center gap-3 overflow-hidden">
        <span class="font-bold tracking-tight text-white flex items-center gap-1.5 shrink-0">
          <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
          Environnement de test
        </span>
        <span class="text-slate-300 text-[11px] truncate hidden md:inline">
          Vous utilisez actuellement un environnement de test. Les modifications que vous y apportez n'ont aucune incidence sur vos données réelles.
        </span>
      </div>
      <div class="flex items-center gap-2 shrink-0">
        <a href="<?= url('/admin/settings') ?>" class="text-[11px] text-slate-300 hover:text-white underline decoration-slate-500">
          Gérer les clés Stripe
        </a>
      </div>
    </div>

    <!-- Main Container with Sidebar & Content Area -->
    <div class="flex flex-1 min-h-[calc(100vh-33px)]">
      
      <!-- 2. Stripe Sidebar (Light & Clean) -->
      <aside class="w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col shrink-0">
        
        <!-- Workspace / Account Header -->
        <div class="p-3.5 border-b border-slate-100 dark:border-slate-800">
          <div class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition-colors">
            <div class="w-8 h-8 rounded-md bg-[#635bff] text-white font-bold flex items-center justify-center text-xs shadow-sm">
              DV
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="text-xs font-bold text-slate-900 dark:text-white truncate">Djerba Voyage</h3>
              <p class="text-[10px] font-medium text-slate-400 truncate">Test Mode • Administrateur</p>
            </div>
            <i class="fi fi-rr-angle-small-down text-slate-400 text-xs"></i>
          </div>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="flex-1 px-3 py-3 space-y-4 overflow-y-auto">
          
          <!-- Section 1 -->
          <div>
            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 px-2.5 mb-1.5">
              Menu Principal
            </div>
            <div class="space-y-0.5">
              <a href="<?= url('/admin/dashboard') ?>" class="stripe-nav-link <?= $isActive('/admin/dashboard') ?>">
                <i class="fi fi-rr-home text-sm"></i> <span>Accueil</span>
              </a>
              <a href="<?= url('/admin/orders') ?>" class="stripe-nav-link <?= $isActive('/admin/orders') ?>">
                <i class="fi fi-rr-receipt text-sm"></i> <span>Commandes</span>
              </a>
              <a href="<?= url('/admin/products') ?>" class="stripe-nav-link <?= $isActive('/admin/products') ?>">
                <i class="fi fi-rr-box-alt text-sm"></i> <span>Catalogue Produits</span>
              </a>
              <a href="<?= url('/admin/services-bookings') ?>" class="stripe-nav-link <?= $isActive('/admin/services-bookings') ?>">
                <i class="fi fi-rr-plane-departure text-sm"></i> <span>Pass & Activités</span>
              </a>
            </div>
          </div>

          <!-- Section 2 -->
          <div>
            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 px-2.5 mb-1.5">
              Outils & Rapports
            </div>
            <div class="space-y-0.5">
              <a href="<?= url('/admin/analytics') ?>" class="stripe-nav-link <?= $isActive('/admin/analytics') ?>">
                <i class="fi fi-rr-chart-pie text-sm"></i> <span>Statistiques GA</span>
              </a>
              <a href="<?= url('/admin/newsletter') ?>" class="stripe-nav-link <?= $isActive('/admin/newsletter') ?>">
                <i class="fi fi-rr-envelope text-sm"></i> <span>Newsletter & Abonnés</span>
              </a>
              <a href="<?= url('/admin/settings') ?>" class="stripe-nav-link <?= $isActive('/admin/settings') ?>">
                <i class="fi fi-rr-settings text-sm"></i> <span>Configuration & Stripe</span>
              </a>
            </div>
          </div>

          <!-- Section 3 -->
          <div>
            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 px-2.5 mb-1.5">
              Sécurité & Comptes
            </div>
            <div class="space-y-0.5">
              <a href="<?= url('/admin/users') ?>" class="stripe-nav-link <?= $isActive('/admin/users') ?>">
                <i class="fi fi-rr-users text-sm"></i> <span>Utilisateurs</span>
              </a>
              <a href="<?= url('/admin/audit') ?>" class="stripe-nav-link <?= $isActive('/admin/audit') ?>">
                <i class="fi fi-rr-shield-check text-sm"></i> <span>Audit & Anti-Fraude</span>
              </a>
            </div>
          </div>

        </nav>
        
        <!-- Sidebar Footer -->
        <div class="p-3 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
          <div class="flex items-center justify-between px-2 py-1.5">
            <span class="text-[11px] font-medium text-slate-500 flex items-center gap-1.5">
              <i class="fi fi-rr-code-compare text-slate-400"></i> Développeurs
            </span>
            <a href="<?= url('/admin/logout') ?>" class="text-[11px] font-medium text-red-600 hover:text-red-700 dark:text-red-400 flex items-center gap-1">
              <i class="fi fi-rr-sign-out-alt"></i> Quitter
            </a>
          </div>
        </div>

      </aside>

      <!-- 3. Content Area & Topbar -->
      <div class="flex-1 flex flex-col min-w-0 bg-[#f8fafc] dark:bg-slate-950 overflow-y-auto">
        
        <!-- Stripe Topbar -->
        <header class="h-14 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-6 flex items-center justify-between shrink-0">
          <!-- Search Bar -->
          <div class="relative w-72 max-w-full">
            <i class="fi fi-rr-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" placeholder="Rechercher..." class="w-full pl-8 pr-3 py-1.5 text-xs rounded-md bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 border-0 focus:ring-1 focus:ring-[#635bff] placeholder-slate-400 transition-all">
          </div>

          <!-- Header Actions -->
          <div class="flex items-center gap-3">
            <button type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-sm p-1.5 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800" title="Aide">
              <i class="fi fi-rr-interrogation"></i>
            </button>
            <button type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-sm p-1.5 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800" title="Notifications">
              <i class="fi fi-rr-bell"></i>
            </button>
            <a href="<?= url('/admin/settings') ?>" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-sm p-1.5 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800" title="Paramètres">
              <i class="fi fi-rr-settings"></i>
            </a>
            
            <!-- Stripe + Quick Button -->
            <a href="<?= url('/admin/products/create') ?>" class="w-6 h-6 rounded-full bg-[#635bff] hover:bg-[#5851ea] text-white flex items-center justify-center text-xs shadow-sm transition-transform active:scale-95" title="Créer un produit">
              <i class="fi fi-rr-plus text-[10px]"></i>
            </a>

            <!-- Guide Pill -->
            <div class="hidden sm:flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full shadow-sm">
              <span class="w-2 h-2 rounded-full border-2 border-[#635bff] border-t-transparent animate-spin"></span>
              Guide de démarrage
            </div>
          </div>
        </header>

        <!-- Dynamic Main Content -->
        <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto">
          <?= $content ?>
        </main>

      </div>

    </div>
  <?php else: ?>
    <!-- Guest / Login Layout -->
    <main class="min-h-screen flex items-center justify-center p-4 bg-[#f8fafc] dark:bg-slate-950">
      <?= $content ?>
    </main>
  <?php endif; ?>
  
</body>
</html>