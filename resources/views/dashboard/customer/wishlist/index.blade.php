@extends('dashboard.layouts.dashboard')
@section('title', "Return Details - #{$return->order->order_number}")

@section('content')
    <div class="space-y-6">
        <!-- Back Button -->
        <a href="{{ route('customer.orders.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="font-medium">Back to My Orders</span>
        </a>

        <!-- Header -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Return Request</h1>
                    <div class="mt-2 flex flex-wrap items-center gap-3">
                        @php
                            $statusColors = [
                                'pending' => [
                                    'bg' => 'bg-yellow-100',
                                    'text' => 'text-yellow-800',
                                    'border' => 'border-yellow-200',
                                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                ],
                                'approved' => [
                                    'bg' => 'bg-green-100',
                                    'text' => 'text-green-800',
                                    'border' => 'border-green-200',
                                    'icon' => 'M5 13l4 4L19 7',
                                ],
                                'refunded' => [
                                    'bg' => 'bg-green-100',
                                    'text' => 'text-green-800',
                                    'border' => 'border-green-200',
                                    'icon' => 'M5 13l4 4L19 7',
                                ],
                                'rejected' => [
                                    'bg' => 'bg-red-100',
                                    'text' => 'text-red-800',
                                    'border' => 'border-red-200',
                                    'icon' => 'M6 18L18 6M6 6l12 12',
                                ],
                                'completed' => [
                                    'bg' => 'bg-blue-100',
                                    'text' => 'text-blue-800',
                                    'border' => 'border-blue-200',
                                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                ],
                                'cancelled' => [
                                    'bg' => 'bg-gray-100',
                                    'text' => 'text-gray-800',
                                    'border' => 'border-gray-200',
                                    'icon' => 'M6 18L18 6M6 6l12 12',
                                ],
                                'processing' => [
                                    'bg' => 'bg-purple-100',
                                    'text' => 'text-purple-800',
                                    'border' => 'border-purple-200',
                                    'icon' =>
                                        'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                                ],
                            ];
                            $colors = $statusColors[$return->status] ?? [
                                'bg' => 'bg-gray-100',
                                'text' => 'text-gray-800',
                                'border' => 'border-gray-200',
                                'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                            ];
                        @endphp

                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $colors['bg'] }} {{ $colors['text'] }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $colors['icon'] }}" />
                            </svg>
                            {{ ucfirst($return->status) }}
                        </span>
                        <span class="text-gray-500">Order #{{ $return->order->order_number }}</span>
                        <span class="text-gray-500">•</span>
                        <span
                            class="text-gray-500">{{ \Carbon\Carbon::parse($return->created_at)->format('M j, Y') }}</span>
                        <span class="text-gray-500">•</span>
                        <span class="text-gray-500">Updated:
                            {{ \Carbon\Carbon::parse($return->updated_at)->format('M j, g:i A') }}</span>
                    </div>
                </div>
                <div class="mt-4 sm:mt-0">
                    <button onclick="window.print()"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print Details
                    </button>
                </div>
            </div>

            <!-- Dynamic Status Banner -->
            @php
                $bannerColors = [
                    'pending' => [
                        'bg' => 'from-yellow-50 to-amber-50',
                        'border' => 'border-yellow-200',
                        'icon' => 'text-yellow-600',
                        'text' => 'text-yellow-800',
                        'title' => 'Return Pending',
                    ],
                    'approved' => [
                        'bg' => 'from-green-50 to-emerald-50',
                        'border' => 'border-green-200',
                        'icon' => 'text-green-600',
                        'text' => 'text-green-800',
                        'title' => 'Return Approved!',
                    ],
                    'refunded' => [
                        'bg' => 'from-green-50 to-emerald-50',
                        'border' => 'border-green-200',
                        'icon' => 'text-green-600',
                        'text' => 'text-green-800',
                        'title' => 'Return Refunded!',
                    ],
                    'rejected' => [
                        'bg' => 'from-red-50 to-pink-50',
                        'border' => 'border-red-200',
                        'icon' => 'text-red-600',
                        'text' => 'text-red-800',
                        'title' => 'Return Rejected',
                    ],
                    'completed' => [
                        'bg' => 'from-blue-50 to-cyan-50',
                        'border' => 'border-blue-200',
                        'icon' => 'text-blue-600',
                        'text' => 'text-blue-800',
                        'title' => 'Return Completed!',
                    ],
                    'cancelled' => [
                        'bg' => 'from-gray-50 to-slate-50',
                        'border' => 'border-gray-200',
                        'icon' => 'text-gray-600',
                        'text' => 'text-gray-800',
                        'title' => 'Return Cancelled',
                    ],
                    'processing' => [
                        'bg' => 'from-purple-50 to-violet-50',
                        'border' => 'border-purple-200',
                        'icon' => 'text-purple-600',
                        'text' => 'text-purple-800',
                        'title' => 'Return Processing',
                    ],
                ];
                $banner = $bannerColors[$return->status] ?? $bannerColors['pending'];

                $statusMessages = [
                    'pending' =>
                        'Your return request has been received and is under review. We will process it within 2-3 business days.',
                    'approved' =>
                        'Your return request has been approved! Please follow the instructions below to complete the return process.',
                    'rejected' =>
                        'Your return request could not be approved. Please contact support if you have questions.',
                    'completed' =>
                        'Your return has been successfully processed. The refund has been issued to your original payment method.',
                    'cancelled' => 'Your return request has been cancelled as requested.',
                    'processing' =>
                        'We have received your returned item and are currently processing it. You will be notified once complete.',
                ];
                $message = $statusMessages[$return->status] ?? 'Your return request status has been updated.';
            @endphp

            <div class="mt-4 p-4 bg-gradient-to-r {{ $banner['bg'] }} border {{ $banner['border'] }} rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 {{ $banner['icon'] }}" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            @if ($return->status == 'pending')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @elseif($return->status == 'approved')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @elseif($return->status == 'rejected')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            @elseif($return->status == 'completed')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            @elseif($return->status == 'cancelled')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            @elseif($return->status == 'processing')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @endif
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium {{ $banner['text'] }}">{{ $banner['title'] }}</h3>
                        <p class="{{ $banner['text'] }} mt-1 opacity-90">
                            {{ $message }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if ($return->status === 'approved')
            <!-- Return Instructions -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">📦 Next Steps - Return Instructions</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-bold">1</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-900">Package the Item</h3>
                            <p class="text-gray-600 mt-1">Place the item in its original packaging if available. Include all
                                accessories, manuals, and freebies.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-bold">2</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-900">Prepare for Shipping</h3>
                            <p class="text-gray-600 mt-1">Securely seal the package. Write the Return ID
                                (<strong>#{{ $return->order->order_number }}</strong>) on the outside of the package.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-bold">3</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-900">Drop Off Location</h3>
                            <p class="text-gray-600 mt-1">Take the package to your nearest courier service. We recommend
                                using a
                                trackable shipping method.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-bold">4</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-900">Keep Your Receipt</h3>
                            <p class="text-gray-600 mt-1">Save your shipping receipt with tracking number. You may need it
                                for
                                reference.</p>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-400 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-yellow-800">Important Notes</h4>
                                <ul class="mt-2 text-sm text-yellow-700 space-y-1">
                                    <li>• Return deadline:
                                        <strong>{{ \Carbon\Carbon::parse($return->updated_at)->addDays(14)->format('F j, Y') }}</strong>
                                    </li>
                                    <li>• Refund will be processed within 5-10 business days after we receive the item</li>
                                    <li>• Refund amount: <strong>KES
                                            {{ number_format($return->order->total_amount, 2) }}</strong> to original
                                        payment
                                        method</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Proof Images & Videos -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Proof Files</h2>
                        <span class="text-sm text-gray-500">{{ count($return->images) }} file(s)</span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($return->images as $image)
                            @php
                                $extension = pathinfo($image->path, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'wmv']);
                                $isDocument = in_array(strtolower($extension), ['pdf', 'doc', 'docx', 'txt']);
                            @endphp

                            <div class="group relative">
                                <a href="{{ asset('storage/' . $image->path) }}" target="_blank"
                                    class="block aspect-square overflow-hidden rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                                    @if ($isImage)
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="Proof image"
                                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-200">
                                    @elseif($isVideo)
                                        <div class="w-full h-full bg-gray-800 flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-white mb-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-white text-xs font-medium">VIDEO</span>
                                            <span class="text-gray-300 text-xs mt-1">{{ strtoupper($extension) }}</span>
                                        </div>
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span
                                                class="text-gray-600 text-xs font-medium">{{ strtoupper($extension) }}</span>
                                            <span class="text-gray-500 text-xs mt-1">DOCUMENT</span>
                                        </div>
                                    @endif

                                    <div
                                        class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-200 rounded-lg">
                                    </div>
                                </a>

                                <div
                                    class="absolute bottom-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex space-x-1">
                                    <a href="{{ asset('storage/' . $image->path) }}" target="_blank"
                                        class="bg-white p-1.5 rounded-full shadow-md hover:shadow-lg" title="View">
                                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ asset('storage/' . $image->path) }}" download
                                        class="bg-white p-1.5 rounded-full shadow-md hover:shadow-lg" title="Download">
                                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </a>
                                </div>

                                <div class="absolute top-2 left-2">
                                    <span class="text-xs bg-black bg-opacity-50 text-white px-2 py-1 rounded">
                                        @if ($isImage)
                                            IMAGE
                                        @elseif($isVideo)
                                            VIDEO
                                        @else
                                            DOC
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if (count($return->images) == 0)
                        <div class="text-center py-8 border-2 border-dashed border-gray-300 rounded-lg">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-gray-500">No proof files uploaded</p>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Being Returned</h2>
                    @php
                        $products = $return->order['products'];
                        $product = reset($products);
                    @endphp

                    @if ($product)
                        <div class="border rounded-lg p-4">
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                                @if (isset($product['image']))
                                    <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}"
                                        class="w-24 h-24 object-contain rounded-lg border border-gray-200">
                                @else
                                    <div
                                        class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900 text-lg">{{ $product['name'] }}</h3>
                                    <div class="text-gray-600 text-sm mt-1">

                                        {!! Str::limit($product['description'], 100, '...') ?? 'No description' !!}</div>
                                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <p class="text-xs text-gray-500">Unit Price</p>
                                            <p class="font-medium">KES {{ number_format($product['price'], 2) }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <p class="text-xs text-gray-500">Quantity</p>
                                            <p class="font-medium">{{ $product['quantity'] ?? 1 }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <p class="text-xs text-gray-500">Model</p>
                                            <p class="font-medium">{{ $product['model'] ?? 'N/A' }}</p>
                                        </div>
                                        <div class="bg-green-50 p-3 rounded-lg">
                                            <p class="text-xs text-green-600">Refund Amount</p>
                                            <p class="font-medium text-green-700">KES
                                                {{ number_format($product['price'] * ($product['quantity'] ?? 1), 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Return Summary -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Return Summary</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Return ID</span>
                            <span class="font-medium">#{{ $return->id }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Order Number</span>
                            <span class="font-medium">{{ $return->order->order_number }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Request Date</span>
                            <span
                                class="font-medium">{{ \Carbon\Carbon::parse($return->created_at)->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Approval Date</span>
                            <span
                                class="font-medium">{{ \Carbon\Carbon::parse($return->updated_at)->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Order Status</span>
                            <span class="font-medium capitalize">{{ $return->order->status }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Shipping Address</span>
                            <span class="font-medium text-sm text-right">{{ $return->order->shipping_address }}</span>
                        </div>
                    </div>
                </div>

                <!-- Reason for Return -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Reason for Return</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">{{ $return->reason }}</p>
                    </div>
                </div>
                @if ($return->status === 'approved')
                    <!-- Refund Information -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">💰 Refund Information</h2>
                        <div class="space-y-4">
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-green-600">Refund Amount</p>
                                        <p class="text-xl font-bold text-green-700">KES
                                            {{ number_format($return->order->total_amount, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Refund Method</span>
                                    <span class="text-sm font-medium">Original Payment Method</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Processing Time</span>
                                    <span class="text-sm font-medium">5-10 business days</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Return Deadline</span>
                                    <span
                                        class="text-sm font-medium">{{ \Carbon\Carbon::parse($return->updated_at)->addDays(14)->format('M j') }}</span>
                                </div>
                            </div>

                            <div class="pt-4 border-t">
                                <p class="text-xs text-gray-500">
                                    *Refund begins processing after we receive and inspect the returned item.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- Customer Actions -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Need Assistance?</h2>
                    <div class="space-y-3">
                        <a href="mailto:procodestechnologies@gmail.com?subject=Return%20%23{{ $return->id }}%20-%20Order%20%23{{ $return->order->order_number }}&body=Hello%20Support%2C%0D%0A%0D%0ARegarding%20Return%20%23{{ $return->id }}%20(Order%20%23{{ $return->order->order_number }})%0D%0A%0D%0AMy%20message%3A%0D%0A%0D%0A%3CPlease%20type%20your%20message%20here%3E%0D%0A%0D%0A%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%2D%0D%0A{{ urlencode(auth()->user()->name) }}%0D%0A{{ urlencode(auth()->user()->email) }}"
                            class="flex items-center justify-center w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <!-- SVG icon -->
                            Email Support
                        </a>

                        <a href="{{ route('customer.orders.show', $return->order->order_number) }}"
                            class="flex items-center justify-center w-full px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            View Original Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Modal Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle video clicks
            document.querySelectorAll('a[href$=".mp4"], a[href$=".mov"], a[href$=".avi"], a[href$=".wmv"]').forEach(
                link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const videoUrl = this.getAttribute('href');

                        const modal = document.createElement('div');
                        modal.className =
                            'fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4';
                        modal.innerHTML = `
                        <div class="relative max-w-4xl w-full">
                            <video controls class="w-full rounded-lg" autoplay>
                                <source src="${videoUrl}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <button onclick="this.parentElement.parentElement.remove()" 
                                    class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-70">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    `;
                        document.body.appendChild(modal);
                    });
                });

            // Handle image clicks (lightbox)
            document.querySelectorAll('a[href$=".jpg"], a[href$=".jpeg"], a[href$=".png"], a[href$=".gif"]')
                .forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const lightbox = document.createElement('div');
                        lightbox.className =
                            'fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4';
                        lightbox.innerHTML = `
                        <div class="relative max-w-4xl max-h-full">
                            <img src="${this.getAttribute('href')}" class="max-w-full max-h-screen rounded-lg">
                            <button onclick="this.parentElement.parentElement.remove()" 
                                    class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-70">
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
