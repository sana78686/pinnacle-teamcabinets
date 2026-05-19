/** Pinnacle marketing site — mobile nav only (tenants use Bootstrap elsewhere). */
(function () {
    var btn = document.getElementById('pn-menu-btn');
    var nav = document.getElementById('pn-mobile-nav');
    if (!btn || !nav) return;
    btn.addEventListener('click', function () {
        nav.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', nav.classList.contains('is-open'));
    });
    nav.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            nav.classList.remove('is-open');
            btn.setAttribute('aria-expanded', 'false');
        });
    });
})();
