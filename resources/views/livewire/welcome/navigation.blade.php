<div>
    @php
        header('Content-Type: Application/json');
        $parents = App\Models\Category::with(['children'])
            ->whereNull('parent_id')
            ->orderBy('name')
            ->limit(10)
            ->get();

    @endphp
    <nav class="bg-white border-default">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-4 py-2.5">
            <!-- Mobile menu button (hidden on desktop) -->
            <button data-collapse-toggle="navbar-dropdown" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-heading bg-white box-border border border-white hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base focus:outline-none md:hidden"
                aria-controls="navbar-dropdown" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                </svg>
            </button>



            <!-- Navigation menu (visible on all devices) -->
            <div class="w-full md:w-auto hidden md:block" id="navbar-dropdown">
                <ul
                    class="flex flex-col font-medium p-4 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:mt-0 md:text-sm md:border-0 md:bg-white md:space-x-8 md:rtl:space-x-reverse md:space-y-0 md:p-0 space-y-0">
                    @foreach ($parents as $category)
                        <li class="relative group">
                            @if (isset($category->children) && $category->children->count() > 0)
                                <!-- Parent category with dropdown -->
                                <button id="dropdownNavbarLink-{{ $category->slug }}"
                                    class="flex items-center justify-between w-full py-3 px-4 text-body rounded hover:bg-white md:hover:bg-white md:border-0 md:hover:text-fg-brand md:p-0 md:w-auto md:group-hover:text-fg-brand transition-colors duration-200">
                                    <span
                                        class="text-lg md:text-base font-semibold md:font-normal">{{ $category->name }}</span>
                                    <svg class="w-5 h-5 ms-2 md:w-4 md:h-4 md:ms-1.5 transform group-hover:rotate-180 transition-transform duration-200"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 9-7 7-7-7" />
                                    </svg>
                                </button>
                                <!-- Dropdown menu for children - MOBILE (Full width) -->
                                <div id="dropdownNavbar-mobile-{{ $category->slug }}"
                                    class="md:hidden bg-white border-t border-b border-default-medium shadow-lg w-full left-0 px-4 py-3">
                                    {{-- <div
                                        class="flex items-center justify-between mb-3 pb-2 border-b border-default-soft">
                                        <button onclick="goBackToParent('{{ $category->slug }}')"
                                            class="flex items-center text-fg-brand hover:text-fg-brand-dark">
                                            <svg class="w-5 h-5 mr-2" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M5 12h14M5 12l4-4m-4 4 4 4" />
                                            </svg>
                                            <span class="font-semibold">Back</span>
                                        </button>
                                        <h3 class="text-lg font-bold text-heading">{{ $category->name }}</h3>
                                        <div class="w-12"></div> <!-- Spacer for centering -->
                                    </div> --}}

                                    <ul class="space-y-1">
                                        @foreach ($category->children as $child)
                                            <li class="border-b border-default-soft last:border-b-0">
                                                @if (isset($child->children) && $child->children->count() > 0)
                                                    <!-- Child category with grandchildren dropdown - MOBILE -->
                                                    <button
                                                        onclick="showGrandchildren('{{ $child->slug }}', '{{ $child->name }}')"
                                                        class="flex items-center justify-between w-full py-3 px-2 text-body hover:bg-neutral-secondary-soft rounded-lg transition-colors duration-150">
                                                        <span class="text-base font-medium">{{ $child->name }}</span>
                                                        <svg class="w-5 h-5 text-neutral-tertiary" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m9 5 7 7-7 7" />
                                                        </svg>
                                                    </button>
                                                    <!-- Grandchildren dropdown - MOBILE -->
                                                    <div id="grandchildren-{{ $child->slug }}"
                                                        class="hidden bg-white border-l-4 border-fg-brand pl-4 ml-2 mt-1 mb-2">
                                                        <ul class="space-y-1">
                                                            @foreach ($child->children as $grandchild)
                                                                <li>
                                                                    <a href="{{ route('store.filter.category', $grandchild->slug) }}"
                                                                        class="flex items-center w-full py-2 px-3 text-sm text-body hover:bg-neutral-secondary-soft hover:text-heading rounded-lg transition-colors duration-150">
                                                                        <span
                                                                            class="w-2 h-2 bg-neutral-tertiary rounded-full mr-3"></span>
                                                                        {{ $grandchild->name }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <!-- Child category without grandchildren (direct link) - MOBILE -->
                                                    <a href="{{ route('store.filter.category', $child->slug) }}"
                                                        class="flex items-center w-full py-3 px-2 text-body hover:bg-neutral-secondary-soft hover:text-heading rounded-lg transition-colors duration-150">
                                                        <span class="text-base font-medium">{{ $child->name }}</span>
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Dropdown menu for children - DESKTOP (Centered) -->
                                <div id="dropdownNavbar-{{ $category->slug }}"
                                    class="hidden md:group-hover:block absolute z-50 top-full left-1/2 transform -translate-x-1/2 mt-1 w-64 bg-white border border-default-medium rounded-lg shadow-xl">
                                    <div class="relative">
                                        <!-- Arrow pointing up -->
                                        <div class="absolute -top-2 left-1/2 transform -translate-x-1/2">
                                            <div
                                                class="w-4 h-4 bg-white border-t border-l border-default-medium rotate-45">
                                            </div>
                                        </div>

                                        <ul class="p-3 space-y-1">
                                            @foreach ($category->children as $child)
                                                <li class="group/child relative">
                                                    @if (isset($child->children) && $child->children->count() > 0)
                                                        <!-- Child category with grandchildren - DESKTOP -->
                                                        <div
                                                            class="flex items-center justify-between p-2 hover:bg-neutral-secondary-soft rounded-lg transition-colors duration-150 cursor-pointer">
                                                            <span
                                                                class="text-sm font-medium text-body group-hover/child:text-heading">{{ $child->name }}</span>
                                                            <svg class="w-3 h-3 text-neutral-tertiary"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="none"
                                                                viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="m9 5 7 7-7 7" />
                                                            </svg>
                                                        </div>
                                                        <!-- Grandchildren dropdown - DESKTOP -->
                                                        <div
                                                            class="hidden group-hover/child:block absolute left-full top-0 ml-1 w-56 bg-white border border-default-medium rounded-lg shadow-xl z-50">
                                                            <div class="p-3">
                                                                <h4
                                                                    class="text-xs font-semibold text-neutral-tertiary uppercase tracking-wider mb-2 px-2">
                                                                    {{ $child->name }}
                                                                </h4>
                                                                <ul class="space-y-1">
                                                                    @foreach ($child->children as $grandchild)
                                                                        <li>
                                                                            <a href="{{ route('store.filter.category', $grandchild->slug) }}"
                                                                                class="flex items-center p-2 text-sm text-body hover:bg-neutral-secondary-soft hover:text-heading rounded-lg transition-colors duration-150">
                                                                                <span
                                                                                    class="w-1.5 h-1.5 bg-neutral-tertiary rounded-full mr-3"></span>
                                                                                {{ $grandchild->name }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <!-- Child category without grandchildren - DESKTOP -->
                                                        <a href="{{ route('store.filter.category', $child->slug) }}"
                                                            class="flex items-center p-2 text-sm text-body hover:bg-neutral-secondary-soft hover:text-heading rounded-lg transition-colors duration-150">
                                                            <span class="font-medium">{{ $child->name }}</span>
                                                        </a>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <!-- Parent category without children (direct link) -->
                                <a href="{{ route('store.filter.category', $category->slug) }}"
                                    class="flex items-center justify-between w-full py-3 px-4 text-body rounded hover:bg-white md:hover:bg-white md:border-0 md:hover:text-fg-brand md:p-0 md:w-auto transition-colors duration-200">
                                    <span
                                        class="text-lg md:text-base font-semibold md:font-normal">{{ $category->name }}</span>
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile navigation overlay -->
    <div id="mobile-nav-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>
    <script>
        // Mobile navigation functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('[data-collapse-toggle="navbar-dropdown"]');
            const mobileNav = document.getElementById('navbar-dropdown');
            const mobileOverlay = document.getElementById('mobile-nav-overlay');

            // Toggle mobile menu
            mobileMenuButton.addEventListener('click', function() {
                const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                mobileNav.classList.toggle('hidden');
                mobileNav.classList.toggle('block');
                mobileNav.classList.toggle('fixed');
                mobileNav.classList.toggle('absolute');
                mobileNav.classList.toggle('top-16');
                mobileNav.classList.toggle('left-0');
                mobileNav.classList.toggle('right-0');
                mobileNav.classList.toggle('bg-white');
                mobileNav.classList.toggle('z-50');
                mobileNav.classList.toggle('max-h-[calc(100vh-4rem)]');
                mobileNav.classList.toggle('overflow-y-auto');
                mobileOverlay.classList.toggle('hidden');

                // Add/remove body scroll lock
                document.body.style.overflow = !isExpanded ? 'hidden' : '';
            });

            // Close mobile menu when clicking overlay
            mobileOverlay.addEventListener('click', function() {
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                mobileNav.classList.add('hidden');
                mobileNav.classList.remove('block', 'fixed', 'absolute', 'top-16', 'left-0', 'right-0',
                    'bg-white', 'z-50', 'max-h-[calc(100vh-4rem)]', 'overflow-y-auto');
                mobileOverlay.classList.add('hidden');
                document.body.style.overflow = '';
            });

            // Close dropdowns when clicking outside on desktop
            document.addEventListener('click', function(event) {
                if (window.innerWidth >= 768) {
                    const dropdowns = document.querySelectorAll('[id^="dropdownNavbar-"]');
                    dropdowns.forEach(dropdown => {
                        if (!dropdown.contains(event.target) && !event.target.closest(
                                '[data-dropdown-toggle]')) {
                            dropdown.classList.remove('block');
                        }
                    });
                }
            });
        });

        // Mobile-specific functions
        function showGrandchildren(childSlug, childName) {
            const grandchildrenMenu = document.getElementById(`grandchildren-${childSlug}`);
            grandchildrenMenu.classList.toggle('hidden');

            // Add animation
            if (!grandchildrenMenu.classList.contains('hidden')) {
                grandchildrenMenu.style.maxHeight = '0';
                grandchildrenMenu.style.overflow = 'hidden';
                const scrollHeight = grandchildrenMenu.scrollHeight;
                grandchildrenMenu.style.maxHeight = scrollHeight + 'px';
                setTimeout(() => {
                    grandchildrenMenu.style.maxHeight = 'none';
                }, 300);
            }
        }

        function goBackToParent(categorySlug) {
            const mobileDropdown = document.getElementById(`dropdownNavbar-mobile-${categorySlug}`);
            if (mobileDropdown) {
                // Close all grandchildren menus
                const grandchildrenMenus = mobileDropdown.querySelectorAll('[id^="grandchildren-"]');
                grandchildrenMenus.forEach(menu => {
                    menu.classList.add('hidden');
                    menu.style.maxHeight = '';
                });
            }
        }

        // Initialize mobile dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth transition to grandchildren menus
            const grandchildrenMenus = document.querySelectorAll('[id^="grandchildren-"]');
            grandchildrenMenus.forEach(menu => {
                menu.style.transition = 'max-height 0.3s ease-out';
            });
        });
    </script>

    <style>
        /* Custom scrollbar for mobile menu */
        #navbar-dropdown::-webkit-scrollbar {
            width: 4px;
        }

        #navbar-dropdown::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 2px;
        }

        #navbar-dropdown::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 2px;
        }

        #navbar-dropdown::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Smooth transitions */
        #navbar-dropdown,
        [id^="dropdownNavbar-"],
        [id^="grandchildren-"] {
            transition: all 1s ease;
        }

        /* Mobile menu animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #navbar-dropdown.block {
            animation: slideIn 1s ease forwards;
        }
    </style>
</div>
