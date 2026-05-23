@extends('themes.classic.layout')

@section('content')
@include('themes.hazel.partials.breadcrumbs', ['items' => $hzBreadcrumbs ?? []])
@include('themes.hazel.partials.page-head', ['title' => $page->title])

<section class="hz-page-content">
    <div class="hz-container">
        @if (!empty($page->content))
            <div class="hz-page-body hz-page-body--intro">
                {!! $page->content !!}
            </div>
        @endif

        @if ($posts->isNotEmpty())
            <div class="hz-blog-list">
                @foreach ($posts as $post)
                    <article class="hz-blog-card">
                        <time class="hz-blog-card__date" datetime="{{ $post->created_at->toDateString() }}">
                            {{ $post->created_at->format('M j, Y') }}
                        </time>
                        <h2 class="hz-blog-card__title">
                            <a href="{{ route('cms.page', $post->slug) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="hz-blog-card__excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 200) }}</p>
                        <a href="{{ route('cms.page', $post->slug) }}" class="hz-blog-card__link">Read more</a>
                    </article>
                @endforeach
            </div>
        @else
            <p class="hz-blog-empty">No posts published yet. Check back soon.</p>
        @endif
    </div>
</section>
@endsection
