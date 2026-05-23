(function () {
    document.addEventListener('DOMContentLoaded', function () {
        const panel = document.querySelector('[data-tc-commission-settings]');
        if (!panel) {
            return;
        }

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const baseUrl = panel.dataset.patchBase || '';

        function showToast(message, ok) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: ok ? 'success' : 'error',
                    title: message,
                    showConfirmButton: false,
                    timer: 2200,
                });
            }
        }

        panel.querySelectorAll('[data-tc-commission-role]').forEach(function (row) {
            const input = row.querySelector('[data-tc-commission-input]');
            const pctCell = row.querySelector('[data-tc-commission-pct]');
            const role = row.dataset.tcCommissionRole;
            if (!input || !role) {
                return;
            }

            let saving = false;

            function updatePct(val) {
                if (!pctCell) {
                    return;
                }
                if (val === '' || isNaN(val)) {
                    pctCell.textContent = '—';
                    return;
                }
                pctCell.textContent = (parseFloat(val) * 100).toFixed(2) + '%';
            }

            input.addEventListener('input', function () {
                updatePct(input.value);
            });

            async function save() {
                const val = String(input.value || '').trim();
                if (val === '' || isNaN(val)) {
                    return;
                }
                if (saving) {
                    return;
                }
                saving = true;
                row.classList.add('tc-commission-row--saving');

                try {
                    const res = await fetch(baseUrl + encodeURIComponent(role), {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({ default_factor: parseFloat(val) }),
                    });
                    const data = await res.json().catch(function () {
                        return {};
                    });
                    if (res.ok && data.success) {
                        row.classList.add('tc-commission-row--saved');
                        setTimeout(function () {
                            row.classList.remove('tc-commission-row--saved');
                        }, 1500);
                        showToast('Saved ' + (data.role || role), true);
                    } else {
                        showToast(data.message || 'Could not save', false);
                    }
                } catch (e) {
                    showToast('Could not save', false);
                } finally {
                    saving = false;
                    row.classList.remove('tc-commission-row--saving');
                }
            }

            input.addEventListener('change', save);
            input.addEventListener('blur', save);
        });
    });
})();
