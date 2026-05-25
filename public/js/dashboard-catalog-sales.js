(function () {
    const statusEl = document.getElementById('tc-catalog-sales-status');
    const bodyEl = document.getElementById('tc-catalog-sales-body');
    const url = window.TC_CATALOG_SALES_URL;

    if (!bodyEl || !url) {
        return;
    }

    const fmt = (n) => '$' + Number(n || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

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
                bodyEl.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">No completed order catalog data yet.</td></tr>';
                if (statusEl) statusEl.textContent = 'No data';
                return;
            }

            bodyEl.innerHTML = sorted
                .map((catalog) => {
                    const row = (period) => fmt((data[period] && data[period][catalog]) || 0);
                    return `<tr>
                        <td>${catalog}</td>
                        <td class="text-end">${row('total')}</td>
                        <td class="text-end">${row('quarter')}</td>
                        <td class="text-end">${row('month')}</td>
                        <td class="text-end">${row('week')}</td>
                    </tr>`;
                })
                .join('');

            if (statusEl) statusEl.textContent = sorted.length + ' catalog(s)';
        })
        .catch(() => {
            bodyEl.innerHTML = '<tr><td colspan="5" class="text-center text-danger py-4">Could not load catalog sales.</td></tr>';
            if (statusEl) statusEl.textContent = 'Error';
        });
})();
