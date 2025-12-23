@extends('layouts.front-end.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-white px-4">
    <!-- Error Illustration -->
    <div class="mb-8">
        <svg class="w-48 h-48 text-red-500 pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>

    <!-- Error Content -->
    <div class="text-center max-w-2xl">
        <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Page Not Found</h2>
        <p class="text-gray-600 mb-8 text-lg">
            We can't seem to find the page you're looking for. It might have been moved, deleted, or never existed.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('store.home') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Back to Homepage
            </a>
            
            <a href="javascript:history.back()" 
               class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-md hover:bg-gray-200 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Go Back
            </a>
        </div>

        <!-- Additional Help -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <p class="text-gray-500 mb-4">Need help? Try these options:</p>
            <div class="flex flex-wrap justify-center gap-4 text-sm">
                <a href="{{ route('store.shop') ?? '#' }}" class="text-red-600 hover:text-red-800 hover:underline">Browse Products</a>
                <span class="text-gray-300">•</span>
                <a href="{{ route('store.contact') ?? '#' }}" class="text-red-600 hover:text-red-800 hover:underline">Contact Support</a>
                 </div>
        </div>
    </div>
</div>
@endsection