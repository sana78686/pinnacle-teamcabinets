<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Create Order') — {{ tenant('company_name') ?? tenant('name') ?? config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ tenant_asset('assets/main/css/fontawesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ tenant_asset('assets/main/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ tenant_asset('assets/main/css/style.css') }}">
    <link rel="stylesheet" href="{{ tenant_asset('css/pinnacle-theme.css') }}?v=10">
    <link rel="stylesheet" href="{{ tenant_asset('css/tenant-forms.css') }}?v=8">
    <link rel="stylesheet" href="{{ tenant_asset('css/create-order.css') }}?v=8">
    <link rel="stylesheet" href="{{ tenant_asset('css/tenant-panel.css') }}?v=34">
    <link rel="stylesheet" href="{{ tenant_asset('css/order-workspace.css') }}?v=11">
    <link rel="stylesheet" href="{{ tenant_asset('css/tenant-order-theme.css') }}?v=1">
    @yield('style')
    @stack('head')
</head>
<body class="ow-standalone-body tc-order-workspace tc-form-page">
    @yield('content')
    <script src="{{ tenant_asset('assets/main/js/jquery-3.5.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('script')
    @stack('scripts')
</body>
</html>
