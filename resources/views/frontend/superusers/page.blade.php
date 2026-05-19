@extends('frontend.superusers.layout')
@section('title', $page->title)
@section('head')
    <!-- CKEditor Core Content Styles -->
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/46.0.0/ckeditor5.css">

    <!-- CKEditor Premium Features Styles (optional if using premium features like Layouts) -->
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5-premium-features/46.0.0/ckeditor5-premium-features.css">
@endsection
@section('style')
<style>
    .ck-content .image img {
    max-width: 100%;
    height: auto;
    display: block;
}

.ck-content figure.image {
    margin-right: 3em;
}

.ck-content .image-style-align-left,
.ck-content .image-style-align-right {
    max-width: 100%;
}

@media (min-width: 768px) {
    .ck-content .image-style-align-left {
        float: left;
        margin-right: 2em;
    }

    .ck-content .image-style-align-right {
        float: right;
        margin-left: 1em;
    }
}

</style>
@endsection


@section('content')


<div class="container py-5">
    <div class="ck-content">
        {!! $page->content !!}
    </div>
</div>
@endsection
