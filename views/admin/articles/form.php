<?php
/**
 * Vue d'administration : Formulaire Éditeur d'Article
 * @var \App\Models\Article|null $article
 * @var string|null $error
 */
$isEdit = !empty($article && $article->id);
?>

<div class="p-4 sm:p-6 space-y-6 max-w-5xl mx-auto">

  <!-- En-tête -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
        <a href="<?= url('/admin/articles') ?>" class="hover:text-slate-700 dark:hover:text-slate-300">Articles</a>
        <span>/</span>
        <span class="text-slate-900 dark:text-slate-100 font-medium"><?= $isEdit ? 'Modifier' : 'Nouveau' ?></span>
      </div>
      <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
        <i class="fi fi-rr-edit text-[#635bff]"></i>
        <?= $isEdit ? 'Éditer l\'Article' : 'Rédiger un Nouvel Article' ?>
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
        Personnalisez le contenu, la mise en page et l'optimisation SEO de votre guide.
      </p>
    </div>

    <div class="flex items-center gap-2">
      <?php if ($isEdit): ?>
        <a href="<?= url('/guide/' . urlencode($article->slug)) ?>" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 rounded-md text-xs font-semibold hover:bg-slate-50 shadow-xs transition-colors">
          <i class="fi fi-rr-eye text-[10px]"></i> Voir en ligne
        </a>
      <?php endif; ?>
      <a href="<?= url('/admin/articles') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 rounded-md text-xs font-semibold hover:bg-slate-50 shadow-xs transition-colors">
        <i class="fi fi-rr-arrow-left text-[10px]"></i> Retour
      </a>
    </div>
  </div>

  <!-- Message d'erreur éventuel -->
  <?php if (!empty($error)): ?>
    <div class="p-3.5 rounded-lg bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-900/50 text-rose-700 dark:text-rose-300 text-xs font-medium flex items-center gap-2">
      <i class="fi fi-rr-cross-circle text-sm"></i>
      <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </div>
  <?php endif; ?>

  <!-- Formulaire de Rédaction -->
  <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
      <!-- Colonne Principale (Contenu Rédactionnel Multilingue) -->
      <div class="lg:col-span-2 space-y-5">
        
        <!-- Onglets de Langue -->
        <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 pb-2">
          <button type="button" onclick="switchArticleLangTab('fr')" id="artTabBtn-fr" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all bg-[#635bff] text-white shadow-xs">
            🇫🇷 Français (Principal)
          </button>
          <button type="button" onclick="switchArticleLangTab('en')" id="artTabBtn-en" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
            🇬🇧 English
          </button>
          <button type="button" onclick="switchArticleLangTab('ar')" id="artTabBtn-ar" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
            🇹🇳 العربية (Arabe)
          </button>
        </div>

        <!-- Volet Français -->
        <div id="artLangTab-fr" class="space-y-4">
          <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs space-y-4">
            <div>
              <label for="title_fr" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                Titre de l'Article (Français) *
              </label>
              <input type="text" id="title_fr" name="title_fr" required 
                     value="<?= $article ? htmlspecialchars($article->titleFr, ENT_QUOTES, 'UTF-8') : '' ?>" 
                     placeholder="ex: Les Plus Belles Plages de Djerba en 2026" 
                     class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white font-semibold focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
            </div>

            <div>
              <label for="slug" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                Identifiant URL (Slug)
              </label>
              <input type="text" id="slug" name="slug" 
                     value="<?= $article ? htmlspecialchars($article->slug, ENT_QUOTES, 'UTF-8') : '' ?>" 
                     placeholder="laisser vide pour génération automatique" 
                     class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-xs bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white font-mono focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
            </div>
          </div>

          <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs space-y-3">
            <div class="flex items-center justify-between">
              <label for="content_fr" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                Contenu Rédactionnel Français (HTML) *
              </label>
              <span class="text-[10px] text-slate-400">Balises : &lt;h2&gt;, &lt;h3&gt;, &lt;p&gt;, &lt;table&gt;, &lt;ul&gt;</span>
            </div>
            <textarea id="content_fr" name="content_fr" rows="12" 
                      class="w-full rounded-md border border-slate-300 dark:border-slate-700 p-3 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white font-mono leading-relaxed focus:outline-hidden focus:ring-1 focus:ring-[#635bff]"><?= $article ? htmlspecialchars($article->contentFr, ENT_QUOTES, 'UTF-8') : '' ?></textarea>
          </div>
        </div>

        <!-- Volet English -->
        <div id="artLangTab-en" class="space-y-4 hidden">
          <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs space-y-4">
            <div>
              <label for="title_en" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                Article Title (English)
              </label>
              <input type="text" id="title_en" name="title_en" 
                     value="<?= $article ? htmlspecialchars($article->titleEn ?? '', ENT_QUOTES, 'UTF-8') : '' ?>" 
                     placeholder="e.g. The Best Beaches in Djerba 2026" 
                     class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white font-semibold focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
            </div>
          </div>

          <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs space-y-3">
            <div class="flex items-center justify-between">
              <label for="content_en" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                English Content (HTML)
              </label>
              <span class="text-[10px] text-slate-400">Full English version</span>
            </div>
            <textarea id="content_en" name="content_en" rows="12" 
                      class="w-full rounded-md border border-slate-300 dark:border-slate-700 p-3 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white font-mono leading-relaxed focus:outline-hidden focus:ring-1 focus:ring-[#635bff]"><?= $article ? htmlspecialchars($article->contentEn ?? '', ENT_QUOTES, 'UTF-8') : '' ?></textarea>
          </div>
        </div>

        <!-- Volet Arabe -->
        <div id="artLangTab-ar" class="space-y-4 hidden">
          <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs space-y-4">
            <div>
              <label for="title_ar" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 text-right">
                عنوان المقال (باللغة العربية)
              </label>
              <input type="text" id="title_ar" name="title_ar" dir="rtl"
                     value="<?= $article ? htmlspecialchars($article->titleAr ?? '', ENT_QUOTES, 'UTF-8') : '' ?>" 
                     placeholder="مثال: أجمل شواطئ جزيرة جربة لعام 2026" 
                     class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-2 text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white font-semibold text-right focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
            </div>
          </div>

          <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-[10px] text-slate-400">تنسيق HTML غني باللغة العربية</span>
              <label for="content_ar" class="block text-xs font-bold text-slate-700 dark:text-slate-300 text-right">
                محتوى المقال باللغة العربية (HTML)
              </label>
            </div>
            <textarea id="content_ar" name="content_ar" rows="12" dir="rtl"
                      class="w-full rounded-md border border-slate-300 dark:border-slate-700 p-3 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white font-mono leading-relaxed text-right focus:outline-hidden focus:ring-1 focus:ring-[#635bff]"><?= $article ? htmlspecialchars($article->contentAr ?? '', ENT_QUOTES, 'UTF-8') : '' ?></textarea>
          </div>
        </div>

        <!-- Résumé Voyageur & Synthèse IA -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs space-y-3">
          <label for="summary_ai" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
            Encadré "L'Essentiel en Bref" (Points Clés Voyageur)
          </label>
          <textarea id="summary_ai" name="summary_ai" rows="3" placeholder="3 à 4 points forts pour les moteurs IA et la synthèse voyageur..." 
                    class="w-full rounded-md border border-slate-300 dark:border-slate-700 p-2.5 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-hidden focus:ring-1 focus:ring-[#635bff]"><?= $article ? htmlspecialchars($article->summaryAi ?? '', ENT_QUOTES, 'UTF-8') : '' ?></textarea>
        </div>

      </div>

      <!-- Colonne Latérale (Paramètres & SEO) -->
      <div class="space-y-5">
        
        <!-- Publication & Statut -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs space-y-4">
          <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Publication</h3>
          
          <div>
            <label for="status" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Statut *</label>
            <select id="status" name="status" class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-1 focus:ring-[#635bff]">
              <option value="published" <?= (!$article || $article->status === 'published') ? 'selected' : '' ?>>Publié en ligne</option>
              <option value="draft" <?= ($article && $article->status === 'draft') ? 'selected' : '' ?>>Brouillon (Non visible)</option>
            </select>
          </div>

          <div>
            <label for="author_name" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nom de l'auteur</label>
            <input type="text" id="author_name" name="author_name" 
                   value="<?= $article ? htmlspecialchars($article->authorName, ENT_QUOTES, 'UTF-8') : 'Rédaction Djerba Voyage' ?>" 
                   class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-1 focus:ring-[#635bff]">
          </div>

          <div class="flex items-center pt-1">
            <input type="checkbox" id="pdf_enabled" name="pdf_enabled" value="1" <?= (!$article || $article->pdfEnabled) ? 'checked' : '' ?> class="h-4 w-4 text-[#635bff] focus:ring-[#635bff] border-slate-300 rounded">
            <label for="pdf_enabled" class="ml-2 block text-xs font-medium text-slate-700 dark:text-slate-300">
              Téléchargement PDF autorisé
            </label>
          </div>
        </div>

        <!-- Image d'Illustration -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs space-y-3">
          <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Illustration</h3>

          <!-- Aperçu de l'image actuelle -->
          <?php
            $currentImg = $article ? $article->featuredImage : 'sidi_mahres.png';
            $previewSrc = asset($currentImg);
          ?>
          <div class="relative group rounded-lg overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800">
            <img id="image-preview" src="<?= htmlspecialchars($previewSrc, ENT_QUOTES, 'UTF-8') ?>" alt="Aperçu" class="w-full h-40 object-cover transition-transform duration-300 group-hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-2.5">
              <span class="text-white text-[10px] font-semibold truncate" id="image-preview-name"><?= htmlspecialchars($currentImg, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Téléverser une image</label>
            <input type="file" id="featured_image_file" name="featured_image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 dark:file:bg-slate-800 file:text-slate-700 dark:file:text-slate-200 hover:file:bg-slate-200 dark:hover:file:bg-slate-700 cursor-pointer">
          </div>
          <div class="relative pt-2">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
              <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
            </div>
            <div class="relative flex justify-center">
              <span class="bg-white dark:bg-slate-900 px-2 text-[10px] text-slate-500 uppercase">Ou choisir une image existante</span>
            </div>
          </div>
          <div>
            <select id="featured_image" name="featured_image" class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-1 focus:ring-[#635bff]">
              <?php foreach (['sidi_mahres.png' => 'Plage Sidi Mahres', 'djerbahood.png' => 'Street Art Djerbahood', 'guellala.png' => 'Coucher de Soleil Guellala', 'ajim.png' => 'Port de Pêche d\'Ajim', 'desert_camp.png' => 'Camp & Dunes Sahara', 'quad_desert.png' => 'Quad & Aventure'] as $file => $label): ?>
                <option value="<?= $file ?>" <?= ($article && $article->featuredImage === $file) ? 'selected' : '' ?>><?= $label ?></option>
              <?php endforeach; ?>
              <?php if ($article && !in_array($article->featuredImage, ['sidi_mahres.png', 'djerbahood.png', 'guellala.png', 'ajim.png', 'desert_camp.png', 'quad_desert.png'])): ?>
                <option value="<?= htmlspecialchars($article->featuredImage, ENT_QUOTES, 'UTF-8') ?>" selected>Image Actuelle (Uploadée)</option>
              <?php endif; ?>
            </select>
          </div>

          <!-- Lien vers le gestionnaire de médias -->
          <a href="<?= url('/admin/media') ?>" target="_blank" class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-[#635bff] hover:text-[#5349e0] transition-colors mt-1">
            <i class="fi fi-rr-picture text-xs"></i> Ouvrir le Gestionnaire de Médias
          </a>
        </div>

        <!-- Référencement SEO -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs space-y-3">
          <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Optimisation SEO</h3>
          <div>
            <label for="seo_description" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Méta Description (max 160 car.)</label>
            <textarea id="seo_description" name="seo_description" rows="3" maxlength="160" placeholder="Description pour Google..." 
                      class="w-full rounded-md border border-slate-300 dark:border-slate-700 p-2 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-1 focus:ring-[#635bff]"><?= $article ? htmlspecialchars($article->seoDescription ?? '', ENT_QUOTES, 'UTF-8') : '' ?></textarea>
          </div>
        </div>

        <!-- Bouton d'enregistrement -->
        <div class="pt-2">
          <button type="submit" class="w-full py-2.5 bg-[#635bff] hover:bg-[#5349e0] text-white rounded-md font-semibold text-xs shadow-sm transition-colors flex items-center justify-center gap-2">
            <i class="fi fi-rr-disk"></i>
            <span><?= $isEdit ? 'Enregistrer les Modifications' : 'Publier l\'Article' ?></span>
          </button>
        </div>

      </div>

    </div>

  </form>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  function switchArticleLangTab(lang) {
    ['fr', 'en', 'ar'].forEach(l => {
      const panel = document.getElementById('artLangTab-' + l);
      const btn = document.getElementById('artTabBtn-' + l);
      if (panel) {
        if (l === lang) {
          panel.classList.remove('hidden');
        } else {
          panel.classList.add('hidden');
        }
      }
      if (btn) {
        if (l === lang) {
          btn.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition-all bg-[#635bff] text-white shadow-xs';
        } else {
          btn.className = 'px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all';
        }
      }
    });
  }

  // Aperçu dynamique de l'image de couverture
  (function() {
    const preview = document.getElementById('image-preview');
    const previewName = document.getElementById('image-preview-name');
    const selectEl = document.getElementById('featured_image');
    const fileInput = document.getElementById('featured_image_file');
    const assetBase = '<?= asset('') ?>';

    if (selectEl) {
      selectEl.addEventListener('change', function() {
        const val = this.value;
        if (val) {
          preview.src = assetBase.replace(/\?.*$/, '').replace(/\/$/, '') + '/' + val;
          previewName.textContent = val;
        }
      });
    }

    if (fileInput) {
      fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
          const reader = new FileReader();
          reader.onload = function(e) {
            preview.src = e.target.result;
            previewName.textContent = fileInput.files[0].name;
          };
          reader.readAsDataURL(this.files[0]);
        }
      });
    }
  })();

  // TinyMCE
  tinymce.init({
    selector: '#content_fr',
    height: 500,
    menubar: false,
    images_upload_url: '<?= url('/admin/upload-image') ?>',
    automatic_uploads: true,
    file_picker_types: 'image',
    plugins: [
      'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
      'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
      'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | ' +
    'bold italic backcolor | alignleft aligncenter ' +
    'alignright alignjustify | bullist numlist outdent indent | ' +
    'image media | removeformat | code | help',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 14px }',
    setup: function (editor) {
      editor.on('change', function () {
        editor.save();
      });
    }
  });
</script>
