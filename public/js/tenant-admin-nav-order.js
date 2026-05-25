(function () {
    'use strict';

    function start() {
        var config = window.TENANT_NAV_MENU_CONFIG;
        var list = document.getElementById('tc-nav-order-list');
        if (!config || !list || typeof Sortable === 'undefined') {
            return;
        }

        var flash = document.getElementById('tc-nav-order-flash');
        var saveBtn = document.getElementById('tc-nav-order-save');
        var resetBtn = document.getElementById('tc-nav-order-reset');

        Sortable.create(list, {
            animation: 150,
            handle: '.tc-nav-order-list__handle',
            ghostClass: 'tc-nav-order-list__item--ghost',
            chosenClass: 'tc-nav-order-list__item--chosen',
            onSort: updatePositions,
        });

        function updatePositions() {
            Array.prototype.forEach.call(list.querySelectorAll('.tc-nav-order-list__item'), function (el, idx) {
                var pos = el.querySelector('.tc-nav-order-list__position');
                if (pos) {
                    pos.textContent = String(idx + 1);
                }
            });
        }

        function showFlash(ok, text) {
            if (!flash) {
                return;
            }
            flash.classList.remove('d-none', 'alert-success', 'alert-danger');
            flash.classList.add(ok ? 'alert-success' : 'alert-danger');
            flash.textContent = text;
        }

        function currentOrder() {
            return Array.prototype.map.call(
                list.querySelectorAll('.tc-nav-order-list__item'),
                function (el) {
                    return el.getAttribute('data-key');
                }
            ).filter(Boolean);
        }

        function headers() {
            return {
                'X-CSRF-TOKEN': config.csrf,
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            };
        }

        function rerenderFeather() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        function rebuildList(items) {
            list.innerHTML = '';
            (items || []).forEach(function (item, idx) {
                var li = document.createElement('li');
                li.className = 'tc-nav-order-list__item';
                li.setAttribute('data-key', item.key);
                li.innerHTML =
                    '<span class="tc-nav-order-list__position" aria-hidden="true">' + (idx + 1) + '</span>' +
                    '<span class="tc-nav-order-list__handle" aria-hidden="true"><i data-feather="menu"></i></span>' +
                    '<span class="tc-nav-order-list__icon"><i data-feather="' + item.icon + '"></i></span>' +
                    '<span class="tc-nav-order-list__label">' + item.label + '</span>';
                list.appendChild(li);
            });
            rerenderFeather();
        }

        if (saveBtn) {
            saveBtn.addEventListener('click', function () {
                saveBtn.disabled = true;
                fetch(config.saveUrl, {
                    method: 'POST',
                    headers: headers(),
                    body: JSON.stringify({ order: currentOrder() }),
                })
                    .then(function (res) {
                        return res.json().then(function (json) {
                            if (!res.ok) {
                                throw new Error(json.message || 'Save failed.');
                            }
                            return json;
                        });
                    })
                    .then(function () {
                        window.location.href = config.dashboardUrl || '/';
                    })
                    .catch(function (e) {
                        showFlash(false, e.message || 'Save failed.');
                    })
                    .finally(function () {
                        saveBtn.disabled = false;
                    });
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                if (!window.confirm('Reset navigation to the default order?')) {
                    return;
                }
                resetBtn.disabled = true;
                fetch(config.resetUrl, {
                    method: 'POST',
                    headers: headers(),
                    body: JSON.stringify({}),
                })
                    .then(function (res) {
                        return res.json().then(function (json) {
                            if (!res.ok) {
                                throw new Error(json.message || 'Reset failed.');
                            }
                            return json;
                        });
                    })
                    .then(function (json) {
                        rebuildList(json.items || []);
                        showFlash(true, json.message || 'Reset.');
                    })
                    .catch(function (e) {
                        showFlash(false, e.message || 'Reset failed.');
                    })
                    .finally(function () {
                        resetBtn.disabled = false;
                    });
            });
        }

        rerenderFeather();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);
    } else {
        start();
    }
})();
