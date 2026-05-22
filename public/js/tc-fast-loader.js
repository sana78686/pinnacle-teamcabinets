/**
 * Hides the global panel loader quickly; script.js skips its slow slideUp when this runs.
 */
(function ($) {
    'use strict';
    window.__tcLoaderFastHide = true;

    function hideLoader() {
        var $loader = $('.loader-wrapper');
        if (!$loader.length) {
            return;
        }
        $loader.stop(true, true).fadeOut(120, function () {
            $(this).remove();
        });
    }

    if ($) {
        $(hideLoader);
    } else {
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.querySelector('.loader-wrapper');
            if (el) {
                el.style.transition = 'opacity .12s ease';
                el.style.opacity = '0';
                setTimeout(function () {
                    el.remove();
                }, 130);
            }
        });
    }
})(window.jQuery);
