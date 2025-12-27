@extends('dashboard.layouts.dashboard')
@section('title', 'My Return Requests')

@section('content')
    <div class="space-y-6">

        <a href="{{ route('customer.orders.index') }}">
            <h2
                class="text-xl font-semibold bg-red-400 w-fit px-4 py-2 rounded cursor-pointer text-gray-900 hover:text-white">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>Back
            </h2>
        </a>

        @forelse ($orders as $return)
            <livewire:customer-returns-page-refresh :return="$return" />
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center text-gray-500">
                You have no return requests yet.
            </div>
        @endforelse

    </div>
@endsection
