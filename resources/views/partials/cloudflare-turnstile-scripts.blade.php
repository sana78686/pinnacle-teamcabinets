@if (app(\App\Services\CloudflareTurnstileService::class)->isEnabled())
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit" async defer></script>
    <script>
        window.turnstileReady = false;

        window.onTurnstileSuccess = function () {
            window.turnstileReady = true;
        };

        window.onTurnstileExpired = function () {
            window.turnstileReady = false;
        };

        window.onTurnstileError = function () {
            window.turnstileReady = false;
        };

        function mountTurnstileWidgets() {
            if (typeof turnstile === 'undefined') {
                window.setTimeout(mountTurnstileWidgets, 80);
                return;
            }

            document.querySelectorAll('.cf-turnstile').forEach(function (el) {
                if (el.getAttribute('data-turnstile-mounted') === '1') {
                    return;
                }

                var sitekey = el.getAttribute('data-sitekey');
                if (!sitekey) {
                    return;
                }

                try {
                    turnstile.render(el, {
                        sitekey: sitekey,
                        theme: el.getAttribute('data-theme') || 'light',
                        size: el.getAttribute('data-size') || 'normal',
                        callback: window.onTurnstileSuccess,
                        'expired-callback': window.onTurnstileExpired,
                        'error-callback': window.onTurnstileError,
                    });
                    el.setAttribute('data-turnstile-mounted', '1');
                } catch (err) {
                    console.warn('Turnstile render failed', err);
                }
            });
        }

        window.mountTurnstileWidgets = mountTurnstileWidgets;

        document.addEventListener('DOMContentLoaded', function () {
            mountTurnstileWidgets();

            document.querySelectorAll('form').forEach(function (form) {
                if (!form.querySelector('.cf-turnstile')) {
                    return;
                }

                form.addEventListener('submit', function (e) {
                    var token = form.querySelector('[name="cf-turnstile-response"]');
                    if (!token || !token.value) {
                        e.preventDefault();
                        alert('Please complete the security verification, then try again.');
                    }
                });
            });

            @if (isset($errors) && $errors->has('cf-turnstile-response'))
            var resetTurnstile = function () {
                if (typeof turnstile === 'undefined') {
                    return;
                }
                document.querySelectorAll('.cf-turnstile').forEach(function (el) {
                    try {
                        turnstile.reset(el);
                    } catch (err) {}
                });
                window.turnstileReady = false;
            };
            if (typeof turnstile !== 'undefined') {
                resetTurnstile();
            } else {
                window.addEventListener('load', resetTurnstile);
            }
            @endif
        });

        window.addEventListener('load', mountTurnstileWidgets);
    </script>
@endif
