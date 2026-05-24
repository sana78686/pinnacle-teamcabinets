<div id="sf-back-top" class="sf-back-top" hidden aria-hidden="true">
    <button type="button" class="sf-back-top__btn" id="sf-back-top-btn" aria-label="Back to top">
        <i class="fa-solid fa-chevron-up" aria-hidden="true"></i>
    </button>
</div>

<button type="button" class="sf-chat-fab" id="sf-chat-fab" aria-label="Open chat">
    <i class="fa-solid fa-comments" aria-hidden="true"></i>
</button>

<div id="sf-chat-panel" class="sf-chat-panel" hidden aria-hidden="true" role="dialog" aria-labelledby="sf-chat-title">
    <div class="sf-chat-panel__head">
        <h2 id="sf-chat-title" class="sf-chat-panel__title">Chat with us</h2>
        <button type="button" class="sf-chat-panel__close" id="sf-chat-close" aria-label="Close chat">&times;</button>
    </div>
    <div id="sf-chat-gate" class="sf-chat-gate">
        <p class="sf-chat-gate__lead">Before we start, please tell us who you are.</p>
        <label class="sf-label" for="sf-chat-name">Name</label>
        <input type="text" id="sf-chat-name" class="sf-input" placeholder="Your name" autocomplete="name">
        <label class="sf-label" for="sf-chat-email">Email</label>
        <input type="email" id="sf-chat-email" class="sf-input" placeholder="your@email.com" autocomplete="email">
        <button type="button" class="sf-btn sf-btn--submit" id="sf-chat-start">Start chat</button>
        <p id="sf-chat-gate-error" class="sf-chat-error" hidden></p>
    </div>
    <div id="sf-chat-room" class="sf-chat-room" hidden>
        <div id="sf-chat-messages" class="sf-chat-messages" aria-live="polite"></div>
        <form id="sf-chat-form" class="sf-chat-compose">
            <input type="text" id="sf-chat-input" class="sf-input" placeholder="Type a message…" maxlength="5000" autocomplete="off">
            <button type="submit" class="sf-btn sf-btn--submit sf-btn--sm">Send</button>
        </form>
    </div>
</div>

<script>
    window.STOREFRONT_CHAT = {
        startUrl: @json(route('storefront_chat.start')),
        messagesUrl: @json(route('storefront_chat.messages')),
        sendUrl: @json(route('storefront_chat.send')),
        csrf: @json(csrf_token()),
    };
</script>
<script src="{{ tenant_static_asset('js/storefront-chat.js') }}?v=1"></script>
<script src="{{ tenant_static_asset('js/storefront-chrome.js') }}?v=1"></script>
