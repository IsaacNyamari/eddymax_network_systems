@extends('dashboard.layouts.dashboard')
@section('title', 'Settings')

@section('content')
    <div class="space-y-6">
        <div class="rounded-lg p-3 sm:p-4">
            @if (session('success'))
                <div class="bg-green-500 mb-3 text-white px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500 mb-3 text-white px-4 py-2 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="bg-yellow-500 mb-3 text-white px-4 py-2 rounded">
                    {{ session('warning') }}
                </div>
            @endif

            <div id="settingsContainer" class="grid grid-cols-1 mb-2 sm:grid-cols-1 gap-3 sm:gap-4 md:gap-6">
                <!-- Settings Card -->
                <div
                    class="text-center shadow-sm bg-white py-3 sm:py-4 md:py-5 rounded-lg transition-all duration-200 hover:shadow-md">
                    <h3 class="pb-2 text-red-600 font-medium text-sm sm:text-base md:text-lg lg:text-xl">
                        Settings
                    </h3>
                    <p class="text-gray-500 text-xs sm:text-sm hidden sm:block">
                        Manage your preferences
                    </p>
                    <hr>
                    <livewire:settings />
                </div>

                <!-- Backup Card -->

            </div>
            <div
                class="text-center shadow-sm bg-white py-3 sm:py-4 md:py-5 rounded-lg transition-all duration-200 hover:shadow-md">
                <h3 class="pb-2 text-blue-500 font-medium text-sm sm:text-base md:text-lg lg:text-xl">
                    Back Up
                </h3>
                <p class="text-gray-500 text-xs sm:text-sm hidden sm:block">
                    Create / download database backups
                </p>
                <hr>

                @if ($backups->count() < 1)
                    <form action="{{ route('admin.settings.backup.database') }}" method="POST" class="p-4">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:-translate-y-1 transition-all duration-200">
                            Create Backup
                        </button>
                        <p class="text-xs text-gray-500 mt-2">
                            Creates a compressed SQL backup
                        </p>
                    </form>
                @else
                    <div class="p-4">
                        <!-- Create New Backup Form -->
                        <form action="{{ route('admin.settings.backup.database') }}" method="POST" class="mb-4">
                            @csrf
                            <button type="submit"
                                class="w-full px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition-all duration-200">
                                Create New Backup
                            </button>
                        </form>

                        <!-- Latest Backup Info -->
                        @php
                            $latestBackup = $backups->first();
                        @endphp

                        <div class="bg-gray-50 rounded-lg p-3 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Latest Backup:</span>
                                <span class="text-xs text-gray-500">{{ $latestBackup->formatted_date }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ $latestBackup->file }}</span>
                                <span
                                    class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $latestBackup->size }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-2">
                            <form action="{{ route('admin.settings.backup.download', $latestBackup->file) }}" method="POST"
                                class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-all duration-200">
                                    Download Latest
                                </button>
                            </form>
                            <form action="{{ route('admin.settings.backup.delete', $latestBackup->file) }}" method="POST"
                                class="flex-1" onsubmit="return confirm('Are you sure you want to delete this backup?')">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200">
                                    Delete Latest
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Additional Backups (if more than 1) -->
                    @if ($backups->count() > 1)
                        <div class="border-t border-gray-200 pt-4 px-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Other Backups
                                ({{ $backups->count() - 1 }})</h4>
                            <div class="space-y-2 max-h-40 overflow-y-auto">
                                @foreach ($backups->slice(1) as $backup)
                                    <div class="flex items-center justify-between bg-gray-50 p-2 rounded text-xs">
                                        <div class="truncate">
                                            <div class="font-medium truncate">{{ $backup->file }}</div>
                                            <div class="text-gray-500">{{ $backup->formatted_date }}</div>
                                        </div>
                                        <div class="flex gap-1">
                                            <form action="{{ route('admin.settings.backup.download', $backup->file) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="px-2 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
                                                    ↓
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.settings.backup.delete', $backup->file) }}"
                                                method="POST" onsubmit="return confirm('Delete this backup?')">
                                                @csrf
                                                <button type="submit"
                                                    class="px-2 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200">
                                                    ×
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <!-- Backup Statistics -->
            @if ($backups->count() > 0)
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Total Backups</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $backups->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Total Size</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $latestBackup->size }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Last Backup</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $backups->first()->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

{{-- @push('scripts')
    <script>
        // Auto-refresh the page when backup is created (optional)
        @if (session('success') && str_contains(session('success'), 'Backup'))
            setTimeout(function() {
                location.reload();
            }, 2000);
        @endif

        // Confirm before deleting backup
        function confirmDelete(form) {
            if (confirm('Are you sure you want to delete this backup?')) {
                form.submit();
            }
            return false;
        }
    </script>
@endpush --}}
