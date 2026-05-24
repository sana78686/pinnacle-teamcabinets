(function () {
    'use strict';

    function startApp() {
        const config = window.COMMISSION_REPORT_LIST;
        if (!config || !window.Vue) {
            return;
        }

        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    config,
                    rows: [],
                    representatives: [],
                    filters: { rep_id: '', from: '', to: '' },
                    loading: false,
                    flash: null,
                };
            },
            mounted() {
                this.fetchData();
            },
            methods: {
                headers() {
                    return {
                        'X-CSRF-TOKEN': config.csrf,
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    };
                },
                apiUrl(template, id) {
                    return String(template).replace('__ID__', String(id));
                },
                async fetchData() {
                    this.loading = true;
                    try {
                        const res = await fetch(config.dataUrl + '?' + new URLSearchParams(this.filters), {
                            headers: this.headers(),
                        });
                        const json = await res.json();
                        this.rows = json.data || [];
                        if (json.representatives) {
                            this.representatives = json.representatives;
                        }
                    } catch (e) {
                        this.flash = { ok: false, text: 'Failed to load commission report.' };
                    } finally {
                        this.loading = false;
                    }
                },
                resetFilters() {
                    this.filters = { rep_id: '', from: '', to: '' };
                    this.fetchData();
                },
                exportCsv() {
                    const params = new URLSearchParams(this.filters).toString();
                    window.location.href = config.exportUrl + (params ? '?' + params : '');
                },
                orderUrl(id) {
                    return this.apiUrl(config.orderShowUrl, id);
                },
                async deleteOrder(id) {
                    if (!confirm('Remove this order from the commission report?')) {
                        return;
                    }
                    try {
                        await fetch(this.apiUrl(config.destroyUrl, id), {
                            method: 'DELETE',
                            headers: this.headers(),
                        });
                        this.fetchData();
                    } catch (e) {
                        this.flash = { ok: false, text: 'Could not remove order.' };
                    }
                },
                async restoreOrder(id) {
                    if (!confirm('Restore this order to the commission report?')) {
                        return;
                    }
                    try {
                        await fetch(this.apiUrl(config.restoreUrl, id), {
                            method: 'POST',
                            headers: this.headers(),
                        });
                        this.fetchData();
                    } catch (e) {
                        this.flash = { ok: false, text: 'Could not restore order.' };
                    }
                },
                fmt(val) {
                    const n = parseFloat(val);
                    if (Number.isNaN(n)) {
                        return 'N/A';
                    }

                    return '$' + n.toFixed(2);
                },
                show(val) {
                    if (val === null || val === undefined || val === '' || val === 0) {
                        return 'N/A';
                    }

                    return val;
                },
            },
        }).mount('#commission-report-app');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startApp);
    } else {
        startApp();
    }
})();
