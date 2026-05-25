(function () {
    'use strict';

    function readStore(key) {
        try {
            var raw = localStorage.getItem(key);
            if (!raw) {
                return null;
            }
            return JSON.parse(raw);
        } catch (e) {
            return null;
        }
    }

    function writeStore(key, data) {
        try {
            localStorage.setItem(key, JSON.stringify(data));
        } catch (e) {
            /* ignore */
        }
    }

    function clearStore(key) {
        try {
            localStorage.removeItem(key);
        } catch (e) {
            /* ignore */
        }
    }

    document.querySelectorAll('form[data-remember-login]').forEach(function (form) {
        var storageKey = form.getAttribute('data-remember-login');
        var loginEl = form.querySelector('[data-remember-field="login"]');
        var passEl = form.querySelector('[data-remember-field="password"]');
        var rememberEl = form.querySelector('[data-remember-checkbox]');

        if (!storageKey || !loginEl || !passEl || !rememberEl) {
            return;
        }

        var saved = readStore(storageKey);
        if (saved) {
            if (saved.login && !loginEl.value) {
                loginEl.value = saved.login;
            }
            if (saved.password) {
                passEl.value = saved.password;
            }
            rememberEl.checked = true;
        } else if (rememberEl.checked && loginEl.value && !passEl.value) {
            /* login prefilled from server cookie only */
        }

        rememberEl.addEventListener('change', function () {
            if (!rememberEl.checked) {
                clearStore(storageKey);
            }
        });

        form.addEventListener('submit', function () {
            if (rememberEl.checked) {
                writeStore(storageKey, {
                    login: loginEl.value,
                    password: passEl.value,
                });
            } else {
                clearStore(storageKey);
            }
        });
    });
})();
