@php
    $hearAbout = config('tenant_storefront.hear_about_options', []);
    $bestContact = config('tenant_storefront.best_contact_options', []);
@endphp
<form action="{{ route('contact.send') }}" method="post" class="sf-contact-form" id="sf-contact-form">
    @csrf
    <input type="text" name="url" value="" tabindex="-1" autocomplete="off" class="sf-honeypot" aria-hidden="true">

    <div class="sf-contact-form__grid">
        <div class="sf-field">
            <label class="sf-label" for="sf-first-name">First Name <span class="sf-req">*</span></label>
            <input type="text" name="first_name" id="sf-first-name" class="sf-input" required value="{{ old('first_name') }}" placeholder="First Name">
        </div>
        <div class="sf-field">
            <label class="sf-label" for="sf-last-name">Last Name <span class="sf-req">*</span></label>
            <input type="text" name="last_name" id="sf-last-name" class="sf-input" required value="{{ old('last_name') }}" placeholder="Last Name">
        </div>
        <div class="sf-field">
            <label class="sf-label" for="sf-email">Email <span class="sf-req">*</span></label>
            <input type="email" name="from" id="sf-email" class="sf-input" required value="{{ old('from') }}" placeholder="email@example.com">
        </div>
        <div class="sf-field">
            <label class="sf-label" for="sf-phone">Phone Number <span class="sf-req">*</span></label>
            <input type="tel" name="phone" id="sf-phone" class="sf-input" required value="{{ old('phone') }}" placeholder="XXX-XXX-XXXX">
        </div>
    </div>

    <p class="sf-contact-form__hint">Tell us more about your space! Have any questions? Include any additional details about your project you would like to share.</p>

    <div class="sf-field">
        <label class="sf-label sf-label--sr" for="sf-message">Message</label>
        <textarea name="message" id="sf-message" class="sf-input sf-textarea" rows="6" required placeholder="Ceiling Height, Appliance Sizes, Project timeline and budget estimate are all very helpful.">{{ old('message') }}</textarea>
    </div>

    <div class="sf-contact-form__grid sf-contact-form__grid--2">
        <div class="sf-field">
            <label class="sf-label" for="sf-hear">How did you hear about us?</label>
            <select name="hear_about_us" id="sf-hear" class="sf-input sf-select">
                @foreach ($hearAbout as $value => $label)
                    <option value="{{ $value }}" @selected(old('hear_about_us') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="sf-field">
            <label class="sf-label" for="sf-best-contact">Best way to contact <span class="sf-req">*</span></label>
            <select name="best_contact_method" id="sf-best-contact" class="sf-input sf-select" required>
                @foreach ($bestContact as $value => $label)
                    <option value="{{ $value }}" @selected(old('best_contact_method') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <label class="sf-checkbox">
        <input type="checkbox" name="newsletter_subscribe" value="1" @checked(old('newsletter_subscribe'))>
        <span>Sign up for newsletter</span>
    </label>

    <div class="sf-field">
        @include('partials.cloudflare-turnstile', ['class' => 'sf-turnstile'])
    </div>

    <button type="submit" class="sf-btn sf-btn--submit">Send message</button>
</form>
