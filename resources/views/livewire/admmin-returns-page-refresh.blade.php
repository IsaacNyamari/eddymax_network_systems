<div wire:poll.15s class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Return Timeline</h2>
    <div class="space-y-4">
        <!-- Timeline 1: Return Request Submitted -->
        <div class="flex">
            <div class="flex flex-col items-center mr-4">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
            </div>
            <div class="flex-1 pb-4">
                <p class="text-sm font-medium text-gray-900">Return Request Submitted</p>
                <p class="text-xs text-gray-500">
                    {{ $return->created_at->diffForHumans() }}</p>
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
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        {{ $return->updated_at->diffForhumans() }}
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
                        : ($return->status == 'refunded'
                            ? 'bg-purple-100'
                            : 'bg-gray-100'))) }} 
            flex items-center justify-center">
                    @if ($return->status == 'approved')
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @elseif($return->status == 'rejected')
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    @elseif($return->status == 'completed')
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    @elseif($return->status == 'refunded')
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z">
                            </path>
                        </svg>
                    @else
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
                <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
            </div>
            <div class="flex-1 pb-4">
                <p class="text-sm font-medium text-gray-900">Status Decision</p>
                @if (in_array($return->status, ['approved', 'rejected', 'completed', 'refunded']))
                    <p class="text-xs text-gray-500">
                        {{ $return->updated_at->diffForHumans() }}</p>
                    <p
                        class="text-xs 
                {{ $return->status == 'approved'
                    ? 'text-blue-600'
                    : ($return->status == 'rejected'
                        ? 'text-red-600'
                        : ($return->status == 'completed'
                            ? 'text-green-600'
                            : ($return->status == 'refunded'
                                ? 'text-purple-600'
                                : 'text-gray-600'))) }} 
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
                    {{ $return->status == 'refunded'
                        ? 'bg-green-100'
                        : ($return->status == 'approved'
                            ? 'bg-blue-100'
                            : 'bg-gray-100') }} 
                    flex items-center justify-center">
                    @if ($return->status == 'completed' || $return->status == 'approved')
                        <svg class="w-4 h-4 {{ $return->status == 'completed' ? 'text-green-600' : 'text-blue-600' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    @else
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    @endif
                </div>
                <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
            </div>
            <div class="flex-1 pb-4">
                <p class="text-sm font-medium text-gray-900">Item Collection</p>
                @if ($return->status == 'approved' ||$return->status == 'refunded')
                    <p class="text-xs text-gray-500">
                        {{ $return->updated_at->diffForHumans() }}
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
                    {{ $return->status == 'refunded' ? 'bg-green-100' : 'bg-gray-100' }} 
                    flex items-center justify-center">
                    @if ($return->status == 'refunded')
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    @else
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    @endif
                </div>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">Refund Processed</p>
                @if ($return->status == 'refunded')
                    <p class="text-xs text-gray-500">
                        {{ $return->updated_at->diffForHumans() }}</p>
                    <p class="text-xs text-green-600 font-medium mt-1">Refund of
                        KES {{ number_format($return->order->payments->amount, 2) }} completed</p>
                @else
                    <p class="text-xs text-gray-400">Awaiting completion</p>
                @endif
            </div>
        </div>
    </div>
</div>
