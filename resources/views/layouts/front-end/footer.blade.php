<footer class="bg-blue-800 border-t mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">

        <!-- Logo & About -->
        <div class="space-y-4">
            <h2 class="text-2xl font-bold text-white">{{ config('app.name', 'laravel') }}</h2>
            <p class="text-white">
                High-quality networking equipment with warranty and expert support. We help you build reliable networks.
            </p>
        </div>

        <!-- Quick Links -->
        <div>
            <h3 class="text-xl font-semibold text-white mb-4">Quick Links</h3>
            <ul class="space-y-2">
                <li><a href="{{ route('store.home') }}" class="text-white hover:text-red-600 transition">Home</a></li>
                <li><a href="{{ route('store.shop') }}" class="text-white hover:text-red-600 transition">Products</a>
                </li>
                <li><a href="{{ route('store.contact') }}" class="text-white hover:text-red-600 transition">Contact
                        Us</a>
                </li>
                <li><a href="{{ route('pages.return-refund') }}" class="text-white hover:text-red-600 transition">Return
                        &
                        Refund</a></li>
            </ul>
        </div>

        <!-- Categories -->
        <div>
            <h3 class="text-xl font-semibold text-white mb-4">Categories</h3>
            <ul class="space-y-2">
                @php
                    $categories = \App\Models\Category::latest()->take(4)->get();
                @endphp
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('store.filter.category', $category->slug) }}"
                            class="text-white hover:text-red-600 transition">{{ $category->name }} </a>
                    </li>
                @endforeach

            </ul>
        </div>

        <!-- Contact & Social -->
        <div class="space-y-4">
            <h3 class="text-xl font-semibold text-white mb-4">Contact Us</h3>
            <p class="text-white">support@ {{ config('app.name', 'laravel') }}.co.ke</p>
            <p class="text-white">+254 723 835 303</p>
            <div class="flex space-x-4 mt-2">
                <a href="#" class="text-white hover:text-red-600 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M24 4.557a9.82 9.82 0 01-2.828.775 4.932 4.932 0 002.165-2.724c-.951.555-2.005.959-3.127 1.184A4.92 4.92 0 0016.616 3c-2.717 0-4.92 2.203-4.92 4.92 0 .386.044.762.128 1.124C7.728 8.902 4.1 6.93 1.671 3.939a4.91 4.91 0 00-.666 2.475c0 1.708.869 3.215 2.188 4.099a4.904 4.904 0 01-2.229-.616v.06c0 2.385 1.698 4.374 3.946 4.828a4.935 4.935 0 01-2.224.084c.627 1.956 2.445 3.377 4.6 3.416A9.867 9.867 0 010 19.54a13.933 13.933 0 007.548 2.212c9.056 0 14.009-7.502 14.009-14.009 0-.213-.004-.426-.014-.637A10.012 10.012 0 0024 4.557z" />
                    </svg>
                </a>
                <a href="#" class="text-white hover:text-red-600 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.849.07 1.366.062 2.633.334 3.608 1.31.975.976 1.248 2.243 1.31 3.608.058 1.265.069 1.645.069 4.849s-.012 3.584-.07 4.849c-.062 1.366-.334 2.633-1.31 3.608-.976.975-2.243 1.248-3.608 1.31-1.265.058-1.645.069-4.849.069s-3.584-.012-4.849-.07c-1.366-.062-2.633-.334-3.608-1.31-.975-.976-1.248-2.243-1.31-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.849c.062-1.366.334-2.633 1.31-3.608.976-.975 2.243-1.248 3.608-1.31C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.012 7.052.072 5.772.131 4.665.387 3.678 1.374 2.692 2.361 2.436 3.468 2.377 4.748 2.317 6.028 2.305 6.437 2.305 12s.012 5.972.072 7.252c.059 1.28.315 2.387 1.301 3.374.987.987 2.094 1.243 3.374 1.301 1.28.059 1.689.072 7.252.072s5.972-.012 7.252-.072c1.28-.059 2.387-.315 3.374-1.301.987-.987 1.243-2.094 1.301-3.374.059-1.28.072-1.689.072-7.252s-.012-5.972-.072-7.252c-.059-1.28-.315-2.387-1.301-3.374C21.387.387 20.28.131 19 .072 17.72.012 17.311 0 12 0z" />
                        <circle cx="12" cy="12" r="3.5" />
                    </svg>
                </a>
                <a href="#" class="text-white hover:text-red-600 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.226.792 24 1.771 24h20.451C23.206 24 24 23.226 24 22.271V1.729C24 .774 23.206 0 22.225 0zM7.094 20.452H3.543V9.045h3.551v11.407zm-1.775-13.1c-1.136 0-2.057-.927-2.057-2.07 0-1.142.921-2.07 2.057-2.07s2.057.928 2.057 2.07c0 1.143-.921 2.07-2.057 2.07zm15.133 13.1h-3.551v-5.569c0-1.328-.027-3.037-1.849-3.037-1.85 0-2.133 1.446-2.133 2.94v5.666h-3.551V9.045h3.413v1.561h.048c.476-.902 1.637-1.849 3.369-1.849 3.601 0 4.27 2.372 4.27 5.455v6.24z" />
                    </svg>
                </a>
            </div>
        </div>

    </div>

    <div class="border-t border-gray-200 mt-6 pt-4 text-center text-white text-sm">
        &copy; {{ date('Y') }} {{ config('app.name', 'laravel') }}. All rights reserved.
    </div>
</footer>
