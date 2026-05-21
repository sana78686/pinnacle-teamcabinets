@extends('layouts.tenant.settings')
@section('title', 'Success / Error Page Content')

@section('breadcrumb-title')
    <h2>Manage <span>Success/Error Page Content</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Success / Error Content</li>
@endsection

@section('setting_content')
<div class="tc-settings-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <p class="mb-0 text-muted small">Edit messages shown on thank-you, error, and confirmation pop-ups (same as legacy Team Cabinets admin).</p>
    <a href="{{ url()->current() }}" class="btn btn-light btn-sm" title="Refresh">
        <i class="icofont icofont-refresh"></i> Refresh
    </a>
</div>

<div class="pt-0 card-body px-0">
    <div class="table-responsive table-sm">
        <table class="table table-striped table-bordered table-sm mb-0">
            <thead>
                <tr>
                    <th scope="col">Pages</th>
                    <th scope="col">Description</th>
                    <th scope="col" style="width: 120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td class="small text-muted">
                            {{ \Illuminate\Support\Str::limit(strip_tags($page->page_content ?? ''), 120) ?: '—' }}
                        </td>
                        <td>
                            <a href="{{ route('tenant_setting_manage_success_edit', $page->id) }}">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-muted">No pages configured yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
