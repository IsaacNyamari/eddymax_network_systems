@extends('layouts.front-end.app')

@section('content')
    <!-- Add this section to your shop page -->
    <section class="relative py-16 px-4 sm:px-6 lg:px-8">
        <!-- Background Image with Clean Overlay -->
        <div class="absolute inset-0 z-0">
            <!-- Semi-transparent overlay -->
            <div class="absolute inset-0 bg-black/50"></div>

            <!-- Subtle gradient -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/20 to-red-900/20 mix-blend-screen"></div>

            <!-- Background Image -->
            <img src="{{ asset('images/Omada-SDN-Banner_High-Resolution.jpg') }}"
                alt="{{ config('app.name') }} - Technology Solutions" class="w-full h-full object-cover object-center"
                loading="lazy" onerror="this.style.display='none'">
        </div>

        <div class="relative z-10 h-64 resize-x max-w-4xl mx-auto text-center flex justify-center">
            <!-- SEO Optimized Description -->
            {{-- <div class="prose prose-lg max-w-fit text-gray-100 mb-10 bg-black/40 p-8 rounded-xl backdrop-blur-sm"> --}}
                {{-- <h2 class="text-white text-5xl">SHOP</h2> --}}
            {{-- </div> --}}
        </div>
    </section>

    <!-- Additional SEO Content (Hidden from users, visible to search engines) -->
    <div class="hidden" aria-hidden="true">
        <h2>Shop {{ config('app.name') }} - Best Technology Store</h2>
        <p>
            {{ config('app.name') }} offers wide range of networking products including routers, switches, cables, and
            wireless
            solutions. Our computing section features computers, laptops, printers, and accessories from top brands.
            We provide comprehensive security systems for home and business protection. Our electronics department
            includes the latest gadgets and devices. As a leading solar energy systems provider, we offer complete
            solar power solutions for residential and commercial needs.
        </p>
        <p>
            Buy networking equipment, computing devices, security cameras, electronic gadgets, and solar panels
            at best prices in Kenya. {{ config('app.name') }} is your trusted partner for technology solutions
            and renewable energy systems.
        </p>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Main Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            <!-- LEFT SIDEBAR : FILTERS (UI ONLY) -->
            <aside class="lg:col-span-1">
                <div class="sticky top-6">
                    <livewire:filter-widget :categories="$categories" />
                </div>
            </aside>

            <!-- MAIN CONTENT -->
            <main class="lg:col-span-3">

                <!-- Products Container -->
                <div class="bg-white border border-gray-200 rounded-lg p-4 md:p-6">

                    @if (!isset($productsSorted))
                        <!-- Grid Container -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                            @foreach ($products as $product)
                                <div
                                    class="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1">

                                    <!-- Image Container -->
                                    <div class="relative aspect-square overflow-hidden bg-gray-50">
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
                                                class="absolute top-2 left-2 bg-{{ $product['badge'] == 'Sale' ? 'red' : ($product['badge'] == 'New' ? 'green' : 'blue') }}-600 text-white px-2 py-1 rounded text-xs font-bold">
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
                                    <div class="p-3">
                                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                                            <h3
                                                class="font-medium text-sm md:text-base text-gray-900 mb-1 group-hover:text-red-600 transition line-clamp-2">
                                                {{ $product['name'] }}
                                            </h3>
                                        </a>

                                        <div class="mt-2">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <span class="text-base font-bold text-red-600">Ksh
                                                        {{ number_format($product['price'], 0) }}</span>
                                                    @if ($product['badge'] == 'Sale')
                                                        <span class="text-xs text-gray-500 line-through ml-1">Ksh
                                                            15,999</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Optional: Show when no products -->
                        @if ($products->isEmpty())
                            <div class="text-center py-12">
                                <div class="text-gray-400 mb-4">
                                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                                <p class="text-gray-500">Try adjusting your filters or check back later.</p>
                            </div>
                        @endif
                    @elseif ($productsSorted->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12">
                            <img src="{{ asset('images/no-products.png') }}" alt="No products found"
                                class="w-48 h-48 mb-4 object-contain">

                            <h2 class="text-xl font-bold text-gray-800 mb-2">
                                Oops! No Products Found
                            </h2>

                            <p class="text-gray-500 mb-6 text-center max-w-md">
                                We couldn't find any products in this category.
                            </p>

                            <a href="{{ route('store.shop') }}"
                                class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-500 transition text-sm font-medium">
                                Browse All Products
                            </a>
                        </div>
                    @else
                        <livewire:products-sorted-by-category :productsSorted="$productsSorted" />
                    @endif
                </div>
            </main>

        </div>
    </div>
@endsection
@section('overlay')
    <!-- FILTER RESULT OVERLAY -->
    <!-- FILTER RESULT OVERLAY -->
    <div id="filter-overlay" class="fixed inset-0 z-[9999] hidden bg-black/70 backdrop-blur-sm">
        <div class="min-h-screen flex items-center justify-center p-4">
            <!-- Remove max-w-6xl to allow full width, use w-full instead -->
            <div
                class="bg-white w-full max-h-[90vh] rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0 mx-4">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Filter Results</h3>
                            <p class="text-sm text-gray-500" id="result-count">0 products found</p>
                        </div>
                    </div>
                    <button id="close-overlay" type="button"
                        class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body - Make it take full width -->
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                    <!-- Remove grid-cols-1, use container and proper grid -->
                    <div id="filter-results-container" class="container mx-auto">
                        <!-- Empty state -->
                        <div id="empty-state" class="col-span-full text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-500">Apply filters to see results</p>
                        </div>

                        <!-- Results will be loaded here -->
                        <div id="results-grid"
                            class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"></div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t bg-gray-50">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">
                            Showing <span class="font-semibold" id="current-count">0</span> products
                        </span>
                        <button type="button" onclick="window.location.href='{{ route('store.shop') }}'"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            View All Products
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
