@extends('layouts.front-end.app')

@section('content')


    <!-- Content Section with Image Overlay -->
    <section class="relative py-16 px-4 sm:px-6 lg:px-8 overflow-hidden mb-1">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
     
            <!-- Blue & Maroon Gradient Overlay -->
            <div class="absolute inset-0 bg-maroon-600 rounded" style="background: #491916e1"></div>

            <!-- Subtle Pattern Overlay -->
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="circuit-pattern" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                            <!-- Circuit board-like pattern -->
                            <rect x="0" y="0" width="80" height="80" fill="none" stroke="currentColor"
                                stroke-width="0.5" class="text-white" />
                            <circle cx="20" cy="20" r="3" fill="currentColor" class="text-blue-300" />
                            <circle cx="60" cy="20" r="3" fill="currentColor" class="text-maroon-300" />
                            <circle cx="20" cy="60" r="3" fill="currentColor" class="text-maroon-300" />
                            <circle cx="60" cy="60" r="3" fill="currentColor" class="text-blue-300" />
                            <line x1="20" y1="20" x2="60" y2="20" stroke="currentColor"
                                stroke-width="1" class="text-white/50" />
                            <line x1="20" y1="20" x2="20" y2="60" stroke="currentColor"
                                stroke-width="1" class="text-white/50" />
                            <line x1="60" y1="20" x2="60" y2="60" stroke="currentColor"
                                stroke-width="1" class="text-white/50" />
                            <line x1="20" y1="60" x2="60" y2="60" stroke="currentColor"
                                stroke-width="1" class="text-white/50" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#circuit-pattern)" />
                </svg>
            </div>
        </div>

        <!-- Content Container -->
        <div class="relative z-10 max-w-7xl mx-auto">
            <!-- Glass Effect Main Heading -->
            <div class="text-center mb-12">
                <div
                    class="inline-block backdrop-blur-md bg-white/90 rounded-2xl p-8 md:p-10 shadow-2xl border border-white/40 mb-8">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                        Welcome to <span
                            class="bg-gradient-to-r from-blue-700 to-maroon-700 bg-clip-text text-transparent">{{ config('app.name') }}</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-700 max-w-3xl mx-auto">
                        Your premier destination for professional networking equipment
                    </p>
                </div>
            </div>

            <!-- Glass Effect Feature Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Router Products -->
                <div
                    class="backdrop-blur-lg bg-white/95 rounded-2xl p-8 border border-white/50 shadow-2xl hover:shadow-3xl hover:border-blue-400/60 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-4 rounded-xl mr-4 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Routers & Switches</h3>
                    </div>
                    <p class="text-gray-700 mb-6 text-lg leading-relaxed">
                        High-performance networking hardware for enterprise connectivity
                    </p>
                    <div class="pt-6 border-t border-gray-300/30">
                        <span
                            class="inline-flex items-center font-semibold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                            <svg class="w-5 h-5 mr-2 text-blue-700" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Enterprise-Grade Solutions
                        </span>
                    </div>
                </div>

                <!-- Wireless Products -->
                <div
                    class="backdrop-blur-lg bg-white/95 rounded-2xl p-8 border border-white/50 shadow-2xl hover:shadow-3xl hover:border-maroon-400/60 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-maroon-600 to-maroon-800 p-4 rounded-xl mr-4 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Wireless Solutions</h3>
                    </div>
                    <p class="text-gray-700 mb-6 text-lg leading-relaxed">
                        Advanced WiFi 6/6E systems and enterprise access points
                    </p>
                    <div class="pt-6 border-t border-gray-300/30">
                        <span
                            class="inline-flex items-center font-semibold bg-gradient-to-r from-maroon-600 to-maroon-800 bg-clip-text text-transparent">
                            <svg class="w-5 h-5 mr-2 text-maroon-700" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Cutting-Edge Technology
                        </span>
                    </div>
                </div>

                <!-- Security Products -->
                <div
                    class="backdrop-blur-lg bg-white/95 rounded-2xl p-8 border border-white/50 shadow-2xl hover:shadow-3xl hover:border-blue-500/60 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-blue-700 to-maroon-700 p-4 rounded-xl mr-4 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Network Security</h3>
                    </div>
                    <p class="text-gray-700 mb-6 text-lg leading-relaxed">
                        Enterprise firewalls, VPNs, and comprehensive security suites
                    </p>
                    <div class="pt-6 border-t border-gray-300/30">
                        <span
                            class="inline-flex items-center font-semibold bg-gradient-to-r from-blue-700 to-maroon-700 bg-clip-text text-transparent">
                            <svg class="w-5 h-5 mr-2 text-blue-700" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            24/7 Network Protection
                        </span>
                    </div>
                </div>
            </div>

            <!-- Glass Effect Value Proposition -->
            <div class="backdrop-blur-xl bg-white/95 rounded-3xl p-10 md:p-12 border border-white/60 shadow-3xl mb-12">
                <div class="max-w-5xl mx-auto text-center">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-10">
                        Why Trust <span
                            class="bg-gradient-to-r from-blue-800 to-maroon-800 bg-clip-text text-transparent">{{ config('app.name') }}</span>?
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div
                            class="backdrop-blur-sm bg-gradient-to-br from-blue-50/80 to-white/90 rounded-2xl p-8 border border-blue-200/50 hover:border-blue-300 transition-all duration-300 hover:shadow-xl">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-2xl mb-6 shadow-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Certified Products</h3>
                            <p class="text-gray-700">Industry-certified networking equipment with warranty</p>
                        </div>
                        <div
                            class="backdrop-blur-sm bg-gradient-to-br from-maroon-50/80 to-white/90 rounded-2xl p-8 border border-maroon-200/50 hover:border-maroon-300 transition-all duration-300 hover:shadow-xl">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-maroon-600 to-maroon-800 text-white rounded-2xl mb-6 shadow-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Expert Support</h3>
                            <p class="text-gray-700">Network specialists available 24/7 for consultation</p>
                        </div>
                        <div
                            class="backdrop-blur-sm bg-gradient-to-br from-blue-50/80 to-maroon-50/80 rounded-2xl p-8 border border-blue-200/50 hover:border-blue-400 transition-all duration-300 hover:shadow-xl">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-700 to-maroon-700 text-white rounded-2xl mb-6 shadow-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Fast Delivery</h3>
                            <p class="text-gray-700">Same-day shipping on orders placed before 3 PM</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
    @if (env('SHOW_BANNER') ?? true)
        <!-- Hero Image Section -->
        <section class="relative overflow-hidden mb-1">
            <div class="relative w-full bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="relative w-full pb-[25%] md:pb-[30%] lg:pb-[35%] overflow-hidden">
        <img 
            src="{{ asset('images/products-banner-edited.png') }}"
            srcset="{{ asset('images/products-banner-edited.png') }} 2x"
            alt="Professional networking equipment and solutions from {{ config('app.name') }} - Routers, Switches, and Network Infrastructure"
            class="absolute inset-0 w-full h-full object-contain"
            loading="eager"
            decoding="async"
            sizes="100vw"
        >
        <!-- Optional subtle gradient overlay for better contrast -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/5 to-transparent"></div>
    </div>
</div>
        </section>
    @endif
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 space-y-12 mt-2 mb-2">
        <h3 class="text-center text-3xl font-semibold border-t-2 border-b-2  py-2 border-gray-200">Shop by category</h3>
        @php
            // Define the custom sort order
            $order = [
                'Fiber Optics' => 2,
                'Networking' => 1,
                'Security Systems' => 3,
                'Computing' => 4,
                'Solar Solutions' => 5,
                'Electronics' => 6,
                'Telephones' => 7,
                'Accessories' => 8,
            ];

            // Sort the parent_categories collection
            if (isset($parent_categories) && $parent_categories) {
                $sortedParentCategories = $parent_categories->sortBy(function ($category) use ($order) {
                    return $order[$category->name] ?? 999;
                });
            } else {
                $sortedParentCategories = collect();
            }
        @endphp

        @if ($sortedParentCategories->count() > 0)
            @foreach ($sortedParentCategories as $category)
                @php
                    try {
                        // Try to get all products
                        $allProducts = $category->getAllProducts();
                        $hasProducts = $allProducts && $allProducts->count() > 0;
                    } catch (\Exception $e) {
                        // If there's an error, skip this category
                        $hasProducts = false;
                    }
                @endphp

                @if ($hasProducts)
                    <div class="mb-16">
                        <!-- Category Header -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                            <div class="mb-4 sm:mb-0">
                                <h2 class="text-4xl font-bold text-gray-900 mb-2">{{ $category->name }}</h2>
                                <p class="text-gray-600">Discover our premium collection</p>
                            </div>
                            <a href="{{ route('store.filter.category', $category->slug) }}"
                                class="group relative inline-flex items-center text-lg font-semibold text-red-600 hover:text-red-700 transition-colors duration-300">
                                <span class="mr-2">Explore Collection</span>
                                <svg class="w-5 h-5 transform group-hover:translate-x-2 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                                <span
                                    class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 group-hover:w-full transition-all duration-300"></span>
                            </a>
                        </div>
                        <!-- Products Grid -->
                         <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-1 md:gap-6">
                            @foreach ($allProducts as $product)
                                <div
                                    class="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">

                                    <!-- Image Container -->
                                    <div class="relative aspect-square overflow-hidden bg-gray-50 flex-shrink-0">
                                        <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            loading="lazy"
                                            onerror="this.src='{{ asset('images/no-image-icon-23492.png') }}'">

                                        <!-- Cart Button Overlay -->
                                        <div
                                            class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <div
                                                class="transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                                <livewire:add-to-cart-button :product="$product" />
                                            </div>
                                        </div>

                                        <!-- Badge -->
                                        @if ($product['badge'])
                                            <div
                                                class="absolute top-2 left-2 px-2.5 py-1 rounded text-xs font-bold text-white 
                                    {{ $product['badge'] == 'Sale' ? 'bg-red-600' : ($product['badge'] == 'New' ? 'bg-green-600' : 'bg-blue-600') }}">
                                                {{ $product['badge'] }}
                                            </div>
                                        @endif

                                        <!-- Wishlist Button -->
                                        <button
                                            class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm hover:bg-gray-50 transition opacity-0 group-hover:opacity-100">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-3 flex flex-col flex-grow">
                                        <!-- Product Name -->
                                        <a href="{{ route('products.show', $product->slug) }}"
                                            class="block mb-2 flex-grow">
                                            <h3
                                                class="font-medium text-sm md:text-base text-gray-900 group-hover:text-red-600 transition line-clamp-2">
                                                {{ $product['name'] }}
                                            </h3>
                                        </a>

                                        <!-- Price -->
                                        <div class="mb-2">
                                            <span class="text-base font-bold text-red-600">
                                                Ksh {{ number_format($product['price'], 2) }}
                                            </span>
                                        </div>

                                        <!-- Rating -->
                                        @if ($product->ratings->count() > 0)
                                            <div class="flex items-center space-x-1.5 mt-auto">
                                                <!-- Stars -->
                                                <div class="flex items-center">
                                                    @php
                                                        $averageRating = $product->ratings->avg('rate_count') ?? 0;
                                                        $ratingCount = $product->ratings->count();
                                                        $roundedRating = round($averageRating * 2) / 2;
                                                    @endphp

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= floor($roundedRating))
                                                            <!-- Full star -->
                                                            <svg class="w-3.5 h-3.5 text-yellow-500 flex-shrink-0"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        @elseif ($i - 0.5 == $roundedRating)
                                                            <!-- Half star -->
                                                            <div class="relative w-3.5 h-3.5">
                                                                <svg class="w-3.5 h-3.5 text-gray-300 absolute"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                                <div class="absolute top-0 left-0 w-1/2 overflow-hidden">
                                                                    <svg class="w-3.5 h-3.5 text-yellow-500"
                                                                        fill="currentColor" viewBox="0 0 20 20">
                                                                        <path
                                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- Empty star -->
                                                            <svg class="w-3.5 h-3.5 text-gray-300 flex-shrink-0"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        @endif
                                                    @endfor
                                                </div>

                                                <!-- Rating Count -->
                                                <span class="text-xs text-gray-500">
                                                    ({{ $ratingCount }})
                                                </span>

                                            </div>
                                        @else
                                            <!-- No ratings yet -->
                                            <div class="flex items-center space-x-1.5 mt-auto">
                                                <div class="flex items-center">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-3.5 h-3.5 text-gray-300 flex-shrink-0"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <span class="text-xs text-gray-400">No reviews</span>
                                            </div>
                                        @endif
                                        <div class="mt-2">
                                            <livewire:add-to-cart-button class=" w-full" :product="$product" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <!-- Show message if no categories -->
            <div class="text-center py-12">
                <h2 class="text-2xl font-bold text-gray-700">No categories found</h2>
                <p class="text-gray-500 mt-2">Please check back later for our product collections.</p>
            </div>
        @endif

        <!-- Why Choose Us Section -->
        <div class="bg-gradient-to-br from-blue-50 to-white rounded-2xl p-8 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Why Choose
                {{ config('app.name', 'Edymax Systems and Networks') }}?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $features = [
                        [
                            'icon' =>
                                'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                            'title' => 'Genuine Products',
                            'desc' => '100% authentic branded networking equipment with original manufacturer warranty',
                        ],
                        [
                            'icon' =>
                                'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                            'title' => 'Secure Payments',
                            'desc' =>
                                'Safe transactions with M-Pesa, cards, and bank transfers. SSL encrypted checkout',
                        ],
                        [
                            'icon' => 'M5 13l4 4L19 7',
                            'title' => 'Warranty Included',
                            'desc' => 'Minimum 1-year warranty on all products with expert technical support',
                        ],
                        [
                            'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                            'title' => 'Fast Delivery',
                            'desc' => 'Nationwide shipping with tracking. Same-day dispatch in Nairobi',
                        ],
                    ];
                @endphp

                @foreach ($features as $feature)
                    <div
                        class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-red-100">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-red-50 to-red-100 rounded-2xl flex items-center justify-center mb-4 group-hover:from-red-100 group-hover:to-red-200 transition">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $feature['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-red-600 rounded-2xl p-10 text-center text-white shadow-2xl">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Upgrade Your Network?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Get expert consultation and find the perfect networking solution for your needs
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('pages.contact') }}"
                    class="bg-white text-gray-900 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:-translate-y-1 shadow-lg">
                    Contact Sales
                </a>
                <a href="tel:+254723835303"
                    class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-900 px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:-translate-y-1">
                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    {{ env('PHONE') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .aspect-w-16 {
            position: relative;
            padding-bottom: 56.25%;
        }

        .aspect-w-16>* {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }

        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }
    </style>
@endpush
