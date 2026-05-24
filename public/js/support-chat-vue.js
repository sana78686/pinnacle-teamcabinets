(function () {
    'use strict';

    function startApp() {
        const config = window.SUPPORT_CHAT_CONFIG;
        if (!config || !window.Vue) {
            return;
        }

        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    config,
                    threads: [],
                    threadPagination: { current_page: 1, last_page: 1, per_page: 15, total: 0 },
                    selectedThreadId: config.initialThreadId || null,
                    messages: [],
                    draftMessage: '',
                    pendingFile: null,
                    threadSearch: '',
                    showCreateChat: false,
                    createUserSearch: '',
                    chatUsers: [],
                    loadingChatUsers: false,
                    creatingAdminChat: false,
                    chatUsersTimer: null,
                    loadingThreads: false,
                    loadingMessages: false,
                    sending: false,
                    flash: null,
                    pollTimer: null,
                    lastMessageAt: null,
                    stickToBottom: true,
                };
            },
            computed: {
                selectedThread() {
                    return this.threads.find((t) => t.id === this.selectedThreadId) || null;
                },
            },
            mounted() {
                if (this.config.isAdmin) {
                    this.loadThreads().then(() => {
                        if (this.selectedThreadId) {
                            this.loadMessages(true);
                        }
                    });
                } else {
                    this.ensureUserThread();
                }
                this.startPolling();
            },
            beforeUnmount() {
                this.stopPolling();
            },
            methods: {
                apiUrl(template, id) {
                    return String(template).replace('__ID__', String(id));
                },
                headers(json) {
                    const h = {
                        'X-CSRF-TOKEN': this.config.csrf,
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    };
                    if (json) {
                        h['Content-Type'] = 'application/json';
                    }
                    return h;
                },
                attachmentIcon(msg) {
                    const name = (msg.attachment_name || '').toLowerCase();
                    if (/\.(jpg|jpeg|png|gif|webp)$/.test(name)) {
                        return 'icofont-image';
                    }
                    if (/\.pdf$/.test(name)) {
                        return 'icofont-file-pdf';
                    }
                    if (/\.(doc|docx)$/.test(name)) {
                        return 'icofont-file-word';
                    }
                    if (/\.(xls|xlsx|csv)$/.test(name)) {
                        return 'icofont-file-excel';
                    }
                    if (/\.zip$/.test(name)) {
                        return 'icofont-file-zip';
                    }
                    return 'icofont-attachment';
                },
                startPolling() {
                    this.stopPolling();
                    const ms = this.config.pollMs || 4000;
                    this.pollTimer = window.setInterval(() => {
                        this.pollUpdates();
                    }, ms);
                },
                stopPolling() {
                    if (this.pollTimer) {
                        window.clearInterval(this.pollTimer);
                        this.pollTimer = null;
                    }
                },
                async pollUpdates() {
                    if (this.config.isAdmin) {
                        await this.loadThreads(this.threadPagination.current_page, true);
                    }
                    if (this.selectedThreadId) {
                        await this.loadMessages(false, true);
                    }
                },
                openCreateChat() {
                    this.showCreateChat = true;
                    this.createUserSearch = '';
                    this.loadChatUsers();
                },
                closeCreateChat() {
                    this.showCreateChat = false;
                    this.chatUsers = [];
                },
                debouncedLoadChatUsers() {
                    if (this.chatUsersTimer) {
                        window.clearTimeout(this.chatUsersTimer);
                    }
                    this.chatUsersTimer = window.setTimeout(() => this.loadChatUsers(), 250);
                },
                async loadChatUsers() {
                    if (!this.config.isAdmin || !this.config.api.chatUsers) {
                        return;
                    }
                    this.loadingChatUsers = true;
                    const qs = new URLSearchParams();
                    if (this.createUserSearch.trim()) {
                        qs.set('search', this.createUserSearch.trim());
                    }
                    try {
                        const url = this.config.api.chatUsers + (qs.toString() ? '?' + qs.toString() : '');
                        const res = await fetch(url, { headers: this.headers() });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not load users.');
                        }
                        this.chatUsers = json.data || [];
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Could not load users.' };
                    } finally {
                        this.loadingChatUsers = false;
                    }
                },
                async createAdminChat(userId) {
                    if (this.creatingAdminChat) {
                        return;
                    }
                    this.creatingAdminChat = true;
                    try {
                        const res = await fetch(this.config.api.storeThread, {
                            method: 'POST',
                            headers: this.headers(true),
                            body: JSON.stringify({ user_id: userId }),
                        });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not start chat.');
                        }
                        this.closeCreateChat();
                        await this.loadThreads(1);
                        if (json.data?.id) {
                            this.selectThread(json.data.id);
                        }
                        this.flash = { ok: true, text: json.message || 'Chat ready.' };
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Could not start chat.' };
                    } finally {
                        this.creatingAdminChat = false;
                    }
                },
                async ensureUserThread() {
                    this.loadingThreads = true;
                    try {
                        const res = await fetch(this.config.api.currentThread, { headers: this.headers() });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not open chat.');
                        }
                        if (json.data?.id) {
                            this.threads = [json.data];
                            this.selectedThreadId = json.data.id;
                            await this.loadMessages(true);
                        }
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Load failed.' };
                    } finally {
                        this.loadingThreads = false;
                    }
                },
                async loadThreads(page, silent) {
                    if (!this.config.isAdmin) {
                        return;
                    }
                    if (!silent) {
                        this.loadingThreads = true;
                    }
                    const p = page || this.threadPagination.current_page || 1;
                    const qs = new URLSearchParams({ page: String(p) });
                    if (this.threadSearch.trim()) {
                        qs.set('search', this.threadSearch.trim());
                    }
                    try {
                        const res = await fetch(this.config.api.threads + '?' + qs.toString(), {
                            headers: this.headers(),
                        });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not load conversations.');
                        }
                        this.threads = json.data || [];
                        this.threadPagination = Object.assign(this.threadPagination, json.meta || {});
                        this.resetThreadListScroll(page === 1 || !page);
                        if (this.selectedThreadId && !this.threads.some((t) => t.id === this.selectedThreadId)) {
                            this.selectedThreadId = this.threads[0]?.id || null;
                            this.messages = [];
                        }
                    } catch (e) {
                        if (!silent) {
                            this.flash = { ok: false, text: e.message || 'Load failed.' };
                        }
                    } finally {
                        if (!silent) {
                            this.loadingThreads = false;
                        }
                    }
                },
                resetThreadListScroll(force) {
                    if (!force) {
                        return;
                    }
                    this.$nextTick(() => {
                        const el = this.$refs.threadListWrap;
                        if (el) {
                            el.scrollTop = 0;
                        }
                    });
                },
                selectThread(id) {
                    if (this.selectedThreadId === id) {
                        return;
                    }
                    this.selectedThreadId = id;
                    this.messages = [];
                    this.lastMessageAt = null;
                    this.stickToBottom = true;
                    this.loadMessages(true);
                },
                async loadMessages(initial, silent) {
                    if (!this.selectedThreadId) {
                        return;
                    }
                    if (initial) {
                        this.loadingMessages = true;
                    }
                    const url = new URL(this.apiUrl(this.config.api.messages, this.selectedThreadId), window.location.origin);
                    if (!initial && this.lastMessageAt) {
                        url.searchParams.set('since', this.lastMessageAt);
                    }
                    url.searchParams.set('mark_read', initial || this.stickToBottom ? '1' : '0');
                    try {
                        const res = await fetch(url.toString(), { headers: this.headers() });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not load messages.');
                        }
                        const incoming = json.data || [];
                        if (initial) {
                            this.messages = incoming;
                        } else if (incoming.length) {
                            const existingIds = new Set(this.messages.map((m) => m.id));
                            incoming.forEach((m) => {
                                if (!existingIds.has(m.id)) {
                                    this.messages.push(m);
                                }
                            });
                        }
                        if (json.thread && !this.config.isAdmin) {
                            this.threads = [json.thread];
                        }
                        if (this.messages.length) {
                            this.lastMessageAt = this.messages[this.messages.length - 1].created_at_iso;
                        }
                        if (this.stickToBottom) {
                            this.$nextTick(() => this.scrollMessagesToBottom());
                        }
                    } catch (e) {
                        if (!silent) {
                            this.flash = { ok: false, text: e.message || 'Could not load messages.' };
                        }
                    } finally {
                        if (initial) {
                            this.loadingMessages = false;
                        }
                    }
                },
                async createUserThread() {
                    try {
                        const res = await fetch(this.config.api.storeThread, {
                            method: 'POST',
                            headers: this.headers(true),
                            body: JSON.stringify({ title: 'Support Chat' }),
                        });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not start chat.');
                        }
                        if (json.data?.id) {
                            this.threads = [json.data];
                            this.selectedThreadId = json.data.id;
                        }
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Could not start chat.' };
                        throw e;
                    }
                },
                onFileSelected(event) {
                    const file = event.target.files?.[0];
                    if (!file) {
                        return;
                    }
                    if (file.size > 10 * 1024 * 1024) {
                        this.flash = { ok: false, text: 'File must be 10 MB or smaller.' };
                        event.target.value = '';
                        return;
                    }
                    this.pendingFile = file;
                },
                clearAttachment() {
                    this.pendingFile = null;
                    if (this.$refs.fileInput) {
                        this.$refs.fileInput.value = '';
                    }
                },
                async sendMessage() {
                    const text = this.draftMessage.trim();
                    if ((!text && !this.pendingFile) || this.sending) {
                        return;
                    }
                    if (!this.selectedThreadId && !this.config.isAdmin) {
                        await this.createUserThread();
                    }
                    if (!this.selectedThreadId) {
                        return;
                    }
                    this.sending = true;
                    try {
                        let res;
                        if (this.pendingFile) {
                            const form = new FormData();
                            if (text) {
                                form.append('message', text);
                            }
                            form.append('attachment', this.pendingFile);
                            res = await fetch(this.apiUrl(this.config.api.sendMessage, this.selectedThreadId), {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': this.config.csrf,
                                    Accept: 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: form,
                            });
                        } else {
                            res = await fetch(this.apiUrl(this.config.api.sendMessage, this.selectedThreadId), {
                                method: 'POST',
                                headers: this.headers(true),
                                body: JSON.stringify({ message: text }),
                            });
                        }
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || (json.errors ? Object.values(json.errors).flat().join(' ') : 'Could not send message.'));
                        }
                        if (json.data) {
                            this.messages.push(json.data);
                            this.lastMessageAt = json.data.created_at_iso || this.lastMessageAt;
                        }
                        this.draftMessage = '';
                        this.clearAttachment();
                        this.stickToBottom = true;
                        this.$nextTick(() => this.scrollMessagesToBottom());
                        if (this.config.isAdmin) {
                            await this.loadThreads(this.threadPagination.current_page, true);
                        }
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Send failed.' };
                    } finally {
                        this.sending = false;
                    }
                },
                async deleteMessage(id) {
                    if (!window.confirm('Delete this message?')) {
                        return;
                    }
                    try {
                        const res = await fetch(this.apiUrl(this.config.api.destroyMessage, id), {
                            method: 'DELETE',
                            headers: this.headers(),
                        });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Delete failed.');
                        }
                        if (json.thread_deleted) {
                            if (this.config.isAdmin) {
                                this.selectedThreadId = null;
                                this.messages = [];
                                await this.loadThreads(1);
                            } else {
                                await this.ensureUserThread();
                            }
                        } else {
                            this.messages = this.messages.filter((m) => m.id !== id);
                        }
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Delete failed.' };
                    }
                },
                async deleteThread(id) {
                    if (!window.confirm('Delete this entire conversation and all messages?')) {
                        return;
                    }
                    try {
                        const res = await fetch(this.apiUrl(this.config.api.destroyThread, id), {
                            method: 'DELETE',
                            headers: this.headers(),
                        });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Delete failed.');
                        }
                        if (this.selectedThreadId === id) {
                            this.selectedThreadId = null;
                            this.messages = [];
                        }
                        await this.loadThreads(1);
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Delete failed.' };
                    }
                },
                onMessagesScroll() {
                    const el = this.$refs.messagesWrap;
                    if (!el) {
                        return;
                    }
                    const distance = el.scrollHeight - el.scrollTop - el.clientHeight;
                    this.stickToBottom = distance < 40;
                },
                scrollMessagesToBottom() {
                    const el = this.$refs.messagesWrap;
                    if (el) {
                        el.scrollTop = el.scrollHeight;
                    }
                },
            },
        }).mount('#support-chat-app');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startApp);
    } else {
        startApp();
    }
})();
