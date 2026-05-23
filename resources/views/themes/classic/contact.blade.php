@extends('themes.classic.layout')

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
    $intro = ($page && $sf->hasMeaningfulHtml($page->content)) ? $page->content : null;
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
                        <div class="hz-alert hz-alert--success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="hz-alert hz-alert--error">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ($intro)
                        <div class="hz-page-body hz-page-body--intro mb-4">{!! $intro !!}</div>
                    @endif
                    <form action="{{ route('contact.send') }}" method="post" enctype="multipart/form-data" class="hz-contact-form">
                        @csrf
                        <input type="text" name="url" value="" tabindex="-1" autocomplete="off" class="hz-honeypot" aria-hidden="true">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="hz-label" for="name">Name</label>
                                <input type="text" name="name" id="name" class="hz-input" required value="{{ old('name') }}" placeholder="Your name">
                            </div>
                            <div class="col-md-6">
                                <label class="hz-label" for="from">Email</label>
                                <input type="email" name="from" id="from" class="hz-input" required value="{{ old('from') }}" placeholder="your@email.com">
                            </div>
                            <div class="col-12">
                                <label class="hz-label" for="message">Message</label>
                                <textarea name="message" id="message" class="hz-input" rows="6" required placeholder="How can we help?">{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="hz-label" for="fileUpload">Attachment <span class="hz-muted">(optional)</span></label>
                                <input type="file" name="fileUpload" id="fileUpload" class="hz-input hz-input--file">
                            </div>
                            <div class="col-12">
                                @include('partials.cloudflare-turnstile', ['class' => 'hz-turnstile-wrap'])
                            </div>
                            <div class="col-12">
                                <button type="submit" class="hz-btn hz-btn--gold hz-btn--block-sm">Send</button>
                            </div>
                        </div>
                    </form>
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
