@extends('layouts.tenant.settings')
@section('title', 'Edit '.$legalMeta['title'])

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_website_designing') }}">Website Designing</a></li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_legal_pages') }}">Legal pages</a></li>
    <li class="breadcrumb-item active">{{ $legalMeta['title'] }}</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.website-designing-nav')

<div class="tc-settings-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div>
        <h5 class="mb-1 tc-settings-form-title">{{ $legalMeta['title'] }}</h5>
        <p class="mb-0 text-muted tc-field-hint">Public URL: <code>/{{ $legalSlug }}</code></p>
    </div>
    <a href="{{ route('tenant_legal_pages') }}" class="btn btn-light btn-sm">Back to legal pages</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ route('tenant_legal_pages_update', $legalSlug) }}" method="POST" class="tc-settings-form">
    @csrf
    @method('PUT')

    @include('layouts.tenant.partials.settings-field', [
        'name' => 'title',
        'label' => 'Page title',
        'required' => true,
        'value' => old('title', $page->title),
    ])

    <div class="mb-3 tc-field">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="published" @selected(old('status', $page->status) === 'published')>Published</option>
            <option value="draft" @selected(old('status', $page->status) === 'draft')>Draft (hidden)</option>
        </select>
    </div>

    @include('layouts.tenant.partials.cms-rich-editor', [
        'editorId' => 'legal_page_editor',
        'name' => 'content',
        'label' => 'Page content',
        'value' => old('content', $page->content),
        'editorHeight' => 360,
    ])

    <div class="tc-settings-form-actions">
        <button type="submit" class="btn btn-primary">Save page</button>
        <a href="{{ route('cms.page', $legalSlug) }}" class="btn btn-light" target="_blank" rel="noopener">Preview on storefront</a>
    </div>
</form>
@endsection
