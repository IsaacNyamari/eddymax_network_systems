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
                            <a href="/cart" class="-m-2 block p-2 font-medium text-gray-900">Cart
                                <livewire:cart-count /> </a>
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
        <div class="bg-indigo-600 text-white text-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row justify-between items-center h-10">
                    <!-- Left: Address -->
                    <div class="flex items-center space-x-4">
                        <span class="hidden sm:inline">📍 123 Main Street, Nairobi, Kenya</span>
                        <span>📧 info@example.com</span>
                        <span>📞 +254 723 835 303</span>
                    </div>

                    <!-- Right: Optional social links -->
                    <div class="mt-1 sm:mt-0 flex items-center space-x-4">
                        <a href="#" class="hover:underline">Facebook</a>
                        <a href="#" class="hover:underline">Twitter</a>
                        <a href="#" class="hover:underline">Instagram</a>
                    </div>
                </div>
            </div>
        </div>


        <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="border-b border-gray-200">
                <div class="flex h-16 items-center ">

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
                            <img src="{{ asset('images/edymax-logo.png') }}" class="h-16 w-auto" />
                        </a>
                    </div>

                    <!-- DESKTOP LEFT NAV (ECOMMERCE) -->
                    <el-popover-group class="hidden lg:ml-8 lg:block lg:self-stretch">
                        <div class="flex h-full space-x-8">
                            <a href="/"
                                class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Home</a>
                            <a href="/shop"
                                class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Shop</a>
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
                                <?xml version="1.0" encoding="iso-8859-1"?>
                                <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                <!DOCTYPE svg
                                    PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px"
                                    viewBox="0 0 395.025 395.025" xml:space="preserve">
                                    <g>
                                        <path d="M357.507,380.982L337.914,82.223c-0.431-6.572-5.887-11.682-12.473-11.682h-54.69V62.5c0-34.462-28.038-62.5-62.5-62.5
                                            h-21.495c-34.462,0-62.5,28.038-62.5,62.5v8.041h-54.69c-6.586,0-12.042,5.11-12.473,11.682L37.45,381.709
                                            c-0.227,3.449,0.986,6.838,3.35,9.361c2.364,2.525,5.666,3.955,9.124,3.955h295.159c0.007,0,0.013,0,0.02,0
                                            c6.903,0,12.5-5.596,12.5-12.5C357.601,382.004,357.57,381.488,357.507,380.982z M149.255,62.5c0-20.678,16.822-37.5,37.5-37.5
                                            h21.495c20.678,0,37.5,16.822,37.5,37.5v8.041h-96.495V62.5z M63.27,370.025L81.272,95.542h42.983v11.154
                                            c-8.895,4.56-15,13.818-15,24.482c0,15.164,12.336,27.5,27.5,27.5s27.5-12.336,27.5-27.5c0-10.664-6.105-19.922-15-24.482V95.542
                                            h96.495v11.154c-8.896,4.56-15,13.818-15,24.482c0,15.164,12.336,27.5,27.5,27.5s27.5-12.336,27.5-27.5
                                            c0-10.664-6.105-19.922-15-24.482V95.542h42.983l18.002,274.483H63.27z" />
                                    </g>
                                </svg>
                                <sup><livewire:cart-count /></sup>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
    </header>
</div>
