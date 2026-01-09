@extends('layouts.front-end.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Check if we have products -->
        @if ($products->count() > 0)
            <!-- Get the requested category -->
            @php
                // Use the category passed from controller, not from first product
                $requestedCategory = request()->category ?? (isset($category) ? $category : null);

                // For banner, you might still want to use first product's category image
                $firstCategory = $products->first()->category ?? null;
            @endphp

            @if ($firstCategory && $firstCategory->image)
                <!-- Category Banner -->
                <div class="relative overflow-hidden rounded-2xl mb-10 group cursor-pointer">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent z-10"></div>
                    <img src="{{ asset('storage/' . $firstCategory->image) }}"
                        class="w-full h-[400px] object-contain transform group-hover:scale-105 transition-transform duration-700"
                        alt="{{ $firstCategory->name }}" loading="lazy">
                    <div class="absolute bottom-8 left-8 z-20 text-white max-w-lg">
                        <h3 class="text-3xl font-bold mb-3">Shop {{ $firstCategory->name }}</h3>
                        <p class="text-lg opacity-90 mb-4">Premium quality products curated for you</p>
                    </div>
                </div>
            @endif

            <!-- Corrected Breadcrumbs: Only show if we have a requested category -->
            @if ($requestedCategory)
                <div class="mb-4">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('store.shop') }}"
                                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                    </svg>
                                    Home
                                </a>
                            </li>

                            <!-- Add parent categories if they exist -->
                            @php
                                $categoryForBreadcrumb = \App\Models\Category::where(
                                    'slug',
                                    $requestedCategory,
                                )->first();
                            @endphp
                            @if ($categoryForBreadcrumb->parent)
                                @php
                                    $parents = collect();
                                    $parent = $categoryForBreadcrumb->parent;
                                    while ($parent) {
                                        $parents->push($parent);
                                        $parent = $parent->parent;
                                    }
                                    $parents = $parents->reverse();
                                @endphp

                                @foreach ($parents as $parentCategory)
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="m1 9 4-4-4-4" />
                                            </svg>
                                            <a href="{{ route('store.filter.category', $parentCategory->slug) }}"
                                                class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                                                {{ $parentCategory->name }}
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            @endif

                            <!-- Current category -->
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span
                                        class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $categoryForBreadcrumb->name }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
            @endif

            <!-- Products Count -->
            <div class="mb-8">
                <p class="text-gray-600">
                    Showing {{ $products->count() }} of {{ $products->total() }} products
                    @if ($categoryForBreadcrumb)
                        in {{ $categoryForBreadcrumb->name }}
                    @endif
                </p>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                @foreach ($products as $product)
                    <div
                        class="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">

                        <!-- Image Container -->
                        <div class="relative aspect-square p-3 overflow-hidden bg-gray-50 flex-shrink-0">
                            <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy" onerror="this.src='{{ asset('images/no-image-icon-23492.png') }}'">

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
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Product Info -->
                        <div class="p-3 flex flex-col flex-grow">
                            <!-- Product Name -->
                            <a href="{{ route('products.show', $product->slug) }}" class="block mb-2 flex-grow">
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
                                                <svg class="w-3.5 h-3.5 text-yellow-500 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @elseif ($i - 0.5 == $roundedRating)
                                                <!-- Half star -->
                                                <div class="relative w-3.5 h-3.5">
                                                    <svg class="w-3.5 h-3.5 text-gray-300 absolute" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    <div class="absolute top-0 left-0 w-1/2 overflow-hidden">
                                                        <svg class="w-3.5 h-3.5 text-yellow-500" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Empty star -->
                                                <svg class="w-3.5 h-3.5 text-gray-300 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
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
                                            <svg class="w-3.5 h-3.5 text-gray-300 flex-shrink-0" fill="currentColor"
                                                viewBox="0 0 20 20">
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
                <a href="{{ route('store.shop') }}"
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
