<!-- Notifications Dropdown -->
<div class="relative" x-data="{ notificationsOpen: false }">
    <button @click="notificationsOpen = !notificationsOpen"
        class="relative p-2 text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
        <span class="sr-only">Open notifications</span>
        <i class="fa fa-bell fa-lg" aria-hidden="true"></i>

        @php $count = $user->notifications()->whereNull('read_at')->count(); @endphp

        @if ($count > 0)
            <span
                class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-semibold leading-none text-white bg-red-600 rounded-full shadow-md ring-2 ring-white transform-gpu will-change-transform animate-pulse">
                {{ $count > 99 ? '99+' : $count }}
            </span>
        @else
            <span
                class="absolute -top-1 -right-1 inline-block h-2 w-2 bg-gray-300 rounded-full ring-2 ring-white"></span>
        @endif
    </button>
    <!-- Notifications Dropdown Menu -->
    <div x-show="notificationsOpen" @click.away="notificationsOpen = false"
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
        class="fixed md:absolute top-16 md:top-auto md:right-0 left-1/2 md:left-auto transform -translate-x-1/2 md:translate-x-0 mt-2 w-[95vw] md:w-80 max-w-sm bg-white rounded-md shadow-lg py-1 z-20 border border-gray-200">
        <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
            @if ($notifications->whereNull('read_at')->count() > 0)
                <button wire:click="markAllAsRead" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                    Mark all read
                </button>
            @endif
        </div>
        <div class="max-h-96 overflow-y-auto">
            <!-- Notification Items -->
            @if ($notifications->count() > 0)
                @foreach ($notifications as $notification)
                    <div wire:key='{{ $notification->id }}'
                        class="flex px-4 py-3 hover:bg-gray-50 border-b border-gray-100 {{ is_null($notification->read_at) ? 'bg-blue-50' : '' }}">
                        <div class="flex-shrink-0">
                            <div
                                class="w-8 h-8 rounded-full 
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
                                <p class="text-sm font-medium text-gray-900">{{ $notification->type }}</p>
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
                            <p class="text-xs text-gray-500 mt-1">{{ $notification->message }}</p>
                            <div class="flex items-center mt-2">
                                <span
                                    class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                @if (is_null($notification->read_at))
                                    <span class="ml-2 w-2 h-2 bg-blue-500 rounded-full"></span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex flex-col items-center justify-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-gray-300 w-16 h-16 block mb-2"
                        viewBox="0 0 32 32">
                        <path
                            d="M26 25.71a22.94 22.94 0 0 1-1-6.58v-5.32a8.74 8.74 0 0 0-6-8.5V5a3 3 0 0 0-6 0v.29a8.73 8.73 0 0 0-6.06 8.52v5.32a22.6 22.6 0 0 1-1 6.58 1 1 0 0 0 1 1.29h5.2A4 4 0 0 0 16 30a4 4 0 0 0 3.83-3H25a1 1 0 0 0 .8-.4 1 1 0 0 0 .2-.89zM15 5a1 1 0 0 1 2 0h-2zm1 23a2 2 0 0 1-1.71-1h3.48A2 2 0 0 1 16 28zm3-3H8.24a25.2 25.2 0 0 0 .7-5.87v-5.32C8.94 10.06 11.67 7 15 7h1.9c3.36 0 6.1 3.06 6.1 6.81v5.32a25.2 25.2 0 0 0 .7 5.87z" />
                    </svg>
                    <p class="text-sm text-gray-500">No notifications.</p>
                </div>
            @endif
        </div>
        <div class="px-4 py-2 border-t border-gray-100">
            <a href="{{ route(Auth::user()->roles->first()->name . '.notifications') }}"
                class="text-sm text-blue-600 hover:text-blue-800 font-medium block text-center">
                View all notifications
            </a>
        </div>
    </div>
</div>

<!-- Success message toast -->
@if (session()->has('message'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in-up">
        {{ session('message') }}
        <button class="ml-2 text-white hover:text-gray-200" onclick="this.parentElement.remove()">
            ×
        </button>
        <style>
            @keyframes fade-in-up {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-up {
                animation: fade-in-up 0.3s ease-out;
            }
        </style>
    </div>
@endif
