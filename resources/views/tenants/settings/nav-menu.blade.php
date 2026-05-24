@extends('layouts.tenant.master')

@section('title', 'Navigation layout')

@section('breadcrumb-title')
    <h2>Navigation<span> layout</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Menu layout</li>
@endsection

@section('content')
    <div class="container-fluid py-2">
        <div class="card tc-nav-menu-editor">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
                <div>
                    <h5 class="mb-1">Customize admin navigation</h5>
                    <p class="text-muted small mb-0">Drag items to reorder your sidebar. Changes apply only to your account.</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light btn-sm" id="tc-nav-order-reset">Reset to default</button>
                    <button type="button" class="btn btn-primary btn-sm" id="tc-nav-order-save">Save order</button>
                </div>
            </div>
            <div class="card-body py-3">
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
    </div>
@endsection

@section('script')
    <script>
        window.TENANT_NAV_MENU_CONFIG = {
            csrf: @json(csrf_token()),
            saveUrl: @json(route('tenant_nav_menu_update')),
            resetUrl: @json(route('tenant_nav_menu_reset')),
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script src="{{ tenant_static_asset('js/tenant-admin-nav-order.js') }}?v=2"></script>
@endsection
