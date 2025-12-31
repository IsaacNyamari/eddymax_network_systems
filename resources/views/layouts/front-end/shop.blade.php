@extends('layouts.front-end.app')

@section('content')
    <section class="relative py-16 px-4 sm:px-6 lg:px-8 mb-2">
        <!-- Background Image with Clean Overlay -->
        <div class="absolute inset-0 z-0">
            <!-- Semi-transparent overlay -->
            {{-- <div class="absolute inset-0 bg-black/50"></div> --}}

            <!-- Subtle gradient -->
            {{-- <div class="absolute inset-0 bg-gradient-to-r from-blue-900/20 to-red-900/20 mix-blend-screen"></div> --}}

            <!-- Background Image -->
            <img src="{{ asset('images/products-banner (1).png') }}" alt="{{ config('app.name') }} - Technology Solutions"
                class="w-fit h-full lg:object-contain md:object-cover object-center" loading="lazy"
                onerror="this.style.display='none'">
        </div>

        <div class="relative z-10 h-64 resize-x max-w-4xl mx-auto text-center flex justify-center">
            <!-- SEO Optimized Description -->
            {{-- <div class="prose prose-lg max-w-fit text-gray-100 mb-10 bg-black/40 p-8 rounded-xl backdrop-blur-sm">
                <h2 class="text-white text-5xl">SHOP</h2>
            </div> --}}
        </div>
    </section>
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 space-y-12 mt-2 mb-2">
        <!-- Add this section to your shop page -->



        <!-- Featured Products -->
        @php
            // Define the custom sort order
            $order = [
                'Networking' => 1,
                'Security Systems' => 2,
                'Computing' => 3,
                'Solar Solutions' => 4,
                'Electronics' => 5,
                'Telephones' => 6,
                'Accessories' => 7,
            ];

            // Sort the parent_categories collection based on the custom order
            $sortedParentCategories = $parent_categories->sortBy(function ($category) use ($order) {
                return $order[$category->name] ?? 999; // Default to high number for categories not in order list
            });
        @endphp

        @foreach ($sortedParentCategories as $index => $category)
            @if ($category->children->count() > 0)
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
                    <div class="grid grid-cols-1 h-fit sm:grid-cols-2 lg:grid-cols-5 mb-4 gap-6">
                        @foreach ($category->getAllProducts() as $product)
                            <!-- Changed from $category->products -->
                            <div
                                class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                                <div class="relative overflow-hidden">
                                    <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}"
                                        class="w-full h-36 object-cover group-hover:scale-110 transition-transform duration-500"
                                        loading="lazy" onerror="this.src='{{ asset('images/no-image-icon-23492.png') }}'">

                                    <!-- ADD THIS CART BUTTON OVERLAY -->
                                    <div
                                        class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div
                                            class="transform scale-90 group-hover:scale-100 transition-transform duration-300">
                                            <livewire:add-to-cart-button :product="$product" />
                                        </div>
                                    </div>

                                    @if ($product['stock_status'])
                                        <div
                                            class="absolute top-3 left-3 bg-{{ $product['stock_status'] == 'Sale' ? 'red' : ($product['stock_status'] == 'New' ? 'green' : 'blue') }}-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                                            {{ Str::replace('_', ' ', $product['stock_status']) }}
                                        </div>
                                    @endif
                                    <button
                                        class="absolute top-3 right-3 bg-white p-2 rounded-full shadow-md hover:bg-gray-100 transition opacity-0 group-hover:opacity-100">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-5">
                                    <a href="{{ route('products.show', $product->slug) }}" wire:navigate>
                                        <h3
                                            class="font-semibold text-md text-gray-900 mb-2 group-hover:text-red-600 transition">
                                            {{ Str::limit($product['name'], 15, '...') }}
                                    </a>
                                    </h3>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2">
                                            <span class="text-sm font-bold text-red-600 block">Ksh
                                                {{ number_format($product['price'], 2) }}</span>
                                            @if ($product->ratings->count() > 0)
                                                <div class="flex text-yellow-600">
                                                    @php
                                                        // Get the average rating
                                                        $averageRating = $product->ratings->avg('rate_count') ?? 0;
                                                        $ratingCount = $product->ratings->count();

                                                        // Round to nearest half for display
                                                        $roundedRating = round($averageRating * 2) / 2;
                                                    @endphp

                                                    {{-- Display stars based on average rating --}}
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= floor($roundedRating))
                                                            {{-- Full star --}}
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        @elseif ($i - 0.5 == $roundedRating)
                                                            {{-- Half star --}}
                                                            <div class="relative">
                                                                <svg class="w-5 h-5 text-gray-300" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                                <div class="absolute top-0 left-0 w-1/2 overflow-hidden">
                                                                    <svg class="w-5 h-5 text-yellow-600" fill="currentColor"
                                                                        viewBox="0 0 20 20">
                                                                        <path
                                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        @else
                                                            {{-- Empty star --}}
                                                            <svg class="w-5 h-5 text-gray-300" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        @endif
                                                    @endfor
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
        <!-- Why Choose Us -->
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
