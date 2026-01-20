<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dashboard Report - {{ now()->format('Y-m-d') }}</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            background-color: #f9fafb;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        tr {
            margin-bottom: 15px !important;
        }

        /* Print styles */
        @media print {
            @page {
                margin: 15mm;
            }

            body {
                background: none;
                padding: 0;
            }

            .container {
                box-shadow: none;
                padding: 0;
            }

            .page-break {
                page-break-before: always;
            }

            .keep-together {
                page-break-inside: avoid;
            }
        }

        /* Header styles */
        .header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #4F46E5;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .logo-container {
            margin-bottom: 15px;
        }

        .logo {
            max-height: 60px;
            max-width: 200px;
        }

        .report-title {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .report-subtitle {
            font-size: 14px;
            color: #6b7280;
        }

        .report-meta {
            text-align: right;
        }

        .meta-label {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .meta-value {
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
        }

        /* Summary cards */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .summary-card {
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            margin-bottom: 15px;
        }

        .summary-card-blue {
            background-color: #eff6ff;
            border-color: #dbeafe;
        }

        .summary-card-green {
            background-color: #f0fdf4;
            border-color: #dcfce7;
        }

        .summary-card-purple {
            background-color: #faf5ff;
            border-color: #f3e8ff;
        }

        .summary-label {
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 16px;
            font-weight: bold;
        }

        /* Section styles */
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .section-header {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Stats grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .stat-card {
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-details {
            font-size: 11px;
            color: #6b7280;
            margin-top: 8px;
        }

        /* Revenue section */
        .revenue-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .revenue-card {
            border-radius: 8px;
            padding: 25px;
            position: relative;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .revenue-card-primary {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: 1px solid #a7f3d0;
        }

        .revenue-card-secondary {
            background-color: white;
            border: 1px solid #e5e7eb;
        }

        /* Table styles */
        .table-container {
            overflow-x: auto;
            margin-top: 15px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background-color: #4F46E5;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
        }

        .data-table td {
            padding: 10px 15px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
        }

        .data-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .data-table tr:hover {
            background-color: #f3f4f6;
        }

        /* Insights section */
        .insights-container {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 25px;
            margin-top: 20px;
        }

        .insights-header {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .insights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .insight-card {
            background-color: white;
            border-radius: 6px;
            padding: 15px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            border: 1px solid #e5e7eb;
            margin-bottom: 15px;
        }

        .insight-icon {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .insight-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
            font-size: 13px;
        }

        .insight-description {
            font-size: 11px;
            color: #6b7280;
            line-height: 1.4;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 11px;
        }

        .footer p {
            margin-bottom: 5px;
        }

        .report-id {
            font-family: monospace;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        /* Color classes */
        .text-blue {
            color: #3b82f6;
        }

        .text-green {
            color: #10b981;
        }

        .text-yellow {
            color: #f59e0b;
        }

        .text-red {
            color: #ef4444;
        }

        .text-purple {
            color: #8b5cf6;
        }

        .text-gray {
            color: #6b7280;
        }

        .bg-blue {
            background-color: #dbeafe;
        }

        .bg-green {
            background-color: #d1fae5;
        }

        .bg-yellow {
            background-color: #fef3c7;
        }

        .bg-red {
            background-color: #fee2e2;
        }

        .bg-purple {
            background-color: #ede9fe;
        }

        .bg-gray {
            background-color: #f3f4f6;
        }

        /* Utility classes */
        .mb-1 {
            margin-bottom: 5px;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .mb-4 {
            margin-bottom: 20px;
        }

        .mt-1 {
            margin-top: 5px;
        }

        .mt-2 {
            margin-top: 10px;
        }

        .mt-3 {
            margin-top: 15px;
        }

        .mt-4 {
            margin-top: 20px;
        }

        .font-bold {
            font-weight: bold;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-sm {
            font-size: 11px;
        }

        .text-base {
            font-size: 12px;
        }

        .text-lg {
            font-size: 16px;
        }

        .text-xl {
            font-size: 20px;
        }

        .text-2xl {
            font-size: 24px;
        }

        .text-3xl {
            font-size: 28px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .flex {
            display: flex;
        }

        .justify-between {
            justify-content: space-between;
        }

        .items-center {
            align-items: center;
        }

        .rounded {
            border-radius: 4px;
        }

        .rounded-lg {
            border-radius: 8px;
        }

        .border {
            border: 1px solid #e5e7eb;
        }

        .border-t {
            border-top: 1px solid #e5e7eb;
        }

        .border-b {
            border-bottom: 1px solid #e5e7eb;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div>
                    <div class="logo-container">
                        @if ($logo)
                            <img src="{{ $logo }}" alt="Logo" class="logo">
                        @else
                            <div class="text-2xl font-bold text-blue">Your Application</div>
                        @endif
                    </div>
                    <h1 class="report-title">Dashboard Analytics Report</h1>
                    <p class="report-subtitle">Comprehensive overview of platform performance and metrics</p>
                </div>

                <div class="report-meta">
                    <div class="meta-label">Generated On</div>
                    <div class="meta-value">{{ now()->format('F j, Y') }}</div>
                    <div class="meta-label mt-2">Time</div>
                    <div class="meta-value">{{ now()->format('g:i A') }}</div>
                </div>
            </div>

            <div class="summary-cards">
                <div class="summary-card summary-card-blue">
                    <div class="summary-label text-blue">Report Period</div>
                    <div class="summary-value">All Time</div>
                </div>
                <div class="summary-card summary-card-green">
                    <div class="summary-label text-green">Data Source</div>
                    <div class="summary-value">Live Database</div>
                </div>
                <div class="summary-card summary-card-purple">
                    <div class="summary-label text-purple">Report Type</div>
                    <div class="summary-value">Executive Summary</div>
                </div>
            </div>
        </div>

        <!-- Orders Overview -->
        <div class="section keep-together">
            <h2 class="section-header">
                Orders Overview
            </h2>

            <div class="stats-grid">
                <!-- Total Orders -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label">Total Orders</div>
                            <div class="stat-value">{{ number_format($data['totalOrders']) }}</div>
                        </div>
                        <div class="stat-icon bg-blue">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3b82f6"
                                stroke-width="2">
                                <path
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-details">All time orders received</div>
                </div>

                <!-- Delivered Orders -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label">Delivered</div>
                            <div class="stat-value text-green">{{ number_format($data['deliveredOrders']) }}</div>
                        </div>
                        <div class="stat-icon bg-green">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10b981"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-details">
                        <span
                            class="font-semibold">{{ round(($data['deliveredOrders'] / max($data['totalOrders'], 1)) * 100, 1) }}%</span>
                        completion rate
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label">Pending</div>
                            <div class="stat-value text-yellow">{{ number_format($data['pendingOrders']) }}</div>
                        </div>
                        <div class="stat-icon bg-yellow">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-details">
                        <span
                            class="font-semibold">{{ round(($data['pendingOrders'] / max($data['totalOrders'], 1)) * 100, 1) }}%</span>
                        of total orders
                    </div>
                </div>

                <!-- Processing Orders -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label">Processing</div>
                            <div class="stat-value text-blue">{{ number_format($data['processingOrders']) }}</div>
                        </div>
                        <div class="stat-icon bg-blue">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3b82f6"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-details">In progress orders</div>
                </div>

                <!-- Today's Orders -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label">Today's Orders</div>
                            <div class="stat-value text-purple">{{ number_format($data['todayOrders']) }}</div>
                        </div>
                        <div class="stat-icon bg-purple">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-details">Orders placed today</div>
                </div>
            </div>
        </div>

        <!-- Revenue Analysis -->
        <div class="section keep-together">
            <h2 class="section-header">
                Revenue Analysis
            </h2>

            <div class="revenue-section">
                <div class="revenue-card revenue-card-primary">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <div class="stat-label">Total Revenue</div>
                            <div class="stat-value text-2xl">Kshs. {{ number_format($data['totalRevenue'], 2) }}</div>
                        </div>
                        <div class="stat-icon bg-green">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-details">
                        Generated from {{ $data['deliveredOrders'] }} delivered orders
                    </div>
                    <div class="mt-2 font-semibold text-green">
                        Average: Kshs. {{ number_format($data['totalRevenue'] / max($data['deliveredOrders'], 1), 2) }}
                        per order
                    </div>
                </div>

                <div class="revenue-card revenue-card-secondary">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <div class="stat-label">Today's Revenue</div>
                            <div class="stat-value text-2xl">Kshs. {{ number_format(App\Models\Payment::whereDate('created_at', today())->sum('amount') ?? 0, 2) }}</div>
                        </div>
                        <div class="stat-icon bg-blue">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-details">
                        Revenue generated from today's orders
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Status -->
        <div class="section keep-together">
            <h2 class="section-header">
                Inventory Status
            </h2>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label">Total Products</div>
                            <div class="stat-value">{{ number_format($data['totalProducts']) }}</div>
                        </div>
                        <div class="stat-icon bg-gray">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6b7280"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-details">Products in catalog</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label text-yellow">Low Stock</div>
                            <div class="stat-value text-yellow">{{ number_format($data['lowStockProducts']) }}</div>
                        </div>
                        <div class="stat-icon bg-yellow">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-details">
                        <span
                            class="font-semibold">{{ round(($data['lowStockProducts'] / max($data['totalProducts'], 1)) * 100, 1) }}%</span>
                        of products
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label text-red">Out of Stock</div>
                            <div class="stat-value text-red">{{ number_format($data['outOfStockProducts']) }}</div>
                        </div>
                        <div class="stat-icon bg-red">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-details">Require urgent attention</div>
                </div>
            </div>
        </div>

        <!-- Customer Insights -->
        <div class="section keep-together">
            <h2 class="section-header">
                Customer Insights
            </h2>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label">Total Customers</div>
                            <div class="stat-value">{{ number_format($data['totalCustomers']) }}</div>
                        </div>
                        <div class="stat-icon bg-purple">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-details">Registered customer accounts</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-label text-green">New Customers (30 Days)</div>
                            <div class="stat-value text-green">{{ number_format($data['newCustomers']) }}</div>
                        </div>
                        <div class="stat-icon bg-green">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10b981"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-details">
                        Customer growth in last month
                        <div class="mt-1 font-semibold">
                            {{ round(($data['newCustomers'] / max($data['totalCustomers'], 1)) * 100, 1) }}% increase
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Performance Insights -->
        <div class="insights-container keep-together">
            <h3 class="insights-header"> Key Performance Insights</h3>

            <div class="insights-grid">
                <div class="insight-card">
                    <div class="insight-icon bg-blue">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div>
                        <div class="insight-title">Order Completion Rate</div>
                        <div class="insight-description">
                            {{ round(($data['deliveredOrders'] / max($data['totalOrders'], 1)) * 100, 1) }}% of orders
                            successfully delivered
                        </div>
                    </div>
                </div>

                <div class="insight-card">
                    <div class="insight-icon bg-green">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <div class="insight-title">Average Order Value</div>
                        <div class="insight-description">
                            Kshs. {{ number_format($data['totalRevenue'] / max($data['deliveredOrders'], 1), 2) }} per
                            delivered order
                        </div>
                    </div>
                </div>

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <div class="insight-card">
                    <div class="insight-icon bg-yellow">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>

                    <div>
                        <div class="insight-title">Inventory Attention Needed</div>
                        <div class="insight-description">
                            {{ $data['lowStockProducts'] + $data['outOfStockProducts'] }} products require inventory
                            review
                        </div>
                    </div>
                </div>

                <div class="insight-card">
                    <div class="insight-icon bg-purple">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <div class="insight-title">Customer Growth</div>
                        <div class="insight-description">
                            {{ round(($data['newCustomers'] / max($data['totalCustomers'], 1)) * 100, 1) }}% new
                            customers in last 30 days
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Table (Optional) -->
        <div class="section keep-together mt-4">
            <h3 class="section-header">📋 Quick Statistics Summary</h3>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Value</th>
                            <th>Percentage</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Order Completion Rate</td>
                            <td>{{ $data['deliveredOrders'] }} / {{ $data['totalOrders'] }}</td>
                            <td>{{ round(($data['deliveredOrders'] / max($data['totalOrders'], 1)) * 100, 1) }}%</td>
                            <td><span class="text-green font-semibold">Good</span></td>
                        </tr>
                        <tr>
                            <td>Pending Orders Ratio</td>
                            <td>{{ $data['pendingOrders'] }} orders</td>
                            <td>{{ round(($data['pendingOrders'] / max($data['totalOrders'], 1)) * 100, 1) }}%</td>
                            <td><span class="text-yellow font-semibold">Monitor</span></td>
                        </tr>
                        <tr>
                            <td>Inventory Issues</td>
                            <td>{{ $data['lowStockProducts'] + $data['outOfStockProducts'] }} products</td>
                            <td>{{ round((($data['lowStockProducts'] + $data['outOfStockProducts']) / max($data['totalProducts'], 1)) * 100, 1) }}%
                            </td>
                            <td><span class="text-red font-semibold">Attention</span></td>
                        </tr>
                        <tr>
                            <td>Customer Growth Rate</td>
                            <td>{{ $data['newCustomers'] }} new</td>
                            <td>{{ round(($data['newCustomers'] / max($data['totalCustomers'], 1)) * 100, 1) }}%</td>
                            <td><span class="text-green font-semibold">Growing</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name', 'Your Application') }}. All rights reserved.</p>
            <p>This report was automatically generated from the system dashboard.</p>
            <div class="report-id mt-2">
                Report ID: DASH-{{ strtoupper(\Illuminate\Support\Str::random(8)) }}-{{ date('Ymd') }}
            </div>
        </div>
    </div>
</body>

</html>
