<!-- latest jquery-->
<script src="{{asset('assets/main/js/jquery.min.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{asset('assets/main/js/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('assets/main/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<!-- feather icon js-->
<script src="{{asset('assets/main/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{asset('assets/main/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{asset('assets/main/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/main/js/config.js')}}"></script>
<!-- Plugins JS start-->
<script src="{{asset('assets/main/js/prism/prism.min.js')}}"></script>
<script src="{{asset('assets/main/js/clipboard/clipboard.min.js')}}"></script>
<script src="{{asset('assets/main/js/custom-card/custom-card.js')}}"></script>
<script src="{{asset('assets/main/js/chat-menu.js')}}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{asset('assets/main/js/script.js')}}"></script>
<script src="{{asset('assets/main/js/theme-customizer/customizer.js')}}"></script>
<script src="{{asset('assets/main/js/jquery.drilldown.js')}}"></script>
<script src="{{asset('assets/main/js/vertical-menu.js')}}"></script>
<script src="{{asset('assets/main/js/megamenu.js')}}"></script>
<script src="{{asset('assets/main/js/megamenu.js')}}"></script>
<script src="{{ asset('js/password-toggle.js') }}?v=1"></script>
<script src="{{ asset('js/admin-table-mobile.js') }}?v=1"></script>
<script src="{{ asset('js/pinnacle-admin-mobile.js') }}?v=1"></script>
<!-- login js-->
@yield('script')
@include('partials.cloudflare-turnstile-scripts')
<!-- Plugin used-->
