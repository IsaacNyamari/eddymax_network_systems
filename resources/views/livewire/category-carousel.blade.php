<div class="swiper categorySwiper">
    <div class="swiper-wrapper">

        @foreach ($categories as $category)
        <div class="swiper-slide">
                <a href="{{ route('store.filter.category', $category->slug) }}"
                    class="group relative bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 block">

                    <img src="{{ asset('storage/' . $category['image']) }}" alt="{{ $category['name'] }}"
                        class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500"
                        loading="lazy">

                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                        <h3 class="text-xl font-bold text-white mb-1">{{ $category['name'] }}</h3>
                        <p class="text-gray-200 text-sm">{{ $category->products->count() }} products</p>
                    </div>

                    <div
                        class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                        Shop Now
                    </div>
                </a>
            </div>
        @endforeach

    </div>

    <!-- Controls -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
</div>
