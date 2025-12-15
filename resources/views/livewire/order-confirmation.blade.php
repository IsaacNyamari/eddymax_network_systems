<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-10">
    <div class="bg-white shadow-lg rounded-2xl p-8 max-w-lg w-full text-center relative overflow-hidden">

        <!-- Success Icon -->
        <div class="mx-auto mb-6 w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
            ✔
        </div>

        <!-- Title -->
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Order Confirmed!</h2>

        <p class="text-gray-600 mb-6">
            Thank you for your purchase. Your order has been successfully placed and is now being processed.
        </p>

        <!-- Order Details -->
        <div class="bg-gray-100 rounded-xl p-4 mb-6">
            <p class="text-gray-700 text-sm">Your Order Reference:</p>
            <p class="text-xl font-semibold text-gray-900 tracking-wide">
                {{ request()->query('order') }}
            </p>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col space-y-3 justify-center items-center">
            <a href="/shop" class="bg-red-600 hover:bg-red-700 text-white w-fit px-4 py-3 rounded-lg font-semibold">
                Continue Shopping
            </a>
        </div>

        <!-- Decorative bottom curve -->
        <div class="absolute bottom-0 left-0 right-0 h-2 bg-gradient-to-r from-red-400 to-red-100"></div>
    </div>
</div>
