@if (!empty($items))
<nav class="border-b border-md-line bg-md-cream py-3 text-sm" aria-label="Breadcrumb">
    <ol class="mx-auto flex max-w-md-page flex-wrap gap-2 px-4 lg:px-6">
        @foreach ($items as $i => $item)
            <li class="flex items-center gap-2">
                @if ($i > 0)<span class="text-gray-400">/</span>@endif
                @if (!empty($item['url']) && $i < count($items) - 1)
                    <a href="{{ $item['url'] }}" class="text-md-gold hover:underline">{{ $item['label'] }}</a>
                @else
                    <span class="font-medium text-md-ink">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif
