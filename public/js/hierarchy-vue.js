(function () {
    'use strict';

    function startApp() {
        const config = window.HIERARCHY_CONFIG;
        if (!config || !window.Vue) {
            return;
        }

        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    config,
                    tree: {
                        rep_show_data: {},
                        rep_dealer_data: {},
                        rep_distri_data: {},
                        dealer_showroom_data: [],
                    },
                    representatives: [],
                    connectedReps: [],
                    repUsers: [],
                    midTierUsers: [],
                    repToConnect: '',
                    connectForm: { user_id: '', rep_id: '' },
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
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    };
                },
                async fetchData() {
                    this.loading = true;
                    try {
                        const res = await fetch(config.dataUrl, { headers: this.headers() });
                        const json = await res.json();
                        this.tree = {
                            rep_show_data: json.rep_show_data || {},
                            rep_dealer_data: json.rep_dealer_data || {},
                            rep_distri_data: json.rep_distri_data || {},
                            dealer_showroom_data: json.dealer_showroom_data || [],
                        };
                        this.representatives = json.representatives || [];
                        const all = json.all_users || [];
                        this.repUsers = all.filter((u) => u.user_type === 'representatives');
                        this.midTierUsers = all.filter((u) =>
                            ['showrooms', 'dealers', 'distributors'].includes(u.user_type)
                        );
                        const adminId = json.admin_id;
                        this.connectedReps = adminId
                            ? all.filter(
                                  (u) => u.user_type === 'representatives' && u.parent_id === adminId
                              )
                            : this.representatives;
                    } catch (e) {
                        this.flash = { ok: false, text: 'Failed to load hierarchy.' };
                    } finally {
                        this.loading = false;
                    }
                },
                async connectRepToAdmin() {
                    try {
                        const res = await fetch(config.connectRepUrl, {
                            method: 'POST',
                            headers: this.headers(),
                            body: JSON.stringify({ user_id: this.repToConnect }),
                        });
                        const json = await res.json();
                        this.flash = {
                            ok: json.success,
                            text: json.message || (json.success ? 'Connected.' : 'Failed.'),
                        };
                        this.repToConnect = '';
                        await this.fetchData();
                    } catch (e) {
                        this.flash = { ok: false, text: 'Could not connect representative.' };
                    }
                },
                async connectToRep() {
                    try {
                        const res = await fetch(config.connectToRepUrl, {
                            method: 'POST',
                            headers: this.headers(),
                            body: JSON.stringify(this.connectForm),
                        });
                        const json = await res.json();
                        this.flash = {
                            ok: json.success,
                            text: json.message || (json.success ? 'Connected.' : 'Failed.'),
                        };
                        this.connectForm = { user_id: '', rep_id: '' };
                        await this.fetchData();
                    } catch (e) {
                        this.flash = { ok: false, text: 'Could not connect user.' };
                    }
                },
            },
        }).mount('#hierarchy-app');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startApp);
    } else {
        startApp();
    }
})();
