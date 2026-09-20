<?php
/**
 * Étape Formulaire de Contact IA (Lead Capture)
 * Règle 3 : Pas de style inline - Classes CSS dédiées
 */
?>
<div class="quiz-step c-ai-lead-step" id="quizLeadStep">
    <div class="c-ai-lead-step__header">
        <div class="c-ai-lead-step__badge">
            <i class="fi fi-rr-sparkles"></i> <?= __('quiz_lead.badge') ?>
        </div>
        <h3 class="c-ai-lead-step__title">
            <?= __('quiz_lead.title') ?>
        </h3>
        <p class="c-ai-lead-step__desc">
            <?= __('quiz_lead.desc') ?>
        </p>
    </div>

    <form id="aiLeadForm" class="c-ai-lead-form" onsubmit="handleAiLeadSubmit(event)">
        <!-- Anti-Spam Security Tokens -->
        <input type="text" name="_hp_security" class="c-hp-security-check" tabindex="-1" autocomplete="off" aria-hidden="true">
        <input type="hidden" name="_form_ts" value="<?= time() ?>">

        <div class="c-ai-lead-form__grid">
            <div class="c-ai-lead-form__group">
                <label for="aiLeadName" class="c-ai-lead-form__label"><?= __('quiz_lead.name_label') ?></label>
                <input type="text" id="aiLeadName" name="name" required placeholder="Ex: Jean Dupont" class="c-ai-lead-form__input">
            </div>
            <div class="c-ai-lead-form__group">
                <label for="aiLeadEmail" class="c-ai-lead-form__label"><?= __('quiz_lead.email_label') ?></label>
                <input type="email" id="aiLeadEmail" name="email" required placeholder="Ex: jean.dupont@email.com" class="c-ai-lead-form__input">
            </div>
            <div class="c-ai-lead-form__group">
                <label for="aiLeadPhone" class="c-ai-lead-form__label"><?= __('quiz_lead.phone_label') ?></label>
                <input type="tel" id="aiLeadPhone" name="phone" placeholder="Ex: +33 6 12 34 56 78" class="c-ai-lead-form__input">
            </div>
            <div class="c-ai-lead-form__group">
                <label for="aiLeadDate" class="c-ai-lead-form__label"><?= __('quiz_lead.date_label') ?></label>
                <input type="date" id="aiLeadDate" name="travel_date" class="c-ai-lead-form__input">
            </div>
        </div>

        <div class="c-ai-lead-form__group c-ai-lead-form__group--full">
            <label for="aiLeadNotes" class="c-ai-lead-form__label"><?= __('quiz_lead.notes_label') ?></label>
            <textarea id="aiLeadNotes" name="notes" rows="2" placeholder="Ex: Anniversaire de mariage, préférence chambres calmes, envie de faire du kitesurf..." class="c-ai-lead-form__textarea"></textarea>
        </div>

        <div id="aiLeadFeedback" class="c-ai-lead__feedback"></div>

        <div class="c-ai-lead-form__actions">
            <button type="submit" id="aiLeadSubmitBtn" class="c-button c-button--primary c-ai-lead-form__submit">
                <i class="fi fi-rr-paper-plane"></i> <?= __('quiz_lead.submit_btn') ?>
            </button>
            <button type="button" class="c-ai-lead__skip-btn" onclick="skipLeadStep()">
                <?= __('quiz_lead.skip_btn') ?> <i class="fi fi-rr-arrow-right"></i>
            </button>
        </div>
        <p class="c-ai-lead-form__privacy">
            <?= __('quiz_lead.privacy') ?>
        </p>
    </form>
</div>
