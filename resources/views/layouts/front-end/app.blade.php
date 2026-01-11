<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- web app --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#6777ef">

    <title>{{ config('app.name', 'Edymax Systems & Networks') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/edymax-logo-bg.jpeg') }}" type="image/*">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/css/bootstrap.min.css"
        integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/js/bootstrap.bundle.min.js"
        integrity="sha512-HvOjJrdwNpDbkGJIG2ZNqDlVqMo77qbs4Me4cah0HoDrfhrbA+8SBlZn1KrvAQw7cILLPFJvdwIgphzQmMm+Pw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/zoom.css') }}">
    <style>
        /* Ensure dropdown stays centered */
        .lg\\:fixed {
            position: fixed !important;
        }

        /* Prevent body scroll when dropdown is open on mobile */
        body:has(.fixed[x-show="open"][style*="display: block"]) {
            overflow: hidden;
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

        .slide-out {
            animation: slideInUp 0.5s forwards;
        }

        .slide-in {
            animation: slideInDown 0.5s forwards;
        }

        @keyframes slideInDown {
            0% {
                transform: translateX(350px)
            }

            100% {
                transform: translateX(0)
            }
        }

        @keyframes slideInUp {
            0% {
                transform: translateX(0)
            }

            100% {
                transform: translateX(350px)
            }
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50">
    <x-loader-component />
    <!-- Cart Alert Notification -->
    <div id="cartAlert"
        class="alert bg-gradient-to-r from-blue-600 to-indigo-600 text-white hidden border-l-4 border-blue-800 shadow-lg px-4 py-3 fixed z-50 transition-all duration-300 transform -translate-y-full right-0 left-0 mx-4 top-4 rounded-xl md:w-96 md:left-auto md:right-4 md:mx-0 md:top-6"
        role="alert" aria-live="polite" aria-atomic="true">
        <div class="flex items-start">
            <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            <div class="flex-1">
                <p class="font-medium text-sm md:text-base cart-alert-message"></p>
            </div>
            <button onclick="closeCartAlert()" class="ml-4 text-white/80 hover:text-white focus:outline-none"
                aria-label="Close notification">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col bg-white">
        <!-- Navigation -->
        <div class="sticky top-0 z-40 w-full bg-white shadow-sm">
            <x-main-nav />
            <livewire:welcome.navigation />
        </div>

        <!-- Conditional Page Header -->
        @if (isset($header))
            <header class="bg-white border-b border-gray-200">
                <div class="w-full px-4 py-4 mx-auto sm:px-6 lg:px-8 max-w-screen-2xl">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endif

        <!-- Main Content Area -->
        <main class="flex-1 w-full overflow-hidden">
            <!-- Container with responsive padding -->
            <div
                class="w-full h-full px-3 py-4 mx-auto sm:px-4 sm:py-5 md:px-5 md:py-6 lg:px-6 lg:py-8 max-w-screen-2xl">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-auto bg-gray-900 text-white">
            @include('layouts.front-end.footer')
        </footer>

        <!-- Overlay for modals/drawers -->
        @yield('overlay')
    </div>

    @livewireScripts
    <script src="{{ asset('js/loader.js') }}"></script>
    <script>
        // Cart Alert Management
        const cartAlert = document.getElementById('cartAlert');
        const cartAlertMessage = document.querySelector('.cart-alert-message');

        // Function to close alert manually
        function closeCartAlert() {
            cartAlert.classList.remove('translate-y-0', 'opacity-100');
            cartAlert.classList.add('-translate-y-full', 'opacity-0');
            setTimeout(() => {
                cartAlert.classList.add('hidden');
            }, 300);
        }

        // Livewire event listener for cart actions
        Livewire.on('added-to-cart', (data) => {
            if (data[0] && data[0].message) {
                // Update message
                cartAlertMessage.textContent = data[0].message;

                // Show alert with animation
                cartAlert.classList.remove('hidden', '-translate-y-full', 'opacity-0');
                cartAlert.classList.add('translate-y-0', 'opacity-100');

                // Auto-hide after 5 seconds
                setTimeout(closeCartAlert, 5000);

                // Announce to screen readers
                announceToScreenReader(data[0].message);
            }
        });

        // Livewire event listener for errors
        Livewire.on('cart-error', (data) => {
            if (data[0] && data[0].message) {
                // Change styling for error
                cartAlert.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-indigo-600', 'border-blue-800');
                cartAlert.classList.add('bg-gradient-to-r', 'from-red-600', 'to-rose-600', 'border-red-800');

                // Update message
                cartAlertMessage.textContent = data[0].message;

                // Show alert with animation
                cartAlert.classList.remove('hidden', '-translate-y-full', 'opacity-0');
                cartAlert.classList.add('translate-y-0', 'opacity-100');

                // Auto-hide after 5 seconds
                setTimeout(() => {
                    closeCartAlert();
                    // Reset styling
                    cartAlert.classList.remove('bg-gradient-to-r', 'from-red-600', 'to-rose-600',
                        'border-red-800');
                    cartAlert.classList.add('bg-gradient-to-r', 'from-blue-600', 'to-indigo-600',
                        'border-blue-800');
                }, 5000);

                // Announce to screen readers
                announceToScreenReader(data[0].message);
            }
        });

        // Accessibility: Announce messages to screen readers
        function announceToScreenReader(message) {
            const announcement = document.getElementById('sr-announcement');
            if (!announcement) {
                const srDiv = document.createElement('div');
                srDiv.id = 'sr-announcement';
                srDiv.className = 'sr-only';
                srDiv.setAttribute('aria-live', 'polite');
                srDiv.setAttribute('aria-atomic', 'true');
                document.body.appendChild(srDiv);
            }
            document.getElementById('sr-announcement').textContent = message;
        }

        // Touch gesture support for mobile
        let touchStartY = 0;
        let touchEndY = 0;

        document.addEventListener('touchstart', e => {
            touchStartY = e.changedTouches[0].screenY;
        });

        document.addEventListener('touchend', e => {
            touchEndY = e.changedTouches[0].screenY;
            // If swiping up on alert, close it
            if (touchEndY < touchStartY - 50 && !cartAlert.classList.contains('hidden')) {
                closeCartAlert();
            }
        });

        // Handle escape key to close alert
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && !cartAlert.classList.contains('hidden')) {
                closeCartAlert();
            }
        });

        // Responsive breakpoint detection (optional)
        function handleResponsiveChanges() {
            const width = window.innerWidth;

            // Adjust alert position based on screen size
            if (width < 768) {
                // Mobile: alert takes full width with margin
                cartAlert.classList.remove('md:w-96', 'md:left-auto', 'md:right-4');
                cartAlert.classList.add('left-0', 'right-0', 'mx-4');
            } else {
                // Desktop: fixed width and position
                cartAlert.classList.add('md:w-96', 'md:left-auto', 'md:right-4');
                cartAlert.classList.remove('left-0', 'right-0', 'mx-4');
            }
        }

        // Initialize on load
        window.addEventListener('DOMContentLoaded', handleResponsiveChanges);
        window.addEventListener('resize', handleResponsiveChanges);

        // Handle Livewire navigation events
        document.addEventListener('livewire:navigating', () => {
            closeCartAlert();
        });
    </script>

    <!-- Additional CSS for responsiveness -->
    <style>
        /* Base responsive styles */
        @media (max-width: 640px) {
            html {
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {

            /* Improve touch targets on mobile */
            button,
            a,
            [role="button"] {
                min-height: 44px;
                min-width: 44px;
            }

            /* Prevent horizontal overflow */
            img,
            video,
            iframe {
                max-width: 100%;
                height: auto;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .dark body {
                background-color: #111827;
                color: #f9fafb;
            }

            .dark .bg-white {
                background-color: #1f2937;
            }

            .dark .bg-gray-100 {
                background-color: #111827;
            }

            .dark .text-gray-900 {
                color: #f9fafb;
            }
        }

        /* Print styles */
        @media print {

            .alert,
            .sticky {
                display: none !important;
            }

            body {
                background: white !important;
                color: black !important;
            }
        }

        /* Reduced motion preference */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* High contrast mode */
        @media (prefers-contrast: high) {
            .alert {
                border-width: 3px;
            }

            button,
            a {
                text-decoration: underline;
            }
        }

        /* Custom scrollbar for desktop */
        @media (min-width: 768px) {
            ::-webkit-scrollbar {
                width: 10px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 5px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
        }

        /* Safe area insets for modern mobile devices */
        @supports (padding: max(0px)) {
            body {
                padding-left: min(0px, env(safe-area-inset-left));
                padding-right: min(0px, env(safe-area-inset-right));
                padding-top: min(0px, env(safe-area-inset-top));
                padding-bottom: min(0px, env(safe-area-inset-bottom));
            }

            .alert {
                margin-top: max(1rem, env(safe-area-inset-top));
            }
        }
    </style>
    <script src="{{ asset('js/zoom.js') }}"></script>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js');
        }
    </script>
    @include('cookie-consent::index')
</body>

</html>
