@php
    $tcHeaderAlerts = $tcHeaderAlerts ?? [];
@endphp
@if (!empty($tcHeaderAlerts))
    <li class="onhover-dropdown tc-header-alert-dot-li d-flex align-items-center">
        <button type="button" class="tc-header-alert-dot-trigger" aria-label="Recent alerts" aria-haspopup="true" aria-expanded="false">
            <span class="tc-header-alert-dot tc-header-alert-dot--blink" aria-hidden="true"></span>
            @if (count($tcHeaderAlerts) > 1)
                <span class="tc-header-alert-dot__count">{{ count($tcHeaderAlerts) }}</span>
            @endif
        </button>
        <ul class="onhover-show-div tc-header-dropdown tc-header-alert-dot-menu" role="menu">
            <li class="tc-header-dropdown__head p-2">
                <h5 class="mb-0">Alerts</h5>
                <span class="f-12 txt-muted">Last 24 hours</span>
            </li>
            @foreach ($tcHeaderAlerts as $alert)
                <li class="tc-header-dropdown__item">
                    <a href="{{ $alert['url'] }}" role="menuitem" class="tc-header-alert-dot-menu__link">
                        <span class="tc-header-alert-dot-menu__dot tc-header-alert-dot-menu__dot--{{ $alert['type'] }}" aria-hidden="true"></span>
                        <span>{{ $alert['message'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@endif
