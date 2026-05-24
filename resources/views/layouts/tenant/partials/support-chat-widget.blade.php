<div id="support-chat-widget" class="tc-support-widget" v-cloak>
    <button
        type="button"
        class="tc-support-widget__fab"
        :class="{ 'is-open': widgetOpen }"
        :aria-expanded="widgetOpen ? 'true' : 'false'"
        aria-label="Chat with admin"
        title="Chat with admin"
        @click="toggleWidget"
    >
        <i class="icofont" :class="widgetOpen ? 'icofont-close' : 'icofont-speech-comments'"></i>
        <span v-if="unreadCount && !widgetOpen" class="tc-support-widget__badge">@{{ unreadCount > 9 ? '9+' : unreadCount }}</span>
    </button>

    <div v-if="widgetOpen" class="tc-support-widget__panel card tc-dash-card">
        <div class="tc-support-widget__header">
            <div class="tc-support-widget__header-main">
                <div class="tc-chat-avatar tc-chat-avatar--sm" title="Admin support">
                    <span class="tc-chat-avatar__initials">AD</span>
                </div>
                <div>
                    <strong>Chat with Admin</strong>
                    <span v-if="loadingMessages" class="d-block small text-muted">Loading…</span>
                    <span v-else class="d-block small text-muted">We typically reply in a few minutes</span>
                </div>
            </div>
            <div class="tc-support-widget__header-actions">
                <a :href="config.fullPageUrl" class="btn btn-link btn-sm p-0" title="Open full page">Expand</a>
                <button type="button" class="btn-close btn-close-sm" aria-label="Close" @click="closeWidget"></button>
            </div>
        </div>

        <div v-if="flash" class="alert alert-sm mb-0 py-2 px-3 rounded-0" :class="flash.ok ? 'alert-success' : 'alert-danger'" role="alert">@{{ flash.text }}</div>

        <div ref="messagesWrap" class="tc-support-widget__messages" @scroll="onMessagesScroll">
            <div v-if="loadingMessages && !messages.length" class="tc-support-chat__empty"><p class="mb-0">Loading messages…</p></div>
            <div v-else-if="!messages.length" class="tc-support-chat__empty">
                <i class="icofont icofont-speech-comments" aria-hidden="true"></i>
                <p class="mb-0">No messages yet. Say hello!</p>
            </div>
            <div v-for="msg in messages" :key="msg.id" class="tc-support-chat__bubble-row" :class="msg.is_mine ? 'is-mine' : 'is-theirs'">
                <div v-if="!msg.is_mine" class="tc-chat-avatar tc-chat-avatar--sm" :title="msg.user_name">
                    <img v-if="msg.user_avatar?.url" :src="msg.user_avatar.url" :alt="msg.user_name">
                    <span v-else class="tc-chat-avatar__initials">@{{ msg.user_avatar?.initials || 'AD' }}</span>
                </div>
                <div class="tc-support-chat__bubble">
                    <div class="tc-support-chat__bubble-meta">
                        <strong>@{{ msg.user_name }}</strong>
                        <span>@{{ msg.created_at }}</span>
                    </div>
                    <div v-if="msg.message" class="tc-support-chat__bubble-text">@{{ msg.message }}</div>
                    <div v-if="msg.has_attachment" class="tc-support-chat__attachment">
                        <a :href="msg.attachment_url" target="_blank" rel="noopener" class="tc-support-chat__attachment-link">
                            <i class="icofont" :class="attachmentIcon(msg)"></i>
                            @{{ msg.attachment_name || 'Download file' }}
                        </a>
                    </div>
                </div>
                <div v-if="msg.is_mine" class="tc-chat-avatar tc-chat-avatar--sm" :title="msg.user_name">
                    <img v-if="msg.user_avatar?.url" :src="msg.user_avatar.url" :alt="msg.user_name">
                    <span v-else class="tc-chat-avatar__initials">@{{ msg.user_avatar?.initials || 'U' }}</span>
                </div>
            </div>
        </div>

        <div class="tc-support-widget__composer">
            <form @submit.prevent="sendMessage" class="d-flex flex-column gap-2">
                <div v-if="pendingFile" class="tc-support-chat__pending-file">
                    <i class="icofont icofont-attachment"></i>
                    <span>@{{ pendingFile.name }}</span>
                    <button type="button" class="btn btn-link btn-sm text-danger p-0" @click="clearAttachment">Remove</button>
                </div>
                <div class="d-flex gap-2 align-items-end">
                    <label class="btn btn-light btn-sm mb-0 tc-support-chat__attach-btn" title="Attach file">
                        <i class="icofont icofont-attachment"></i>
                        <input ref="fileInput" type="file" class="d-none" @change="onFileSelected" accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx,.zip,.txt,.csv">
                    </label>
                    <textarea
                        v-model="draftMessage"
                        class="form-control form-control-sm"
                        rows="2"
                        maxlength="5000"
                        placeholder="Type a message…"
                        :disabled="sending"
                        @keydown.enter.exact.prevent="sendMessage"
                    ></textarea>
                    <button type="submit" class="btn btn-primary btn-sm" :disabled="sending || (!draftMessage.trim() && !pendingFile)">
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
window.SUPPORT_CHAT_WIDGET_CONFIG = @json(\App\Http\Controllers\TenantSupportChatController::userWidgetConfig(request()));
</script>
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="{{ tenant_static_asset('js/support-chat-widget.js') }}?v=1"></script>
