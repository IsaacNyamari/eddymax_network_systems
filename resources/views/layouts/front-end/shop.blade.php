@extends('layouts.front-end.app')

@section('content')
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 space-y-12 mt-2 mb-2">
        <!-- Hero Section -->
        {{-- <div class="relative bg-gradient-to-r from-blue-900 to-blue-800 rounded-xl overflow-hidden shadow-2xl">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80"
                    alt="Networking Equipment" class="w-full h-full object-cover opacity-40" loading="lazy"
                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIzMDAiIHZpZXdCb3g9IjAgMCAxMjAwIDQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjMWYyYTM1Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCxzYW5zLXNlcmlmIiBmb250LXNpemU9IjI0IiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPk5FVFdPUktJTkcgRVFVSVBJTUVOVDwvdGV4dD48L3N2Zz4='">
            </div>
            <div class="relative px-8 py-16 md:py-24 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 leading-tight">
                    Professional Networking Solutions
                </h1>
                <p class="text-xl text-gray-200 mb-8 max-w-3xl mx-auto">
                    High-quality routers, switches, access points, and cables with warranty and expert support
                </p>
                <a href="{{ route('store.shop') }}"
                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold rounded-lg hover:from-red-700 hover:to-red-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Shop Now
                </a>
            </div>
        </div> --}}

        {{-- <!-- Featured Categories -->
        <div id="shop">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-900">Shop by Category</h2>
                <a href="{{ route('store.shop') }}"  
                    class="text-red-600 hover:text-red-500 font-semibold flex items-center">
                    View All
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <livewire:category-carousel />
        </div> --}}
        <!-- Featured Products -->
        @foreach ($parent_categories as $index => $category)
        {{ $category->products }}
            <div class="mb-16">
                @if ($index == 0)
                    <!-- Category Banner -->
                    <div class="relative overflow-hidden rounded-2xl mb-10 group cursor-pointer">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent z-10"></div>
                        <img src="{{ asset('storage/' . $category['image']) }}"
                            class="w-full h-[400px] object-cover transform group-hover:scale-105 transition-transform duration-700"
                            alt="{{ $category->name }}" loading="lazy"
                            onerror="this.src='https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80'">
                        <div class="absolute bottom-8 left-8 z-20 text-white max-w-lg">
                            <h3 class="text-3xl font-bold mb-3">Shop {{ $category->name }}</h3>
                            <p class="text-lg opacity-90 mb-4">Premium quality products curated for you</p>
                            <a href="{{ route('store.filter.category', $category->slug) }}"
                                class="inline-flex items-center bg-white text-gray-900 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors duration-300">
                                Shop Now
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif

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
                @livewire('product-list')

                <!-- View All Bottom CTA -->
                <div class="text-center mt-12 pt-8 border-t border-gray-200">
                    <a href="{{ route('store.filter.category', $category->slug) }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white font-bold rounded-full hover:shadow-xl hover:shadow-red-200 transform hover:-translate-y-1 transition-all duration-300 group/cta">
                        <span class="mr-3">View All {{ $category->name }}</span>
                        <svg class="w-5 h-5 transform group-hover/cta:translate-x-2 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach
        <!-- Why Choose Us -->
        <div class="bg-gradient-to-br from-blue-50 to-white rounded-2xl p-8 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Why Choose
                {{ config('app.name', 'Eddymax Systems') }}?</h2>
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
                <a href="tel:+254712345678"
                    class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-900 px-8 py-3 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:-translate-y-1">
                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    +254 723 835 303
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
