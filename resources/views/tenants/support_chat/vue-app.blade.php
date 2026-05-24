<div id="support-chat-app" class="tc-support-chat" :class="config.isAdmin ? 'tc-support-chat--admin' : 'tc-support-chat--user'" v-cloak>
    <div v-if="flash" class="alert mb-3" :class="flash.ok ? 'alert-success' : 'alert-danger'" role="alert">@{{ flash.text }}</div>

    <div v-if="config.isAdmin" class="row g-3 tc-support-chat__layout">
        <div class="col-lg-4">
            <div class="card tc-dash-card tc-support-chat__sidebar h-100">
                <div class="card-header py-3">
                    <h5 class="mb-0">Chat rooms</h5>
                </div>
                <div class="card-body border-bottom py-2">
                    <div class="tc-support-chat__search-row">
                        <input v-model="threadSearch" type="search" class="form-control form-control-sm" placeholder="Search users…" @keyup.enter="loadThreads(1)">
                        <button type="button" class="btn btn-info btn-sm tc-support-chat__new-btn" title="Start new chat" @click="openCreateChat">
                            <i class="icofont icofont-plus"></i>
                        </button>
                    </div>
                </div>
                <div ref="threadListWrap" class="tc-support-chat__thread-list">
                    <div v-if="loadingThreads" class="tc-support-chat__empty"><p class="mb-0">Loading…</p></div>
                    <div v-else-if="!threads.length" class="tc-support-chat__empty">
                        <i class="icofont icofont-users" aria-hidden="true"></i>
                        <p class="mb-0">No conversations yet. Click + to start a chat.</p>
                    </div>
                    <button
                        v-for="thread in threads"
                        :key="thread.id"
                        type="button"
                        class="tc-support-chat__thread-item"
                        :class="{ 'is-active': selectedThreadId === thread.id, 'has-unread': thread.unread_count > 0 }"
                        @click="selectThread(thread.id)"
                    >
                        <div class="tc-support-chat__thread-row">
                            <div class="tc-chat-avatar tc-chat-avatar--sm" :title="thread.user_name">
                                <img v-if="thread.user_avatar?.url" :src="thread.user_avatar.url" :alt="thread.user_name">
                                <span v-else class="tc-chat-avatar__initials">@{{ thread.user_avatar?.initials || 'U' }}</span>
                            </div>
                            <div class="tc-support-chat__thread-body">
                                <div class="tc-support-chat__thread-title">
                                    <span>@{{ thread.user_name || 'User' }}</span>
                                    <span v-if="thread.unread_count > 0" class="badge rounded-pill bg-danger">@{{ thread.unread_count }}</span>
                                </div>
                                <div class="tc-support-chat__thread-sub">@{{ thread.user_email || thread.title }}</div>
                                <div class="tc-support-chat__thread-meta">@{{ thread.created_at }}</div>
                            </div>
                        </div>
                        <button type="button" class="tc-support-chat__thread-delete btn btn-link btn-sm text-danger p-0" title="Delete thread" @click.stop="deleteThread(thread.id)">
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
            <div class="card tc-dash-card tc-support-chat__panel h-100">
                <div v-if="selectedThread" class="card-header py-3 d-flex align-items-center gap-2">
                    <div class="tc-chat-avatar tc-chat-avatar--md" :title="selectedThread.user_name">
                        <img v-if="selectedThread.user_avatar?.url" :src="selectedThread.user_avatar.url" :alt="selectedThread.user_name">
                        <span v-else class="tc-chat-avatar__initials">@{{ selectedThread.user_avatar?.initials || 'U' }}</span>
                    </div>
                    <div>
                        <h5 class="mb-0">@{{ selectedThread.user_name || 'User' }}</h5>
                        <p class="mb-0 small text-muted">@{{ selectedThread.user_email }}</p>
                    </div>
                </div>
                <div v-else class="tc-support-chat__placeholder d-flex align-items-center justify-content-center text-muted flex-grow-1">
                    <div class="text-center">
                        <i class="icofont icofont-speech-comments" aria-hidden="true"></i>
                        <p class="mb-0 mt-2">Select a user chat room to start messaging.</p>
                    </div>
                </div>
                @include('tenants.support_chat.partials.chat-panel')
            </div>
        </div>
    </div>

    <div v-else class="card tc-dash-card tc-support-chat__panel tc-support-chat__panel--solo">
        <div class="card-header py-3 d-flex align-items-center gap-2">
            <div class="tc-chat-avatar tc-chat-avatar--md" title="Admin support">
                <span class="tc-chat-avatar__initials">AD</span>
            </div>
            <div>
                <h5 class="mb-0">Chat with Admin</h5>
                <p class="mb-0 small text-muted">Send a message or attach a file — our team will reply here.</p>
            </div>
        </div>
        @include('tenants.support_chat.partials.chat-panel')
    </div>

    <div v-if="config.isAdmin && showCreateChat" class="tc-support-chat__modal-backdrop" @click.self="closeCreateChat">
        <div class="tc-support-chat__modal card tc-dash-card">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0">Start new chat</h5>
                <button type="button" class="btn-close" aria-label="Close" @click="closeCreateChat"></button>
            </div>
            <div class="card-body border-bottom py-2">
                <input v-model="createUserSearch" type="search" class="form-control form-control-sm" placeholder="Search by name or email…" @input="debouncedLoadChatUsers">
            </div>
            <div class="tc-support-chat__user-picker">
                <div v-if="loadingChatUsers" class="tc-support-chat__empty"><p class="mb-0">Loading users…</p></div>
                <div v-else-if="!chatUsers.length" class="tc-support-chat__empty"><p class="mb-0">No users found.</p></div>
                <button
                    v-for="user in chatUsers"
                    :key="user.id"
                    type="button"
                    class="tc-support-chat__user-option"
                    :disabled="creatingAdminChat"
                    @click="createAdminChat(user.id)"
                >
                    <div class="tc-chat-avatar tc-chat-avatar--sm" :title="user.name">
                        <img v-if="user.avatar?.url" :src="user.avatar.url" :alt="user.name">
                        <span v-else class="tc-chat-avatar__initials">@{{ user.avatar?.initials || 'U' }}</span>
                    </div>
                    <div class="tc-support-chat__user-option-body">
                        <strong>@{{ user.name }}</strong>
                        <span>@{{ user.email }}</span>
                        <span v-if="user.has_thread" class="badge bg-light text-muted">Existing chat</span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
