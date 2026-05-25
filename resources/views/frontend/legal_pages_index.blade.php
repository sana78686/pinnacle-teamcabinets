@extends('layouts.tenant.settings')
@section('title', 'Legal pages')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_website_designing') }}">Website Designing</a></li>
    <li class="breadcrumb-item active">Legal pages</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.website-designing-nav')

<div class="tc-settings-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div>
        <h5 class="mb-1 tc-settings-form-title">Legal &amp; policy pages</h5>
        <p class="mb-0 text-muted tc-field-hint">Pages appear on the storefront only when <strong>Published</strong> and they contain real content (not the default placeholder). Terms and privacy also show in the header when live.</p>
    </div>
</div>

@include('partial.message')

<div class="table-responsive">
    <table class="table table-striped table-bordered table-sm mb-0 tc-settings-table">
        <thead>
            <tr>
                <th scope="col">Page</th>
                <th scope="col">URL</th>
                <th scope="col">Header</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pages as $row)
                <tr>
                    <td>{{ $row['title'] }}</td>
                    <td><code>/{{ $row['slug'] }}</code></td>
                    <td>{{ $row['in_header'] ? 'Yes' : 'Footer only' }}</td>
                    <td>
                        @if ($row['published'] && $row['has_content'])
                            <span class="badge badge-success">Live on storefront</span>
                        @elseif ($row['published'])
                            <span class="badge badge-warning">Published — add content</span>
                        @else
                            <span class="badge badge-secondary">Draft</span>
                        @endif
                    </td>
                    <td class="text-end text-nowrap">
                        <a href="{{ $row['storefront_url'] }}" class="btn btn-light btn-sm" target="_blank" rel="noopener">View</a>
                        <a href="{{ route('tenant_legal_pages_edit', $row['slug']) }}" class="btn btn-primary btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
