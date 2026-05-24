@extends('themes.modern.layout')

@section('content')
@include('themes.modern.partials.breadcrumbs', ['items' => $hzBreadcrumbs ?? []])
@include('themes.modern.partials.page-head', ['title' => $page->title ?? 'Articles'])
@if (!empty($page->content))
<section class="py-8">
    <div class="md-content mx-auto max-w-3xl px-4 lg:px-6">{!! $page->content !!}</div>
</section>
@endif
<section class="py-12">
    <div class="mx-auto max-w-md-page px-4 lg:px-6">
        @if ($posts->isEmpty())
            <p class="text-center text-gray-600">No articles published yet.</p>
        @else
            <div class="grid gap-8 md:grid-cols-2">
                @foreach ($posts as $post)
                    <article class="rounded-lg border border-md-line bg-white p-6 shadow-sm">
                        <time class="text-xs font-semibold uppercase tracking-wide text-gray-500" datetime="{{ $post->created_at->toDateString() }}">
                            {{ $post->created_at->format('M j, Y') }}
                        </time>
                        <h2 class="mt-2 text-xl font-bold">
                            <a href="{{ route('cms.page', $post->slug) }}" class="hover:text-md-gold">{{ $post->title }}</a>
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 200) }}</p>
                        <a href="{{ route('cms.page', $post->slug) }}" class="mt-4 inline-block text-sm font-semibold text-md-gold">Read more →</a>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
