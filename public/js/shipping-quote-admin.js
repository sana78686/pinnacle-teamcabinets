(function () {
    var root = document.getElementById('tc-shipping-quote-admin');
    if (!root) {
        return;
    }

    var palletUnit = parseFloat(root.getAttribute('data-pallet-unit') || '30') || 30;
    var subTotal = parseFloat(root.getAttribute('data-subtotal') || '0') || 0;
    var assembleTotal = parseFloat(root.getAttribute('data-assemble') || '0') || 0;

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

    function recalc() {
        var pallets = Math.max(1, Math.floor(num('sq_total_pallets')));
        var palletsCost = pallets * palletUnit;
        var delivery = num('sq_delivery_cost');
        var liftgate = num('sq_liftgate_cost');
        var unload = num('sq_unload_cost');
        var misc = num('sq_misc_cost');
        var shippingTotal = delivery + liftgate + unload + palletsCost + misc;
        var orderTotal = subTotal + assembleTotal + shippingTotal;

        var setText = function (id, val) {
            var el = document.getElementById(id);
            if (el) {
                el.textContent = money(val);
            }
        };

        setText('sq-summary-pallets-cost', palletsCost);
        setText('sq-summary-delivery', delivery);
        setText('sq-summary-liftgate', liftgate);
        setText('sq-summary-unload', unload);
        setText('sq-summary-misc', misc);
        setText('sq-total-shipping-charges', shippingTotal);
        setText('sq-display-order-total', orderTotal);

        var palletsCount = document.getElementById('sq-summary-pallets-count');
        if (palletsCount) {
            palletsCount.textContent = String(pallets);
        }
    }

    root.querySelectorAll('.sq-cost-input').forEach(function (input) {
        input.addEventListener('input', recalc);
        input.addEventListener('change', recalc);
    });

    recalc();
})();
