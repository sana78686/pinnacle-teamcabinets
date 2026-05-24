@extends('themes.modern.layout')

@section('content')
@include('themes.modern.partials.breadcrumbs', ['items' => $hzBreadcrumbs ?? []])
@include('themes.modern.partials.page-head', ['title' => $page->title])
<section class="py-12">
    <div class="md-content mx-auto max-w-3xl px-4 lg:px-6">
        {!! $page->content !!}
    </div>
</section>
@endsection
