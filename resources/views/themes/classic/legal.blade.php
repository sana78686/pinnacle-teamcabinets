@extends('themes.classic.layout')

@section('content')
@include('themes.hazel.partials.breadcrumbs', ['items' => $hzBreadcrumbs ?? []])
@include('themes.hazel.partials.page-head', ['title' => $legal['title']])

<section class="hz-page-content">
    <div class="hz-container">
        <div class="hz-page-body hz-legal-body">
            {!! $legal['html'] !!}
        </div>
    </div>
</section>
@endsection
