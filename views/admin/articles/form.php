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
  <form action="" method="POST" class="space-y-6">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
      <!-- Colonne Principale (Contenu Rédactionnel) -->
      <div class="lg:col-span-2 space-y-5">
        
        <!-- Titre Principal -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs space-y-4">
          <div>
            <label for="title_fr" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
              Titre de l'Article (FR) *
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

        <!-- Corps de l'Article (Éditeur de Texte) -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs space-y-3">
          <div class="flex items-center justify-between">
            <label for="content_fr" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
              Contenu Rédactionnel (HTML / Paragraphes) *
            </label>
            <span class="text-[10px] text-slate-400">Balises autorisées : &lt;h2&gt;, &lt;h3&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;strong&gt;</span>
          </div>

          <!-- Barre d'outils rapide -->
          <div class="flex flex-wrap gap-1 p-1 bg-slate-100 dark:bg-slate-800 rounded-md text-[11px]">
            <button type="button" onclick="insertTag('h2')" class="px-2 py-1 rounded bg-white dark:bg-slate-700 hover:opacity-80 font-bold">H2</button>
            <button type="button" onclick="insertTag('h3')" class="px-2 py-1 rounded bg-white dark:bg-slate-700 hover:opacity-80 font-bold">H3</button>
            <button type="button" onclick="insertTag('p')" class="px-2 py-1 rounded bg-white dark:bg-slate-700 hover:opacity-80">Paragraphe</button>
            <button type="button" onclick="insertTag('strong')" class="px-2 py-1 rounded bg-white dark:bg-slate-700 hover:opacity-80 font-bold">Gras</button>
            <button type="button" onclick="insertTag('ul')" class="px-2 py-1 rounded bg-white dark:bg-slate-700 hover:opacity-80">Liste</button>
          </div>

          <textarea id="content_fr" name="content_fr" rows="14" required 
                    class="w-full rounded-md border border-slate-300 dark:border-slate-700 p-3 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white font-mono leading-relaxed focus:outline-hidden focus:ring-1 focus:ring-[#635bff]"><?= $article ? htmlspecialchars($article->contentFr, ENT_QUOTES, 'UTF-8') : '' ?></textarea>
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
          <div>
            <label for="featured_image" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Photo de couverture</label>
            <select id="featured_image" name="featured_image" class="w-full rounded-md border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-xs bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-1 focus:ring-[#635bff]">
              <?php foreach (['sidi_mahres.png' => 'Plage Sidi Mahres', 'djerbahood.png' => 'Street Art Djerbahood', 'guellala.png' => 'Coucher de Soleil Guellala', 'ajim.png' => 'Port de Pêche d\'Ajim', 'desert_camp.png' => 'Camp & Dunes Sahara', 'quad_desert.png' => 'Quad & Aventure'] as $file => $label): ?>
                <option value="<?= $file ?>" <?= ($article && $article->featuredImage === $file) ? 'selected' : '' ?>><?= $label ?></option>
              <?php endforeach; ?>
            </select>
          </div>
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

<script>
function insertTag(tag) {
  const textarea = document.getElementById('content_fr');
  if (!textarea) return;
  const start = textarea.selectionStart;
  const end = textarea.selectionEnd;
  const selected = textarea.value.substring(start, end) || 'Votre texte';
  const replacement = (tag === 'ul') 
    ? `\n<ul>\n  <li>${selected}</li>\n</ul>\n` 
    : `<${tag}>${selected}</${tag}>`;
  textarea.setRangeText(replacement, start, end, 'select');
}
</script>
