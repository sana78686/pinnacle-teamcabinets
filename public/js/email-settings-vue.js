(function () {
    'use strict';

    function getBootstrapModal(el) {
        if (!el || typeof window.bootstrap === 'undefined') {
            return null;
        }
        return window.bootstrap.Modal.getOrCreateInstance(el);
    }

    function startApp() {
        const boot = window.EMAIL_SETTINGS_CRUD;
        if (!boot || !window.Vue) {
            return;
        }
        if (typeof window.bootstrap === 'undefined') {
            setTimeout(startApp, 40);
            return;
        }

        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    boot,
                    activeTab: boot.initialTab || 'smtp',
                    showTrashed: false,
                    rows: [],
                    meta: { smtp_accounts: [] },
                    pagination: { current_page: 1, last_page: 1, per_page: 15, total: 0 },
                    loading: false,
                    saving: false,
                    testing: false,
                    formMode: 'create',
                    editId: null,
                    form: {},
                    formErrors: [],
                    showRecord: null,
                    flash: null,
                };
            },
            computed: {
                config() {
                    return this.boot.modules[this.activeTab] || {};
                },
                api() {
                    return this.boot.api[this.activeTab] || {};
                },
            },
            mounted() {
                this.loadMeta();
                this.loadRows();
            },
            methods: {
                setTab(tab) {
                    if (this.activeTab === tab) {
                        return;
                    }
                    this.activeTab = tab;
                    this.showTrashed = false;
                    this.flash = null;
                    this.pagination.current_page = 1;
                    this.loadRows(1);
                },
                toggleTrashed() {
                    this.showTrashed = !this.showTrashed;
                    this.pagination.current_page = 1;
                    this.loadRows(1);
                },
                apiUrl(template, id) {
                    return String(template).replace('__ID__', String(id));
                },
                headers(json) {
                    const h = {
                        'X-CSRF-TOKEN': this.boot.csrf,
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    };
                    if (json) {
                        h['Content-Type'] = 'application/json';
                    }
                    return h;
                },
                showFormModal() {
                    getBootstrapModal(this.$refs.formModalEl)?.show();
                },
                hideFormModal() {
                    getBootstrapModal(this.$refs.formModalEl)?.hide();
                },
                showDetailsModal() {
                    getBootstrapModal(this.$refs.showModalEl)?.show();
                },
                async loadMeta() {
                    try {
                        const res = await fetch(this.boot.api.meta, { headers: this.headers() });
                        if (res.ok) {
                            this.meta = await res.json();
                        }
                    } catch (e) {
                        /* optional */
                    }
                },
                async loadRows(page) {
                    this.loading = true;
                    const p = page || this.pagination.current_page || 1;
                    const q = '?page=' + p + (this.showTrashed ? '&trashed=1' : '');
                    try {
                        const res = await fetch(this.api.index + q, { headers: this.headers() });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not load list.');
                        }
                        this.rows = json.data || [];
                        this.pagination = Object.assign(this.pagination, json.meta || {});
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Load failed.' };
                    } finally {
                        this.loading = false;
                    }
                },
                goPage(page) {
                    if (page < 1 || page > this.pagination.last_page) {
                        return;
                    }
                    this.loadRows(page);
                },
                emptyForm() {
                    const form = {};
                    (this.config.fields || []).forEach((f) => {
                        form[f.name] = f.type === 'number' ? '' : '';
                    });
                    this.form = form;
                    this.formErrors = [];
                },
                openCreate() {
                    this.formMode = 'create';
                    this.editId = null;
                    this.emptyForm();
                    if (this.activeTab === 'smtp') {
                        this.form.smtp_port = '587';
                        this.form.smtp_encryption = 'tls';
                    }
                    if (this.activeTab === 'email-content') {
                        this.form.email_from = '';
                    }
                    this.showFormModal();
                },
                async openEdit(id) {
                    this.formMode = 'edit';
                    this.editId = id;
                    this.emptyForm();
                    try {
                        const res = await fetch(this.apiUrl(this.api.show, id), { headers: this.headers() });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not load record.');
                        }
                        const row = json.data || {};
                        (this.config.fields || []).forEach((f) => {
                            this.form[f.name] = row[f.name] ?? '';
                        });
                        if (this.activeTab === 'smtp') {
                            this.form.smtp_password = '';
                        }
                        this.showFormModal();
                    } catch (e) {
                        this.flash = { ok: false, text: e.message };
                    }
                },
                async openShow(id) {
                    try {
                        const res = await fetch(this.apiUrl(this.api.show, id), { headers: this.headers() });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not load record.');
                        }
                        this.showRecord = json.data;
                        this.showDetailsModal();
                    } catch (e) {
                        this.flash = { ok: false, text: e.message };
                    }
                },
                optionsFor(field) {
                    if (field.optionsFrom) {
                        return this.meta[field.optionsFrom] || [];
                    }
                    if (field.options) {
                        return field.options;
                    }
                    return [];
                },
                buildPayload() {
                    const payload = Object.assign({}, this.form);
                    if (this.activeTab === 'email-content') {
                        payload.email_from = payload.email_from ? parseInt(payload.email_from, 10) : 0;
                    }
                    if (this.activeTab === 'smtp') {
                        payload.smtp_port = parseInt(payload.smtp_port, 10) || 587;
                        if (this.formMode === 'edit' && !payload.smtp_password) {
                            delete payload.smtp_password;
                        }
                    }
                    if (this.formMode === 'edit' && this.editId) {
                        payload.id = this.editId;
                    }
                    return payload;
                },
                async submitForm() {
                    this.saving = true;
                    this.formErrors = [];
                    const isEdit = this.formMode === 'edit' && this.editId;
                    const url = isEdit ? this.apiUrl(this.api.update, this.editId) : this.api.store;
                    try {
                        const res = await fetch(url, {
                            method: 'POST',
                            headers: this.headers(true),
                            body: JSON.stringify(this.buildPayload()),
                        });
                        const json = await res.json().catch(() => ({}));
                        if (!res.ok) {
                            if (json.errors) {
                                this.formErrors = Object.values(json.errors).flat();
                            } else {
                                this.formErrors = [json.message || 'Save failed.'];
                            }
                            return;
                        }
                        this.hideFormModal();
                        this.flash = { ok: true, text: json.message || 'Saved.' };
                        await this.loadMeta();
                        await this.loadRows(this.pagination.current_page);
                    } catch (e) {
                        this.formErrors = [e.message || 'Network error.'];
                    } finally {
                        this.saving = false;
                    }
                },
                async testSmtpRow(row) {
                    if (!window.confirm('Send a test email using this SMTP account?')) {
                        return;
                    }
                    this.testing = true;
                    try {
                        const res = await fetch(this.boot.api.testSmtp, {
                            method: 'POST',
                            headers: this.headers(true),
                            body: JSON.stringify({
                                id: row.id,
                                smtp_host: row.smtp_host,
                                smtp_username: row.smtp_username,
                                from_email: row.from_email,
                                from_name: row.from_name,
                                smtp_port: row.smtp_port,
                                smtp_encryption: row.smtp_encryption,
                            }),
                        });
                        const json = await res.json();
                        this.flash = { ok: !!json.success, text: json.message || (json.success ? 'Test sent.' : 'Test failed.') };
                    } catch (e) {
                        this.flash = { ok: false, text: e.message || 'Test failed.' };
                    } finally {
                        this.testing = false;
                    }
                },
                async destroyRow(id, row) {
                    if (row && row.in_use) {
                        this.flash = { ok: false, text: 'This SMTP account is assigned to an email template and cannot be deleted.' };
                        return;
                    }
                    if (!window.confirm('Delete this record?')) {
                        return;
                    }
                    try {
                        const res = await fetch(this.apiUrl(this.api.destroy, id), {
                            method: 'DELETE',
                            headers: this.headers(),
                        });
                        const json = await res.json().catch(() => ({}));
                        if (!res.ok) {
                            const msg = json.errors ? Object.values(json.errors).flat().join(' ') : json.message;
                            throw new Error(msg || 'Delete failed.');
                        }
                        this.flash = { ok: true, text: json.message || 'Deleted.' };
                        await this.loadRows(this.pagination.current_page);
                    } catch (e) {
                        this.flash = { ok: false, text: e.message };
                    }
                },
                async restoreRow(id) {
                    if (!window.confirm('Restore this record?')) {
                        return;
                    }
                    try {
                        const res = await fetch(this.apiUrl(this.api.restore, id), {
                            method: 'POST',
                            headers: this.headers(),
                        });
                        const json = await res.json().catch(() => ({}));
                        if (!res.ok) {
                            throw new Error(json.message || 'Restore failed.');
                        }
                        this.flash = { ok: true, text: json.message || 'Restored.' };
                        await this.loadMeta();
                        await this.loadRows(this.pagination.current_page);
                    } catch (e) {
                        this.flash = { ok: false, text: e.message };
                    }
                },
                showValue(field, record) {
                    if (!record) {
                        return '—';
                    }
                    if (field.type === 'bool') {
                        return record[field.key] ? 'Yes' : 'No';
                    }
                    if (field.type === 'html') {
                        return record[field.key] || '—';
                    }
                    return record[field.key] ?? '—';
                },
            },
        }).mount('#email-settings-app');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startApp);
    } else {
        startApp();
    }
})();
