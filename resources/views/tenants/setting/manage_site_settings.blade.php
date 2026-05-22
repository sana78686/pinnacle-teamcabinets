@extends('layouts.tenant.settings')
@section('title', 'Site Settings')

@section('breadcrumb-title')
    <h2>Site <span>Settings</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Site Settings</li>
@endsection

@section('setting_content')
<form class="tc-settings-form" action="{{ route('tenant_site_settings_store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <section class="tc-settings-section">
        <h3 class="tc-settings-section__title">Company</h3>
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <div class="tc-field">
                    <label for="logo">Logo</label>
                    @if ($settings && $settings->logo)
                        <img src="{{ tenant_static_asset($settings->logo) }}" alt="Logo" class="tc-settings-preview-img">
                    @endif
                    <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="tc-field">
                    <label for="favicon">Favicon</label>
                    @if ($settings && $settings->favicon)
                        <img src="{{ tenant_static_asset($settings->favicon) }}" alt="Favicon" class="tc-settings-preview-img" style="max-width:48px;">
                    @endif
                    <input type="file" name="favicon" id="favicon" class="form-control" accept="image/*">
                    <small class="text-muted">Shown in browser tab on your public site (32×32 or 64×64 PNG recommended).</small>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="tc-field">
                    <label for="main_phone">Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" id="main_phone" name="phone" class="form-control" placeholder="Enter phone number"
                        required value="{{ old('phone', $settings->phone ?? '') }}">
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="tc-field">
                    <label for="main_email">Email <span class="text-danger">*</span></label>
                    <input type="email" id="main_email" name="email" class="form-control" placeholder="Enter email address"
                        required value="{{ old('email', $settings->email ?? '') }}">
                </div>
            </div>
        </div>
    </section>

    <section class="tc-settings-section">
        <h3 class="tc-settings-section__title">Contact & Registration</h3>
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" id="sameContactToggle" name="use_same_contact" value="1"
                {{ !empty($sameContact) ? 'checked' : '' }}>
            <label class="form-check-label" for="sameContactToggle">Use the same email and phone for Contact Us &amp; New User Register</label>
        </div>
        <div id="customContactFields">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="tc-field">
                        <label for="contactus_phone">Contact Us Phone</label>
                        <input type="tel" name="contactus_phone" id="contactus_phone" class="form-control"
                            placeholder="Enter contact phone" value="{{ old('contactus_phone', $settings->contactus_phone ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tc-field">
                        <label for="contactus_email">Contact Us Email</label>
                        <input type="email" name="contactus_email" id="contactus_email" class="form-control"
                            placeholder="Enter contact email" value="{{ old('contactus_email', $settings->contactus_email ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tc-field">
                        <label for="newuser_phone">New User Request Phone</label>
                        <input type="tel" name="newuser_phone" id="newuser_phone" class="form-control"
                            placeholder="Enter registration phone" value="{{ old('newuser_phone', $settings->newuser_phone ?? '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tc-field">
                        <label for="newuser_email">New User Request Email</label>
                        <input type="email" name="newuser_email" id="newuser_email" class="form-control"
                            placeholder="Enter registration email" value="{{ old('newuser_email', $settings->newuser_email ?? '') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="tc-settings-section">
        <h3 class="tc-settings-section__title">Public site SEO (default meta tags)</h3>
        <p class="text-muted small mb-3">Used on the homepage and as fallbacks when a page has no custom meta. Open Graph image is used for social sharing.</p>
        <div class="row g-3">
            <div class="col-12">
                <div class="tc-field">
                    <label for="site_meta_title">Default meta title</label>
                    <input type="text" name="site_meta_title" id="site_meta_title" class="form-control"
                        placeholder="Your Company — Wholesale RTA Cabinets"
                        value="{{ old('site_meta_title', $settings->site_meta_title ?? '') }}">
                </div>
            </div>
            <div class="col-12">
                <div class="tc-field">
                    <label for="site_meta_description">Default meta description</label>
                    <textarea name="site_meta_description" id="site_meta_description" class="form-control" rows="2"
                        placeholder="Short description for search engines">{{ old('site_meta_description', $settings->site_meta_description ?? '') }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tc-field">
                    <label for="site_meta_keywords">Meta keywords</label>
                    <input type="text" name="site_meta_keywords" id="site_meta_keywords" class="form-control"
                        placeholder="RTA cabinets, wholesale, kitchen"
                        value="{{ old('site_meta_keywords', $settings->site_meta_keywords ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="tc-field">
                    <label for="og_image">Open Graph image</label>
                    @if ($settings && $settings->og_image)
                        <img src="{{ tenant_static_asset($settings->og_image) }}" alt="OG" class="tc-settings-preview-img">
                    @endif
                    <input type="file" name="og_image" id="og_image" class="form-control" accept="image/*">
                </div>
            </div>
        </div>
    </section>

    <section class="tc-settings-section">
        <h3 class="tc-settings-section__title">Address &amp; Social</h3>
        <div class="row g-3">
            <div class="col-12">
                <div class="tc-field">
                    <label for="address">Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" id="address" class="form-control" placeholder="Enter business address"
                        value="{{ old('address', $settings->address ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="tc-field">
                    <label for="facebook">Facebook URL</label>
                    <input type="url" name="facebook" id="facebook" class="form-control"
                        placeholder="https://facebook.com/your-page"
                        value="{{ old('facebook', $settings->facebook ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="tc-field">
                    <label for="twitter">Twitter URL</label>
                    <input type="url" name="twitter" id="twitter" class="form-control"
                        placeholder="https://twitter.com/your-handle"
                        value="{{ old('twitter', $settings->twitter ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="tc-field">
                    <label for="youtube">YouTube URL</label>
                    <input type="url" name="youtube" id="youtube" class="form-control"
                        placeholder="https://youtube.com/your-channel"
                        value="{{ old('youtube', $settings->youtube ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="tc-field">
                    <label for="instagram">Instagram URL</label>
                    <input type="url" name="instagram" id="instagram" class="form-control"
                        placeholder="https://instagram.com/your-profile"
                        value="{{ old('instagram', $settings->instagram ?? '') }}">
                </div>
            </div>
        </div>
    </section>

    <section class="tc-settings-section">
        <h3 class="tc-settings-section__title">Storefront brand color</h3>
        <p class="text-muted small mb-3">Applies to your public site header, footer, and primary buttons. Saved as CSS on your server — not loaded from the database on each page view.</p>
        @php
            $brandColor = old('storefront_brand_color', $storefrontBrandColor ?? '#1a4a7a');
        @endphp
        <div class="row g-3 align-items-end">
            <div class="col-md-6 col-lg-4">
                <div class="tc-field">
                    <label for="storefront_brand_color">Brand color</label>
                    <div class="d-flex gap-2 align-items-center flex-wrap">
                        <input type="hidden" name="storefront_brand_color" id="storefront_brand_color" value="{{ $brandColor }}">
                        <input type="color" id="storefront_brand_color_picker"
                            class="form-control form-control-color tc-brand-picker"
                            value="{{ $brandColor }}" title="Pick brand color">
                        <input type="text" id="storefront_brand_color_hex" class="form-control" style="max-width:8rem;"
                            pattern="^#[0-9A-Fa-f]{6}$" maxlength="7" value="{{ $brandColor }}" aria-label="Hex color">
                    </div>
                    @error('storefront_brand_color')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-lg-8">
                <div class="tc-brand-preview" id="tcBrandPreview" aria-hidden="true">
                    <div class="tc-brand-preview__chip" data-part="header">Header</div>
                    <div class="tc-brand-preview__chip" data-part="button">Primary button</div>
                    <div class="tc-brand-preview__chip" data-part="footer">Footer</div>
                </div>
            </div>
        </div>
    </section>

    <div class="tc-settings-form-actions">
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </div>
</form>
@endsection

@section('setting_script')
<style>
    .tc-brand-picker { width: 3.25rem; height: 2.75rem; padding: 0.2rem; cursor: pointer; }
    .tc-brand-preview { display: flex; flex-wrap: wrap; gap: 0.75rem; }
    .tc-brand-preview__chip {
        padding: 0.65rem 1.1rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #fff;
        min-width: 7rem;
        text-align: center;
    }
    .tc-brand-preview__chip[data-part="button"] { color: #fff; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const picker = document.getElementById('storefront_brand_color_picker');
        const hexInput = document.getElementById('storefront_brand_color_hex');
        const hiddenColor = document.getElementById('storefront_brand_color');
        const preview = document.getElementById('tcBrandPreview');
        const form = document.querySelector('.tc-settings-form');

        function normalizeHex(value) {
            let v = (value || '').trim();
            if (!v.startsWith('#')) {
                v = '#' + v;
            }
            if (/^#[0-9a-fA-F]{6}$/.test(v)) {
                return v.toLowerCase();
            }
            return null;
        }

        function darken(hex, amount) {
            const n = parseInt(hex.slice(1), 16);
            let r = (n >> 16) & 255, g = (n >> 8) & 255, b = n & 255;
            const f = 1 - amount;
            r = Math.round(r * f); g = Math.round(g * f); b = Math.round(b * f);
            return '#' + [r, g, b].map(function (c) { return c.toString(16).padStart(2, '0'); }).join('');
        }

        function applyBrandPreview(hex) {
            if (!preview || !hex) {
                return;
            }
            const navy = darken(hex, 0.42);
            preview.querySelector('[data-part="header"]').style.background = navy;
            preview.querySelector('[data-part="footer"]').style.background = 'linear-gradient(180deg, ' + darken(hex, 0.5) + ' 0%, ' + navy + ' 100%)';
            preview.querySelector('[data-part="button"]').style.background = hex;
            if (picker) {
                picker.value = hex;
            }
            if (hexInput) {
                hexInput.value = hex;
            }
            if (hiddenColor) {
                hiddenColor.value = hex;
            }
        }

        function syncFromPicker() {
            const hex = normalizeHex(picker ? picker.value : '');
            if (hex) {
                applyBrandPreview(hex);
            }
        }

        if (picker) {
            picker.addEventListener('input', syncFromPicker);
        }
        if (hexInput) {
            hexInput.addEventListener('input', function () {
                const hex = normalizeHex(hexInput.value);
                if (hex) {
                    applyBrandPreview(hex);
                }
            });
            hexInput.addEventListener('blur', function () {
                const hex = normalizeHex(hexInput.value);
                if (hex) {
                    applyBrandPreview(hex);
                }
            });
        }

        syncFromPicker();

        if (form) {
            form.addEventListener('submit', function () {
                const hex = normalizeHex(hexInput && hexInput.value ? hexInput.value : (picker ? picker.value : ''));
                if (hex) {
                    applyBrandPreview(hex);
                }
            });
        }

        const toggle = document.getElementById('sameContactToggle');
        const fields = document.getElementById('customContactFields');
        const mainPhone = document.getElementById('main_phone');
        const mainEmail = document.getElementById('main_email');
        const contactusPhone = document.getElementById('contactus_phone');
        const contactusEmail = document.getElementById('contactus_email');
        const newuserPhone = document.getElementById('newuser_phone');
        const newuserEmail = document.getElementById('newuser_email');

        function syncContactFromMain() {
            contactusPhone.value = mainPhone.value;
            contactusEmail.value = mainEmail.value;
            newuserPhone.value = mainPhone.value;
            newuserEmail.value = mainEmail.value;
        }

        function setRequiredFields(required) {
            contactusPhone.required = required;
            contactusEmail.required = required;
            newuserPhone.required = required;
            newuserEmail.required = required;
        }

        function applyToggleState() {
            if (toggle.checked) {
                fields.style.display = 'none';
                setRequiredFields(false);
                syncContactFromMain();
            } else {
                fields.style.display = 'block';
                setRequiredFields(false);
            }
        }

        if (!toggle || !fields) {
            return;
        }

        applyToggleState();

        toggle.addEventListener('change', applyToggleState);

        mainPhone.addEventListener('input', function () {
            if (toggle.checked) {
                syncContactFromMain();
            }
        });
        mainEmail.addEventListener('input', function () {
            if (toggle.checked) {
                syncContactFromMain();
            }
        });

        if (form) {
            form.addEventListener('submit', function () {
                if (toggle.checked) {
                    syncContactFromMain();
                }
            });
        }
    });
</script>
@endsection
