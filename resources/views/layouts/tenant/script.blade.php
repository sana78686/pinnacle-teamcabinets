<script src="{{asset('assets/main/js/jquery-3.5.1.min.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{asset('assets/main/js/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('assets/main/js/bootstrap/bootstrap.js')}}"></script>
<!-- feather icon js-->
<script src="{{asset('assets/main/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{asset('assets/main/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{asset('assets/main/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/main/js/config.js')}}"></script>
<!-- Plugins JS start-->
@yield('script')
<script src="{{asset('assets/main/js/chat-menu.js')}}"></script>
<script src="{{asset('assets/main/js/prism/prism.min.js')}}"></script>
<script src="{{asset('assets/main/js/clipboard/clipboard.min.js')}}"></script>
<script src="{{asset('assets/main/js/custom-card/custom-card.js')}}"></script>
<script src="{{asset('assets/main/js/tooltip-init.js')}}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{asset('assets/main/js/script.js')}}"></script>
{{-- <script src="{{asset('assets/main/js/theme-customizer/customizer.js')}}"></script> --}}
<script src="{{asset('assets/main/js/jquery.drilldown.js')}}"></script>
<script src="{{asset('assets/main/js/vertical-menu.js')}}"></script>
<script src="{{asset('assets/main/js/megamenu.js')}}"></script>


{{-- Others --}}
<script src="{{asset('assets/main/js/tooltip-init.js')}}"></script>
<script src="{{route('/')}}/assets/main/js/sweet-alert/sweetalert.min.js"></script>
<script src="{{route('/')}}/assets/main/js/sweet-alert/app.js"></script>

{{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
{{-- <script src="https://cdn.datatables.net/2.2.0/js/dataTables.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/2.2.0/js/dataTables.bootstrap5.js"></script> --}}


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{--Theme: these 2 For showing listing filters --}}
{{-- <script src="{{ route('/') }}/assets/main/js/datatable/datatables/datatable.custom.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatables/jquery.dataTables.min.js"></script> --}}

{{-- jquery filters with search --}}
{{-- <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.3.3/js/dataTables.searchPanes.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.3.3/js/searchPanes.dataTables.js"></script>
<script src="https://cdn.datatables.net/select/3.0.0/js/dataTables.select.js"></script>
<script src="https://cdn.datatables.net/select/3.0.0/js/select.dataTables.js"></script> --}}

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>window.TENANT_FIELD_TIPS = @json(config('tenant_field_tips', []));</script>
<script src="{{ asset('js/tenant-tooltips.js') }}?v=3"></script>
<script src="{{ asset('js/tenant-settings-forms.js') }}?v=2"></script>
<script src="{{ asset('js/tenant-settings-layout.js') }}?v=1"></script>
@auth
<script>
    window.TENANT_NOTIFICATIONS_POLL_URL = @json(route('tenant_notifications_poll'));
    window.TENANT_NOTIFICATIONS_READ_URL = @json(route('tenant_notifications_read', ['id' => '__ID__']));
    window.TENANT_NOTIFICATIONS_READ_ALL_URL = @json(route('tenant_notifications_read_all'));
    window.TENANT_NOTIFICATIONS_POLL_MS = 45000;
</script>
<script src="{{ asset('js/tenant-notifications.js') }}?v=2"></script>
<script src="{{ asset('js/tenant-select2.js') }}?v=1"></script>
@endauth
<!-- Plugin used-->
