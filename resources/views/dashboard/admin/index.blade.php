@extends('dashboard.layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('header')
    <div class="flex justify-between items-center">

        <div class="flex space-x-2">
            <button onclick="window.print()"
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print
            </button>
            <a href="{{ route('admin.reports') }}"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Generate Report
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Orders -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['totalOrders'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['pendingOrders'] ?? 0 }} pending</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View Orders →
                </a>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">KES {{ number_format($stats['totalRevenue'] ?? 0, 2) }}
                    </p>
                    <p class="text-xs text-green-600 mt-1">Today: KES {{ number_format($stats['todayRevenue'] ?? 0, 2) }}
                    </p>
                </div>
                <div class="p-3 bg-green-50 rounded-xl">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.reports.sales') }}"
                    class="text-sm text-green-600 hover:text-green-800 font-medium">
                    Sales Report →
                </a>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Products</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['totalProducts'] ?? 0 }}</p>
                    <p class="text-xs text-red-600 mt-1">{{ $stats['lowStockProducts'] ?? 0 }} low stock</p>
                </div>
                <div class="p-3 bg-purple-50 rounded-xl">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.products.index') }}"
                    class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                    Manage Products →
                </a>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Customers</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['totalCustomers'] ?? 0 }}</p>
                    <p class="text-xs text-blue-600 mt-1">{{ $stats['newCustomers'] ?? 0 }} new this month</p>
                </div>
                <div class="p-3 bg-pink-50 rounded-xl">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.9 0-1.7.2-2.4.5l-.6.9-1.1-.3c-.3 0-.6.1-.8.3l-.9.8-1.1-.2c-.3 0-.5 0-.8.1l-1.1.1" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.users.index') }}" class="text-sm text-pink-600 hover:text-pink-800 font-medium">
                    View Customers →
                </a>
            </div>
        </div>

        <!-- Average Order Value -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Avg. Order Value</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">KES
                        {{ number_format($stats['averageOrderValue'] ?? 0, 2) }}</p>
                    <p class="text-xs {{ $stats['aovChange'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                        {{ $stats['aovChange'] >= 0 ? '↑' : '↓' }} {{ abs($stats['aovChange'] ?? 0) }}%
                    </p>
                </div>
                <div class="p-3 bg-yellow-50 rounded-xl">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.reports') }}" class="text-sm text-yellow-600 hover:text-yellow-800 font-medium">
                    Analytics →
                </a>
            </div>
        </div>

        <!-- Conversion Rate -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Conversion Rate</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ number_format($stats['conversionRate'] ?? 0, 1) }}%</p>
                    <p class="text-xs {{ $stats['crChange'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                        {{ $stats['crChange'] >= 0 ? '↑' : '↓' }} {{ abs($stats['crChange'] ?? 0) }}%
                    </p>
                </div>
                <div class="p-3 bg-indigo-50 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.settings') }}"
                    class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    Settings →
                </a>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="grid grid-row-1 lg:grid-row-2 gap-6 mb-8">
        <!-- Sales Chart -->
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Sales Overview</h2>
                <div class="flex space-x-2">
                    <select class="text-sm border border-gray-300 rounded-lg px-3 py-1">
                        <option>Last 7 days</option>
                        <option selected>Last 30 days</option>
                        <option>Last 90 days</option>
                        <option>This year</option>
                    </select>
                </div>
            </div>
            <div class="h-80">
                <!-- Chart Container -->
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-xl border p-6">
            <h2 class="text-lg font-semibold mb-4">Recent Activity</h2>

            <div class="space-y-4">
                @forelse ($recentActivities as $activity)
                    <div class="flex items-center gap-4 p-4 rounded-lg {{ $activity['bgColor'] }}">
                        <div class="{{ $activity['textColor'] }}">
                            {!! $activity['icon'] !!}
                        </div>

                        <div class="flex-1">
                            <p class="font-medium text-gray-900">
                                {{ $activity['title'] }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $activity['description'] }}
                            </p>
                        </div>

                        <span class="text-xs text-gray-500">
                            {{ $activity['time'] }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center">
                        No recent activity
                    </p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Orders & Top Products -->
    <div class="grid grid-row-1 lg:grid-row-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>
                    <a href="{{ route('admin.orders.index') }}"
                        class="text-sm text-red-600 hover:text-red-800 font-medium">
                        View all →
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
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="text-red-600 hover:text-red-800 font-medium">
                                        {{ $order->order_number }}
                                    </a>
                                    <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">
                                                {{ substr($order->customer_name ?? 'G', 0, 1) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $order->customer_name ?? 'Guest' }}</p>
                                            <p class="text-xs text-gray-500">{{ $order->customer_email ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-medium text-gray-900">KES
                                        {{ number_format($order->total_amount, 2) }}</p>
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
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="text-red-600 hover:text-red-900 mr-3">View</a>
                                    @if ($order->status === 'pending')
                                        <a href="#" class="text-green-600 hover:text-green-900">Process</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="mt-2">No orders yet</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Top Selling Products</h2>
                    <a href="{{ route('admin.products.index') }}"
                        class="text-sm text-red-600 hover:text-red-800 font-medium">
                        View all →
                    </a>
                </div>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($topProducts as $product)
                    <div class="p-6 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">KES {{ number_format($product->price, 2) }}</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span
                                        class="text-xs px-2 py-1 rounded-full 
                                {{ $product->stock > 10
                                    ? 'bg-green-100 text-green-800'
                                    : ($product->stock > 0
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : 'bg-red-100 text-red-800') }}">
                                        {{ $product->stock }} in stock
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $product->orders_count ?? 0 }} sold</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900">KES {{ number_format($product->revenue ?? 0, 2) }}
                            </p>
                            <p class="text-xs text-gray-500">Revenue</p>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="mt-2">No products yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Stats Footer -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gray-50 rounded-lg p-4 text-center">
            <p class="text-sm text-gray-500">Orders Today</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['todayOrders'] ?? 0 }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4 text-center">
            <p class="text-sm text-gray-500">Visitors Today</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['todayVisitors'] ?? 'N/A' }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4 text-center">
            <p class="text-sm text-gray-500">Refund Requests</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['refundRequests'] ?? 0 }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4 text-center">
            <p class="text-sm text-gray-500">Avg. Response Time</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['avgResponseTime'] ?? 'N/A' }}h</p>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Sales Chart
                const salesCtx = document.getElementById('salesChart').getContext('2d');
                const salesChart = new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: @json($salesData->pluck('date')),
                        datasets: [{
                            label: 'Sales (KES)',
                            data: @json($salesData->pluck('total')),
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false
                                },
                                ticks: {
                                    callback: function(value) {
                                        return 'KES ' + value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
