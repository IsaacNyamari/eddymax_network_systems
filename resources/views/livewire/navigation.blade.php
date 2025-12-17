@php
    $parents = App\Models\Category::with(['children.children'])
        ->whereNull('parent_id')
        ->orderBy('name')
        ->limit(10)
        ->get();
@endphp

<div class="bg-red-900">
    <nav class="bg-gradient-to-r from-maroon-50 to-rose-50 border-b border-maroon-100 shadow-sm" x-data="{ mobileMenuOpen: false }">
        <div class="container mx-auto px-4">
            {{-- Mobile Menu Button --}}
            <div class="flex justify-between items-center py-3 lg:hidden">
                <div class="text-xl font-bold text-maroon-800">Logo</div>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-slate-700 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16">
                        </path>
                    </svg>
                </button>
            </div>

            {{-- Desktop & Mobile Menu --}}
            <div :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" class="hidden lg:block">
                <ul
                    class="flex flex-col lg:flex-row lg:flex-wrap lg:justify-center lg:items-center lg:space-x-1 space-y-2 lg:space-y-0 py-2 lg:py-0">



                    {{-- Dynamic Categories --}}
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
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                                                        <circle cx="4" cy="4" r="3" />
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
        </div>
    </nav>
</div>
