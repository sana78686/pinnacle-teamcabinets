@extends('layouts.tenant.settings')
@section('title', !empty($isArticle) ? 'Edit Article' : 'Edit CMS Page')

@section('breadcrumb-title')
    <h2>Edit <span>{{ !empty($isArticle) ? 'Article' : 'Page' }}</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_website_designing') }}">Website Designing</a></li>
    @if (!empty($isArticle))
        <li class="breadcrumb-item"><a href="{{ route('tenant_storefront_blog') }}">Articles</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @else
        <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">CMS Pages</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endif
@endsection

@section('setting_content')
@include('layouts.tenant.partials.website-designing-nav')

    <div class="tc-settings-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h5 class="mb-1 tc-settings-form-title">{{ !empty($isArticle) ? 'Edit article' : 'Edit page' }}</h5>
            <p class="mb-0 text-muted tc-field-hint">{{ $page->title }}</p>
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

    <form action="{{ route('pages.update', $page->id) }}" method="POST" class="tc-settings-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                @include('layouts.tenant.partials.settings-field', [
                    'name' => 'title',
                    'label' => 'Page Title',
                    'required' => true,
                    'placeholder' => 'Enter page title',
                    'value' => old('title', $page->title),
                ])
            </div>
            <div class="col-md-6">
                @include('layouts.tenant.partials.settings-field', [
                    'name' => 'slug',
                    'label' => 'Slug (URL)',
                    'required' => true,
                    'placeholder' => 'about-us',
                    'value' => old('slug', $page->slug),
                    'hint' => 'Example: about-us, contact, services',
                ])
            </div>
        </div>

        @if (!empty($isArticle) && !empty($blogPage))
            <input type="hidden" name="parent_id" value="{{ $blogPage->id }}">
        @else
            <div class="mb-3 tc-field">
                <label for="parent_id" class="form-label">Parent Page (Optional)</label>
                <select name="parent_id" id="parent_id" class="form-select">
                    <option value="">-- None --</option>
                    @foreach ($parents as $id => $title)
                        <option value="{{ $id }}" {{ old('parent_id', $page->parent_id) == $id ? 'selected' : '' }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        @include('layouts.tenant.partials.cms-rich-editor', [
            'editorId' => 'editor',
            'name' => 'content',
            'label' => 'Page Content',
            'value' => old('content', $page->content),
            'editorHeight' => 420,
        ])

        <section class="tc-settings-section mb-4">
            <h3 class="tc-settings-section__title">SEO &amp; social sharing</h3>
            <div class="row g-3">
                <div class="col-md-6">
                    @include('layouts.tenant.partials.settings-field', [
                        'name' => 'meta_title',
                        'label' => 'Meta title',
                        'placeholder' => 'Page title for search engines',
                        'value' => old('meta_title', $page->meta_title),
                    ])
                </div>
                <div class="col-md-6">
                    @include('layouts.tenant.partials.settings-field', [
                        'name' => 'meta_keywords',
                        'label' => 'Meta keywords',
                        'placeholder' => 'keyword1, keyword2',
                        'value' => old('meta_keywords', $page->meta_keywords),
                    ])
                </div>
                <div class="col-12">
                    <div class="tc-field">
                        <label for="meta_description" class="form-label">Meta description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control" rows="2"
                            placeholder="Short summary for Google and social previews">{{ old('meta_description', $page->meta_description) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    @include('layouts.tenant.partials.image-upload-field', [
                        'name' => 'og_image',
                        'label' => 'Open Graph image (optional)',
                        'currentPath' => $page->og_image,
                    ])
                </div>
            </div>
        </section>

        <div class="row">
            <div class="col-md-4">
                @include('layouts.tenant.partials.settings-field', [
                    'name' => 'order_no',
                    'label' => 'Order Number',
                    'type' => 'number',
                    'value' => old('order_no', $page->order_no),
                    'placeholder' => 'Enter display order',
                ])
            </div>
            <div class="col-md-4">
                <div class="mb-3 tc-field">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="draft" {{ old('status', $page->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $page->status) == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="tc-settings-form-actions">
            <button type="submit" class="btn btn-primary">Update Page</button>
            <a href="{{ route('pages.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>
@endsection
