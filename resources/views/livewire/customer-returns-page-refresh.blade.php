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
        <div>
            <a href="{{ route('customer.orders.returns.show', $return) }}"
                class="px-4 py-2 bg-blue-700 rounded text-white">Return Details</a>
            <span
                class="px-3 py-1 rounded-full text-sm font-medium
                    @if ($return->status === 'pending') bg-yellow-100 text-yellow-700
                    @elseif($return->status === 'approved') bg-green-100 text-green-700
                    @elseif($return->status === 'rejected') bg-red-100 text-red-700 @endif
                ">
                {{ ucfirst($return->status) }}
            </span>
        </div>
    </div>

    <!-- Body -->
    <div class="text-sm text-gray-700 space-y-2 border-red-700 border-l-4 pl-3">
        <p>
            <span class="font-medium">Order Status:</span>
            {{ ucfirst($return->order->status) }}
        </p>

        <p>
            <span class="font-medium">Return Reason:</span>
            {{ $return->reason }}
        </p>

        <p>
            <span class="font-medium">Order Date:</span>
            {{ $return->order->created_at->format('M d, Y') }}
        </p>
    </div>

</div>
