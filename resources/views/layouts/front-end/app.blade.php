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

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @php
            $parents = App\Models\Category::with(['children.children'])
                ->whereNull('parent_id')
                ->orderBy('name')
                ->limit(10)
                ->get();
        @endphp
        <div class="bg-red-900">
            <nav class="bg-gradient-to-r from-maroon-50 to-rose-50 border-b border-maroon-100 shadow-sm"
                x-data="{ mobileMenuOpen: false }">

                <div class="container mx-auto px-4">
                    {{-- Mobile Menu Button --}}
                    <div class="flex justify-between items-center py-3 lg:hidden">
                        <div class="text-xl font-bold text-maroon-800">Logo</div>
                        <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="p-2 rounded-lg text-slate-700 hover:text-maroon-800 hover:bg-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16">
                                </path>
                            </svg>
                        </button>
                    </div>

                    {{-- Desktop & Mobile Menu --}}
                    <div :class="{ 'block': mobileMenuOpen, 'hidden lg:block': !mobileMenuOpen }">
                        <ul
                            class="flex flex-col lg:flex-row lg:flex-wrap lg:justify-center lg:items-center lg:space-x-1 space-y-2 lg:space-y-0 py-2 lg:py-0">

                            {{-- Home --}}
                            <li class="group">
                                <a href="{{ url('/') }}"
                                    class="flex items-center px-4 lg:px-5 py-3 rounded-lg transition-all duration-300 
                              text-slate-700 hover:text-maroon-800 hover:bg-white 
                              group-hover:shadow-sm group-hover:-translate-y-0.5
                              font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                        </path>
                                    </svg>
                                    Home
                                </a>
                            </li>

                            {{-- Dynamic Categories --}}
                            @foreach ($parents as $parent)
                                <li class="relative group lg:static" x-data="{ open: false }"
                                    @mouseenter="open = true"
                                    @mouseleave="open = false">

                                    {{-- Parent link with mobile toggle --}}
                                    <button type="button" @click="open = !open"
                                        @mouseenter="open = true"
                                        class="flex items-center justify-between w-full lg:w-auto px-4 lg:px-5 py-3 rounded-lg transition-all duration-300
                                       text-slate-700 hover:text-maroon-800 hover:bg-white
                                       group-hover:shadow-sm group-hover:-translate-y-0.5
                                       font-medium text-left lg:text-center">
                                        <span class="flex items-center">
                                            {{ $parent->name }}
                                            @if ($parent->children->count())
                                                <svg class="w-3 h-3 ml-1.5 transition-transform duration-300"
                                                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            @endif
                                        </span>
                                    </button>

                                    {{-- Dropdown --}}
                                    @if ($parent->children->count())
                                        <div x-show="open" x-cloak
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 lg:translate-y-1"
                                            x-transition:enter-end="opacity-100 lg:translate-y-0"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 lg:translate-y-0"
                                            x-transition:leave-end="opacity-0 lg:translate-y-1"
                                            class="lg:absolute lg:top-full mt-1 lg:mt-0
                                        w-full lg:w-auto lg:min-w-[800px] lg:max-w-[90vw] 
                                        bg-white rounded-lg lg:rounded-xl shadow-lg border border-maroon-100 
                                        p-4 lg:p-6 z-50 overflow-hidden
                                        lg:left-1/2 lg:transform lg:-translate-x-1/2"
                                            style="left: 0; right: 0; margin: 0 auto;"
                                            @mouseenter="if(window.innerWidth >= 1024) open = true"
                                            @mouseleave="if(window.innerWidth >= 1024) open = false">

                                            <div
                                                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-maroon-500 to-rose-500">
                                            </div>

                                            <h3
                                                class="text-lg font-bold text-slate-800 mb-4 lg:mb-6 px-2 flex items-center gap-2">
                                                <span class="bg-maroon-100 text-maroon-800 p-1.5 rounded-lg">
                                                    {{ strtoupper(substr($parent->name, 0, 1)) }}
                                                </span>
                                                {{ $parent->name }} Categories
                                            </h3>

                                            {{-- Children displayed in responsive grid --}}
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                                                @foreach ($parent->children as $child)
                                                    <div class="space-y-2 lg:space-y-3">
                                                        {{-- Child header --}}
                                                        <div class="flex items-center gap-2 mb-1 lg:mb-2">
                                                            <div class="w-1.5 h-1.5 bg-maroon-400 rounded-full"></div>
                                                            <h4 class="font-semibold text-slate-800 text-sm">
                                                                {{ $child->name }}
                                                            </h4>
                                                        </div>

                                                        {{-- Grandchildren displayed as block list --}}
                                                        @if ($child->children->count())
                                                            <ul class="space-y-1 lg:space-y-1.5">
                                                                @foreach ($child->children as $grandchild)
                                                                    <li>
                                                                        <a href="{{ route('store.filter.category', $grandchild->slug) }}"
                                                                            class="block px-3 py-1.5 rounded-md text-sm text-slate-600 
                                                                      hover:text-maroon-800 hover:bg-maroon-50 
                                                                      transition-colors duration-150
                                                                      border-l-2 border-transparent hover:border-maroon-400
                                                                      flex items-center gap-2">
                                                                            <svg class="w-2 h-2 text-maroon-400"
                                                                                fill="currentColor" viewBox="0 0 8 8">
                                                                                <circle cx="4" cy="4"
                                                                                    r="3" />
                                                                            </svg>
                                                                            {{ $grandchild->name }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            {{-- If no grandchildren, show child as link --}}
                                                            <a href="{{ route('store.filter.category', $child->slug) }}"
                                                                class="block px-3 py-1.5 rounded-md text-sm text-slate-600 
                                                          hover:text-maroon-800 hover:bg-maroon-50 
                                                          transition-colors duration-150
                                                          border-l-2 border-transparent hover:border-maroon-400
                                                          flex items-center gap-2">
                                                                <svg class="w-2 h-2 text-maroon-400" fill="currentColor"
                                                                    viewBox="0 0 8 8">
                                                                    <circle cx="4" cy="4" r="3" />
                                                                </svg>
                                                                {{ $child->name }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </li>
                            @endforeach

                            {{-- Cart --}}
                            <li class="group">
                                <a href="#"
                                    class="flex items-center px-4 lg:px-5 py-3 rounded-lg transition-all duration-300
                              text-slate-700 hover:text-maroon-800 hover:bg-white
                              group-hover:shadow-sm group-hover:-translate-y-0.5
                              font-medium relative">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    Cart
                                    <span
                                        class="absolute -top-1 -right-1 bg-maroon-600 text-white text-xs 
                                     rounded-full w-5 h-5 flex items-center justify-center
                                     group-hover:bg-maroon-700 transition-colors">
                                        3
                                    </span>
                                </a>
                            </li>

                            {{-- Account --}}
                            <li class="group">
                                <a href="#"
                                    class="flex items-center px-4 lg:px-5 py-3 rounded-lg transition-all duration-300
                              text-slate-700 hover:text-maroon-800 hover:bg-white
                              group-hover:shadow-sm group-hover:-translate-y-0.5
                              font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    Account
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>

        </div>

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
