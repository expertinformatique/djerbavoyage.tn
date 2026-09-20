<?php
/**
 * Module Section Newsletter & Club Privé VIP
 * Règle 1, 3, 4, 6 : MVC, 0 inline style, Responsive, < 200 lignes
 */
?>
<section class="c-newsletter-section">
  <div class="l-container">
    <div class="c-newsletter-card">
      
      <div class="c-newsletter-icon-wrap">
        <i class="fi fi-rr-crown"></i>
      </div>

      <div>
        <span class="c-newsletter-badge">
          <?= __('newsletter.badge') ?>
        </span>
      </div>

      <h2 class="c-newsletter-title">
        <?= __('newsletter.title') ?>
      </h2>

      <p class="c-newsletter-subtitle">
        <?= __('newsletter.subtitle') ?>
      </p>

      <!-- Pass Privilège Immédiat -->
      <div class="c-newsletter-voucher-box">
        <div class="c-newsletter-voucher-info">
          <div class="c-newsletter-voucher-label"><?= __('newsletter.voucher_label') ?></div>
          <div class="c-newsletter-voucher-code"><?= __('newsletter.voucher_code') ?></div>
          <div class="c-newsletter-voucher-sub"><?= __('newsletter.voucher_sub') ?></div>
        </div>
        <div class="c-newsletter-voucher-tag">
          <i class="fi fi-rr-badge-percent"></i> <?= __('newsletter.voucher_tag') ?>
        </div>
      </div>

      <!-- Feedback AJAX -->
      <div id="newsletterFeedback" class="c-newsletter-alert c-newsletter-feedback-box"></div>

      <!-- Formulaire d'inscription -->
      <form id="homeNewsletterForm" method="POST" action="<?= url('/newsletter') ?>" class="c-newsletter-form">
        <!-- Anti-Spam Security Tokens -->
        <input type="text" name="_hp_security" class="c-hp-security-check" tabindex="-1" autocomplete="off" aria-hidden="true">
        <input type="hidden" name="_form_ts" value="<?= time() ?>">

        <div class="c-newsletter-form-group">
          <input type="email" id="homeNewsletterEmail" name="email" placeholder="<?= __('newsletter.placeholder') ?>" required class="c-newsletter-input">
          <button type="submit" id="homeNewsletterBtn" class="c-newsletter-button">
            <span><?= __('newsletter.btn') ?></span>
            <i class="fi fi-rr-paper-plane"></i>
          </button>
        </div>
        <p class="c-newsletter-footer-note">
          <?= __('newsletter.footer_note') ?>
        </p>
      </form>

      <!-- Grille des 4 Avantages Exclusifs -->
      <div class="c-newsletter-perks">
        <div class="c-newsletter-perk-item">
          <i class="fi fi-rr-badge-percent c-newsletter-perk-icon c-newsletter-perk-icon--amber"></i>
          <div class="c-newsletter-perk-title"><?= __('newsletter.perk1_title') ?></div>
          <div class="c-newsletter-perk-desc"><?= __('newsletter.perk1_desc') ?></div>
        </div>
        <div class="c-newsletter-perk-item">
          <i class="fi fi-rr-map-marker c-newsletter-perk-icon c-newsletter-perk-icon--emerald"></i>
          <div class="c-newsletter-perk-title"><?= __('newsletter.perk2_title') ?></div>
          <div class="c-newsletter-perk-desc"><?= __('newsletter.perk2_desc') ?></div>
        </div>
        <div class="c-newsletter-perk-item">
          <i class="fi fi-rr-restaurant c-newsletter-perk-icon c-newsletter-perk-icon--terracotta"></i>
          <div class="c-newsletter-perk-title"><?= __('newsletter.perk3_title') ?></div>
          <div class="c-newsletter-perk-desc"><?= __('newsletter.perk3_desc') ?></div>
        </div>
        <div class="c-newsletter-perk-item">
          <i class="fi fi-rr-shield-check c-newsletter-perk-icon c-newsletter-perk-icon--sky"></i>
          <div class="c-newsletter-perk-title"><?= __('newsletter.perk4_title') ?></div>
          <div class="c-newsletter-perk-desc"><?= __('newsletter.perk4_desc') ?></div>
        </div>
      </div>

      <!-- Preuve Sociale & Avis Voyageurs -->
      <div class="c-newsletter-proof">
        <span class="c-newsletter-stars">★★★★★</span>
        <span><?= __('newsletter.proof', ['count' => '<strong>1 450+</strong>']) ?></span>
      </div>

    </div>
  </div>
</section>
