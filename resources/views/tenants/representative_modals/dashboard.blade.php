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
                    <div class="tc-ci-box__body tc-role-dashboard__account p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0 tc-role-dashboard__account-table">
                                <tbody>
                                    <tr>
                                        <th scope="row">User name</th>
                                        <td>{{ $account['name'] ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Address</th>
                                        <td>{{ $account['address'] ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">State</th>
                                        <td>{{ $account['state'] ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">City</th>
                                        <td>{{ $account['city'] ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Zipcode</th>
                                        <td>{{ $account['zipcode'] ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Phone number</th>
                                        <td>{{ $account['phone'] ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td>{{ $account['email'] ?? '—' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                                <li class="tc-role-dashboard__empty">
                                    <i class="icofont icofont-users" aria-hidden="true"></i>
                                    <p class="mb-0">No users yet.</p>
                                </li>
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
                            <a href="{{ route('tenant_dashboard', ['bulletin' => $bulletin->id]) }}#tc-bulletin-{{ $bulletin->id }}"
                                class="tc-role-dashboard__past-item {{ ($openBulletinId ?? $pastBulletins->first()?->id) === $bulletin->id ? 'is-active' : '' }}">
                                <span class="tc-role-dashboard__past-title">{{ $bulletin->bulletin_title }}</span>
                                <span class="text-muted">({{ $bulletin->created_at?->format('m/d/Y') }})</span>
                                @if ($bulletin->isPdfAttachment())
                                    <span class="badge bg-light text-dark border ms-1">PDF</span>
                                @endif
                            </a>
                        @empty
                            <div class="tc-role-dashboard__empty">
                                <i class="icofont icofont-file-document" aria-hidden="true"></i>
                                <p class="mb-0">No bulletins posted yet.</p>
                            </div>
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
                            <div class="tc-role-dashboard__empty tc-role-dashboard__empty--lg">
                                <i class="icofont icofont-notification" aria-hidden="true"></i>
                                <p class="mb-0">No bulletin available for your account yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
