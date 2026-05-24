@extends('themes.modern.layout')

@section('content')
@php
    $home = $homesettings ?? $sf->homeSettings();
    $heroTitle = $page?->title ?? ($home?->aboutus_title ?? 'About '.$sfCompany);
    $heroLead = $page && $sf->hasMeaningfulHtml($page->content) ? null : ($home?->aboutus_description ?? null);
@endphp
@include('themes.modern.partials.breadcrumbs', ['items' => $hzBreadcrumbs ?? []])
@include('themes.modern.partials.page-head', ['title' => $heroTitle, 'lead' => $heroLead])
@if ($page && $sf->hasMeaningfulHtml($page->content))
<section class="py-12">
    <div class="md-content mx-auto max-w-3xl px-4 lg:px-6">{!! $page->content !!}</div>
</section>
@endif
@endsection
