<aside class="lg:col-span-1">
    <!-- FILTER RESULT OVERLAY -->
    <div id="filter-overlay" class="fixed inset-0 z-50 hidden bg-black/70  flex items-center justify-center">

        <!-- Overlay Content -->
        <div class="bg-white w-full max-w-5xl max-h-[90vh] rounded-lg shadow-xl overflow-hidden">

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">
                    Filter Results
                </h3>

                <button id="close-overlay" class="text-gray-400 hover:text-gray-600 text-xl leading-none">
                    &times;
                </button>
            </div>
            <!-- Body (Results go here) -->
            <div class="p-6 overflow-y-auto">
                <div id="filter-results-container">
                </div>
            </div>

        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-5 space-y-6
                sticky top-0">

        <!-- Filter Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Filters</h2>
            <a href="{{ route('store.shop') }}" wire:lazy class="text-sm text-red-600 hover:underline">
                Clear All
            </a>
        </div>

        <!-- Category Filter -->
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                Categories
            </h3>

            <div class="space-y-2">

                <!-- All Categories -->
                <label class="flex items-center space-x-2 text-sm text-gray-600 cursor-pointer">
                    <input type="radio" wire:model.live="selectedCategory" value=""
                        class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                    <span>All Categories</span>
                </label>

                @foreach ($categories as $category)
                    <label class="flex items-center space-x-2 text-sm text-gray-600 cursor-pointer">
                        <input type="radio" wire:model.live="selectedCategory" value="{{ $category->slug }}"
                            class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span>{{ $category->name }}</span>
                    </label>
                @endforeach

            </div>

        </div>

        <!-- Price Range Filter -->
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                Price Range
            </h3>

            <div class="flex items-center space-x-3">
                <div class="text-center">
                    <label for="min">Min</label>
                    <input type="number" wire:model.live='min_price' placeholder="Min" min="0" id="min"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                <div class="text-center">
                    <label for="max">Max</label>
                    <input type="number" id="max" wire:model.live='max_price' max="{{ $fixedMaxPrice }}"
                        placeholder="Max"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
            </div>
        </div>

        <!-- Availability Filter -->
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                Availability
            </h3>

            <label class="flex items-center space-x-2 text-sm text-gray-600">
                <input type="checkbox" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                <span>In Stock</span>
            </label>

            <label class="flex items-center space-x-2 text-sm text-gray-600">
                <input type="checkbox" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                <span>Out of Stock</span>
            </label>
        </div>

        <!-- Apply Button -->
        <button wire:click='search' class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-500 transition">
            Apply Filters
        </button>

    </div>
</aside>
@script
    <script>
        const overlay = document.getElementById('filter-overlay');
        const closeBtn = document.getElementById('close-overlay');
        $wire.on('filter-result', (html) => {
            overlay.classList.remove('hidden');
            document.getElementById('filter-results-container').innerHTML = html;
        });
        closeBtn.addEventListener('click', () => {
            overlay.classList.add('hidden');
        });
    </script>
@endscript
