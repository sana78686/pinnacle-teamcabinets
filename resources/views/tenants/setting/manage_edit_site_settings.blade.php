@extends('layouts.tenant.settings')
@section('title', 'Edit Site Settings')

@section('breadcrumb-title')
    <h2>Edit <span>Site Settings</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Edit Site Settings</li>
@endsection

@section('setting_content')
<form class="tc-settings-form" action="{{ route('tenant_setting_home_list_edit') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <section class="tc-settings-section">
        <h3 class="tc-settings-section__title">Company</h3>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="logo">Logo</label>
                    @if ($settings && $settings->logo)
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" class="tc-settings-preview-img">
                    @endif
                    <input type="file" name="logo" id="logo" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="phone">Phone Number</label>
                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="Enter phone number"
                        required value="{{ old('phone', $settings->phone ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address"
                        required value="{{ old('email', $settings->email ?? '') }}">
                </div>
            </div>
        </div>
    </section>

    <section class="tc-settings-section">
        <h3 class="tc-settings-section__title">Social Links</h3>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="facebook">Facebook URL</label>
                    <input type="url" name="facebook" id="facebook" class="form-control"
                        placeholder="https://facebook.com/your-page"
                        value="{{ old('facebook', $settings->facebook ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="twitter">Twitter URL</label>
                    <input type="url" name="twitter" id="twitter" class="form-control"
                        placeholder="https://twitter.com/your-handle"
                        value="{{ old('twitter', $settings->twitter ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="tc-field">
                    <label for="youtube">YouTube URL</label>
                    <input type="url" name="youtube" id="youtube" class="form-control"
                        placeholder="https://youtube.com/your-channel"
                        value="{{ old('youtube', $settings->youtube ?? '') }}">
                </div>
            </div>
        </div>
    </section>

    <div class="tc-settings-form-actions">
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </div>
</form>
@endsection
