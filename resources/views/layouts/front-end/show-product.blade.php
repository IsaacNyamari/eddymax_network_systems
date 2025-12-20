@extends('layouts.front-end.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

        <!-- Product Hero / Breadcrumb -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
            <a href="{{ route('store.shop') }}"
                class="text-red-600 hover:text-red-500 font-semibold flex items-center mt-4 sm:mt-0">
                Back to Products
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
                <div class="rounded-xl overflow-hidden shadow-lg relative group cursor-zoom-in" id="zoom-container">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-96 object-cover transition-transform duration-300 group-hover:scale-105"
                        loading="lazy" id="main-product-image"
                        onerror="this.src='https://via.placeholder.com/600x400?text=Product+Image'">
                </div>

                <!-- Gallery Thumbnails -->
                <div class="grid grid-cols-4 gap-3">
                    <!-- Main Image Thumbnail -->
                    <div class="rounded-lg overflow-hidden shadow hover:shadow-lg transition border-2 border-red-500"
                        onclick="changeMainImage('{{ asset('storage/' . $product->image) }}', this)">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }} Thumbnail"
                            class="w-full h-24 object-cover" loading="lazy"
                            onerror="this.src='https://via.placeholder.com/150?text=Thumbnail'">
                    </div>

                    <!-- Additional Images Gallery -->
                    @if ($product->productImages && $product->productImages->count() > 0)
                        @foreach ($product->productImages as $image)
                            <div class="rounded-lg overflow-hidden shadow hover:shadow-lg transition border-2 border-gray-200 hover:border-red-500"
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
                <!-- Price & Badges -->
                <div class="flex items-center space-x-4">
                    <span class="text-3xl font-bold text-red-600">Ksh {{ number_format($product->price, 2) }}</span>
                    <span class="px-3 py-1 rounded-full bg-green-600 text-white font-semibold text-sm">
                        {{ $product->category->name }}
                    </span>
                </div>

                <!-- Short Description -->
                <p class="text-gray-700 text-lg">
                    {{ Str::limit($product->description, 75, '...') }}
                </p>

                <!-- Product Options -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <livewire:add-to-cart-button :product="$product" />
                        <button
                            class="border-2 border-gray-300 hover:border-red-500 px-4 py-3 rounded-lg transition transform hover:-translate-y-1 flex items-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Wishlist
                        </button>
                    </div>
                </div>

                <!-- Product Reviews -->
                <div class="mt-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Reviews</h3>
                    <div class="flex items-center mb-2">
                        <div class="flex text-yellow-400">
                            @for ($i = 1; $i <= 3; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <span class="text-gray-600 ml-2">(24 reviews)</span>
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
                            <div class="flex items-center justify-between">
                                <span class="text-red-600 font-bold">Ksh 12,499</span>
                                <livewire:add-to-cart-button :product="$product" />
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
