(function () {
    'use strict';

    function startWidget() {
        const config = window.SUPPORT_CHAT_WIDGET_CONFIG;
        const mountEl = document.getElementById('support-chat-widget');
        if (!config || !mountEl || !window.Vue) {
            return;
        }

        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    config,
                    widgetOpen: false,
                    threads: [],
                    selectedThreadId: null,
                    messages: [],
                    draftMessage: '',
                    pendingFile: null,
                    unreadCount: 0,
                    loadingMessages: false,
                    sending: false,
                    flash: null,
                    pollTimer: null,
                    lastMessageAt: null,
                    stickToBottom: true,
                };
            },
            mounted() {
                this.loadUnreadCount();
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
                toggleWidget() {
                    if (this.widgetOpen) {
                        this.closeWidget();
                        return;
                    }
                    this.widgetOpen = true;
                    this.flash = null;
                    this.ensureUserThread();
                },
                closeWidget() {
                    this.widgetOpen = false;
                },
                startPolling() {
                    this.stopPolling();
                    const ms = this.config.pollMs || 4000;
                    this.pollTimer = window.setInterval(() => {
                        if (this.widgetOpen && this.selectedThreadId) {
                            this.loadMessages(false, true);
                        } else {
                            this.loadUnreadCount(true);
                        }
                    }, ms);
                },
                stopPolling() {
                    if (this.pollTimer) {
                        window.clearInterval(this.pollTimer);
                        this.pollTimer = null;
                    }
                },
                async loadUnreadCount(silent) {
                    if (!this.config.api.unreadCount) {
                        return;
                    }
                    try {
                        const res = await fetch(this.config.api.unreadCount, { headers: this.headers() });
                        const json = await res.json();
                        if (res.ok) {
                            this.unreadCount = Number(json.unread_count || json.count || json.data?.count || 0);
                        }
                    } catch (e) {
                        if (!silent) {
                            this.flash = { ok: false, text: 'Could not load unread count.' };
                        }
                    }
                },
                async ensureUserThread() {
                    this.loadingMessages = true;
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
                        } else {
                            this.selectedThreadId = null;
                            this.messages = [];
                        }
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Load failed.' };
                    } finally {
                        this.loadingMessages = false;
                    }
                },
                async createUserThread() {
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
                    url.searchParams.set('mark_read', '1');
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
                        this.unreadCount = 0;
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
                    if (!this.selectedThreadId) {
                        try {
                            await this.createUserThread();
                        } catch (e) {
                            return;
                        }
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
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Send failed.' };
                    } finally {
                        this.sending = false;
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
        }).mount('#support-chat-widget');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startWidget);
    } else {
        startWidget();
    }
})();
