(function () {
    'use strict';

    function replaceFeatherIcons() {
        if (window.feather && typeof window.feather.replace === 'function') {
            window.feather.replace();
        }
    }

    function startApp() {
        const config = window.REP_WORKSPACE_LIST;
        if (!config || !window.Vue) {
            return;
        }

        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    config,
                    rows: [],
                    pagination: { current_page: 1, last_page: 1, per_page: 15, total: 0 },
                    perPage: 15,
                    perPageOptions: [10, 15, 25, 50, 100],
                    loading: false,
                    search: '',
                    flash: null,
                };
            },
            computed: {
                emptyMessage() {
                    return this.config.emptyMessage
                        || ('No ' + (this.config.rowLabel || 'record') + 's yet.');
                },
                paginationFrom() {
                    if (!this.pagination.total) {
                        return 0;
                    }

                    return ((this.pagination.current_page - 1) * this.pagination.per_page) + 1;
                },
                paginationTo() {
                    return Math.min(
                        this.pagination.current_page * this.pagination.per_page,
                        this.pagination.total
                    );
                },
            },
            mounted() {
                this.loadRows();
                this.$nextTick(replaceFeatherIcons);
            },
            updated() {
                this.$nextTick(replaceFeatherIcons);
            },
            methods: {
                apiUrl(template, id) {
                    return String(template).replace('__ID__', String(id));
                },
                headers() {
                    return {
                        'X-CSRF-TOKEN': this.config.csrf,
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    };
                },
                showUrl(id) {
                    return this.config.showUrl ? this.apiUrl(this.config.showUrl, id) : '#';
                },
                editUrl(id) {
                    return this.config.editUrl ? this.apiUrl(this.config.editUrl, id) : '#';
                },
                pickListUrl(id) {
                    return this.config.pickListUrl ? this.apiUrl(this.config.pickListUrl, id) : '#';
                },
                printUrl(id) {
                    return this.config.printUrl ? this.apiUrl(this.config.printUrl, id) : '#';
                },
                clearSearch() {
                    this.search = '';
                    this.loadRows(1);
                },
                async loadRows(page) {
                    this.loading = true;
                    const p = page || this.pagination.current_page || 1;
                    const qs = new URLSearchParams({
                        page: String(p),
                        per_page: String(this.perPage),
                    });
                    if (this.search.trim()) {
                        qs.set('search', this.search.trim());
                    }
                    try {
                        const res = await fetch(this.config.api.index + '?' + qs.toString(), {
                            headers: this.headers(),
                        });
                        const json = await res.json();
                        if (!res.ok) {
                            throw new Error(json.message || 'Could not load list.');
                        }
                        this.rows = json.data || [];
                        this.pagination = Object.assign(this.pagination, json.meta || {});
                        if (json.meta && json.meta.per_page) {
                            this.perPage = json.meta.per_page;
                        }
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
                async destroyRow(id) {
                    if (!this.config.canDelete || !window.confirm('Delete this ' + (this.config.rowLabel || 'record') + '?')) {
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
        }).mount('#rep-workspace-app');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startApp);
    } else {
        startApp();
    }
})();
