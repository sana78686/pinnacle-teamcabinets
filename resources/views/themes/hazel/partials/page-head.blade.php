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
            <div class="hz-page-head__lead hz-page-body">{!! $lead !!}</div>
        @endif
    </div>
</header>
