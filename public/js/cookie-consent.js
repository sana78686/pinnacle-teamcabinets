(function () {
    'use strict';

    var cfg = window.TC_COOKIE_CONSENT || {};
    var key = cfg.storageKey || 'tc_cookie_consent';
    var bar = document.getElementById('tc-cookie-consent');
    var acceptBtn = document.getElementById('tc-cookie-accept');
    var dismissBtn = document.getElementById('tc-cookie-dismiss');

    if (!bar || !acceptBtn) {
        return;
    }

    function hideBar() {
        bar.hidden = true;
        bar.setAttribute('aria-hidden', 'true');
    }

    function storeAccepted() {
        try {
            localStorage.setItem(key, 'accepted');
        } catch (e) {
            /* private browsing */
        }
    }

    try {
        if (localStorage.getItem(key) === 'accepted') {
            return;
        }
    } catch (e) {
        /* private browsing */
    }

    bar.hidden = false;
    bar.removeAttribute('aria-hidden');

    acceptBtn.addEventListener('click', function () {
        storeAccepted();
        hideBar();
    });

    if (dismissBtn) {
        dismissBtn.addEventListener('click', function () {
            storeAccepted();
            hideBar();
        });
    }
})();
