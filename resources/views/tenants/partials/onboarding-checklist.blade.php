@if(!empty($onboardingSteps))
<div class="container-fluid mb-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Setup checklist (§5.2)</h5>
            <span class="badge bg-primary">{{ $onboardingProgress ?? '' }}</span>
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @foreach (collect($onboardingSteps)->sortBy('order') as $step)
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
                        <a href="{{ route($step['route']) }}" class="btn btn-sm {{ $step['done'] ? 'btn-light' : 'btn-primary' }}">
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
