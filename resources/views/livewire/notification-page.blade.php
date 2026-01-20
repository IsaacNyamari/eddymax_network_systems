{{-- create a page that will display all notifications --}}
<div class="p-3 bg-white rounded shadow-md">
    <div class="flex flex-row mb-2">
        <h1 class="text-2xl font-bold mb-4 ">All Notifications</h1>
        <button wire:click="markAllAsRead"
            class="ml-auto px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
            <i class="fa fa-check-circle" aria-hidden="true"></i> Mark all as read
        </button>
    </div>

    @if ($notifications->isEmpty())
        <p class="text-gray-600">You have no notifications.</p>
    @else
        <div class="space-y-4">
            @foreach ($notifications as $notification)
                <div wire:key='{{ $notification->id }}'
                    class="flex px-4 py-3 hover:bg-gray-50 border-b border-gray-100  @if (is_null($notification->read_at)) border-l-emerald-600 bg-blue-200 border-l-4 @endif }}">
                    <div class="flex-shrink-0">
                        <div
                            class="w-8 capitalize h-8 rounded-full 
                            @switch($notification->type)
                                @case('order') bg-green-100 @break
                                @case('payment') bg-blue-100 @break
                                @case('alert') bg-red-100 @break
                                @default bg-gray-100
                            @endswitch
                            flex items-center justify-center">
                            <svg class="h-4 w-4 
                                @switch($notification->type)
                                    @case('order') text-green-600 @break
                                    @case('payment') text-blue-600 @break
                                    @case('alert') text-red-600 @break
                                    @default text-gray-600
                                @endswitch"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @switch($notification->type)
                                    @case('order')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    @break

                                    @case('payment')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    @break

                                    @case('alert')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    @break

                                    @default
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                @endswitch
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 flex-1">
                        <div class="flex justify-between items-start">
                            <p class="text-sm capitalize font-medium text-gray-900">
                                {{ $notification->type }}</p>
                            <div class="flex space-x-2">
                                @if (is_null($notification->read_at))
                                    <button wire:click="markNotificationAsRead({{ $notification->id }})"
                                        class="text-xs text-green-600 hover:text-green-800">
                                        Mark read
                                    </button>
                                @endif
                                <button wire:click="deleteNotification({{ $notification->id }})"
                                    onclick="return confirm('Delete this notification?')"
                                    class="text-xs text-red-600 hover:text-red-800">
                                    Delete
                                </button>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-700">
                            {{ $notification['message'] ?? 'No message available.' }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
