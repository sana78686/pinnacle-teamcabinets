@extends('pinnacle.layouts.app')

@section('title', 'Pinnacle — Cabinets platform for distributors')

@section('content')
<section class="pn-hero">
    <div class="pn-container">
        <div class="pn-hero__grid">
            <div>
                <span class="pn-hero__badge">{{ $pinnacle['trial_days'] }}-day free trial</span>
                <h1 class="pn-hero__title">
                    Run your <span>cabinets business</span> online — website &amp; panel in minutes
                </h1>
                <p class="pn-hero__lead">
                    Pinnacle gives cabinet distributors a branded public site, dealer portal, ordering, quotes, and QuickBooks — on dedicated tenant infrastructure. <strong>Team Cabinets</strong> is our live flagship implementation.
                </p>
                <div class="pn-hero__cta">
                    <a href="{{ route('registeration') }}" class="pn-btn pn-btn--primary">Get started free</a>
                    <a href="{{ route('pinnacle.services') }}" class="pn-btn pn-btn--outline">See services</a>
                </div>
            </div>
            <div class="pn-hero__visual">
                @include('pinnacle.partials.hero-rotator')
                <div class="pn-hero__float">
                    <div class="pn-hero__chip"><strong>Website</strong> Public catalog &amp; quotes</div>
                    <div class="pn-hero__chip"><strong>Panel</strong> Orders &amp; dealers</div>
                    <div class="pn-hero__chip"><strong>QuickBooks</strong> Synced products</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pn-section">
    <div class="pn-container">
        <div class="pn-section__head">
            <h2>What you get with Pinnacle</h2>
            <p>One platform for how cabinet distributors actually work — not generic e-commerce.</p>
        </div>
        <div class="pn-sell-grid">
            @foreach ($pinnacle['what_we_sell'] as $item)
            <article class="pn-sell-card">
                <div class="pn-sell-card__icon">@include('pinnacle.partials.icons', ['icon' => $item['icon']])</div>
                <h3>{{ $item['title'] }}</h3>
                <p>{{ $item['description'] }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>

<section class="pn-section pn-section--white">
    <div class="pn-container">
        <div class="pn-section__head">
            <h2>Built for cabinet distributors</h2>
            <p>Every service below comes from our production Team Cabinets platform — now available per tenant.</p>
        </div>
        <div class="pn-highlights">
            @foreach ($pinnacle['highlights'] as $h)
            <div class="pn-highlight">
                <h4>{{ $h['title'] }}</h4>
                <p>{{ $h['body'] }}</p>
            </div>
            @endforeach
        </div>
        <p style="text-align:center;margin-top:2rem">
            <a href="{{ route('pinnacle.services') }}" class="pn-btn pn-btn--dark">View all services</a>
        </p>
    </div>
</section>

<section class="pn-section">
    <div class="pn-container">
        <div class="pn-section__head">
            <h2>See the platform</h2>
            <p>Dealer-facing website plus back-office panel — provisioned on your subdomain.</p>
        </div>
        <div style="display:grid;gap:1.5rem;grid-template-columns:repeat(auto-fit,minmax(280px,1fr))">
            <div class="pn-img-panel">
                @include('pinnacle.partials.visual', [
                    'variant' => 'showcase_dealer',
                    'alt' => 'Dealer browsing cabinet catalog',
                    'aspect' => '16/10',
                ])
            </div>
            <div>
                <div class="pn-mockup" style="margin-bottom:1rem">
                    <div class="pn-mockup__bar"><span class="pn-mockup__dot"></span><span class="pn-mockup__dot"></span><span class="pn-mockup__dot"></span></div>
                    <div class="pn-mockup__body">
                        <div class="pn-mockup__row"></div>
                        <div class="pn-mockup__row pn-mockup__row--short"></div>
                        <div class="pn-mockup__grid">
                            @for ($i = 0; $i < 6; $i++) <div class="pn-mockup__cell"></div> @endfor
                        </div>
                    </div>
                </div>
                <p style="font-size:0.9375rem;color:var(--pn-text-muted);margin:0">Admin panel: orders, users, catalog, claims, commissions, and settings.</p>
            </div>
        </div>
    </div>
</section>

<section class="pn-section pn-section--white">
    <div class="pn-container">
        <article class="pn-flagship">
            <div class="pn-flagship__content">
                <p class="pn-flagship__label">Flagship tenant</p>
                <h2>{{ $pinnacle['flagship_tenant']['name'] }}</h2>
                <p>{{ $pinnacle['flagship_tenant']['description'] }}</p>
                <div style="display:flex;flex-wrap:wrap;gap:0.75rem">
                    <a href="{{ route('pinnacle.team-cabinets') }}" class="pn-btn pn-btn--primary">About Team Cabinets</a>
                    <a href="{{ route('registeration') }}" class="pn-btn pn-btn--outline">Register your tenant</a>
                </div>
            </div>
            <div class="pn-flagship__media">
                @include('pinnacle.partials.visual', [
                    'variant' => 'flagship_logo',
                    'alt' => $pinnacle['flagship_tenant']['name'],
                    'aspect' => 'auto',
                    'class' => 'pn-visual--contain',
                ])
            </div>
        </article>
    </div>
</section>

<section class="pn-section">
    <div class="pn-container">
        <div class="pn-section__head">
            <h2>How it works</h2>
            <p>From signup to selling cabinets with your dealers.</p>
        </div>
        <ol class="pn-steps" style="list-style:none;padding:0;margin:0">
            <li class="pn-step">
                <div class="pn-step__num">1</div>
                <h3>Register on Pinnacle</h3>
                <p>Create your company account. Your {{ $pinnacle['trial_days'] }}-day trial starts immediately.</p>
            </li>
            <li class="pn-step">
                <div class="pn-step__num">2</div>
                <h3>Get your tenant site</h3>
                <p>We provision your subdomain, public website, and management panel with isolated data.</p>
            </li>
            <li class="pn-step">
                <div class="pn-step__num">3</div>
                <h3>Onboard dealers &amp; sell</h3>
                <p>Add users, connect QuickBooks, publish your catalog, and take orders.</p>
            </li>
        </ol>
    </div>
</section>

<section class="pn-section pn-section--white">
    <div class="pn-container">
        <div class="pn-cta-band">
            <h2>Ready to launch your cabinets business online?</h2>
            <p>Full access to website, dealer portal, orders, quotes, and QuickBooks mapping — start with a {{ $pinnacle['trial_days'] }}-day trial.</p>
            <a href="{{ route('registeration') }}" class="pn-btn pn-btn--dark">Create your account</a>
        </div>
    </div>
</section>
@endsection
