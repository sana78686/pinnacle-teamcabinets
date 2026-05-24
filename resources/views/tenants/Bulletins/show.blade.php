@extends('layouts.tenant.master')
@section('title', 'Bulletin Details')

@section('breadcrumb-title')
    <h2>Bulletin <span>Details</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_bulletin_index') }}">Bulletins</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="{{ route('tenant_bulletin_edit', $bulletin->id) }}" class="btn btn-primary btn-sm">Edit</a>
        <a href="{{ route('tenant_bulletin_index') }}" class="btn btn-light btn-sm">Back to list</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card tc-bulletin-admin__card p-3">
                <h3 class="h5 mb-3">{{ $bulletin->bulletin_title }}</h3>
                <dl class="row mb-0 tc-bulletin-admin__meta">
                    <dt class="col-sm-4">Audience</dt>
                    <dd class="col-sm-8">
                        <span class="badge {{ $bulletin->user_option === 'every_one' ? 'bg-primary' : 'bg-secondary' }}">
                            {{ \App\Support\BulletinAudience::userOptionLabel($bulletin->user_option) }}
                        </span>
                    </dd>
                    @if ($bulletin->user_option === 'specific_user')
                        <dt class="col-sm-4">User type</dt>
                        <dd class="col-sm-8">{{ \App\Support\BulletinAudience::targetRoleLabel($bulletin->target_role) }}</dd>
                    @endif
                    <dt class="col-sm-4">Posted</dt>
                    <dd class="col-sm-8">{{ $bulletin->created_at?->format('F j, Y g:i A') ?? '—' }}</dd>
                    <dt class="col-sm-4">Description</dt>
                    <dd class="col-sm-8">{!! nl2br(e($bulletin->bulletin_description)) !!}</dd>
                </dl>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card tc-bulletin-admin__card p-3">
                <h4 class="h6 text-muted mb-3">Attachment</h4>
                @if ($bulletin->image && $bulletin->isImageAttachment())
                    <a href="{{ $bulletin->attachmentUrl() }}" target="_blank" rel="noopener">
                        <img src="{{ $bulletin->attachmentUrl() }}" alt="" class="img-fluid rounded tc-bulletin-admin__preview">
                    </a>
                @elseif ($bulletin->image)
                    <p class="mb-2"><a href="{{ $bulletin->attachmentUrl() }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">Open {{ strtoupper($bulletin->attachmentExtension()) }} file</a></p>
                    <p class="small text-muted mb-0">{{ $bulletin->image }}</p>
                @else
                    <p class="text-muted mb-0">No file attached.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
