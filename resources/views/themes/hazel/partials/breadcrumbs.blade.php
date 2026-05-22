@php
    $items = $items ?? ($hzBreadcrumbs ?? []);
@endphp
@if (count($items) > 0)
<nav class="hz-breadcrumb" aria-label="Breadcrumb">
    <div class="hz-container">
        <ol class="hz-breadcrumb__list">
            @foreach ($items as $index => $crumb)
                <li class="hz-breadcrumb__item">
                    @if (!empty($crumb['url']) && $index < count($items) - 1)
                        <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                    @else
                        <span aria-current="page">{{ $crumb['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</nav>
@endif
