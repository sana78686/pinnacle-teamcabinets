@if (app(\App\Services\CloudflareTurnstileService::class)->isEnabled())
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
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

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form').forEach(function (form) {
                if (!form.querySelector('.cf-turnstile')) {
                    return;
                }

                form.addEventListener('submit', function (e) {
                    var token = form.querySelector('[name="cf-turnstile-response"]');
                    if (!token || !token.value) {
                        e.preventDefault();
                        alert('Please wait for security verification to finish, then try again.');
                    }
                });
            });

            @if ($errors->has('cf-turnstile-response'))
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
    </script>
@endif
