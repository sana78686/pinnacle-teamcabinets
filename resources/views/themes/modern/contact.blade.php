@extends('themes.modern.layout')

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

@include('themes.modern.partials.breadcrumbs', ['items' => $hzBreadcrumbs ?? []])
@include('themes.modern.partials.page-head', [
    'title' => $pageTitle,
    'lead' => 'Questions about dealer applications, orders, or project support? Send us a message.',
])

<section class="py-12">
    <div class="mx-auto grid max-w-md-page gap-10 px-4 lg:grid-cols-3 lg:px-6">
        <div class="lg:col-span-2">
            @if (session('success'))
                <div class="sf-alert sf-alert--success mb-4">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="sf-alert sf-alert--error mb-4">
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @if ($intro)
                <div class="md-content mb-6">{!! $intro !!}</div>
            @endif
            @include('partials.storefront.contact-form')
        </div>
        <aside class="rounded-lg border border-md-line bg-md-cream p-6">
            <h2 class="text-xl font-bold">{{ $sidebarTitle }}</h2>
            <ul class="mt-4 space-y-4 text-sm">
                @if ($phone)
                    <li><strong>Phone</strong><br><a href="tel:{{ preg_replace('/\D+/', '', $phone) }}" class="text-md-gold">{{ $phone }}</a></li>
                @endif
                @if ($site?->address)
                    <li><strong>Address</strong><br>{{ $site->address }}</li>
                @endif
                @if ($email)
                    <li><strong>Email</strong><br><a href="mailto:{{ $email }}" class="text-md-gold">{{ $email }}</a></li>
                @endif
            </ul>
        </aside>
    </div>
</section>

@if ($mapEmbed)
<section class="pb-12">
    <div class="mx-auto max-w-md-page px-4 lg:px-6">
        <h2 class="mb-4 text-2xl font-bold">Find us</h2>
        <div class="overflow-hidden rounded-lg border border-md-line">
            @if (str_contains($mapEmbed, '<iframe'))
                {!! $mapEmbed !!}
            @else
                <iframe src="{{ $mapEmbed }}" width="100%" height="400" style="border:0;" allowfullscreen loading="lazy" title="Map location"></iframe>
            @endif
        </div>
    </div>
</section>
@endif
@endsection
