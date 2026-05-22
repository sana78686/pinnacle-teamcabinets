@php
    $year = now()->year;
    $phone = $settings?->contactus_phone ?: $settings?->phone;
    $email = $settings?->contactus_email ?: $settings?->email;
    $socials = array_filter([
        ['url' => $settings?->facebook, 'icon' => 'fa-brands fa-facebook-f', 'label' => 'Facebook'],
        ['url' => $settings?->instagram, 'icon' => 'fa-brands fa-instagram', 'label' => 'Instagram'],
        ['url' => $settings?->youtube, 'icon' => 'fa-brands fa-youtube', 'label' => 'YouTube'],
        ['url' => $settings?->twitter, 'icon' => 'fa-brands fa-x-twitter', 'label' => 'X'],
    ], fn ($s) => ! empty($s['url']));
@endphp
<footer class="hz-footer">
    <div class="hz-container">
        <div class="hz-footer__top">
            <div class="hz-footer__brand">
                @if ($sfLogoUrl)
                    <a href="{{ route('cms.page') }}" class="hz-footer__logo-link">
                        <img src="{{ $sfLogoUrl }}" alt="{{ $sfCompany }}" class="hz-footer__logo">
                    </a>
                @else
                    <a href="{{ route('cms.page') }}" class="hz-footer__brand-name">{{ $sfCompany }}</a>
                @endif
                @if (!empty($settings?->address))
                    <p class="hz-footer__address">{{ $settings->address }}</p>
                @endif
            </div>

            <div class="hz-footer__col">
                <h3 class="hz-footer__heading">Explore</h3>
                <ul class="hz-footer__links">
                    @foreach ($sfFooterNav ?? [] as $link)
                        <li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
                    <li><a href="{{ route('cms.page') }}#hz-faq">FAQs</a></li>
                </ul>
            </div>

            <div class="hz-footer__col">
                <h3 class="hz-footer__heading">Get in touch</h3>
                <ul class="hz-footer__links hz-footer__links--contact">
                    @if ($phone)
                        <li><a href="tel:{{ preg_replace('/\D+/', '', $phone) }}"><i class="fa-solid fa-phone" aria-hidden="true"></i> {{ $phone }}</a></li>
                    @endif
                    @if ($email)
                        <li><a href="mailto:{{ $email }}"><i class="fa-solid fa-envelope" aria-hidden="true"></i> {{ $email }}</a></li>
                    @endif
                </ul>
                @if (count($socials))
                    <div class="hz-footer__social" aria-label="Social media">
                        @foreach ($socials as $social)
                            <a href="{{ $social['url'] }}" class="hz-footer__social-btn" rel="noopener noreferrer" target="_blank" aria-label="{{ $social['label'] }}">
                                <i class="{{ $social['icon'] }}" aria-hidden="true"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="hz-footer__bar">
            @if ($sfLegalNav->isNotEmpty())
                <nav class="hz-footer__legal" aria-label="Legal">
                    @foreach ($sfLegalNav as $item)
                        <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                    @endforeach
                </nav>
            @endif
            <p class="hz-footer__copy">&copy; {{ $year }} {{ $sfCompany }}. All rights reserved.</p>
        </div>
    </div>
</footer>
