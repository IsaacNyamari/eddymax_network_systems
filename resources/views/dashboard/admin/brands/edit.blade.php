@extends('dashboard.layouts.dashboard')
@section('title', 'Edit Brand: ' . $brand->name)
@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Brand</h1>
                <p class="text-gray-600 mt-1">Update brand details and information</p>
            </div>
            <a href="{{ route('admin.brands.index') }}" 
                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-lg hover:from-gray-700 hover:to-gray-800 shadow-sm hover:shadow-md transition-all duration-200 group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Brands
            </a>
        </div>

        {{-- <!-- Brand Info Summary -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Brand Stats -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $brand->name }}</h2>
                        <div class="flex items-center space-x-4 mt-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                {{ $brand->products_count ?? 0 }} products
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Created {{ $brand->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.products.index', ['brand' => $brand->id]) }}" 
                       class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <span class="font-medium text-gray-900">View Products</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    
                    <form action="{{ route('admin.brands.destroy', $brand) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this brand? This will affect all products associated with it.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full flex items-center justify-between p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors group">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-900">Delete Brand</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div> --}}

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <h2 class="text-lg font-semibold text-gray-900">Update Brand Details</h2>
                <p class="text-sm text-gray-500 mt-1">Modify the brand information below</p>
            </div>

            <!-- Form Content -->
            <form action="{{ route('admin.brands.update', $brand) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Brand Name -->
                <div class="space-y-3">
                    <x-input-label for="name" value="Brand Name" class="font-medium text-gray-700" />
                    
                    <div class="relative">
                        <input type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $brand->name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 placeholder-gray-400"
                            placeholder="e.g., Apple, Samsung, Dell, HP"
                            required
                            oninput="updateSlugPreview(this.value)">
                        
                        <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                            <span id="charCount">{{ strlen(old('name', $brand->name)) }}</span> characters
                        </div>
                    </div>
                    
                    @error('name')
                        <div class="flex items-center text-sm text-red-600 mt-2">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="space-y-3">
                    <x-input-label for="slug" value="Brand Slug" class="font-medium text-gray-700" />
                    
                    <div class="relative">
                        <input type="text" 
                            id="slug" 
                            name="slug" 
                            value="{{ old('slug', $brand->slug) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 placeholder-gray-400 font-mono"
                            placeholder="brand-slug"
                            required>
                        
                        <div class="absolute bottom-3 right-3">
                            <button type="button" 
                                    onclick="generateSlugFromName()"
                                    class="text-xs text-blue-600 hover:text-blue-800 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Regenerate
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-gray-600">
                                Used in URLs. Example: 
                                <code class="bg-gray-800 text-gray-100 px-2 py-1 rounded text-xs ml-1">
                                    /brands/{{ old('slug', $brand->slug) }}
                                </code>
                            </p>
                        </div>
                    </div>
                    
                    @error('slug')
                        <div class="flex items-center text-sm text-red-600 mt-2">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                                           
                        <div class="flex items-center space-x-3">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg shadow-sm hover:from-red-700 hover:to-red-800 hover:shadow-md transition-all duration-200 group">
                                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Brand
                            </button>
                            
                            <a href="{{ route('admin.brands.index') }}" 
                               class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                Discard Changes
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Update character count
        document.getElementById('name').addEventListener('input', function() {
            document.getElementById('charCount').textContent = this.value.length;
        });

        // Generate slug from name
        function generateSlugFromName() {
            const name = document.getElementById('name').value;
            if (!name) {
                alert('Please enter a brand name first');
                return;
            }
            
            // Generate slug from name
            let slug = name.toLowerCase()
                .replace(/[^\w\s-]/g, '')  // Remove special characters
                .replace(/\s+/g, '-')      // Replace spaces with hyphens
                .replace(/--+/g, '-')      // Replace multiple hyphens with single
                .trim();
            
            document.getElementById('slug').value = slug;
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            if (nameInput) {
                document.getElementById('charCount').textContent = nameInput.value.length;
            }
        });
    </script>

    <style>
        /* Smooth transitions */
        input, button {
            transition: all 0.2s ease-in-out;
        }
        
        /* Focus styles */
        input:focus, button:focus {
            outline: none;
            ring: 2px;
        }
    </style>
@endsection