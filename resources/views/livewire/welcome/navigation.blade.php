@php
    $parents = App\Models\Category::with(['children.children'])
        ->whereNull('parent_id')
        ->orderBy('name')
        ->limit(10)
        ->get();
@endphp

<div class="bg-red-900" x-data="navSearch()">
    <nav class="bg-gradient-to-r from-maroon-50 to-rose-50 border-b border-maroon-100 shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                {{-- Mobile Top Bar --}}
                <div class="flex justify-between items-center py-3 lg:hidden">
                    <button @click="navMobileMenuOpen = !navMobileMenuOpen"
                        class="p-2 rounded-lg text-slate-700 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16">
                            </path>
                        </svg>
                    </button>

                    {{-- Mobile Search Button --}}
                    <button @click="navMobileSearchOpen = !navMobileSearchOpen"
                        class="p-2 rounded-lg text-slate-700 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                            </path>
                        </svg>
                    </button>
                </div>

                {{-- Mobile Search Panel --}}
                <div x-show="navMobileSearchOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    class="lg:hidden bg-white border-t border-b border-gray-200 py-4 px-4">
                    <form action="{{ route('store.search.index') }}" method="GET" class="relative">
                        <div class="relative">
                            <input type="text" name="q" x-model="navSearchQuery"
                                @input.debounce.300ms="navPerformSearch($event.target.value)"
                                class="w-full px-4 py-3 pl-10 pr-12 rounded-lg border border-gray-300 focus:border-red-600 focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 focus:outline-none transition duration-200"
                                placeholder="Search routers, CCTV, laptops, software..." value="{{ request('q') }}"
                                autocomplete="off">

                            {{-- Search Icon --}}
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                    </path>
                                </svg>
                            </div>

                            {{-- Close Button --}}
                            <button @click="navMobileSearchOpen = false" type="button"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 p-1">
                                <svg class="w-5 h-5 text-gray-400 hover:text-gray-600 transition" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        {{-- Mobile Search Suggestions --}}
                        <div x-show="navSearchQuery.length >= 2" x-cloak
                            class="mt-2 bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
                            <div class="py-2">
                                <div x-show="navSearchLoading" class="px-4 py-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-red-600"></div>
                                        <span class="text-gray-600">Searching...</span>
                                    </div>
                                </div>

                                <div x-show="!navSearchLoading">
                                    <template x-if="navSearchResults.length === 0">
                                        <div class="px-4 py-3 text-gray-500 text-center">
                                            <p>No products found for "<span x-text="navSearchQuery"></span>"</p>
                                        </div>
                                    </template>

                                    <template x-if="navSearchResults.length > 0">
                                        <div class="max-h-64 overflow-y-auto">
                                            <template x-for="product in navSearchResults" :key="product.id">
                                                <a :href="product.url" @click="navMobileSearchOpen = false"
                                                    class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                                    <div class="flex items-center space-x-3">
                                                        <img :src="product.image" :alt="product.name"
                                                            class="w-10 h-10 rounded object-cover flex-shrink-0">
                                                        <div class="flex-1 min-w-0">
                                                            <h4 class="text-sm font-medium text-gray-900 truncate"
                                                                x-text="product.name"></h4>
                                                            <p class="text-xs text-gray-500 truncate"
                                                                x-text="product.category"></p>
                                                        </div>
                                                        <div class="text-red-600 font-semibold text-sm">
                                                            KES <span x-text="product.price"></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Desktop & Mobile Menu --}}
                <div :class="{ 'block': navMobileMenuOpen, 'hidden': !navMobileMenuOpen }"
                    class="hidden lg:block flex-1">
                    <ul
                        class="flex flex-col lg:flex-row lg:flex-wrap lg:justify-center lg:items-center lg:space-x-1 space-y-2 lg:space-y-0 py-2 lg:py-0">
                        @foreach ($parents as $parent)
                            <li class="relative group" x-data="{ open: false }"
                                @mouseenter="if(window.innerWidth >= 1024) open = true"
                                @mouseleave="if(window.innerWidth >= 1024) open = false">

                                {{-- Parent link --}}
                                <button type="button"
                                    @click="if(window.innerWidth < 1024) { 
                                        open = !open; 
                                        $event.stopPropagation(); 
                                    }"
                                    class="flex items-center text-white justify-between w-full lg:w-auto px-4 lg:px-5 py-3 rounded-lg transition-all duration-300
                                           hover:text-white
                                           group-hover:shadow-sm group-hover:-translate-y-0.5
                                           font-medium text-left">
                                    <span class="flex items-center">
                                        {{ $parent->name }}
                                        @if ($parent->children->count())
                                            <svg class="w-3 h-3 ml-1.5 transition-transform duration-300"
                                                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        @endif
                                    </span>
                                </button>

                                {{-- Dropdown - CENTERED IN PAGE --}}
                                @if ($parent->children->count())
                                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-2"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-2"
                                        class="
                                            fixed
                                            top-20
                                            left-1/2 -translate-x-1/2

                                            w-[95%] sm:w-[90%] lg:w-[800px] lg:max-w-[90vw]

                                            bg-white
                                            rounded-lg lg:rounded-xl
                                            shadow-2xl
                                            border border-maroon-100
                                            p-4 lg:p-6
                                            z-50
                                            overflow-hidden
                                        ">

                                        {{-- Gradient top border --}}
                                        <div
                                            class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-maroon-500 to-rose-500">
                                        </div>

                                        {{-- Close button for mobile --}}
                                        <button @click="open = false"
                                            class="absolute top-4 right-4 lg:hidden p-1 rounded-full bg-white-100 text-white-800 hover:text-white hover:bg-maroon-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>

                                        {{-- Dropdown header --}}
                                        <h3
                                            class="text-lg font-bold text-slate-800 mb-4 lg:mb-6 px-2 flex items-center gap-2">
                                            {{ $parent->name }}
                                        </h3>

                                        {{-- Content grid --}}
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                                            @foreach ($parent->children as $child)
                                                <div class="space-y-2 lg:space-y-3">
                                                    {{-- Child header --}}
                                                    <div class="flex items-center gap-2 mb-1 lg:mb-2">
                                                        <div class="w-1.5 h-1.5 bg-maroon-400 rounded-full"></div>
                                                        <h4 class="font-semibold text-slate-800 text-sm">
                                                            {{ $child->name }}
                                                        </h4>
                                                    </div>

                                                    {{-- Grandchildren list --}}
                                                    @if ($child->children->count())
                                                        <ul class="space-y-1 lg:space-y-1.5">
                                                            @foreach ($child->children as $grandchild)
                                                                <li>
                                                                    <a href="{{ route('store.filter.category', $grandchild->slug) }}"
                                                                        class="block px-3 py-1.5 rounded-md text-sm text-slate-600 
                                                                               hover:text-black hover:bg-maroon-600
                                                                               transition-colors duration-150
                                                                               border-l-2 border-transparent hover:border-maroon-400
                                                                               flex items-center gap-2">
                                                                        <svg class="w-2 h-2 text-maroon-400 group-hover:text-black"
                                                                            fill="currentColor" viewBox="0 0 8 8">
                                                                            <circle cx="4" cy="4"
                                                                                r="3" />
                                                                        </svg>
                                                                        {{ $grandchild->name }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        {{-- Direct child link if no grandchildren --}}
                                                        <a href="{{ route('store.filter.category', $child->slug) }}"
                                                            class="block px-3 py-1.5 rounded-md text-sm text-slate-600 
                                                                   hover:text-black hover:bg-maroon-600
                                                                   transition-colors duration-150
                                                                   border-l-2 border-transparent hover:border-maroon-400
                                                                   flex items-center gap-2">
                                                            <svg class="w-2 h-2 text-maroon-400 group-hover:text-black"
                                                                fill="currentColor" viewBox="0 0 8 8">
                                                                <circle cx="4" cy="4" r="3" />
                                                            </svg>
                                                            {{ $child->name }}
                                                        </a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Desktop Cart/Actions Area --}}
                <div class="hidden lg:flex items-center space-x-4 ml-4">
                    <a href="{{ route('store.cart') }}" class="relative p-2 text-white hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            <livewire:cart-count />
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Desktop Search Bar (BELOW the navigation but INSIDE the same Alpine component) --}}

</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('navSearch', () => ({
                navMobileMenuOpen: false,
                navMobileSearchOpen: false,
                navSearchQuery: '',
                navSearchSuggestionsOpen: false,
                navSearchLoading: false,
                navSearchResults: [],

                navPerformSearch(query) {
                    if (query.length < 2) {
                        this.navSearchResults = [];
                        return;
                    }

                    this.navSearchLoading = true;

                    fetch(`/search/quick?q=${encodeURIComponent(query)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.navSearchResults = data;
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            this.navSearchResults = [];
                        })
                        .finally(() => {
                            this.navSearchLoading = false;
                        });
                }
            }));
        });
    </script>

    <style>
        /* Custom scrollbar for search results */
        .max-h-96::-webkit-scrollbar,
        .max-h-64::-webkit-scrollbar {
            width: 6px;
        }

        .max-h-96::-webkit-scrollbar-track,
        .max-h-64::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .max-h-96::-webkit-scrollbar-thumb,
        .max-h-64::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .max-h-96::-webkit-scrollbar-thumb:hover,
        .max-h-64::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Ensure dropdown appears above other elements */
        [x-cloak] {
            display: none !important;
        }

        /* Search input focus styles */
        #navbar-search-input:focus,
        input[name="q"]:focus {
            box-shadow: 0 0 0 4px rgba(185, 28, 28, 0.15);
        }

        /* Animation for search results */
        .search-result-enter {
            opacity: 0;
            transform: translateY(-10px);
        }

        .search-result-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 200ms, transform 200ms;
        }
    </style>
@endpush
