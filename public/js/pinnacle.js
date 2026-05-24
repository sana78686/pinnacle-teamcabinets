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
