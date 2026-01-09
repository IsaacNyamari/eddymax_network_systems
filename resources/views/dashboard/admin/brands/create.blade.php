@extends('dashboard.layouts.dashboard')
@section('title', 'Create New Brand')
@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create New Brand</h1>
                <p class="text-gray-600 mt-1">Add a new product brand to organize your products</p>
            </div>
            <a href="{{ route('admin.brands.index') }}"
                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-lg hover:from-gray-700 hover:to-gray-800 shadow-sm hover:shadow-md transition-all duration-200 group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Brands
            </a>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <h2 class="text-lg font-semibold text-gray-900">Brand Details</h2>
                <p class="text-sm text-gray-500 mt-1">Fill in the details below to create a new brand</p>
                @if (session('success'))
                    <div class="bg-green-800 text-white rounded w-full px-4 py-2">{{ session('success') }}</div>
                @endif
            </div>

            <!-- Form Content -->
            <form action="{{ route('admin.brands.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Brand Name -->
                <div class="space-y-3">
                    <x-input-label for="name" value="Brand Name" class="font-medium text-gray-700" />

                    <div class="relative">
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 placeholder-gray-400"
                            placeholder="e.g., Apple, Samsung, Dell, HP" oninput="updateSlugPreview(this.value)">

                        <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                            <span id="charCount">0</span> characters
                        </div>
                    </div>

                    @error('name')
                        <div class="flex items-center text-sm text-red-600 mt-2">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="text-xs text-gray-500">Example brands:</span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Apple</span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Samsung</span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Dell</span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">HP</span>
                    </div>
                </div>

                <!-- Slug Preview -->
                <div class="space-y-3">
                    <x-input-label value="Slug Preview" class="font-medium text-gray-700" />

                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Generated Slug</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    This will be used in URLs. Automatically generated from brand name.
                                </p>
                            </div>
                            <code id="slugPreview" class="px-3 py-1.5 bg-gray-800 text-gray-100 rounded text-sm font-mono">
                                {{ old('slug', 'brand-slug') }}
                            </code>
                        </div>
                    </div>

                    <!-- Manual Slug Override (Hidden by default, can be shown if needed) -->
                    <div id="slugOverrideContainer" class="hidden">
                        <x-input-label for="slug" value="Custom Slug (Optional)" class="font-medium text-gray-700" />
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 placeholder-gray-400"
                            placeholder="custom-slug">
                        <p class="text-xs text-gray-500 mt-1">Leave empty to use auto-generated slug</p>
                    </div>

                    <button type="button" onclick="toggleSlugOverride()"
                        class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                        Use custom slug
                    </button>

                    @error('slug')
                        <div class="flex items-center text-sm text-red-600 mt-2">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <a  href="{{ route('admin.brands.index') }}"
                            class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            Cancel
                        </a>

                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg shadow-sm hover:from-red-700 hover:to-red-800 hover:shadow-md transition-all duration-200 group">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create Brand
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Update character count
        document.getElementById('name').addEventListener('input', function() {
            document.getElementById('charCount').textContent = this.value.length;
            updateSlugPreview(this.value);
        });

        // Update slug preview
        function updateSlugPreview(name) {
            if (!name) {
                document.getElementById('slugPreview').textContent = 'brand-slug';
                return;
            }

            // Generate slug from name
            let slug = name.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/--+/g, '-') // Replace multiple hyphens with single
                .trim();

            document.getElementById('slugPreview').textContent = slug;

            // Update hidden slug field if it exists and user hasn't customized it
            const slugInput = document.getElementById('slug');
            if (slugInput && !slugInput.dataset.customized) {
                slugInput.value = slug;
            }
        }

        // Toggle slug override
        function toggleSlugOverride() {
            const container = document.getElementById('slugOverrideContainer');
            const slugInput = document.getElementById('slug');

            container.classList.toggle('hidden');

            if (!container.classList.contains('hidden')) {
                slugInput.focus();
                slugInput.dataset.customized = 'true';
            } else {
                delete slugInput.dataset.customized;
                updateSlugPreview(document.getElementById('name').value);
            }
        }

        // Mark slug as customized when user types
        document.addEventListener('DOMContentLoaded', function() {
            const slugInput = document.getElementById('slug');
            if (slugInput) {
                slugInput.addEventListener('input', function() {
                    this.dataset.customized = 'true';
                });
            }

            // Initialize character count
            const nameInput = document.getElementById('name');
            if (nameInput) {
                document.getElementById('charCount').textContent = nameInput.value.length;
                updateSlugPreview(nameInput.value);
            }
        });
    </script>

    <style>
        /* Custom scrollbar for select */
        select::-webkit-scrollbar {
            width: 8px;
        }

        select::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        select::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        select::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Smooth transitions */
        input,
        button {
            transition: all 0.2s ease-in-out;
        }
    </style>
@endsection
