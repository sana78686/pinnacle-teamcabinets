@extends('themes.hazel.layout')

@push('head')
    @include('partials.cloudflare-turnstile-scripts')
@endpush

@section('content')
@php
    $site = $settings ?? $sf->site();
    $phone = $site?->contactus_phone ?: $site?->phone;
    $email = $site?->contactus_email ?: $site?->email;
    $pageTitle = $page?->title ?? 'Contact us';
    $sidebarTitle = $site?->contact_sidebar_title ?: 'Need Assistance?';
    $intro = ($page && $sf->contactShowsIntro($page)) ? $page->content : null;
    $mapEmbed = $site?->map_embed_url ?? null;
@endphp

@include('themes.hazel.partials.breadcrumbs', ['items' => $hzBreadcrumbs ?? []])
@include('themes.hazel.partials.page-head', [
    'title' => $pageTitle,
    'lead' => 'Questions about dealer applications, orders, or project support? Send us a message.',
])

<section class="hz-section hz-section--contact">
    <div class="hz-container">
        <div class="row g-4 g-lg-5 align-items-start">
            <div class="col-lg-7 order-2 order-lg-1">
                <div class="hz-contact-card">
                    <h2 class="hz-contact-card__title">Send us a message</h2>
                    @if (session('success'))
                        <div class="sf-alert sf-alert--success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="sf-alert sf-alert--error">
                            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif
                    @if ($intro)
                        <div class="hz-page-body hz-page-body--intro mb-4">{!! $intro !!}</div>
                    @endif
                    @include('partials.storefront.contact-form')
                </div>
            </div>
            <div class="col-lg-5 order-1 order-lg-2">
                <aside class="hz-contact-info">
                    <h2 class="hz-contact-info__title">{{ $sidebarTitle }}</h2>
                    <ul class="hz-contact-info__list">
                        @if ($phone)
                            <li>
                                <span class="hz-contact-info__icon"><i class="fa-solid fa-phone" aria-hidden="true"></i></span>
                                <span><strong>Phone</strong><br><a href="tel:{{ preg_replace('/\D+/', '', $phone) }}">{{ $phone }}</a></span>
                            </li>
                        @endif
                        @if ($site?->address)
                            <li>
                                <span class="hz-contact-info__icon"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                                <span><strong>Address</strong><br>{{ $site->address }}</span>
                            </li>
                        @endif
                        @if ($email)
                            <li>
                                <span class="hz-contact-info__icon"><i class="fa-solid fa-envelope" aria-hidden="true"></i></span>
                                <span><strong>Email</strong><br><a href="mailto:{{ $email }}">{{ $email }}</a></span>
                            </li>
                        @endif
                    </ul>
                </aside>
            </div>
        </div>
    </div>
</section>

@if ($mapEmbed)
<section class="hz-section hz-section--map">
    <div class="hz-container">
        <h2 class="hz-map__title">Find us</h2>
        <div class="hz-map-embed">
            @if (str_contains($mapEmbed, '<iframe'))
                {!! $mapEmbed !!}
            @else
                <iframe src="{{ $mapEmbed }}" width="100%" height="400" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Map location"></iframe>
            @endif
        </div>
    </div>
</section>
@endif
@endsection
