/**
 * CI cart_checkout_product — totals, county tax, payment panels, validation.
 */
(function () {
    'use strict';

    const cfg = window.owCheckout || {};
    const form = document.getElementById('ow-checkout-form');
    if (!form || cfg.subTotal == null) {
        return;
    }

    const salesTaxUrl = cfg.salesTaxUrl || '';
    const floridaCounties = cfg.floridaCounties || [];

    function money(n) {
        return '$' + (Number(n) || 0).toFixed(2);
    }

    function paymentType() {
        const el = form.querySelector('input[name="credit_or_not_credit_card"]:checked');
        return el ? el.value : 'by_credit_card';
    }

    function prePaymentTotals(taxPct) {
        const sub = cfg.subTotal;
        const assemble = cfg.assembleTotal || 0;
        const shipping = cfg.shippingCost || 0;
        const fuelPct = cfg.fuelPercent || 0;
        const fuel = Math.round(sub * (fuelPct / 100) * 100) / 100;
        const tax = Math.round(sub * ((taxPct ?? cfg.salesTaxPercent) / 100) * 100) / 100;
        const pre = sub + assemble + fuel + tax + shipping;
        return { sub, assemble, shipping, fuel, tax, pre };
    }

    function feeForMethod(type, pre) {
        const creditPct = cfg.creditCardPercent || 0;
        const debitFlat = cfg.debitCardFlat || 0;
        const achFlat = cfg.achCharge || 0;

        if (type === 'by_credit_card') {
            const amt = creditPct > 0 ? Math.round(pre * (creditPct / 100) * 100) / 100 : 0;
            return { kind: 'credit', label: 'Credit Card Charges', amount: amt, percent: creditPct };
        }
        if (type === 'by_debit_card') {
            return { kind: 'debit', label: 'Debit Card Charges', amount: debitFlat, percent: 0 };
        }
        if (type === 'pay_ach') {
            return { kind: 'ach', label: 'ACH Charges', amount: achFlat, percent: 0 };
        }
        return { kind: 'none', label: '', amount: 0, percent: 0 };
    }

    function recalc(taxPct) {
        const type = paymentType();
        const t = prePaymentTotals(taxPct);
        const fee = feeForMethod(type, t.pre);
        const grand = Math.round((t.pre + fee.amount) * 100) / 100;

        const set = (id, text) => {
            const el = document.getElementById(id);
            if (el) {
                el.textContent = text;
            }
        };

        set('ow-fuel-amt', money(t.fuel));
        set('ow-sales-tax', money(t.tax));
        set('ow-tax-percent', (taxPct ?? cfg.salesTaxPercent) + '%');
        set('ow-grand-total', money(grand));
        set('ow-assemble-subtotal', money(t.assemble));
        set('ow-assemble-total', money(t.assemble));

        const paymentFeeRow = document.getElementById('ow-payment-fee-row');
        const feeLabel = document.getElementById('ow-payment-fee-label');

        if (paymentFeeRow) {
            if (fee.kind === 'none') {
                paymentFeeRow.style.display = 'none';
            } else {
                paymentFeeRow.style.display = '';
            }
        }
        if (feeLabel && fee.kind !== 'none') {
            feeLabel.textContent =
                fee.kind === 'credit' && fee.percent > 0
                    ? fee.label + ' (' + fee.percent + '%)'
                    : fee.label;
        }
        set('ow-payment-fee-amt', money(fee.kind === 'none' ? 0 : fee.amount));

        const hidGrand = document.getElementById('ow-grand-total-input');
        if (hidGrand) {
            hidGrand.value = grand.toFixed(2);
        }
        const hidFuel = document.getElementById('ow-fuel-total-input');
        if (hidFuel) {
            hidFuel.value = t.fuel.toFixed(2);
        }
        const hidTax = document.getElementById('ow-sales-tax-input');
        if (hidTax) {
            hidTax.value = (taxPct ?? cfg.salesTaxPercent);
        }

        updateSavings(t);
    }

    function updateSavings(t) {
        const creditPct = cfg.creditCardPercent || 0;
        const creditFee = creditPct > 0 ? Math.round(t.pre * (creditPct / 100) * 100) / 100 : 0;
        const debitSave = Math.max(0, creditFee - (cfg.debitCardFlat || 0));
        const achSave = Math.max(0, creditFee - (cfg.achCharge || 0));

        const setSave = (sel, amt, creditStyle) => {
            document.querySelectorAll(sel).forEach((el) => {
                if (creditStyle) {
                    el.textContent = '(You save nothing.)';
                    return;
                }
                el.textContent = 'You save ' + money(amt);
            });
        };
        setSave('[data-save-credit]', 0, true);
        setSave('[data-save-debit]', debitSave, false);
        setSave('[data-save-ach]', achSave, false);
        setSave('[data-save-cash]', creditFee, false);
    }

    function syncPaymentPanels() {
        const type = paymentType();
        document.querySelectorAll('.tc-checkout__pay-card').forEach((card) => {
            const radio = card.querySelector('input[name="credit_or_not_credit_card"]');
            const active = radio && radio.checked;
            card.classList.toggle('is-active', active);
        });
        recalc(parseFloat(document.getElementById('ow-sales-tax-input')?.value || cfg.salesTaxPercent));
    }

    function isFlorida(state) {
        const s = (state || '').toLowerCase().trim();
        return s === 'florida' || s === 'fl';
    }

    function renderCountyField(state, selected) {
        const wrap = document.getElementById('ow-ship-county-wrap');
        if (!wrap) {
            return;
        }
        if (isFlorida(state) && floridaCounties.length) {
            let html = '<select class="form-control form-control-sm" name="ship_county" id="ship_county">';
            floridaCounties.forEach((c) => {
                const sel = c === selected ? ' selected' : '';
                html += '<option value="' + c + '"' + sel + '>' + c + '</option>';
            });
            html += '</select>';
            wrap.innerHTML = html;
        } else {
            wrap.innerHTML =
                '<input type="text" class="form-control form-control-sm" name="ship_county" id="ship_county" value="' +
                (selected || '').replace(/"/g, '&quot;') +
                '">';
        }
        const countyEl = document.getElementById('ship_county');
        if (countyEl) {
            countyEl.addEventListener('change', fetchSalesTax);
        }
    }

    function fetchSalesTax() {
        const stateEl = document.getElementById('ship_state');
        const countyEl = document.getElementById('ship_county');
        if (!stateEl || !salesTaxUrl) {
            return;
        }
        const params = new URLSearchParams({
            ship_state: stateEl.value,
            ship_county: countyEl ? countyEl.value : '',
        });
        fetch(salesTaxUrl + '?' + params.toString(), {
            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        })
            .then((r) => r.json())
            .then((data) => {
                if (typeof data.sales_tax_percent === 'number') {
                    recalc(data.sales_tax_percent);
                }
            })
            .catch(() => {});
    }

    function showError(name, msg) {
        const box = form.querySelector('.err_' + name);
        if (box) {
            box.textContent = msg || '';
        }
    }

    function clearErrors() {
        form.querySelectorAll('.field-error').forEach((el) => {
            el.textContent = '';
        });
    }

    function validateBeforeSubmit(e, type) {
        clearErrors();
        let ok = true;

        const req = (name, label) => {
            const el = form.querySelector('[name="' + name + '"]');
            if (!el || !String(el.value || '').trim()) {
                showError(name.replace(/\./g, '_'), label + ' is required.');
                ok = false;
            }
        };

        [
            ['bill_to_name', 'Name'],
            ['bill_to_address', 'Address'],
            ['bill_to_city', 'City'],
            ['bill_to_state', 'State'],
            ['bill_to_county', 'County'],
            ['bill_to_country', 'Country'],
            ['bill_to_zip', 'Zip'],
            ['bill_to_email', 'Email'],
            ['bill_to_phone', 'Phone'],
            ['ship_to_name', 'Ship name'],
            ['ship_to_address', 'Ship address'],
            ['ship_city', 'Ship city'],
            ['ship_state', 'Ship state'],
            ['ship_county', 'Ship county'],
            ['ship_country', 'Ship country'],
            ['ship_zip', 'Ship zip'],
            ['ship_to_email', 'Ship email'],
            ['ship_to_phone', 'Ship phone'],
        ].forEach(([n, l]) => req(n, l));

        const pay = type || paymentType();
        if (pay === 'by_credit_card' || pay === 'by_debit_card') {
            const fields =
                pay === 'by_debit_card'
                    ? {
                          fname: 'debit_checkout_fname',
                          lname: 'debit_checkout_lname',
                          addr: 'debit_checkout_address',
                          city: 'debit_checkout_city',
                          state: 'debit_checkout_state',
                          zip: 'debit_checkout_zipcode',
                          card: 'debit_card_number',
                          exp: 'debit_expiry_date',
                          cvv: 'debit_cvv_number',
                      }
                    : {
                          fname: 'checkout_fname',
                          lname: 'checkout_lname',
                          addr: 'checkout_address',
                          city: 'checkout_city',
                          state: 'checkout_state',
                          zip: 'checkout_zipcode',
                          card: 'card_number',
                          exp: 'expiry_date',
                          cvv: 'cvv_number',
                      };
            req(fields.fname, 'First name');
            req(fields.lname, 'Last name');
            req(fields.addr, 'Address');
            req(fields.city, 'City');
            req(fields.state, 'State');
            req(fields.zip, 'Zip');
            req(fields.card, 'Card number');
            const exp = form.querySelector('[name="' + fields.exp + '"]');
            if (!exp || !/^\d{2}\/\d{2}$/.test(String(exp.value || '').trim())) {
                showError(fields.exp, 'Use MM/YY format.');
                ok = false;
            }
            req(fields.cvv, 'CVV');
            const mem = form.querySelector('[name="membership_agree"]');
            if (!mem || !mem.checked) {
                showError('membership_agree', 'You must agree to the membership terms.');
                ok = false;
            }
        } else if (pay === 'pay_ach') {
            req('ach_checkout_fname', 'First name');
            req('ach_checkout_lname', 'Last name');
            req('ach_checkout_address', 'Address');
            req('ach_checkout_city', 'City');
            req('ach_checkout_state', 'State');
            req('ach_checkout_zipcode', 'Zip');
            req('account_number', 'Account number');
            req('route_number', 'Route number');
        }

        if (!ok) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            const loader = document.getElementById('ow-checkout-loading');
            if (loader) {
                loader.classList.add('is-visible');
            }
        }
    }

    form.querySelectorAll('input[name="credit_or_not_credit_card"]').forEach((r) => {
        r.addEventListener('change', syncPaymentPanels);
    });

    const shipState = document.getElementById('ship_state');
    if (shipState) {
        shipState.addEventListener('change', function () {
            const county = document.getElementById('ship_county');
            renderCountyField(this.value, county ? county.value : '');
            fetchSalesTax();
        });
    }

    document.querySelectorAll('.tc-checkout__pay-head').forEach((head) => {
        head.addEventListener('click', function (e) {
            if (e.target.tagName === 'INPUT' || e.target.closest('label.tc-checkout__pay-choice')) {
                const radio = this.querySelector('input[name="credit_or_not_credit_card"]');
                if (radio && !radio.checked) {
                    radio.checked = true;
                    syncPaymentPanels();
                }
                return;
            }
            const radio = this.querySelector('input[name="credit_or_not_credit_card"]');
            if (radio) {
                radio.checked = true;
                syncPaymentPanels();
            }
        });
    });

    form.querySelectorAll('.final_frm_sub_btn').forEach((btn) => {
        btn.addEventListener('click', function () {
            const type = this.getAttribute('data-pay-type');
            const radio = form.querySelector('input[name="credit_or_not_credit_card"][value="' + type + '"]');
            if (radio) {
                radio.checked = true;
                syncPaymentPanels();
            }
        });
    });

    form.addEventListener('submit', function (e) {
        validateBeforeSubmit(e, paymentType());
    });

    const initState = shipState ? shipState.value : '';
    const initCounty = document.getElementById('ship_county')?.value || cfg.shipCounty || '';
    renderCountyField(initState, initCounty);

    syncPaymentPanels();
})();
