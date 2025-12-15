@extends('dashboard.layouts.dashboard')

@section('title', 'Edit Product: ' . $product->name)
@section('content')

    <livewire:edit-product :product="$product" />

@endsection
