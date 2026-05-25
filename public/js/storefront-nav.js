(function () {
    'use strict';

    var body = document.body;
    if (!body || !body.classList.contains('sf-storefront')) {
        return;
    }

    function bindMenu(btnId, navId) {
        var btn = document.getElementById(btnId);
        var nav = document.getElementById(navId);
        if (!btn || !nav) {
            return;
        }

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var isModern = navId === 'md-mobile-nav';
            if (isModern) {
                nav.classList.toggle('hidden');
            } else {
                nav.classList.toggle('is-open');
            }
            var open = isModern ? !nav.classList.contains('hidden') : nav.classList.contains('is-open');
            body.classList.toggle('sf-nav-open', open);
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    bindMenu('hz-menu-btn', 'hz-mobile-nav');
    bindMenu('cl-menu-btn', 'cl-mobile-nav');
    bindMenu('md-menu-btn', 'md-mobile-nav');

    body.addEventListener('click', function (e) {
        if (!body.classList.contains('sf-nav-open')) {
            return;
        }
        if (e.target.closest('.hz-mobile-nav, .cl-mobile-nav, #md-mobile-nav, .hz-menu-toggle, .cl-menu-toggle, #md-menu-btn')) {
            return;
        }
        closeAll();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAll();
        }
    });

    function closeAll() {
        var hzNav = document.getElementById('hz-mobile-nav');
        var clNav = document.getElementById('cl-mobile-nav');
        var mdNav = document.getElementById('md-mobile-nav');
        if (hzNav) {
            hzNav.classList.remove('is-open');
        }
        if (clNav) {
            clNav.classList.remove('is-open');
        }
        if (mdNav) {
            mdNav.classList.add('hidden');
        }
        body.classList.remove('sf-nav-open');
        ['hz-menu-btn', 'cl-menu-btn', 'md-menu-btn'].forEach(function (id) {
            var b = document.getElementById(id);
            if (b) {
                b.setAttribute('aria-expanded', 'false');
            }
        });
    }
})();
