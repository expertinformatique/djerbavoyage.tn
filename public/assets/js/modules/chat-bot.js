/**
 * Module ChatBot IA — Concierge Virtuel Djerba Voyage
 * Règle 6 : Moins de 300 lignes, gestion d'erreurs non bloquante
 */

(function () {
  'use strict';

  var currentLang = document.documentElement.lang || window.LOCALE || 'fr';
  var baseUrl = window.APP_BASE_URL || '';
  var sessionId = sessionStorage.getItem('djerba_chat_session') || ('sess_' + Math.random().toString(36).substring(2, 11));
  sessionStorage.setItem('djerba_chat_session', sessionId);

  var history = [];
  try {
    var stored = sessionStorage.getItem('djerba_chat_history');
    if (stored) history = JSON.parse(stored);
  } catch (e) {
    history = [];
  }

  var widget, messagesBox, chatForm, chatInput, typingIndicator;

  function initChat() {
    widget = document.getElementById('djerbaChatWidget');
    messagesBox = document.getElementById('djerbaChatMessages');
    chatForm = document.getElementById('djerbaChatForm');
    chatInput = document.getElementById('djerbaChatInput');
    typingIndicator = document.getElementById('djerbaChatTyping');

    if (!widget) return;

    var toggleBtn = document.getElementById('djerbaChatToggleBtn');
    var closeBtn = document.getElementById('djerbaChatCloseBtn');
    var clearBtn = document.getElementById('djerbaChatClearBtn');
    var minimizeBtn = document.getElementById('djerbaChatMinimizeBtn');

    if (toggleBtn) toggleBtn.addEventListener('click', toggleChat);
    if (closeBtn) closeBtn.addEventListener('click', closeChat);
    if (clearBtn) clearBtn.addEventListener('click', clearChat);
    if (minimizeBtn) minimizeBtn.addEventListener('click', closeChat);

    // Global triggers (.js-open-chat)
    document.querySelectorAll('.js-open-chat').forEach(function (el) {
      el.addEventListener('click', function (e) {
        e.preventDefault();
        openChat();
        var prompt = el.getAttribute('data-chat-prompt');
        if (prompt) sendUserMessage(prompt);
      });
    });

    if (chatForm) {
      chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var msg = chatInput.value.trim();
        if (msg) {
          sendUserMessage(msg);
          chatInput.value = '';
        }
      });
    }

    // Quick suggestion chips
    document.querySelectorAll('#djerbaChatChips .c-chat-chip').forEach(function (chip) {
      chip.addEventListener('click', function () {
        var prompt = chip.getAttribute('data-prompt');
        if (prompt) sendUserMessage(prompt);
      });
    });

    if (history.length > 0) {
      history.forEach(function (item) {
        appendBubble(item.role, item.content, item.action, item.action_label, item.time, false);
      });
    }

    if (messagesBox) {
      messagesBox.addEventListener('click', handleChatActionClick);
    }
  }

  function openChat() {
    if (!widget) return;
    widget.classList.add('is-open');
    if (chatInput) setTimeout(function () { chatInput.focus(); }, 150);
  }

  function closeChat() {
    if (!widget) return;
    widget.classList.remove('is-open');
  }

  function toggleChat() {
    if (!widget) return;
    if (widget.classList.contains('is-open')) closeChat();
    else openChat();
  }

  function handleChatActionClick(e) {
    var actBtn = e.target.closest('[data-chat-action]');
    if (!actBtn) return;
    var act = actBtn.getAttribute('data-chat-action');

    if (act === 'view_activities') {
      window.location.href = baseUrl + '/activites';
    } else if (act === 'view_pass') {
      window.location.href = baseUrl + '/services';
    } else if (act === 'view_transports') {
      window.location.href = baseUrl + '/transports';
    } else if (act === 'view_hotels') {
      window.location.href = baseUrl + '/hotels-restaurants';
    } else if (act === 'open_custom_stay') {
      window.location.href = baseUrl + '/contact';
    } else if (act === 'submit_lead') {
      submitLeadContact(actBtn);
    }
  }

  function appendBubble(role, text, action, actionLabel, time, save) {
    if (!messagesBox) return;
    var isUser = role === 'user';
    var timeStr = time || (new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));

    var row = document.createElement('div');
    row.className = 'c-chat-msg-row ' + (isUser ? 'c-chat-msg-row--user' : 'c-chat-msg-row--assistant');

    var avatar = isUser ? '' : '<div class="c-chat-avatar-mini">🤖</div>';
    var bubbleClass = isUser ? 'c-chat-bubble c-chat-bubble--user' : 'c-chat-bubble c-chat-bubble--assistant';

    var actionHtml = '';
    if (action === 'ask_contact') {
      actionHtml = '<div class="c-chat-lead-box">' +
        '<div class="c-chat-lead-box__title">📋 ' + (currentLang === 'ar' ? 'بيانات التواصل' : 'Vos coordonnées') + '</div>' +
        '<input type="text" class="c-chat-lead-box__input js-lead-name" placeholder="' + (currentLang === 'ar' ? 'الاسم الكامل *' : 'Votre nom *') + '">' +
        '<input type="email" class="c-chat-lead-box__input js-lead-email" placeholder="' + (currentLang === 'ar' ? 'البريد الإلكتروني *' : 'Email *') + '">' +
        '<input type="tel" class="c-chat-lead-box__input js-lead-phone" placeholder="' + (currentLang === 'ar' ? 'الهاتف أو واتساب' : 'Téléphone / WhatsApp') + '">' +
        '<button type="button" class="c-chat-lead-box__btn" data-chat-action="submit_lead">✓ ' + (currentLang === 'ar' ? 'إرسال' : 'Enregistrer mes coordonnées') + '</button>' +
      '</div>';
    } else if (action && actionLabel) {
      actionHtml = '<button type="button" class="c-chat-action-btn" data-chat-action="' + escapeHtml(action) + '">' + escapeHtml(actionLabel) + '</button>';
    }

    row.innerHTML = (isUser ? '' : avatar) +
      '<div>' +
        '<div class="' + bubbleClass + '">' +
          '<p>' + escapeHtml(text) + '</p>' +
          actionHtml +
        '</div>' +
        '<span class="c-chat-timestamp ' + (isUser ? 'c-chat-timestamp--right' : '') + '">' + timeStr + '</span>' +
      '</div>';

    messagesBox.appendChild(row);
    messagesBox.scrollTop = messagesBox.scrollHeight;

    if (save) {
      history.push({ role: role, content: text, action: action, action_label: actionLabel, time: timeStr });
      sessionStorage.setItem('djerba_chat_history', JSON.stringify(history));
    }
  }

  async function sendUserMessage(text) {
    appendBubble('user', text, null, null, null, true);
    if (typingIndicator) typingIndicator.classList.remove('u-hidden');
    messagesBox.scrollTop = messagesBox.scrollHeight;

    var endpoint = baseUrl ? (baseUrl + '/api/chat') : '/api/chat';

    try {
      var res = await fetch(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          action: 'message',
          message: text,
          session_id: sessionId,
          history: history,
          lang: currentLang
        })
      });

      if (!res.ok) {
        // Fallback endpoint public/api/chat.php
        res = await fetch((baseUrl ? (baseUrl + '/api/chat.php') : '/api/chat.php'), {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'message', message: text, session_id: sessionId, history: history, lang: currentLang })
        });
      }

      var data = await res.json();
      if (typingIndicator) typingIndicator.classList.add('u-hidden');

      if (data && data.success && data.reply) {
        appendBubble('assistant', data.reply, data.action, data.action_label, null, true);
      } else {
        appendBubble('assistant', "Désolé, une erreur est survenue. N'hésitez pas à nous contacter par e-mail à reservation@djerbavoyage.tn.", null, null, null, false);
      }
    } catch (err) {
      if (typingIndicator) typingIndicator.classList.add('u-hidden');
      appendBubble('assistant', "Connexion momentanément interrompue. Notre équipe reste joignable à reservation@djerbavoyage.tn.", null, null, null, false);
    }
  }

  async function submitLeadContact(btn) {
    var box = btn.closest('.c-chat-lead-box');
    if (!box) return;
    var name = (box.querySelector('.js-lead-name') || {}).value || '';
    var email = (box.querySelector('.js-lead-email') || {}).value || '';
    var phone = (box.querySelector('.js-lead-phone') || {}).value || '';

    if (!name.trim() || !email.trim()) {
      box.insertAdjacentHTML('beforeend', '<div class="c-chat-lead-box__error">' + (currentLang === 'ar' ? 'يرجى إدخال الاسم والبريد' : 'Veuillez saisir votre nom et email.') + '</div>');
      return;
    }

    btn.disabled = true;
    btn.textContent = '...';

    var endpoint = baseUrl ? (baseUrl + '/api/chat') : '/api/chat';
    try {
      var res = await fetch(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          action: 'save_contact',
          session_id: sessionId,
          client_name: name.trim(),
          client_email: email.trim(),
          client_phone: phone.trim(),
          history: history,
          lang: currentLang
        })
      });
      var data = await res.json();
      box.innerHTML = '<div class="c-chat-lead-box__success">✓ ' + escapeHtml(data.reply || 'Coordonnées enregistrées.') + '</div>';
    } catch (e) {
      btn.disabled = false;
      btn.textContent = 'Réessayer';
    }
  }

  function clearChat() {
    var welcome = document.getElementById('djerbaChatWelcomeMsg');
    if (messagesBox && welcome) {
      messagesBox.innerHTML = '';
      messagesBox.appendChild(welcome);
    }
    history = [];
    try { sessionStorage.removeItem('djerba_chat_history'); } catch (e) {}
    var oldSess = sessionId;
    sessionId = 'sess_' + Math.random().toString(36).substring(2, 11);
    try { sessionStorage.setItem('djerba_chat_session', sessionId); } catch (e) {}

    var endpoint = baseUrl ? (baseUrl + '/api/chat') : '/api/chat';
    fetch(endpoint, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'archive', session_id: oldSess })
    }).catch(function () {});
  }

  function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
  }

  window.djerbaChat = {
    open: openChat,
    close: closeChat,
    toggle: toggleChat,
    clear: clearChat,
    send: sendUserMessage
  };

  document.addEventListener('DOMContentLoaded', initChat);
})();
