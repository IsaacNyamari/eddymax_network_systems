<div>
    @if ($products->isEmpty())
        <p class="text-center text-gray-500">No products found.</p>
    @else
        @foreach ($products as $product)
            <a href="{{ route('products.show', $product->slug) }}"  >
                <div class="w-full bg-slate-200 flex shadow-sm mb-4 p-2 rounded-xl">
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-16" alt="">

                    <div class="pl-2">
                        <h3 class="font-semibold">{{ $product->name }}</h3>
                        <h3>Ksh. {{ number_format($product->price, 2) }}</h3>
                    </div>
                </div>
            </a>
        @endforeach
    @endif
</div>
