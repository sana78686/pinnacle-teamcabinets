(function () {
    window.TenantUserDoorFactors = function (config) {
        const pointFactorDefaults = config.pointFactorDefaults || {};
        const roleDefaultUrl = config.roleDefaultUrl || '';
        const csrf = config.csrf || '';

        const emptyState = document.getElementById('door-factor-empty');
        const setState = document.getElementById('door-factor-set');
        const countEl = document.getElementById('door-factor-count');
        const applyAllBtn = document.getElementById('apply-default-factors');

        function doorFactorInputs() {
            return document.querySelectorAll('.door-factor-input');
        }

        function visibleDoorInputs(catalogId) {
            const container = document.querySelector('.door-colors-container[data-catalog-id="' + catalogId + '"]');
            if (!container || container.style.display === 'none') {
                return [];
            }
            return container.querySelectorAll('.door-factor-input');
        }

        function filledCount() {
            let n = 0;
            doorFactorInputs().forEach(function (input) {
                if (String(input.value || '').trim() !== '') {
                    n++;
                }
            });
            return n;
        }

        function updateDoorFactorStatus() {
            const count = filledCount();
            if (!emptyState || !setState) {
                return;
            }
            if (count > 0) {
                emptyState.classList.add('d-none');
                setState.classList.remove('d-none');
                if (countEl) {
                    countEl.textContent = String(count);
                }
            } else {
                emptyState.classList.remove('d-none');
                setState.classList.add('d-none');
            }
        }

        function roleDefaultKey(roleName) {
            if (!roleName) {
                return null;
            }
            const base = String(roleName).toLowerCase().trim().replace(/\s+/g, '-');
            if (pointFactorDefaults[base] !== undefined) {
                return base;
            }
            const plural = base.endsWith('s') ? base : base + 's';
            if (pointFactorDefaults[plural] !== undefined) {
                return plural;
            }
            const singular = base.replace(/s$/, '');
            if (pointFactorDefaults[singular] !== undefined) {
                return singular;
            }
            return null;
        }

        function localDefaultForRole(roleName) {
            const key = roleDefaultKey(roleName);
            return key ? pointFactorDefaults[key] : null;
        }

        async function fetchRoleDefault(roleId, roleName) {
            if (!roleDefaultUrl) {
                return localDefaultForRole(roleName);
            }
            try {
                const url = roleDefaultUrl + '?role_id=' + encodeURIComponent(roleId);
                const res = await fetch(url, {
                    headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                });
                const data = await res.json();
                if (data.success && data.default_factor != null) {
                    return String(data.default_factor);
                }
            } catch (e) {
                /* fallback below */
            }
            return localDefaultForRole(roleName);
        }

        function applyDefaultToInputs(inputs, value, onlyEmpty) {
            inputs.forEach(function (input) {
                if (!onlyEmpty || String(input.value || '').trim() === '') {
                    input.value = value;
                }
            });
            updateDoorFactorStatus();
        }

        function bindCatalogCheckboxes() {
            document.querySelectorAll('.product-catalog-checkbox').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const catalogId = this.dataset.catalogId;
                    const container = document.querySelector('.door-colors-container[data-catalog-id="' + catalogId + '"]');
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
                    updateDoorFactorStatus();
                });
            });
        }

        function bindPerCatalogApply() {
            document.querySelectorAll('[data-apply-catalog-default]').forEach(function (btn) {
                btn.addEventListener('click', async function () {
                    const catalogId = btn.dataset.applyCatalogDefault;
                    const roleData = config.getSelectedRole ? config.getSelectedRole() : null;
                    if (!roleData || !roleData.id) {
                        alert('Select a user type first.');
                        return;
                    }
                    const value = await fetchRoleDefault(roleData.id, roleData.text);
                    if (value == null) {
                        alert('No default factor for this role.');
                        return;
                    }
                    applyDefaultToInputs(visibleDoorInputs(catalogId), value, false);
                });
            });
        }

        function bindModalOpen() {
            document.querySelectorAll('.btn-import').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const el = document.getElementById('importModal');
                    if (el && window.bootstrap && bootstrap.Modal) {
                        bootstrap.Modal.getOrCreateInstance(el).show();
                    }
                });
            });
        }

        function bindRoleChange() {
            const roleEl = document.getElementById('search_role');
            if (!roleEl || !window.jQuery) {
                return;
            }
            jQuery(roleEl).on('select2:select', async function (e) {
                const val = await fetchRoleDefault(e.params.data.id, e.params.data.text);
                if (applyAllBtn) {
                    applyAllBtn.classList.toggle('d-none', val == null);
                }
            }).on('select2:clear', function () {
                if (applyAllBtn) {
                    applyAllBtn.classList.add('d-none');
                }
            });
        }

        function bindApplyAll() {
            if (!applyAllBtn) {
                return;
            }
            applyAllBtn.addEventListener('click', async function () {
                const checked = document.querySelectorAll('.product-catalog-checkbox:checked');
                if (checked.length === 0) {
                    const el = document.getElementById('importModal');
                    if (el && window.bootstrap && bootstrap.Modal) {
                        bootstrap.Modal.getOrCreateInstance(el).show();
                    }
                    alert('Select at least one product catalog first.');
                    return;
                }
                const roleData = config.getSelectedRole ? config.getSelectedRole() : null;
                if (!roleData) {
                    alert('Select a user type first.');
                    return;
                }
                const value = await fetchRoleDefault(roleData.id, roleData.text);
                if (value == null) {
                    alert('No default factor for this role.');
                    return;
                }
                checked.forEach(function (cb) {
                    applyDefaultToInputs(visibleDoorInputs(cb.dataset.catalogId), value, true);
                });
            });
        }

        doorFactorInputs().forEach(function (input) {
            input.addEventListener('input', updateDoorFactorStatus);
        });

        bindCatalogCheckboxes();
        bindPerCatalogApply();
        bindModalOpen();
        bindRoleChange();
        bindApplyAll();
        updateDoorFactorStatus();

        return { updateDoorFactorStatus: updateDoorFactorStatus };
    };
})();
