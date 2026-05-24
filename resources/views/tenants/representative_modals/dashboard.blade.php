@extends('layouts.tenant.role.master')

@section('title', 'Dashboard')

@section('breadcrumb-title')
    <h2>Welcome {{ tenant_panel_display_name() }} <span>({{ tenant_panel_role_label() }})</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Home</li>
@endsection

@section('content')
    @php
        $account = $account ?? [];
        $childUsers = $childUsers ?? collect();
        $pastBulletins = $pastBulletins ?? collect();
        $openBulletinId = $featuredBulletin?->id;
    @endphp

    <div class="tc-role-dashboard px-2 pb-1">
        @if (session('order_msg') || session('success'))
            <div class="alert alert-success tc-role-dashboard__flash py-2 mb-2">
                {{ session('order_msg') ?? session('success') }}
            </div>
        @endif

        <div class="tc-role-dashboard__layout">
            <aside class="tc-role-dashboard__left">
                <div class="tc-ci-box tc-role-dashboard__box">
                    <div class="tc-ci-box__header">
                        <h3 class="tc-ci-box__title mb-0">Account #{{ $account['account_number'] ?? '—' }}</h3>
                    </div>
                    <div class="tc-ci-box__body tc-role-dashboard__account">
                        <ul class="list-unstyled mb-0">
                            <li><strong>User name:</strong> {{ $account['name'] ?? '—' }}</li>
                            <li><strong>Address:</strong> {{ $account['address'] ?? '—' }}</li>
                            <li><strong>State:</strong> {{ $account['state'] ?? '—' }}</li>
                            <li><strong>City:</strong> {{ $account['city'] ?? '—' }}</li>
                            <li><strong>Zipcode:</strong> {{ $account['zipcode'] ?? '—' }}</li>
                            <li><strong>Phone number:</strong> {{ $account['phone'] ?? '—' }}</li>
                            <li><strong>Email:</strong> {{ $account['email'] ?? '—' }}</li>
                        </ul>
                    </div>
                </div>

                <div class="tc-ci-box tc-role-dashboard__box">
                    <div class="tc-ci-box__header d-flex justify-content-between align-items-center gap-2">
                        <h3 class="tc-ci-box__title mb-0">{{ $usersCardTitle ?? 'My Users' }}</h3>
                        @if ($showAddUser ?? true)
                            <a href="{{ route('tenant_user_child_create') }}" class="btn btn-sm btn-primary tc-role-dashboard__add-btn">
                                {{ $addUserLabel ?? 'Add User' }}
                            </a>
                        @endif
                    </div>
                    <div class="tc-ci-box__body p-0">
                        <ul class="list-unstyled mb-0 tc-role-dashboard__user-list">
                            @forelse ($childUsers as $child)
                                <li class="tc-role-dashboard__list-row">
                                    <a href="{{ route('tenant_child_user_show', $child->id) }}">
                                        {{ tenant_panel_display_name($child) }}
                                    </a>
                                    @if ($child->email)
                                        <div class="small text-muted">{{ $child->email }}</div>
                                    @endif
                                </li>
                            @empty
                                <li class="tc-role-dashboard__list-row text-muted">No users yet.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="tc-ci-box tc-role-dashboard__box">
                    <div class="tc-ci-box__header">
                        <h3 class="tc-ci-box__title mb-0">Past Bulletins</h3>
                    </div>
                    <div class="tc-ci-box__body p-0 tc-role-dashboard__past-list">
                        @forelse ($pastBulletins as $bulletin)
                            <a href="{{ route('tenant_dashboard', ['bulletin' => $bulletin->id]) }}"
                                class="tc-role-dashboard__past-item {{ ($openBulletinId ?? $pastBulletins->first()?->id) === $bulletin->id ? 'is-active' : '' }}">
                                {{ $bulletin->bulletin_title }}
                                <span class="text-muted">({{ $bulletin->created_at?->format('m/d/Y') }})</span>
                            </a>
                        @empty
                            <p class="text-muted mb-0 tc-role-dashboard__list-row">No bulletins posted yet.</p>
                        @endforelse
                    </div>
                </div>
            </aside>

            <section class="tc-role-dashboard__right">
                <div class="tc-ci-box tc-role-dashboard__box tc-role-dashboard__bulletin-panel">
                    <div class="tc-ci-box__header">
                        <h3 class="tc-ci-box__title mb-0">{{ tenant('company_name') ?? tenant('name') ?? 'Team Cabinets' }} Bulletins</h3>
                    </div>
                    <div class="tc-ci-box__body tc-role-dashboard__bulletin-body p-0">
                        @if ($pastBulletins->isNotEmpty())
                            <div class="accordion tc-role-dashboard__accordion" id="tcRoleBulletinAccordion">
                                @foreach ($pastBulletins as $index => $bulletin)
                                    @php
                                        $isOpen = ($openBulletinId ?? null)
                                            ? $openBulletinId === $bulletin->id
                                            : $index === 0;
                                        $collapseId = 'tc-bulletin-'.$bulletin->id;
                                    @endphp
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-{{ $bulletin->id }}">
                                            <button
                                                class="accordion-button {{ $isOpen ? '' : 'collapsed' }}"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#{{ $collapseId }}"
                                                aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                                                aria-controls="{{ $collapseId }}"
                                            >
                                                {{ $bulletin->bulletin_title }}
                                            </button>
                                        </h2>
                                        <div
                                            id="{{ $collapseId }}"
                                            class="accordion-collapse collapse {{ $isOpen ? 'show' : '' }}"
                                            aria-labelledby="heading-{{ $bulletin->id }}"
                                            data-bs-parent="#tcRoleBulletinAccordion"
                                        >
                                            <div class="accordion-body">
                                                @include('tenants.representative_modals.dashboard.partials.bulletin-viewer', [
                                                    'bulletin' => $bulletin,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0 p-2">No bulletin available for your account yet.</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
