@extends('dashboard.layouts.dashboard')
@section('title', 'Create New Category')
@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create New Category</h1>
                <p class="text-gray-600 mt-1">Add a new product category to organize your products</p>
            </div>
            <a href="{{ route('admin.categories.index') }}" 
                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-lg hover:from-gray-700 hover:to-gray-800 shadow-sm hover:shadow-md transition-all duration-200 group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Categories
            </a>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <h2 class="text-lg font-semibold text-gray-900">Category Details</h2>
                <p class="text-sm text-gray-500 mt-1">Fill in the details below to create a new category</p>
            </div>

            <!-- Form Content -->
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-6">
                @csrf

                <!-- Category Name -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <x-input-label for="name" value="Category Names" class="font-medium text-gray-700" />
                        <span class="text-xs text-gray-500">Separate multiple names with commas</span>
                    </div>

                    <div class="relative">
                        <textarea id="name" name="name" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 placeholder-gray-400 resize-none"
                            placeholder="e.g., monitors, desktops, laptops, pos" oninput="autoGrow(this)">{{ old('name') }}</textarea>

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
                        <span class="text-xs text-gray-500">Example formats:</span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">monitors, desktops</span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">laptops, pos</span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">printers, scanners</span>
                    </div>
                </div>

                <!-- Parent Category -->
                <div class="space-y-3">
                    <x-input-label for="parent_category" value="Parent Category" class="font-medium text-gray-700" />

                    <div class="relative">
                        <select id="parent_category" name="parent_category"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 appearance-none bg-white hover:bg-gray-50 cursor-pointer">
                            <option value="" class="text-gray-500">Select a parent category (Optional)</option>
                            @foreach ($categories as $category)
                                <option value="{{ (int) $category->id }}"
                                    class="py-2 {{ old('parent_category') == $category->id ? 'bg-red-50 text-red-700' : 'text-gray-900' }}"
                                    {{ old('parent_category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Custom dropdown arrow -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    @error('parent_category')
                        <div class="flex items-center text-sm text-red-600 mt-2">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="mt-2 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-blue-700">Parent Category Info</p>
                                <p class="text-xs text-blue-600 mt-1">
                                    Select a parent category to make this a sub-category. Leave empty to create a top-level
                                    category.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category Image -->
                <div class="space-y-3">
                    <x-input-label for="image" value="Category Image" class="font-medium text-gray-700" />

                    <div class="space-y-4">
                        <!-- File Upload Area -->
                        <div class="relative">
                            <input id="image" type="file" name="image" class="hidden"
                                onchange="previewImage(event)" />

                            <label for="image"
                                class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-red-400 hover:bg-red-50 transition-colors duration-200">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                                </div>
                            </label>
                        </div>

                        <!-- Image Preview -->
                        <div id="imagePreview" class="hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">Image Preview</p>
                            <div class="relative w-32 h-32 rounded-lg overflow-hidden border border-gray-200">
                                <img id="preview" class="w-full h-full object-cover" />
                                <button type="button" onclick="removeImage()"
                                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    @error('image')
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
                        <button type="button" onclick="window.history.back()"
                            class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            Cancel
                        </button>

                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg shadow-sm hover:from-red-700 hover:to-red-800 hover:shadow-md transition-all duration-200 group">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-grow textarea
        function autoGrow(element) {
            element.style.height = "auto";
            element.style.height = (element.scrollHeight) + "px";

            // Update character count
            document.getElementById('charCount').textContent = element.value.length;
        }

        // Image preview functionality
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('name');
            if (textarea) {
                autoGrow(textarea);
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
        textarea,
        select,
        input,
        button {
            transition: all 0.2s ease-in-out;
        }
    </style>
@endsection
