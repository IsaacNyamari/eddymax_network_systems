@extends('layouts.front-end.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Featured Products -->
        @foreach ($parent_categories as $index => $category)
            <div class="mb-16">
                @if ($index == 0)
                    <!-- Category Banner -->
                    <div class="relative overflow-hidden rounded-2xl mb-10 group cursor-pointer">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent z-10"></div>
                        <img src="{{ asset('storage/' . $category['image']) }}"
                            class="w-full h-[400px] object-cover transform group-hover:scale-105 transition-transform duration-700"
                            alt="{{ $category->name }}" loading="lazy">
                        <div class="absolute bottom-8 left-8 z-20 text-white max-w-lg">
                            <h3 class="text-3xl font-bold mb-3">Shop {{ $category->name }}</h3>
                            <p class="text-lg opacity-90 mb-4">Premium quality products curated for you</p>

                        </div>
                    </div>
                @endif

                <!-- Category Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div class="mb-4 sm:mb-0">
                        <h2 class="text-4xl font-bold text-gray-900 mb-2">{{ $category->name }}</h2>
                        <p class="text-gray-600">Discover our premium collection</p>
                    </div>
                </div>
                <!-- Products Grid -->
                <div class="grid grid-cols-1 h-fit sm:grid-cols-2 lg:grid-cols-5 mb-4 gap-6">
                    @foreach ($category->getAllProducts() as $product)
                        <div
                            class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            <h3 class="bg-red-500 text-center text-white mb-2">{{ $product->category->name }}</h3>
                            <div class="relative overflow-hidden">

                                <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}"
                                    class="w-full h-36 object-cover group-hover:scale-110 transition-transform duration-500"
                                    loading="lazy" onerror="this.src='{{ asset('images/no-image-icon-23492.png') }}'">

                                <!-- ADD THIS CART BUTTON OVERLAY -->
                                <div
                                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="transform scale-90 group-hover:scale-100 transition-transform duration-300">
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
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <h3
                                        class="font-semibold text-lg text-gray-900 mb-2 group-hover:text-red-600 transition">
                                        {{ Str::limit($product['name'], 15, '...') }}
                                </a>
                                </h3>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-lg font-bold text-red-600 block">Ksh
                                            {{ number_format($product['price'], 2) }}</span>
                                        @if ($product['badge'] == 'Sale')
                                            <span class="text-sm text-gray-500 line-through ml-2">Ksh 15,999</span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        @endforeach

    </div>
@endsection
