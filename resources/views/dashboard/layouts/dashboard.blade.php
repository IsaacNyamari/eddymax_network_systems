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
    </style>

</head>

<body class="font-sans antialiased bg-gray-100" x-data="{ mobileMenuOpen: false, notificationsOpen: false }">
    <x-loader-component />
    <div class="min-h-screen flex">
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
                                class="{{ request()->routeIs('admin.messages') ? 'sidebar-active' : '' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md sidebar-hover">
                                <i class="fa fa-comments" aria-hidden="true"></i>
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
                        <a class="px-4 py-2 bg-green-500 hover:bg-green-600 hover:text-white capitalize rounded-lg"
                            href="{{ route('store.shop') }}"><i class="fa fa-globe" aria-hidden="true"></i>
                            website</a>
                    </div>

                    <!-- User Dropdown -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications Dropdown -->
                        <div class="relative" x-data="{ notificationsOpen: false }">
                            <button @click="notificationsOpen = !notificationsOpen"
                                class="relative p-1 text-gray-400 hover:text-gray-500 focus:outline-none">
                                <i class="fa fa-comments h-6 w-6" aria-hidden="true"></i>
                                <span
                                    class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
                            </button>
                            <!-- Notifications Dropdown Menu -->
                            <div x-show="notificationsOpen" @click.away="notificationsOpen = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-20 border border-gray-200">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <!-- Notification Items -->
                                    <a href="#"
                                        class="flex px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-blue-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm text-gray-900">New order received</p>
                                            <p class="text-xs text-gray-500">Order #ORD-1234 has been placed</p>
                                            <p class="text-xs text-gray-400 mt-1">2 minutes ago</p>
                                        </div>
                                    </a>

                                    <a href="#"
                                        class="flex px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-green-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm text-gray-900">Order shipped</p>
                                            <p class="text-xs text-gray-500">Your order #ORD-1233 has been shipped</p>
                                            <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                                        </div>
                                    </a>

                                    <a href="#"
                                        class="flex px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-yellow-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm text-gray-900">Payment reminder</p>
                                            <p class="text-xs text-gray-500">Payment for order #ORD-1232 is due in 2
                                                days</p>
                                            <p class="text-xs text-gray-400 mt-1">3 hours ago</p>
                                        </div>
                                    </a>

                                    <a href="#" class="flex px-4 py-3 hover:bg-gray-50">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-purple-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm text-gray-900">New promotion</p>
                                            <p class="text-xs text-gray-500">Summer sale starts tomorrow - 20% off all
                                                products</p>
                                            <p class="text-xs text-gray-400 mt-1">Yesterday</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="px-4 py-2 border-t border-gray-100">
                                    <a href="#"
                                        class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all
                                        notifications</a>
                                </div>
                            </div>
                        </div>

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
                        <a href="{{ route('admin.reports') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            Reports
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

    <script>
        document.getElementById('editor-description-container') ? document.addEventListener('DOMContentLoaded', function() {
            new WysiwygEditor('editor-description-container', {
                height: 200, // Optional: custom height
                placeholder: 'Enter description...' // Optional: placeholder
            });
        }) : '';
    </script>
    <script src="{{ asset('js/loader.js') }}"></script>
    @stack('scripts')
</body>

</html>
