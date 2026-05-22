/**
 * Tenant panel — mobile navigation drawer + overlay
 */
(function () {
    'use strict';

    var menuBtn = document.getElementById('tc-pn-menu-btn');
    var navRoot = document.querySelector('.tc-tenant-nav');
    var mainNav = document.querySelector('.tc-tenant-nav #main-nav');
    if (!menuBtn || !navRoot || !mainNav) {
        return;
    }

    var overlay = document.createElement('div');
    overlay.className = 'tc-mobile-nav-overlay';
    overlay.setAttribute('aria-hidden', 'true');
    document.body.appendChild(overlay);

    function isMobile() {
        return window.matchMedia('(max-width: 991.98px)').matches;
    }

    function openNav() {
        if (!isMobile()) {
            return;
        }
        navRoot.classList.add('is-open');
        overlay.classList.add('is-visible');
        document.body.classList.add('tc-nav-open');
        menuBtn.setAttribute('aria-expanded', 'true');
        overlay.setAttribute('aria-hidden', 'false');
    }

    function closeNav() {
        navRoot.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        document.body.classList.remove('tc-nav-open');
        menuBtn.setAttribute('aria-expanded', 'false');
        overlay.setAttribute('aria-hidden', 'true');
        mainNav.style.left = '';
        mainNav.style.transform = '';
    }

    function toggleNav() {
        if (navRoot.classList.contains('is-open')) {
            closeNav();
        } else {
            openNav();
        }
    }

    menuBtn.addEventListener('click', function (e) {
        e.preventDefault();
        toggleNav();
    });

    overlay.addEventListener('click', closeNav);

    document.querySelectorAll('.tc-tenant-nav .mobile-back').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            closeNav();
        });
    });

    navRoot.querySelectorAll('#main-menu a[href]').forEach(function (link) {
        var href = link.getAttribute('href');
        if (href && href !== '#' && href.indexOf('javascript:') !== 0) {
            link.addEventListener('click', function () {
                if (isMobile()) {
                    closeNav();
                }
            });
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && navRoot.classList.contains('is-open')) {
            closeNav();
        }
    });

    window.addEventListener('resize', function () {
        if (!isMobile()) {
            closeNav();
        }
    });

    /* Submenu toggle on touch devices (parent items with # href) */
    navRoot.querySelectorAll('#main-menu > li.tc-nav-has-children > a').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            if (!isMobile()) {
                return;
            }
            var href = anchor.getAttribute('href');
            if (href === '#' || href === '' || href === null) {
                e.preventDefault();
                var li = anchor.closest('li');
                if (li) {
                    li.classList.toggle('sm-open');
                }
            }
        });
    });
})();
