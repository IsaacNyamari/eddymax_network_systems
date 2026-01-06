<div>
    @php
        $parents = App\Models\Category::with(['children.children'])
            ->whereNull('parent_id')
            ->orderBy('name')
            ->limit(10)
            ->get();

        $order = [
            'Networking' => 1,
            'Security Systems' => 2,
            'Computing' => 3,
            'Solar Solutions' => 4,
            'Electronics' => 5,
            'Telephones' => 6,
            'Accessories' => 7,
        ];

        $sortedParents = $parents->sortBy(function ($category) use ($order) {
            return $order[$category->name] ?? 999;
        });
    @endphp

    <!-- Desktop Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-0 d-none d-lg-block"
        aria-label="Main navigation">
        <div class="container-fluid px-0">
            <ul class="navbar-nav w-100 justify-content-between m-0" role="menubar">
                @foreach ($sortedParents as $category)
                    @php
                        $hasChildren = $category->children->count() > 0;
                        $isActive = request()->is('category/' . $category->slug . '*');
                    @endphp

                    <li class="nav-item dropdown position-static" role="none">
                        @if ($hasChildren)
                            <!-- Parent category with dropdown -->
                            <a class="nav-link dropdown-toggle px-4 py-3 d-flex align-items-center {{ $isActive ? 'active' : '' }}"
                                href="{{ route('store.filter.category', $category->slug) }}"
                                id="dropdown-{{ $category->slug }}" role="menuitem" aria-haspopup="true"
                                aria-expanded="false" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <span class="fw-semibold">{{ $category->name }}</span>
                            </a>

                            <!-- Mega dropdown menu -->
                            <div class="dropdown-menu dropdown-mega start-0 end-0 rounded-0 border-top-0 mt-0 p-4"
                                aria-labelledby="dropdown-{{ $category->slug }}" role="menu">
                                <div class="container">
                                    <div class="row g-4">
                                        @foreach ($category->children as $child)
                                            <div class="col-lg-3 col-md-4">
                                                <div class="dropdown-item-parent h-100">
                                                    @if ($child->children->count() > 0)
                                                        <!-- Child with grandchildren -->
                                                        <div class="position-relative h-100">
                                                            <div class="dropdown-header mb-2 px-0">
                                                                <a href="{{ route('store.filter.category', $child->slug) }}"
                                                                    class="text-primary fw-semibold text-decoration-none d-flex justify-content-between align-items-center">
                                                                    {{ $child->name }}
                                                                    <svg class="w-4 h-4 ms-2" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M9 5l7 7-7 7" />
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                            <!-- Submenu for grandchildren -->
                                                            <div class="grandchildren-list ps-3 border-start border-2">
                                                                @foreach ($child->children as $grandchild)
                                                                    <a class="dropdown-item py-1 px-0 d-block text-body"
                                                                        href="{{ route('store.filter.category', $grandchild->slug) }}"
                                                                        role="menuitem">
                                                                        {{ $grandchild->name }}
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @else
                                                        <!-- Child without grandchildren -->
                                                        <a class="dropdown-item fw-semibold px-0 py-2 h-100 d-flex align-items-center"
                                                            href="{{ route('store.filter.category', $child->slug) }}"
                                                            role="menuitem">
                                                            {{ $child->name }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if ($category->children->count() > 0)
                                        <div class="row mt-4 pt-3 border-top">
                                            <div class="col-12">
                                                <a href="{{ route('store.filter.category', $category->slug) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    View All {{ $category->name }}
                                                    <svg class="w-4 h-4 ms-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <!-- Parent category without children -->
                            <a class="nav-link px-4 py-3 {{ $isActive ? 'active' : '' }}"
                                href="{{ route('store.filter.category', $category->slug) }}" role="menuitem">
                                <span class="fw-semibold">{{ $category->name }}</span>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>

    <!-- Mobile Navigation -->
    <nav class="navbar navbar-light bg-white border-bottom py-2 d-lg-none" aria-label="Mobile navigation">
        <div class="container-fluid px-3">
            <button class="navbar-toggler border-1 border-primary p-2 d-flex align-items-center rounded-2"
                type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileCategories"
                aria-controls="mobileCategories" aria-label="Toggle categories">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="ms-2 fw-semibold text-primary">Categories</span>
            </button>
        </div>
    </nav>

    <!-- Mobile Offcanvas Menu -->
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileCategories"
        aria-labelledby="mobileCategoriesLabel">
        <div class="offcanvas-header border-bottom py-3 px-4">
            <h5 class="offcanvas-title fw-bold" id="mobileCategoriesLabel">All Categories</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="list-group list-group-flush">
                @foreach ($sortedParents as $category)
                    @if ($category->children->count() > 0)
                        <div class="list-group-item border-0 p-0">
                            <a class="list-group-item list-group-item-action border-0 py-3 px-4 d-flex justify-content-between align-items-center fw-semibold"
                                href="{{ route('store.filter.category', $category->slug) }}" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $category->slug }}" aria-expanded="false"
                                aria-controls="collapse-{{ $category->slug }}"
                                onclick="return preventIfChildren(event, {{ $category->children->count() }})">
                                <span>{{ $category->name }}</span>
                                <svg class="w-4 h-4 collapse-icon" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m19 9-7 7-7-7" />
                                </svg>
                            </a>
                            <div class="collapse" id="collapse-{{ $category->slug }}"
                                data-bs-parent="#mobileCategories .offcanvas-body">
                                <div class="list-group list-group-flush bg-light">
                                    @foreach ($category->children as $child)
                                        @if ($child->children->count() > 0)
                                            <div class="list-group-item border-0 p-0">
                                                <a class="list-group-item list-group-item-action border-0 py-3 px-4 d-flex justify-content-between align-items-center ps-5"
                                                    href="{{ route('store.filter.category', $child->slug) }}"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-child-{{ $child->slug }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapse-child-{{ $child->slug }}"
                                                    onclick="return preventIfChildren(event, {{ $child->children->count() }})">
                                                    <span>{{ $child->name }}</span>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="m9 5 7 7-7 7" />
                                                    </svg>
                                                </a>
                                                <div class="collapse" id="collapse-child-{{ $child->slug }}"
                                                    data-bs-parent="#collapse-{{ $category->slug }}">
                                                    <div class="list-group list-group-flush bg-white">
                                                        @foreach ($child->children as $grandchild)
                                                            <a href="{{ route('store.filter.category', $grandchild->slug) }}"
                                                                class="list-group-item list-group-item-action border-0 py-2 px-4 ps-6">
                                                                {{ $grandchild->name }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <a href="{{ route('store.filter.category', $child->slug) }}"
                                                class="list-group-item list-group-item-action border-0 py-3 px-4 ps-5">
                                                {{ $child->name }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('store.filter.category', $category->slug) }}"
                            class="list-group-item list-group-item-action border-0 py-3 px-4 fw-semibold">
                            {{ $category->name }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <style>
        /* Desktop Styles */
        @media (min-width: 992px) {

            /* Navbar styling */
            .navbar-nav .nav-link {
                color: #495057;
                transition: all 0.2s ease;
                border-bottom: 3px solid transparent;
                position: relative;
                font-size: 0.95rem;
            }

            .navbar-nav .nav-link:hover,
            .navbar-nav .nav-link:focus,
            .navbar-nav .nav-link.active,
            .navbar-nav .nav-link.show {
                color: #2563eb;
                border-bottom-color: #2563eb;
                background-color: transparent;
            }

            /* Mega dropdown */
            .dropdown-mega {
                display: none;
                position: absolute;
                background: white;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                border: 1px solid #e5e7eb;
                border-top: none;
                z-index: 1050;
                animation: fadeInDown 0.2s ease;
            }

            .nav-item.dropdown:hover .dropdown-mega,
            .nav-item.dropdown .nav-link.show+.dropdown-mega {
                display: block;
            }

            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Dropdown items */
            .dropdown-item {
                color: #4b5563;
                padding: 8px 0;
                margin: 0;
                border-radius: 4px;
                transition: all 0.15s ease;
                white-space: normal;
                border: none;
            }

            .dropdown-item:hover,
            .dropdown-item:focus {
                color: #2563eb;
                background-color: transparent;
                transform: translateX(4px);
            }

            .dropdown-header a {
                color: #111827;
                font-size: 0.95rem;
            }

            .dropdown-header a:hover {
                color: #2563eb;
            }

            /* Grandchildren list */
            .grandchildren-list {
                border-color: #3b82f6 !important;
            }

            .grandchildren-list .dropdown-item {
                font-size: 0.9rem;
                color: #6b7280;
                padding: 4px 0;
            }

            .grandchildren-list .dropdown-item:hover {
                color: #2563eb;
            }

            /* View all button */
            .btn-outline-primary {
                border-color: #3b82f6;
                color: #3b82f6;
            }

            .btn-outline-primary:hover {
                background-color: #3b82f6;
                color: white;
            }
        }

        /* Mobile Styles */
        @media (max-width: 991.98px) {

            /* Fix for offcanvas preventing collapse */
            .offcanvas.show .collapse {
                visibility: visible !important;
            }

            /* Offcanvas styling */
            .offcanvas {
                width: 320px;
            }

            /* List group items */
            .list-group-item-action {
                transition: all 0.2s ease;
                color: #374151;
                position: relative;
            }

            .list-group-item-action:hover {
                background-color: #f3f4f6;
                color: #2563eb;
            }

            .list-group-item-action[aria-expanded="true"] {
                background-color: #eff6ff;
                color: #2563eb;
            }

            .list-group-item-action[aria-expanded="true"] .collapse-icon {
                transform: rotate(180deg);
            }

            .collapse-icon {
                transition: transform 0.3s ease;
            }

            /* Nested items */
            .ps-5 {
                padding-left: 2.5rem !important;
            }

            .ps-6 {
                padding-left: 3.5rem !important;
            }

            /* Active state */
            .list-group-item-action.active {
                background-color: #eff6ff;
                color: #2563eb;
                border-left: 4px solid #2563eb;
            }

            /* Toggle button */
            .navbar-toggler {
                transition: all 0.2s ease;
            }

            .navbar-toggler:hover {
                background-color: #eff6ff;
            }

            /* Collapse animations */
            .collapse {
                transition: height 0.35s ease;
            }

            .collapsing {
                transition: height 0.35s ease;
            }
        }

        /* Common styles */
        .fw-semibold {
            font-weight: 600;
        }

        /* Remove Bootstrap default dropdown arrow */
        .dropdown-toggle::after {
            display: none;
        }

        /* Better focus styles for accessibility */
        .nav-link:focus,
        .dropdown-item:focus,
        .btn:focus,
        .list-group-item-action:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* Smooth transitions */
        .nav-link,
        .dropdown-item,
        .list-group-item-action,
        .btn {
            transition: all 0.2s ease;
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script>
        // Helper function to prevent navigation if element has children
        function preventIfChildren(event, childrenCount) {
            if (childrenCount > 0) {
                event.preventDefault();
                event.stopPropagation();

                // Get the collapse target
                const target = event.currentTarget;
                const collapseId = target.getAttribute('data-bs-target');
                const collapseElement = document.querySelector(collapseId);

                if (collapseElement) {
                    const bsCollapse = bootstrap.Collapse.getInstance(collapseElement) ||
                        new bootstrap.Collapse(collapseElement, {
                            toggle: false
                        });

                    // Toggle the collapse
                    bsCollapse.toggle();

                    // Update aria-expanded
                    const isExpanded = target.getAttribute('aria-expanded') === 'true';
                    target.setAttribute('aria-expanded', !isExpanded);

                    // Update icon rotation
                    const icon = target.querySelector('.collapse-icon');
                    if (icon) {
                        icon.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(180deg)';
                    }
                }
                return false;
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all collapses
            const collapseElements = document.querySelectorAll('.collapse');
            collapseElements.forEach(collapseEl => {
                // Initialize without auto toggle
                new bootstrap.Collapse(collapseEl, {
                    toggle: false
                });
            });

            // Handle offcanvas events
            const mobileOffcanvas = document.getElementById('mobileCategories');
            if (mobileOffcanvas) {
                // Close all collapses when offcanvas opens
                mobileOffcanvas.addEventListener('show.bs.offcanvas', function() {
                    document.querySelectorAll('.collapse.show').forEach(collapse => {
                        bootstrap.Collapse.getInstance(collapse)?.hide();
                    });

                    // Reset all aria-expanded attributes
                    document.querySelectorAll('[aria-expanded="true"]').forEach(el => {
                        el.setAttribute('aria-expanded', 'false');
                    });

                    // Reset all icons
                    document.querySelectorAll('.collapse-icon').forEach(icon => {
                        icon.style.transform = 'rotate(0deg)';
                    });
                });

                // Reset everything when offcanvas closes
                mobileOffcanvas.addEventListener('hidden.bs.offcanvas', function() {
                    document.querySelectorAll('.collapse.show').forEach(collapse => {
                        bootstrap.Collapse.getInstance(collapse)?.hide();
                    });

                    document.querySelectorAll('[aria-expanded="true"]').forEach(el => {
                        el.setAttribute('aria-expanded', 'false');
                    });

                    document.querySelectorAll('.collapse-icon').forEach(icon => {
                        icon.style.transform = 'rotate(0deg)';
                    });
                });
            }

            // Desktop: Better hover handling
            if (window.innerWidth >= 992) {
                const dropdowns = document.querySelectorAll('.nav-item.dropdown');

                dropdowns.forEach(dropdown => {
                    const link = dropdown.querySelector('.nav-link');
                    const menu = dropdown.querySelector('.dropdown-mega');

                    // Show on hover
                    dropdown.addEventListener('mouseenter', () => {
                        bootstrap.Dropdown.getOrCreateInstance(link).show();
                    });

                    // Hide with delay
                    dropdown.addEventListener('mouseleave', (e) => {
                        setTimeout(() => {
                            if (!dropdown.contains(e.relatedTarget)) {
                                bootstrap.Dropdown.getOrCreateInstance(link).hide();
                            }
                        }, 100);
                    });
                });

                // Close dropdowns when clicking elsewhere
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.nav-item.dropdown')) {
                        document.querySelectorAll('.dropdown-mega.show').forEach(menu => {
                            const link = menu.previousElementSibling;
                            if (link) {
                                bootstrap.Dropdown.getInstance(link)?.hide();
                            }
                        });
                    }
                });
            }

            // Keyboard navigation improvement
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.show').forEach(el => {
                        if (el.classList.contains('dropdown-menu') || el.classList.contains(
                                'collapse')) {
                            const trigger = document.querySelector('[aria-expanded="true"]');
                            if (trigger) {
                                bootstrap.Collapse.getInstance(trigger)?.hide();
                            }
                        }
                    });
                }
            });

            // Initialize Bootstrap dropdowns
            const dropdownElements = document.querySelectorAll('.dropdown-toggle');
            dropdownElements.forEach(dropdown => {
                new bootstrap.Dropdown(dropdown);
            });
        });
    </script>
</div>
