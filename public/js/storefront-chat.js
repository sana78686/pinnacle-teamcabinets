(function () {
    'use strict';

    var cfg = window.STOREFRONT_CHAT;
    if (!cfg) return;

    var fab = document.getElementById('sf-chat-fab');
    var panel = document.getElementById('sf-chat-panel');
    var closeBtn = document.getElementById('sf-chat-close');
    var gate = document.getElementById('sf-chat-gate');
    var room = document.getElementById('sf-chat-room');
    var startBtn = document.getElementById('sf-chat-start');
    var gateError = document.getElementById('sf-chat-gate-error');
    var nameInput = document.getElementById('sf-chat-name');
    var emailInput = document.getElementById('sf-chat-email');
    var messagesEl = document.getElementById('sf-chat-messages');
    var form = document.getElementById('sf-chat-form');
    var input = document.getElementById('sf-chat-input');

    var token = localStorage.getItem('sf_chat_token') || '';
    var pollTimer = null;

    function isOpen() {
        return panel && panel.classList.contains('is-open');
    }

    function headers(json) {
        var h = {
            Accept: 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': cfg.csrf,
        };
        if (token) {
            h['X-Storefront-Chat-Token'] = token;
        }
        if (json) {
            h['Content-Type'] = 'application/json';
        }
        return h;
    }

    function openPanel() {
        if (!panel) return;
        panel.hidden = false;
        panel.classList.add('is-open');
        panel.setAttribute('aria-hidden', 'false');
        if (token) {
            showRoom();
            loadMessages();
            startPolling();
        }
    }

    function closePanel(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        if (!panel) return;
        panel.hidden = true;
        panel.classList.remove('is-open');
        panel.setAttribute('aria-hidden', 'true');
        stopPolling();
    }

    function togglePanel() {
        if (isOpen()) {
            closePanel();
        } else {
            openPanel();
        }
    }

    function showRoom() {
        if (gate) gate.hidden = true;
        if (room) room.hidden = false;
    }

    function renderMessages(list) {
        if (!messagesEl) return;
        messagesEl.innerHTML = '';
        (list || []).forEach(function (msg) {
            var div = document.createElement('div');
            div.className = 'sf-chat-bubble ' + (msg.is_mine ? 'sf-chat-bubble--mine' : 'sf-chat-bubble--them');
            div.innerHTML = '<div>' + escapeHtml(msg.message || '') + '</div><div class="sf-chat-bubble__meta">' + escapeHtml(msg.created_at || '') + '</div>';
            messagesEl.appendChild(div);
        });
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    function escapeHtml(s) {
        var d = document.createElement('div');
        d.textContent = s;
        return d.innerHTML;
    }

    async function loadMessages() {
        try {
            var res = await fetch(cfg.messagesUrl, { headers: headers(false) });
            var data = await res.json();
            renderMessages(data.data || []);
        } catch (e) {
            /* ignore */
        }
    }

    async function startChat() {
        var name = (nameInput && nameInput.value || '').trim();
        var email = (emailInput && emailInput.value || '').trim();
        if (!name || !email) {
            if (gateError) {
                gateError.textContent = 'Please enter your name and email.';
                gateError.hidden = false;
            }
            return;
        }
        if (gateError) gateError.hidden = true;
        startBtn.disabled = true;
        try {
            var res = await fetch(cfg.startUrl, {
                method: 'POST',
                headers: headers(true),
                body: JSON.stringify({ name: name, email: email }),
            });
            var data = await res.json();
            if (!res.ok) throw new Error(data.message || 'Could not start chat');
            token = data.token;
            localStorage.setItem('sf_chat_token', token);
            showRoom();
            await loadMessages();
            startPolling();
        } catch (err) {
            if (gateError) {
                gateError.textContent = err.message || 'Could not start chat.';
                gateError.hidden = false;
            }
        } finally {
            startBtn.disabled = false;
        }
    }

    async function sendMessage(text) {
        var res = await fetch(cfg.sendUrl, {
            method: 'POST',
            headers: headers(true),
            body: JSON.stringify({ message: text, token: token }),
        });
        var data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Send failed');
        if (data.token) {
            token = data.token;
            localStorage.setItem('sf_chat_token', token);
        }
        await loadMessages();
    }

    function startPolling() {
        stopPolling();
        pollTimer = window.setInterval(loadMessages, 5000);
    }

    function stopPolling() {
        if (pollTimer) {
            window.clearInterval(pollTimer);
            pollTimer = null;
        }
    }

    if (fab) {
        fab.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            togglePanel();
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closePanel);
    }

    if (panel) {
        var head = panel.querySelector('.sf-chat-panel__head');
        if (head) {
            head.addEventListener('click', function (e) {
                if (e.target.closest('.sf-chat-panel__close, #sf-chat-close')) {
                    closePanel(e);
                }
            });
        }
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && isOpen()) {
            closePanel();
        }
    });

    if (startBtn) startBtn.addEventListener('click', startChat);

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var text = (input && input.value || '').trim();
            if (!text) return;
            input.disabled = true;
            sendMessage(text).then(function () {
                input.value = '';
            }).catch(function () {
                /* ignore */
            }).finally(function () {
                input.disabled = false;
                input.focus();
            });
        });
    }

    if (token) {
        showRoom();
    }
})();
