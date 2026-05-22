(function () {
    var csrf = document.querySelector('meta[name="csrf-token"]');
    var token = csrf ? csrf.getAttribute('content') : '';

    function postUpdate(row, data) {
        var url = row.getAttribute('data-update-url');
        if (!url) return;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                Accept: 'application/json',
            },
            body: JSON.stringify(Object.assign({
                order_id: row.getAttribute('data-order-id') || 0,
                sc_id: row.getAttribute('data-sc-id') || 0,
                mq_id: row.getAttribute('data-mq-id') || 0,
            }, data)),
        }).catch(function () {});
    }

    function markRowViewed(row) {
        var url = row.getAttribute('data-mark-viewed-url');
        var type = row.getAttribute('data-mark-viewed-type');
        var id = row.getAttribute('data-mark-viewed-id');
        if (!url || !type || !id || id === '0') return;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                Accept: 'application/json',
            },
            body: JSON.stringify({ type: type, id: parseInt(id, 10) }),
        }).then(function () {
            row.classList.remove('tc-row-unviewed');
        }).catch(function () {});
    }

    function recalcMargin(row) {
        var subTotal = parseFloat(row.getAttribute('data-sub-total')) || 0;
        var tax = parseFloat(row.getAttribute('data-tax')) || 0;
        var shipping = parseFloat(row.querySelector('.tc-tracker-ship')?.value) || 0;
        var assembly = parseFloat(row.getAttribute('data-assemble')) || 0;
        var cc = parseFloat(row.getAttribute('data-cc')) || 0;
        var fuel = parseFloat(row.getAttribute('data-fuel')) || 0;
        var misc = parseFloat(row.querySelector('.tc-tracker-misc')?.value) || 0;
        var delivery = parseFloat(row.querySelector('.tc-tracker-delivery')?.value) || 0;

        var margin = subTotal - (tax + shipping + cc + fuel + assembly + misc + delivery);
        var pct = subTotal !== 0 ? (margin / subTotal) * 100 : 0;
        var cell = row.querySelector('.tc-tracker-margin');
        if (!cell) return;

        cell.textContent = '$' + margin.toFixed(2);
        cell.classList.toggle('is-positive', pct >= 20);
        cell.classList.toggle('is-negative', pct < 20);
    }

    function bindRow(mainRow, detailRow) {
        [mainRow, detailRow].forEach(function (row) {
            if (!row) return;
            row.querySelectorAll('.tc-tracker-field').forEach(function (el) {
                var eventName = el.tagName === 'SELECT' ? 'change' : 'blur';
                el.addEventListener(eventName, function () {
                    var name = el.getAttribute('name');
                    if (!name) return;
                    var data = {};
                    data[name] = el.value;
                    postUpdate(mainRow, data);
                    if (
                        el.classList.contains('tc-tracker-ship')
                        || el.classList.contains('tc-tracker-misc')
                        || el.classList.contains('tc-tracker-delivery')
                        || el.classList.contains('tc-tracker-vendor-amount')
                    ) {
                        recalcMargin(mainRow);
                    }
                });
            });
        });
    }

    function bindToggle(btn) {
        btn.addEventListener('click', function () {
            var detailId = btn.getAttribute('data-tracker-toggle');
            var mainRow = btn.closest('.tc-tracker-row');
            var detail = mainRow ? mainRow.nextElementSibling : null;
            if (!detail || !detail.classList.contains('tc-tracker-detail-row')) return;

            var open = detail.classList.toggle('d-none') === false;
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            btn.classList.toggle('is-open', open);

            if (open && mainRow) {
                markRowViewed(mainRow);
            }

            if (window.feather) {
                var icon = btn.querySelector('[data-feather]');
                if (icon) {
                    icon.setAttribute('data-feather', open ? 'chevron-up' : 'chevron-down');
                    feather.replace({ scope: btn });
                }
            }
        });
    }

    function initSelect2() {
        if (!window.jQuery || !jQuery.fn.select2) return;

        jQuery('.tc-select2-search').each(function () {
            var $el = jQuery(this);
            if ($el.data('select2')) return;
            $el.select2({
                width: '100%',
                minimumResultsForSearch: 0,
                dropdownAutoWidth: true,
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.tc-tracker-row').forEach(function (mainRow) {
            var detail = mainRow.nextElementSibling;
            if (detail && detail.classList.contains('tc-tracker-detail-row')) {
                bindRow(mainRow, detail);
            } else {
                bindRow(mainRow, null);
            }
        });

        document.querySelectorAll('.tc-tracker-toggle').forEach(bindToggle);
        initSelect2();

        if (window.jQuery && jQuery.fn.DataTable && document.getElementById('tcRecentOrdersTable')) {
            jQuery('#tcRecentOrdersTable').DataTable({
                pageLength: 10,
                order: [[0, 'desc']],
            });
        }

        if (window.feather) {
            feather.replace();
        }
    });
})();
