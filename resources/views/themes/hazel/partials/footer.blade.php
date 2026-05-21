@php
    $company = tenant('company_name') ?? tenant('name') ?? config('app.name');
    $year = now()->year;
@endphp
<footer class="hz-footer">
    <div class="hz-container">
        <div class="hz-footer__grid">
            <div>
                <strong>{{ $company }}</strong>
                @if (!empty($settings?->address))
                    <p class="mt-2 mb-0">{{ $settings->address }}</p>
                @endif
            </div>
            <div>
                <strong>Contact</strong>
                @if (!empty($settings?->phone))
                    <p class="mb-1 mt-2"><a href="tel:{{ preg_replace('/\D+/', '', $settings->phone) }}">{{ $settings->phone }}</a></p>
                @endif
                @if (!empty($settings?->email))
                    <p class="mb-0"><a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></p>
                @endif
            </div>
            <div>
                <strong>Follow</strong>
                <p class="mt-2 mb-0">
                    @if (!empty($settings?->facebook))<a href="{{ $settings->facebook }}" class="me-2" rel="noopener">Facebook</a>@endif
                    @if (!empty($settings?->instagram))<a href="{{ $settings->instagram }}" class="me-2" rel="noopener">Instagram</a>@endif
                    @if (!empty($settings?->youtube))<a href="{{ $settings->youtube }}" rel="noopener">YouTube</a>@endif
                </p>
            </div>
        </div>
        <div class="hz-footer__bottom">&copy; {{ $year }} {{ $company }}. All rights reserved.</div>
    </div>
</footer>
