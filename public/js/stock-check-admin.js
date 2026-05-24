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

    var shippingForm = document.getElementById('sc-admin-shipping-form');
    if (shippingForm) {
        root.querySelectorAll('.sc-cost-input').forEach(function (input) {
            input.addEventListener('input', recalc);
            input.addEventListener('change', recalc);
        });
        recalc();
    }

    function validateEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }

    function showWarehouseMsg(html, isError) {
        var msg = document.getElementById('sc-warehouse-email-msg');
        if (msg) {
            msg.innerHTML = html;
            msg.className = 'small mt-1' + (isError ? ' text-danger' : ' text-success');
        }
        var topMsg = document.getElementById('sc-status-msg');
        if (topMsg) {
            topMsg.style.display = 'block';
            topMsg.innerHTML = html;
            topMsg.className = 'alert alert-' + (isError ? 'danger' : 'success') + ' py-2 mb-3';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    var warehouseForm = document.getElementById('sc-warehouse-email-form');
    if (warehouseForm) {
        var submitBtn = warehouseForm.querySelector('button[type="submit"]');
        var emailInput = document.getElementById('sc_warehouse_email');

        warehouseForm.addEventListener('submit', function (event) {
            event.preventDefault();
            var email = (emailInput?.value || '').trim();

            if (email === '') {
                showWarehouseMsg('<span>Please enter Warehouse Email.</span>', true);
                emailInput?.focus();
                return;
            }

            if (!validateEmail(email)) {
                showWarehouseMsg('<span>Please enter a valid Email.</span>', true);
                emailInput?.focus();
                return;
            }

            if (submitBtn) {
                submitBtn.disabled = true;
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
                    if (data.status) {
                        showWarehouseMsg('<span>Your email is successfully delivered.</span>', false);
                        if (emailInput) {
                            emailInput.value = '';
                        }
                        setTimeout(function () {
                            var msg = document.getElementById('sc-warehouse-email-msg');
                            if (msg) {
                                msg.innerHTML = '';
                            }
                            var topMsg = document.getElementById('sc-status-msg');
                            if (topMsg) {
                                topMsg.style.display = 'none';
                                topMsg.innerHTML = '';
                            }
                        }, 5000);
                    } else {
                        showWarehouseMsg('<span>Some problem occurred, please try again.</span>', true);
                    }
                })
                .catch(function () {
                    showWarehouseMsg('<span>Some problem occurred, please try again.</span>', true);
                })
                .finally(function () {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                    }
                });
        });
    }
})();
