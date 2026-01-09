@extends('dashboard.layouts.dashboard')

@section('title', 'Orders')
@section('content')

    <!-- Recent Orders & Top Products -->
    <div class="grid grid-row-1 lg:grid-row-2 gap-6">
        <!-- Recent Orders -->
        @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-2 w-full">
                {{ session('success') }}
            </div>
        @endif
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900"> Orders</h2>
                    <a href="{{ route('admin.orders.returns') }}" 
                        class="text-sm bg-green-400 px-4 py-2 text-black rounded-2xl hover:text-white font-medium">
                        View Returns →
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.orders.show', $order->order_number) }}"
                                        class="text-red-600 hover:text-red-800 font-medium">
                                        {{ $order->order_number }}
                                    </a>
                                    <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">
                                                {{ substr($order->user->name ?? 'G', 0, 1) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $order->user->name ?? 'Guest' }}</p>
                                            <p class="text-xs text-gray-500">{{ $order->customer_email ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-medium text-gray-900">KES
                                        {{ number_format($order->total_amount, 2) }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-medium text-gray-900">
                                        @if ($order->payments)
                                            {{ $order->payments->transaction_code }}
                                        @endif
                                    </p>
                                </td>
                                <td class="px-1 py-2 whitespace-nowrap">
                                    <span
                                        class="px-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $order->status === 'completed'
                                    ? 'bg-green-100 text-green-800'
                                    : ($order->status === 'processing'
                                        ? 'bg-blue-100 text-blue-800'
                                        : ($order->status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($order->status === 'cancelled'
                                                ? 'bg-red-100 text-red-800'
                                                : 'bg-gray-100 text-gray-800'))) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.orders.show', $order->order_number) }}" 
                                        class="text-red-600 hover:text-red-900 mr-3">
                                        View
                                    </a>

                                    @php
                                        $hasBlockedReturn =
                                            $order->orderReturns &&
                                            in_array($order->orderReturns->status, ['approved', 'refunded']);

                                        $statusEnum = App\OrderStatus::from($order->status);

                                        $nextActions = match ($statusEnum) {
                                            App\OrderStatus::PENDING => [
                                                'process' => 'Process',
                                            ],
                                            App\OrderStatus::PROCESSING => [
                                                'ship' => 'Ship',
                                            ],
                                            App\OrderStatus::SHIPPED => [
                                                'delivered' => 'Deliver',
                                            ],
                                            default => [],
                                        };
                                    @endphp

                                    @if ($hasBlockedReturn)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $order->orderReturns->status === 'refunded' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($order->orderReturns->status) }}
                                        </span>
                                    @else
                                        @foreach ($nextActions as $actionRoute => $actionLabel)
                                            <a href="{{ route('admin.orders.status.' . $actionRoute, $order->order_number) }}"
                                                 class="text-green-600 px-2 py-1 hover:text-green-900">
                                                {{ $actionLabel }}
                                            </a>
                                        @endforeach
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2
                                                                                                                        0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9
                                                                                                                                5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="mt-2">No orders yet</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>


                </table>
            </div>
            <nav class="px-5 py-2">{{ $recentOrders->links() }}</nav>
        </div>


    </div>



@endsection
