(function () {
    'use strict';

    var state = {
        userId: null,
        saveUrl: '',
        formUrl: '',
        csrf: '',
        pointFactorDefaults: {},
        roleDefaultUrl: '',
    };

    function modalEl() {
        return document.getElementById('userApprovalSetupModal');
    }

    function bodyEl() {
        return document.getElementById('userApprovalSetupModalBody');
    }

    function showModal() {
        var el = modalEl();
        if (!el) {
            return;
        }
        if (window.bootstrap && bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(el).show();
        } else if (window.jQuery) {
            jQuery(el).modal('show');
        }
    }

    function hideModal() {
        var el = modalEl();
        if (!el) {
            return;
        }
        if (window.bootstrap && bootstrap.Modal) {
            var instance = bootstrap.Modal.getInstance(el);
            if (instance) {
                instance.hide();
            }
        } else if (window.jQuery) {
            jQuery(el).modal('hide');
        }
    }

    function bindCatalogCheckboxes(root) {
        root.querySelectorAll('.product-catalog-checkbox').forEach(function (checkbox) {
            if (checkbox.dataset.approvalBound === '1') {
                return;
            }
            checkbox.dataset.approvalBound = '1';
            checkbox.addEventListener('change', function () {
                var catalogId = this.dataset.catalogId;
                var container = root.querySelector('.door-colors-container[data-catalog-id="' + catalogId + '"]');
                if (!container) {
                    return;
                }
                if (this.checked) {
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                    container.querySelectorAll('.door-factor-input').forEach(function (input) {
                        input.value = '';
                    });
                }
            });
        });
    }

    function roleDefaultKey(roleName) {
        if (!roleName) {
            return null;
        }
        var base = String(roleName).toLowerCase().trim().replace(/\s+/g, '-');
        if (state.pointFactorDefaults[base] !== undefined) {
            return base;
        }
        var plural = base.endsWith('s') ? base : base + 's';
        if (state.pointFactorDefaults[plural] !== undefined) {
            return plural;
        }
        var singular = base.replace(/s$/, '');
        if (state.pointFactorDefaults[singular] !== undefined) {
            return singular;
        }
        return null;
    }

    function localDefaultForRole(roleName) {
        var key = roleDefaultKey(roleName);
        return key ? state.pointFactorDefaults[key] : null;
    }

    async function fetchRoleDefault(roleName) {
        if (!state.roleDefaultUrl) {
            return localDefaultForRole(roleName);
        }
        try {
            var url = state.roleDefaultUrl + '?role=' + encodeURIComponent(roleName || '');
            var res = await fetch(url, {
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            });
            var data = await res.json();
            if (data.success && data.default_factor != null) {
                return String(data.default_factor);
            }
        } catch (e) {
            /* ignore */
        }
        return localDefaultForRole(roleName);
    }

    function bindApplyDefaults(root, roleName) {
        root.querySelectorAll('[data-apply-catalog-default]').forEach(function (btn) {
            if (btn.dataset.approvalBound === '1') {
                return;
            }
            btn.dataset.approvalBound = '1';
            btn.addEventListener('click', async function () {
                var catalogId = btn.dataset.applyCatalogDefault;
                var value = await fetchRoleDefault(roleName);
                if (value == null) {
                    alert('No default factor for this user type.');
                    return;
                }
                var container = root.querySelector('.door-colors-container[data-catalog-id="' + catalogId + '"]');
                if (!container || container.style.display === 'none') {
                    return;
                }
                container.querySelectorAll('.door-factor-input').forEach(function (input) {
                    input.value = value;
                });
            });
        });
    }

    function collectPayload(root) {
        var catalogVisibility = {};
        root.querySelectorAll('.product-catalog-checkbox:checked').forEach(function (cb) {
            catalogVisibility[cb.dataset.catalogId] = cb.value;
        });

        var doorFactors = {};
        root.querySelectorAll('.door-colors-container').forEach(function (container) {
            var catalogId = container.dataset.catalogId;
            if (!catalogId) {
                return;
            }
            doorFactors[catalogId] = {};
            container.querySelectorAll('.door-factor-input').forEach(function (input) {
                var match = input.name.match(/door_factors\[(\d+)\]\[(\d+)\]/);
                if (match) {
                    doorFactors[match[1]][match[2]] = input.value;
                }
            });
        });

        return {
            catalog_visibility: catalogVisibility,
            door_factors: doorFactors,
        };
    }

    function updateDoorFactorsCell(userId, summary) {
        if (!summary) {
            return;
        }
        var row = document.querySelector('[data-tc-user-row-id="' + userId + '"]');
        if (!row) {
            return;
        }
        var cell = row.querySelector('[data-tc-user-door-summary]');
        if (!cell) {
            return;
        }
        if (summary.catalogs > 0 || summary.door_styles > 0) {
            cell.innerHTML =
                '<span class="tc-door-factor-summary" title="' + summary.catalogs + ' catalog(s), ' + summary.door_styles + ' door style(s)">' +
                summary.catalogs + ' catalog' + (summary.catalogs === 1 ? '' : 's') + ', ' +
                summary.door_styles + ' door' + (summary.door_styles === 1 ? '' : 's') +
                '</span>';
        } else {
            cell.innerHTML = '<span class="text-muted small">Not configured</span>';
        }
    }

    async function saveSetup() {
        if (!state.userId || !state.saveUrl) {
            return;
        }
        var root = bodyEl();
        if (!root) {
            return;
        }

        var saveBtn = document.getElementById('userApprovalSetupSave');
        if (saveBtn) {
            saveBtn.disabled = true;
        }

        try {
            var res = await fetch(state.saveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': state.csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(collectPayload(root)),
            });
            var data = await res.json();

            if (!data.success) {
                var msg = data.message || 'Could not save catalog settings.';
                if (window.Swal) {
                    Swal.fire('Error', msg, 'error');
                } else {
                    alert(msg);
                }
                return;
            }

            updateDoorFactorsCell(state.userId, data.summary);
            hideModal();

            if (window.Swal) {
                Swal.fire('Saved', data.message || 'Catalog settings saved.', 'success');
            }
        } catch (e) {
            console.error(e);
            if (window.Swal) {
                Swal.fire('Error', 'Something went wrong while saving.', 'error');
            }
        } finally {
            if (saveBtn) {
                saveBtn.disabled = false;
            }
        }
    }

    async function open(userId) {
        if (!userId || !state.formUrl) {
            return;
        }

        state.userId = userId;
        var root = bodyEl();
        var subtitle = document.getElementById('userApprovalSetupModalSubtitle');
        var saveBtn = document.getElementById('userApprovalSetupSave');

        if (root) {
            root.innerHTML = '<p class="text-muted mb-0">Loading…</p>';
        }
        if (saveBtn) {
            saveBtn.disabled = true;
        }

        showModal();

        try {
            var url = state.formUrl.replace(':id', String(userId)).replace('__ID__', String(userId));
            var res = await fetch(url, {
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            });
            var data = await res.json();

            if (!data.success) {
                if (root) {
                    root.innerHTML = '<p class="text-danger">' + (data.message || 'Could not load setup form.') + '</p>';
                }
                return;
            }

            if (root) {
                root.innerHTML = data.html || '';
            }

            if (subtitle && data.user) {
                var label = data.user.name || data.user.username || 'User';
                if (data.user.role) {
                    label += ' · ' + data.user.role;
                }
                subtitle.textContent = label;
            }

            bindCatalogCheckboxes(root);
            bindApplyDefaults(root, data.user ? data.user.role : null);

            var incomplete = root.querySelector('.tc-door-factor-setup-empty, [data-door-factor-setup-empty]');
            if (saveBtn) {
                saveBtn.disabled = !!incomplete;
            }
        } catch (e) {
            console.error(e);
            if (root) {
                root.innerHTML = '<p class="text-danger">Failed to load catalog setup.</p>';
            }
        }
    }

    function bindGlobals() {
        var cfg = window.TC_USER_APPROVAL_SETUP || {};
        state.formUrl = cfg.formUrl || '';
        state.saveUrl = cfg.saveUrl || '';
        state.csrf = cfg.csrf || '';
        state.pointFactorDefaults = cfg.pointFactorDefaults || {};
        state.roleDefaultUrl = cfg.roleDefaultUrl || '';

        var saveBtn = document.getElementById('userApprovalSetupSave');
        if (saveBtn && saveBtn.dataset.bound !== '1') {
            saveBtn.dataset.bound = '1';
            saveBtn.addEventListener('click', saveSetup);
        }

        document.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-tc-user-catalog-setup]');
            if (btn) {
                e.preventDefault();
                open(btn.dataset.userId);
            }
        });
    }

    window.TenantUserApprovalSetup = {
        open: open,
        bindGlobals: bindGlobals,
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bindGlobals);
    } else {
        bindGlobals();
    }
})();
