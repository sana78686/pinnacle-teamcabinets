/** Pinnacle marketing site — mobile nav + hero finish rotator. */
(function () {
    document.querySelectorAll('.pn-hero-rotator:not([data-static])').forEach(function (root) {
        var imgs = root.querySelectorAll('.pn-hero-rotator__img');
        if (imgs.length < 2) return;
        var ms = parseInt(root.getAttribute('data-interval'), 10) || 4000;
        var i = 0;
        setInterval(function () {
            imgs[i].classList.remove('is-active');
            i = (i + 1) % imgs.length;
            imgs[i].classList.add('is-active');
        }, ms);
    });
})();

(function () {
    var btn = document.getElementById('pn-menu-btn');
    var nav = document.getElementById('pn-mobile-nav');
    var header = document.querySelector('.pn-header');
    if (!btn || !nav) return;

    function setMenuOpen(open) {
        nav.classList.toggle('is-open', open);
        document.body.classList.toggle('pn-menu-open', open);
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    btn.addEventListener('click', function () {
        setMenuOpen(!nav.classList.contains('is-open'));
    });

    nav.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            setMenuOpen(false);
        });
    });

    document.addEventListener('click', function (e) {
        if (!nav.classList.contains('is-open')) return;
        if (nav.contains(e.target) || btn.contains(e.target)) return;
        setMenuOpen(false);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') setMenuOpen(false);
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) setMenuOpen(false);
    });
})();
