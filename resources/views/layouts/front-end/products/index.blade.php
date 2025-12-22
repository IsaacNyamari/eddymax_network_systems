@extends('layouts.front-end.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Shop</h1>
            <p class="text-gray-600 mt-2">Browse our collection of products</p>
        </div>

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
                                <div class="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                                    
                                    <!-- Image Container -->
                                    <div class="relative aspect-square overflow-hidden bg-gray-50">
                                        <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            loading="lazy"
                                            onerror="this.src='{{ asset('images/no-image-icon-23492.png') }}'">

                                        <!-- Cart Button Overlay -->
                                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <div class="transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                                <livewire:add-to-cart-button :product="$product" />
                                            </div>
                                        </div>

                                        <!-- Badge -->
                                        @if ($product['badge'])
                                            <div class="absolute top-2 left-2 bg-{{ $product['badge'] == 'Sale' ? 'red' : ($product['badge'] == 'New' ? 'green' : 'blue') }}-600 text-white px-2 py-1 rounded text-xs font-bold">
                                                {{ $product['badge'] }}
                                            </div>
                                        @endif

                                        <!-- Wishlist Button -->
                                        <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm hover:bg-gray-50 transition opacity-0 group-hover:opacity-100">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-3">
                                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                                            <h3 class="font-medium text-sm md:text-base text-gray-900 mb-1 group-hover:text-red-600 transition line-clamp-2">
                                                {{ $product['name'] }}
                                            </h3>
                                        </a>
                                        
                                        <div class="mt-2">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <span class="text-base font-bold text-red-600">Ksh {{ number_format($product['price'], 0) }}</span>
                                                    @if ($product['badge'] == 'Sale')
                                                        <span class="text-xs text-gray-500 line-through ml-1">Ksh 15,999</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Optional: Show when no products -->
                        @if($products->isEmpty())
                            <div class="text-center py-12">
                                <div class="text-gray-400 mb-4">
                                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
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
{{-- 
                <!-- Pagination (if applicable) -->
                @if(method_exists($products, 'links') && !isset($productsSorted))
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @endif --}}
                
            </main>

        </div>
    </div>
@endsection