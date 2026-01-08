@extends('layouts.front-end.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

        <!-- Product Hero / Breadcrumb -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
            <a href="{{ route('store.shop') }}"
                class="text-red-600 hover:text-red-500 font-semibold flex items-center mt-32 sm:mt-0">
                Back
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </div>

        <!-- Product Details Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Product Images with Gallery -->
            <div class="space-y-4">
                <!-- Main Image with Zoom -->
                <div class="rounded-xl bg-blue-800 hover:bg-blue-800 overflow-hidden shadow-lg relative group cursor-zoom-in"
                    id="zoom-container">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-96 object-cover transition-transform duration-300 group-hover:scale-105"
                        loading="lazy" id="main-product-image"
                        onerror="this.src='https://via.placeholder.com/600x400?text=Product+Image'">
                </div>

                <!-- Gallery Thumbnails -->
                <div class="grid grid-cols-4 gap-3">
                    <!-- Main Image Thumbnail -->
                    <div class="rounded-lg overflow-hidden shadow cursor-pointer hover:shadow-lg transition border-2 border-red-500"
                        onclick="changeMainImage('{{ asset('storage/' . $product->image) }}', this)">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }} Thumbnail"
                            class="w-full h-24 object-cover" loading="lazy"
                            onerror="this.src='https://via.placeholder.com/150?text=Thumbnail'">
                    </div>

                    <!-- Additional Images Gallery -->
                    @if ($product->productImages && $product->productImages->count() > 0)
                        @foreach ($product->productImages as $image)
                            <div class="rounded-lg overflow-hidden cursor-pointer shadow hover:shadow-lg transition border-2 border-gray-200 hover:border-red-500"
                                onclick="changeMainImage('{{ asset('storage/' . $image->path) }}', this)">
                                <img src="{{ asset('storage/' . $image->path) }}"
                                    alt="Product Image {{ $loop->iteration + 1 }}" class="w-full h-24 object-cover"
                                    loading="lazy"
                                    onerror="this.src='https://via.placeholder.com/150?text=Image+{{ $loop->iteration + 1 }}'">
                            </div>
                        @endforeach
                    @endif

                    <!-- If no additional images, show placeholders -->
                    @if (!$product->productImages || $product->productImages->count() == 0)
                        @for ($i = 1; $i <= 3; $i++)
                            <div class="rounded-lg overflow-hidden shadow hover:shadow-lg transition opacity-50">
                                <img src="https://via.placeholder.com/150?text=Image+{{ $i }}"
                                    alt="Thumbnail {{ $i }}" class="w-full h-24 object-cover grayscale"
                                    loading="lazy">
                            </div>
                        @endfor
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <!-- Price & Stock Status -->
                <div class="space-y-3">
                    <!-- Price -->
                    <div class="flex items-center">
                        <span class="text-3xl font-bold text-red-600">Ksh {{ number_format($product->price, 2) }}</span>
                    </div>

                    <!-- Stock Status & Category -->
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Stock Badge -->
                        @if ($product->stock_status == 'in_stock')
                            <div
                                class="inline-flex items-center px-3 py-1.5 rounded-full bg-green-100 text-green-800 font-semibold text-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                In Stock
                                @if ($product->stock_quantity > 0 && $product->stock_quantity < 10)
                                    <span class="ml-1">(Only {{ $product->stock_quantity }} left)</span>
                                @endif
                            </div>
                        @elseif($product->stock_status == 'out_of_stock')
                            <div
                                class="inline-flex items-center px-3 py-1.5 rounded-full bg-red-100 text-red-800 font-semibold text-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                Out of Stock
                            </div>
                        @elseif($product->stock_status == 'backorder')
                            <div
                                class="inline-flex items-center px-3 py-1.5 rounded-full bg-yellow-100 text-yellow-800 font-semibold text-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Available on Backorder
                            </div>
                        @endif

                        <!-- Category Badge -->
                        <span class="px-3 py-1.5 rounded-full bg-blue-100 text-blue-800 font-semibold text-sm">
                            {{ $product->category->name }}
                        </span>
                        @if ($product->unitable)
                            <span class="px-3 py-1.5 rounded-full bg-blue-100 text-blue-800 font-semibold text-sm">
                                {{ $product->unitable?->name }}
                            </span>
                        @endif
                    </div>
                </div>
                <!-- Short Description -->
                @if ($product->short_description)
                    <div class="bg-white rounded-lg shadow p-4 mb-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-2">Product Overview</h3>
                        <p class="text-gray-700">
                            {{ Str::limit(strip_tags($product->short_description), 75, '...') }}
                        </p>
                    </div>
                @endif

                <!-- Product Options -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        @if ($product->stock_status == 'in_stock' || $product->stock_status == 'backorder')
                            <livewire:add-to-cart-button :product="$product" />
                        @else
                            <button disabled
                                class="px-6 py-3 bg-gray-300 text-gray-500 rounded-lg font-semibold cursor-not-allowed">
                                Out of Stock
                            </button>
                        @endif
                        <livewire:wishlist-toggle :product="$product" />
                    </div>
                </div>

                <!-- Product Reviews -->
                <div class="mt-4" wire:poll.5s>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Reviews</h3>
                    <div class="flex items-center mb-2">
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
                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <div class="absolute top-0 left-0 w-1/2 overflow-hidden">
                                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    {{-- Empty star --}}
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-gray-600 ml-2">({{ $ratingCount }}
                            review{{ $ratingCount !== 1 ? 's' : '' }})</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Add some CSS for the zoom effect -->
        <style>
            #zoom-container {
                position: relative;
                overflow: hidden;
            }

            .zoomable-image {
                transition: transform 0.3s ease;
                cursor: zoom-in;
            }

            .zoomable-image:hover {
                transform: scale(1.5);
                cursor: zoom-out;
            }

            .thumbnail-active {
                border-color: #dc2626 !important;
                /* red-600 */
                box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.3);
            }
        </style>

        <!-- Product Description / Details -->
        <div class="bg-gray-50 p-8 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Product Details</h2>
            <p class="text-gray-700 leading-relaxed">
                {!! $product->description !!}
            </p>




        </div>
        <div class="mt-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Add a review</h2>
            <livewire:reviews :product='$product'>
        </div>
        <!-- Related Products -->
        <div>
            @php
                $relatedProducts = $relatedProducts ?? collect();
                if ($relatedProducts->isEmpty()) {
                    $relatedProducts = \App\Models\Product::latest()->where('id', '!=', $product->id)->take(4)->get();
                    $title = 'Latest Products';
                } else {
                    $title = 'Related Products';
                }
            @endphp

            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $title }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($relatedProducts as $product)
                    <div
                        class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Related Product {{ $product->name }}"
                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="p-4">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $product->name }}</h3>
                            </a>

                            <!-- Stock badge in related products -->
                            @if ($product->stock_status == 'in_stock')
                                <div class="mb-2">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        In Stock
                                    </span>
                                </div>
                            @elseif($product->stock_status == 'out_of_stock')
                                <div class="mb-2">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        Out of Stock
                                    </span>
                                </div>
                            @endif

                            <div class="flex items-center justify-between">
                                <span class="text-red-600 font-bold">Ksh {{ number_format($product->price, 2) }}</span>
                                @if ($product->stock_status == 'in_stock' || $product->stock_status == 'backorder')
                                    <livewire:add-to-cart-button :product="$product" />
                                @else
                                    <button disabled
                                        class="px-3 py-1.5 bg-gray-200 text-gray-500 text-sm rounded cursor-not-allowed">
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    <!-- JavaScript for image switching -->
    <script>
        function changeMainImage(imageUrl, clickedElement) {
            // Update main image
            const mainImage = document.getElementById('main-product-image');
            mainImage.src = imageUrl;

            // Remove active class from all thumbnails
            const thumbnails = document.querySelectorAll('.grid-cols-4 > div');
            thumbnails.forEach(thumb => {
                thumb.classList.remove('thumbnail-active');
                thumb.classList.remove('border-red-500');
                thumb.classList.add('border-gray-200');
            });

            // Add active class to clicked thumbnail
            clickedElement.classList.remove('border-gray-200');
            clickedElement.classList.add('border-red-500', 'thumbnail-active');
        }

        // Add click-to-zoom functionality
        document.addEventListener('DOMContentLoaded', function() {
            const zoomContainer = document.getElementById('zoom-container');
            const mainImage = document.getElementById('main-product-image');

            zoomContainer.addEventListener('click', function() {
                if (mainImage.classList.contains('zoomable-image')) {
                    mainImage.classList.remove('zoomable-image');
                    zoomContainer.classList.remove('cursor-zoom-out');
                    zoomContainer.classList.add('cursor-zoom-in');
                } else {
                    mainImage.classList.add('zoomable-image');
                    zoomContainer.classList.remove('cursor-zoom-in');
                    zoomContainer.classList.add('cursor-zoom-out');
                }
            });
        });
    </script>
@endsection

@section('structured-data')
    @php
        // Prepare images array
        $images = [asset('storage/' . $product->image)];
        if ($product->productImages && $product->productImages->count() > 0) {
            foreach ($product->productImages as $image) {
                $images[] = asset('storage/' . $image->path);
            }
        }

        // Determine availability
        if ($product->stock_status == 'in_stock') {
            $availability = 'https://schema.org/InStock';
        } elseif ($product->stock_status == 'backorder') {
            $availability = 'https://schema.org/BackOrder';
        } else {
            $availability = 'https://schema.org/OutOfStock';
        }
    @endphp

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->name,
        'image' => $images,
        'description' => Str::limit(strip_tags($product->description), 150),
        'sku' => $product->id,
        'offers' => [
            '@type' => 'Offer',
            'availability' => $availability,
            'price' => $product->price,
            'priceCurrency' => 'KES',
            'priceValidUntil' => \Carbon\Carbon::now()->addYear()->format('Y-m-d'),
            'shippingDetails' => [
                '@type' => 'OfferShippingDetails',
                'shippingRate' => [
                    '@type' => 'MonetaryAmount',
                    'value' => '0',
                    'currency' => 'KES',
                ],
            ],
        ],
        'brand' => [
            '@type' => 'Brand',
            'name' => 'Cameras Africa',
        ],
        'category' => $product->category->name,
    ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
    </script>
@endsection
