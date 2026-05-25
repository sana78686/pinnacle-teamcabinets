(function () {
    'use strict';

    function getBootstrapModal(el) {
        if (!el || typeof window.bootstrap === 'undefined') {
            return null;
        }
        return window.bootstrap.Modal.getOrCreateInstance(el);
    }

    function startApp() {
        const boot = window.PRODUCT_SETUP_CRUD;
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
                    config: boot,
                    rows: [],
                    meta: { catalogs: [], categories: [], door_styles: [] },
                    pagination: { current_page: 1, last_page: 1, per_page: 15, total: 0 },
                    loading: false,
                    saving: false,
                    formMode: 'create',
                    editId: null,
                    form: {},
                    formFiles: {},
                    formPreview: {},
                    formErrors: [],
                    showRecord: null,
                    flash: null,
                };
            },
            mounted() {
                this.loadMeta();
                this.loadRows();
            },
            watch: {
                'form.catalog_id'(catalogId) {
                    if (this.config.type === 'products') {
                        this.syncDoorStyleForCatalog(catalogId);
                    }
                },
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
                showFormModal() {
                    const modal = getBootstrapModal(this.$refs.formModalEl);
                    modal?.show();
                },
                showDetailsModal() {
                    const modal = getBootstrapModal(this.$refs.showModalEl);
                    modal?.show();
                },
                hideFormModal() {
                    getBootstrapModal(this.$refs.formModalEl)?.hide();
                },
                hideShowModal() {
                    getBootstrapModal(this.$refs.showModalEl)?.hide();
                },
                async loadMeta() {
                    try {
                        const res = await fetch(this.config.api.meta, { headers: this.headers() });
                        if (res.ok) {
                            this.meta = await res.json();
                        }
                    } catch (e) {
                        /* optional */
                    }
                },
                async deactivateAll() {
                    if (!this.config.deactivateAllUrl) {
                        return;
                    }
                    if (!confirm('Deactivate ALL products? They will be removed from the catalog (soft-deleted) and door styles hidden.')) {
                        return;
                    }
                    try {
                        const res = await fetch(this.config.deactivateAllUrl, {
                            method: 'POST',
                            headers: this.headers(),
                        });
                        const json = await res.json();
                        this.flash = {
                            ok: json.success,
                            text: json.message || (json.success ? 'Done.' : 'Failed.'),
                        };
                        await this.loadRows(1);
                    } catch (e) {
                        this.flash = { ok: false, text: 'Could not deactivate products.' };
                    }
                },
                async loadRows(page) {
                    this.loading = true;
                    const p = page || this.pagination.current_page || 1;
                    try {
                        const res = await fetch(this.config.api.index + '?page=' + p, { headers: this.headers() });
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
                    const preview = {};
                    (this.config.fields || []).forEach((f) => {
                        if (f.type === 'checkbox') {
                            form[f.name] = true;
                        } else if (f.type === 'media') {
                            form[f.name] = null;
                            form[f.name + '_url'] = '';
                        } else if (f.type === 'file') {
                            form[f.name] = null;
                        } else {
                            form[f.name] = '';
                        }
                        preview[f.name] = null;
                    });
                    this.form = form;
                    this.formFiles = {};
                    this.formPreview = preview;
                    this.formErrors = [];
                },
                openCreate() {
                    this.formMode = 'create';
                    this.editId = null;
                    this.emptyForm();
                    this.showFormModal();
                },
                async openEdit(id) {
                    this.formMode = 'edit';
                    this.editId = id;
                    this.emptyForm();
                    try {
                        const res = await fetch(this.apiUrl(this.config.api.show, id), { headers: this.headers() });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not load record.');
                        }
                        const row = json.data || {};
                        (this.config.fields || []).forEach((f) => {
                            if (f.type === 'checkbox') {
                                this.form[f.name] = !!row[f.name];
                            } else if (f.name === 'product_catalog_id') {
                                this.form[f.name] = row.product_catalog_id || '';
                            } else if (f.name === 'catalog_id') {
                                this.form[f.name] = row.catalog_id || '';
                            } else if (f.name === 'section_id') {
                                this.form[f.name] = row.section_id || '';
                            } else if (f.name === 'door_color_id') {
                                this.form[f.name] = row.door_color_id || '';
                            } else if (f.type === 'media') {
                                this.form[f.name + '_url'] = row[f.name + '_link'] || '';
                                if (f.mediaType === 'image' && row.image_url) {
                                    this.formPreview[f.name] = row.image_url;
                                } else if (f.mediaType === 'pdf' && (row.pdf_url || row.pdf_view_url)) {
                                    this.formPreview[f.name] = row.pdf_url || row.pdf_view_url;
                                }
                            } else if (f.type !== 'file') {
                                this.form[f.name] = row[f.name] ?? '';
                            }
                            if (f.type === 'file' && row.image_url) {
                                this.formPreview[f.name] = row.image_url;
                            }
                        });
                        this.showFormModal();
                    } catch (e) {
                        this.flash = { ok: false, text: e.message };
                    }
                },
                async restoreRow(id) {
                    if (!this.config.api.restore || !window.confirm('Restore this record?')) {
                        return;
                    }
                    try {
                        const res = await fetch(this.apiUrl(this.config.api.restore, id), {
                            method: 'POST',
                            headers: this.headers(),
                        });
                        const json = await res.json().catch(() => ({}));
                        if (!res.ok) {
                            throw new Error(json.message || 'Restore failed.');
                        }
                        this.flash = { ok: true, text: json.message || 'Restored.' };
                        await this.loadRows(this.pagination.current_page);
                    } catch (e) {
                        this.flash = { ok: false, text: e.message };
                    }
                },
                async openShow(id) {
                    if (!this.config.api.show) {
                        const row = this.rows.find((r) => r.id === id);
                        if (row) {
                            this.showRecord = row;
                            this.showDetailsModal();
                        }
                        return;
                    }
                    try {
                        const res = await fetch(this.apiUrl(this.config.api.show, id), { headers: this.headers() });
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
                onFile(ev, name) {
                    const file = ev.target.files && ev.target.files[0];
                    this.formFiles[name] = file || null;
                    if (file) {
                        this.formPreview[name] = URL.createObjectURL(file);
                        const urlKey = name + '_url';
                        if (Object.prototype.hasOwnProperty.call(this.form, urlKey)) {
                            this.form[urlKey] = '';
                        }
                    }
                },
                catalogIdForDoorStyles() {
                    if (this.config.type === 'products') {
                        return this.form.catalog_id ? String(this.form.catalog_id) : '';
                    }
                    if (this.config.type === 'door-styles') {
                        return this.form.product_catalog_id ? String(this.form.product_catalog_id) : '';
                    }

                    return '';
                },
                syncDoorStyleForCatalog(catalogId) {
                    if (this.config.type !== 'products') {
                        return;
                    }

                    const catalogKey = catalogId ? String(catalogId) : '';
                    const current = this.form.door_color_id ? String(this.form.door_color_id) : '';

                    if (!current) {
                        return;
                    }

                    const stillValid = (this.meta.door_styles || []).some(
                        (row) =>
                            String(row.id) === current &&
                            String(row.product_catalog_id) === catalogKey
                    );

                    if (!stillValid) {
                        this.form.door_color_id = '';
                    }
                },
                optionsFor(field) {
                    if (Array.isArray(field.options)) {
                        return field.options;
                    }
                    const key = field.options || '';
                    let list = this.meta[key] || [];
                    if (key === 'catalogs') {
                        return list.map((x) => ({ value: String(x.id), label: x.name }));
                    }
                    if (key === 'categories') {
                        return list.map((x) => ({ value: String(x.id), label: x.cabinets_name }));
                    }
                    if (key === 'door_styles') {
                        const catalogId = this.catalogIdForDoorStyles();
                        if (catalogId) {
                            list = list.filter(
                                (x) => String(x.product_catalog_id) === catalogId
                            );
                        } else {
                            list = [];
                        }

                        return list.map((x) => ({ value: String(x.id), label: x.product_label }));
                    }
                    return [];
                },
                formatMoney(value) {
                    if (value === null || value === undefined || value === '') {
                        return '—';
                    }
                    const num = parseFloat(String(value).replace(/[^0-9.\-]/g, ''));
                    if (Number.isNaN(num)) {
                        return String(value);
                    }
                    return '$' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                },
                formatWeight(value) {
                    if (value === null || value === undefined || value === '') {
                        return '—';
                    }
                    const num = parseFloat(String(value).replace(/[^0-9.\-]/g, ''));
                    if (Number.isNaN(num)) {
                        return String(value);
                    }
                    const formatted = num.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
                    return formatted + ' lbs';
                },
                buildFormData() {
                    const fd = new FormData();
                    Object.keys(this.form).forEach((key) => {
                        const val = this.form[key];
                        if (val === null || val === undefined) {
                            return;
                        }
                        if (typeof val === 'boolean') {
                            fd.append(key, val ? '1' : '0');
                        } else {
                            fd.append(key, val);
                        }
                    });
                    Object.keys(this.formFiles).forEach((key) => {
                        if (this.formFiles[key]) {
                            fd.append(key, this.formFiles[key]);
                        }
                    });
                    return fd;
                },
                async submitForm() {
                    this.saving = true;
                    this.formErrors = [];
                    const isEdit = this.formMode === 'edit' && this.editId;
                    const url = isEdit ? this.apiUrl(this.config.api.update, this.editId) : this.config.api.store;
                    try {
                        const res = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': this.config.csrf,
                                Accept: 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: this.buildFormData(),
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
                        await this.loadRows(this.pagination.current_page);
                    } catch (e) {
                        this.formErrors = [e.message || 'Network error.'];
                    } finally {
                        this.saving = false;
                    }
                },
                async destroyRow(id) {
                    if (!window.confirm('Delete this record?')) {
                        return;
                    }
                    try {
                        const res = await fetch(this.apiUrl(this.config.api.destroy, id), {
                            method: 'DELETE',
                            headers: this.headers(),
                        });
                        const json = await res.json().catch(() => ({}));
                        if (!res.ok) {
                            throw new Error(json.message || 'Delete failed.');
                        }
                        this.flash = { ok: true, text: json.message || 'Deleted.' };
                        await this.loadRows(this.pagination.current_page);
                    } catch (e) {
                        this.flash = { ok: false, text: e.message };
                    }
                },
            },
        }).mount('#product-setup-app');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startApp);
    } else {
        startApp();
    }
})();
