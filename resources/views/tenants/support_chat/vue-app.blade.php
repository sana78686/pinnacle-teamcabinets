<div id="support-chat-app" class="tc-support-chat" v-cloak>
    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card tc-support-chat__sidebar h-100">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">@{{ config.isAdmin ? 'Support conversations' : 'My support tickets' }}</h5>
                    <button v-if="!config.isAdmin" type="button" class="btn btn-info btn-sm" @click="showNewThread = !showNewThread">
                        <i class="icofont icofont-plus"></i> New
                    </button>
                </div>

                <div v-if="showNewThread && !config.isAdmin" class="card-body border-bottom py-3">
                    <label class="form-label mb-1">Subject</label>
                    <input v-model="newThreadTitle" type="text" class="form-control form-control-sm mb-2" maxlength="255" placeholder="What do you need help with?">
                    <label class="form-label mb-1">First message (optional)</label>
                    <textarea v-model="newThreadMessage" class="form-control form-control-sm mb-2" rows="2" maxlength="5000" placeholder="Describe your issue…"></textarea>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary btn-sm" :disabled="creatingThread || !newThreadTitle.trim()" @click="createThread">Create ticket</button>
                        <button type="button" class="btn btn-light btn-sm" @click="showNewThread = false">Cancel</button>
                    </div>
                </div>

                <div class="card-body border-bottom py-2">
                    <input v-model="threadSearch" type="search" class="form-control form-control-sm" placeholder="Search…" @keyup.enter="loadThreads(1)">
                </div>

                <div class="tc-support-chat__thread-list">
                    <div v-if="loadingThreads" class="text-center text-muted py-4">Loading…</div>
                    <div v-else-if="!threads.length" class="text-center text-muted py-4">No conversations yet.</div>
                    <button
                        v-for="thread in threads"
                        :key="thread.id"
                        type="button"
                        class="tc-support-chat__thread-item"
                        :class="{ 'is-active': selectedThreadId === thread.id, 'has-unread': thread.unread_count > 0 }"
                        @click="selectThread(thread.id)"
                    >
                        <div class="tc-support-chat__thread-title">
                            <span>@{{ config.isAdmin ? (thread.user_name || 'User') : (thread.title || 'Support') }}</span>
                            <span v-if="thread.unread_count > 0" class="badge rounded-pill bg-danger">@{{ thread.unread_count }}</span>
                        </div>
                        <div v-if="config.isAdmin" class="tc-support-chat__thread-sub">@{{ thread.title || 'Support request' }}</div>
                        <div class="tc-support-chat__thread-meta">@{{ thread.created_at }}</div>
                        <button
                            v-if="config.isAdmin"
                            type="button"
                            class="tc-support-chat__thread-delete btn btn-link btn-sm text-danger p-0"
                            title="Delete thread"
                            @click.stop="deleteThread(thread.id)"
                        >
                            <i class="icofont icofont-trash"></i>
                        </button>
                    </button>
                </div>

                <div v-if="threadPagination.last_page > 1" class="card-footer py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-light btn-sm" :disabled="threadPagination.current_page <= 1" @click="loadThreads(threadPagination.current_page - 1)">Prev</button>
                        <span class="small text-muted">@{{ threadPagination.current_page }} / @{{ threadPagination.last_page }}</span>
                        <button type="button" class="btn btn-light btn-sm" :disabled="threadPagination.current_page >= threadPagination.last_page" @click="loadThreads(threadPagination.current_page + 1)">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card tc-support-chat__panel h-100">
                <div class="card-header py-3">
                    <h5 class="mb-0">
                        <template v-if="selectedThread">
                            @{{ config.isAdmin ? (selectedThread.user_name || 'User') : (selectedThread.title || 'Support') }}
                        </template>
                        <template v-else>Select a conversation</template>
                    </h5>
                </div>

                <div v-if="!selectedThreadId" class="card-body d-flex align-items-center justify-content-center text-muted" style="min-height:420px">
                    Choose a conversation from the list to start chatting.
                </div>

                <template v-else>
                    <div ref="messagesWrap" class="tc-support-chat__messages" @scroll="onMessagesScroll">
                        <div v-if="loadingMessages && !messages.length" class="text-center text-muted py-4">Loading messages…</div>
                        <div v-for="msg in messages" :key="msg.id" class="tc-support-chat__bubble-row" :class="msg.is_mine ? 'is-mine' : 'is-theirs'">
                            <div class="tc-support-chat__bubble">
                                <div class="tc-support-chat__bubble-meta">
                                    <strong>@{{ msg.user_name }}</strong>
                                    <span>@{{ msg.created_at }}</span>
                                </div>
                                <div class="tc-support-chat__bubble-text">@{{ msg.message }}</div>
                                <button
                                    v-if="config.isAdmin || msg.is_mine"
                                    type="button"
                                    class="tc-support-chat__bubble-delete btn btn-link btn-sm text-danger p-0"
                                    title="Delete message"
                                    @click="deleteMessage(msg.id)"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <form @submit.prevent="sendMessage" class="d-flex gap-2 align-items-end">
                            <textarea
                                v-model="draftMessage"
                                class="form-control"
                                rows="2"
                                maxlength="5000"
                                placeholder="Type your message…"
                                :disabled="sending"
                                @keydown.enter.exact.prevent="sendMessage"
                            ></textarea>
                            <button type="submit" class="btn btn-primary" :disabled="sending || !draftMessage.trim()">
                                Send
                            </button>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div v-if="flash" class="alert mt-3" :class="flash.ok ? 'alert-success' : 'alert-danger'" role="alert">@{{ flash.text }}</div>
</div>

<style>
[v-cloak] { display: none !important; }
.tc-support-chat__sidebar,
.tc-support-chat__panel { min-height: 520px; }
.tc-support-chat__thread-list { max-height: 420px; overflow-y: auto; }
.tc-support-chat__thread-item {
    display: block;
    width: 100%;
    text-align: left;
    border: 0;
    border-bottom: 1px solid rgba(0,0,0,.06);
    background: #fff;
    padding: .85rem 1rem;
    position: relative;
}
.tc-support-chat__thread-item:hover { background: #f8f9fa; }
.tc-support-chat__thread-item.is-active { background: #eef5ff; }
.tc-support-chat__thread-item.has-unread { border-left: 3px solid #dc3545; }
.tc-support-chat__thread-title { display: flex; justify-content: space-between; gap: .5rem; font-weight: 600; }
.tc-support-chat__thread-sub, .tc-support-chat__thread-meta { font-size: .82rem; color: #6c757d; }
.tc-support-chat__thread-delete { position: absolute; top: .75rem; right: .75rem; }
.tc-support-chat__messages {
    height: 420px;
    overflow-y: auto;
    padding: 1rem;
    background: #fbfbfc;
}
.tc-support-chat__bubble-row { display: flex; margin-bottom: .75rem; }
.tc-support-chat__bubble-row.is-mine { justify-content: flex-end; }
.tc-support-chat__bubble-row.is-theirs { justify-content: flex-start; }
.tc-support-chat__bubble {
    max-width: 78%;
    background: #fff;
    border: 1px solid rgba(0,0,0,.08);
    border-radius: .75rem;
    padding: .65rem .85rem;
    box-shadow: 0 1px 2px rgba(0,0,0,.04);
}
.tc-support-chat__bubble-row.is-mine .tc-support-chat__bubble { background: #e7f1ff; border-color: #cfe2ff; }
.tc-support-chat__bubble-meta { display: flex; justify-content: space-between; gap: 1rem; font-size: .75rem; color: #6c757d; margin-bottom: .35rem; }
.tc-support-chat__bubble-text { white-space: pre-wrap; word-break: break-word; }
</style>
