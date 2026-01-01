@extends('dashboard.layouts.dashboard')

@section('title', 'My Dashboard')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Dashboard</h1>
            <p class="text-gray-600 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('store.shop') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Continue Shopping
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Orders -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['totalOrders'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('customer.orders.index') }}"
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View Orders →
                </a>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pending Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['pendingOrders'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-yellow-50 rounded-xl">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('customer.orders.filter', 'pending') }}"
                    class="text-sm text-yellow-600 hover:text-yellow-800 font-medium">
                    Track Orders →
                </a>
            </div>
        </div>

        <!-- Shipped Orders -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Shipped Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['shippedOrders'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('customer.orders.filter', 'shipped') }}"
                    class="text-sm text-slate-600 hover:text-slate-800 font-medium">
                    View History →
                </a>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Completed Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['deliveredOrders'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-50 rounded-xl">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('customer.orders.filter', 'delivered') }}"
                    class="text-sm text-green-600 hover:text-green-800 font-medium">
                    View History →
                </a>
            </div>
        </div>

        <!-- Total Spent -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Spent</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">KES {{ number_format($stats['totalSpent'] ?? 0, 2) }}
                    </p>
                </div>
                <div class="p-3 bg-purple-50 rounded-xl">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('customer.orders.index') }}"
                    class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                    Order Details →
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>
                <a href="{{ route('customer.orders.index') }}" class="text-sm text-red-600 hover:text-red-800 font-medium">
                    View all →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            @if ($recentOrders->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order
                                #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($recentOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('customer.orders.show', $order) }}"
                                        class="text-red-600 hover:text-red-800 font-medium">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    KES {{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
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
                                    <a href="{{ route('customer.orders.show', $order->order_number) }}"
                                        class="text-red-600 hover:text-red-900 mr-3">View</a>
                                    @if ($order->status === 'pending')
                                        <a href="#" class="text-gray-600 hover:text-gray-900">Cancel</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="mt-2">You haven't placed any orders yet</p>
                    <a href="{{ route('store.shop') }}"
                        class="mt-4 inline-block px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('customer.profile.edit') }}"
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:border-red-300 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="p-3 bg-blue-50 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">My Profile</h3>
                    <p class="text-sm text-gray-500">Update your personal information</p>
                </div>
            </div>
        </a>
        <a href="{{ route('customer.profile.edit') }}"
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:border-red-300 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="p-3 bg-green-50 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">My Addresses</h3>
                    <p class="text-sm text-gray-500">Manage delivery addresses</p>
                </div>
            </div>
        </a>

        <a href="{{ route('store.shop') }}"
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:border-red-300 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="p-3 bg-red-50 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Continue Shopping</h3>
                    <p class="text-sm text-gray-500">Browse our products</p>
                </div>
            </div>
        </a>
    </div>
@endsection
