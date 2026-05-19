@php
if (!isset($breadcrumbs)) {
    $home = ['label' => 'Home', 'url' => route('/')];
    $breadcrumbs = match (Route::currentRouteName()) {
        '/', null => null,
        'pinnacle.services' => [$home, ['label' => 'Services']],
        'pinnacle.team-cabinets' => [$home, ['label' => 'Team Cabinets']],
        'pinnacle.contact', 'pinnacle.contact.send' => [$home, ['label' => 'Contact us']],
        'pinnacle.find-tenant', 'pinnacle.find-tenant.lookup' => [$home, ['label' => 'Find tenant']],
        'pinnacle.privacy' => [$home, ['label' => 'Privacy Policy']],
        'pinnacle.terms' => [$home, ['label' => 'Terms of Service']],
        'pinnacle.cookies' => [$home, ['label' => 'Cookie Policy']],
        'pinnacle.subscription-terms' => [$home, ['label' => 'Subscription Terms']],
        'auth_login', 'login_post' => [$home, ['label' => 'Admin login']],
        'registeration', 'pinnacle_tenant_register' => [$home, ['label' => 'Register']],
        default => null,
    };
}
@endphp
@if (!empty($breadcrumbs))
<nav class="pn-breadcrumb" aria-label="Breadcrumb">
    <div class="pn-container">
        <ol class="pn-breadcrumb__list">
            @foreach ($breadcrumbs as $i => $crumb)
            <li class="pn-breadcrumb__item">
                @if (!empty($crumb['url']) && $i < count($breadcrumbs) - 1)
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
