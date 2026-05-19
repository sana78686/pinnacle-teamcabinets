@props([
    'title',
    'createUrl' => null,
    'createLabel' => 'Create',
])

<div class="container-fluid admin-list-page">
    <div class="admin-list-toolbar">
        <h3 class="admin-list-title">{{ $title }}</h3>
        <div class="admin-list-actions">
            @isset($toolbar)
                {{ $toolbar }}
            @endisset
            @if ($createUrl)
                <a href="{{ $createUrl }}" class="btn admin-btn-create">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    {{ $createLabel }}
                </a>
            @endif
        </div>
    </div>

    @session('success')
        <div class="alert alert-success admin-list-alert" role="alert">{{ $value }}</div>
    @endsession

    <div class="card admin-list-card">
        <div class="card-body admin-list-card-body">
            {{ $slot }}
        </div>
    </div>
</div>
