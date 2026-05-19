@extends('pinnacle.layouts.app')

@section('title', 'Services')
@section('meta_description', 'Pinnacle services for cabinet distributors: website, dealer portal, orders, quotes, QuickBooks, and operations.')

@section('content')
<section class="pn-page-hero">
    <div class="pn-container">
        <h1>Services for your cabinets business</h1>
        <p>Everything included when you run on Pinnacle — the same capabilities as our Team Cabinets production platform.</p>
    </div>
</section>

<section class="pn-section">
    <div class="pn-container">
        <div class="pn-services-grid">
            @foreach ($pinnacle['service_groups'] as $index => $group)
            <article class="pn-service-card">
                <span class="pn-service-card__num">{{ $index + 1 }}</span>
                <h3>{{ $group['title'] }}</h3>
                <p>{{ $group['description'] }}</p>
                <ul>
                    @foreach ($group['items'] as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </article>
            @endforeach
        </div>
        <div class="pn-cta-band" style="margin-top:3rem">
            <h2>Start with Team Cabinets on Pinnacle</h2>
            <p>{{ $pinnacle['trial_days'] }}-day free trial — website, panel, dealers, orders, and QuickBooks.</p>
            <a href="{{ route('registeration') }}" class="pn-btn pn-btn--dark">Get started</a>
        </div>
    </div>
</section>
@endsection
