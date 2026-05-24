@php
    $phone = $settings?->contactus_phone ?: $settings?->phone;
    $company = $sfCompany ?? tenant('company_name') ?? 'Us';
    $contactUrl = $sfContactPage ? route('cms.page', $sfContactPage->slug) : route('cms.page', 'contact');
@endphp
<section class="sf-prefooter" aria-label="Contact and newsletter">
    <div class="sf-prefooter__inner">
        <div class="sf-prefooter__promo">
            <div class="sf-prefooter__promo-text">
                <strong>Sign up for sales &amp; promotions today!</strong>
                <span>It's the next best thing to signing up yesterday.</span>
            </div>
            <a href="{{ route('tenant_register') }}" class="sf-prefooter__promo-btn">Sign up</a>
        </div>
        <div class="sf-prefooter__call">
            <span class="sf-prefooter__call-icon" aria-hidden="true"><i class="fa-solid fa-mobile-screen"></i></span>
            <div class="sf-prefooter__call-body">
                <strong>Call us today.</strong>
                @if ($phone)
                    <a href="tel:{{ preg_replace('/\D+/', '', $phone) }}" class="sf-prefooter__phone">{{ $phone }}</a>
                @else
                    <a href="{{ $contactUrl }}" class="sf-prefooter__phone">Contact {{ $company }}</a>
                @endif
            </div>
            <div class="sf-prefooter__hours">
                <span>Mon – Thurs: 8am – 6pm ET</span>
                <span>Fri: 8am – 5pm ET</span>
                <span>Sat &amp; Sun: Closed</span>
            </div>
        </div>
    </div>
</section>
