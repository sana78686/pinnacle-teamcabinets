@php
    $phone = $settings?->contactus_phone ?: $settings?->phone;
    $email = $settings?->contactus_email ?: $settings?->email;
    $company = $sfCompany ?? tenant('company_name') ?? 'Team Cabinets';
    $contactUrl = $sfContactPage ? route('cms.page', $sfContactPage->slug) : route('cms.page', 'contact');
@endphp
<section class="sf-prefooter" aria-label="Partner with us and contact">
    <div class="sf-prefooter__split">
        <div class="sf-prefooter__promo">
            <div class="sf-prefooter__promo-text">
                <h2 class="sf-prefooter__promo-title">Ready to partner with {{ $company }}?</h2>
                <p class="sf-prefooter__promo-sub">Join dealers nationwide who trust us for quality, price, and delivery.</p>
            </div>
            <div class="sf-prefooter__promo-actions">
                <a href="{{ route('tenant_register') }}" class="sf-prefooter__promo-btn sf-prefooter__promo-btn--primary">Create your account</a>
                <a href="{{ route('tenant_login') }}" class="sf-prefooter__promo-btn sf-prefooter__promo-btn--ghost">Dealer login</a>
            </div>
        </div>
        <div class="sf-prefooter__call">
            <div class="sf-prefooter__call-inner">
                <div class="sf-prefooter__call-lead">
                    <span class="sf-prefooter__call-icon" aria-hidden="true"><i class="fa-solid fa-mobile-screen"></i></span>
                    <div class="sf-prefooter__call-body">
                        <strong class="sf-prefooter__call-label">Call us today.</strong>
                        @if ($phone)
                            <a href="tel:{{ preg_replace('/\D+/', '', $phone) }}" class="sf-prefooter__phone">{{ $phone }}</a>
                        @endif
                        <a href="{{ $contactUrl }}" class="sf-prefooter__contact-link">Contact {{ $company }}</a>
                        @if ($email)
                            <a href="mailto:{{ $email }}" class="sf-prefooter__email">{{ $email }}</a>
                        @endif
                    </div>
                </div>
                <aside class="sf-prefooter__hours" aria-label="Business hours">
                    <span>Mon – Thurs: 8am – 6pm ET</span>
                    <span>Fri: 8am – 5pm ET</span>
                    <span>Sat &amp; Sun: Closed</span>
                </aside>
            </div>
        </div>
    </div>
</section>
