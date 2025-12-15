@extends('dashboard.layouts.dashboard')
@section('title', 'Edit Category')
@section('content')
    <livewire:category-edit :name="$category->name" :slug="$category->slug" :currentImage="$category->image" />
@endsection
