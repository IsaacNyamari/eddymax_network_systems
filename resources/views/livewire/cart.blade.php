<div class="bg-white rounded-xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Shopping Cart</h2>
        <div class="text-sm text-gray-600">
            {{ count($cart) }} {{ Str::plural('item', count($cart)) }}
        </div>
    </div>

    @if (empty($cart))
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
            <p class="text-gray-600 mb-6">Add some products to your cart to see them here</p>
            <a href="{{ route('store.shop') }}"
                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="space-y-4">
            <div class="space-y-4">
                @foreach ($cart as $productId => $item)
                    <div  wire:key="cart-item-{{ $productId }}" class="flex items-center justify-between border-b pb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100">
                                @if (!empty($item['image']))
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <span class="text-gray-500 text-sm font-semibold">No Image</span>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <a href="{{ route('products.show', $item['slug']) }}">
                                    <h4 class="font-semibold text-red-600">{{ $item['name'] }}</h4>
                                </a>
                                <p class="text-gray-600">Ksh {{ number_format($item['price']) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-6">
                            <div class="flex items-center space-x-3">
                                <button wire:click="decrement({{ $productId }})"
                                    class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 12H4" />
                                    </svg>
                                </button>
                                <span class="font-semibold">{{ $item['quantity'] }}</span>
                                <button wire:click="increment({{ $productId }})"
                                    class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>

                            <div class="text-right">
                                <div class="font-bold text-gray-900">
                                    Ksh {{ number_format($item['price'] * $item['quantity']) }}
                                </div>
                                <button wire:click="removeItem({{ $productId }})"
                                    class="text-sm text-red-600 hover:text-red-800 mt-1">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- ... rest of your code ... -->
            </div>

            <div class="pt-6 border-t">
                @php
                    $subtotal = array_sum(
                        array_map(function ($item) {
                            return $item['price'] * $item['quantity'];
                        }, $cart),
                    );

                    $shipping = 300;
                    $total = $subtotal + $shipping;
                @endphp

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">Ksh {{ number_format($subtotal) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold">Ksh {{ number_format($shipping) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-3 border-t">
                        <span>Total</span>
                        <span class="text-red-600">Ksh {{ number_format($total) }}</span>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('store.shop') }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-center font-semibold transition">
                        Continue Shopping
                    </a>
                    <a href="{{ route('store.checkout') }}"
                        class="px-6 py-3 bg-red-600 text-white text-center rounded-lg hover:bg-red-700 font-semibold transition">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
