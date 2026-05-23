@extends('themes.hazel.layout')

@section('content')
@php
    $home = $homesettings ?? $sf->homeSettings();
    $heroTitle = $page?->title ?? ($home?->aboutus_title ?? 'About '.$sfCompany);
    $heroLead = $page && $sf->hasMeaningfulHtml($page->content)
        ? null
        : ($home?->aboutus_description ?? null);
    $aboutImg = $sf->publicAsset($home?->aboutus_image);
    $cards = ($home && $home->card_one_title) ? [
        ['icon' => 'fa-tags', 'title' => $home->card_one_title, 'text' => $home->card_one_description],
        ['icon' => 'fa-tree', 'title' => $home->card_two_title, 'text' => $home->card_two_description],
        ['icon' => 'fa-truck-fast', 'title' => $home->card_three_title, 'text' => $home->card_three_description],
    ] : [];
@endphp

@include('themes.hazel.partials.breadcrumbs', ['items' => $hzBreadcrumbs ?? []])
@include('themes.hazel.partials.page-head', ['title' => $heroTitle, 'lead' => $heroLead])

@if ($page && $sf->hasMeaningfulHtml($page->content))
<section class="hz-page-content">
    <div class="hz-container">
        <div class="hz-page-body hz-page-body--intro">
            {!! $page->content !!}
        </div>
    </div>
</section>
@endif

@if ($aboutImg)
<section class="hz-section hz-section--cream">
    <div class="hz-container hz-about">
        <div class="hz-about__img">
            <img src="{{ $aboutImg }}" alt="{{ $home?->aboutus_title ?? $heroTitle }}">
        </div>
        <div>
            <h2 class="hz-section__title hz-section__title--left">{{ $home?->aboutus_title ?? 'Built for the trade' }}</h2>
            @if ($home?->aboutus_description)
                <div class="hz-page-body">{!! $home->aboutus_description !!}</div>
            @endif
            @if ($sfShowContact)
                <a href="{{ $sfContactPage ? route('cms.page', $sfContactPage->slug) : route('cms.page').'#hz-contact' }}" class="hz-btn hz-btn--primary">Contact us</a>
            @endif
        </div>
    </div>
</section>
@endif

@if (count($cards))
<section class="hz-section">
    <div class="hz-container">
        <h2 class="hz-section__title">Why partners choose {{ $sfCompany }}</h2>
        <div class="hz-grid-3">
            @foreach ($cards as $card)
                <article class="hz-card hz-card--lift">
                    <div class="hz-card__icon"><i class="fa-solid {{ $card['icon'] }}" aria-hidden="true"></i></div>
                    <h3>{{ $card['title'] }}</h3>
                    <div class="hz-page-body">{!! $card['text'] !!}</div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="hz-section hz-section--dark text-center">
    <div class="hz-container">
        <h2 class="hz-section__title" style="color:#fff;">Ready to work with {{ $sfCompany }}?</h2>
        <a href="{{ route('tenant_register') }}" class="hz-btn hz-btn--gold">Apply for trade pricing</a>
    </div>
</section>
@endsection
