/**
 * CI-identical order workspace (Team Cabinets) — Laravel tenant theme.
 */
(function ($) {
    'use strict';

    const $page = $('#ow-page');
    if (!$page.length) return;

    /** jQuery .data() camelCases keys; use attributes so URLs/CSRF always resolve. */
    function pageAttr(name) {
        const v = $page.attr('data-' + name);
        return v === undefined || v === '' ? undefined : v;
    }

    function pageJson(name) {
        const raw = pageAttr(name);
        if (!raw) return null;
        try {
            return JSON.parse(raw);
        } catch (e) {
            return null;
        }
    }

    const cfg = {
        catalogId: parseInt(pageAttr('catalog-id'), 10) || pageAttr('catalog-id'),
        doorId: parseInt(pageAttr('door-id'), 10) || pageAttr('door-id'),
        catalogName: pageAttr('catalog-name') || '',
        doorLabel: pageAttr('door-label') || '',
        csrf: pageAttr('csrf'),
        accordionSearchPrefix: pageAttr('accordion-search-prefix'),
        autosaveUrl: pageAttr('autosave-url'),
        clearCartUrl: pageAttr('clear-cart-url'),
        urls: {
            print: pageAttr('store-print-url'),
            quote: pageAttr('store-quote-url'),
            shipping: pageAttr('store-shipping-url'),
            stock: pageAttr('store-stock-url'),
        },
    };

    let roomCounter = 1;
    let autosaveTimer = null;
    let restoring = false;
    let clearingCart = false;

    function money(n) {
        return '$' + (Number(n) || 0).toFixed(2);
    }

    function hasJobName() {
        return $('#ow-job-name').val().trim().length > 0;
    }

    function requireJobName() {
        if (hasJobName()) {
            return true;
        }
        $('.err-job-name').html('<span class="text-danger">Required Field</span>');
        $('#ow-job-name').focus();
        return false;
    }

    function syncJobNameGate() {
        const enabled = hasJobName();
        $('.room-name-input')
            .prop('readonly', !enabled)
            .attr('placeholder', enabled ? 'Enter room name' : 'Enter job name first');
        $('#ow-add-room').prop('disabled', !enabled);
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

    function lineCheckboxPayload($r) {
        const val1 = $r.find('.chk-single').is(':checked');
        const val2 = $r.find('.chk-double').is(':checked');
        return {
            checkbox_val1: val1 ? 1 : 0,
            checkbox_val2: val2 ? 1 : 0,
            checkbox_status: val1 && val2 ? 'both' : val1 ? 'single' : val2 ? 'double' : 'none',
        };
    }

    function num(v, fallback) {
        const n = parseFloat(v);
        return Number.isFinite(n) ? n : fallback !== undefined ? fallback : 0;
    }

    /** CI catalog/door keys: spaces → underscores (ARTSTAR, Shaker_White). */
    function ciFactorKey(label) {
        return String(label || '')
            .trim()
            .split(' ')
            .join('_');
    }

    function parseDoorTree(raw) {
        if (!raw) {
            return null;
        }
        if (typeof raw === 'object') {
            return raw;
        }
        try {
            return JSON.parse(raw);
        } catch (e) {
            return null;
        }
    }

    function ciDoorFactorFromTree(tree, catalogName, doorLabel) {
        if (!tree) {
            return '';
        }
        const catKey = ciFactorKey(catalogName);
        const doorKey = ciFactorKey(doorLabel);
        const byCat = tree[catKey];
        if (!byCat || byCat[doorKey] === undefined || byCat[doorKey] === null) {
            return '';
        }
        const val = String(byCat[doorKey]).replace(/,/g, '');
        if (val === '' || val.toLowerCase() === 'null') {
            return '';
        }
        return val;
    }

    /** CI cart unit: base cost × door factor (direct multiply). */
    function ciCartUnitCost(rawCost, doorTreeRaw, catalogName, doorLabel) {
        const raw = num(rawCost, 0);
        const factor = ciDoorFactorFromTree(parseDoorTree(doorTreeRaw), catalogName, doorLabel);
        if (factor === '') {
            return raw;
        }
        return parseFloat((raw * parseFloat(factor)).toFixed(2));
    }

    function normalizeSavedLine(p) {
        const qty = parseInt(p.quantity ?? p.product_quantity ?? p.cabinet_quantity, 10) || 1;
        const cost = num(p.cost ?? p.product_cost, 0);
        return {
            product_id: p.product_id ?? p.product_ids ?? p.add_pro_ids_room_wise ?? '',
            sku: p.sku ?? p.product_sku ?? '',
            label: p.label ?? p.product_name ?? p.cabinet_name ?? '',
            description: p.description ?? p.product_cabinets_description ?? p.cabinet_description ?? '',
            weight: num(p.weight ?? p.product_weight, 0),
            cost: cost,
            cost1: num(p.cost1 ?? p.product_actual_price ?? p.product_count_cost, cost),
            quantity: qty,
            cabinet_id: p.cabinet_id ?? p.product_cabinets_id ?? p.cabinets_id ?? '',
            product_details: p.product_details ?? '',
            assemble_cost: num(p.assemble_cost ?? p.product_assemble_cost, 0),
            product_color: p.product_color ?? p.product_cabinets_color ?? p.cabinet_color ?? '',
            parent_door_price: p.parent_door_price ?? '',
            parent_door_factor: p.parent_door_factor ?? p.parent_door_point ?? '',
            representative_door_price: p.representative_door_price ?? '',
            representative_door_factor: p.representative_door_factor ?? p.representative_door_point ?? '',
            user_door_factor: p.user_door_factor ?? p.user_door_point ?? p.door_point ?? '',
            catalogue_name: p.catalogue_name ?? p.sel_catalogue_name ?? '',
            product_note: p.product_note ?? '',
            line_total: num(p.line_total ?? p.product_tot_price, cost * qty),
            checkbox_val1: p.checkbox_val1,
            checkbox_val2: p.checkbox_val2,
            checkbox_status: p.checkbox_status,
        };
    }

    function rowAttr($row, name) {
        const v = $row.attr('data-' + name);
        return v === undefined || v === '' ? undefined : v;
    }

    function lineFromPicker($src) {
        const doorColor = $('.product_img_name').val() || cfg.doorLabel || '';
        const catalogName = cfg.catalogName || '';
        const raw = num(rowAttr($src, 'cost1') ?? rowAttr($src, 'cost'), 0);
        const cartCost = ciCartUnitCost(raw, rowAttr($src, 'door-point'), catalogName, doorColor);
        return normalizeSavedLine({
            product_id: rowAttr($src, 'cabinetid') || $src.data('cabinetid') || $src.data('productId'),
            sku: rowAttr($src, 'sku') || $src.data('sku'),
            label: rowAttr($src, 'label') || $src.data('label'),
            description: rowAttr($src, 'description') || $src.data('description'),
            weight: num(rowAttr($src, 'weight') ?? $src.data('weight'), 0),
            cost: cartCost,
            cost1: raw,
            cabinet_id: rowAttr($src, 'cabinet') || $src.data('cabinet'),
            product_details: rowAttr($src, 'details') || $src.data('details'),
            assemble_cost: num(rowAttr($src, 'ass-cost') ?? $src.data('assCost'), 0),
            product_color: doorColor,
            parent_door_factor: rowAttr($src, 'parent-point'),
            representative_door_factor: rowAttr($src, 'representative-point'),
            user_door_factor: rowAttr($src, 'door-point'),
            catalogue_name: $('input[name="catalogue_name"]').val() || cfg.catalogName || '',
            quantity: 1,
        });
    }

    function lineFromCartRow($r) {
        return normalizeSavedLine({
            product_id: $r.data('product-id'),
            sku: $r.data('sku'),
            label: $r.data('label'),
            description: $r.data('description'),
            weight: $r.data('unit-weight'),
            cost: $r.data('unit-cost'),
            cost1: $r.data('unit-cost-raw') ?? $r.data('unit-cost'),
            quantity: parseInt($r.find('.product-qty-input').val(), 10) || 1,
            cabinet_id: $r.data('cabinet-id'),
            product_details: $r.data('product-details'),
            assemble_cost: $r.data('assemble-cost'),
            product_color: $r.data('product-color'),
            parent_door_price: $r.data('parent-door-price'),
            parent_door_factor: $r.data('parent-door-factor'),
            representative_door_price: $r.data('rep-door-price'),
            representative_door_factor: $r.data('rep-door-factor'),
            user_door_factor: $r.data('user-door-factor'),
            catalogue_name: $r.data('catalogue-name'),
            product_note: $r.data('product-note'),
            line_total: $r.data('line-total'),
            ...lineCheckboxPayload($r),
        });
    }

    function enrichLineFromPicker(line) {
        line = normalizeSavedLine(line);
        if (!line.sku) {
            return line;
        }
        const $pick = $('#product-list-container tr.cabinet-row').filter(function () {
            return String($(this).data('sku')) === String(line.sku);
        }).first();
        if (!$pick.length) {
            return line;
        }
        const fresh = lineFromPicker($pick);
        return normalizeSavedLine({
            ...fresh,
            ...line,
            cost: line.cost || fresh.cost,
            cost1: line.cost1 || fresh.cost1,
            weight: line.weight || fresh.weight,
            line_total: line.line_total || fresh.line_total,
        });
    }

    function applyLineCheckboxes($row, line) {
        const v1 =
            line.checkbox_val1 == 1 ||
            line.checkbox_val1 === '1' ||
            line.checkbox_status === 'single' ||
            line.checkbox_status === 'both';
        const v2 =
            line.checkbox_val2 == 1 ||
            line.checkbox_val2 === '1' ||
            line.checkbox_status === 'double' ||
            line.checkbox_status === 'both';
        $row.find('.chk-single').prop('checked', !!v1);
        $row.find('.chk-double').prop('checked', !!v2);
    }

    function roomsFromSaved(saved) {
        const rd = saved.room_data;
        if (!rd) {
            return [];
        }
        if (Array.isArray(rd)) {
            return rd;
        }
        const rooms = [];
        let idx = 1;
        Object.keys(rd).forEach(function (roomName) {
            const val = rd[roomName];
            const skus = val.product_sku || [];
            const products = [];
            for (let i = 0; i < skus.length; i++) {
                products.push({
                    product_id: (val.product_ids || val.add_pro_ids_room_wise || [])[i],
                    sku: skus[i],
                    label: (val.product_name || [])[i],
                    description: (val.product_cabinets_description || [])[i],
                    weight: (val.product_weight || [])[i],
                    cost: (val.product_cost || [])[i],
                    cost1: (val.product_actual_price || [])[i],
                    quantity: (val.product_quantity || [])[i] || 1,
                    cabinet_id: (val.product_cabinets_id || [])[i],
                    product_details: (val.product_details || [])[i],
                    assemble_cost: (val.product_assemble_cost || [])[i],
                    product_color: (val.product_cabinets_color || [])[i],
                    parent_door_price: (val.parent_door_price || [])[i],
                    parent_door_factor: (val.parent_door_factor || [])[i],
                    representative_door_price: (val.representative_door_price || [])[i],
                    representative_door_factor: (val.representative_door_factor || [])[i],
                    user_door_factor: (val.user_door_factor || [])[i],
                    catalogue_name: (val.sel_catalogue_name || [])[i],
                    product_note: (val.product_note || [])[i],
                    line_total: (val.product_tot_price || [])[i],
                    checkbox_val1: (val.checkbox_val1 || [])[i],
                    checkbox_val2: (val.checkbox_val2 || [])[i],
                });
            }
            rooms.push({ room_index: idx++, room_name: roomName, products: products });
        });
        return rooms;
    }

    function restoreDoorSelection(saved) {
        if (!saved.door_label && !saved.door_image) {
            return;
        }
        if (saved.door_label) {
            $('.product_img_name').val(saved.door_label);
            $('#door-heading').text(saved.door_label);
        }
        if (saved.door_image) {
            $('.product_img_src').val(saved.door_image);
            $('#door-preview-img').attr('src', saved.door_image).removeClass('d-none');
            $('#door-preview-empty').hide();
        }
        const $tile = $('.door-image-tile, .ow-door-pill').filter(function () {
            return $(this).data('label') === saved.door_label;
        }).first();
        if ($tile.length) {
            $('.door-image-tile, .ow-door-pill').removeClass('is-selected selected');
            $tile.addClass('is-selected selected');
            if ($tile.data('door-id')) {
                cfg.doorId = $tile.data('door-id');
            }
        }
    }

    function collectRoomsPayload() {
        const rooms = [];
        $('tbody.cart-room').each(function () {
            const $tb = $(this);
            const roomName = $tb.find('.room-name-input').val().trim();
            const products = [];
            $tb.find('.product-row').each(function () {
                const line = lineFromCartRow($(this));
                products.push({
                    product_id: parseInt(line.product_id, 10),
                    quantity: line.quantity,
                    cost: line.cost,
                    cost1: line.cost1,
                    weight: line.weight,
                    sku: line.sku,
                    label: line.label,
                    description: line.description,
                    assemble_cost: line.assemble_cost,
                    ...lineCheckboxPayload($(this)),
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
                    lines.push(lineFromCartRow($(this)));
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
        if (restoring || clearingCart || !cfg.autosaveUrl) return;
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

    function accordionSearchUrl() {
        return cfg.accordionSearchPrefix + '/' + cfg.doorId + '/accordion-search';
    }

    function populateProductDetails($row) {
        const catName = $row.closest('table').data('category-name') || '';
        $('.ow-detail-placeholder').hide();
        $('#detail-category').text(catName ? catName + ':' : '');
        $('#detail-label').text($row.data('label') || '');
        $('#detail-sku').text('SKU: ' + ($row.data('sku') || ''));
        $('#detail-weight').text('Weight: ' + ($row.data('weight') || 0) + ' lbs');
        $('#detail-cost').text('Cost: $' + (parseFloat(rowAttr($row, 'cost1') ?? rowAttr($row, 'cost')) || 0).toFixed(2));
        $('#detail-info').text('Details: ' + ($row.data('details') || ''));
        const img = $row.data('product-img');
        if (img) {
            $('#detail-img').attr('src', img).removeClass('d-none');
        } else {
            $('#detail-img').addClass('d-none');
        }
    }

    function buildProductRow(line) {
        line = enrichLineFromPicker(normalizeSavedLine(line));
        const qty = line.quantity || 1;
        const cost = line.cost;
        const weight = line.weight;
        const lineTotal = line.line_total > 0 ? line.line_total : cost * qty;
        const $tr = $('<tr class="product-row"></tr>');
        $tr.attr({
            'data-product-id': line.product_id || '',
            'data-sku': line.sku || '',
            'data-label': line.label || '',
            'data-description': line.description || '',
            'data-unit-weight': weight,
            'data-unit-cost': cost,
            'data-unit-cost-raw': line.cost1,
            'data-cabinet-id': line.cabinet_id || '',
            'data-product-details': line.product_details || '',
            'data-assemble-cost': line.assemble_cost,
            'data-product-color': line.product_color || '',
            'data-parent-door-price': line.parent_door_price,
            'data-parent-door-factor': line.parent_door_factor,
            'data-rep-door-price': line.representative_door_price,
            'data-rep-door-factor': line.representative_door_factor,
            'data-user-door-factor': line.user_door_factor,
            'data-catalogue-name': line.catalogue_name || '',
            'data-product-note': line.product_note || '',
            'data-line-total': lineTotal,
        });
        $tr.append(
            '<td class="ow-check-cell"><input type="checkbox" class="cb-yellow chk-single" style="accent-color:yellow">' +
                '<input type="checkbox" class="cb-green chk-double" style="accent-color:green"></td>'
        );
        $tr.append($('<td></td>').text(line.label || ''));
        $tr.append($('<td></td>').text(line.description || ''));
        $tr.append($('<td class="line-weight"></td>').text(weight.toFixed(2) + ' lbs'));
        $tr.append($('<td class="line-unit"></td>').text(money(cost)));
        $tr.append($('<td class="line-total"></td>').text(money(lineTotal)));
        $tr.append(
            '<td class="product-qty-cell text-center">' +
                '<span class="product-qty-count">1</span>' +
                '<input type="hidden" class="product-qty-input" value="1" min="1" ' +
                'data-unit-cost="' +
                cost +
                '" data-unit-weight="' +
                weight +
                '">' +
                '</td><td><a href="#" class="btn-delete-row text-primary">×</a></td>'
        );
        setRowQty($tr, qty);
        applyLineCheckboxes($tr, line);
        updateRowTotal($tr, cost, qty);
        return $tr;
    }

    function setRowQty($row, qty) {
        const n = Math.max(1, parseInt(qty, 10) || 1);
        $row.find('.product-qty-input').val(n);
        $row.find('.product-qty-count').text(n);
        return n;
    }

    function updateRowTotal($row, unitCost, qty) {
        const w = parseFloat($row.find('.product-qty-input').data('unit-weight')) || 0;
        $row.find('.line-total').text(money(unitCost * qty));
        $row.find('.line-weight').text((w * qty).toFixed(2) + ' lbs');
    }

    function appendRoomTbody(n) {
        const removeBtn =
            '<button type="button" class="btn btn-sm btn-light btn-remove-room flex-shrink-0" data-room="' +
            n +
            '">-</button>';
        const html =
            '<tbody data-room-index="' +
            n +
            '" class="cart-room">' +
            '<tr class="room-header-row"><th colspan="8">' +
            '<div class="ow-room-toolbar">' +
            '<span class="ow-room-toolbar__label">Room <span class="text-danger">*</span></span>' +
            '<input type="text" name="roomlabel[]" data-attr="' +
            n +
            '" class="form-control form-control-sm room-name-input ow-room-toolbar__input" placeholder="Enter room name" readonly>' +
            '<input type="hidden" name="roomlabel_id[]" value="' +
            n +
            '">' +
            removeBtn +
            '</div>' +
            '<span class="err-roomlabel text-danger f-12 d-block"></span></th></tr>' +
            '<tr class="cart-header-row"><th>Check</th><th>Name</th><th>Desc</th><th>Wt</th><th>Unit</th><th>Total</th><th>Qty</th><th></th></tr></tbody>';
        $('#cart_table tfoot').before(html);
    }

    function workspaceMeta() {
        return {
            catalogue_name: $('input[name="catalogue_name"]').val() || '',
            product_img_name: $('.product_img_name').val() || '',
            product_img_src: $('.product_img_src').val() || '',
            cus_rep_id: $('input[name="cus_rep_id"]').val() || '',
            cus_parent_id: $('input[name="cus_parent_id"]').val() || '',
            catalog_id: cfg.catalogId,
            door_id: cfg.doorId,
        };
    }

    function postAction(url, extra) {
        if (!url) {
            return $.Deferred().reject({ responseJSON: { message: 'Action URL is not configured.' } }).promise();
        }
        const body = {
            job_name: $('#ow-job-name').val().trim(),
            rooms: collectRoomsPayload(),
            assemble_cabinets_check: $('input[name="assemble_cabinets_check"]:checked').val(),
            comment: $('#ow-comment').val(),
            ...workspaceMeta(),
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

    function resetWorkspaceCartUi() {
        $('#ow-job-name').val('');
        $('#ow-comment').val('');
        $('input[name="assemble_cabinets_check"][value="no"]').prop('checked', true);
        $('.cart-room').remove();
        roomCounter = 1;
        $('.cart_product_weight').val('0 lbs');
        $('.all_cart_total').val('0');
        $('.total-weight').text('0 lbs');
        $('.total-price').text('$0.00');
        $('.err-job-name, .err-roomlabel, .err-cart-tot, .err-assemble').html('');
        syncJobNameGate();
        scheduleAutosave();
    }

    function handleSaveResponse(data, opts) {
        opts = opts || {};
        if (data.clear_cart) {
            resetWorkspaceCartUi();
        }
        if (data.redirect) {
            if (opts.newTab) {
                window.open(data.redirect, '_blank');
                return;
            }
            if (data.message && typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'success', title: 'Saved', text: data.message }).then(function () {
                    window.location.href = data.redirect;
                });
                return;
            }
            window.location.href = data.redirect;
            return;
        }
        if (data.message && typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'success', title: 'Saved', text: data.message });
        }
    }

    // --- Events ---
    $('#ow-clear-cart-link').on('click', function (e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to clear all the items in cart?')) {
            return;
        }
        clearingCart = true;
        clearTimeout(autosaveTimer);
        const url = cfg.clearCartUrl || $(this).attr('href');
        if (url) {
            window.location.href = url;
        }
    });

    $('#ow-job-name').on('input', function () {
        $('.err-job-name').html('');
        syncJobNameGate();
    });

    syncJobNameGate();

    $('#ow-add-room').on('click', function () {
        if (!requireJobName()) {
            return;
        }
        roomCounter += 1;
        appendRoomTbody(roomCounter);
        syncJobNameGate();
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

    $(document).on('focus', '.room-name-input', function () {
        if (!requireJobName()) {
            $(this).blur();
            return;
        }
        setActiveRoom($(this).data('attr'));
    });

    $(document).on('click', '.room-name-input', function () {
        if (!requireJobName()) {
            return;
        }
        setActiveRoom($(this).data('attr'));
    });

    $(document).on('click', 'tbody.cart-room', function (e) {
        if ($(e.target).closest('.btn-remove-room, .btn-delete-row').length) return;
        if ($(e.target).hasClass('room-name-input')) return;
        if (!requireJobName()) return;
        setActiveRoom($(this).data('room-index'));
    });

    $(document).on('click', '.cabinet-row', function (e) {
        if (e.detail > 1) return;
        populateProductDetails($(this));
    });

    $(document).on('dblclick', '.cabinet-label-cell', function (e) {
        e.preventDefault();
        if (!requireJobName()) {
            return;
        }
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
            const v = setRowQty(existing, parseInt($input.val(), 10) + 1);
            updateRowTotal(existing, parseFloat($input.data('unit-cost')), v);
            recalcTotals();
            scheduleAutosave();
            return;
        }
        $room.append(buildProductRow(lineFromPicker($cell)));
        recalcTotals();
    });

    $(document).on('click', '.btn-delete-row', function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        recalcTotals();
    });

    $(document).on('change', '.chk-single, .chk-double, .cb-yellow, .cb-green', function () {
        scheduleAutosave();
    });

    $(document).on('click', '.door-image-tile, .door-image-tile.ow-door-pill', function () {
        const $tile = $(this);
        $('.door-image-tile, .ow-door-pill').removeClass('is-selected selected');
        $tile.addClass('is-selected selected');
        const name = $tile.data('label');
        const src = $tile.data('src') || $tile.find('img').attr('src') || '';
        cfg.doorId = $tile.data('door-id');
        cfg.doorLabel = name;
        $('.product_img_name').val(name);
        $('.product_img_src').val(src);
        $('#door-heading').text(name);
        if (src) {
            $('#door-preview-img').attr('src', src).removeClass('d-none');
            $('#door-preview-empty').hide();
        } else {
            $('#door-preview-img').addClass('d-none');
            $('#door-preview-empty').show();
        }
        runSkuSearch(true);
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

    function runSkuSearch(forceFull) {
        const sku = forceFull ? '' : $('#ow-sku-search').val().trim();
        $.post(accordionSearchUrl(), {
            _token: cfg.csrf,
            sku: sku || '',
            color: $('.product_img_name').val(),
        }).done(function (html) {
            $('#product-list-container').html(html || '<p class="p-3 text-muted">No Product Found</p>');
        });
    }

    $('#btn-print').on('click', function () {
        if (!validateCart()) return;
        const $btn = $(this).prop('disabled', true);
        postAction(cfg.urls.print, { shipping_status: 'pending' })
            .done(function (data) {
                handleSaveResponse(data, { newTab: true });
            })
            .fail(showError)
            .always(function () {
                $btn.prop('disabled', false);
            });
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
        postAction(cfg.urls.quote, {
            quote_name: name,
            shipping_status: 'pending',
            quote_saved_id: $('#quote_saved_id').val() || '',
        })
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
            shipping_quote_saved_id: $('#shipping_quote_saved_id').val() || '',
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

    function showError(xhr) {
        let msg = 'Could not save.';
        if (xhr.responseJSON) {
            if (xhr.responseJSON.message) msg = xhr.responseJSON.message;
            else if (xhr.responseJSON.errors) {
                const errs = xhr.responseJSON.errors;
                msg = Object.keys(errs)
                    .map(function (k) {
                        return errs[k][0];
                    })
                    .join(' ');
            }
        } else if (xhr.status === 419) {
            msg = 'Session expired. Please refresh the page and try again.';
        } else if (xhr.status === 0) {
            msg = 'Network error — could not reach the server.';
        }
        if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'error', title: 'Error', text: msg });
        } else {
            alert(msg);
        }
    }

    $(document).on('keypress', function (e) {
        if (e.which === 13 && !$(e.target).is('textarea')) {
            e.preventDefault();
            runSkuSearch();
        }
    });

    // Restore saved cart_data (Laravel room_data[] or legacy CI keyed room_data)
    const saved = pageJson('saved-cart');
    const savedRooms = saved ? roomsFromSaved(saved) : [];
    if (saved) {
        if (saved.order_comment != null && String(saved.order_comment).length) {
            $('#ow-comment').val(saved.order_comment);
        }
    }
    if (saved && savedRooms.length) {
        restoring = true;
        if (saved.job_name) $('#ow-job-name').val(saved.job_name);
        syncJobNameGate();
        if (saved.order_comment != null && String(saved.order_comment).length) {
            $('#ow-comment').val(saved.order_comment);
        }
        if (saved.is_assemble) {
            const assembleVal = saved.is_assemble === 1 || saved.is_assemble === '1' ? 'yes' : saved.is_assemble;
            $('input[name="assemble_cabinets_check"][value="' + assembleVal + '"]').prop('checked', true);
        }
        restoreDoorSelection(saved);

        savedRooms.forEach(function (room, idx) {
            const roomIndex = room.room_index || idx + 1;
            if (idx > 0) {
                roomCounter = Math.max(roomCounter, roomIndex);
                if (!$('tbody.cart-room[data-room-index="' + roomIndex + '"]').length) {
                    appendRoomTbody(roomIndex);
                }
            }
            const $tb = $('tbody.cart-room[data-room-index="' + roomIndex + '"]');
            $tb.find('.room-name-input').val(room.room_name || '');
            (room.products || []).forEach(function (p) {
                const line = enrichLineFromPicker(normalizeSavedLine(p));
                const sku = line.sku;
                const existing = sku ? $tb.find('.product-row[data-sku="' + sku + '"]') : $();
                if (existing.length) {
                    const $input = existing.find('.product-qty-input');
                    const v = setRowQty(existing, parseInt($input.val(), 10) + (line.quantity || 1));
                    updateRowTotal(existing, parseFloat($input.data('unit-cost')), v);
                } else {
                    $tb.append(buildProductRow(line));
                }
            });
        });
        restoring = false;
        syncJobNameGate();
        recalcTotals();
    }
})(window.jQuery);
