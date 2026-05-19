@extends('pinnacle.layouts.app')

@section('title', 'Contact us')

@section('content')
<section class="pn-page-hero">
    <div class="pn-container">
        <h1>Contact us</h1>
        <p>Questions about Team Cabinets, your tenant, dealers, or getting started on Pinnacle.</p>
    </div>
</section>

<section class="pn-section pn-section--white">
    <div class="pn-container">
        <div class="pn-contact-layout">
            <div class="pn-contact-form-wrap">
                <h2 class="pn-contact-form-wrap__title">Send us a message</h2>

                @if (session('contact_success'))
                    <div class="pn-alert pn-alert--success">{{ session('contact_success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="pn-alert pn-alert--error">
                        <ul style="margin:0;padding-left:1.25rem">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('pinnacle.contact.send') }}" class="pn-contact-form" id="contact_form">
                    @csrf
                    <input type="text" name="url" value="" tabindex="-1" autocomplete="off" class="pn-honeypot" aria-hidden="true">

                    <div class="pn-form-grid pn-form-grid--2">
                        <div class="pn-field">
                            @include('pinnacle.partials.form-label', ['for' => 'user_name', 'label' => 'Your name', 'required' => true, 'tip' => 'Full name so we know who to reply to.'])
                            <input type="text" name="user_name" id="user_name" class="pn-input @error('user_name') is-invalid @enderror"
                                value="{{ old('user_name') }}" placeholder="Your name" required>
                            @error('user_name')<p class="pn-field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="pn-field">
                            @include('pinnacle.partials.form-label', ['for' => 'user_email', 'label' => 'Your email', 'required' => true, 'tip' => 'We will reply to this address.'])
                            <input type="email" name="user_email" id="user_email" class="pn-input @error('user_email') is-invalid @enderror"
                                value="{{ old('user_email') }}" placeholder="you@company.com" required>
                            @error('user_email')<p class="pn-field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="pn-field">
                            @include('pinnacle.partials.form-label', ['for' => 'user_phone', 'label' => 'Phone', 'tip' => 'Optional — include if you prefer a call back.'])
                            <input type="text" name="user_phone" id="user_phone" class="pn-input @error('user_phone') is-invalid @enderror"
                                value="{{ old('user_phone') }}" placeholder="(555) 000-0000">
                            @error('user_phone')<p class="pn-field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="pn-field">
                            @include('pinnacle.partials.form-label', ['for' => 'inquiry_type', 'label' => 'Inquiry type', 'required' => true, 'tip' => 'Helps us route your message to the right team.'])
                            <select name="inquiry_type" id="inquiry_type" class="pn-select @error('inquiry_type') is-invalid @enderror" required>
                                <option value="">Select type</option>
                                <option value="general" @selected(old('inquiry_type') === 'general')>General inquiry</option>
                                <option value="sales" @selected(old('inquiry_type') === 'sales')>Sales / new tenant</option>
                                <option value="support" @selected(old('inquiry_type') === 'support')>Technical support</option>
                                <option value="dealer" @selected(old('inquiry_type') === 'dealer')>Dealer / affiliate question</option>
                            </select>
                            @error('inquiry_type')<p class="pn-field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="pn-field pn-field--full">
                            @include('pinnacle.partials.form-label', ['for' => 'user_query', 'label' => 'Your message', 'required' => true, 'tip' => 'Describe your question — orders, catalog, tenant setup, etc.'])
                            <textarea name="user_query" id="user_query" class="pn-textarea @error('user_query') is-invalid @enderror"
                                placeholder="How can we help you?" maxlength="2000" required>{{ old('user_query') }}</textarea>
                            @error('user_query')<p class="pn-field-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <button type="submit" class="pn-btn pn-btn--primary">Submit message</button>
                </form>
            </div>

            <aside class="pn-contact-side">
                <h3>Get in touch</h3>
                <ul class="pn-contact-list">
                    <li><strong>Phone</strong><span>{{ $pinnacle['contact']['phone'] }}</span></li>
                    <li><strong>Email</strong><span><a href="mailto:{{ $pinnacle['support_email'] }}">{{ $pinnacle['support_email'] }}</a></span></li>
                    <li><strong>Address</strong><span>{{ $pinnacle['contact']['address'] }}</span></li>
                    <li><strong>Hours</strong><span>{{ $pinnacle['contact']['hours'] }}</span></li>
                </ul>
                <p class="pn-contact-side__note">Already registered? <a href="{{ route('pinnacle.find-tenant') }}">Find your tenant site</a> with your owner email.</p>

                <div class="pn-map-wrap">
                    <iframe
                        src="{{ $pinnacle['contact']['map_embed'] }}"
                        width="100%" height="280" style="border:0;border-radius:12px" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Pinnacle office location map"></iframe>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
