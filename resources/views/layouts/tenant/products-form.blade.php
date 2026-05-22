@extends('layouts.tenant.master')

@section('breadcrumb-title')
    <h2>Products</h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
    <div class="container-fluid tc-products-page tc-settings-page pl-0">
        <div class="tc-settings-hub tc-products-hub mb-0">
            <div class="tc-settings-inner p-0">
                <div class="tc-settings-layout">
                    @include('layouts.tenant.partials.products-form-sidebar')
                    <div class="tc-settings-content">
                        <div class="tc-settings-panel tc-form-page">
                            @hasSection('products_title')
                                <h3 class="tc-settings-form-title mb-3">@yield('products_title')</h3>
                            @endif
                            @include('partial.message')
                            @yield('products_content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            var panel = document.querySelector('.tc-settings-panel');
            function refreshProductsUi() {
                if (window.TenantSettingsLayout && typeof window.TenantSettingsLayout.refresh === 'function') {
                    window.TenantSettingsLayout.refresh(panel);
                }
                if (window.TenantSettingsForms && typeof window.TenantSettingsForms.refresh === 'function') {
                    window.TenantSettingsForms.refresh(panel);
                }
                if (window.TenantFieldTips && typeof window.TenantFieldTips.refresh === 'function') {
                    window.TenantFieldTips.refresh(panel);
                }
            }
            refreshProductsUi();
            window.setTimeout(refreshProductsUi, 500);
        });
    </script>
    @yield('products_script')
@endsection
