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
                <li>
                    <a href="{{ route('pages.return-refund') }}" class="text-white hover:text-red-600 transition">Return
                        & Refund</a>
                </li>
                <li>
                    <a href="{{ route('pages.privacy-policy') }}"
                        class="text-white hover:text-red-600 transition">Privacy Policy</a>
                </li>
                <li>
                    <a href="{{ route('pages.terms-conditions') }}"
                        class="text-white hover:text-red-600 transition">Terms & Conditions</a>
                </li>
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
            <p class="text-white">{{ env('SUPPORT_EMAIL') }}</p>
            <p class="text-white">{{ env('PHONE') }}</p>

        </div>

    </div>

    <div class="border-t border-gray-200 mt-6 pt-4 text-center text-white text-sm">
        &copy; {{ date('Y') }} {{ config('app.name', 'laravel') }}. All rights reserved.
    </div>
</footer>
