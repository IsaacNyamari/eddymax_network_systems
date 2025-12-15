@extends('dashboard.layouts.dashboard')

@section('title', 'Page Not Found')

@section('content')
<div class="flex flex-col items-center justify-center h-[70vh] text-center space-y-6">
    <h1 class="text-6xl font-bold text-red-600">404</h1>
    <h2 class="text-2xl font-semibold text-gray-800">Oops! Page Not Found</h2>
    <p class="text-gray-500 max-w-md">
        The page you are looking for does not exist within the dashboard. It might have been removed, renamed, or you typed the wrong URL.
    </p>
    <a href="{{ route('dashboard') }}" 
       class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-500 transition">
        Go Back to Dashboard
    </a>
</div>
@endsection
