@extends('dashboard.layouts.dashboard')
@section('title', 'Return Details - #' . $return->order->order_number)

@section('content')
    <div class="space-y-6">
        <!-- Back Button -->
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="font-medium">Back to Orders</span>
        </a>

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Return Request #{{ $return->id }}</h1>
                <p class="text-gray-500 mt-1">Submitted on
                    {{ \Carbon\Carbon::parse($return->created_at)->format('F j, Y \a\t g:i A') }}</p>
            </div>

        </div>

        <!-- Status Notification -->
        <div id="returnStatus" class="fixed top-5 right-5 z-50"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Return Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Return Information Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Return Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Return ID</p>
                            <p class="font-medium">#{{ $return->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Order Number</p>
                            <p class="font-medium">{{ $return->order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Order Status</p>
                            <p class="font-medium capitalize">{{ $return->order->status }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Amount</p>
                            <p class="font-medium text-green-600">KES {{ number_format($return->order->total_amount, 2) }}
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Shipping Address</p>
                            <p class="font-medium">{{ $return->order->shipping_address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Reason Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Return Reason</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">{{ $return->reason }}</p>
                    </div>
                </div>

                <!-- Product Details Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Details</h2>
                    @php
                        $products = json_decode($return->order->products, true);
                        $product = reset($products); // Get first product
                    @endphp

                    @if ($product)
                        <div class="flex items-center space-x-4 p-4 border rounded-lg">
                            @if (isset($product['image']))
                                <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}"
                                    class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $product['name'] }}</h3>
                                <p class="text-sm text-gray-500">Model: {{ $product['model'] ?? 'N/A' }}</p>
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="text-sm text-gray-600">Price: KES
                                        {{ number_format($product['price'], 2) }}</span>
                                    <span class="text-sm text-gray-600">Quantity: {{ $product['quantity'] ?? 1 }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Proof Images Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Proof Images</h2>
                        <span class="text-sm text-gray-500">{{ count($return->images) }} images</span>
                    </div>

                    @if ($return->images->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($return->images as $image)
                                <div class="relative group">
                                    <a href="{{ asset('storage/' . $image->path) }}" target="_blank" class="block">
                                        <div class="aspect-square overflow-hidden rounded-lg border border-gray-200">
                                            <img src="{{ asset('storage/' . $image->path) }}" alt="Proof image"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                        </div>
                                    </a>
                                    <div
                                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ asset('storage/' . $image->path) }}" download
                                            class="bg-white p-1 rounded-full shadow-sm" title="Download">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-gray-500">No proof images uploaded</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column - Actions & Timeline -->
            <div class="space-y-6">
                <!-- Status Actions Card -->
                <div class="bg-white shadow rounded-lg p-6 sticky top-10">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h2>
                    <div class="space-y-3">
                        <livewire:return-actions :return="$return" />
                        <script>
                            function getRoute(status) {
                                const select = document.querySelector('select[name="status"]');
                                const selectedOption = select.options[select.selectedIndex];
                                return selectedOption.getAttribute('data-route');
                            }
                        </script>

                        <!-- Quick Actions -->
                        <div class="pt-4 border-t">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Quick Actions</h3>
                            <div class="space-y-2">
                                <a href="{{ route('admin.orders.show', $return->order->order_number) }}"
                                    class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Order
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Timeline Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Return Timeline</h2>
                    <div class="space-y-4">
                        <!-- Timeline 1: Return Request Submitted -->
                        <div class="flex">
                            <div class="flex flex-col items-center mr-4">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
                            </div>
                            <div class="flex-1 pb-4">
                                <p class="text-sm font-medium text-gray-900">Return Request Submitted</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($return->created_at)->format('M j, Y g:i A') }}</p>
                                <p class="text-xs text-gray-600 mt-1">Customer requested return for order
                                    #{{ $return->order_id }}</p>
                            </div>
                        </div>

                        <!-- Timeline 2: Admin Review -->
                        <div class="flex">
                            <div class="flex flex-col items-center mr-4">
                                <div
                                    class="w-8 h-8 rounded-full {{ $return->status == 'pending' ? 'bg-yellow-100' : 'bg-green-100' }} flex items-center justify-center">
                                    @if ($return->status == 'pending')
                                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
                            </div>
                            <div class="flex-1 pb-4">
                                <p class="text-sm font-medium text-gray-900">Under Review</p>
                                @if ($return->status == 'pending')
                                    <p class="text-xs text-yellow-600 font-medium">Currently reviewing</p>
                                @else
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($return->updated_at)->subHours(2)->format('M j, Y g:i A') }}
                                    </p>
                                    <p class="text-xs text-gray-600 mt-1">Return request reviewed by admin</p>
                                @endif
                            </div>
                        </div>

                        <!-- Timeline 3: Status Decision -->
                        <div class="flex">
                            <div class="flex flex-col items-center mr-4">
                                <div
                                    class="w-8 h-8 rounded-full 
                    {{ $return->status == 'approved'
                        ? 'bg-blue-100'
                        : ($return->status == 'rejected'
                            ? 'bg-red-100'
                            : ($return->status == 'completed'
                                ? 'bg-green-100'
                                : 'bg-gray-100')) }} 
                    flex items-center justify-center">
                                    @if ($return->status == 'approved')
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @elseif($return->status == 'rejected')
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    @elseif($return->status == 'completed')
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
                            </div>
                            <div class="flex-1 pb-4">
                                <p class="text-sm font-medium text-gray-900">Status Decision</p>
                                @if (in_array($return->status, ['approved', 'rejected', 'completed']))
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($return->updated_at)->format('M j, Y g:i A') }}</p>
                                    <p
                                        class="text-xs 
                        {{ $return->status == 'approved'
                            ? 'text-blue-600'
                            : ($return->status == 'rejected'
                                ? 'text-red-600'
                                : 'text-green-600') }} 
                        font-medium mt-1">
                                        Return {{ ucfirst($return->status) }}
                                    </p>
                                @else
                                    <p class="text-xs text-gray-400">Pending decision</p>
                                @endif
                            </div>
                        </div>

                        <!-- Timeline 4: Item Collection/Shipping -->
                        <div class="flex">
                            <div class="flex flex-col items-center mr-4">
                                <div
                                    class="w-8 h-8 rounded-full 
                    {{ $return->status == 'completed'
                        ? 'bg-green-100'
                        : ($return->status == 'approved'
                            ? 'bg-blue-100'
                            : 'bg-gray-100') }} 
                    flex items-center justify-center">
                                    @if ($return->status == 'completed' || $return->status == 'approved')
                                        <svg class="w-4 h-4 {{ $return->status == 'completed' ? 'text-green-600' : 'text-blue-600' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
                            </div>
                            <div class="flex-1 pb-4">
                                <p class="text-sm font-medium text-gray-900">Item Collection</p>
                                @if ($return->status == 'completed')
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($return->updated_at)->subHours(1)->format('M j, Y g:i A') }}
                                    </p>
                                    <p class="text-xs text-gray-600 mt-1">Item collected by courier</p>
                                @elseif($return->status == 'approved')
                                    <p class="text-xs text-blue-600 font-medium">Awaiting collection</p>
                                @else
                                    <p class="text-xs text-gray-400">Not applicable</p>
                                @endif
                            </div>
                        </div>

                        <!-- Timeline 5: Refund/Completion -->
                        <div class="flex">
                            <div class="flex flex-col items-center mr-4">
                                <div
                                    class="w-8 h-8 rounded-full 
                    {{ $return->status == 'completed' ? 'bg-green-100' : 'bg-gray-100' }} 
                    flex items-center justify-center">
                                    @if ($return->status == 'completed')
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Refund Processed</p>
                                @if ($return->status == 'completed')
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($return->updated_at)->format('M j, Y g:i A') }}</p>
                                    <p class="text-xs text-green-600 font-medium mt-1">Refund of
                                        ${{ number_format($return->refund_amount, 2) }} completed</p>
                                @else
                                    <p class="text-xs text-gray-400">Awaiting completion</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Info Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h2>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">User #{{ $return->order->user_id }}</p>
                                <p class="text-sm text-gray-500">Customer ID</p>
                            </div>
                        </div>
                        <div class="pt-3 border-t">
                            <p class="text-sm text-gray-500 mb-1">Order Date</p>
                            <p class="font-medium">
                                {{ \Carbon\Carbon::parse($return->order->created_at)->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        {{-- <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Admin Notes</h2>
            <form action="{{ route('admin.returns.add-note', $return->id) }}" method="POST">
                @csrf
                <textarea name="notes" rows="3" 
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                          placeholder="Add notes about this return..."></textarea>
                <div class="mt-3 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">
                        Save Note
                    </button>
                </div>
            </form>
        </div> --}}
    </div>

    <!-- JavaScript for Image Lightbox -->
    <script>
        // Simple image lightbox
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img[src*="storage"]');
            images.forEach(img => {
                img.addEventListener('click', function(e) {
                    e.preventDefault();
                    const src = this.src;
                    const lightbox = document.createElement('div');
                    lightbox.className =
                        'fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center';
                    lightbox.innerHTML = `
                        <div class="relative max-w-4xl max-h-full">
                            <img src="${src}" class="max-w-full max-h-screen">
                            <button onclick="this.parentElement.parentElement.remove()" 
                                    class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    `;
                    document.body.appendChild(lightbox);
                });
            });
        });
    </script>
@endsection
