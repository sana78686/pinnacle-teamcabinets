<div v-if="(config.isAdmin && selectedThreadId) || !config.isAdmin" class="tc-support-chat__body">
    <div ref="messagesWrap" class="tc-support-chat__messages" @scroll="onMessagesScroll">
        <div v-if="loadingMessages && !messages.length" class="tc-support-chat__empty"><p class="mb-0">Loading messages…</p></div>
        <div v-else-if="!messages.length" class="tc-support-chat__empty">
            <i class="icofont icofont-speech-comments" aria-hidden="true"></i>
            <p class="mb-0">No messages yet. Say hello or attach a file.</p>
        </div>
        <div v-for="msg in messages" :key="msg.id" class="tc-support-chat__bubble-row" :class="msg.is_mine ? 'is-mine' : 'is-theirs'">
            <div v-if="!msg.is_mine" class="tc-chat-avatar tc-chat-avatar--sm" :title="msg.user_name">
                <img v-if="msg.user_avatar?.url" :src="msg.user_avatar.url" :alt="msg.user_name">
                <span v-else class="tc-chat-avatar__initials">@{{ msg.user_avatar?.initials || 'U' }}</span>
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
                <button v-if="config.isAdmin || msg.is_mine" type="button" class="tc-support-chat__bubble-delete btn btn-link btn-sm text-danger p-0" title="Delete message" @click="deleteMessage(msg.id)">Delete</button>
            </div>
            <div v-if="msg.is_mine" class="tc-chat-avatar tc-chat-avatar--sm" :title="msg.user_name">
                <img v-if="msg.user_avatar?.url" :src="msg.user_avatar.url" :alt="msg.user_name">
                <span v-else class="tc-chat-avatar__initials">@{{ msg.user_avatar?.initials || 'U' }}</span>
            </div>
        </div>
    </div>

    <div class="tc-support-chat__composer">
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
                    class="form-control"
                    rows="2"
                    maxlength="5000"
                    placeholder="Type your message…"
                    :disabled="sending"
                    @keydown.enter.exact.prevent="sendMessage"
                ></textarea>
                <button type="submit" class="btn btn-primary" :disabled="sending || (!draftMessage.trim() && !pendingFile)">
                    Send
                </button>
            </div>
        </form>
    </div>
</div>
