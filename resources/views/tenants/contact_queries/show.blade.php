@extends('layouts.tenant.settings')
@section('title', 'Contact message')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_contact_queries_index') }}">Contact inquiries</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.website-designing-nav')

<div class="tc-settings-toolbar d-flex flex-wrap justify-content-between gap-2 mb-3">
    <h5 class="mb-0 tc-settings-form-title">Contact message #{{ $query->id }}</h5>
    <a href="{{ route('tenant_contact_queries_index') }}" class="btn btn-light btn-sm">Back to list</a>
</div>

<div class="card tc-dash-card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Received</dt>
            <dd class="col-sm-9">{{ $query->created_at?->format('M j, Y g:i A') }}</dd>
            <dt class="col-sm-3">First name</dt>
            <dd class="col-sm-9">{{ $query->first_name ?: '—' }}</dd>
            <dt class="col-sm-3">Last name</dt>
            <dd class="col-sm-9">{{ $query->last_name ?: '—' }}</dd>
            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9"><a href="mailto:{{ $query->email }}">{{ $query->email }}</a></dd>
            <dt class="col-sm-3">Phone</dt>
            <dd class="col-sm-9">{{ $query->phone ?: '—' }}</dd>
            <dt class="col-sm-3">How they heard about us</dt>
            <dd class="col-sm-9">{{ $query->hear_about_us ? (config('tenant_storefront.hear_about_options')[$query->hear_about_us] ?? $query->hear_about_us) : '—' }}</dd>
            <dt class="col-sm-3">Best way to contact</dt>
            <dd class="col-sm-9">{{ $query->best_contact_method ? (config('tenant_storefront.best_contact_options')[$query->best_contact_method] ?? $query->best_contact_method) : '—' }}</dd>
            <dt class="col-sm-3">Newsletter</dt>
            <dd class="col-sm-9">{{ $query->newsletter_subscribe ? 'Yes' : 'No' }}</dd>
            <dt class="col-sm-3">Message</dt>
            <dd class="col-sm-9"><pre class="mb-0" style="white-space:pre-wrap;font-family:inherit;">{{ $query->message }}</pre></dd>
            @if ($query->attachment_path)
                <dt class="col-sm-3">Attachment</dt>
                <dd class="col-sm-9">
                    <a href="{{ tenant_static_asset($query->attachment_path) }}" target="_blank" rel="noopener">Download attachment</a>
                </dd>
            @endif
        </dl>
    </div>
</div>

<form method="post" action="{{ route('tenant_contact_queries_destroy', $query) }}" class="mt-3" onsubmit="return confirm('Delete this message?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger btn-sm">Delete message</button>
</form>
@endsection
