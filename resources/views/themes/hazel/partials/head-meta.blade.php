@php
    $seo = $seo ?? ($sf->homeSeo() ?? []);
    $seoTitle = $seo['title'] ?? ($sfCompany ?? config('app.name'));
    $seoDescription = $seo['description'] ?? '';
    $seoKeywords = $seo['keywords'] ?? '';
    $seoCanonical = $seo['canonical'] ?? url()->current();
    $ogImage = $seo['og_image'] ?? null;
    $ogType = $seo['og_type'] ?? 'website';
    $twitterCard = $seo['twitter_card'] ?? 'summary_large_image';
@endphp
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
@if ($seoKeywords)
    <meta name="keywords" content="{{ $seoKeywords }}">
@endif
<link rel="canonical" href="{{ $seoCanonical }}">
@if (!empty($sfFaviconUrl))
    <link rel="icon" href="{{ $sfFaviconUrl }}" type="image/png">
    <link rel="shortcut icon" href="{{ $sfFaviconUrl }}">
@endif
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:title" content="{{ $seo['og_title'] ?? $seoTitle }}">
<meta property="og:description" content="{{ $seo['og_description'] ?? $seoDescription }}">
<meta property="og:url" content="{{ $seoCanonical }}">
<meta property="og:site_name" content="{{ $sfCompany ?? config('app.name') }}">
@if ($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
@endif
<meta name="twitter:card" content="{{ $twitterCard }}">
<meta name="twitter:title" content="{{ $seo['og_title'] ?? $seoTitle }}">
<meta name="twitter:description" content="{{ $seo['og_description'] ?? $seoDescription }}">
@if ($ogImage)
    <meta name="twitter:image" content="{{ $ogImage }}">
@endif
