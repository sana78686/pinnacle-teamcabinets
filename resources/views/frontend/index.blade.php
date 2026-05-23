@extends('layouts.tenant.settings')
@section('title', 'CMS Pages')

@section('breadcrumb-title')
    <h2>CMS <span>Pages</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_website_designing') }}">Website Designing</a></li>
    <li class="breadcrumb-item active">CMS Pages</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.website-designing-nav')
@include('partial.message')

    <div class="tc-settings-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h5 class="mb-1 tc-settings-form-title">Pages</h5>
            <p class="mb-0 text-muted tc-field-hint">Custom pages and system pages (About, Blog, Contact). Use <strong>Articles</strong> for blog posts. Avoid reserved slugs like <code>about</code>, <code>blog</code>, <code>contact</code> when creating new pages.</p>
        </div>
        <a href="{{ route('pages.create') }}" class="btn btn-primary btn-sm">
            <i data-feather="plus" class="tc-btn-icon"></i> Create Page
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm mb-0 tc-settings-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Parent page</th>
                    <th scope="col">Status</th>
                    <th scope="col">Order</th>
                    <th scope="col" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pages as $page)
                    <tr>
                        <td>{{ $page->id }}</td>
                        <td>
                            {{ $page->title }}
                            @if ($page->isReservedSystemPage())
                                <span class="badge badge-info ms-1">System</span>
                            @elseif ($page->parent_id)
                                <span class="badge badge-light border ms-1">Child</span>
                            @endif
                        </td>
                        <td><code>{{ $page->slug }}</code></td>
                        <td>{{ $page->parent?->title ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $page->status === 'published' ? 'badge-success' : 'badge-secondary' }}">
                                {{ ucfirst($page->status) }}
                            </span>
                        </td>
                        <td>{{ $page->order_no }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ $page->panelEditUrl() }}" class="btn btn-warning btn-sm">Edit</a>
                            @unless ($page->isReservedSystemPage())
                                <form method="POST" action="{{ route('pages.destroy', $page->id) }}" class="d-inline"
                                    onsubmit="return confirm('Delete this page?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No pages yet.
                            <a href="{{ route('pages.create') }}">Create your first page</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('partials.tenant-pagination', ['paginator' => $pages])
@endsection
