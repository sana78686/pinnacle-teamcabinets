(function () {
    const statusEl = document.getElementById('tc-catalog-sales-status');
    const bodyEl = document.getElementById('tc-catalog-sales-body');
    const url = window.TC_CATALOG_SALES_URL;

    if (!bodyEl || !url) {
        return;
    }

    const fmt = (n) => '$' + Number(n || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    const escapeHtml = (value) => {
        const div = document.createElement('div');
        div.textContent = value == null ? '' : String(value);
        return div.innerHTML;
    };

    const emptyRow = (icon, message, hint) => `
        <tr>
            <td colspan="5" class="p-0 border-0">
                <div class="tc-admin-datatable__empty">
                    <i class="icofont ${icon}" aria-hidden="true"></i>
                    <p class="mb-0">${escapeHtml(message)}</p>
                    ${hint ? `<p class="small text-muted mb-0 mt-1">${escapeHtml(hint)}</p>` : ''}
                </div>
            </td>
        </tr>`;

    const setStatus = (text, visible) => {
        if (!statusEl) {
            return;
        }
        statusEl.textContent = text || '';
        statusEl.classList.toggle('d-none', !visible);
    };

    fetch(url, {
        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin',
    })
        .then((r) => (r.ok ? r.json() : Promise.reject(r)))
        .then((payload) => {
            const data = payload.data || {};
            const catalogs = new Set();
            ['total', 'quarter', 'month', 'week'].forEach((p) => {
                Object.keys(data[p] || {}).forEach((c) => catalogs.add(c));
            });

            const sorted = Array.from(catalogs).sort((a, b) => {
                const ta = (data.total && data.total[a]) || 0;
                const tb = (data.total && data.total[b]) || 0;
                return tb - ta;
            });

            if (!sorted.length) {
                bodyEl.innerHTML = emptyRow(
                    'icofont-chart-bar-graph',
                    'No catalog sales data yet.',
                    'Totals appear after orders with product lines are recorded.'
                );
                setStatus('', false);
                return;
            }

            bodyEl.innerHTML = sorted
                .map((catalog) => {
                    const row = (period) => fmt((data[period] && data[period][catalog]) || 0);
                    const name = escapeHtml(catalog);
                    return `<tr>
                        <td>${name}</td>
                        <td class="text-end">${row('total')}</td>
                        <td class="text-end">${row('quarter')}</td>
                        <td class="text-end">${row('month')}</td>
                        <td class="text-end">${row('week')}</td>
                    </tr>`;
                })
                .join('');

            setStatus(sorted.length + ' catalog' + (sorted.length === 1 ? '' : 's'), true);
        })
        .catch(() => {
            bodyEl.innerHTML = emptyRow(
                'icofont-warning',
                'Could not load catalog sales.',
                'Refresh the page or try again in a moment.'
            );
            setStatus('', false);
        });
})();
