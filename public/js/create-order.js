/**
 * Standalone create-order workspace — CI Team Cabinets exact cart behavior.
 */
(function () {
    const shell = document.querySelector('.co-shell--build');
    if (!shell) return;

    const searchUrl = shell.dataset.searchUrl;
    const csrf = shell.dataset.csrf;
    const cartApi = {
        get: shell.dataset.cartGetUrl,
        saveJob: shell.dataset.cartSaveJobUrl,
        addRoom: shell.dataset.cartAddRoomUrl,
        removeRoom: shell.dataset.cartRemoveRoomUrl,
        addProduct: shell.dataset.cartAddProductUrl,
        removeProduct: shell.dataset.cartRemoveProductUrl,
        clear: shell.dataset.cartClearUrl,
        saveTotals: shell.dataset.cartSaveTotalsUrl,
    };
    const urls = {
        order: shell.dataset.storeOrderUrl,
        quote: shell.dataset.storeQuoteUrl,
        shipping: shell.dataset.storeShippingUrl,
        stockCheck: shell.dataset.storeStockCheckUrl,
    };

    let lastRoomRow = null;
    let roomCounter = 0;
    let restoringCart = false;

    const cartBody = document.getElementById('co-cart-body');
    const jobInput = document.getElementById('co-job-name');
    const sectionsEl = document.getElementById('co-product-sections');
    const searchResultsEl = document.getElementById('co-search-results');

    function money(n) {
        return '$' + (Number(n) || 0).toFixed(2);
    }

    function postJson(url, body) {
        if (!url) return Promise.resolve();
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                Accept: 'application/json',
            },
            body: JSON.stringify({ ...body, _token: csrf }),
        });
    }

    function updateTotals() {
        let totalPrice = 0;
        let totalWeight = 0;
        cartBody.querySelectorAll('[data-line-type="product"]').forEach((row) => {
            totalPrice += parseFloat(row.dataset.lineTotal || '0');
            totalWeight += parseFloat(row.dataset.lineWeight || '0');
        });
        document.getElementById('co-total-price').textContent = money(totalPrice);
        document.getElementById('co-total-weight').textContent = totalWeight.toFixed(2) + ' lbs';
        if (!restoringCart) {
            postJson(cartApi.saveTotals, {
                total_price: money(totalPrice),
                total_weight: totalWeight.toFixed(2) + ' lbs',
            });
        }
    }

    function getActiveRoomName() {
        if (!lastRoomRow) return '';
        const input = lastRoomRow.querySelector('.co-room-name');
        return input ? input.value.trim() : '';
    }

    function setActiveRoom(tr) {
        cartBody.querySelectorAll('.co-room-row').forEach((r) => r.classList.remove('is-active'));
        lastRoomRow = tr;
        if (tr) tr.classList.add('is-active');
    }

    function validateRoomInput(input) {
        const err = input?.closest('td')?.querySelector('.co-room-error');
        if (!err) return;
        const empty = !input.value.trim();
        err.classList.toggle('d-none', !empty);
    }

    function checkGroupHtml() {
        return (
            '<div class="co-check-group">' +
            '<button type="button" class="co-check-tile co-check-tile--single" aria-pressed="false" title="Single check"></button>' +
            '<button type="button" class="co-check-tile co-check-tile--double" aria-pressed="false" title="Double check"></button>' +
            '</div>'
        );
    }

    function getCheckboxStatus(row) {
        if (row.querySelector('.co-check-tile--double')?.getAttribute('aria-pressed') === 'true') return 'double';
        if (row.querySelector('.co-check-tile--single')?.getAttribute('aria-pressed') === 'true') return 'single';
        return 'none';
    }

    function setCheckboxStatus(row, status) {
        const single = row.querySelector('.co-check-tile--single');
        const double = row.querySelector('.co-check-tile--double');
        if (!single || !double) return;
        single.setAttribute('aria-pressed', status === 'single' ? 'true' : 'false');
        double.setAttribute('aria-pressed', status === 'double' ? 'true' : 'false');
    }

    function syncProductSession(row) {
        if (restoringCart) return;
        const roomRow = cartBody.querySelector('[data-room-id="' + row.dataset.roomId + '"]');
        if (!roomRow) return;
        postJson(cartApi.addProduct, {
            room_id: row.dataset.roomId,
            room_name: roomRow.querySelector('.co-room-name')?.value.trim() || '',
            product_id: parseInt(row.dataset.productId, 10),
            description: row.dataset.description,
            weight: row.dataset.unitWeight,
            price: parseFloat(row.dataset.unitCost),
            quantity: parseInt(row.dataset.qty, 10) || 1,
            checkbox_status: getCheckboxStatus(row),
        });
    }

    function addRoomRow(roomName, roomId) {
        roomCounter += 1;
        const id = roomId || 'room_' + roomCounter;
        const tr = document.createElement('tr');
        tr.className = 'co-room-row';
        tr.dataset.roomId = id;
        tr.innerHTML =
            '<td class="co-room-label-cell"><label>Room <em>*</em></label></td>' +
            '<td colspan="6" class="co-room-input-cell">' +
            '<input type="text" class="co-room-name form-control" placeholder="Enter Room Name." value="' +
            escapeAttr(roomName || '') +
            '">' +
            '<span class="co-room-error d-none">Required Field</span>' +
            '</td>' +
            '<td class="co-room-del-cell"><a href="#" class="co-del-x co-remove-room" title="Remove room">x</a></td>';
        cartBody.appendChild(tr);
        setActiveRoom(tr);
        const roomInput = tr.querySelector('.co-room-name');
        tr.addEventListener('click', (e) => {
            if (e.target.closest('.co-remove-room')) return;
            setActiveRoom(tr);
        });
        roomInput.addEventListener('focus', () => setActiveRoom(tr));
        roomInput.addEventListener('blur', () => validateRoomInput(roomInput));
        roomInput.addEventListener('input', () => validateRoomInput(roomInput));
        return tr;
    }

    function findProductRow(roomId, productId) {
        return cartBody.querySelector(
            '[data-line-type="product"][data-room-id="' + roomId + '"][data-product-id="' + productId + '"]'
        );
    }

    function setLineQty(row, qty) {
        const nextQty = Math.max(1, parseInt(qty, 10) || 1);
        row.dataset.qty = String(nextQty);
        row.querySelector('.co-line-qty').textContent = String(nextQty);
        const unit = parseFloat(row.dataset.unitCost);
        const weight = parseFloat(row.dataset.unitWeight);
        row.dataset.lineTotal = String(unit * nextQty);
        row.dataset.lineWeight = String(weight * nextQty);
        row.querySelector('.co-line-total').textContent = money(unit * nextQty);
        row.querySelector('.co-line-weight').textContent = (weight * nextQty).toFixed(2) + ' lbs';
        updateTotals();
        syncProductSession(row);
    }

    function buildProductRow(product, roomId) {
        const unit = parseFloat(product.cost) || 0;
        const weight = parseFloat(product.weight) || 0;
        const tr = document.createElement('tr');
        tr.dataset.lineType = 'product';
        tr.dataset.productId = product.id;
        tr.dataset.roomId = roomId;
        tr.dataset.qty = '1';
        tr.dataset.unitCost = String(unit);
        tr.dataset.unitWeight = String(weight);
        tr.dataset.lineTotal = String(unit);
        tr.dataset.lineWeight = String(weight);
        tr.dataset.description = product.description || '';

        tr.innerHTML =
            '<td>' + checkGroupHtml() + '</td>' +
            '<td>' + escapeHtml(product.label) + '</td>' +
            '<td>' + escapeHtml(product.description) + '</td>' +
            '<td class="co-line-weight">' + weight.toFixed(2) + ' lbs</td>' +
            '<td>' + money(unit) + '</td>' +
            '<td class="co-line-total">' + money(unit) + '</td>' +
            '<td class="co-line-qty">1</td>' +
            '<td><a href="#" class="co-del-x co-remove-line" title="Remove">x</a></td>';
        return tr;
    }

    function insertProductAfterRoom(roomRow, productRow) {
        const roomId = roomRow.dataset.roomId;
        let insertAfter = roomRow;
        let next = insertAfter.nextElementSibling;
        while (next && next.dataset.lineType === 'product' && next.dataset.roomId === roomId) {
            insertAfter = next;
            next = next.nextElementSibling;
        }
        insertAfter.insertAdjacentElement('afterend', productRow);
    }

    function addProductToCart(product) {
        const roomName = getActiveRoomName();
        if (!lastRoomRow) {
            window.alert('Please add a room before selecting a product.');
            return;
        }
        if (!roomName) {
            validateRoomInput(lastRoomRow.querySelector('.co-room-name'));
            window.alert('Please enter a room name before selecting products.');
            return;
        }

        const roomId = lastRoomRow.dataset.roomId;
        const existing = findProductRow(roomId, product.id);
        if (existing) {
            setLineQty(existing, parseInt(existing.dataset.qty, 10) + 1);
            return;
        }

        const tr = buildProductRow(product, roomId);
        insertProductAfterRoom(lastRoomRow, tr);
        updateTotals();
        syncProductSession(tr);
    }

    function escapeHtml(s) {
        const d = document.createElement('div');
        d.textContent = s;
        return d.innerHTML;
    }

    function escapeAttr(s) {
        return String(s).replace(/"/g, '&quot;');
    }

    function productFromRow(row) {
        return {
            id: row.dataset.productId,
            label: row.dataset.label,
            sku: row.dataset.sku,
            description: row.dataset.description,
            weight: row.dataset.weight,
            cost: row.dataset.cost,
        };
    }

    function collectRoomsPayload() {
        const rooms = [];
        cartBody.querySelectorAll('.co-room-row').forEach((roomRow) => {
            const roomId = roomRow.dataset.roomId;
            const roomName = roomRow.querySelector('.co-room-name')?.value.trim() || '';
            const products = [];
            let el = roomRow.nextElementSibling;
            while (el && el.dataset.lineType === 'product' && el.dataset.roomId === roomId) {
                products.push({
                    product_id: parseInt(el.dataset.productId, 10),
                    quantity: parseInt(el.dataset.qty, 10) || 1,
                    checkbox_status: getCheckboxStatus(el),
                });
                el = el.nextElementSibling;
            }
            if (roomName && products.length) {
                rooms.push({ room_name: roomName, products });
            }
        });
        return rooms;
    }

    /** CI Team Cabinets: native alert(), one message at a time (same as legacy checkvalidation). */
    function ciValidate() {
        const assembleErr = document.getElementById('co-assemble-error');

        if (!jobInput.value.trim()) {
            window.alert('Please enter a Job Name.');
            return false;
        }
        if (!cartBody.querySelector('.co-room-row')) {
            window.alert('Please add at least one room.');
            return false;
        }
        let emptyRoom = false;
        cartBody.querySelectorAll('.co-room-name').forEach((inp) => {
            if (!inp.value.trim()) {
                emptyRoom = true;
                validateRoomInput(inp);
            }
        });
        if (emptyRoom) {
            window.alert('Please enter a room name.');
            return false;
        }
        if (!cartBody.querySelector('[data-line-type="product"]')) {
            window.alert('Please add at least one product.');
            return false;
        }
        if (!document.querySelector('input[name="assemble"]:checked')) {
            if (assembleErr) assembleErr.textContent = 'Please select Yes or No for Assemble All Cabinetry.';
            window.alert('Please select Yes or No for Assemble All Cabinetry.');
            return false;
        }
        if (assembleErr) assembleErr.textContent = '';
        return true;
    }

    function submitWorkspace(action, shippingStatus, skipValidate) {
        if (!skipValidate && !ciValidate()) return;

        const assemble = document.querySelector('input[name="assemble"]:checked').value;
        const storeUrl = urls[action];
        if (!storeUrl) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Save action is not configured.' });
            return;
        }

        const body = {
            job_name: jobInput.value.trim(),
            rooms: collectRoomsPayload(),
            assemble_cabinets_check: assemble === 'yes' ? '1' : '2',
            comment: document.getElementById('co-comment').value,
        };

        if (action === 'shipping') {
            body.shipping_status = 'yes';
        } else if (shippingStatus) {
            body.shipping_status = shippingStatus;
        } else if (action === 'order' || action === 'stockCheck') {
            body.shipping_status = 'pending';
        }

        fetch(storeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                Accept: 'application/json',
            },
            body: JSON.stringify(body),
        })
            .then((r) => r.json().then((data) => ({ ok: r.ok, data })))
            .then(({ ok, data }) => {
                if (!ok) {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Could not save.' });
                    return;
                }
                postJson(cartApi.clear, {}).finally(() => {
                    Swal.fire({ icon: 'success', title: 'Saved', text: data.message }).then(() => {
                        if (data.redirect) window.location.href = data.redirect;
                    });
                });
            })
            .catch(() => Swal.fire({ icon: 'error', title: 'Error', text: 'Network error.' }));
    }

    function loadSessionCart() {
        if (!cartApi.get) return;
        fetch(cartApi.get, { headers: { Accept: 'application/json' } })
            .then((r) => r.json())
            .then((data) => {
                restoringCart = true;
                cartBody.innerHTML = '';
                lastRoomRow = null;
                if (data.job_name) jobInput.value = data.job_name;

                const cart = data.cart || {};
                const roomIds = {};
                const byRoom = {};
                Object.values(cart).forEach((item) => {
                    const rid = item.room_id || 'room_' + (item.room_name || '1');
                    if (!byRoom[rid]) {
                        byRoom[rid] = { name: item.room_name || '', items: [] };
                    }
                    byRoom[rid].items.push(item);
                });
                Object.entries(byRoom).forEach(([rid, group]) => {
                    roomIds[rid] = addRoomRow(group.name, rid);
                });

                Object.values(cart).forEach((item) => {
                    const rid = item.room_id || 'room_' + (item.room_name || '1');
                    const roomRow = roomIds[rid] || cartBody.querySelector('.co-room-row');
                    if (!roomRow) return;
                    const product = {
                        id: String(item.product_id),
                        label: item.label || '',
                        description: item.description || '',
                        cost: item.price,
                        weight: parseFloat(String(item.weight).replace(/[^\d.]/, '')) || 0,
                    };
                    const tr = buildProductRow(product, roomRow.dataset.roomId);
                    setCheckboxStatus(tr, item.checkbox_status || 'none');
                    insertProductAfterRoom(roomRow, tr);
                    setLineQty(tr, item.quantity || 1);
                });

                lastRoomRow = cartBody.querySelector('.co-room-row:last-of-type');
                updateTotals();
                restoringCart = false;
            })
            .catch(() => {
                restoringCart = false;
            });
    }

    document.getElementById('co-add-room')?.addEventListener('click', () => {
        const job = jobInput.value.trim();
        if (!job) {
            window.alert('Please enter a Job Name before adding a room.');
            return;
        }
        postJson(cartApi.saveJob, { job_name: job });
        const tr = addRoomRow('', null);
        postJson(cartApi.addRoom, { job_name: job, room_name: '' });
        tr.querySelector('.co-room-name')?.focus();
    });

    document.getElementById('co-clear-cart')?.addEventListener('click', () => {
        if (!window.confirm('Are you sure you want to clear all the items in cart?')) return;
        postJson(cartApi.clear, {}).then(() => {
            cartBody.innerHTML = '';
            lastRoomRow = null;
            jobInput.value = '';
            updateTotals();
        });
    });

    cartBody.addEventListener('click', (e) => {
        if (e.target.closest('.co-del-x')) e.preventDefault();
        const tile = e.target.closest('.co-check-tile');
        if (tile) {
            const row = tile.closest('[data-line-type="product"]');
            const single = row.querySelector('.co-check-tile--single');
            const double = row.querySelector('.co-check-tile--double');
            if (tile.classList.contains('co-check-tile--single')) {
                const on = single.getAttribute('aria-pressed') !== 'true';
                single.setAttribute('aria-pressed', on ? 'true' : 'false');
                if (on) double.setAttribute('aria-pressed', 'false');
            } else {
                const on = double.getAttribute('aria-pressed') !== 'true';
                double.setAttribute('aria-pressed', on ? 'true' : 'false');
                if (on) single.setAttribute('aria-pressed', 'false');
            }
            syncProductSession(row);
            return;
        }

        if (e.target.closest('.co-remove-room')) {
            const row = e.target.closest('.co-room-row');
            const roomId = row.dataset.roomId;
            const roomName = row.querySelector('.co-room-name')?.value.trim() || '';
            const toRemove = [row];
            let next = row.nextElementSibling;
            while (next && next.dataset.lineType === 'product' && next.dataset.roomId === roomId) {
                toRemove.push(next);
                next = next.nextElementSibling;
            }
            toRemove.forEach((el) => {
                if (el.dataset.lineType === 'product') {
                    postJson(cartApi.removeProduct, {
                        room_id: roomId,
                        product_id: parseInt(el.dataset.productId, 10),
                    });
                }
                el.remove();
            });
            postJson(cartApi.removeRoom, { room_name: roomName });
            lastRoomRow = cartBody.querySelector('.co-room-row:last-of-type');
            if (lastRoomRow) setActiveRoom(lastRoomRow);
            updateTotals();
            return;
        }

        if (e.target.closest('.co-remove-line')) {
            const row = e.target.closest('[data-line-type="product"]');
            postJson(cartApi.removeProduct, {
                room_id: row.dataset.roomId,
                product_id: parseInt(row.dataset.productId, 10),
            });
            row.remove();
            updateTotals();
        }
    });

    sectionsEl?.addEventListener('dblclick', (e) => {
        const row = e.target.closest('.co-product-row');
        if (!row) return;
        row.classList.add('is-flash');
        setTimeout(() => row.classList.remove('is-flash'), 400);
        addProductToCart(productFromRow(row));
    });

    document.getElementById('co-sku-search-btn')?.addEventListener('click', runSearch);
    document.getElementById('co-sku-search')?.addEventListener('keydown', (ev) => {
        if (ev.key === 'Enter') runSearch();
    });

    function runSearch() {
        const term = document.getElementById('co-sku-search').value.trim();
        if (!term) {
            searchResultsEl.classList.add('d-none');
            sectionsEl.classList.remove('d-none');
            return;
        }
        fetch(searchUrl + '?search=' + encodeURIComponent(term), { headers: { Accept: 'application/json' } })
            .then((r) => r.json())
            .then((data) => {
                sectionsEl.classList.add('d-none');
                searchResultsEl.classList.remove('d-none');
                if (!data.products?.length) {
                    searchResultsEl.innerHTML = '<p class="co-hint">No products found.</p>';
                    return;
                }
                let html =
                    '<div class="co-table-wrap"><table class="co-table co-table--picker table table-bordered table-sm"><thead><tr>' +
                    '<th>Cabinet Label</th><th>SKU</th><th>Description</th><th>Weight</th><th>Cost</th><th>Qty</th>' +
                    '</tr></thead><tbody>';
                data.products.forEach((p) => {
                    const listDesc = p.list_description || p.sku;
                    html +=
                        '<tr class="co-product-row" data-product-id="' +
                        p.id +
                        '" data-label="' +
                        escapeAttr(p.label) +
                        '" data-sku="' +
                        escapeAttr(p.sku) +
                        '" data-description="' +
                        escapeAttr(p.description) +
                        '" data-weight="' +
                        p.weight +
                        '" data-cost="' +
                        p.cost +
                        '">' +
                        '<td class="co-product-label">' +
                        escapeHtml(p.label) +
                        '</td><td>' +
                        escapeHtml(p.sku) +
                        '</td><td>' +
                        escapeHtml(listDesc) +
                        '</td><td>' +
                        escapeHtml(String(p.weight)) +
                        '</td><td>' +
                        escapeHtml(String(p.cost)) +
                        '</td><td>' +
                        escapeHtml(String(p.qty ?? '')) +
                        '</td></tr>';
                });
                html += '</tbody></table></div>';
                searchResultsEl.innerHTML = html;
            });
    }

    searchResultsEl?.addEventListener('dblclick', (e) => {
        const row = e.target.closest('.co-product-row');
        if (!row) return;
        addProductToCart(productFromRow(row));
    });

    document.getElementById('co-process-btn')?.addEventListener('click', () => submitWorkspace('order'));
    document.getElementById('co-quote-btn')?.addEventListener('click', () => submitWorkspace('quote'));
    document.getElementById('co-shipping-btn')?.addEventListener('click', () => {
        if (!ciValidate()) return;
        submitWorkspace('shipping', 'yes', true);
    });

    document.getElementById('co-stock-check-btn')?.addEventListener('click', () => {
        if (!ciValidate()) return;
        const wantShipping = window.confirm('Do you want shipping for stock check?');
        submitWorkspace('stockCheck', wantShipping ? 'yes' : 'pending', true);
    });

    document.querySelectorAll('input[name="assemble"]').forEach((radio) => {
        radio.addEventListener('change', () => {
            const assembleErr = document.getElementById('co-assemble-error');
            if (assembleErr) assembleErr.textContent = '';
        });
    });
    document.getElementById('co-print-btn')?.addEventListener('click', () => window.print());

    if (cartBody) {
        cartBody.setAttribute('ondrop', 'return false');
        cartBody.setAttribute('ondragover', 'return false');
    }

    loadSessionCart();
})();
