@extends('dashboard.layouts.dashboard')

@section('title', 'My Wishlist')

@section('content')
    <div class="max-w-6xl mx-auto py-8">
        @if ($wishlists->count())
            <livewire:wish-list-blade :wishlists="$wishlists" />
        @else
            <div class="text-center text-gray-600 py-20">
                ❤️ You have no items in your wishlist yet.
            </div>
        @endif

    </div>
@endsection
