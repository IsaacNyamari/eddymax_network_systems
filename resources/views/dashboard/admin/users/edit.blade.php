@extends('dashboard.layouts.dashboard')

@section('title', 'Edit User')
@section('content')

    <div class="max-w-4xl mx-auto bg-white shadow-sm rounded-xl border border-gray-200 p-6">
        

        <livewire:update-user-form :user="$user" />
    </div>

@endsection
