/**
 * CI cart_checkout_product fee/total recalculation (fuel, tax, card/ACH fees).
 */
(function () {
    'use strict';

    const cfg = window.owCheckout || {};
    if (!cfg.subTotal) return;

    const $form = document.getElementById('ow-checkout-form');
    if (!$form) return;

    function money(n) {
        return '$' + (Number(n) || 0).toFixed(2);
    }

    function paymentMethod() {
        const el = $form.querySelector('input[name="payment_method"]:checked');
        return el ? el.value : 'Check';
    }

    function recalc() {
        const sub = cfg.subTotal;
        const assemble = cfg.assembleTotal || 0;
        const fuelPct = cfg.fuelPercent || 0;
        const taxPct = cfg.salesTaxPercent || 0;
        const fuel = Math.round(sub * (fuelPct / 100) * 100) / 100;
        const tax = Math.round(sub * (taxPct / 100) * 100) / 100;
        let pre = sub + assemble + fuel + tax;

        const method = paymentMethod().toLowerCase();
        let cardPct = 0;
        let ach = 0;
        if (method.indexOf('credit') >= 0) {
            cardPct = cfg.creditCardPercent || 0;
        } else if (method.indexOf('debit') >= 0) {
            cardPct = cfg.debitCardPercent || 0;
        } else if (method === 'ach') {
            ach = cfg.achCharge || 0;
        }

        const cardFee = cardPct > 0 ? Math.round(pre * (cardPct / 100) * 100) / 100 : 0;
        const grand = Math.round((pre + cardFee + ach) * 100) / 100;

        const set = (id, text) => {
            const el = document.getElementById(id);
            if (el) el.textContent = text;
        };

        set('ow-fuel-amt', money(fuel));
        set('ow-sales-tax', money(tax));
        set('ow-card-fee-amt', money(cardFee));
        set('ow-ach-fee-amt', money(ach));
        set('ow-grand-total', money(grand));

        const cardRow = document.getElementById('ow-card-fee-row');
        if (cardRow) cardRow.style.display = cardFee > 0 ? '' : 'none';
        const achRow = document.getElementById('ow-ach-fee-row');
        if (achRow) achRow.style.display = ach > 0 ? '' : 'none';

        const hid = document.getElementById('ow-grand-total-input');
        if (hid) hid.value = grand.toFixed(2);
        const fuelHid = document.getElementById('ow-fuel-total-input');
        if (fuelHid) fuelHid.value = fuel.toFixed(2);
        const taxHid = document.getElementById('ow-sales-tax-input');
        if (taxHid) taxHid.value = taxPct;
    }

    function togglePaymentPanels() {
        const method = paymentMethod().toLowerCase();
        document.querySelectorAll('.ow-pay-panel').forEach((p) => {
            p.style.display = 'none';
        });
        if (method.indexOf('credit') >= 0 || method.indexOf('debit') >= 0) {
            const panel = document.getElementById('ow-panel-card');
            if (panel) panel.style.display = 'block';
        } else if (method === 'ach') {
            const panel = document.getElementById('ow-panel-ach');
            if (panel) panel.style.display = 'block';
        }
        recalc();
    }

    $form.querySelectorAll('input[name="payment_method"]').forEach((r) => {
        r.addEventListener('change', togglePaymentPanels);
    });

    togglePaymentPanels();
})();
