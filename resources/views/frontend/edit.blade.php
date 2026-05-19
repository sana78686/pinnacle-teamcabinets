@extends('layouts.tenant.settings')
@section('title', 'Edit CMS Page')

@section('breadcrumb-title')
    <h2>Edit <span>Page</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">CMS Pages</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('setting_content')
    <div class="tc-settings-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h5 class="mb-1 tc-settings-form-title">Edit Page</h5>
            <p class="mb-0 text-muted tc-field-hint">{{ $page->title }}</p>
        </div>
        <a href="{{ route('pages.index') }}" class="btn btn-light btn-sm">Back to list</a>
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

    <form action="{{ route('pages.update', $page->id) }}" method="POST" class="tc-settings-form">
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

        <div class="mb-3 tc-field">
            <label for="parent_id" class="form-label">Parent Page (Optional)</label>
            <select name="parent_id" id="parent_id" class="form-select">
                <option value="">-- None --</option>
                @foreach ($parents as $id => $title)
                    <option value="{{ $id }}" {{ old('parent_id', $page->parent_id) == $id ? 'selected' : '' }}>{{ $title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 tc-field">
            <label for="editor" class="form-label">Page Content</label>
            <textarea name="content" id="editor" class="form-control" rows="8">{{ old('content', $page->content) }}</textarea>
        </div>

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

@section('setting_script')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/46.0.0/ckeditor5.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/46.0.0/ckeditor5.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5-premium-features/46.0.0/ckeditor5-premium-features.css">
    <script src="https://cdn.ckeditor.com/ckeditor5-premium-features/46.0.0/ckeditor5-premium-features.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            const { ClassicEditor, Essentials, Bold, Italic, Font, Paragraph } = CKEDITOR;
            const { FormatPainter } = CKEDITOR_PREMIUM_FEATURES;

            ClassicEditor.create(document.querySelector('#editor'), {
                licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NjEwOTExOTksImp0aSI6IjJmOGFmZWRkLWRiNDAtNDRjOS05N2M3LWJjN2JmYzhhMmE1MyIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6IjFkM2IxYWZlIn0.yM6GkJEVB3i9LdhwsMQy6niiCkGqc1Rj8vyTOPISHxGp8VuejBsIFhacx75yhLcUpimX17_V0iKeCMy0RTpsAQ',
                plugins: [Essentials, Bold, Italic, Font, Paragraph, FormatPainter],
                toolbar: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|', 'formatPainter',
                ],
            }).then(function () {
                if (window.TenantFieldTips) {
                    window.TenantFieldTips.refresh(document.querySelector('.tc-settings-panel'));
                }
            }).catch(console.error);
        });
    </script>
@endsection
