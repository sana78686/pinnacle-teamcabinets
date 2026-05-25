@php
    $cookieStorageKey = $cookieStorageKey ?? 'tc_cookie_consent';
    $cookiePolicyUrl = $cookiePolicyUrl ?? null;
    $cookieVariant = $cookieVariant ?? 'storefront';
    $cookieScript = ($cookieVariant === 'pinnacle') ? asset('js/cookie-consent.js') : tenant_static_asset('js/cookie-consent.js');
@endphp
<div id="tc-cookie-consent" class="tc-cookie-consent tc-cookie-consent--{{ $cookieVariant }}" hidden role="dialog" aria-live="polite" aria-label="Cookie notice">
    <div class="tc-cookie-consent__inner">
        <p class="tc-cookie-consent__text">
            We use cookies to remember your preferences, keep you signed in when you choose, and improve your experience.
            @if ($cookiePolicyUrl)
                <a href="{{ $cookiePolicyUrl }}" class="tc-cookie-consent__link">Cookie policy</a>
            @endif
        </p>
        <button type="button" class="tc-cookie-consent__btn" id="tc-cookie-accept">Accept</button>
    </div>
</div>
<script>
    window.TC_COOKIE_CONSENT = @json(['storageKey' => $cookieStorageKey]);
</script>
<script src="{{ $cookieScript }}?v=1"></script>
