<div wire:poll.15s class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">
                Order #{{ $return->order->order_number ?? $return->order->id }}
            </h3>
            <p class="text-sm text-gray-500">
                <span class="text-gray-500 block">From: {{ $return->order->user->name }}</span>
                Requested {{ $return->created_at->diffForHumans() }}
            </p>
        </div>

        <!-- Return Status -->
        <div class="flex items-center gap-2">
            <a href="{{ route('customer.orders.returns.show', $return) }}"
                class="px-4 py-2 bg-blue-700 rounded text-white hover:bg-blue-800 transition-colors">
                Return Details
            </a>
            <span
                class="px-3 py-1 rounded-full text-sm font-medium
                    @if ($return->status === 'pending') 
                        bg-yellow-100 text-yellow-700 border border-yellow-300
                    @elseif($return->status === 'approved') 
                        bg-blue-100 text-blue-700 border border-blue-300
                    @elseif($return->status === 'rejected') 
                        bg-red-100 text-red-700 border border-red-300
                    @elseif($return->status === 'refunded') 
                        bg-green-100 text-green-700 border border-green-300
                    @endif
                ">
                {{ ucfirst($return->status) }}
            </span>
        </div>
    </div>

    <!-- Body -->
    <div class="text-sm text-gray-700 space-y-2 border-l-4 pl-3 
        @if ($return->status === 'pending') border-yellow-500
        @elseif($return->status === 'approved') border-blue-500
        @elseif($return->status === 'rejected') border-red-500
        @elseif($return->status === 'refunded') border-green-500
        @endif">
        
        <p>
            <span class="font-medium">Order Status:</span>
            <span class="ml-1 px-2 py-1 text-xs rounded 
                @if ($return->order->status === 'delivered') bg-green-100 text-green-800
                @elseif($return->order->status === 'shipped') bg-blue-100 text-blue-800
                @elseif($return->order->status === 'processing') bg-yellow-100 text-yellow-800
                @elseif($return->order->status === 'pending') bg-gray-100 text-gray-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ ucfirst($return->order->status) }}
            </span>
        </p>

        <p>
            <span class="font-medium">Return Reason:</span>
            {{ $return->reason }}
        </p>

        <p>
            <span class="font-medium">Order Date:</span>
            {{ $return->order->created_at->format('M d, Y') }}
        </p>

        <!-- Additional return-specific info -->
        @if ($return->status === 'approved')
            <p class="text-blue-600">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Return has been approved. Follow instructions sent via email.
            </p>
        @elseif($return->status === 'rejected')
            <p class="text-red-600">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Return request was rejected. Check your email for details.
            </p>
        @elseif($return->status === 'refunded')
            <p class="text-green-600">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M5 13l4 4L19 7" />
                </svg>
                Return processed and refund issued successfully.
            </p>
            @if ($return->refunded_at)
                <p>
                    <span class="font-medium">Refunded On:</span>
                    {{ $return->refunded_at->format('M d, Y h:i A') }}
                </p>
            @endif
        @endif

        @if ($return->admin_notes)
            <div class="mt-3 p-3 bg-gray-50 rounded border border-gray-200">
                <p class="font-medium text-gray-700">Admin Notes:</p>
                <p class="text-gray-600 mt-1">{{ $return->admin_notes }}</p>
            </div>
        @endif
    </div>

</div>