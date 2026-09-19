<?php
/**
 * Modal Éditeur Exclusivité Voyageur — Guide PDF Personnalisé
 * Règle 3 & 6 : Pas de style inline, fichier compact
 */
?>
<div class="c-modal" id="personalizedPdfModal">
  <div class="c-modal__card c-pdf-modal-card">
    <div class="c-pdf-modal-header">
      <span class="c-pdf-badge-gold">
        ✨ EXCLUSIVITÉ VOYAGEUR • ÉDITION SOUVENIR
      </span>
      <button type="button" data-close-modal="personalizedPdfModal" class="c-pdf-modal-close">&times;</button>
    </div>

    <div class="c-pdf-editor-grid">
      <!-- Live 3D Book Cover Preview -->
      <div class="c-pdf-book-cover">
        <div>
          <div class="c-pdf-cover-badge">✨ Aperçu Couverture HD</div>
          <div class="c-pdf-cover-img-box">
            <img id="previewCoverImg" src="<?= asset('images/guide-djerba-pdf-personnalise-voyage.png') ?>" alt="Exemple de Guide de Voyage Djerba Personnalisé en PDF" class="c-pdf-cover-img">
          </div>
          <h3 id="previewTitle" class="c-pdf-cover-title">Guide Djerba de Marie & Julien</h3>
          <div id="previewDates" class="c-pdf-cover-dates">Séjour du 15 au 22 Octobre 2026</div>
          <div id="previewMessage" class="c-pdf-cover-message-box">
            « Pour notre merveilleux séjour à Djerba, entre plages dorées et souvenirs inoubliables ! »
          </div>
        </div>
        <div class="c-pdf-cover-footer">
          Djerba Voyage • Édition Personnalisée 2026
        </div>
      </div>

      <!-- Formulaire Éditeur -->
      <div>
        <form id="formPersonalizedPdf" onsubmit="submitPersonalizedPdf(event)">
          <div class="c-pdf-form-group">
            <label for="customName" class="c-pdf-label">1. Nom(s) sur la couverture *</label>
            <input type="text" id="customName" placeholder="Ex: Marie & Julien ou Famille Dupont" required class="c-pdf-input">
          </div>

          <div class="c-pdf-form-group">
            <label for="customMessage" class="c-pdf-label">2. Votre message personnel / Dédicace</label>
            <textarea id="customMessage" rows="2" placeholder="Ex: Pour notre voyage de noces magique sous le soleil de Djerba..." class="c-pdf-textarea"></textarea>
          </div>

          <div class="c-pdf-form-group">
            <label class="c-pdf-label">3. Photo de couverture</label>
            <div class="c-pdf-upload-row">
              <label for="customPhotoFile" class="c-pdf-upload-btn">
                <i class="fi fi-rr-camera"></i> Importer ma propre photo
              </label>
              <input type="file" id="customPhotoFile" accept="image/*" class="c-pdf-file-input">
              <span class="c-pdf-upload-hint">ou choisir un spot :</span>
            </div>
            <div class="c-pdf-photo-picker">
              <button type="button" class="c-pdf-photo-thumb is-selected" data-photo="<?= asset('images/guide-djerba-pdf-personnalise-voyage.png') ?>" title="Plage & Menzel VIP">
                <img src="<?= asset('images/guide-djerba-pdf-personnalise-voyage.png') ?>" alt="Guide Personnalisé Djerba Menzel">
              </button>
              <button type="button" class="c-pdf-photo-thumb" data-photo="<?= asset('images/djerbahood.png') ?>" title="Djerbahood">
                <img src="<?= asset('images/djerbahood.png') ?>" alt="Djerbahood">
              </button>
              <button type="button" class="c-pdf-photo-thumb" data-photo="<?= asset('images/sidi_mahres.png') ?>" title="Plage Sidi Mahres">
                <img src="<?= asset('images/sidi_mahres.png') ?>" alt="Sidi Mahres">
              </button>
              <button type="button" class="c-pdf-photo-thumb" data-photo="<?= asset('images/guellala.png') ?>" title="Sunset Guellala">
                <img src="<?= asset('images/guellala.png') ?>" alt="Guellala">
              </button>
              <button type="button" class="c-pdf-photo-thumb" data-photo="<?= asset('images/ajim.png') ?>" title="Port d'Ajim">
                <img src="<?= asset('images/ajim.png') ?>" alt="Ajim">
              </button>
            </div>
          </div>

          <div class="c-pdf-form-group">
            <label for="customDates" class="c-pdf-label">4. Dates de séjour (optionnel)</label>
            <input type="text" id="customDates" placeholder="Ex: Octobre 2026 ou 15 - 22 Octobre" class="c-pdf-input">
          </div>

          <div class="c-pdf-form-group">
            <label for="customEmail" class="c-pdf-label">5. E-mail de réception du PDF *</label>
            <input type="email" id="customEmail" placeholder="votre.email@exemple.com" required class="c-pdf-input">
          </div>

          <div class="c-pdf-actions">
            <button type="button" class="c-pdf-preview-btn" onclick="previewPersonalizedPdf()">
              <i class="fi fi-rr-eye"></i> Prévisualiser Spécimen PDF
            </button>
            <button type="submit" class="c-button c-button--primary c-pdf-submit-btn">
              Commander mon Guide (9,90 €) <i class="fi fi-rr-arrow-right"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="module" src="<?= asset('js/modules/personalized-pdf-editor.js') ?>"></script>
