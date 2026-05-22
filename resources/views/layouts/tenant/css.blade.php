@php($tcLayout = $tcLayout ?? tenant_layout_flags())
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<!-- Font Awesome-->
<link rel="stylesheet" type="text/css" href="{{tenant_panel_asset('assets/main/css/fontawesome.css')}}">
<!-- ico-font-->
<link rel="stylesheet" type="text/css" href="{{tenant_panel_asset('assets/main/css/icofont.css')}}">
<!-- Themify icon-->
<link rel="stylesheet" type="text/css" href="{{tenant_panel_asset('assets/main/css/themify.css')}}">
<!-- Feather icon-->
<link rel="stylesheet" type="text/css" href="{{tenant_panel_asset('assets/main/css/feather-icon.css')}}">
<!-- Plugins css start-->
@yield('css')
<link rel="stylesheet" type="text/css" href="{{tenant_panel_asset('assets/main/css/vertical-menu.css')}}">
<link rel="stylesheet" type="text/css" href="{{tenant_panel_asset('assets/main/css/pe7-icon.css')}}">
<!-- Plugins css Ends-->
<!-- Bootstrap css-->
<link rel="stylesheet" type="text/css" href="{{tenant_panel_asset('assets/main/css/bootstrap.css')}}">
<!-- App css-->
<link rel="stylesheet" type="text/css" href="{{tenant_panel_asset('assets/main/css/style.css')}}">
<link id="color" rel="stylesheet" href="{{tenant_panel_asset('assets/main/css/color-6.css')}}" media="screen">
<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="{{tenant_panel_asset('assets/main/css/responsive.css')}}">

{{-- Others --}}

<link rel="stylesheet" type="text/css" href="{{ tenant_panel_asset('assets/main/css/sweetalert2.css') }}">

  <style>
  /* Compact UI text — form labels/inputs use tenant-forms.css instead */
  .page-wrapper span,
  .page-wrapper p,
  .page-wrapper h1, .page-wrapper h2, .page-wrapper h3,
  .page-wrapper h4, .page-wrapper h5, .page-wrapper h6,
  .page-wrapper a,
  .page-wrapper li,
  .page-wrapper td,
  .page-wrapper th,
  .page-main-header label,
  .vertical-menu-main label,
  .breadcrumb-item {
    font-size: 0.75rem !important;
    line-height: 1.25 !important;
  }
</style>
@if ($tcLayout['settings_extras'] ?? false)
<link rel="stylesheet" href="{{ tenant_panel_asset('css/tenant-tooltips.css') }}?v=1">
@endif
<link rel="stylesheet" href="{{ tenant_panel_asset('css/tenant-forms.css') }}?v=8">
<link rel="stylesheet" href="{{ tenant_panel_asset('css/pinnacle-theme.css') }}?v=10">
<link rel="stylesheet" href="{{ tenant_panel_asset('css/tenant-panel.css') }}?v=37">
