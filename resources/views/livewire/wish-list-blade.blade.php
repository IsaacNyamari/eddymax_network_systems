  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($wishlists as $wishlist)
          <div class="bg-white border rounded-xl shadow-sm p-4 flex flex-col">

              <img src="{{ asset('storage/' . $wishlist->product->image) }}" alt="{{ $wishlist->product->name }}"
                  class="h-48 w-full object-cover rounded-lg mb-4">

              <h3 class="font-semibold text-gray-900">
                  {{ $wishlist->product->name }}
              </h3>

              <p class="text-gray-600 mb-3">
                  KES {{ number_format($wishlist->product->price, 2) }}
              </p>

              <div class="mt-auto flex items-center justify-between">
                  <a href="{{ route('products.show', $wishlist->product->slug) }}"
                      class="text-blue-600 hover:underline text-sm">
                      View Product
                  </a>

                  {{-- Remove from wishlist --}}
                  <livewire:wishlist-toggle :product="$wishlist->product" />
              </div>
          </div>
      @endforeach
  </div>
