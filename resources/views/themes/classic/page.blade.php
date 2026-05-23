@extends('themes.classic.layout')

@section('content')
@include('themes.hazel.partials.breadcrumbs', ['items' => $hzBreadcrumbs ?? []])
@include('themes.hazel.partials.page-head', ['title' => $page->title])

<section class="hz-page-content">
    <div class="hz-container">
        <div class="hz-page-body">
            {!! $page->content !!}
        </div>
    </div>
</section>
@endsection
