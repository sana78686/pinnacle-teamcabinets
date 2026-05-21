<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Poco admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Poco admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5-premium-features/46.0.0/ckeditor5-premium-features.css" />
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5-premium-features/46.0.0/ckeditor5-premium-features.css" />
     <!-- CKEditor Core Content Styles -->
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/46.0.0/ckeditor5.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="icon" href="{{ dynamic_url('assets/logo/pinnacle-favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ dynamic_url('assets/logo/pinnacle-favicon.png') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    @include('layouts.tenant.css')
    <style>
        .table-sm th,
        .table-sm td {
            padding: .75rem;
            font-size: 90%;
        }

        body {
            font-family: ;
        }
    </style>
    @yield('style')
    @yield('head')
</head>

<body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="typewriter">
            <h1>Pinnacle Admin Tenant Dashboard Loading..</h1>
        </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper vertical tc-panel-shell">
        <div class="tc-chrome tc-compact-chrome tc-sticky-top">
            @include('layouts.tenant.header')
            @include('layouts.tenant.admin_sidebar')
        </div>
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Right sidebar Start-->
            @include('layouts.tenant.chat_sidebar')
            <!-- Right sidebar Ends-->
            <div class="page-body tc-form-page p-0">
                @auth
                    @include('layouts.tenant.partials.trial-marquee')
                @endauth
                <div class="container-fluid">
                    @php
                        $tcShowPageHeader = View::hasSection('breadcrumb-title')
                            || View::hasSection('breadcrumb-items')
                            || ! empty($tcFrontendUrl ?? null);
                    @endphp
                    @if ($tcShowPageHeader)
                        <div class="page-header tc-page-header-row pb-0 pt-1">
                            <div class="row align-items-center">
                                <div class="col-lg-6 main-header">
                                    <div class="tc-page-header-heading">
                                        @hasSection('breadcrumb-title')
                                            @yield('breadcrumb-title')
                                        @endif
                                        @if (! empty($tcFrontendUrl))
                                            @hasSection('breadcrumb-title')
                                                <span class="tc-page-header-sep" aria-hidden="true">—</span>
                                            @endif
                                            @include('layouts.tenant.partials.storefront-link-inline')
                                        @endif
                                    </div>
                                    @hasSection('breadcrumb-subtitle')
                                        <h6 class="mb-0 txt-muted">@yield('breadcrumb-subtitle')</h6>
                                    @endif
                                </div>
                                @hasSection('breadcrumb-items')
                                    <div class="col-lg-6 breadcrumb-right">
                                        <ol class="breadcrumb justify-content-lg-end mb-0">
                                            <li class="breadcrumb-item"><a href="{{ route('tenant_dashboard') }}"><i class="pe-7s-home"></i></a></li>
                                            @yield('breadcrumb-items')
                                        </ol>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Container-fluid starts-->
                @yield('content')
                <!-- Container-fluid Ends-->
            </div>
        </div>
    </div>
    @include('layouts.tenant.script')
</body>

</html>
