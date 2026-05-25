(function () {
    'use strict';

    var cfg = window.TC_MODERN_HOME || {};
    var interval = parseInt(cfg.intervalMs, 10) || 2000;

    function autoScrollStrip(strip) {
        if (!strip) return;
        var step = function () {
            var imgs = strip.querySelectorAll('img');
            if (imgs.length < 2) return;
            var itemWidth = imgs[0].offsetWidth + 12;
            var maxScroll = strip.scrollWidth - strip.clientWidth;
            if (maxScroll <= 0) return;
            var next = strip.scrollLeft + itemWidth;
            strip.scrollTo({ left: next >= maxScroll - 2 ? 0 : next, behavior: 'smooth' });
        };
        setInterval(step, interval);
    }

    function autoScrollGallery(track) {
        if (!track) return;
        var step = function () {
            var slides = track.querySelectorAll('a');
            if (slides.length < 2) return;
            var slideWidth = slides[0].offsetWidth + 16;
            var maxScroll = track.scrollWidth - track.clientWidth;
            if (maxScroll <= 0) return;
            var next = track.scrollLeft + slideWidth;
            track.scrollTo({ left: next >= maxScroll - 2 ? 0 : next, behavior: 'smooth' });
        };
        setInterval(step, interval);
    }

    document.querySelectorAll('[data-md-showcase-strip]').forEach(autoScrollStrip);
    autoScrollGallery(document.getElementById('md-gallery-track'));
})();
