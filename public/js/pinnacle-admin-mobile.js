/**
 * Pinnacle super-admin (mega layout) — mobile sidebar overlay & nav cleanup.
 */
(function () {
    var MOBILE_MAX = 991;

    function isMobile() {
        return window.innerWidth <= MOBILE_MAX;
    }

    function closeSidebar() {
        var sidebar = document.querySelector('.iconsidebar-menu');
        if (!sidebar) {
            return;
        }
        sidebar.classList.add('iconbar-second-close');
        sidebar.classList.remove('iconbar-mainmenu-close');
        document.body.classList.remove('pn-admin-sidebar-open');
    }

    function openSidebar() {
        var sidebar = document.querySelector('.iconsidebar-menu');
        if (!sidebar) {
            return;
        }
        sidebar.classList.remove('iconbar-second-close');
        sidebar.classList.add('iconbar-mainmenu-close');
        document.body.classList.add('pn-admin-sidebar-open');
    }

    function bindSidebar() {
        var toggle = document.querySelector('.mobile-sidebar #sidebar-toggle');
        if (!toggle || toggle.dataset.pnBound === '1') {
            return;
        }
        toggle.dataset.pnBound = '1';

        toggle.addEventListener('click', function (e) {
            if (!isMobile()) {
                return;
            }
            e.preventDefault();
            var sidebar = document.querySelector('.iconsidebar-menu');
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
            var sidebar = document.querySelector('.iconsidebar-menu');
            if (!sidebar) {
                return;
            }
            if (sidebar.contains(e.target) || e.target.closest('.mobile-sidebar')) {
                return;
            }
            closeSidebar();
        });

        window.addEventListener('resize', function () {
            if (!isMobile()) {
                closeSidebar();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bindSidebar);
    } else {
        bindSidebar();
    }
})();
