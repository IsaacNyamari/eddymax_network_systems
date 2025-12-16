@extends('dashboard.layouts.dashboard')
@section('title', 'Create Category')
@section('content')
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <livewire:category-create />
            </div>
        </div>
    </div>
@endsection
