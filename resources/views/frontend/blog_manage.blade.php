@extends('layouts.tenant.settings')
@section('title', 'Articles')

@section('breadcrumb-title')
    <h2>Blog <span>posts</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_website_designing') }}">Website Designing</a></li>
    <li class="breadcrumb-item active">Articles</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.website-designing-nav')

    <div class="tc-settings-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h5 class="mb-1 tc-settings-form-title">Articles</h5>
            <p class="mb-0 text-muted tc-field-hint">Edit the articles landing page and publish posts shown on your storefront blog.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('pages.edit', $blogPage->id) }}" class="btn btn-light btn-sm">Edit blog page</a>
            <a href="{{ route('pages.create', ['parent' => 'blog']) }}" class="btn btn-primary btn-sm">
                <i data-feather="plus" class="tc-btn-icon"></i> New post
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm mb-0 tc-settings-table">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                    <th scope="col">Published</th>
                    <th scope="col" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td><code>{{ $post->slug }}</code></td>
                        <td>
                            <span class="badge {{ $post->status === 'published' ? 'badge-success' : 'badge-secondary' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td>{{ $post->created_at?->format('M j, Y') ?? '—' }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('cms.page', $post->slug) }}" class="btn btn-light btn-sm" target="_blank" rel="noopener">View</a>
                            <a href="{{ route('pages.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No blog posts yet.
                            <a href="{{ route('pages.create', ['parent' => 'blog']) }}">Create your first post</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
