@if (!empty($tcShowTrialBanner) && $tcTrialEndsAt)
@php
    $trialDate = $tcTrialEndsAt->format('M j, Y');
    $company = tenant('company_name') ?? tenant('name') ?? 'Your portal';
    $trialMsg = "Free trial active until {$trialDate} — Complete site settings, product catalog, and dealer onboarding to get the most from {$company}. ";
@endphp
<div class="tc-trial-marquee" role="status" aria-live="polite">
    <div class="tc-trial-marquee__track">
        <span class="tc-trial-marquee__text">{{ $trialMsg }}</span>
        <span class="tc-trial-marquee__text" aria-hidden="true">{{ $trialMsg }}</span>
        <span class="tc-trial-marquee__text" aria-hidden="true">{{ $trialMsg }}</span>
    </div>
</div>
@endif
