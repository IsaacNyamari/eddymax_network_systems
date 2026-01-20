<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Payment Transactions</h1>
                    <p class="text-gray-600 mt-2">Track and manage all payment transactions in real-time</p>
                </div>

                <!-- Search and Export Container -->
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">

                    <div class="relative flex-1" x-data="{ open: false }" @click.outside="open = false">
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="search" @focus="open = true"
                                placeholder="Search payments..."
                                class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm bg-white shadow-sm hover:border-gray-400">

                            <!-- Search Icon -->
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>

                            <!-- Clear Search Button -->
                            @if ($search)
                                <button wire:click="$set('search', '')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center group"
                                    aria-label="Clear search">
                                    <svg class="h-4 w-4 text-gray-400 group-hover:text-gray-600 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>

                        <!-- Search Suggestions Dropdown -->
                        <div x-show="open && $wire.search.length > 2"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute z-50 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">

                            <!-- Loading State -->
                            <div wire:loading class="p-3">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <span class="text-sm text-gray-600">Searching...</span>
                                </div>
                            </div>

                            <!-- Results Count -->
                            @if ($search && !$payments->isEmpty())
                                <div class="px-4 py-2.5 border-b border-gray-100 bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700">
                                            {{ $payments->total() }} {{ Str::plural('result', $payments->total()) }}
                                            found
                                        </span>
                                        <button @click="open = false"
                                            class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                            Close
                                        </button>
                                    </div>
                                </div>

                                <!-- Quick Results (Optional - would need implementation) -->
                                <div class="max-h-48 overflow-y-auto">
                                    @foreach ($payments->take(5) as $payment)
                                        <a href="#"
                                            class="block px-4 py-2.5 hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        #{{ $payment->order_number }}</p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $payment->order->user->name ?? 'N/A' }}</p>
                                                </div>
                                                <span class="text-sm font-semibold text-gray-900">Ksh
                                                    {{ number_format($payment->amount, 2) }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                    @if ($payments->total() > 5)
                                        <div class="px-4 py-2.5 text-center bg-gray-50">
                                            <span class="text-xs text-gray-500">And {{ $payments->total() - 5 }}
                                                more...</span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- No Results -->
                            @if ($search && $payments->isEmpty())
                                <div class="p-4 text-center">
                                    <svg class="h-8 w-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    <p class="text-sm text-gray-500">No payments found for "{{ $search }}"</p>
                                    <p class="text-xs text-gray-400 mt-1">Try a different search term</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Export Button -->
                    <button wire:click="export" wire:loading.attr="disabled" wire:target="export"
                        class="inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 disabled:from-blue-400 disabled:to-blue-500 transition-all duration-200 font-medium shadow-sm hover:shadow-md disabled:shadow-none whitespace-nowrap">
                        <svg wire:loading.remove wire:target="export" class="w-5 h-5 mr-2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <svg wire:loading wire:target="export" class="animate-spin w-5 h-5 mr-2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span wire:loading.remove wire:target="export">Export CSV</span>
                        <span wire:loading wire:target="export">Exporting...</span>
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2">
                                Ksh {{ number_format(App\Models\Payment::sum('amount'), 2) }}
                            </p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Transactions</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2">
                                {{ App\Models\Payment::count() }}
                            </p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Average Transaction</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2">
                                Ksh {{ number_format(App\Models\Payment::avg('amount'), 2) }}
                            </p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div
                class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Recent Transactions</h2>
                    <p class="text-sm text-gray-600 mt-1">List of all payment transactions</p>
                </div>
                <div class="flex items-center gap-3">
                    <select wire:model.live="status"
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm">
                        <option value="">All Status</option>
                        <option value="paid">Paid</option>
                        <option value="not_paid">Not Paid</option>
                    </select>
                    <select wire:model.live="date"
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 text-sm">
                        <option value="30">Last 30 days</option>
                        <option value="7">Last 7 days</option>
                        <option value="1">Last 24 hours</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <span>#ID</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                </div>
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Paid By
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Order Number
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Amount
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Date Paid
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($payments as $payment)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span
                                                    class="text-blue-600 font-semibold">{{ substr($payment->order->user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $payment->order->user->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $payment->order->user->email ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">{{ $payment->order->order_number }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Completed
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">
                                        Ksh {{ number_format($payment->amount, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $payment->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button
                                        class="text-blue-600 hover:text-blue-900 transition-colors duration-200 mr-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                            </path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ $payments->firstItem() ?? 0 }}</span> to
                    <span class="font-medium">{{ $payments->lastItem() ?? 0 }}</span> of
                    <span class="font-medium">{{ $payments->total() }}</span> results
                </div>
                <div class="flex items-center space-x-2">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Data is updated in real-time. Last updated: {{ now()->format('M d, Y h:i A') }}</p>
        </div>
    </div>
</div>
