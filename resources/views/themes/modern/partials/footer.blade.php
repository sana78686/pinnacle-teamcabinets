@php
    $year = now()->year;
    $phone = $settings?->contactus_phone ?: $settings?->phone;
    $email = $settings?->contactus_email ?: $settings?->email;
@endphp
<footer id="md-contact" class="border-t border-md-line bg-md-cream">
    <div class="mx-auto max-w-md-page px-4 py-16 lg:px-6">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-{{ ($sfLegalNav ?? collect())->isNotEmpty() ? '4' : '3' }}">
            <div>
                @if ($sfLogoUrl)
                    <img src="{{ $sfLogoUrl }}" alt="{{ $sfCompany }}" class="mb-4 h-10 w-auto">
                @else
                    <p class="text-xl font-bold">{{ $sfCompany }}</p>
                @endif
                @if (!empty($settings?->address))
                    <p class="mt-2 text-sm text-gray-600">{{ $settings->address }}</p>
                @endif
            </div>
            <div>
                <h3 class="mb-3 text-sm font-bold uppercase tracking-wider">Explore</h3>
                <ul class="space-y-2 text-sm">
                    @foreach ($sfFooterNav ?? [] as $link)
                        <li><a href="{{ $link['url'] }}" class="hover:text-md-gold">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            @if (($sfLegalNav ?? collect())->isNotEmpty())
                <div>
                    <h3 class="mb-3 text-sm font-bold uppercase tracking-wider">Legal</h3>
                    <ul class="space-y-2 text-sm">
                        @foreach ($sfLegalNav as $item)
                            <li><a href="{{ $item['url'] }}" class="hover:text-md-gold">{{ $item['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div>
                <h3 class="mb-3 text-sm font-bold uppercase tracking-wider">Contact</h3>
                @if ($sfShowContact)
                    <p class="mb-3">
                        <a href="{{ $sf->contactPageUrl() }}" class="inline-flex items-center gap-2 font-semibold text-md-gold hover:underline">
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i> Send a message
                        </a>
                    </p>
                @endif
                @if ($phone)
                    <p class="text-2xl font-bold text-md-ink"><a href="tel:{{ preg_replace('/\D+/', '', $phone) }}">{{ $phone }}</a></p>
                @endif
                @if ($email)
                    <p class="mt-2 text-sm"><a href="mailto:{{ $email }}" class="hover:text-md-gold">{{ $email }}</a></p>
                @endif
            </div>
        </div>
        <div class="mt-12 flex flex-col gap-4 border-t border-md-line pt-8 text-sm text-gray-600 md:flex-row md:items-center md:justify-between">
            @if ($sfLegalNav->isNotEmpty())
                <nav class="flex flex-wrap gap-4">
                    @foreach ($sfLegalNav as $item)
                        <a href="{{ $item['url'] }}" class="hover:text-md-ink">{{ $item['label'] }}</a>
                    @endforeach
                </nav>
            @endif
            <p>&copy; {{ $year }} {{ $sfCompany }}. All rights reserved.</p>
        </div>
    </div>
</footer>
