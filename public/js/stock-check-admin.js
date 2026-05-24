(function () {
    var root = document.getElementById('tc-stock-check-admin');
    if (!root) {
        return;
    }

    var palletUnit = parseFloat(root.getAttribute('data-pallet-unit') || '30') || 30;
    var subTotal = parseFloat(root.getAttribute('data-subtotal') || '0') || 0;
    var assembleTotal = parseFloat(root.getAttribute('data-assemble') || '0') || 0;
    var fuelTotal = parseFloat(root.getAttribute('data-fuel') || '0') || 0;
    var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    function money(n) {
        return (Math.round(n * 100) / 100).toFixed(2);
    }

    function num(id) {
        var el = document.getElementById(id);
        if (!el) {
            return 0;
        }
        var v = parseFloat(el.value);
        return isNaN(v) ? 0 : v;
    }

    function setText(id, val) {
        var el = document.getElementById(id);
        if (el) {
            el.textContent = money(val);
        }
    }

    function recalc() {
        var pallets = Math.max(1, Math.floor(num('sc_total_pallets')));
        var palletsCost = pallets * palletUnit;
        var delivery = num('sc_delivery_cost');
        var liftgate = num('sc_liftgate_cost');
        var unload = num('sc_unload_cost');
        var misc = num('sc_misc_cost');
        var shippingTotal = delivery + liftgate + unload + palletsCost + misc;
        var orderTotal = subTotal + assembleTotal + fuelTotal + shippingTotal;

        setText('sc-summary-pallets-cost', palletsCost);
        setText('sc-summary-delivery', delivery);
        setText('sc-summary-liftgate', liftgate);
        setText('sc-summary-unload', unload);
        setText('sc-summary-misc', misc);
        setText('sc-total-shipping-charges', shippingTotal);
        setText('sc-display-order-total', orderTotal);

        var palletsCount = document.getElementById('sc-summary-pallets-count');
        if (palletsCount) {
            palletsCount.textContent = String(pallets);
        }
    }

    root.querySelectorAll('.sc-cost-input').forEach(function (input) {
        input.addEventListener('input', recalc);
        input.addEventListener('change', recalc);
    });

    recalc();

    var warehouseForm = document.getElementById('sc-warehouse-email-form');
    if (warehouseForm) {
        warehouseForm.addEventListener('submit', function (event) {
            event.preventDefault();
            var msg = document.getElementById('sc-warehouse-email-msg');
            var email = document.getElementById('sc_warehouse_email')?.value || '';
            if (msg) {
                msg.innerHTML = '';
            }

            fetch(warehouseForm.getAttribute('data-action'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ email: email }),
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    if (!msg) {
                        return;
                    }
                    if (data.status) {
                        msg.innerHTML = '<span class="text-success">Email sent successfully.</span>';
                        document.getElementById('sc_warehouse_email').value = '';
                    } else {
                        msg.innerHTML = '<span class="text-danger">Could not send email. Please try again.</span>';
                    }
                })
                .catch(function () {
                    if (msg) {
                        msg.innerHTML = '<span class="text-danger">Could not send email. Please try again.</span>';
                    }
                });
        });
    }
})();
