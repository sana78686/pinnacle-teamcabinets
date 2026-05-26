@php
    $tcHeaderAlerts = $tcHeaderAlerts ?? [];
@endphp
@if (!empty($tcHeaderAlerts))
    <div class="tc-header-alerts" role="region" aria-label="Recent alerts">
        @foreach ($tcHeaderAlerts as $alert)
            <a href="{{ $alert['url'] }}" class="tc-header-alert tc-header-alert--{{ $alert['type'] }} tc-header-alert--blink">
                <span class="tc-header-alert__icon" aria-hidden="true">!</span>
                <span class="tc-header-alert__text">{{ $alert['message'] }}</span>
            </a>
        @endforeach
    </div>
@endif
