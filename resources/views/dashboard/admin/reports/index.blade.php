@extends('dashboard.layouts.dashboard')

@section('title', 'Analytics Reports')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Analytics Reports</h1>
            <p class="text-gray-600 mt-1">Real-time insights and performance metrics</p>
        </div>

        <!-- Print and Export Buttons -->
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.reports.print') }}" 
                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-sm hover:shadow-md transition-all duration-200 group">
                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Download PDF Report
            </a>

            <a href="{{ route('admin.reports.excel') }}"
                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 shadow-sm hover:shadow-md transition-all duration-200 group">
                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Excel
            </a>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-8">
        <!-- Total Orders -->
        <div
            class="bg-gradient-to-br from-blue-50 to-white border border-blue-100 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 mb-1">Total Orders</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($stats['totalOrders']) }}</h3>
                </div>
                <div class="bg-blue-500 p-2.5 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-blue-100">
                <div class="flex items-center text-sm text-blue-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span>All time orders</span>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div
            class="bg-gradient-to-br from-purple-50 to-white border border-purple-100 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600 mb-1">Total Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-900">KES {{ number_format($stats['totalRevenue'], 0) }}</h3>
                </div>
                <div class="bg-purple-500 p-2.5 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-purple-100">
                <div class="flex items-center text-sm text-purple-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span>Gross revenue</span>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div
            class="bg-gradient-to-br from-yellow-50 to-white border border-yellow-100 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-yellow-600 mb-1">Pending Orders</p>
                    <h3 class="text-2xl font-bold text-yellow-700">{{ number_format($stats['pendingOrders']) }}</h3>
                </div>
                <div class="bg-yellow-500 p-2.5 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-yellow-100">
                <div class="flex items-center text-sm text-yellow-600">
                    <span
                        class="font-medium">{{ number_format(($stats['pendingOrders'] / max($stats['totalOrders'], 1)) * 100, 1) }}%</span>
                    <span class="ml-2">of total orders</span>
                </div>
            </div>
        </div>

        <!-- Delivered Orders -->
        <div
            class="bg-gradient-to-br from-green-50 to-white border border-green-100 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600 mb-1">Delivered Orders</p>
                    <h3 class="text-2xl font-bold text-green-700">{{ number_format($stats['deliveredOrders']) }}</h3>
                </div>
                <div class="bg-green-500 p-2.5 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-green-100">
                <div class="flex items-center text-sm text-green-600">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ number_format(($stats['deliveredOrders'] / max($stats['totalOrders'], 1)) * 100, 1) }}% success
                        rate</span>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div
            class="bg-gradient-to-br from-indigo-50 to-white border border-indigo-100 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-indigo-600 mb-1">New Customers</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($stats['newCustomers']) }}</h3>
                </div>
                <div class="bg-indigo-500 p-2.5 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-10a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-indigo-100">
                <div class="flex items-center text-sm text-indigo-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span>This month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Sales Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Sales Overview</h2>
                        <p class="text-sm text-gray-500 mt-1">Daily revenue trends</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <select
                                class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Last 7 days</option>
                                <option selected>Last 30 days</option>
                                <option>Last 90 days</option>
                                <option>This year</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="h-72">
                    <!-- Chart Container -->
                    <canvas id="salesChart"></canvas>
                </div>
                <!-- Chart Stats -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        {{-- <div class="text-center">
                            <p class="text-sm text-gray-500">Today</p>
                            <p class="font-semibold text-gray-900">KES {{ number_format(end($salesData->pluck('total')->toArray()) ?? 0) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500">This Week</p>
                            <p class="font-semibold text-gray-900">KES {{ number_format(array_sum(array_slice($salesData->pluck('total')->toArray(), -7))) }}</p>
                        </div> --}}
                        <div class="text-center">
                            <p class="text-sm text-gray-500">Avg. Daily</p>
                            <p class="font-semibold text-gray-900">KES {{ number_format($salesData->avg('total') ?? 0) }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500">Growth</p>
                            <p class="font-semibold text-green-600">+12.5%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
                        <p class="text-sm text-gray-500 mt-1">Latest system activities</p>
                    </div>
                    <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View All
                    </button>
                </div>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse ($activities as $activity)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-10 h-10 rounded-lg {{ $activity['bgColor'] }} flex items-center justify-center">
                                    <div class="{{ $activity['textColor'] }}">
                                        {!! $activity['icon'] !!}
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 mb-1">
                                    {{ $activity['title'] }}
                                </p>
                                <p class="text-sm text-gray-600 mb-2">
                                    {{ $activity['description'] }}
                                </p>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $activity['time'] }}
                                </div>
                            </div>

                            <div class="flex-shrink-0">
                                <div
                                    class="w-2 h-2 rounded-full {{ str_contains($activity['bgColor'], 'green') ? 'bg-green-500' : 'bg-blue-500' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="text-gray-400 mb-3">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-gray-500">No recent activity</p>
                        <p class="text-sm text-gray-400 mt-1">Activities will appear here</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Top Products -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Top Products</h2>
            <div class="space-y-4">

                @foreach ($topProducts as $topProduct)
                    <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                <span class="font-semibold text-gray-700">#{{ $topProduct->id }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $topProduct->name }}</p>
                                <p class="text-sm text-gray-500">{{ $topProduct->category->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">KES {{ number_format(rand(10000, 50000)) }}</p>
                            <p class="text-sm text-green-600">+{{ rand(5, 25) }}%</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Status</h2>
            <div class="h-48 mb-4">
                <canvas id="orderStatusChart"></canvas>
            </div>
            <div class="space-y-2">
                @foreach (['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'] as $status)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-3 h-3 rounded-full 
                                @if ($status == 'Pending') bg-yellow-500
                                @elseif($status == 'Processing') bg-blue-500
                                @elseif($status == 'Shipped') bg-indigo-500
                                @elseif($status == 'Delivered') bg-green-500
                                @else bg-red-500 @endif mr-2">
                            </div>
                            <span class="text-sm text-gray-600">{{ $status }}</span>
                        </div>
                        <span class="font-medium text-gray-900">{{ rand(5, 30) }}%</span>
                    </div>
                @endforeach
            </div>
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
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#3b82f6',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'KES ' + context.parsed.y.toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false,
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return 'KES ' + value.toLocaleString();
                                    },
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'nearest'
                        }
                    }
                });

                // Order Status Chart
                const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
                const statusChart = new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
                        datasets: [{
                            data: [15, 20, 25, 30, 10],
                            backgroundColor: [
                                '#f59e0b',
                                '#3b82f6',
                                '#6366f1',
                                '#10b981',
                                '#ef4444'
                            ],
                            borderWidth: 0,
                            hoverOffset: 10
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
                        cutout: '70%'
                    }
                });

                // Export to Excel function
                window.exportToExcel = function() {
                    alert('Export to Excel functionality would be implemented here.');
                    // In production, you would make an AJAX call to your backend
                    // to generate and download the Excel file
                };
            });
        </script>
    @endpush
@endsection
