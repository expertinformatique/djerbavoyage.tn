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
        <?= __('pdf_modal.badge') ?>
      </span>
      <button type="button" data-close-modal="personalizedPdfModal" class="c-pdf-modal-close">&times;</button>
    </div>

    <div class="c-pdf-editor-grid">
      <!-- Live 3D Book Cover Preview -->
      <div class="c-pdf-book-cover">
        <div>
          <div class="c-pdf-cover-badge"><?= __('pdf_modal.preview_badge') ?></div>
          <div class="c-pdf-cover-img-box">
            <img id="previewCoverImg" src="<?= asset('images/guide-djerba-pdf-personnalise-voyage.png') ?>" alt="Exemple de Guide de Voyage Djerba Personnalisé en PDF" class="c-pdf-cover-img">
          </div>
          <h3 id="previewTitle" class="c-pdf-cover-title"><?= __('pdf_modal.sample_title') ?></h3>
          <div id="previewDates" class="c-pdf-cover-dates"><?= __('pdf_modal.sample_dates') ?></div>
          <div id="previewMessage" class="c-pdf-cover-message-box">
            <?= __('pdf_modal.sample_message') ?>
          </div>
        </div>
        <div class="c-pdf-cover-footer">
          <?= __('pdf_modal.cover_footer') ?>
        </div>
      </div>

      <!-- Formulaire Éditeur -->
      <div>
        <form id="formPersonalizedPdf" onsubmit="submitPersonalizedPdf(event)">
          <div class="c-pdf-form-group">
            <label for="customName" class="c-pdf-label"><?= __('pdf_modal.label_name') ?></label>
            <input type="text" id="customName" placeholder="<?= __('pdf_modal.placeholder_name') ?>" required class="c-pdf-input">
          </div>

          <div class="c-pdf-form-group">
            <label for="customMessage" class="c-pdf-label"><?= __('pdf_modal.label_message') ?></label>
            <textarea id="customMessage" rows="2" placeholder="<?= __('pdf_modal.placeholder_message') ?>" class="c-pdf-textarea"></textarea>
          </div>

          <div class="c-pdf-form-group">
            <label class="c-pdf-label"><?= __('pdf_modal.label_photo') ?></label>
            <div class="c-pdf-upload-row">
              <label for="customPhotoFile" class="c-pdf-upload-btn">
                <i class="fi fi-rr-camera"></i> <?= __('pdf_modal.upload_btn') ?>
              </label>
              <input type="file" id="customPhotoFile" accept="image/*" class="c-pdf-file-input">
              <span class="c-pdf-upload-hint"><?= __('pdf_modal.or_choose_spot') ?></span>
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
            <label for="customDates" class="c-pdf-label"><?= __('pdf_modal.label_dates') ?></label>
            <input type="text" id="customDates" placeholder="<?= __('pdf_modal.placeholder_dates') ?>" class="c-pdf-input">
          </div>

          <div class="c-pdf-form-group">
            <label for="customEmail" class="c-pdf-label"><?= __('pdf_modal.label_email') ?></label>
            <input type="email" id="customEmail" placeholder="votre.email@exemple.com" required class="c-pdf-input">
          </div>

          <div class="c-pdf-actions">
            <button type="button" class="c-pdf-preview-btn" onclick="previewPersonalizedPdf()">
              <i class="fi fi-rr-eye"></i> <?= __('pdf_modal.preview_btn') ?>
            </button>
            <button type="submit" class="c-button c-button--primary c-pdf-submit-btn">
              <?= __('pdf_modal.submit_btn', ['price' => money(9.90)]) ?> <i class="fi fi-rr-arrow-right"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="module" src="<?= asset('js/modules/personalized-pdf-editor.js') ?>"></script>
