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
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="logo">Logo</label>
                    @if ($settings && $settings->logo)
                        <img src="{{ asset($settings->logo) }}" alt="Logo" class="tc-settings-preview-img">
                    @endif
                    <input type="file" name="logo" id="logo" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="main_phone">Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" id="main_phone" name="phone" class="form-control" placeholder="Enter phone number"
                        required value="{{ old('phone', $settings->phone ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
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
            <input class="form-check-input" type="checkbox" id="sameContactToggle">
            <label class="form-check-label" for="sameContactToggle">Use the same email and phone for Contact Us &amp; New User Register</label>
        </div>
        <div id="customContactFields">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="tc-field">
                        <label for="contactus_phone">Contact Us Phone</label>
                        <input type="tel" name="contactus_phone" id="contactus_phone" class="form-control"
                            placeholder="Enter contact phone" value="{{ old('contactus_phone') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tc-field">
                        <label for="contactus_email">Contact Us Email</label>
                        <input type="email" name="contactus_email" id="contactus_email" class="form-control"
                            placeholder="Enter contact email" value="{{ old('contactus_email') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tc-field">
                        <label for="newuser_phone">New User Request Phone</label>
                        <input type="tel" name="newuser_phone" id="newuser_phone" class="form-control"
                            placeholder="Enter registration phone" value="{{ old('newuser_phone') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tc-field">
                        <label for="newuser_email">New User Request Email</label>
                        <input type="email" name="newuser_email" id="newuser_email" class="form-control"
                            placeholder="Enter registration email" value="{{ old('newuser_email') }}">
                    </div>
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

    <div class="tc-settings-form-actions">
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </div>
</form>
@endsection

@section('setting_script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('sameContactToggle');
        const fields = document.getElementById('customContactFields');
        const mainPhone = document.getElementById('main_phone');
        const mainEmail = document.getElementById('main_email');
        const contactusPhone = document.getElementById('contactus_phone');
        const contactusEmail = document.getElementById('contactus_email');
        const newuserPhone = document.getElementById('newuser_phone');
        const newuserEmail = document.getElementById('newuser_email');

        function setRequiredFields(required) {
            contactusPhone.required = required;
            contactusEmail.required = required;
            newuserPhone.required = required;
            newuserEmail.required = required;
        }

        if (toggle.checked) {
            fields.style.display = 'none';
            setRequiredFields(false);
            contactusPhone.value = mainPhone.value;
            contactusEmail.value = mainEmail.value;
            newuserPhone.value = mainPhone.value;
            newuserEmail.value = mainEmail.value;
        }

        toggle.addEventListener('change', function () {
            if (this.checked) {
                fields.style.display = 'none';
                setRequiredFields(false);
                contactusPhone.value = mainPhone.value;
                contactusEmail.value = mainEmail.value;
                newuserPhone.value = mainPhone.value;
                newuserEmail.value = mainEmail.value;
            } else {
                fields.style.display = 'block';
                setRequiredFields(true);
                contactusPhone.value = '';
                contactusEmail.value = '';
                newuserPhone.value = '';
                newuserEmail.value = '';
            }
        });
    });
</script>
@endsection
