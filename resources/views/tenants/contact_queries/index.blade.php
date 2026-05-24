@extends('layouts.tenant.settings')
@section('title', 'Contact inquiries')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_website_designing') }}">Website Designing</a></li>
    <li class="breadcrumb-item active">Contact inquiries</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.website-designing-nav')

<div class="tc-settings-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div>
        <h5 class="mb-1 tc-settings-form-title">Contact inquiries</h5>
        <p class="mb-0 text-muted tc-field-hint">Messages submitted from your storefront contact form.</p>
    </div>
    <a href="{{ route('tenant_contact_page_settings') }}" class="btn btn-light btn-sm">Contact page settings</a>
</div>

@include('partial.message')

@include('partials.tc-list-toolbar', [
    'listUrl' => route('tenant_contact_queries_index'),
    'perPage' => $perPage,
    'search' => $search,
])

<div class="table-responsive tc-admin-datatable">
    <table class="table table-striped table-bordered table-sm mb-0">
        <thead>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Best contact</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($queries as $item)
                <tr class="{{ tenant_admin_unviewed_row_class($item) }}">
                    <td class="text-nowrap">{{ $item->created_at?->format('M j, Y g:i A') }}</td>
                    <td>{{ $item->name ?: trim(($item->first_name ?? '').' '.($item->last_name ?? '')) ?: '—' }}</td>
                    <td><a href="mailto:{{ $item->email }}">{{ $item->email }}</a></td>
                    <td>{{ $item->phone ?: '—' }}</td>
                    <td>{{ $item->best_contact_method ? (config('tenant_storefront.best_contact_options')[$item->best_contact_method] ?? $item->best_contact_method) : '—' }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('tenant_contact_queries_show', $item) }}" class="tc-admin-datatable__edit">View</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No contact messages yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-2">{{ $queries->links() }}</div>
@endsection
