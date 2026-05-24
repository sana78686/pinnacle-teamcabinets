(function () {
    'use strict';
    var btn = document.getElementById('sf-back-top-btn');
    var wrap = document.getElementById('sf-back-top');
    if (!btn || !wrap) return;

    function toggle() {
        var show = window.scrollY > 400;
        wrap.hidden = !show;
        wrap.setAttribute('aria-hidden', show ? 'false' : 'true');
    }

    window.addEventListener('scroll', toggle, { passive: true });
    toggle();

    btn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();
