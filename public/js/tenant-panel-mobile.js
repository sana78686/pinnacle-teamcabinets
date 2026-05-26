/**
 * Tenant panel — mobile / tablet navigation drawer (admin top nav + role icon sidebar)
 */
(function () {
    'use strict';

    var menuBtn = document.getElementById('tc-pn-menu-btn');
    if (!menuBtn) {
        return;
    }

    var adminNavRoot = document.querySelector('.tc-tenant-nav');
    var roleNavRoot = document.querySelector('.tc-role-panel .iconsidebar-menu.tc-compact-icon-sidebar')
        || document.querySelector('.tc-role-panel .iconsidebar-menu');

    var navMode = adminNavRoot ? 'admin' : (roleNavRoot ? 'role' : null);
    if (!navMode) {
        return;
    }

    var navRoot = navMode === 'admin' ? adminNavRoot : roleNavRoot;
    var navPanel = navMode === 'admin' ? adminNavRoot.querySelector('#main-nav') : roleNavRoot;

    if (!navPanel) {
        return;
    }

    menuBtn.setAttribute('aria-controls', navMode === 'admin' ? 'main-nav' : 'tc-role-sidebar-nav');

    var overlay = document.createElement('div');
    overlay.className = 'tc-mobile-nav-overlay';
    overlay.setAttribute('aria-hidden', 'true');
    document.body.appendChild(overlay);

    function isMobile() {
        return window.matchMedia('(max-width: 1199.98px)').matches;
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
        if (navMode === 'admin') {
            navPanel.style.left = '';
            navPanel.style.transform = '';
        }
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
        e.stopPropagation();
        toggleNav();
    });

    overlay.addEventListener('click', closeNav);

    document.querySelectorAll('.tc-tenant-nav .mobile-back, .tc-role-nav-mobile-back button').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            closeNav();
        });
    });

    var linkSelector = navMode === 'admin'
        ? '.tc-tenant-nav #main-menu a[href]'
        : '.tc-role-panel .iconsidebar-menu a.bar-icons[href]';

    navRoot.querySelectorAll(linkSelector).forEach(function (link) {
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

    if (navMode === 'admin') {
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
    }
})();
