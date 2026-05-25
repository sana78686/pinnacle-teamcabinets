@extends('layouts.tenant.settings')

@section('title', 'Menu layout')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Menu layout</li>
@endsection

@section('setting_content')
    <div class="card tc-nav-menu-editor border-0 shadow-none">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3 px-0 bg-transparent border-0">
            <div>
                <h5 class="mb-1">Customize admin navigation</h5>
                <p class="text-muted small mb-0">Drag items to reorder your sidebar. Changes apply only to your account.</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-light btn-sm" id="tc-nav-order-reset">Reset to default</button>
                <button type="button" class="btn btn-primary btn-sm" id="tc-nav-order-save">Save order</button>
            </div>
        </div>
        <div class="card-body py-3 px-0">
            <div id="tc-nav-order-flash" class="alert d-none mb-3" role="alert"></div>
            <ul id="tc-nav-order-list" class="tc-nav-order-list list-unstyled mb-0">
                @foreach ($navItems as $index => $navItem)
                    <li class="tc-nav-order-list__item" data-key="{{ $navItem['key'] }}">
                        <span class="tc-nav-order-list__position" aria-hidden="true">{{ $index + 1 }}</span>
                        <span class="tc-nav-order-list__handle" aria-hidden="true">
                            <i data-feather="menu"></i>
                        </span>
                        <span class="tc-nav-order-list__icon">
                            <i data-feather="{{ $navItem['icon'] }}"></i>
                        </span>
                        <span class="tc-nav-order-list__label">{{ $navItem['label'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('setting_script')
    <script>
        window.TENANT_NAV_MENU_CONFIG = {
            csrf: @json(csrf_token()),
            saveUrl: @json(route('tenant_nav_menu_update')),
            resetUrl: @json(route('tenant_nav_menu_reset')),
            dashboardUrl: @json(route('tenant_dashboard')),
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script src="{{ tenant_static_asset('js/tenant-admin-nav-order.js') }}?v=3"></script>
@endsection
