{{-- Usage: @include('layouts.tenant.partials.nav-dropdown', ['title' => 'Claims', 'items' => [...]]) --}}
<ul class="tc-nav-dropdown">
    <li class="tc-nav-dropdown__head">{{ $title }}</li>
    @foreach ($items as $item)
        <li class="tc-nav-dropdown__item">
            <a href="{{ $item['url'] }}">
                <i data-feather="{{ $item['icon'] ?? 'circle' }}" aria-hidden="true"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        </li>
    @endforeach
</ul>
