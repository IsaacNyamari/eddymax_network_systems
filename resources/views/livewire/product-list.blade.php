<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mb-4 gap-6">
        @foreach ($products as $product)
            <div
                class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}"
                        class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500"
                        loading="lazy"
                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIwIiBoZWlnaHQ9IjIyNCIgdmlld0JveD0iMCAwIDMyMCAyMjQiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iI2YzZjRmNiIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwsc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzZjNzU3ZCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPnthcHBsaWNhdGlvbiBzZXR0aW5nc31Qcm9kdWN0IEltYWdlPC90ZXh0Pjwvc3ZnPg=='">
                    @if ($product['badge'])
                        <div
                            class="absolute top-3 left-3 bg-{{ $product['badge'] == 'Sale' ? 'red' : ($product['badge'] == 'New' ? 'green' : 'blue') }}-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                            {{ $product['badge'] }}
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
                    <a href="{{ route('products.show', $product->slug) }}"  >
                        <h3 class="font-semibold text-lg text-gray-900 mb-2 group-hover:text-red-600 transition">
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
                        <div class="">
                            <livewire:add-to-cart-button :product="$product" />
                        </div>
                    </div>
                    <div class="mt-3 flex items-center">
                        <div class="flex text-yellow-400">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600 ml-2">(24 reviews)</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
