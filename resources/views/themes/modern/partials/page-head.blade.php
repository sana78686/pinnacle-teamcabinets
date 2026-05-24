<section class="border-b border-md-line bg-white py-12 md:py-16">
    <div class="mx-auto max-w-md-page px-4 text-center lg:px-6">
        <h1 class="text-3xl font-bold text-md-ink md:text-4xl">{{ $title }}</h1>
        @if (!empty($lead))
            <div class="md-content mx-auto mt-4 max-w-3xl">{!! $lead !!}</div>
        @endif
    </div>
</section>
