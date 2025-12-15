@extends('layouts.front-end.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Shop</h1>
        </div>

        <!-- Main Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- LEFT SIDEBAR : FILTERS (UI ONLY) -->
            <livewire:filter-widget :categories="$categories" />
            <!-- MAIN CONTENT -->
            <main class="lg:col-span-3 space-y-6">

                <!-- Top Sort Bar -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <p class="text-sm text-gray-500">
                        Browse our latest products
                    </p>

                    <select class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 text-sm">
                        <option value="">Sort By</option>
                        <option value="price-low-high">Price: Low to High</option>
                        <option value="price-high-low">Price: High to Low</option>
                        <option value="newest">Newest</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>

                <!-- Products Container -->
                <div class="p-6 bg-white border gap-5 w-full border-gray-200 rounded-lg">

                    @if (!isset($productsSorted))
                        @livewire('product-list')
                        @livewire('product-list')
                        @livewire('product-list')
                        @livewire('product-list')
                        @livewire('product-list')
                        @livewire('product-list')
                        @livewire('product-list')
                        @livewire('product-list')
                    @elseif ($productsSorted->isEmpty())
                        <div class="flex flex-col items-center justify-center py-20">
                            <img src="{{ asset('images/no-products.png') }}" alt="No products found"
                                class="w-64 h-64 mb-6 object-contain">

                            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                                Oops! No Products Found
                            </h2>

                            <p class="text-gray-500 mb-6 text-center">
                                We couldn't find any products in this category.
                            </p>

                            <a href="{{ route('store.shop') }}"
                                class="px-6 py-3 bg-red-600 text-white rounded-full hover:bg-red-500 transition">
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
