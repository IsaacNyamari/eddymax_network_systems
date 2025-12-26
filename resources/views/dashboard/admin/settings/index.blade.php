@extends('dashboard.layouts.dashboard')
@section('title', 'Settings')

@section('content')
    <div class="space-y-6">
        <div class="rounded-lg p-3 sm:p-4">
            <div id="settingsContainer" class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 md:gap-6">
                <!-- Settings Card -->
                <div
                    class="text-center shadow-sm bg-white py-3 sm:py-4 md:py-5 rounded-lg 
                    transition-all duration-200 hover:shadow-md hover:-translate-y-1">
                    <h3
                        class="pb-2 text-red-600 font-medium
                       text-sm sm:text-base md:text-lg lg:text-xl">
                        Settings
                    </h3>
                    <p class="text-gray-500 text-xs sm:text-sm hidden sm:block">
                        Manage your preferences
                    </p>
                    <hr>
                </div>

                <!-- Backup Card -->
                <div
                    class="text-center shadow-sm bg-white py-3 sm:py-4 md:py-5 rounded-lg 
                    transition-all duration-200 hover:shadow-md hover:-translate-y-1">
                    <h3
                        class="pb-2 text-blue-500 font-medium
                       text-sm sm:text-base md:text-lg lg:text-xl">
                        Back Up
                    </h3>
                    <p class="text-gray-500 text-xs sm:text-sm hidden sm:block">
                        Create / download database backups
                    </p>
                    <hr>
                    <form action="{{ route('admin.settings.backup.database') }}" method="POST" class="p-4">
                        <button>Create Backup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
