@extends('dashboard.layouts.dashboard')

@section('title', 'Reports')

@section('content')

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <!-- In your dashboard view -->
        <a href="{{ route('admin.reports.print') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Download PDF Report
        </a>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl border">
            <p class="text-sm text-gray-500">Total Orders</p>
            <p class="text-2xl font-semibold">{{ $stats['totalOrders'] }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl border">
            <p class="text-sm text-gray-500">Revenue</p>
            <p class="text-2xl font-semibold">
                KES {{ number_format($stats['totalRevenue'], 2) }}
            </p>
        </div>

        <div class="bg-white p-5 rounded-xl border">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-2xl font-semibold text-yellow-600">
                {{ $stats['pendingOrders'] }}
            </p>
        </div>

        <div class="bg-white p-5 rounded-xl border">
            <p class="text-sm text-gray-500">Delivered</p>
            <p class="text-2xl font-semibold text-green-600">
                {{ $stats['deliveredOrders'] }}
            </p>
        </div>

        <div class="bg-white p-5 rounded-xl border">
            <p class="text-sm text-gray-500">Customers</p>
            <p class="text-2xl font-semibold">
                {{ $stats['newCustomers'] }}
            </p>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="grid grid-row-3 lg:grid-row-2 gap-6 mb-8">
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
                @forelse ($activities as $activity)
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
