@if(!empty($onboardingSteps))
@php
    $compact = $compact ?? false;
    $onboardingPct = $onboardingPct ?? 0;
    $sortedSteps = collect($onboardingSteps)->sortBy('order');
@endphp

@if ($compact)
<div class="card tc-dash-card tc-dash-setup h-100">
    <div class="card-header tc-dash-setup__head">
        <div>
            <h5 class="mb-0 tc-dash-card__title">Store setup</h5>
            <p class="tc-dash-card__sub mb-0">Complete configuration before dealers order.</p>
        </div>
        <span class="badge rounded-pill tc-onboard-badge">{{ $onboardingProgress ?? '' }}</span>
    </div>
    <div class="card-body">
        <div class="tc-dash-setup__progress" role="progressbar" aria-valuenow="{{ $onboardingPct }}" aria-valuemin="0" aria-valuemax="100">
            <div class="tc-dash-setup__progress-bar" style="width: {{ $onboardingPct }}%"></div>
        </div>
        <ul class="tc-dash-setup__list">
            @foreach ($sortedSteps as $step)
            <li class="tc-dash-setup__item {{ $step['done'] ? 'is-done' : '' }}">
                <span class="tc-dash-setup__status" aria-hidden="true">
                    @if($step['done'])
                        <i data-feather="check-circle"></i>
                    @else
                        <i data-feather="circle"></i>
                    @endif
                </span>
                <div class="tc-dash-setup__body">
                    <span class="tc-dash-setup__label">{{ $step['label'] }}</span>
                    <a href="{{ route($step['route']) }}" class="tc-dash-setup__action">
                        {{ $step['done'] ? 'Review' : 'Configure' }}
                    </a>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    @if(isset($dealerReady) && !$dealerReady)
        <div class="card-footer tc-dash-setup__footer">
            <i data-feather="info" aria-hidden="true"></i>
            <span>Complete <strong>Site settings</strong> and <strong>Tax &amp; fees</strong> first.</span>
        </div>
    @elseif(isset($dealerReady) && $dealerReady && $onboardingPct < 100)
        <div class="card-footer tc-dash-setup__footer tc-dash-setup__footer--ok">
            <i data-feather="check" aria-hidden="true"></i>
            <span>Dealers can place orders. Finish remaining setup when ready.</span>
        </div>
    @elseif($onboardingPct >= 100)
        <div class="card-footer tc-dash-setup__footer tc-dash-setup__footer--ok">
            <i data-feather="award" aria-hidden="true"></i>
            <span>Setup complete.</span>
        </div>
    @endif
</div>
@else
<div class="container-fluid mb-3">
    <div class="card tc-dash-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 tc-dash-card__title">Store setup</h5>
            <span class="badge rounded-pill tc-onboard-badge">{{ $onboardingProgress ?? '' }}</span>
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush tc-dash-setup__list tc-dash-setup__list--full">
                @foreach ($sortedSteps as $step)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="me-3">
                            @if($step['done'])
                                <i class="fa-solid fa-circle-check text-success" aria-hidden="true"></i>
                            @else
                                <i class="fa-regular fa-circle text-muted" aria-hidden="true"></i>
                            @endif
                            <strong class="ms-1">{{ $step['label'] }}</strong>
                            <div class="small text-muted">{{ $step['hint'] }}</div>
                        </div>
                        <a href="{{ route($step['route']) }}" class="btn btn-sm tc-pn-btn {{ $step['done'] ? 'tc-pn-btn--outline' : 'tc-pn-btn--navy' }}">
                            {{ $step['done'] ? 'Review' : 'Configure' }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        @if(isset($dealerReady) && !$dealerReady)
            <div class="card-footer small text-muted">
                Complete <strong>Site settings</strong> and <strong>Tax &amp; fees</strong> before dealers can place orders.
            </div>
        @elseif(isset($dealerReady) && $dealerReady)
            <div class="card-footer small text-success">
                Minimum setup complete. Continue with catalog, users, and QuickBooks as needed.
            </div>
        @endif
    </div>
</div>
@endif
@endif
