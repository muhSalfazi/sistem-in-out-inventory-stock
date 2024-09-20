<!-- resources/views/layouts/app.blade.php -->
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Your Default Title')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('../assets/images/icon-kbi.png') }}" width="5%"
        alt="" />
    <!-- Include CSS and other resources -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/css/styles.min.css') }}" />

    @stack('head')

    <style>
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.998);
            /* Optional: semi-transparent background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* Ensure it is on top */
            opacity: 1;
            /* Make sure the loader is visible */
            transition: opacity 0.5s ease, visibility 0.5s ease;
            /* Smooth transition when fading out */
        }

        .loading.hidden {
            opacity: 0;
            visibility: hidden;
            /* Hide visibility for scroll */
        }

        /* Loader Animation */
        .pl {
            width: 6em;
            height: 6em;
        }

        /* Loader Animation */
        .pl {
            width: 6em;
            height: 6em;
        }

        .pl__ring {
            animation: ringA 2s linear infinite;
        }

        .pl__ring--a {
            stroke: #f42f25;
        }

        .pl__ring--b {
            animation-name: ringB;
            stroke: #f49725;
        }

        .pl__ring--c {
            animation-name: ringC;
            stroke: #255ff4;
        }

        .pl__ring--d {
            animation-name: ringD;
            stroke: #f42582;
        }

        /* Animations */
        @keyframes ringA {

            from,
            4% {
                stroke-dasharray: 0 660;
                stroke-width: 20;
                stroke-dashoffset: -330;
            }

            12% {
                stroke-dasharray: 60 600;
                stroke-width: 30;
                stroke-dashoffset: -335;
            }

            32% {
                stroke-dasharray: 60 600;
                stroke-width: 30;
                stroke-dashoffset: -595;
            }

            40%,
            54% {
                stroke-dasharray: 0 660;
                stroke-width: 20;
                stroke-dashoffset: -660;
            }

            62% {
                stroke-dasharray: 60 600;
                stroke-width: 30;
                stroke-dashoffset: -665;
            }

            82% {
                stroke-dasharray: 60 600;
                stroke-width: 30;
                stroke-dashoffset: -925;
            }

            90%,
            to {
                stroke-dasharray: 0 660;
                stroke-width: 20;
                stroke-dashoffset: -990;
            }
        }

        @keyframes ringB {

            from,
            12% {
                stroke-dasharray: 0 220;
                stroke-width: 20;
                stroke-dashoffset: -110;
            }

            20% {
                stroke-dasharray: 20 200;
                stroke-width: 30;
                stroke-dashoffset: -115;
            }

            40% {
                stroke-dasharray: 20 200;
                stroke-width: 30;
                stroke-dashoffset: -195;
            }

            48%,
            62% {
                stroke-dasharray: 0 220;
                stroke-width: 20;
                stroke-dashoffset: -220;
            }

            70% {
                stroke-dasharray: 20 200;
                stroke-width: 30;
                stroke-dashoffset: -225;
            }

            90% {
                stroke-dasharray: 20 200;
                stroke-width: 30;
                stroke-dashoffset: -305;
            }

            98%,
            to {
                stroke-dasharray: 0 220;
                stroke-width: 20;
                stroke-dashoffset: -330;
            }
        }

        @keyframes ringC {
            from {
                stroke-dasharray: 0 440;
                stroke-width: 20;
                stroke-dashoffset: 0;
            }

            8% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -5;
            }

            28% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -175;
            }

            36%,
            58% {
                stroke-dasharray: 0 440;
                stroke-width: 20;
                stroke-dashoffset: -220;
            }

            66% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -225;
            }

            86% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -395;
            }

            94%,
            to {
                stroke-dasharray: 0 440;
                stroke-width: 20;
                stroke-dashoffset: -440;
            }
        }

        @keyframes ringD {

            from,
            8% {
                stroke-dasharray: 0 440;
                stroke-width: 20;
                stroke-dashoffset: 0;
            }

            16% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -5;
            }

            36% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -175;
            }

            44%,
            50% {
                stroke-dasharray: 0 440;
                stroke-width: 20;
                stroke-dashoffset: -220;
            }

            58% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -225;
            }

            78% {
                stroke-dasharray: 40 400;
                stroke-width: 30;
                stroke-dashoffset: -395;
            }

            86%,
            to {
                stroke-dasharray: 0 440;
                stroke-width: 20;
                stroke-dashoffset: -440;
            }
        }

        /* Add your existing CSS here... */
        /* Same loader animation CSS as before */
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Hide loader after page load
        $(window).on('load', function() {
            $('.loading').addClass('hidden'); // Add hidden class to fade out
            setTimeout(() => {
                $('.loading').remove(); // Remove loader from DOM after fade out
            }, 500); // Match this time with the CSS transition duration
        });
    </script>
</head>

<body>
    <!-- Loader -->
    <div class="loading">
        <svg class="pl" width="240" height="240" viewBox="0 0 240 240">
            <circle class="pl__ring pl__ring--a" cx="120" cy="120" r="105" fill="none" stroke="#000"
                stroke-width="20" stroke-dasharray="0 660" stroke-dashoffset="-330" stroke-linecap="round"></circle>
            <circle class="pl__ring pl__ring--b" cx="120" cy="120" r="35" fill="none" stroke="#000"
                stroke-width="20" stroke-dasharray="0 220" stroke-dashoffset="-110" stroke-linecap="round"></circle>
            <circle class="pl__ring pl__ring--c" cx="85" cy="120" r="70" fill="none" stroke="#000"
                stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
            <circle class="pl__ring pl__ring--d" cx="155" cy="120" r="70" fill="none" stroke="#000"
                stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
        </svg>
    </div>

    @include('layouts.head')

    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar Start -->
        @include('layouts.sidebar')
        <!-- Sidebar End -->

        <!-- Main Wrapper Start -->
        <div class="body-wrapper">
            <!-- Header Start -->
            @include('layouts.header')
            <!-- Header End -->

            <!-- Main Content Start -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- Main Content End -->

            <!-- Footer Start -->
            @include('layouts.footer')
            <!-- Footer End -->
        </div>
        <!-- Main Wrapper End -->
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
