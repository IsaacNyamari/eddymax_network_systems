<div class="flex flex-column gap-2 w-full">
    <div class="w-full">
        <x-text-input class="w-full" wire:model.live="search" placeholder="Search for any product..." />
    </div>
    <div class="grid grid-cols-2 gap-1 sm:grid-cols-4 lg:grid-cols-3 xl:grid-cols-3 w-full md:gap-6">

        @foreach ($products as $product)
            <div
                class="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">

                <!-- Image Container -->
                <div class="relative aspect-square overflow-hidden bg-gray-50 flex-shrink-0">
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
    <div class="mt-2">{{ $products->links() }}</div>
</div>
