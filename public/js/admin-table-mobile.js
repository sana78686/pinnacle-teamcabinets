/**
 * Pinnacle super-admin tables — mobile card layout with column labels.
 */
(function () {
    function initAdminTables() {
        document.querySelectorAll('.admin-table-wrap').forEach(function (wrap) {
            var table = wrap.querySelector('.admin-table');
            if (!table || table.dataset.mobileLabels === '1') {
                return;
            }

            var headers = [];
            table.querySelectorAll('thead th').forEach(function (th, i) {
                headers[i] = (th.textContent || '').trim();
            });

            table.querySelectorAll('tbody tr').forEach(function (tr) {
                if (tr.classList.contains('admin-table-empty')) {
                    return;
                }
                tr.querySelectorAll('td').forEach(function (td, i) {
                    if (headers[i]) {
                        td.setAttribute('data-label', headers[i]);
                    }
                });
            });

            table.dataset.mobileLabels = '1';
            wrap.classList.add('admin-table-wrap--stackable');
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAdminTables);
    } else {
        initAdminTables();
    }
})();
