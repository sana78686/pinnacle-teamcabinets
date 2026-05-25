(function () {
    'use strict';

    var cfg = window.TC_COOKIE_CONSENT || {};
    var key = cfg.storageKey || 'tc_cookie_consent';
    var bar = document.getElementById('tc-cookie-consent');
    var acceptBtn = document.getElementById('tc-cookie-accept');

    if (!bar || !acceptBtn) {
        return;
    }

    try {
        if (localStorage.getItem(key) === 'accepted') {
            return;
        }
    } catch (e) {
        /* private browsing */
    }

    bar.hidden = false;

    acceptBtn.addEventListener('click', function () {
        try {
            localStorage.setItem(key, 'accepted');
        } catch (e) {
            /* ignore */
        }
        bar.hidden = true;
    });
})();
