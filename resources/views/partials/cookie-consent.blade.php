@php
    $cookieStorageKey = $cookieStorageKey ?? 'tc_cookie_consent';
    $cookiePolicyUrl = $cookiePolicyUrl ?? null;
    $cookieVariant = $cookieVariant ?? 'storefront';
    $cookieScript = ($cookieVariant === 'pinnacle') ? asset('js/cookie-consent.js') : tenant_static_asset('js/cookie-consent.js');
@endphp
<div id="tc-cookie-consent" class="tc-cookie-consent tc-cookie-consent--{{ $cookieVariant }}" hidden role="dialog" aria-labelledby="tc-cookie-title" aria-describedby="tc-cookie-desc" aria-live="polite">
    <div class="tc-cookie-consent__panel">
        <div class="tc-cookie-consent__icon" aria-hidden="true">
            <i class="fa-solid fa-cookie-bite"></i>
        </div>
        <div class="tc-cookie-consent__body">
            <p id="tc-cookie-title" class="tc-cookie-consent__title">Cookies on this site</p>
            <p id="tc-cookie-desc" class="tc-cookie-consent__text">
                We use essential cookies to run the storefront and optional cookies to remember your preferences.
                @if ($cookiePolicyUrl)
                    Read our <a href="{{ $cookiePolicyUrl }}" class="tc-cookie-consent__link">cookie policy</a>.
                @endif
            </p>
        </div>
        <div class="tc-cookie-consent__actions">
            <button type="button" class="tc-cookie-consent__btn tc-cookie-consent__btn--primary" id="tc-cookie-accept">Accept all</button>
        </div>
        <button type="button" class="tc-cookie-consent__close" id="tc-cookie-dismiss" aria-label="Dismiss notice">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
    </div>
</div>
<script>
    window.TC_COOKIE_CONSENT = @json(['storageKey' => $cookieStorageKey]);
</script>
<script src="{{ $cookieScript }}?v=3"></script>
