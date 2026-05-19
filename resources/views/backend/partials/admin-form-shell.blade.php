@props(['title', 'backUrl', 'backLabel' => 'Back to list'])

<div class="container-fluid admin-list-page">
    <div class="admin-list-toolbar">
        <h3 class="admin-list-title">{{ $title }}</h3>
        <div class="admin-list-actions">
            <a href="{{ $backUrl }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> {{ $backLabel }}
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger admin-list-alert">
            <strong>Please fix the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @session('error')
        <div class="alert alert-danger admin-list-alert" role="alert">{{ $value }}</div>
    @endsession

    <div class="card admin-list-card">
        <div class="card-body admin-list-card-body">
            {{ $slot }}
        </div>
    </div>
</div>
