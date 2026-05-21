@extends('layouts.tenant.settings')
@section('title', 'Success / Error Content')

@section('breadcrumb-title')
    <h2>{{ $page->title }}<span> Content</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_setting_manage_success_list') }}">Success / Error Content</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('setting_content')
<div class="tc-settings-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <p class="mb-0 text-muted small">Slug: <code>{{ $page->slug }}</code></p>
    <div class="d-flex gap-2">
        <a href="{{ route('tenant_setting_manage_success_edit', $page->id) }}" class="btn btn-primary btn-sm">Edit</a>
        <a href="{{ route('tenant_setting_manage_success_list') }}" class="btn btn-light btn-sm">Back to list</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        {!! $page->page_content ?: '<p class="text-muted mb-0">No content saved yet.</p>' !!}
    </div>
</div>
@endsection
