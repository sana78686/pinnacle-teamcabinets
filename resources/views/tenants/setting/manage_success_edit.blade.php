@extends('layouts.tenant.settings')
@section('title', 'Edit Success / Error Content')

@section('breadcrumb-title')
    <h2>Edit <span>{{ $page->title }}</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_setting_manage_success_list') }}">Success / Error Content</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('setting_content')
<div class="tc-settings-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h5 class="mb-0 tc-settings-form-title">{{ $page->title }}</h5>
    <a href="{{ route('tenant_setting_manage_success_list') }}" class="btn btn-info btn-sm text-white">
        <i class="fa fa-arrow-left"></i> Back
    </a>
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

<form action="{{ route('tenant_setting_manage_success_update', $page->id) }}" method="POST" class="tc-settings-form">
    @csrf
    <div class="mb-3 tc-field">
        <label for="editor" class="form-label">Description <span class="text-danger">*</span></label>
        <textarea name="page_content" id="editor" class="form-control" rows="12">{{ old('page_content', $page->page_content) }}</textarea>
    </div>
    <div class="tc-settings-form-actions">
        <button type="submit" class="btn btn-success btn-sm">
            <i class="fa-solid fa-floppy-disk"></i> Save
        </button>
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
            }).catch(console.error);
        });
    </script>
@endsection
