@php
    $turnstile = app(\App\Services\CloudflareTurnstileService::class);
@endphp
@if ($turnstile->isEnabled())
    <div class="cf-turnstile-wrap {{ $class ?? '' }}">
        <div
            class="cf-turnstile"
            data-sitekey="{{ $turnstile->siteKey() }}"
            data-theme="{{ config('turnstile.theme', 'light') }}"
            data-size="{{ config('turnstile.size', 'normal') }}"
            data-callback="onTurnstileSuccess"
            data-expired-callback="onTurnstileExpired"
            data-error-callback="onTurnstileError"
        ></div>
        @error('cf-turnstile-response')
            <p class="cf-turnstile-error">{{ $message }}</p>
        @enderror
    </div>
@endif
