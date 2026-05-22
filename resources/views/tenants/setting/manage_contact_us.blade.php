@extends('layouts.tenant.settings')
@section('title', 'Contact page')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_website_designing') }}">Website Designing</a></li>
    <li class="breadcrumb-item active">Contact page</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.website-designing-nav')

<div class="tc-settings-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div>
        <h5 class="mb-1 tc-settings-form-title">Contact page</h5>
        <p class="mb-0 text-muted tc-field-hint">Sidebar title and map shown on your public contact page. Phone, email, and address come from Site Settings.</p>
    </div>
    <a href="{{ route('tenant_contact_queries_index') }}" class="btn btn-primary btn-sm">View inquiries</a>
</div>

@include('partial.message')

<form class="tc-settings-form" method="post" action="{{ route('tenant_contact_page_settings_store') }}">
    @csrf
    <section class="tc-settings-section">
        <div class="row g-3">
            <div class="col-12">
                <div class="tc-field">
                    <label for="contact_sidebar_title">Sidebar heading</label>
                    <input type="text" name="contact_sidebar_title" id="contact_sidebar_title" class="form-control"
                        placeholder="Need Assistance?"
                        value="{{ old('contact_sidebar_title', $settings->contact_sidebar_title ?? 'Need Assistance?') }}">
                </div>
            </div>
            <div class="col-12">
                <div class="tc-field">
                    <label for="map_embed_url">Google Maps embed</label>
                    <textarea name="map_embed_url" id="map_embed_url" class="form-control" rows="4"
                        placeholder="Paste iframe HTML from Google Maps → Share → Embed a map">{{ old('map_embed_url', $settings->map_embed_url ?? '') }}</textarea>
                    <small class="text-muted">Optional. Shown below the contact form on your storefront.</small>
                </div>
            </div>
        </div>
    </section>
    <div class="tc-settings-form-actions">
        <button type="submit" class="btn btn-primary">Save contact page</button>
    </div>
</form>
@endsection
