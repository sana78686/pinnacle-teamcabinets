@php($tcLayout = $tcLayout ?? tenant_layout_flags())
@include('layouts.tenant.partials.panel-asset-fn')
<script src="{{$panelAsset('assets/main/js/jquery-3.5.1.min.js')}}"></script>
<script src="{{ $panelAsset('js/tc-fast-loader.js') }}?v=1"></script>
<!-- Bootstrap js-->
<script src="{{$panelAsset('assets/main/js/bootstrap/popper.min.js')}}"></script>
<script src="{{$panelAsset('assets/main/js/bootstrap/bootstrap.js')}}"></script>
<!-- feather icon js-->
<script src="{{$panelAsset('assets/main/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{$panelAsset('assets/main/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{$panelAsset('assets/main/js/sidebar-menu.js')}}"></script>
<script src="{{$panelAsset('assets/main/js/config.js')}}"></script>
<!-- Plugins JS start-->
@yield('script')
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{$panelAsset('assets/main/js/script.js')}}"></script>
{{-- <script src="{{$panelAsset('assets/main/js/theme-customizer/customizer.js')}}"></script> --}}
<script src="{{$panelAsset('assets/main/js/jquery.drilldown.js')}}"></script>
<script src="{{$panelAsset('assets/main/js/vertical-menu.js')}}"></script>
<script src="{{$panelAsset('assets/main/js/megamenu.js')}}"></script>
<script src="{{ $panelAsset('js/password-toggle.js') }}?v=1"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@if ($tcLayout['settings_extras'] ?? false)
<script>window.TENANT_FIELD_TIPS = @json(config('tenant_field_tips', []));</script>
<script src="{{ $panelAsset('js/tenant-tooltips.js') }}?v=3"></script>
<script src="{{ $panelAsset('js/tenant-settings-forms.js') }}?v=2"></script>
<script src="{{ $panelAsset('js/tenant-settings-layout.js') }}?v=1"></script>
@endif
@auth
<script>
    window.TENANT_NOTIFICATIONS_POLL_URL = @json(route('tenant_notifications_poll'));
    window.TENANT_NOTIFICATIONS_READ_URL = @json(route('tenant_notifications_read', ['id' => '__ID__']));
    window.TENANT_NOTIFICATIONS_READ_ALL_URL = @json(route('tenant_notifications_read_all'));
    window.TENANT_NOTIFICATIONS_POLL_MS = @json((int) config('tenant_panel.notifications_poll_ms', 15000));
</script>
<script src="{{ $panelAsset('js/tenant-notifications.js') }}?v=4"></script>
@if ($tcLayout['settings_extras'] ?? false)
<script src="{{ $panelAsset('js/tenant-select2.js') }}?v=1"></script>
@endif
<script src="{{ $panelAsset('js/tenant-panel-search.js') }}?v=1"></script>
<script>
    document.getElementById('tc-pn-menu-btn')?.addEventListener('click', function () {
        var menu = document.querySelector('.tc-tenant-nav .sm, .tc-compact-chrome .sm');
        if (menu) {
            menu.style.left = '0px';
        }
        this.setAttribute('aria-expanded', 'true');
    });
    document.querySelectorAll('.tc-tenant-nav .mobile-back').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var toggle = document.getElementById('tc-pn-menu-btn');
            if (toggle) {
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    });
</script>
@endauth
<!-- Plugin used-->
