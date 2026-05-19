@extends('pinnacle.layouts.app')

@section('title', 'Find your tenant')

@section('content')
<section class="pn-page-hero">
    <div class="pn-container">
        <h1>Find your tenant</h1>
        <p>Enter the email address used when your cabinets business was registered on Pinnacle.</p>
    </div>
</section>

<section class="pn-section">
    <div class="pn-container">
        <div class="pn-find-tenant-card">
            @if (!empty($found) && $found === true)
                <div class="pn-alert pn-alert--success">
                    <strong>We found your tenant!</strong>
                    <p style="margin:0.5rem 0 0">Your account is registered under <strong>{{ $tenant->company_name ?? $tenant->name }}</strong>.</p>
                </div>
                <p class="pn-find-tenant-card__lead">Use the link below to open your tenant website and dealer portal:</p>
                <a href="{{ $tenantUrl }}" class="pn-btn pn-btn--primary pn-btn--block" target="_blank" rel="noopener">
                    Go to your tenant →
                </a>
                <p class="pn-hint" style="text-align:center;margin-top:1rem">{{ $tenantUrl }}</p>
                <p class="pn-auth-card__foot" style="margin-top:1.5rem">
                    <a href="{{ route('pinnacle.find-tenant') }}">Look up a different email</a>
                </p>
            @elseif (isset($found) && $found === false)
                <div class="pn-alert pn-alert--error">
                    No tenant was found for <strong>{{ $email }}</strong>. Please check the email or
                    <a href="{{ route('registeration') }}" style="color:inherit;text-decoration:underline">register a new tenant</a>.
                </div>
                <p class="pn-auth-card__foot"><a href="{{ route('pinnacle.find-tenant') }}">Try again</a></p>
            @else
                <h2 class="pn-auth-card__title">Enter owner email</h2>
                <p class="pn-auth-card__sub">This must match the email on your tenant owner account (the address used at registration).</p>

                <form method="POST" action="{{ route('pinnacle.find-tenant.lookup') }}">
                    @csrf
                    <div class="pn-field">
                        @include('pinnacle.partials.form-label', [
                            'for' => 'email',
                            'label' => 'Email address',
                            'required' => true,
                            'tip' => 'The same email you used when creating your Team Cabinets / Pinnacle tenant.',
                        ])
                        <input type="email" name="email" id="email" class="pn-input @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="owner@yourcompany.com" required autofocus>
                        @error('email')<p class="pn-field-error">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="pn-btn pn-btn--primary pn-btn--block" style="margin-top:1rem">Find my tenant</button>
                </form>
                <p class="pn-auth-card__foot">New to Pinnacle? <a href="{{ route('registeration') }}">Create a tenant account</a></p>
            @endif
        </div>
    </div>
</section>
@endsection
