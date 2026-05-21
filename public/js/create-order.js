/**
 * Standalone create-order workspace (multi-room cart, CI-aligned).
 */
(function () {
    const shell = document.querySelector('.co-shell--build');
    if (!shell) return;

    const searchUrl = shell.dataset.searchUrl;
    const storeUrl = shell.dataset.storeUrl;
    const csrf = shell.dataset.csrf;

    let lastRoomRow = null;
    let roomCounter = 0;

    const cartBody = document.getElementById('co-cart-body');
    const jobInput = document.getElementById('co-job-name');
    const sectionsEl = document.getElementById('co-product-sections');
    const searchResultsEl = document.getElementById('co-search-results');

    function money(n) {
        return '$' + (Number(n) || 0).toFixed(2);
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
    }

    function getActiveRoomName() {
        if (!lastRoomRow) return '';
        const input = lastRoomRow.querySelector('.co-room-name');
        return input ? input.value.trim() : '';
    }

    function addRoomRow() {
        const job = jobInput.value.trim();
        if (!job) {
            Swal.fire({ icon: 'warning', title: 'Job name required', text: 'Enter a job name before adding a room.' });
            return;
        }

        roomCounter += 1;
        const roomId = 'room_' + roomCounter;
        const tr = document.createElement('tr');
        tr.className = 'co-room-row';
        tr.dataset.roomId = roomId;
        tr.innerHTML =
            '<td colspan="8">' +
            '<label>Room <em>*</em></label> ' +
            '<input type="text" class="co-room-name" placeholder="e.g. Kitchen" value="Room ' + roomCounter + '">' +
            ' <button type="button" class="co-btn co-btn--ghost co-remove-room" style="margin-left:0.5rem">Remove room</button>' +
            '</td>';
        cartBody.appendChild(tr);
        lastRoomRow = tr;
        tr.querySelector('.co-room-name').addEventListener('focus', () => {
            lastRoomRow = tr;
        });
    }

    function findProductRow(productId) {
        return cartBody.querySelector('[data-line-type="product"][data-product-id="' + productId + '"]');
    }

    function addProductToCart(product) {
        const roomName = getActiveRoomName();
        if (!lastRoomRow || !roomName) {
            Swal.fire({ icon: 'warning', title: 'Add a room first', text: 'Enter job name, click + Add room, then double-click products.' });
            return;
        }

        const existing = findProductRow(product.id);
        if (existing) {
            const qty = parseInt(existing.dataset.qty, 10) + 1;
            existing.dataset.qty = String(qty);
            existing.querySelector('.co-line-qty').textContent = String(qty);
            const unit = parseFloat(existing.dataset.unitCost);
            const weight = parseFloat(existing.dataset.unitWeight);
            existing.dataset.lineTotal = String(unit * qty);
            existing.dataset.lineWeight = String(weight * qty);
            existing.querySelector('.co-line-total').textContent = money(unit * qty);
            existing.querySelector('.co-line-weight').textContent = (weight * qty).toFixed(2) + ' lbs';
            updateTotals();
            return;
        }

        const qty = 1;
        const unit = parseFloat(product.cost) || 0;
        const weight = parseFloat(product.weight) || 0;
        const tr = document.createElement('tr');
        tr.dataset.lineType = 'product';
        tr.dataset.productId = product.id;
        tr.dataset.qty = '1';
        tr.dataset.unitCost = String(unit);
        tr.dataset.unitWeight = String(weight);
        tr.dataset.lineTotal = String(unit);
        tr.dataset.lineWeight = String(weight);
        tr.dataset.roomId = lastRoomRow.dataset.roomId;

        tr.innerHTML =
            '<td><input type="checkbox" class="co-check-single"><br><input type="checkbox" class="co-check-double"></td>' +
            '<td>' + escapeHtml(product.label) + '</td>' +
            '<td>' + escapeHtml(product.description) + '</td>' +
            '<td class="co-line-weight">' + weight.toFixed(2) + ' lbs</td>' +
            '<td>' + money(unit) + '</td>' +
            '<td class="co-line-total">' + money(unit) + '</td>' +
            '<td class="co-line-qty">1</td>' +
            '<td><button type="button" class="co-btn co-btn--ghost co-remove-line">×</button></td>';

        let insertAfter = lastRoomRow;
        let next = insertAfter.nextElementSibling;
        while (next && next.dataset.lineType === 'product' && next.dataset.roomId === lastRoomRow.dataset.roomId) {
            insertAfter = next;
            next = next.nextElementSibling;
        }
        insertAfter.insertAdjacentElement('afterend', tr);
        updateTotals();
    }

    function escapeHtml(s) {
        const d = document.createElement('div');
        d.textContent = s;
        return d.innerHTML;
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
        const roomRows = cartBody.querySelectorAll('.co-room-row');
        roomRows.forEach((roomRow) => {
            const roomId = roomRow.dataset.roomId;
            const roomName = roomRow.querySelector('.co-room-name')?.value.trim() || '';
            const products = [];
            let el = roomRow.nextElementSibling;
            while (el && el.dataset.lineType === 'product' && el.dataset.roomId === roomId) {
                let checkboxStatus = 'none';
                if (el.querySelector('.co-check-double')?.checked) checkboxStatus = 'double';
                else if (el.querySelector('.co-check-single')?.checked) checkboxStatus = 'single';
                products.push({
                    product_id: parseInt(el.dataset.productId, 10),
                    quantity: parseInt(el.dataset.qty, 10) || 1,
                    checkbox_status: checkboxStatus,
                });
                el = el.nextElementSibling;
            }
            if (roomName && products.length) {
                rooms.push({ room_name: roomName, products });
            }
        });
        return rooms;
    }

    function validateCart() {
        const errors = [];
        if (!jobInput.value.trim()) errors.push('Enter a job name.');
        if (!cartBody.querySelector('.co-room-row')) errors.push('Add at least one room.');
        if (!cartBody.querySelector('[data-line-type="product"]')) errors.push('Add at least one product.');
        const assemble = document.querySelector('input[name="assemble"]:checked');
        if (!assemble) errors.push('Select assemble all cabinetry (Yes or No).');
        return errors;
    }

    function submitOrder(shippingStatus) {
        const errors = validateCart();
        if (errors.length) {
            Swal.fire({ icon: 'error', title: 'Incomplete order', html: errors.join('<br>') });
            return;
        }

        const assemble = document.querySelector('input[name="assemble"]:checked').value;

        fetch(storeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                Accept: 'application/json',
            },
            body: JSON.stringify({
                job_name: jobInput.value.trim(),
                rooms: collectRoomsPayload(),
                assemble_cabinets_check: assemble === 'yes' ? 'yes' : 'no',
                shipping_status: shippingStatus || 'pending',
                comment: document.getElementById('co-comment').value,
            }),
        })
            .then((r) => r.json().then((data) => ({ ok: r.ok, data })))
            .then(({ ok, data }) => {
                if (!ok) {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Could not save order.' });
                    return;
                }
                Swal.fire({ icon: 'success', title: 'Saved', text: data.message }).then(() => {
                    window.location.href = data.redirect || '/tenants/orders/index';
                });
            })
            .catch(() => Swal.fire({ icon: 'error', title: 'Error', text: 'Network error.' }));
    }

    document.getElementById('co-add-room')?.addEventListener('click', addRoomRow);

    document.getElementById('co-clear-cart')?.addEventListener('click', () => {
        Swal.fire({
            icon: 'warning',
            title: 'Clear cart?',
            showCancelButton: true,
            confirmButtonText: 'Clear',
        }).then((r) => {
            if (r.isConfirmed) {
                cartBody.innerHTML = '';
                lastRoomRow = null;
                updateTotals();
            }
        });
    });

    cartBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('co-remove-room')) {
            const row = e.target.closest('.co-room-row');
            const roomId = row.dataset.roomId;
            const toRemove = [row];
            let next = row.nextElementSibling;
            while (next && next.dataset.lineType === 'product' && next.dataset.roomId === roomId) {
                toRemove.push(next);
                next = next.nextElementSibling;
            }
            toRemove.forEach((el) => el.remove());
            lastRoomRow = cartBody.querySelector('.co-room-row:last-of-type');
            updateTotals();
        }
        if (e.target.classList.contains('co-remove-line')) {
            e.target.closest('tr').remove();
            updateTotals();
        }
    });

    cartBody.addEventListener('change', (e) => {
        if (e.target.classList.contains('co-check-single') && e.target.checked) {
            e.target.closest('tr').querySelector('.co-check-double').checked = false;
        }
        if (e.target.classList.contains('co-check-double') && e.target.checked) {
            e.target.closest('tr').querySelector('.co-check-single').checked = false;
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
    document.getElementById('co-sku-search')?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') runSearch();
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
                    '<div class="co-table-wrap"><table class="co-table co-table--picker"><thead><tr><th>Label</th><th>SKU</th><th>Cost</th></tr></thead><tbody>';
                data.products.forEach((p) => {
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
                        money(p.cost) +
                        '</td></tr>';
                });
                html += '</tbody></table></div>';
                searchResultsEl.innerHTML = html;
            });
    }

    function escapeAttr(s) {
        return String(s).replace(/"/g, '&quot;');
    }

    searchResultsEl?.addEventListener('dblclick', (e) => {
        const row = e.target.closest('.co-product-row');
        if (!row) return;
        addProductToCart(productFromRow(row));
    });

    document.getElementById('co-process-btn')?.addEventListener('click', () => submitOrder('pending'));
    document.getElementById('co-quote-btn')?.addEventListener('click', () => submitOrder('pending'));
    document.getElementById('co-shipping-btn')?.addEventListener('click', () => {
        Swal.fire({
            title: 'Shipping for this order?',
            showDenyButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
        }).then((r) => submitOrder(r.isConfirmed ? 'yes' : 'pending'));
    });
    document.getElementById('co-print-btn')?.addEventListener('click', () => window.print());

    addRoomRow();
})();
