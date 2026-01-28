@props(['product'])
<button wire:click="addToCart({{ $product->id }})"
    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-3xl font-semibold transition transform hover:-translate-y-1 shadow-lg flex items-center">
    <i class="fa fa-cart-plus" aria-hidden="true"></i>
    <span class="hidden lg:inline-block md:inline-block">Add to Cart</span>
</button>
