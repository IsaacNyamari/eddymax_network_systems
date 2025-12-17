<!-- Include this script tag or install `@tailwindplus/elements` via npm: -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script> -->

<div class="bg-white">
    <!-- Mobile menu -->
    <el-dialog>
        <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
            <el-dialog-backdrop
                class="fixed inset-0 bg-black/25 transition-opacity duration-300 ease-linear data-closed:opacity-0">
            </el-dialog-backdrop>

            <div tabindex="0" class="fixed inset-0 flex focus:outline-none">
                <el-dialog-panel
                    class="relative flex w-full max-w-xs transform flex-col overflow-y-auto bg-white pb-12 shadow-xl transition duration-300 ease-in-out data-closed:-translate-x-full">

                    <!-- Close button -->
                    <div class="flex px-4 pt-5 pb-2">
                        <button type="button" command="close" commandfor="mobile-menu"
                            class="relative -m-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400">
                            <span class="sr-only">Close menu</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                class="size-6">
                                <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <!-- MOBILE ECOMMERCE LINKS -->
                    <div class="space-y-6 border-t border-gray-200 px-4 py-6">
                        <div class="flow-root">
                            <a href="/" class="-m-2 block p-2 font-medium text-gray-900">Home</a>
                        </div>
                        <div class="flow-root">
                            <a href="/shop" class="-m-2 block p-2 font-medium text-gray-900">Shop</a>
                        </div>
                        <div class="flow-root">
                            <a href="/cart" class="-m-2 block p-2 font-medium text-gray-900">Cart</a>
                        </div>
                        <div class="flow-root">
                            <a href="/checkout" class="-m-2 block p-2 font-medium text-gray-900">Checkout</a>
                        </div>
                    </div>

                    <!-- MOBILE AUTH LINKS -->
                    <div class="space-y-6 border-t border-gray-200 px-4 py-6">
                        @guest
                            <div class="flow-root">
                                <a href="{{ route('login') }}" class="-m-2 block p-2 font-medium text-gray-900">Sign in</a>
                            </div>
                            <div class="flow-root">
                                <a href="{{ route('register') }}" class="-m-2 block p-2 font-medium text-gray-900">Create
                                    account</a>
                            </div>
                        @endguest

                        @auth
                            <div class="flow-root">
                                <a href="{{ route('dashboard') }}"
                                    class="-m-2 block p-2 font-medium text-gray-900">Dashboard</a>
                            </div>
                            <div class="flow-root">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="-m-2 block p-2 font-medium text-gray-900">Logout</button>
                                </form>
                            </div>
                        @endauth
                    </div>

                    <!-- Currency -->
                    <div class="border-t border-gray-200 px-4 py-6">
                        <a href="#" class="-m-2 flex items-center p-2">
                            <img src="https://tailwindcss.com/plus-assets/img/flags/flag-kenya.svg" class="block w-5" />
                            <span class="ml-3 font-medium text-gray-900">KES</span>
                        </a>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>

    <!-- HEADER -->
    <header class="relative bg-white">
        <p class="flex h-10 items-center justify-center bg-indigo-600 px-4 text-sm font-medium text-white">
            Get free delivery on orders over $100
        </p>

        <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="border-b border-gray-200">
                <div class="flex h-16 items-center">

                    <!-- Mobile menu button -->
                    <button type="button" command="show-modal" commandfor="mobile-menu"
                        class="rounded-md p-2 text-gray-400 lg:hidden">
                        <span class="sr-only">Open menu</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6">
                            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>

                    <!-- Logo -->
                    <div class="ml-4 flex lg:ml-0">
                        <a href="/">
                            <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
                                class="h-8 w-auto" />
                        </a>
                    </div>

                    <!-- DESKTOP LEFT NAV (ECOMMERCE) -->
                    <el-popover-group class="hidden lg:ml-8 lg:block lg:self-stretch">
                        <div class="flex h-full space-x-8">
                            <a href="/"
                                class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Home</a>
                            <a href="/shop"
                                class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Shop</a>
                            <a href="/cart"
                                class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Cart</a>
                            <a href="/checkout"
                                class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Checkout</a>
                        </div>
                    </el-popover-group>

                    <!-- RIGHT SIDE AUTH LINKS -->
                    <div class="ml-auto flex items-center">
                        <div class="hidden lg:flex lg:space-x-6">
                            @guest
                                <a href="{{ route('login') }}"
                                    class="text-sm font-medium text-gray-700 hover:text-gray-800">Sign in</a>
                                <span class="h-6 w-px bg-gray-200"></span>
                                <a href="{{ route('register') }}"
                                    class="text-sm font-medium text-gray-700 hover:text-gray-800">Create account</a>
                            @endguest

                            @auth
                                <a href="{{ route('dashboard') }}"
                                    class="text-sm font-medium text-gray-700 hover:text-gray-800">Dashboard</a>
                                <span class="h-6 w-px bg-gray-200"></span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="text-sm font-medium text-gray-700 hover:text-gray-800">Logout</button>
                                </form>
                            @endauth
                        </div>

                        <!-- Cart -->
                        <div class="ml-4 lg:ml-6">
                            <a href="/cart" class="flex items-center p-2">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    class="size-6 text-gray-400">
                                    <path d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <span class="ml-2 text-sm font-medium text-gray-700">0</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
    </header>
</div>
