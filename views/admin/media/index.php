<?php
/**
 * Vue d'administration : Gestionnaire de Médias (Images & Vidéos)
 * @var array $images
 * @var array $videos
 * @var string $tab
 * @var string|null $flashSuccess
 * @var string|null $flashError
 */

function formatMediaSize(int $bytes): string {
    if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' Mo';
    if ($bytes >= 1024) return round($bytes / 1024, 1) . ' Ko';
    return $bytes . ' o';
}

$blogCount = count(array_filter($images, fn($i) => $i['folder'] === 'blog'));
$siteCount = count(array_filter($images, fn($i) => $i['folder'] === 'site'));
$uploadCount = count(array_filter($images, fn($i) => $i['folder'] === 'uploads'));
$totalSize = array_sum(array_column($images, 'size')) + array_sum(array_column($videos, 'size'));
?>

<div class="p-4 sm:p-6 space-y-5 max-w-7xl mx-auto">

  <!-- En-tête -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200 dark:border-slate-800">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
        <a href="<?= url('/admin/dashboard') ?>" class="hover:text-slate-700 dark:hover:text-slate-300">Dashboard</a>
        <span>/</span>
        <span class="text-[#635bff] font-medium">Médias</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
        <i class="fi fi-rr-picture text-[#635bff]"></i>
        Gestionnaire de Médias
      </h1>
      <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
        Images du site, articles de blog (/images/blog/) et vidéos. Protégées contre le hotlinking.
      </p>
    </div>
  </div>

  <!-- Messages Flash -->
  <?php if (!empty($flashSuccess)): ?>
    <div class="p-3 text-xs font-medium text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 rounded-lg flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="fi fi-rr-check-circle text-emerald-600 dark:text-emerald-400 text-sm"></i>
        <span><?= htmlspecialchars($flashSuccess, ENT_QUOTES, 'UTF-8') ?></span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm">&times;</button>
    </div>
  <?php endif; ?>

  <?php if (!empty($flashError)): ?>
    <div class="p-3 text-xs font-medium text-rose-800 dark:text-rose-300 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 rounded-lg flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="fi fi-rr-cross-circle text-rose-600 dark:text-rose-400 text-sm"></i>
        <span><?= htmlspecialchars($flashError, ENT_QUOTES, 'UTF-8') ?></span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 text-sm">&times;</button>
    </div>
  <?php endif; ?>

  <!-- KPI -->
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
    <div class="p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xs">
      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Images</span>
      <span class="text-lg font-bold text-slate-900 dark:text-white mt-0.5 block"><?= count($images) ?></span>
    </div>
    <div class="p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xs">
      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Blog & Articles</span>
      <span class="text-lg font-bold text-amber-600 dark:text-amber-400 mt-0.5 block"><?= $blogCount ?></span>
    </div>
    <div class="p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xs">
      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Vidéos</span>
      <span class="text-lg font-bold text-slate-900 dark:text-white mt-0.5 block"><?= count($videos) ?></span>
    </div>
    <div class="p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xs">
      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Taille Totale</span>
      <span class="text-lg font-bold text-[#635bff] mt-0.5 block"><?= formatMediaSize($totalSize) ?></span>
    </div>
  </div>

  <!-- Zone d'Upload -->
  <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xs overflow-hidden">
    <form action="<?= url('/admin/media/upload') ?>" method="POST" enctype="multipart/form-data" class="p-4 sm:p-5">
      <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Téléverser de nouveaux fichiers</h3>
      <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
        <div class="sm:col-span-5">
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Fichiers</label>
          <input type="file" name="media_files[]" multiple accept="image/*,video/*"
                 class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 dark:file:bg-slate-800 file:text-slate-700 dark:file:text-slate-200 hover:file:bg-slate-200 dark:hover:file:bg-slate-700 cursor-pointer">
        </div>
        <div class="sm:col-span-2">
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Type</label>
          <select name="media_type" id="media_type_select" class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-1 focus:ring-[#635bff]">
            <option value="image" <?= $tab === 'images' ? 'selected' : '' ?>>Image</option>
            <option value="video" <?= $tab === 'videos' ? 'selected' : '' ?>>Vidéo</option>
          </select>
        </div>
        <div class="sm:col-span-3" id="folder_container">
          <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Dossier cible</label>
          <select name="folder" class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-1 focus:ring-[#635bff]">
            <option value="blog">Articles & Blog (/images/blog/)</option>
            <option value="uploads" selected>Téléversements (/images/uploads/)</option>
          </select>
        </div>
        <div class="sm:col-span-2">
          <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-semibold text-white bg-[#635bff] hover:bg-[#5349e0] rounded-md shadow-xs transition-colors">
            <i class="fi fi-rr-cloud-upload-alt"></i>
            <span>Téléverser</span>
          </button>
        </div>
      </div>
    </form>
  </div>

  <!-- Conteneur Principal -->
  <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xs overflow-hidden">
    
    <!-- Onglets Images / Vidéos -->
    <div class="border-b border-slate-200 dark:border-slate-800 px-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 py-2">
      <nav class="flex gap-4" aria-label="Onglets Médias">
        <a href="<?= url('/admin/media?tab=images') ?>"
           class="py-2.5 text-xs font-semibold border-b-2 transition-colors <?= $tab === 'images' ? 'border-[#635bff] text-[#635bff]' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' ?>">
          <i class="fi fi-rr-picture mr-1"></i> Images (<?= count($images) ?>)
        </a>
        <a href="<?= url('/admin/media?tab=videos') ?>"
           class="py-2.5 text-xs font-semibold border-b-2 transition-colors <?= $tab === 'videos' ? 'border-[#635bff] text-[#635bff]' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' ?>">
          <i class="fi fi-rr-play-alt mr-1"></i> Vidéos (<?= count($videos) ?>)
        </a>
      </nav>

      <?php if ($tab === 'images'): ?>
        <!-- Barre de recherche en temps réel -->
        <div class="relative min-w-[220px]">
          <input type="text" id="image-search-input" placeholder="Rechercher une image..."
                 class="w-full rounded-lg border border-slate-200 dark:border-slate-700 pl-8 pr-3 py-1.5 text-xs bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-1 focus:ring-[#635bff]">
          <i class="fi fi-rr-search absolute left-2.5 top-2 text-slate-400 text-xs"></i>
        </div>
      <?php endif; ?>
    </div>

    <!-- Onglet Images -->
    <?php if ($tab === 'images'): ?>
      <!-- Filtres par Dossier / Catégorie -->
      <div class="px-4 py-2.5 bg-slate-50/50 dark:bg-slate-800/30 border-b border-slate-200 dark:border-slate-800 flex flex-wrap items-center gap-2 text-xs">
        <span class="text-slate-400 font-medium text-[11px]">Filtrer par :</span>
        <button type="button" onclick="filterFolder('all')" id="btn-filter-all"
                class="filter-btn px-2.5 py-1 rounded-md font-semibold text-[11px] bg-[#635bff] text-white">
          Tous (<?= count($images) ?>)
        </button>
        <button type="button" onclick="filterFolder('blog')" id="btn-filter-blog"
                class="filter-btn px-2.5 py-1 rounded-md font-semibold text-[11px] bg-slate-200/80 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-700">
          <i class="fi fi-rr-document-signed mr-1"></i> Blog & Articles (<?= $blogCount ?>)
        </button>
        <button type="button" onclick="filterFolder('site')" id="btn-filter-site"
                class="filter-btn px-2.5 py-1 rounded-md font-semibold text-[11px] bg-slate-200/80 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-700">
          <i class="fi fi-rr-globe mr-1"></i> Images du site (<?= $siteCount ?>)
        </button>
        <button type="button" onclick="filterFolder('uploads')" id="btn-filter-uploads"
                class="filter-btn px-2.5 py-1 rounded-md font-semibold text-[11px] bg-slate-200/80 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-700">
          <i class="fi fi-rr-cloud-upload-alt mr-1"></i> Téléversements (<?= $uploadCount ?>)
        </button>
      </div>

      <?php if (empty($images)): ?>
        <div class="p-10 text-center text-slate-400 text-sm">
          <i class="fi fi-rr-picture text-3xl block mb-2 opacity-40"></i>
          Aucune image trouvée.
        </div>
      <?php else: ?>
        <div id="images-grid" class="p-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
          <?php foreach ($images as $img): ?>
            <?php
              $badgeBg = match($img['folder']) {
                'blog'    => 'bg-amber-500/90 text-white',
                'uploads' => 'bg-emerald-600/90 text-white',
                default   => 'bg-slate-700/80 text-white',
              };
              $badgeLabel = match($img['folder']) {
                'blog'    => 'Blog',
                'uploads' => 'Upload',
                default   => 'Site',
              };
            ?>
            <div class="image-card group relative bg-slate-50 dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden shadow-xs hover:shadow-md transition-shadow"
                 data-folder="<?= htmlspecialchars($img['folder'], ENT_QUOTES, 'UTF-8') ?>"
                 data-name="<?= strtolower(htmlspecialchars($img['name'], ENT_QUOTES, 'UTF-8')) ?>">
              
              <!-- Badge dossier -->
              <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded text-[9px] font-bold <?= $badgeBg ?> shadow-xs">
                <?= $badgeLabel ?>
              </span>

              <!-- Vignette -->
              <div class="aspect-square overflow-hidden bg-slate-100 dark:bg-slate-900">
                <img src="<?= asset('images/' . $img['path']) ?>" 
                     alt="<?= htmlspecialchars($img['name'], ENT_QUOTES, 'UTF-8') ?>"
                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                     loading="lazy">
              </div>

              <!-- Overlay actions -->
              <div class="absolute inset-0 bg-black/65 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-1.5 p-2 z-20">
                <button type="button" onclick="copyUrl('<?= htmlspecialchars($img['url'], ENT_QUOTES, 'UTF-8') ?>')" 
                        class="w-full py-1.5 bg-white/95 text-slate-800 rounded text-[10px] font-bold hover:bg-white transition-colors flex items-center justify-center gap-1">
                  <i class="fi fi-rr-copy-alt"></i> Copier l'URL
                </button>
                <a href="<?= htmlspecialchars($img['url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank"
                   class="w-full py-1.5 bg-slate-800/90 text-white rounded text-[10px] font-bold hover:bg-slate-700 transition-colors flex items-center justify-center gap-1">
                  <i class="fi fi-rr-eye"></i> Ouvrir
                </a>
                <?php if ($img['deletable']): ?>
                  <form method="POST" action="<?= url('/admin/media/delete') ?>" 
                        onsubmit="return confirm('Supprimer définitivement cette image ?')" class="w-full">
                    <input type="hidden" name="file" value="<?= htmlspecialchars($img['name'], ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="folder" value="<?= htmlspecialchars($img['folder'], ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="type" value="image">
                    <button type="submit" class="w-full py-1.5 bg-rose-500/90 text-white rounded text-[10px] font-bold hover:bg-rose-600 transition-colors flex items-center justify-center gap-1">
                      <i class="fi fi-rr-trash"></i> Supprimer
                    </button>
                  </form>
                <?php endif; ?>
              </div>

              <!-- Infos fichier -->
              <div class="px-2 py-1.5 bg-white dark:bg-slate-800/90">
                <p class="text-[10px] font-semibold text-slate-700 dark:text-slate-200 truncate" title="<?= htmlspecialchars($img['name'], ENT_QUOTES, 'UTF-8') ?>">
                  <?= htmlspecialchars($img['name'], ENT_QUOTES, 'UTF-8') ?>
                </p>
                <p class="text-[9px] text-slate-400 flex items-center justify-between mt-0.5">
                  <span><?= formatMediaSize($img['size']) ?></span>
                  <span><?= date('d/m/Y', $img['modified']) ?></span>
                </p>
              </div>

            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    <!-- Onglet Vidéos -->
    <?php else: ?>
      <?php if (empty($videos)): ?>
        <div class="p-10 text-center text-slate-400 text-sm">
          <i class="fi fi-rr-play-alt text-3xl block mb-2 opacity-40"></i>
          Aucune vidéo trouvée.
        </div>
      <?php else: ?>
        <div class="p-4 overflow-x-auto w-full">
          <table class="w-full text-xs text-left border-collapse">
            <thead class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase bg-slate-50/75 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800 tracking-wider">
              <tr>
                <th class="px-4 py-3">Fichier</th>
                <th class="px-4 py-3">Taille</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3 text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
              <?php foreach ($videos as $vid): ?>
                <tr class="hover:bg-slate-50/75 dark:hover:bg-slate-800/50 transition-colors">
                  <td class="px-4 py-2.5">
                    <div class="flex items-center gap-3">
                      <div class="w-9 h-9 rounded-md bg-slate-200 dark:bg-slate-700 flex items-center justify-center shrink-0">
                        <i class="fi fi-rr-play text-slate-500 dark:text-slate-300"></i>
                      </div>
                      <div class="min-w-0">
                        <p class="font-semibold text-slate-900 dark:text-white truncate max-w-xs">
                          <?= htmlspecialchars($vid['name'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <p class="text-[10px] text-slate-400 font-mono truncate"><?= htmlspecialchars($vid['url'], ENT_QUOTES, 'UTF-8') ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-2.5 text-slate-600 dark:text-slate-300 font-medium"><?= formatMediaSize($vid['size']) ?></td>
                  <td class="px-4 py-2.5 text-slate-400 text-[11px] whitespace-nowrap"><?= date('d/m/Y H:i', $vid['modified']) ?></td>
                  <td class="px-4 py-2.5 text-right">
                    <div class="inline-flex items-center gap-1">
                      <button type="button" onclick="copyUrl('<?= htmlspecialchars($vid['url'], ENT_QUOTES, 'UTF-8') ?>')"
                              class="p-1.5 text-slate-400 hover:text-[#635bff] rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Copier l'URL">
                        <i class="fi fi-rr-copy-alt text-xs"></i>
                      </button>
                      <?php if ($vid['deletable']): ?>
                        <form method="POST" action="<?= url('/admin/media/delete') ?>" onsubmit="return confirm('Supprimer cette vidéo ?')" class="inline">
                          <input type="hidden" name="file" value="<?= htmlspecialchars($vid['name'], ENT_QUOTES, 'UTF-8') ?>">
                          <input type="hidden" name="type" value="video">
                          <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Supprimer">
                            <i class="fi fi-rr-trash text-xs"></i>
                          </button>
                        </form>
                      <?php endif; ?>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    <?php endif; ?>

  </div>
</div>

<script>
let currentFolder = 'all';

function filterFolder(folder) {
  currentFolder = folder;
  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.className = 'filter-btn px-2.5 py-1 rounded-md font-semibold text-[11px] bg-slate-200/80 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-700';
  });
  const activeBtn = document.getElementById('btn-filter-' + folder);
  if (activeBtn) activeBtn.className = 'filter-btn px-2.5 py-1 rounded-md font-semibold text-[11px] bg-[#635bff] text-white';
  applyFilters();
}

function applyFilters() {
  const query = (document.getElementById('image-search-input')?.value || '').toLowerCase().trim();
  document.querySelectorAll('.image-card').forEach(card => {
    const cardFolder = card.getAttribute('data-folder');
    const cardName   = card.getAttribute('data-name') || '';
    const matchFolder = (currentFolder === 'all' || cardFolder === currentFolder);
    const matchQuery  = (!query || cardName.includes(query));
    card.style.display = (matchFolder && matchQuery) ? '' : 'none';
  });
}

document.getElementById('image-search-input')?.addEventListener('input', applyFilters);

const typeSelect = document.getElementById('media_type_select');
if (typeSelect) {
  typeSelect.addEventListener('change', function() {
    const folderBox = document.getElementById('folder_container');
    if (folderBox) folderBox.style.display = (this.value === 'video') ? 'none' : '';
  });
}

function copyUrl(url) {
  try {
    const fullUrl = window.location.origin + url;
    navigator.clipboard.writeText(fullUrl).then(function() {
      showToast('URL copiée : ' + url);
    });
  } catch (error) {
    console.error('[ERROR] ' + error.message);
  }
}

function showToast(message) {
  const toast = document.createElement('div');
  toast.className = 'fixed bottom-6 right-6 z-50 px-4 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-xs font-semibold rounded-lg shadow-lg flex items-center gap-2 animate-fade-in';
  toast.innerHTML = '<i class="fi fi-rr-check text-emerald-400 dark:text-emerald-600"></i> ' + message;
  document.body.appendChild(toast);
  setTimeout(function() {
    toast.style.opacity = '0';
    toast.style.transition = 'opacity 0.3s';
    setTimeout(function() { toast.remove(); }, 300);
  }, 2200);
}
</script>
