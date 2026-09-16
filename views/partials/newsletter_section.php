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
          ✨ Cercle Privé Djerba Voyage
        </span>
      </div>

      <h2 class="c-newsletter-title">
        Recevez Nos Pépites, Réductions & Spots Secrets
      </h2>

      <p class="c-newsletter-subtitle">
        Rejoignez notre cercle de plus de 1 450 voyageurs privilégiés. Recevez en avant-première nos réductions secrètes, nos coordonnées GPS confidentielles et nos conseils d'initiés.
      </p>

      <!-- Pass Privilège Immédiat -->
      <div class="c-newsletter-voucher-box">
        <div class="c-newsletter-voucher-info">
          <div class="c-newsletter-voucher-label">🎁 Votre Privilège de Bienvenue Immédiat</div>
          <div class="c-newsletter-voucher-code">CLUB-DJERBA-10</div>
          <div class="c-newsletter-voucher-sub">Code promo envoyé instantanément par e-mail dès validation</div>
        </div>
        <div class="c-newsletter-voucher-tag">
          <i class="fi fi-rr-badge-percent"></i> -10% Immédiat
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
          <input type="email" id="homeNewsletterEmail" name="email" placeholder="Votre adresse e-mail personnelle..." required class="c-newsletter-input">
          <button type="submit" id="homeNewsletterBtn" class="c-newsletter-button">
            <span>Rejoindre le Club VIP</span>
            <i class="fi fi-rr-paper-plane"></i>
          </button>
        </div>
        <p class="c-newsletter-footer-note">
          🔒 Inscription 100% gratuite • Zéro spam garanti • Désinscription en 1 clic
        </p>
      </form>

      <!-- Grille des 4 Avantages Exclusifs -->
      <div class="c-newsletter-perks">
        <div class="c-newsletter-perk-item">
          <i class="fi fi-rr-badge-percent c-newsletter-perk-icon c-newsletter-perk-icon--amber"></i>
          <div class="c-newsletter-perk-title">Code Réduction -10%</div>
          <div class="c-newsletter-perk-desc">Valable sur toutes nos excursions, quads et sorties en mer dès votre confirmation.</div>
        </div>
        <div class="c-newsletter-perk-item">
          <i class="fi fi-rr-map-marker c-newsletter-perk-icon c-newsletter-perk-icon--emerald"></i>
          <div class="c-newsletter-perk-title">Spots Secrets & Criques</div>
          <div class="c-newsletter-perk-desc">Coordonnées GPS des plages sauvages et ateliers traditionnels loin des foules.</div>
        </div>
        <div class="c-newsletter-perk-item">
          <i class="fi fi-rr-restaurant c-newsletter-perk-icon c-newsletter-perk-icon--terracotta"></i>
          <div class="c-newsletter-perk-title">Tables d'Hôtes Secrètes</div>
          <div class="c-newsletter-perk-desc">Les meilleures tables familiales, poissons du jour et dîners sous les palmiers.</div>
        </div>
        <div class="c-newsletter-perk-item">
          <i class="fi fi-rr-shield-check c-newsletter-perk-icon c-newsletter-perk-icon--sky"></i>
          <div class="c-newsletter-perk-title">Conciergerie & Zéro Spam</div>
          <div class="c-newsletter-perk-desc">1 seul e-mail de pépites par mois. Assistance prioritaire pour vos réservations.</div>
        </div>
      </div>

      <!-- Preuve Sociale & Avis Voyageurs -->
      <div class="c-newsletter-proof">
        <span class="c-newsletter-stars">★★★★★</span>
        <span>Recommandé par <strong>1 450+</strong> voyageurs privilégiés à Djerba</span>
      </div>

    </div>
  </div>
</section>
