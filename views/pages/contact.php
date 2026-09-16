<?php
/**
 * Page Contact — Djerba Voyage (Multilingue)
 * Règle 3 : Zéro style inline
 */
?>
<div class="l-container c-contact-page">
  <div class="c-contact-header">
    <span class="c-contact-badge"><?= __('contact.question_badge') ?></span>
    <h1 class="c-contact-title"><?= __('contact.title') ?></h1>
    <p class="c-contact-subtitle">
      <?= __('contact.subtitle') ?>
    </p>
  </div>

  <?php if (!empty($result)): ?>
    <div class="c-contact-alert <?= $result['success'] ? 'c-contact-alert--success' : 'c-contact-alert--error' ?>">
      <i class="fi fi-rr-<?= $result['success'] ? 'check-circle' : 'cross-circle' ?>"></i> <?= e($result['message']) ?>
    </div>
  <?php endif; ?>

  <div class="c-contact-grid">
    <!-- Formulaire de contact -->
    <div class="c-contact-card">
      <form method="POST" action="<?= url('/contact') ?>">
        <!-- Anti-Spam Security Tokens -->
        <input type="text" name="_hp_security" class="c-hp-security-check" tabindex="-1" autocomplete="off" aria-hidden="true">
        <input type="hidden" name="_form_ts" value="<?= time() ?>">

        <div class="c-contact-form-group">
          <label for="contactName" class="c-contact-label"><?= __('contact.name') ?></label>
          <input type="text" id="contactName" name="name" required placeholder="<?= e(__('contact.name_placeholder')) ?>" class="c-contact-input">
        </div>

        <div class="c-contact-form-group">
          <label for="contactEmail" class="c-contact-label"><?= __('contact.email') ?></label>
          <input type="email" id="contactEmail" name="email" required placeholder="<?= e(__('contact.email_placeholder')) ?>" class="c-contact-input">
        </div>

        <div class="c-contact-form-group">
          <label for="contactPhone" class="c-contact-label"><?= __('contact.phone') ?></label>
          <input type="tel" id="contactPhone" name="phone" placeholder="<?= e(__('contact.phone_placeholder')) ?>" class="c-contact-input">
        </div>

        <div class="c-contact-form-group">
          <label for="contactSubject" class="c-contact-label"><?= __('contact.subject') ?></label>
          <select id="contactSubject" name="subject" class="c-contact-select">
            <option value="concierge"><?= __('contact.subject_concierge') ?></option>
            <option value="pass"><?= __('contact.subject_pass') ?></option>
            <option value="shop"><?= __('contact.subject_shop') ?></option>
            <option value="transfer"><?= __('contact.subject_transfer') ?></option>
            <option value="other"><?= __('contact.subject_other') ?></option>
          </select>
        </div>

        <div class="c-contact-form-group">
          <label for="contactMessage" class="c-contact-label"><?= __('contact.message') ?></label>
          <textarea id="contactMessage" name="message" rows="5" required placeholder="<?= e(__('contact.message_placeholder')) ?>" class="c-contact-textarea"></textarea>
        </div>

        <button type="submit" class="c-button c-button--primary c-contact-submit">
          <i class="fi fi-rr-paper-plane"></i> <?= __('contact.submit') ?>
        </button>
      </form>
    </div>

    <!-- Coordonnées & Infos directes -->
    <div class="c-contact-info-col">
      <div class="c-contact-info-card">
        <div class="c-contact-info-icon-box c-contact-info-icon-box--terracotta">
          <i class="fi fi-rr-envelope"></i>
        </div>
        <div>
          <h3 class="c-contact-info-title"><?= __('contact.email_info_title') ?></h3>
          <p class="c-contact-info-text">
            <a href="mailto:reservation@djerbavoyage.tn" class="c-contact-info-link">reservation@djerbavoyage.tn</a><br>
            <?= __('contact.email_reply') ?>
          </p>
        </div>
      </div>

      <div class="c-contact-info-card">
        <div class="c-contact-info-icon-box c-contact-info-icon-box--emerald">
          <i class="fi fi-rr-phone-call"></i>
        </div>
        <div>
          <h3 class="c-contact-info-title"><?= __('contact.phone_title') ?></h3>
          <p class="c-contact-info-text">
            <a href="tel:+353896110430" class="c-contact-info-link">🇮🇪 +353 89 611 0430</a><br>
            <a href="tel:+21622168875" class="c-contact-info-link">🇹🇳 +216 22 168 875</a><br>
            <?= __('contact.phone_available') ?>
          </p>
        </div>
      </div>

      <div class="c-contact-info-card">
        <div class="c-contact-info-icon-box c-contact-info-icon-box--emerald">
          <i class="fi fi-rr-time-fast"></i>
        </div>
        <div>
          <h3 class="c-contact-info-title"><?= __('contact.hours_title') ?></h3>
          <p class="c-contact-info-text">
            <?= __('contact.hours_text') ?><br>
            <?= __('contact.hours_whatsapp') ?>
          </p>
        </div>
      </div>

      <div class="c-contact-info-card">
        <div class="c-contact-info-icon-box c-contact-info-icon-box--sky">
          <i class="fi fi-rr-marker"></i>
        </div>
        <div>
          <h3 class="c-contact-info-title"><?= __('contact.location_title') ?></h3>
          <p class="c-contact-info-text">
            <?= __('contact.location_text') ?><br>
            <?= __('contact.location_country') ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
