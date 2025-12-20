@extends('layouts.app')

@section('title', 'Search Results - Edymax Networks')

@section('content')
    <div class="bg-gradient-to-r from-red-900 to-red-800 text-white py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl lg:text-4xl font-bold mb-4">Search Results</h1>
            <p class="text-red-100">
                Found <span class="font-bold">{{ $products->total() }}</span> products for "{{ $query }}"
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        @if ($products->total() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-product.jpg') }}"
                                alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <a href="{{ route('products.show', $product->slug ?? $product->id) }}"
                                    class="text-lg font-semibold text-gray-800 hover:text-red-600 line-clamp-2">
                                    {{ $product->name }}
                                </a>
                            </div>

                            @if ($product->category)
                                <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded mb-3">
                                    {{ $product->category->name }}
                                </span>
                            @endif

                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $product->short_description ?? $product->description }}
                            </p>

                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-red-600">
                                    KES {{ number_format($product->price, 2) }}
                                </span>
                                <livewire:add-to-cart-button :product="$product" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $products->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-6">🔍</div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">No products found</h2>
                <p class="text-gray-600 mb-8">We couldn't find any products matching "{{ $query }}"</p>
                <div class="space-x-4">
                    <a href="{{ route('store.shop') }}"
                        class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                        Go to Homepage
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition">
                        Browse All Products
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
