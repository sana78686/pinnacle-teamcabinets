@extends('pinnacle.layouts.auth')

@section('title', 'Register your cabinets business — Pinnacle')

@section('content')
@php
    $appDomain = tenant_base_domain();
    $trialDays = config('pinnacle.trial_days', 14);
@endphp
<div class="pn-container pn-auth-register">
    <div class="pn-auth-register__row">
        <div class="pn-auth-register__form pn-auth-card">
            <h2 class="pn-auth-card__title">Create your tenant account</h2>
            <p class="pn-auth-card__sub">Subdomain is generated from your company name.</p>

            @if (session('success'))
                <div class="pn-alert pn-alert--success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="pn-alert pn-alert--error">{{ session('error') }}</div>
            @endif
            @if ($errors->has('error'))
                <div class="pn-alert pn-alert--error">{{ $errors->first('error') }}</div>
            @endif

            <div id="pn-progress" class="pn-alert pn-alert--info" style="display:none">Creating your tenant — please wait…</div>

            <form method="POST" action="{{ route('pinnacle_tenant_register') }}" id="tenant-form" novalidate>
                @csrf
                <input type="hidden" name="country_id" value="233">

                <div class="pn-form-grid pn-form-grid--2 pn-form-grid--register">
                    <div class="pn-field pn-field--full">
                        @include('pinnacle.partials.form-label', [
                            'for' => 'company_name',
                            'label' => 'Company name',
                            'required' => true,
                            'tip' => 'Your business name. We use this to generate your tenant subdomain.',
                        ])
                        <input type="text" name="company_name" id="company_name" class="pn-input @error('company_name') is-invalid @enderror"
                            value="{{ old('company_name') }}" placeholder="e.g. Acme Cabinets" required autofocus>
                        <p class="pn-subdomain-preview" id="subdomain-preview" aria-live="polite">
                            Your site: <strong id="subdomain-text">your-company.{{ $appDomain }}</strong>
                        </p>
                        @error('company_name')<p class="pn-field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pn-field">
                        @include('pinnacle.partials.form-label', ['for' => 'username', 'label' => 'Username', 'required' => true, 'tip' => 'Used to sign in to your tenant admin panel.'])
                        <input type="text" name="username" id="username" class="pn-input @error('username') is-invalid @enderror"
                            value="{{ old('username') }}" placeholder="johndoe" required>
                        @error('username')<p class="pn-field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pn-field">
                        @include('pinnacle.partials.form-label', ['for' => 'name', 'label' => 'Full name', 'required' => true, 'tip' => 'Primary account holder name.'])
                        <input type="text" name="name" id="name" class="pn-input @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="John Smith" required>
                        @error('name')<p class="pn-field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pn-field">
                        @include('pinnacle.partials.form-label', ['for' => 'phone', 'label' => 'Phone', 'tip' => 'Business contact number for your account.'])
                        <input type="text" name="phone" id="phone" class="pn-input @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}" placeholder="(555) 000-0000">
                        @error('phone')<p class="pn-field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pn-field">
                        @include('pinnacle.partials.form-label', ['for' => 'email', 'label' => 'Email', 'required' => true, 'tip' => 'Used for login and account notifications.'])
                        <input type="email" name="email" id="email" class="pn-input @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="you@company.com" required autocomplete="email">
                        @error('email')<p class="pn-field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pn-field">
                        @include('pinnacle.partials.form-label', ['for' => 'password', 'label' => 'Password', 'required' => true, 'tip' => 'Minimum 6 characters.'])
                        <input type="password" name="password" id="password" class="pn-input @error('password') is-invalid @enderror"
                            placeholder="••••••••" required autocomplete="new-password">
                        @error('password')<p class="pn-field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pn-field">
                        @include('pinnacle.partials.form-label', ['for' => 'password_confirmation', 'label' => 'Confirm password', 'required' => true, 'tip' => 'Re-enter your password.'])
                        <input type="password" name="password_confirmation" id="password_confirmation" class="pn-input @error('password_confirmation') is-invalid @enderror"
                            placeholder="••••••••" required autocomplete="new-password">
                        @error('password_confirmation')<p class="pn-field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pn-field">
                        @include('pinnacle.partials.form-label', ['for' => 'state_id', 'label' => 'State', 'tip' => 'Select your business state.'])
                        <select name="state_id" id="state_id" class="pn-select @error('state_id') is-invalid @enderror">
                            <option value="">Select state</option>
                        </select>
                        @error('state_id')<p class="pn-field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pn-field">
                        @include('pinnacle.partials.form-label', ['for' => 'city_name', 'label' => 'City', 'tip' => 'City where your business is located.'])
                        <input type="text" name="city_name" id="city_name" class="pn-input @error('city_name') is-invalid @enderror"
                            value="{{ old('city_name') }}" placeholder="City">
                        @error('city_name')<p class="pn-field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pn-field">
                        @include('pinnacle.partials.form-label', ['for' => 'zip_code', 'label' => 'Zip code', 'tip' => 'Postal or ZIP code.'])
                        <input type="text" name="zip_code" id="zip_code" class="pn-input @error('zip_code') is-invalid @enderror"
                            value="{{ old('zip_code') }}" placeholder="00000">
                        @error('zip_code')<p class="pn-field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="pn-field pn-field--full">
                        @include('pinnacle.partials.form-label', ['for' => 'address', 'label' => 'Address', 'tip' => 'Street address for your business.'])
                        <input type="text" name="address" id="address" class="pn-input @error('address') is-invalid @enderror"
                            value="{{ old('address') }}" placeholder="Street address">
                        @error('address')<p class="pn-field-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="pn-check pn-check--compact">
                    <input type="checkbox" name="accept_terms" id="accept_terms" value="1" {{ old('accept_terms') ? 'checked' : '' }} required>
                    <label for="accept_terms">
                        I agree to the
                        <a href="{{ route('pinnacle.terms') }}" target="_blank" rel="noopener">Terms of Service</a>,
                        <a href="{{ route('pinnacle.subscription-terms') }}" target="_blank" rel="noopener">Subscription Terms</a>,
                        and <a href="{{ route('pinnacle.privacy') }}" target="_blank" rel="noopener">Privacy Policy</a>.
                    </label>
                </div>

                <div class="pn-field pn-field--full">
                    @include('partials.cloudflare-turnstile', ['class' => 'cf-turnstile-wrap--register'])
                </div>
                <button type="submit" class="pn-btn pn-btn--primary pn-btn--block" id="submit-btn">Create account</button>
            </form>

            <p class="pn-auth-card__foot">
                Already have an account? <a href="{{ route('auth_login') }}">Admin login</a>
            </p>
        </div>

        <aside class="pn-auth-register__info pn-auth-info-card" aria-label="Trial benefits">
            <p class="pn-auth-info-card__badge">{{ $trialDays }}-day free trial</p>
            <h2 class="pn-auth-info-card__title">Everything you need to sell cabinets online</h2>
            <p>Get a branded website and management panel for your cabinet distribution business.</p>
            <ul class="pn-auth-info-card__list">
                <li>Public dealer website &amp; catalog</li>
                <li>Orders, quotes &amp; stock checks</li>
                <li>Dealer &amp; affiliate accounts</li>
                <li>QuickBooks integration</li>
            </ul>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var appDomain = @json($appDomain);
    var company = document.getElementById('company_name');
    var subText = document.getElementById('subdomain-text');
    function slugify(s) {
        return s.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '') || 'your-company';
    }
    function updateSub() {
        subText.textContent = slugify(company.value) + '.' + appDomain;
    }
    company.addEventListener('input', updateSub);
    updateSub();

    var form = document.getElementById('tenant-form');
    var progress = document.getElementById('pn-progress');
    var btn = document.getElementById('submit-btn');
    form.addEventListener('submit', function (e) {
        var token = form.querySelector('[name="cf-turnstile-response"]');
        if (token && !token.value) {
            e.preventDefault();
            alert('Please complete the security verification, then try again.');
            if (typeof window.mountTurnstileWidgets === 'function') {
                window.mountTurnstileWidgets();
            }
            return;
        }
        progress.style.display = 'block';
        btn.disabled = true;
        btn.textContent = 'Creating account…';
    });

    var oldState = @json(old('state_id'));
    fetch('/get-states/233')
        .then(function (r) { return r.json(); })
        .then(function (states) {
            var sel = document.getElementById('state_id');
            states.forEach(function (s) {
                var o = document.createElement('option');
                o.value = s.id;
                o.textContent = s.name.charAt(0).toUpperCase() + s.name.slice(1);
                if (String(s.id) === String(oldState)) o.selected = true;
                sel.appendChild(o);
            });
        });
    if (typeof window.mountTurnstileWidgets === 'function') {
        window.mountTurnstileWidgets();
    }
})();
</script>
@endpush
