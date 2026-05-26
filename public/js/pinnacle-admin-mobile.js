/**
 * Pinnacle super-admin (mega layout) — mobile module sidebar & header menu.
 */
(function () {
    'use strict';

    var MOBILE_MAX = 991;

    function isMobile() {
        return window.innerWidth <= MOBILE_MAX;
    }

    function sidebarEl() {
        return document.getElementById('pn-admin-sidebar') || document.querySelector('.iconsidebar-menu');
    }

    function menuBtn() {
        return document.getElementById('sidebar-toggle');
    }

    function setMenuExpanded(open) {
        var btn = menuBtn();
        if (btn) {
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        }
    }

    function closeSidebar() {
        var sidebar = sidebarEl();
        if (!sidebar) {
            return;
        }
        sidebar.classList.add('iconbar-second-close');
        sidebar.classList.remove('iconbar-mainmenu-close');
        document.body.classList.remove('pn-admin-sidebar-open');
        setMenuExpanded(false);
    }

    function openSidebar() {
        var sidebar = sidebarEl();
        if (!sidebar) {
            return;
        }
        sidebar.classList.remove('iconbar-second-close');
        sidebar.classList.add('iconbar-mainmenu-close');
        document.body.classList.add('pn-admin-sidebar-open');
        setMenuExpanded(true);
    }

    function bindSidebar() {
        var toggle = menuBtn();
        if (!toggle || toggle.dataset.pnBound === '1') {
            return;
        }
        toggle.dataset.pnBound = '1';

        toggle.addEventListener('click', function (e) {
            if (!isMobile()) {
                return;
            }
            e.preventDefault();
            e.stopPropagation();
            var sidebar = sidebarEl();
            if (!sidebar) {
                return;
            }
            if (sidebar.classList.contains('iconbar-mainmenu-close')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        document.addEventListener('click', function (e) {
            if (!isMobile() || !document.body.classList.contains('pn-admin-sidebar-open')) {
                return;
            }
            var sidebar = sidebarEl();
            if (!sidebar) {
                return;
            }
            if (sidebar.contains(e.target) || e.target.closest('.pn-admin-menu-btn, #sidebar-toggle')) {
                return;
            }
            closeSidebar();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });

        window.addEventListener('resize', function () {
            applyViewportLayout();
        });
    }

    function applyViewportLayout() {
        var sidebar = sidebarEl();
        if (!sidebar) {
            return;
        }
        if (isMobile()) {
            closeSidebar();
        } else {
            sidebar.classList.remove('iconbar-second-close');
            if (!sidebar.classList.contains('iconbar-mainmenu-close')) {
                sidebar.classList.add('iconbar-mainmenu-close');
            }
            document.body.classList.remove('pn-admin-sidebar-open');
            setMenuExpanded(false);
        }
    }

    function init() {
        bindSidebar();
        applyViewportLayout();
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
