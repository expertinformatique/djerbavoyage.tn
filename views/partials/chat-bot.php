<?php
/**
 * Composant ChatBot IA — Concierge Virtuel Djerba Voyage
 * Règle 1, 3 & 4 : Vue minimale, zéro style inline, 100% responsive & accessible
 */
$welcomeMsg = match(\Core\Lang::getLocale()) {
    'ar' => "مرحباً بكم في جربة فواياج ! أنا مرشدكم الذكي 🤖. كيف يمكنني مساعدتكم في تنظيم رحلاتكم، كواد، رحلات بحرية، أو النقل من المطار ؟",
    'en' => "Hello and welcome to Djerba Voyage! I am your AI Concierge 🤖. How can I help you plan your excursions, quad tours, hotels, or airport shuttles?",
    default => "Bonjour et bienvenue à Djerba ! Je suis votre Concierge Virtuel 🤖. Comment puis-je vous aider (excursions en mer, quads, Pass Expérience, hôtels ou navettes) ?"
};
?>
<!-- Bouton Lanceur Flottant -->
<div id="djerbaChatLauncher" class="c-chat-launcher">
  <button type="button" id="djerbaChatToggleBtn" class="c-chat-launcher__btn" aria-label="<?= __('chat.open_concierge', 'Ouvrir le Concierge IA') ?>">
    <span class="c-chat-launcher__pulse-wrapper">
      <span class="c-chat-launcher__pulse"></span>
      <span class="c-chat-launcher__dot"></span>
    </span>
    <span>🤖</span>
    <span><?= __('chat.bot_name', 'Djerba IA') ?></span>
    <span class="c-chat-launcher__badge">24/7</span>
  </button>
</div>

<!-- Panneau Flottant du ChatBot -->
<div id="djerbaChatWidget" class="c-chat-widget" role="dialog" aria-modal="false" aria-labelledby="djerbaChatTitle">
  <!-- En-tête -->
  <div class="c-chat-header">
    <div class="c-chat-header__profile">
      <div class="c-chat-header__avatar">
        🤖
        <span class="c-chat-header__avatar-status"></span>
      </div>
      <div>
        <h3 id="djerbaChatTitle" class="c-chat-header__title">
          <span><?= __('chat.title', 'Concierge IA Djerba') ?></span>
          <span class="c-chat-header__status-badge"><?= __('chat.online_badge', 'EN LIGNE') ?></span>
        </h3>
        <p class="c-chat-header__subtitle"><?= __('chat.subtitle', 'Conseiller voyage & réservations directes') ?></p>
      </div>
    </div>
    <div class="c-chat-header__controls">
      <button type="button" id="djerbaChatClearBtn" class="c-chat-header__btn c-chat-header__btn--danger" title="<?= __('chat.clear', 'Effacer la discussion') ?>" aria-label="<?= __('chat.clear', 'Effacer') ?>">
        <i class="fi fi-rr-trash"></i>
      </button>
      <button type="button" id="djerbaChatMinimizeBtn" class="c-chat-header__btn" title="<?= __('chat.minimize', 'Réduire') ?>" aria-label="<?= __('chat.minimize', 'Réduire') ?>">
        —
      </button>
      <button type="button" id="djerbaChatCloseBtn" class="c-chat-header__btn" title="<?= __('chat.close', 'Fermer') ?>" aria-label="<?= __('chat.close', 'Fermer') ?>">
        ✕
      </button>
    </div>
  </div>

  <!-- Flux des messages -->
  <div id="djerbaChatMessages" class="c-chat-messages">
    <!-- Message d'accueil par défaut -->
    <div id="djerbaChatWelcomeMsg" class="c-chat-msg-row c-chat-msg-row--assistant">
      <div class="c-chat-avatar-mini">🤖</div>
      <div>
        <div class="c-chat-bubble c-chat-bubble--assistant">
          <p><?= htmlspecialchars($welcomeMsg) ?></p>
          <!-- Suggestions rapides (Chips) -->
          <div id="djerbaChatChips" class="c-chat-chips">
            <button type="button" class="c-chat-chip" data-prompt="<?= __('chat.chip_activities_prompt', 'Quelles sont les meilleures excursions et sorties en quad ?') ?>">
              <?= __('chat.chip_activities', '🌴 Excursions & Quads') ?>
            </button>
            <button type="button" class="c-chat-chip" data-prompt="<?= __('chat.chip_pass_prompt', 'Comment fonctionne le Pass Djerba Expérience ?') ?>">
              <?= __('chat.chip_pass', '🎟️ Pass Djerba Expérience') ?>
            </button>
            <button type="button" class="c-chat-chip" data-prompt="<?= __('chat.chip_transfers_prompt', 'Comment réserver une navette depuis l\'aéroport de Djerba ?') ?>">
              <?= __('chat.chip_transfers', '🚗 Navette Aéroport') ?>
            </button>
            <button type="button" class="c-chat-chip" data-prompt="<?= __('chat.chip_hotels_prompt', 'Quels sont les meilleurs hôtels et maisons d\'hôtes à Djerba ?') ?>">
              <?= __('chat.chip_hotels', '🏨 Hôtels & Djerbahood') ?>
            </button>
          </div>
        </div>
        <span class="c-chat-timestamp"><?= date('H:i') ?></span>
      </div>
    </div>
  </div>

  <!-- Indicateur d'écriture -->
  <div id="djerbaChatTyping" class="c-chat-typing u-hidden">
    <span class="c-chat-typing__dot"></span>
    <span><?= __('chat.typing', 'Le Concierge IA consulte le guide...') ?></span>
  </div>

  <!-- Barre de saisie -->
  <form id="djerbaChatForm" class="c-chat-input-bar">
    <input 
      type="text" 
      id="djerbaChatInput" 
      placeholder="<?= e(__('chat.input_placeholder', 'Posez votre question (quads, bateau pirate, pass, navette...)')) ?>" 
      class="c-chat-input-field" 
      autocomplete="off" 
      required
    >
    <button type="submit" class="c-chat-send-btn" aria-label="<?= __('chat.send', 'Envoyer') ?>">
      <i class="fi fi-rr-paper-plane"></i>
    </button>
  </form>
</div>

<!-- Script client du Chatbot -->
<script src="<?= asset('js/modules/chat-bot.js') ?>"></script>
