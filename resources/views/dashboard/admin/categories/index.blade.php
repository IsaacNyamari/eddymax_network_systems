@extends('dashboard.layouts.dashboard')
@section('title', 'Categories')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <livewire:categories />
            </div>
        </div>
    </div>
@endsection
