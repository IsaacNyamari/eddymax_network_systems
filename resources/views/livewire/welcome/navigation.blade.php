<div>
    <nav class="dark:bg-gray-800 w-full mt-0 p-3 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('store.home') }}" class="text-xl font-bold text-black dark:text-white">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>


        <!-- Navigation Links -->
        <div class="hidden md:flex space-x-4">
            <a href="{{ route('store.home') }}"
                class="rounded-md px-3 py-2 active text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80">
                Home
            </a>
            <a href="{{ route('store.shop') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80">
                Shop
            </a>
            <a href="{{ route('store.cart') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80">
                Cart <livewire:cart-count />
            </a>
            <a href="{{ route('store.checkout') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80">
                Checkout
            </a>
            @auth
                <a href="{{ route('dashboard') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80">
                        Register
                    </a>
                @endif
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden flex items-center">
            <button id="mobile-menu-button" class="text-black dark:text-white focus:outline-none">
                <!-- Hamburger Icon -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden p-3 space-y-2">
        <a href="{{ route('store.shop') }}" class="block text-black hover:bg-slate-900 hover:text-white p-2">Shop</a>
        <a href="{{ route('store.cart') }}" class="block text-black hover:bg-slate-900 hover:text-white p-2">Cart</a>
        <a href="{{ route('store.checkout') }}"
            class="block text-black hover:bg-slate-900 hover:text-white p-2">Checkout</a>
        <a href="{{ route('store.contact') }}"
            class="block text-black hover:bg-slate-900 hover:text-white p-2">Contact</a>

        @auth
            <a href="{{ route('dashboard') }}"
                class="block text-black hover:bg-slate-900 hover:text-white p-2">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="block text-black hover:bg-slate-900 hover:text-white p-2">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="block text-black hover:bg-slate-900 hover:text-white p-2">Register</a>
            @endif
        @endauth
    </div>

    <script>
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</div>
