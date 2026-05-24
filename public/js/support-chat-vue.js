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
                    threadSearch: '',
                    newThreadTitle: '',
                    newThreadMessage: '',
                    showNewThread: false,
                    loadingThreads: false,
                    loadingMessages: false,
                    sending: false,
                    creatingThread: false,
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
                this.loadThreads().then(() => {
                    if (this.selectedThreadId) {
                        this.loadMessages(true);
                    } else if (this.threads.length === 1) {
                        this.selectThread(this.threads[0].id);
                    }
                });
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
                    await this.loadThreads(this.threadPagination.current_page, true);
                    if (this.selectedThreadId) {
                        await this.loadMessages(false, true);
                    }
                },
                async loadThreads(page, silent) {
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
                    if (initial) {
                        url.searchParams.set('mark_read', '1');
                    } else {
                        url.searchParams.set('mark_read', this.stickToBottom ? '1' : '0');
                    }
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
                async sendMessage() {
                    const text = this.draftMessage.trim();
                    if (!text || !this.selectedThreadId || this.sending) {
                        return;
                    }
                    this.sending = true;
                    try {
                        const res = await fetch(this.apiUrl(this.config.api.sendMessage, this.selectedThreadId), {
                            method: 'POST',
                            headers: this.headers(true),
                            body: JSON.stringify({ message: text }),
                        });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not send message.');
                        }
                        if (json.data) {
                            this.messages.push(json.data);
                            this.lastMessageAt = json.data.created_at_iso || this.lastMessageAt;
                        }
                        this.draftMessage = '';
                        this.stickToBottom = true;
                        this.$nextTick(() => this.scrollMessagesToBottom());
                        await this.loadThreads(this.threadPagination.current_page, true);
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Send failed.' };
                    } finally {
                        this.sending = false;
                    }
                },
                async createThread() {
                    const title = this.newThreadTitle.trim();
                    if (!title || this.creatingThread) {
                        return;
                    }
                    this.creatingThread = true;
                    try {
                        const res = await fetch(this.config.api.storeThread, {
                            method: 'POST',
                            headers: this.headers(true),
                            body: JSON.stringify({
                                title,
                                message: this.newThreadMessage.trim() || null,
                            }),
                        });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not create ticket.');
                        }
                        this.newThreadTitle = '';
                        this.newThreadMessage = '';
                        this.showNewThread = false;
                        await this.loadThreads(1);
                        if (json.data?.id) {
                            this.selectThread(json.data.id);
                        }
                        this.flash = { ok: true, text: 'Support ticket created.' };
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Create failed.' };
                    } finally {
                        this.creatingThread = false;
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
                            this.selectedThreadId = null;
                            this.messages = [];
                        } else {
                            this.messages = this.messages.filter((m) => m.id !== id);
                        }
                        await this.loadThreads(this.threadPagination.current_page, true);
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
