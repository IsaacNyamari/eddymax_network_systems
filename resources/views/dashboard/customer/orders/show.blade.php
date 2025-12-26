@extends('dashboard.layouts.dashboard')
@section('title', 'My Orders')
@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6  sticky top-0">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Status (Created On:
            {{ $order->created_at->diffForHumans() }})</h3>

        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-700">Shipping Progress</span>
                <span
                    class="text-sm font-semibold {{ $order->status === 'delivered' ? 'text-green-600' : 'text-blue-600' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-2.5">
                @php

                    $progress = [
                        'pending' => 10,
                        'confirmed' => 25,
                        'processing' => 40,
                        'shipped' => 70,
                        'out_for_delivery' => 85,
                        'delivered' => 100,
                    ];
                    $currentProgress = $progress[$order->status] ?? 10;
                @endphp
                <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2.5 rounded-full transition-all duration-500"
                    style="width: {{ $currentProgress }}%"></div>
            </div>

            <!-- Status Steps -->
            <div class="flex justify-between mt-3">
                @foreach (['pending', 'processing', 'shipped', 'delivered'] as $step)
                    <div class="text-center">
                        <div
                            class="w-8 h-8 mx-auto rounded-full flex items-center justify-center mb-1 
                        {{ $order->status === $step
                            ? 'bg-green-100 border-2 border-green-500'
                            : ($currentProgress >= $progress[$step]
                                ? 'bg-blue-100 border-2 border-blue-500'
                                : 'bg-gray-100 border-2 border-gray-300') }}">
                            @switch($step)
                                @case('pending')
                                    <svg class="w-4 h-4 {{ $order->status === $step
                                        ? 'text-green-600'
                                        : ($currentProgress >= $progress[$step]
                                            ? 'text-blue-600'
                                            : 'text-gray-400') }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @break

                                @case('processing')
                                    <svg class="w-4 h-4 {{ $order->status === $step
                                        ? 'text-green-600'
                                        : ($currentProgress >= $progress[$step]
                                            ? 'text-blue-600'
                                            : 'text-gray-400') }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                @break

                                @case('shipped')
                                    <svg class="w-4 h-4 {{ $order->status === $step
                                        ? 'text-green-600'
                                        : ($currentProgress >= $progress[$step]
                                            ? 'text-blue-600'
                                            : 'text-gray-400') }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                @break

                                @case('delivered')
                                    <svg class="w-4 h-4 {{ $order->status === $step
                                        ? 'text-green-600'
                                        : ($currentProgress >= $progress[$step]
                                            ? 'text-blue-600'
                                            : 'text-gray-400') }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @break
                            @endswitch
                        </div>
                        <span
                            class="text-xs font-medium {{ $order->status === $step
                                ? 'text-green-600'
                                : ($currentProgress >= $progress[$step]
                                    ? 'text-blue-600'
                                    : 'text-gray-500') }}">
                            {{ ucfirst($step) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>


    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6 w-full">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Products in this order.<br> Return status:
            @php
                $orderStatus = $order->orderReturns ? $order->orderReturns->status : 'no return';
            @endphp
            <span
                class="px-2 py-2 rounded-lg text-white
                    @if ($orderStatus === 'approved') bg-green-300
                    @elseif ($orderStatus === 'rejected')
                    bg-red-300 @endif
                    ">
                {{ $orderStatus }}
            </span>
        </h3>
        @if (session('success'))
            <div class="bg-green-600 text-center py-2 px-4 rounded-lg text-white">
                {!! session('success') !!}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-600 text-center py-2 px-4 rounded-lg text-white">
                {!! session('error') !!}
            </div>
        @endif
        @php
            $products = json_decode($order->products, true) ?? [];
        @endphp

        @if (empty($products))
            <p class="text-gray-500">No products found in this order.</p>
        @else
            <div class="flex flex-col space-y-4 w-full">
                @foreach ($products as $product)
                    <div
                        class="flex flex-col sm:flex-row justify-between items-center bg-gray-50 rounded-lg p-4 shadow-sm w-full">
                        {{-- Image and product details --}}
                        <div class="flex items-center w-full sm:w-auto">
                            <img src="{{ asset('storage/' . ($product['image'] ?? 'placeholder.png')) }}"
                                alt="{{ $product['name'] }}" class="w-24 h-24 object-cover rounded flex-shrink-0 mr-4">

                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-800 truncate">
                                    {{ Str::limit($product['name'], 20, '...') }}</h4>
                                <p class="text-gray-500 text-sm">Quantity: {{ $product['quantity'] }}</p>
                                <p class="text-gray-700 font-medium mt-1">Kshs.
                                    {{ number_format($product['price'], 2) }}
                                </p>
                                <p class="text-gray-500 text-sm">Total Amount: Kshs.
                                    {{ number_format($product['quantity'] * $product['price'], 2) }}</p>
                            </div>
                        </div>
                        @php
                            $order_status = $order->status;
                        @endphp
                        @if ($order_status != 'rejected')
                        @endif
                        {{-- Cancel button --}}
                        <div class="mt-4 sm:mt-0 sm:ml-4">


                            <div x-data="{
                                showForm: false,
                                actionType: null
                            }" class="space-y-3">

                                {{-- Buttons --}}
                                @if ($order_status === 'pending' || $order_status === 'processing')
                                    <button type="button" @click="showForm = true; actionType = 'cancel'"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500 transition">
                                        Cancel
                                    </button>
                                @endif

                                @if ($order_status === 'shipped' || $order_status === 'delivered')
                                    <button type="button" @click="showForm = true; actionType = 'return'"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500 transition">
                                        Return & Refund
                                    </button>
                                @endif

                                {{-- Shared Form (ONE URL) --}}
                                <form x-show="showForm" enctype="multipart/form-data" x-transition
                                    action="{{ route('customer.orders.cancel', $order) }}" method="POST"
                                    class="space-y-2">
                                    @csrf
                                    <label for="proof_image" class="block text-sm font-medium text-gray-700 mb-1">
                                        Proof Images
                                    </label>
                                    <input type="file" name="proof_image[]" id="proof_image"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        multiple required
                                        x-bind:placeholder="actionType === 'cancel' ? 'Proof image for cancellation' :
                                            'Proof image for return & refund'">
                                    <x-input-label for="reason">Reason</x-input-label>
                                    <x-text-input name="reason" id="reason" :placeholder="''"
                                        x-bind:placeholder="actionType === 'cancel'
                                            ?
                                            'Reason for cancellation' :
                                            'Reason for return & refund'"
                                        class="w-full" required />

                                    <input type="hidden" name="type" :value="actionType">

                                    <div class="flex gap-2">
                                        <button type="submit"
                                            class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                                            Submit
                                        </button>

                                        <button type="button" @click="showForm = false"
                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
