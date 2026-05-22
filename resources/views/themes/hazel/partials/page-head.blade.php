@php
    $title = $title ?? '';
    $lead = $lead ?? null;
@endphp
<header class="hz-page-head">
    <div class="hz-container">
        @if (!empty($title))
            <h1 class="hz-page-head__title">{{ $title }}</h1>
        @endif
        @if (!empty($lead))
            <p class="hz-page-head__lead">{{ $lead }}</p>
        @endif
    </div>
</header>
