<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('') }}auth/css/bootstrap.min.css">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('') }}auth/css/all.min.css"
        referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/logo/pinnacle-favicon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .bg-main {
            background-color: #000000;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #000000;
            /* Adjust background color as needed */
        }

        .min-vh-100 {
            min-height: 100vh;
            /* Minimum height of the viewport */
            margin-bottom: 70px;
            /* Adjust margin to create space for the footer */
        }

        .flex-fill {
            flex: 1;
            /* Makes this section grow to fill available space */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            /* Optional: add padding to the content */
        }

        .navbar-area.is-sticky {
            position: fixed;
            left: 0;
            width: 100%;
            z-index: 999;
            box-shadow: 0 2px 28px 0 rgba(0, 0, 0, 0.09);
            background-color: #fff !important;
            -webkit-animation: fadeInDown 0.5s ease-in-out 0s 1 normal none running;
            animation: fadeInDown 0.5s ease-in-out 0s 1 normal none running;
        }

        /* Adjust navbar height and add margin at the top */
        .navbar-area {
            margin-bottom: 20px;
            /* Space below the navbar */
        }
    </style>
    @yield('styles')
</head>

<body class="font-sans antialiased">

    <div id="navbar" class="navbar-area is-sticky">
        <div class="main-navbar">
            <div class="container">
                <nav class="bg-transparent navbar navbar-expand-lg navbar-light">
                    <div class="container d-flex justify-content-center align-items-center">
                        <a class="text-center navbar-brand" href="{{ route('/') }}">
                            <img src="{{ asset('') }}assets/logo/team_cabinets.jpg.jpg" alt="" style="width:250px;">
                            {{-- <img src="https://netopz.com/auth/logo/Netopz-Logo-blue.png" style="height:40px"
                                alt="logo"> --}}
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <section class="vh-100">
        <div class="min-vh-100 d-flex flex-column">
           <div class="m-0 m-md-5 flex-fill">
                @yield('content')
            </div>
            <footer class="footer">
                <div
                    class="px-4 py-4 text-center d-flex flex-column flex-md-row text-md-start justify-content-between px-xl-5 bg-main">
                    <div class="text-white mb-md-0">
                        {{-- Copyright © {{ date('Y') }}. Powered by <a href="https://netopz.com">NetOPZ.com</a>. --}}
                    </div>
                </div>
            </footer>
        </div>
    </section>
    <script src="{{ asset('') }}auth/js/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="{{ asset('') }}auth/js/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="{{ asset('') }}auth/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>
    <script src="{{ asset('') }}auth/js/jquery.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}
    @yield('scripts')
</body>

</html>
