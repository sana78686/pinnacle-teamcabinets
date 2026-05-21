@extends('themes.hazel.layout')

@section('title', ($page->title ?? 'Page').' — '.(tenant('company_name') ?? tenant('name')))

@section('content')
<section class="hz-page-content">
    <div class="hz-container">
        @if ($page->isBlogPost() && ($blogPage ?? null))
            <p class="hz-page-breadcrumb">
                <a href="{{ route('cms.page', $blogPage->slug) }}">Blog</a>
                <span aria-hidden="true"> / </span>
                <span>{{ $page->title }}</span>
            </p>
        @endif
        <h1>{{ $page->title }}</h1>
        <div class="hz-page-body">
            {!! $page->content !!}
        </div>
    </div>
</section>
@endsection
