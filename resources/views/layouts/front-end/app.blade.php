<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        /* Ensure dropdown stays centered */
        .lg\\:fixed {
            position: fixed !important;
        }

        /* Prevent body scroll when dropdown is open on mobile */
        body:has(.fixed[x-show="open"][style*="display: block"]) {
            overflow: hidden;
        }

        h1,h2,h3,h4,h5,h6 {
            font-family: 'Algerian', serif !important;
        }

        /* Responsive adjustments */
        @media (max-width: 1023px) {
            .fixed[x-show="open"][style*="display: block"] {
                position: fixed !important;
                top: 20px !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
                max-height: 85vh;
                overflow-y: auto;
            }
        }

        /* Desktop specific */
        @media (min-width: 1024px) {
            .lg\\:left-1\\/2 {
                left: 50% !important;
            }

            .lg\\:top-20 {
                top: 80px !important;
            }
        }


        /* Hover effects for main nav links */

        nav button:hover {
            background-color: transparent !important;
        }

        /* Optional: Add a subtle background transition for the entire nav item */
        .group:hover {
            background-color: rgba(185, 28, 28, 0.1);
            /* maroon with 10% opacity */
            border-radius: 0.5rem;
        }

        /* Fix for SVG icons in dropdown links */
        a:hover svg {
            color: white !important;
        }

        .bg-red-600 {
            background: rgba(128, 0, 0, 0.8) !important;
        }

        .bg-red-500 {
            background: rgba(128, 0, 0, 0.541) !important;
        }

        .text-red-600 {
            color: rgba(128, 0, 0, 0.541) !important;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <livewire:navigation />
        <x-main-nav />
        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
        @include('layouts.front-end.footer')
    </div>
    @livewireScripts
    <script>
        new Swiper('.categorySwiper', {
            loop: true,
            spaceBetween: 24,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            autoplay: {
                delay: 3000, // 3 seconds per slide
                disableOnInteraction: false, // continues autoplay after user interaction
            },
            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                640: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 4
                },
            }
        });
    </script>

</body>

</html>
