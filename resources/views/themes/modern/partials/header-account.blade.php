@php
    $variant = $variant ?? 'desktop';
    $userName = auth()->user()->name ?? auth()->user()->email ?? 'Account';
@endphp
@if ($variant === 'mobile')
    <span class="text-md-muted"><i class="fa-solid fa-user mr-1"></i>{{ $userName }}</span>
    <a href="{{ route('tenant_dashboard') }}">Dashboard</a>
    <a href="{{ route('tenant_profile') }}">Profile</a>
    <form method="POST" action="{{ route('tenant_logout') }}">
        @csrf
        <button type="submit" class="text-left font-medium text-red-700">Log out</button>
    </form>
@else
    <div class="relative">
        <button type="button" id="md-account-btn" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-md-line text-md-ink hover:bg-md-cream" aria-label="Account menu">
            <i class="fa-solid fa-user" aria-hidden="true"></i>
        </button>
        <div id="md-account-menu" class="absolute right-0 z-50 mt-2 hidden min-w-[200px] rounded-lg border border-md-line bg-white py-2 shadow-lg">
            <p class="border-b border-md-line px-4 py-2 text-sm font-semibold">{{ $userName }}</p>
            <a href="{{ route('tenant_dashboard') }}" class="block px-4 py-2 text-sm hover:bg-md-cream">Dashboard</a>
            <a href="{{ route('tenant_profile') }}" class="block px-4 py-2 text-sm hover:bg-md-cream">Profile</a>
            <form method="POST" action="{{ route('tenant_logout') }}">
                @csrf
                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-700 hover:bg-md-cream">Log out</button>
            </form>
        </div>
    </div>
@endif
