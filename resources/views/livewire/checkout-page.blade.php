<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <h1 class="text-3xl font-bold text-gray-900 text-center mb-6">Checkout</h1>

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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Billing Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- User Status Alert -->
                @if ($this->getIsLoggedInProperty())
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-green-800 font-medium">
                                You are logged in as {{ $name }} ({{ $email }})
                            </span>
                        </div>
                    </div>
                @else
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-blue-800 font-medium">
                                You're checking out as a guest. An account will be created for you.
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Billing Details Form -->
                <div class="bg-white shadow-lg p-8 rounded-xl space-y-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Billing Details</h2>

                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Full Name *</label>
                            <input type="text" wire:model="name" @if ($this->getIsLoggedInProperty()) disabled @endif
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 @if ($this->getIsLoggedInProperty()) bg-gray-50 @endif">
                            @error('name')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                            @if ($this->getIsLoggedInProperty())
                                <p class="text-xs text-gray-500 mt-1">Registered users cannot change their name during
                                    checkout</p>
                            @endif
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Email Address *</label>
                            <input type="email" wire:model="email" @if ($this->getIsLoggedInProperty()) disabled @endif
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 @if ($this->getIsLoggedInProperty()) bg-gray-50 @endif">
                            @error('email')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                            @if ($this->getIsLoggedInProperty())
                                <p class="text-xs text-gray-500 mt-1">Registered users cannot change their email</p>
                            @endif
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Phone Number *</label>
                            <input type="text" wire:model.live="phone" placeholder="0712345678"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('phone')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Delivery Address *</label>
                            <input type="text" wire:model="address" placeholder="Street, Building, Apartment"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('address')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- City & County -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-gray-700 mb-1">City/Town *</label>
                                <input type="text" wire:model="city"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                @error('city')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block font-semibold text-gray-700 mb-1">County *</label>
                                <select wire:model="selectedCounty"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                    <option value="">Select County</option>
                                    @foreach ($counties as $county)
                                        <option value="{{ $county->id }}">{{ $county->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedCounty')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Section (same as before) -->
                <!-- ... -->
            </div>

            <!-- Right Column: Order Summary -->
            <div>
                <div class="bg-white shadow-lg p-8 rounded-xl space-y-6 sticky top-6">
                    <h2 class="text-xl font-bold text-gray-900">Order Summary</h2>
                    {{-- 
                    <!-- Cart Items -->
                    <div class="max-h-80 overflow-y-auto space-y-4 pr-2">
                        @foreach ($cart as $itemId => $item)
                            @if (is_array($item) && isset($item['name']))
                                <div class="border-b pb-4 space-y-2">
                                    <div class="flex justify-between font-semibold text-gray-900">
                                        <span>{{ $item['name'] }}</span>
                                        <span>KES {{ number_format($item['price'] ?? 0, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600 text-sm">
                                        <span>Qty: {{ $item['quantity'] ?? 1 }}</span>
                                        <span>Subtotal: KES
                                            {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div> --}}

                    <!-- Order Total -->
                    <div class="space-y-2 text-gray-800 pt-4 border-t">
                        <div class="flex justify-between text-lg">
                            <span class="font-semibold">Subtotal</span>
                            <span class="font-bold">KES {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg">
                            <span class="font-semibold">Shipping</span>
                            <span class="font-bold text-green-600">FREE</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold pt-2 border-t mt-2">
                            <span>Total</span>
                            <span class="text-red-600">KES {{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- User Action Note -->
                    @if (!$this->getIsLoggedInProperty())
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-yellow-800 text-sm">
                                <span class="font-semibold">Note:</span>
                                By clicking "Pay Now", a guest account will be created for you with the email provided.
                            </p>
                        </div>
                    @endif

                    <!-- Pay with Paystack Button -->
                    <button wire:click="initiatePayment" wire:loading.attr="disabled"
                        wire:loading.class="opacity-70 cursor-not-allowed"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg shadow-lg transition transform hover:-translate-y-1 mt-6 flex items-center justify-center">
                        <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span wire:loading.remove>Pay Now</span>
                        <span wire:loading>Processing...</span>
                    </button>

                    <!-- Security Note -->
                    <div class="text-center pt-4 border-t">
                        <p class="text-xs text-gray-500 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Secured by Paystack • SSL Encrypted
                        </p>
                    </div>
                </div>

                <!-- Login/Register Links -->
                <div class="mt-4 text-center space-y-2">
                    @if (!$this->getIsLoggedInProperty())
                        <p class="text-sm text-gray-600">
                            Already have an account?
                            <a href="{{ route('login', ['redirect' => route('store.checkout')]) }}"
                                class="text-red-600 hover:text-red-800 font-medium">
                                Login here
                            </a>
                        </p>
                    @endif
                    <a href="{{ route('store.cart') }}"
                        class="text-red-600 hover:text-red-800 text-sm font-medium inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Return to Cart
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@script
    <script>
        $wire.on('paystack-payment', async (event) => {
            if (event) {
                const data = event[0];
                // Dynamically load Paystack script if not loaded
                if (!window.PaystackPop) {
                    await new Promise((resolve, reject) => {
                        const script = document.createElement('script');
                        script.src = 'https://js.paystack.co/v1/inline.js';
                        script.onload = resolve;
                        script.onerror = reject;
                        document.body.appendChild(script);
                    });
                }

                // Initialize Paystack
                let handler = PaystackPop.setup({
                    key: '{{ env('PAYSTACK_PUBLIC_KEY') }}', // Corrected
                    email: data.email,
                    amount: data.amount, // in kobo
                    currency: 'KES',
                    ref: 'PS_' + Math.floor(Math.random() * 1000000000 + 1),
                    callback: function(response) {
                        console.log('Payment successful:', response);
                        // Notify Livewire of success
                        $wire.paymentSuccessful(response);
                    },
                    onClose: function() {
                        console.log('Payment popup closed');
                        // Notify Livewire of failed/closed payment
                        $wire.paymentFailed();
                    }
                });

                handler.openIframe();
            }
        });
    </script>
@endscript
