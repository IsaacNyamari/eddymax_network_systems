<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Edymax Systems and Networks') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    {{-- app icon --}}
    <link rel="icon" href="{{ asset('images/edymax-logo-bg.jpeg') }}" type="image/x-icon" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    {{-- sweetalert.js --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
    <!-- Additional Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
    <style>
        .sidebar-active {
            background-color: #f3f4f6;
            color: #111827;
            border-left: 4px solid #ef4444;
        }

        .sidebar-hover:hover {
            background-color: #f9fafb;
        }

        .quill-small .ql-editor {
            min-height: 120px;
            /* small */
            max-height: 120px;
            overflow-y: auto;
        }

        .alert {
            animation: slideIn 1s forwards linear;
        }

        @keyframes slideIn {
            0% {
                right: -600px
            }

            100% {
                right: 10px
            }
        }
    </style>

</head>

<body class="font-sans antialiased bg-gray-100" x-data="{ mobileMenuOpen: false, notificationsOpen: false }">
    @if (!request()->routeIs('dashboard'))
        <x-loader-component />
    @endif
    <div class="min-h-screen flex">
        <div class="alertDiv fixed flex flex-column z-50 right-10 top-10">
            <x-info-alert />
            <x-success-alert />
            <x-error-alert />
        </div><!-- Add this to your main layout file, before closing body tag -->
        <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-3 w-80 sm:w-96"></div>
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow pt-5 bg-white overflow-y-auto border-r">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-4">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-900">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <!-- Navigation -->
                <div class="mt-5 flex-grow flex flex-col">
                    <nav class="flex-1 px-2 space-y-1">
                        <!-- Dashboard Link -->
                        <a href="{{ route('dashboard') }}"
                            class="{{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>

                        <!-- Customer Links -->
                        @hasrole('customer')
                            <a href="{{ route('customer.my-wishlist.index') }}"
                                class="{{ request()->routeIs('customer.my-wishlist.*') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                                <i class="fa fa-heart mr-3 h-5 w-5" aria-hidden="true"></i>
                                My Wishlist
                            </a>
                            <a href="{{ route('customer.orders.index') }}"
                                class="{{ request()->routeIs('customer.orders.*') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                My Orders
                            </a>

                            <a href="{{ route('customer.profile.edit') }}"
                                class="{{ request()->routeIs('customer.profile.*') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                        @endhasrole

                        <!-- Admin Links -->
                        @hasrole('admin')
                            <div class="px-3 pt-4">
                                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Admin Panel
                                </h3>
                            </div>

                            <a href="{{ route('admin.orders.index') }}"
                                class="{{ request()->routeIs('admin.orders.*') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Orders
                            </a>

                            <a href="{{ route('admin.products.index') }}"
                                class="{{ request()->routeIs('admin.products.*') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                Products
                            </a>
                            <!-- Brands Menu Item -->
                            <a href="{{ route('admin.brands.index') }}"
                                class="{{ request()->routeIs('admin.brands.*') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                                Brands
                            </a>
                            <a href="{{ route('admin.users.index') }}"
                                class="{{ request()->routeIs('admin.users.*') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.9 0-1.7.2-2.4.5l-.6.9-1.1-.3c-.3 0-.6.1-.8.3l-.9.8-1.1-.2c-.3 0-.5 0-.8.1l-1.1.1" />
                                </svg>
                                Customers
                            </a>

                            <a href="{{ route('admin.categories.index') }}"
                                class="{{ request()->routeIs('admin.categories.*') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Categories
                            </a>

                            <a href="{{ route('admin.messages.index') }}"
                                class="{{ request()->routeIs('admin.messages.*') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                                <i class="fa fa-comments mr-3" aria-hidden="true"></i>
                                Messages
                            </a>
                            <a href="{{ route('admin.reports') }}"
                                class="{{ request()->routeIs('admin.reports') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Reports
                            </a>
                            <a href="{{ route('admin.settings') }}"
                                class="{{ request()->routeIs('admin.settings') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                                <i class="fas fa-cogs mr-3"></i>
                                Settings
                            </a>
                        @endhasrole
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow">
                <div class="flex justify-between items-center px-4 py-3 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-2">
                        <!-- Mobile menu button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden mr-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="text-lg font-semibold text-gray-900">
                            @yield('title', 'Dashboard')
                        </h1>
                        <a class="px-4 py-2 bg-green-500 hover:bg-green-600 hover:text-white capitalize rounded-lg hidden md:inline-block"
                            href="{{ route('store.shop') }}">
                            <i class="fa fa-globe" aria-hidden="true"></i> website
                        </a>
                    </div>

                    <!-- User Dropdown -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route(Auth::user()->roles->first()->name . '.notifications') }}"
                            class="relative p-2 text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                            <span class="sr-only">Open notifications</span>
                            <i class="fa fa-bell fa-lg" aria-hidden="true"></i>

                            @php $count = Auth::user()->notifications()->whereNull('read_at')->count(); @endphp

                            @if ($count > 0)
                                <span
                                    class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-semibold leading-none text-white bg-red-600 rounded-full shadow-md ring-2 ring-white transform-gpu will-change-transform animate-pulse">
                                    {{ $count > 99 ? '99+' : $count }}
                                </span>
                            @else
                                <span
                                    class="absolute -top-1 -right-1 inline-block h-2 w-2 bg-gray-300 rounded-full ring-2 ring-white"></span>
                            @endif
                        </a>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </span>
                                </div>
                                <span class="hidden md:block text-sm font-medium text-gray-700">
                                    {{ auth()->user()->name }}
                                </span>
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200">
                                @hasrole('customer')
                                    <a href="{{ route('customer.profile.edit') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Profile Settings
                                    </a>
                                @endhasrole
                                @hasrole('admin')
                                    <a href="{{ route('admin.settings') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Admin Settings
                                    </a>
                                @endhasrole
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Mobile Sidebar (hidden by default) -->
            <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="md:hidden bg-white shadow-lg">
                <!-- Mobile navigation content -->
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                        Dashboard
                    </a>
                    @hasrole('customer')
                        <a href="{{ route('customer.orders.index') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            My Orders
                        </a>
                        <a href="{{ route('customer.profile.edit') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            Profile
                        </a>
                    @endhasrole
                    @hasrole('admin')
                        <div class="px-3 pt-2">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Admin Panel
                            </h3>
                        </div>
                        <a href="{{ route('admin.orders.index') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            Orders
                        </a>
                        <a href="{{ route('admin.products.index') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            Products
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            Customers
                        </a>
                        <a href="{{ route('admin.categories.index') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            Categories
                        </a>
                        <a href="{{ route('admin.messages.index') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            Messages
                        </a>
                        <a href="{{ route('admin.reports') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            Reports
                        </a>
                        <a href="{{ route('admin.settings') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            Settings
                        </a>
                    @endhasrole
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <!-- Page Heading -->
                @hasSection('header')
                    <div class="mb-6">
                        @yield('header')
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>
    @livewireScripts
    <script src="{{ asset('js/toast.js') }}"></script>
    <script>
        let alertDiv = document.querySelectorAll('.alertDiv');
        let alertSuccess = document.getElementById('alertSuccess');
        let messageSuccess = document.getElementById('messageSuccess');
        document.addEventListener('DOMContentLoaded', () => {
            if (!window.Echo) {
                console.error('Echo is not loaded!');
                return;
            }
            document.getElementById('editor-description-container') ? document.addEventListener('DOMContentLoaded',
                function() {
                    new WysiwygEditor('editor-description-container', {
                        height: 200, // Optional: custom height
                        placeholder: 'Enter description...' // Optional: placeholder
                    });
                }) : '';
            // Minimal version
            Echo.private('order-update.' + {{ auth()->id() }})
                .listen('.order.update', (e) => {
                    // Simple toast call
                    simpleToast(`${e.message}`);
                });

            function simpleToast(text) {
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 z-50 bg-white p-4 rounded shadow-lg border w-fit';
                toast.innerHTML = `
        <div class="flex items-center w-fit">
            <div class="text-blue-500 mr-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-gray-800 w-fit text-wrap">${text}</p>
            <button class="ml-4 text-gray-400" onclick="this.parentElement.parentElement.remove()">×</button>
        </div>
    `;

                document.body.appendChild(toast);

                setTimeout(() => {
                    if (toast.parentElement) toast.remove();
                }, 4000);
            }
            window.Echo.private('admin.orders')
                .listen('.new.order', (e) => {
                    // e.order_id, e.customer_name, etc.

                    // Show notification

                    let message = `New order #${e.order_number} from ${e.customer_name}`;

                    if (!("Notification" in window)) {
                        // Check if the browser supports notifications
                        alert("This browser does not support desktop notification");
                    } else if (Notification.permission === "granted") {
                        // Check whether notification permissions have already been granted;
                        // if so, create a notification
                        const notification = new Notification(message);
                        // …
                    } else if (Notification.permission !== "denied") {
                        // We need to ask the user for permission
                        Notification.requestPermission().then((permission) => {
                            // If the user accepts, let's create a notification
                            if (permission === "granted") {
                                const notification = new Notification(message);
                                // …
                            }
                        });
                    }
                })

        })
    </script>
    @if (!request()->routeIs('dashboard'))
        <script src="{{ asset('js/loader.js') }}"></script>
    @endif
    @stack('scripts')
</body>

</html>
