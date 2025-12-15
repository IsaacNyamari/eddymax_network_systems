@extends('dashboard.layouts.dashboard')
@section('title', 'Create Product')
@section('content')
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="float-right m-3 flex">
                    <a class="px-4 py-2 bg-green-500 rounded-lg mb-1" href="{{ route('admin.products.index') }}"><i
                            class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">

                    <livewire:create-product />
                </div>
            </div>
        </div>
    </div>
@endsection
