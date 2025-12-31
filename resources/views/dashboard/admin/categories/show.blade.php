@extends('dashboard.layouts.dashboard')
@section('title', $category->name . ' - Category Details')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h1>
                <p class="text-gray-600 mt-1">Category management and details</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 rounded-full text-sm font-medium 
                    {{ $category->children->count() > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $category->children->count() }} Sub-categories
                </span>
                <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    {{ $category->products->count() }} Products
                </span>
            </div>
        </div>

        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Products Card -->
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600">Total Products</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $category->getAllProducts()->count() }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Including sub-categories</p>
                    </div>
                    <div class="bg-blue-500 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Sub-categories Card -->
            <div class="bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-600">Sub-categories</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $category->children->count() }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Child categories</p>
                    </div>
                    <div class="bg-purple-500 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Category Status</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $category->is_active ? 'Active' : 'Inactive' }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Visibility status</p>
                    </div>
                    <div class="bg-green-500 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Category Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Category Details</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category Info -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Category Name</label>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-900">{{ $category->name }}</h3>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Category Slug</label>
                                    <div class="flex items-center">
                                        <code class="px-3 py-2 bg-gray-100 text-gray-800 rounded-lg text-sm font-mono">
                                            {{ $category->slug }}
                                        </code>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Created</label>
                                    <div class="flex items-center text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $category->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Category Image -->
                            @if($category->image)
                            <div class="space-y-4">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Category Image</label>
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         alt="{{ $category->name }}" 
                                         class="w-full h-48 object-cover rounded-lg shadow-sm border border-gray-200">
                                    <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">Preview</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sub-categories Products Breakdown -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-6 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Products Distribution</h2>
                        <p class="text-sm text-gray-500 mt-1">Products across sub-categories</p>
                    </div>
                    
                    <div class="p-6">
                        @if($category->children->count() > 0)
                            <div class="space-y-4">
                                @foreach ($category->children as $childCategory)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ $childCategory->name }}</h4>
                                                <p class="text-sm text-gray-500">Slug: {{ $childCategory->slug }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                                {{ $childCategory->products->count() }} products
                                            </span>
                                            <a href="{{ route('admin.categories.show', $childCategory->slug) }}" 
                                               class="text-blue-600 hover:text-blue-800 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 mb-4">
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <p class="text-gray-500">No sub-categories found</p>
                                <p class="text-sm text-gray-400 mt-1">This is a top-level category</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Edit Category -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-orange-100">
                        <h2 class="text-lg font-semibold text-gray-900">Edit Category</h2>
                        <p class="text-sm text-gray-600 mt-1">Update category details</p>
                    </div>
                    
                    <div class="p-6">
                        <livewire:category-edit 
                            :name="$category->name" 
                            :category="$category" 
                            :slug="$category->slug" 
                            :currentImage="$category->image" 
                        />
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-6 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                    </div>
                    
                    <div class="p-4">
                        <div class="space-y-3">
                            <a href="{{ route('admin.products.index', ['category' => $category->slug]) }}" 
                               class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900">Add New Product</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <a href="{{ route('admin.categories.create', ['parent' => $category->slug]) }}" 
                               class="flex items-center justify-between p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors group">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900">Add Sub-category</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <a href="{{ route('admin.products.index') }}?category={{ $category->slug }}" 
                               class="flex items-center justify-between p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900">View All Products</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection