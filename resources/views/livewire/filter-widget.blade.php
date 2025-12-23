<aside class="lg:col-span-1 relative">
    <!-- FILTER RESULT OVERLAY -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-8 sticky top-6">
        <!-- Filter Header with Active Count -->
        <div class="flex items-center justify-between pb-4 border-b">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <h2 class="text-xl font-bold text-gray-900">Filters</h2>
                @if ($this->activeFilterCount > 0)
                    <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">
                        {{ $this->activeFilterCount }}
                    </span>
                @endif
            </div>
            <button type="button" wire:click="resetFilters"
                class="text-sm text-red-600 hover:text-red-800 font-medium flex items-center space-x-1 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span>Clear All</span>
            </button>
        </div>

        <!-- Search Box -->
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span>Search Products</span>
            </h3>
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="searchQuery" placeholder="Type to search..."
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 placeholder-gray-400">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="space-y-4">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Categories</span>
            </h3>

            <div class="space-y-2 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                <!-- All Categories -->
                <label
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-150 {{ !$selectedCategory ? 'bg-red-50 border border-red-100' : '' }}">
                    <div class="relative flex items-center">
                        <input type="radio" wire:model.live="selectedCategory" value="" class="sr-only peer">
                        <div
                            class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-red-600 peer-checked:bg-red-600 flex items-center justify-center transition-all duration-200">
                            <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-700">All Categories</span>
                    </div>
                </label>

                @foreach ($categories as $category)
                    <label
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-150 {{ $selectedCategory == $category->slug ? 'bg-red-50 border border-red-100' : '' }}">
                        <div class="relative flex items-center">
                            <input type="radio" wire:model.live="selectedCategory" value="{{ $category->slug }}"
                                class="sr-only peer">
                            <div
                                class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-red-600 peer-checked:bg-red-600 flex items-center justify-center transition-all duration-200">
                                <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-700">{{ $category->name }}</span>
                        </div>
                        @if (isset($category->products_count) && $category->products_count > 0)
                            <span class="ml-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                                {{ $category->products_count }}
                            </span>
                        @endif
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Price Range Filter -->
        <div class="space-y-4">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Price Range</span>
            </h3>

            <div class="space-y-4">
                {{-- <!-- Price Slider -->
                <div class="px-2">
                    <div class="relative h-2 bg-gray-200 rounded-lg mb-6">
                        <input type="range" min="{{ $fixedMinPrice }}" max="{{ $fixedMaxPrice }}"
                            wire:model.live="priceRange.0"
                            class="absolute w-full h-2 bg-transparent appearance-none pointer-events-none [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-red-600 [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:cursor-pointer"
                            style="z-index: 10;">
                        <input type="range" min="{{ $fixedMinPrice }}" max="{{ $fixedMaxPrice }}"
                            wire:model.live="priceRange.1"
                            class="absolute w-full h-2 bg-transparent appearance-none pointer-events-none [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-red-600 [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:cursor-pointer"
                            style="z-index: 11;">
                    </div>
                </div> --}}

                <!-- Price Inputs -->
                <div class="flex items-center justify-between space-x-4">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Min Price</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" wire:model.live="min_price" min="{{ $fixedMinPrice }}"
                                max="{{ $fixedMaxPrice }}"
                                class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>
                    </div>
                    <div class="text-gray-400 pt-5">-</div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Max Price</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" wire:model.live="max_price" min="{{ $fixedMinPrice }}"
                                max="{{ $fixedMaxPrice }}"
                                class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Brand Filter -->
        @if (count($brands) > 0)
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Brands</span>
                </h3>

                <div class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                    @foreach ($brands as $brand)
                        <label
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-150 {{ in_array($brand, $selectedBrands) ? 'bg-red-50 border border-red-100' : '' }}">
                            <div class="relative flex items-center">
                                <input type="checkbox" wire:click="toggleBrand('{{ $brand }}')"
                                    class="sr-only peer" {{ in_array($brand, $selectedBrands) ? 'checked' : '' }}>
                                <div
                                    class="w-5 h-5 border-2 border-gray-300 rounded peer-checked:border-red-600 peer-checked:bg-red-600 flex items-center justify-center transition-all duration-200">
                                    <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-700">{{ $brand }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Rating Filter -->
        {{-- <div class="space-y-4">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                <span>Customer Rating</span>
            </h3>

            <div class="space-y-2">
                @foreach ([5, 4, 3, 2, 1] as $rating)
                    <label
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-150 {{ in_array($rating, $selectedRatings) ? 'bg-red-50 border border-red-100' : '' }}">
                        <div class="relative flex items-center">
                            <input type="checkbox" wire:click="toggleRating({{ $rating }})"
                                class="sr-only peer" {{ in_array($rating, $selectedRatings) ? 'checked' : '' }}>
                            <div
                                class="w-5 h-5 border-2 border-gray-300 rounded peer-checked:border-red-600 peer-checked:bg-red-600 flex items-center justify-center transition-all duration-200">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-3 flex items-center space-x-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                                <span class="text-sm text-gray-600">& above</span>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
        </div> --}}

        <!-- Additional Filters -->
        {{-- <div class="space-y-4">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                <span>Additional Filters</span>
            </h3>

            <div class="space-y-3">
                <label
                    class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-150 {{ $inStockOnly ? 'bg-red-50 border border-red-100' : '' }}">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="checkbox" wire:model.live="inStockOnly" class="sr-only peer">
                            <div
                                class="w-5 h-5 border-2 border-gray-300 rounded peer-checked:border-red-600 peer-checked:bg-red-600 flex items-center justify-center transition-all duration-200">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-700">In Stock Only</span>
                    </div>
                    @if ($inStockOnly)
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </label>

                <label
                    class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-150 {{ $onSaleOnly ? 'bg-red-50 border border-red-100' : '' }}">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="checkbox" wire:model.live="onSaleOnly" class="sr-only peer">
                            <div
                                class="w-5 h-5 border-2 border-gray-300 rounded peer-checked:border-red-600 peer-checked:bg-red-600 flex items-center justify-center transition-all duration-200">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-700">On Sale</span>
                    </div>
                    @if ($onSaleOnly)
                        <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">SALE</span>
                    @endif
                </label>
            </div>
        </div> --}}

        <!-- Sort By -->
        <div class="space-y-4">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                </svg>
                <span>Sort By</span>
            </h3>

            <select wire:model.live="sortBy"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 appearance-none bg-white">
                <option value="default">Default Sorting</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
                <option value="popular">Most Popular</option>
                <option value="newest">Newest First</option>
                <option value="rating">Highest Rated</option>
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 border-t space-y-3">
            <button type="button" wire:click="search" wire:loading.attr="disabled"
                class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-3.5 rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl flex items-center justify-center space-x-2 disabled:opacity-70 disabled:cursor-not-allowed">
                <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <svg wire:loading class="animate-spin w-5 h-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span wire:loading.remove>Apply Filters</span>
                <span wire:loading>Applying...</span>
            </button>

            <button type="button" wire:click="resetFilters"
                class="w-full border border-gray-300 text-gray-700 hover:bg-gray-50 py-3 rounded-xl font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span>Reset Filters</span>
            </button>
        </div>
    </div>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Fix for range sliders */
        input[type="range"] {
            -webkit-appearance: none;
            width: 100%;
            height: 2px;
            background: transparent;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #dc2626;
            cursor: pointer;
            border: 3px solid white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        input[type="range"]::-moz-range-thumb {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #dc2626;
            cursor: pointer;
            border: 3px solid white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Ensure overlay is on top */
        #filter-overlay {
            z-index: 9999 !important;
        }
    </style>
</aside>


@script
    <script>
        const overlay = document.getElementById('filter-overlay');
        const closeBtn = document.getElementById('close-overlay');
        const overlayContent = overlay.querySelector('.bg-white');

        // Function to show overlay
        function showOverlay() {
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
            setTimeout(() => {
                overlayContent.classList.remove('scale-95', 'opacity-0');
                overlayContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Function to hide overlay
        function hideOverlay() {
            overlayContent.classList.remove('scale-100', 'opacity-100');
            overlayContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                overlay.classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling
            }, 300);
        }

        // Listen for filter-result event
        $wire.on('filter-result', ({
            html,
            resultCount
        }) => {
            console.log('Filter result received:', {
                html,
                resultCount
            }); // Debug log

            const resultsContainer = document.getElementById('filter-results-container');
            const resultCountElement = document.getElementById('result-count');
            const currentCountElement = document.getElementById('current-count');

            // Make sure html is a string
            if (typeof html !== 'string') {
                console.error('HTML is not a string:', html);
                return;
            }

            // Update count elements
            if (resultCount !== undefined) {
                resultCountElement.textContent =
                    `${resultCount} ${resultCount === 1 ? 'product' : 'products'} found`;
                currentCountElement.textContent = resultCount;
            }

            // Update results
            resultsContainer.innerHTML = html;

            // Show overlay
            showOverlay();

            // Smooth scroll to top of results
            overlay.querySelector('.overflow-y-auto').scrollTop = 0;
        });

        // Close button event
        closeBtn.addEventListener('click', hideOverlay);

        // Close overlay when clicking outside
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                hideOverlay();
            }
        });

        // Close with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !overlay.classList.contains('hidden')) {
                hideOverlay();
            }
        });

        // Initialize Livewire event listeners for auto-search
        document.addEventListener('livewire:initialized', () => {
            // Remove the manual slider handling since Livewire handles it now
            // The wire:model.live.debounce.300ms will automatically update the price

            // Auto-search on filter changes (for other inputs)
            const searchableInputs = document.querySelectorAll(
                'input[wire\\:model\\.live], select[wire\\:model\\.live]');
            let debounceTimer;

            searchableInputs.forEach(input => {
                // Skip price inputs since they have their own debounce
                if (input.name === 'min_price' || input.name === 'max_price' || input.hasAttribute(
                        'data-price-slider')) {
                    return;
                }

                input.addEventListener('change', () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        $wire.search();
                    }, 300);
                });
            });

            // Add visual feedback for price sliders
            const minSlider = document.querySelector('input[wire\\:model="min_price"][type="range"]');
            const maxSlider = document.querySelector('input[wire\\:model="max_price"][type="range"]');
            const minInput = document.querySelector('input[wire\\:model="min_price"][type="number"]');
            const maxInput = document.querySelector('input[wire\\:model="max_price"][type="number"]');

            // Update input fields when sliders change (visual sync)
            if (minSlider && minInput) {
                minSlider.addEventListener('input', (e) => {
                    minInput.value = e.target.value;
                });
            }

            if (maxSlider && maxInput) {
                maxSlider.addEventListener('input', (e) => {
                    maxInput.value = e.target.value;
                });
            }

            // Ensure min doesn't exceed max and vice versa
            if (minInput && maxInput) {
                minInput.addEventListener('change', (e) => {
                    const minValue = parseInt(e.target.value) || 0;
                    const maxValue = parseInt(maxInput.value) || 10000;

                    if (minValue > maxValue) {
                        maxInput.value = minValue;
                        if (maxSlider) maxSlider.value = minValue;
                    }
                });

                maxInput.addEventListener('change', (e) => {
                    const maxValue = parseInt(e.target.value) || 10000;
                    const minValue = parseInt(minInput.value) || 0;

                    if (maxValue < minValue) {
                        minInput.value = maxValue;
                        if (minSlider) minSlider.value = maxValue;
                    }
                });
            }
        });
    </script>
@endscript
