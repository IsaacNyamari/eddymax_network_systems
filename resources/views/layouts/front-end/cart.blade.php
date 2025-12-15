@extends('layouts.front-end.app')
@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

        <h1 class="text-3xl font-bold text-gray-900 text-center mb-8">Your Cart</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-6">
                <livewire:cart />
            </div>

            <!-- Summary -->
            <div>
                <div class="bg-white rounded-xl shadow-lg p-6 space-y-6">

                    <h2 class="text-xl font-bold text-gray-900">Order Summary</h2>

                    <div class="space-y-3 text-gray-800">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>KES 7,900</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span>KES 300</span>
                        </div>

                        <div class="flex justify-between text-xl font-bold text-gray-900 pt-2">
                            <span>Total</span>
                            <span>KES 8,200</span>
                        </div>
                    </div>

                    <a href="/checkout"
                        class="block text-center bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg shadow-md transition transform hover:-translate-y-1">
                        Proceed to Checkout
                    </a>

                </div>
            </div>

        </div>

    </div>
@endsection
