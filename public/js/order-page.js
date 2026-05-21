/**
 * CI-identical order workspace (Team Cabinets) — Laravel tenant theme.
 */
(function ($) {
    'use strict';

    const $page = $('#ow-page');
    if (!$page.length) return;

    const cfg = {
        catalogId: $page.data('catalog-id'),
        doorId: $page.data('door-id'),
        csrf: $page.data('csrf'),
        accordionSearchUrl: $page.data('accordion-search-url'),
        autosaveUrl: $page.data('autosave-url'),
        urls: {
            print: $page.data('store-print-url'),
            quote: $page.data('store-quote-url'),
            shipping: $page.data('store-shipping-url'),
            stock: $page.data('store-stock-url'),
            process: $page.data('store-process-url'),
        },
    };

    let roomCounter = 1;
    let autosaveTimer = null;
    let restoring = false;

    function money(n) {
        return '$' + (Number(n) || 0).toFixed(2);
    }

    function setActiveRoom(n) {
        $('tbody.cart-room').removeClass('active');
        $(`tbody.cart-room[data-room-index="${n}"]`).addClass('active');
    }

    function recalcTotals() {
        let totalCost = 0;
        let totalWeight = 0;
        $('tbody.cart-room .product-row').each(function () {
            const $row = $(this);
            const qty = parseInt($row.find('.product-qty-input').val(), 10) || 0;
            const cost = parseFloat($row.find('.product-qty-input').data('unit-cost')) || 0;
            const weight = parseFloat($row.find('.product-qty-input').data('unit-weight')) || 0;
            totalCost += cost * qty;
            totalWeight += weight * qty;
        });
        $('.total-price').text(money(totalCost));
        $('.total-weight').text(totalWeight.toFixed(2) + ' lbs');
        $('.all_cart_total').val(totalCost.toFixed(2));
        $('.cart_product_weight').val(totalWeight.toFixed(2) + ' lbs');
        scheduleAutosave();
    }

    function collectRoomsPayload() {
        const rooms = [];
        $('tbody.cart-room').each(function () {
            const $tb = $(this);
            const roomName = $tb.find('.room-name-input').val().trim();
            const products = [];
            $tb.find('.product-row').each(function () {
                const $r = $(this);
                let status = 'none';
                if ($r.find('.chk-double').is(':checked')) status = 'double';
                else if ($r.find('.chk-single').is(':checked')) status = 'single';
                products.push({
                    product_id: parseInt($r.data('product-id'), 10),
                    quantity: parseInt($r.find('.product-qty-input').val(), 10) || 1,
                    checkbox_status: status,
                });
            });
            if (roomName && products.length) {
                rooms.push({ room_name: roomName, products });
            }
        });
        return rooms;
    }

    function collectAutosaveState() {
        const rooms = [];
        $('tbody.cart-room').each(function () {
            const idx = $(this).data('room-index');
            const lines = [];
            $(this)
                .find('.product-row')
                .each(function () {
                    const $r = $(this);
                    lines.push({
                        product_id: $r.data('product-id'),
                        sku: $r.data('sku'),
                        label: $r.data('label'),
                        description: $r.data('description'),
                        weight: $r.data('unit-weight'),
                        cost: $r.data('unit-cost'),
                        quantity: parseInt($r.find('.product-qty-input').val(), 10) || 1,
                        checkbox_status: $r.find('.chk-double').is(':checked')
                            ? 'double'
                            : $r.find('.chk-single').is(':checked')
                              ? 'single'
                              : 'none',
                    });
                });
            rooms.push({
                room_index: idx,
                room_name: $(this).find('.room-name-input').val(),
                products: lines,
            });
        });
        return {
            job_name: $('#ow-job-name').val(),
            room_data: rooms,
            cart_product_weight: $('.cart_product_weight').val(),
            all_cart_total: $('.all_cart_total').val(),
            is_assemble: $('input[name="assemble_cabinets_check"]:checked').val() || null,
            order_comment: $('#ow-comment').val(),
            door_label: $('.product_img_name').val(),
            door_image: $('.product_img_src').val(),
        };
    }

    function scheduleAutosave() {
        if (restoring || !cfg.autosaveUrl) return;
        clearTimeout(autosaveTimer);
        autosaveTimer = setTimeout(function () {
            $.ajax({
                url: cfg.autosaveUrl,
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': cfg.csrf },
                contentType: 'application/json',
                data: JSON.stringify(collectAutosaveState()),
            });
        }, 600);
    }

    function validateCart() {
        let ok = true;
        $('.err-job-name, .err-assemble, .err-cart-tot').html('');
        $('tbody.cart-room .err-roomlabel').html('');

        const job = $('#ow-job-name').val().trim();
        if (!job) {
            $('.err-job-name').html('<span class="text-danger">Required Field</span>');
            ok = false;
        }

        let roomFilled = false;
        $('input.room-name-input').each(function () {
            if ($(this).val().trim() !== '') roomFilled = true;
            else {
                $(this).closest('tbody').find('.err-roomlabel').html('<span class="text-danger">Required Field</span>');
                ok = false;
            }
        });
        if (!roomFilled) ok = false;

        if ($('input[name="assemble_cabinets_check"]:checked').length === 0) {
            $('.err-assemble').html('<span class="text-danger">Required Field</span>');
            ok = false;
        }

        const total = parseFloat($('.all_cart_total').val()) || 0;
        if (total <= 0) {
            $('.err-cart-tot').html('<span class="text-danger">Please add items into the cart.</span>');
            ok = false;
        }

        return ok;
    }

    function buildProductRow(roomIndex, $src) {
        const sku = $src.data('sku');
        const label = $src.data('label');
        const desc = $src.data('description');
        const weight = parseFloat($src.data('weight')) || 0;
        const cost = parseFloat($src.data('cost')) || 0;
        const pid = $src.data('cabinetid') || $src.data('product-id');

        return (
            '<tr class="product-row" data-product-id="' +
            pid +
            '" data-sku="' +
            sku +
            '">' +
            '<td><input type="checkbox" class="chk-single ow-chk ow-chk--yellow"><br>' +
            '<input type="checkbox" class="chk-double ow-chk ow-chk--green"></td>' +
            '<td>' +
            label +
            '</td><td>' +
            desc +
            '</td>' +
            '<td class="line-weight">' +
            weight.toFixed(2) +
            ' lbs</td>' +
            '<td class="line-unit">' +
            money(cost) +
            '</td>' +
            '<td class="line-total">' +
            money(cost) +
            '</td>' +
            '<td><div class="ow-qty-wrap">' +
            '<button type="button" class="btn btn-sm btn-light btn-qty-minus">-</button>' +
            '<input type="text" class="form-control form-control-sm product-qty-input text-center" value="1" readonly ' +
            'data-unit-cost="' +
            cost +
            '" data-unit-weight="' +
            weight +
            '">' +
            '<button type="button" class="btn btn-sm btn-light btn-qty-plus">+</button></div></td>' +
            '<td><a href="#" class="btn-delete-row text-primary">×</a></td></tr>'
        );
    }

    function updateRowTotal($row, unitCost, qty) {
        const w = parseFloat($row.find('.product-qty-input').data('unit-weight')) || 0;
        $row.find('.line-total').text(money(unitCost * qty));
        $row.find('.line-weight').text((w * qty).toFixed(2) + ' lbs');
    }

    function appendRoomTbody(n) {
        const html =
            '<tbody data-room-index="' +
            n +
            '" class="cart-room">' +
            '<tr class="room-header-row">' +
            '<th class="ow-room-th">Room <span class="text-danger">*</span></th>' +
            '<th colspan="6"><input type="text" name="roomlabel[]" data-attr="' +
            n +
            '" class="form-control form-control-sm room-name-input" placeholder="Enter Room Name.">' +
            '<input type="hidden" name="roomlabel_id[]" value="' +
            n +
            '">' +
            '<span class="err-roomlabel text-danger"></span></th>' +
            '<th><button type="button" class="btn btn-sm btn-light btn-remove-room" data-room="' +
            n +
            '">-</button></th></tr>' +
            '<tr class="cart-header-row"><th>Double Check Work</th><th>Cabinet Name</th><th>Cabinet Description</th>' +
            '<th>Weight</th><th>Unit Price</th><th>Total Price</th><th>Quantity</th><th>Delete</th></tr></tbody>';
        $('#cart_table tfoot').before(html);
    }

    function postAction(url, extra) {
        const body = {
            job_name: $('#ow-job-name').val().trim(),
            rooms: collectRoomsPayload(),
            assemble_cabinets_check: $('input[name="assemble_cabinets_check"]:checked').val(),
            comment: $('#ow-comment').val(),
            ...extra,
        };
        return $.ajax({
            url,
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': cfg.csrf, Accept: 'application/json' },
            contentType: 'application/json',
            data: JSON.stringify(body),
        });
    }

    function handleSaveResponse(data) {
        if (data.redirect) window.location.href = data.redirect;
        else if (data.message) Swal.fire({ icon: 'success', title: 'Saved', text: data.message });
    }

    // --- Events ---
    $('#ow-add-room').on('click', function () {
        if (!$('#ow-job-name').val().trim()) {
            $('.err-job-name').html('<span class="text-danger">Required Field</span>');
            return;
        }
        roomCounter += 1;
        appendRoomTbody(roomCounter);
        setActiveRoom(roomCounter);
        scheduleAutosave();
    });

    $(document).on('click', '.btn-remove-room', function () {
        const n = $(this).data('room');
        $(`tbody.cart-room[data-room-index="${n}"]`).remove();
        const $last = $('tbody.cart-room').last();
        if ($last.length) setActiveRoom($last.data('room-index'));
        recalcTotals();
    });

    $(document).on('click focus', '.room-name-input', function () {
        setActiveRoom($(this).data('attr'));
    });

    $(document).on('click', 'tbody.cart-room', function (e) {
        if ($(e.target).closest('.btn-remove-room, .btn-delete-row, .btn-qty-minus, .btn-qty-plus').length) return;
        if ($(e.target).hasClass('room-name-input')) return;
        setActiveRoom($(this).data('room-index'));
    });

    $(document).on('dblclick', '.cabinet-label-cell', function () {
        const $cell = $(this).closest('tr');
        const $room = $('tbody.cart-room.active');
        const roomName = $room.find('.room-name-input').val().trim();
        if (!roomName) {
            $room.find('.err-roomlabel').html('<span class="text-danger">Required Field</span>');
            return;
        }
        const sku = $cell.data('sku');
        const existing = $room.find('.product-row[data-sku="' + sku + '"]');
        if (existing.length) {
            const $input = existing.find('.product-qty-input');
            const v = parseInt($input.val(), 10) + 1;
            $input.val(v);
            updateRowTotal(existing, parseFloat($input.data('unit-cost')), v);
            recalcTotals();
            return;
        }
        const roomIndex = $room.data('room-index');
        $room.append(buildProductRow(roomIndex, $cell));
        recalcTotals();
    });

    $(document).on('click', '.btn-qty-minus', function () {
        const $input = $(this).siblings('.product-qty-input');
        let v = parseInt($input.val(), 10) || 1;
        if (v > 1) {
            v -= 1;
            $input.val(v);
            updateRowTotal($(this).closest('tr'), parseFloat($input.data('unit-cost')), v);
            recalcTotals();
        }
    });

    $(document).on('click', '.btn-qty-plus', function () {
        const $input = $(this).siblings('.product-qty-input');
        const v = parseInt($input.val(), 10) + 1;
        $input.val(v);
        updateRowTotal($(this).closest('tr'), parseFloat($input.data('unit-cost')), v);
        recalcTotals();
    });

    $(document).on('click', '.btn-delete-row', function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        recalcTotals();
    });

    $(document).on('change', '.chk-single', function () {
        if (this.checked) $(this).closest('tr').find('.chk-double').prop('checked', false);
    });
    $(document).on('change', '.chk-double', function () {
        if (this.checked) $(this).closest('tr').find('.chk-single').prop('checked', false);
    });

    $('input[name="assemble_cabinets_check"]').on('change', function () {
        $('.err-assemble').html('');
    });

    $('#ow-sku-search-btn').on('click', runSkuSearch);
    $('#ow-sku-search').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            runSkuSearch();
        }
    });

    function runSkuSearch() {
        const sku = $('#ow-sku-search').val().trim();
        if (!sku) {
            window.location.reload();
            return;
        }
        $.post(cfg.accordionSearchUrl, {
            _token: cfg.csrf,
            sku,
            color: $('.product_img_name').val(),
        }).done(function (html) {
            $('#product-list-container').html(html);
        });
    }

    $('#btn-print').on('click', function () {
        if (!validateCart()) return;
        postAction(cfg.urls.print, { shipping_status: 'pending' })
            .done(handleSaveResponse)
            .fail(showError);
    });

    $('#btn-save-quote').on('click', function () {
        if (!validateCart()) return;
        $('#ow-modal-quote').modal('show');
    });

    $('#ow-btn-confirm-quote').on('click', function () {
        const name = $('#ow-quote-name-field').val().trim();
        if (!name) {
            $('#ow-err-quote-name').text('Please enter a quote name.');
            return;
        }
        $('#ow-err-quote-name').text('');
        $('#ow-modal-quote').modal('hide');
        postAction(cfg.urls.quote, { quote_name: name, shipping_status: 'pending' })
            .done(handleSaveResponse)
            .fail(showError);
    });

    $('#btn-shipping-quote').on('click', function () {
        if (!validateCart()) return;
        $('#ow-modal-shipping-confirm').modal('show');
    });

    $('#ow-shipping-confirm-yes').on('click', function () {
        $('#ow-modal-shipping-confirm').modal('hide');
        $('#ow-modal-shipping-info').modal('show');
    });

    $('input[name="ow_unload_type"]').on('change', function () {
        $('#ow-shipping-terms').toggleClass('d-none', this.value !== 'by_hand');
    });

    $('#ow-btn-save-shipping').on('click', function () {
        const name = $('#ow-shipping-quote-name').val().trim();
        const delivery = $('input[name="ow_delivery_type"]:checked').val();
        const liftgate = $('input[name="ow_liftgate"]:checked').val();
        const unload = $('input[name="ow_unload_type"]:checked').val();
        if (!name || !delivery || !liftgate || !unload) {
            $('#ow-err-shipping').text('Please fill all required fields.');
            return;
        }
        $('#ow-err-shipping').text('');
        $('#ow-modal-shipping-info').modal('hide');
        postAction(cfg.urls.shipping, {
            quote_name: name,
            ship_quote_delivery_type: delivery,
            ship_quote_liftgate_req: liftgate,
            ship_quote_unload_type: unload,
            shipping_status: 'yes',
        })
            .done(handleSaveResponse)
            .fail(showError);
    });

    $('#btn-stock-check').on('click', function () {
        if (!validateCart()) return;
        $('#ow-modal-stock-confirm').modal('show');
    });

    $('#ow-stock-confirm-no').on('click', function () {
        $('#ow-modal-stock-confirm').modal('hide');
        postAction(cfg.urls.stock, { shipping_status: 'pending', ship_quote_type: '' })
            .done(handleSaveResponse)
            .fail(showError);
    });

    $('#ow-stock-confirm-yes').on('click', function () {
        $('#ow-modal-stock-confirm').modal('hide');
        $('#ow-modal-stock-shipping').modal('show');
    });

    $('#ow-btn-save-stock-shipping').on('click', function () {
        const delivery = $('input[name="ow_stock_delivery_type"]:checked').val();
        const liftgate = $('input[name="ow_stock_liftgate"]:checked').val();
        const unload = $('input[name="ow_stock_unload_type"]:checked').val();
        if (!delivery || !liftgate || !unload) {
            $('#ow-err-stock-shipping').text('Please fill all required fields.');
            return;
        }
        $('#ow-err-stock-shipping').text('');
        $('#ow-modal-stock-shipping').modal('hide');
        postAction(cfg.urls.stock, {
            shipping_status: 'yes',
            ship_quote_type: 'stockcheckshippingquote',
            ship_quote_delivery_type: delivery,
            ship_quote_liftgate_req: liftgate,
            ship_quote_unload_type: unload,
        })
            .done(handleSaveResponse)
            .fail(showError);
    });

    $('#btn-process-order').on('click', function () {
        if (!validateCart()) return;
        postAction(cfg.urls.process, {})
            .done(handleSaveResponse)
            .fail(showError);
    });

    function showError(xhr) {
        const msg = xhr.responseJSON?.message || 'Could not save.';
        Swal.fire({ icon: 'error', title: 'Error', text: msg });
    }

    $(document).on('keypress', function (e) {
        if (e.which === 13 && !$(e.target).is('textarea')) e.preventDefault();
    });

    // Restore saved cart_data
    const saved = $page.data('saved-cart');
    if (saved && saved.room_data && saved.room_data.length) {
        restoring = true;
        if (saved.job_name) $('#ow-job-name').val(saved.job_name);
        if (saved.order_comment) $('#ow-comment').val(saved.order_comment);
        if (saved.is_assemble) $('input[name="assemble_cabinets_check"][value="' + saved.is_assemble + '"]').prop('checked', true);

        saved.room_data.forEach(function (room, idx) {
            if (idx > 0) {
                roomCounter = Math.max(roomCounter, room.room_index || idx + 1);
                if (!$('tbody.cart-room[data-room-index="' + room.room_index + '"]').length) {
                    appendRoomTbody(room.room_index);
                }
            }
            const $tb = $('tbody.cart-room[data-room-index="' + (room.room_index || 1) + '"]');
            $tb.find('.room-name-input').val(room.room_name || '');
            (room.products || []).forEach(function (p) {
                const $fake = $('<tr>').data({
                    sku: p.sku,
                    label: p.label,
                    description: p.description,
                    weight: p.weight,
                    cost: p.cost,
                    cabinetid: p.product_id,
                });
                $tb.append(buildProductRow(room.room_index || 1, $fake));
                const $row = $tb.find('.product-row').last();
                $row.find('.product-qty-input').val(p.quantity || 1);
                if (p.checkbox_status === 'single') $row.find('.chk-single').prop('checked', true);
                if (p.checkbox_status === 'double') $row.find('.chk-double').prop('checked', true);
                updateRowTotal($row, parseFloat(p.cost), parseInt(p.quantity, 10) || 1);
            });
        });
        restoring = false;
        recalcTotals();
    }
})(window.jQuery);
