@extends('layouts.tenant.master')

@section('content')
    <div class="container-fluid tc-settings-page pl-0">
        <div class="tc-settings-hub mb-0">
            <div class="tc-settings-inner p-0">
                <div class="tc-settings-layout">
                    @include('layouts.tenant.partials.settings-sidebar')
                    <div class="tc-settings-content">
                        <div class="tc-settings-panel tc-form-page">
                            @yield('setting_content')
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
            function refreshSettingsUi() {
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
            refreshSettingsUi();
            window.setTimeout(refreshSettingsUi, 500);
        });
    </script>
    @yield('setting_script')
@endsection
