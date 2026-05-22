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
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9">{{ $query->name ?: '—' }}</dd>
            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9"><a href="mailto:{{ $query->email }}">{{ $query->email }}</a></dd>
            <dt class="col-sm-3">Subject</dt>
            <dd class="col-sm-9">{{ $query->subject ?: '—' }}</dd>
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
