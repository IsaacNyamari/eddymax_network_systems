@extends('dashboard.layouts.dashboard')

@section('title', 'User Profile')

@section('content')

    <div class="grid grid-row-1 lg:grid-row-2 gap-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }} Profile</h2>
            </div>

            @if (session('success'))
                <div class="mx-6 mt-6 rounded-lg bg-green-100 border border-green-300 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Profile Info -->
            <div class="p-6">
                <div class="flex items-center mb-6">
                    @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}"
                            class="w-20 h-20 rounded-full object-cover border border-gray-300">
                    @else
                        <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-user text-gray-400 text-2xl"></i>
                        </div>
                    @endif
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Details List -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <i class="fas fa-user-tag text-gray-400 w-6"></i>
                        <span class="ml-3 text-gray-700">{{ ucfirst($user->roles[0]->name) }}</span>
                    </div>

                    @if ($user->addresses)
                        <div class="flex items-center">
                            <i class="fas fa-phone text-gray-400 w-6"></i>
                            <span class="ml-3 text-gray-700">{{ $user->addresses->first()->phone }}</span>
                        </div>
                    @endif

                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt text-gray-400 w-6"></i>
                        <span class="ml-3 text-gray-700">Joined {{ $user->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <!-- Edit Button -->
                <div class="mt-8">
                    <a href="{{ route('admin.users.edit', $user) }}"
                        class="w-full bg-red-600 text-white text-center px-4 py-2.5 rounded-lg font-medium hover:bg-red-700 transition">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
