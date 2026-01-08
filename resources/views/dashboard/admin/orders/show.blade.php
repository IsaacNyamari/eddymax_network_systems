@extends('dashboard.layouts.dashboard')
@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-0">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Status</h3>
        @if ($order->orderReturns)
            @php
                $ostatus = $order->orderReturns->status;
            @endphp
            <div
                class="mb-2 @switch( $ostatus )
                @case('refunded')
                    bg-blue-500
                    @break
                @case('approved')
                    bg-green-500
                    @break
                @case('rejected')
                    bg-red-500
                    @break
                @case('pending')
                    bg-orange-500
                    @break
            
                @default
                    
            @endswitch text-white rounded px-4 py-2">
                This order return is {{ $ostatus }}
            </div>
        @endif
        @if (!$order->orderReturns || !in_array($order->orderReturns->status, ['refunded', 'approved']))
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
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
        @endif
        <!-- Customer Details -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Customer Information
                </h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500">Full Name</p>
                            <p class="text-sm font-medium text-gray-900">{{ $order->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Email Address</p>
                            <p class="text-sm font-medium text-gray-900">{{ $order->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Phone Number</p>
                            <p class="text-sm font-medium text-gray-900">{{ $order->user->addresses->first()->phone }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Customer Since</p>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $order->user->created_at->format('M d, Y') ?? 'Guest Customer' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Address -->
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Delivery Address
                </h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0 mr-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $order->shipping_address }}</p>
                            <div class="mt-1 text-sm text-gray-600">
                                <p class="mt-1">Delivery Instructions:
                                    <span
                                        class="font-medium">{{ $order->delivery_notes ?? 'No special instructions' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Order Summary
                </h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500">Order Number</p>
                            <p class="text-sm font-medium text-gray-900">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Order Date</p>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Payment Method</p>
                            <p class="text-sm font-medium text-gray-900">{{ ucfirst('Paystack (Mpesa)') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Payment Status</p>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                        {{ $order->payment_status === 'completed'
                            ? 'bg-green-100 text-green-800'
                            : ($order->payment_status === 'pending'
                                ? 'bg-yellow-100 text-yellow-800'
                                : 'bg-red-100 text-red-800') }}">
                                Paid
                            </span>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-gray-500">Total Amount</p>
                            <p class="text-lg font-bold text-gray-900">KES {{ number_format($order->total_amount, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Actions -->
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Quick Actions
                </h4>
                <div class="grid grid-cols-2 gap-3">
                    <a href="mailto:{{ $order->user->email }}"
                        class="bg-white border border-gray-300 rounded-lg p-3 text-center hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mx-auto text-gray-600 mb-1" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Send Email</span>
                    </a>
                    <a href="tel:{{ $order->user->addresses->first()->phone }}"
                        class="bg-white border border-gray-300 rounded-lg p-3 text-center hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mx-auto text-gray-600 mb-1" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Call Customer</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
