@extends('layouts.tenant.settings')
@section('title', !empty($isArticle) ? 'New Article' : 'Create CMS Page')

@section('breadcrumb-title')
    <h2>{{ !empty($isArticle) ? 'New' : 'Create' }} <span>{{ !empty($isArticle) ? 'Article' : 'Page' }}</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_website_designing') }}">Website Designing</a></li>
    @if (!empty($isArticle))
        <li class="breadcrumb-item"><a href="{{ route('tenant_storefront_blog') }}">Articles</a></li>
        <li class="breadcrumb-item active">New</li>
    @else
        <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">CMS Pages</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endif
@endsection

@section('setting_content')
@include('layouts.tenant.partials.website-designing-nav')

    <div class="tc-settings-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h5 class="mb-1 tc-settings-form-title">{{ !empty($isArticle) ? 'New article' : 'Create new page' }}</h5>
            <p class="mb-0 text-muted tc-field-hint">
                @if (!empty($isArticle))
                    This post will appear on your public blog.
                @else
                    Custom pages for your storefront (not blog posts).
                @endif
            </p>
        </div>
        <a href="{{ !empty($isArticle) ? route('tenant_storefront_blog') : route('pages.index') }}" class="btn btn-light btn-sm">Back</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pages.store') }}" method="POST" class="tc-settings-form">
        @csrf

        <div class="row">
            <div class="col-md-6">
                @include('layouts.tenant.partials.settings-field', [
                    'name' => 'title',
                    'label' => 'Page Title',
                    'required' => true,
                    'placeholder' => 'Enter page title',
                    'value' => old('title'),
                ])
            </div>
            <div class="col-md-6">
                @include('layouts.tenant.partials.settings-field', [
                    'name' => 'slug',
                    'label' => 'Slug (URL)',
                    'required' => true,
                    'placeholder' => 'about-us',
                    'value' => old('slug'),
                    'hint' => 'Example: about-us, contact, services',
                ])
            </div>
        </div>

        @if (!empty($isArticle) && isset($blogPage))
            <input type="hidden" name="is_article" value="1">
            <input type="hidden" name="parent_id" value="{{ $blogPage->id }}">
        @else
            <div class="mb-3 tc-field">
                <label for="parent_id" class="form-label">Parent Page (Optional)</label>
                <select name="parent_id" id="parent_id" class="form-select">
                    <option value="">-- None (top-level page) --</option>
                    @foreach ($parents as $id => $title)
                        <option value="{{ $id }}" {{ (string) old('parent_id') === (string) $id ? 'selected' : '' }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        @include('layouts.tenant.partials.cms-rich-editor', [
            'editorId' => 'editor',
            'name' => 'content',
            'label' => 'Page Content',
            'value' => old('content'),
            'editorHeight' => 420,
        ])

        <div class="row">
            <div class="col-md-4">
                @include('layouts.tenant.partials.settings-field', [
                    'name' => 'order_no',
                    'label' => 'Order Number',
                    'type' => 'number',
                    'value' => old('order_no', 0),
                    'placeholder' => 'Enter display order',
                ])
            </div>
            <div class="col-md-4">
                <div class="mb-3 tc-field">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="tc-settings-form-actions">
            <button type="submit" class="btn btn-primary">Save Page</button>
            <a href="{{ route('pages.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>
@endsection
