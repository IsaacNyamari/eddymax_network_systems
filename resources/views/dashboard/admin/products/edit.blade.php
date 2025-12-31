@extends('dashboard.layouts.dashboard')

@section('title', 'Edit Product: ' . Str::limit($product->name, 15, '...'))
@section('content')

    <livewire:edit-product :product="$product" />

@endsection
