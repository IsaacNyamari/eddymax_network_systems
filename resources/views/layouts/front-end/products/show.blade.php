@extends('layouts.front-end.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Check if we have products -->
        @if ($products->count() > 0)
            <!-- Get the first product's category for banner (optional) -->
            @php
                $firstCategory = $products->first()->category ?? null;
            @endphp

            @if ($firstCategory && $firstCategory->image)
                <!-- Category Banner -->
                <div class="relative overflow-hidden rounded-2xl mb-10 group cursor-pointer">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent z-10"></div>
                    <img src="{{ asset('storage/' . $firstCategory->image) }}"
                        class="w-full h-[400px] object-cover transform group-hover:scale-105 transition-transform duration-700"
                        alt="{{ $firstCategory->name }}" loading="lazy">
                    <div class="absolute bottom-8 left-8 z-20 text-white max-w-lg">
                        <h3 class="text-3xl font-bold mb-3">Shop {{ $firstCategory->name }}</h3>
                        <p class="text-lg opacity-90 mb-4">Premium quality products curated for you</p>
                    </div>
                </div>
            @endif

            <!-- Products Count -->
            <div class="mb-8">
                <p class="text-gray-600">
                    Showing {{ $products->count() }} of {{ $products->total() }} products
                    @if (isset($category))
                        in {{ $category->name }}
                    @endif
                </p>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 h-fit sm:grid-cols-2 lg:grid-cols-5 mb-4 gap-6">
                @foreach ($products as $product)
                    <div
                        class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Category Badge - kept your red background -->
                        <h3 class="bg-red-500 text-center text-white mb-2">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </h3>

                        <div class="relative overflow-hidden">
                            <!-- Product Image -->
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-36 object-cover group-hover:scale-110 transition-transform duration-500"
                                    loading="lazy" onerror="this.src='{{ asset('images/no-image-icon-23492.png') }}'">
                            @else
                                <img src="{{ asset('images/no-image-icon-23492.png') }}" alt="{{ $product->name }}"
                                    class="w-full h-36 object-cover group-hover:scale-110 transition-transform duration-500"
                                    loading="lazy">
                            @endif

                            <!-- ADD THIS CART BUTTON OVERLAY -->
                            <div
                                class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="transform scale-90 group-hover:scale-100 transition-transform duration-300">
                                    <livewire:add-to-cart-button :product="$product" />
                                </div>
                            </div>

                            @if ($product->stock_status)
                                <div
                                    class="absolute top-3 left-3 bg-{{ $product->stock_status == 'Sale' ? 'red' : ($product->stock_status == 'New' ? 'green' : 'blue') }}-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    {{ Str::replace('_', ' ', $product->stock_status) }}
                                </div>
                            @endif

                            <button
                                class="absolute top-3 right-3 bg-white p-2 rounded-full shadow-md hover:bg-gray-100 transition opacity-0 group-hover:opacity-100">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-5">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <h3 class="font-semibold text-lg text-gray-900 mb-2 group-hover:text-red-600 transition">
                                    {{ Str::limit($product->name, 15, '...') }}
                                </h3>
                            </a>

                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-lg font-bold text-red-600 block">Ksh
                                        {{ number_format($product->price, 2) }}</span>
                                    @if ($product->compare_at_price && $product->compare_at_price > $product->price)
                                        <span class="text-sm text-gray-500 line-through ml-2">
                                            Ksh {{ number_format($product->compare_at_price, 2) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($products->hasPages())
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <!-- No Products Found -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Products Found</h3>
                <p class="text-gray-600 mb-6">We couldn't find any products in this category.</p>
                <a href="{{ route('store.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Store
                </a>
            </div>
        @endif
    </div>
@endsection
