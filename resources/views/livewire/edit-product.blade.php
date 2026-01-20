<div class="grid grid-row-1 lg:grid-row-2 gap-6">
    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div id="editAlert"
        class="fixed top-5 right-5 rounded-r-lg text-white font-semibold hidden border-l-8 border-l-red-500 z-50 p-4 bg-green-500 justify-center ml-auto">
        Product updated successfully!
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <form class="bg-white p-6 rounded-lg shadow-md space-y-4" wire:submit.prevent="saveProduct">
            {{-- GLOBAL ERRORS --}}
            @if ($errors->any())
                <div class="p-3 text-sm text-red-700 bg-red-100 rounded-lg">
                    Please fix the errors below.
                </div>
            @endif
            <div class="mb-3 flex flex-row">
                <h1 class="text-lg">Product Details</h1>
                <a class="px-4 py-2 rounded-lg bg-green-500 text-white ml-auto"
                    href="{{ route('admin.products.show', $product->slug) }}"><i class="fa fa-eye"
                        aria-hidden="true"></i> View Product</a>
            </div>
            {{-- NAME --}}
            <div>
                <x-input-label for="name">Name</x-input-label>
                <x-text-input wire:model="name" id="name" class="w-full" />
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- image --}}
            <div>
                <x-input-label for="image">Product Image</x-input-label>
                <x-text-input type="file" wire:model="image" id="image" class="w-full p-2" />
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @if ($image)
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">Preview:</p>
                        <img src="{{ $image->temporaryUrl() }}" class="mt-2 w-32 h-32 object-cover rounded-lg">
                    </div>
                @endif
            </div>

            {{-- PRICE --}}
            <div>
                <x-input-label for="price">Price</x-input-label>
                <x-text-input type="number" wire:model="price" id="price" class="w-full" />
                @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                <input type="text" id="unit" wire:model="unit"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500">
                @error('unit')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Stock Status --}}
            <div>
                <x-input-label for="stock_status">Stock Status</x-input-label>
                <div class="mt-2 flex items-center gap-4">
                    <div class="inline-flex items-center">
                        <input type="radio" wire:model="stock_status" name="stock_status" id="stock_status_in_stock"
                            value="in_stock" class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500" />
                        <label for="stock_status_in_stock" class="ml-2 text-sm text-gray-700">
                            In Stock
                        </label>
                    </div>

                    <div class="inline-flex items-center">
                        <input type="radio" wire:model="stock_status" name="stock_status"
                            id="stock_status_out_of_stock" value="out_of_stock"
                            class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500" />
                        <label for="stock_status_out_of_stock" class="ml-2 text-sm text-gray-700">
                            Out of Stock
                        </label>
                    </div>

                    <div class="inline-flex items-center">
                        <input type="radio" wire:model="stock_status" name="stock_status" id="stock_status_backorder"
                            value="backorder" class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500" />
                        <label for="stock_status_backorder" class="ml-2 text-sm text-gray-700">
                            Backorder
                        </label>
                    </div>
                </div>
                @error('stock_status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- MODEL --}}
            <div>
                <x-input-label for="model">Model</x-input-label>
                <x-text-input type="text" wire:model="model" id="model" class="w-full" />
                @error('model')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- BRAND  --}}
            <div class="mt-4">
                <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                <select wire:model="brandInputData" name="brandInputData" id="brand"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500">
                    <option value="">Select a Brand</option>
                    @foreach ($brands as $brandItem)
                        <option value="{{ $brandItem->id }}" {{ $brandInputData == $brandItem->id ? 'selected' : '' }}>
                            {{ $brandItem->name }}
                        </option>
                    @endforeach
                </select>
                @error('brandInputData')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- DESCRIPTION with WYSIWYG Editor --}}
            <div>
                <x-input-label for="description">Description</x-input-label>

                <div id="editor-description-containers" data-wysiwyg data-height="200"
                    data-placeholder="Enter product description...">
                    <textarea wire:model="description" id="description" rows="3" class="hidden">{{ old('description', $description ?? '') }}</textarea>
                </div>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- CATEGORY --}}
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-3">Select Category</label>
                <div class="border border-gray-300 rounded-lg p-4 max-h-96 overflow-y-auto bg-gray-50">
                    @foreach ($categories as $parentCategory)
                        @if ($parentCategory->parent_id === null)
                            <div class="mb-3">
                                @if ($parentCategory->children->isEmpty())
                                    <label
                                        class="flex items-center space-x-3 p-2 bg-white rounded shadow-sm mb-2 hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" name="category_id" wire:model="category_id"
                                            value="{{ $parentCategory->id }}"
                                            class="text-red-600 focus:ring-red-500">
                                        <span class="font-semibold text-gray-800">{{ $parentCategory->name }}</span>
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Parent
                                            Category</span>
                                    </label>
                                @else
                                    <div class="font-semibold text-gray-800 p-2 bg-white rounded shadow-sm mb-2">
                                        {{ $parentCategory->name }}
                                        <span
                                            class="text-xs text-gray-500 ml-2">{{ $parentCategory->children->count() }}
                                            subcategories</span>
                                    </div>
                                @endif

                                @foreach ($parentCategory->children as $childCategory)
                                    <div class="ml-4 mb-2">
                                        @if ($childCategory->children->isEmpty())
                                            <label
                                                class="flex items-center space-x-3 p-2 bg-white rounded shadow-sm mb-1 hover:bg-gray-50 cursor-pointer">
                                                <input type="radio" name="category_id" wire:model="category_id"
                                                    value="{{ $childCategory->id }}"
                                                    class="text-red-600 focus:ring-red-500">
                                                <span
                                                    class="text-gray-700 font-medium">{{ $childCategory->name }}</span>
                                                <span
                                                    class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Category</span>
                                            </label>
                                        @else
                                            <div class="text-gray-700 font-medium p-2 bg-white rounded shadow-sm mb-1">
                                                {{ $childCategory->name }}
                                                <span
                                                    class="text-xs text-gray-500 ml-2">{{ $childCategory->children->count() }}
                                                    subcategories</span>
                                            </div>
                                        @endif

                                        @foreach ($childCategory->children as $grandchildCategory)
                                            <label
                                                class="flex items-center space-x-3 ml-8 p-2 hover:bg-gray-100 rounded cursor-pointer">
                                                <input type="radio" name="category_id" wire:model="category_id"
                                                    value="{{ $grandchildCategory->id }}"
                                                    class="text-red-600 focus:ring-red-500">
                                                <span class="text-gray-600">
                                                    {{ $grandchildCategory->name }}
                                                    @if ($grandchildCategory->children->isNotEmpty())
                                                        <span class="text-xs text-red-500 ml-2">Has
                                                            {{ $grandchildCategory->children->count() }} more
                                                            levels</span>
                                                    @endif
                                                </span>
                                            </label>

                                            @foreach ($grandchildCategory->children as $greatGrandchild)
                                                <label
                                                    class="flex items-center space-x-3 ml-12 p-2 hover:bg-gray-100 rounded cursor-pointer">
                                                    <input type="radio" name="category_id" wire:model="category_id"
                                                        value="{{ $greatGrandchild->id }}"
                                                        class="text-red-600 focus:ring-red-500">
                                                    <span
                                                        class="text-sm text-gray-500">{{ $greatGrandchild->name }}</span>
                                                </label>

                                                @foreach ($greatGrandchild->children as $level5Category)
                                                    <label
                                                        class="flex items-center space-x-3 ml-16 p-2 hover:bg-gray-100 rounded cursor-pointer">
                                                        <input type="radio" name="category_id"
                                                            wire:model="category_id"
                                                            value="{{ $level5Category->id }}"
                                                            class="text-red-600 focus:ring-red-500">
                                                        <span
                                                            class="text-xs text-gray-500">{{ $level5Category->name }}</span>
                                                    </label>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>

                @if ($category_id)
                    <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-700">Selected:
                            <span class="font-semibold">
                                @php
                                    $selectedCategory = \App\Models\Category::find($category_id);
                                @endphp
                                {{ $selectedCategory ? $selectedCategory->fullPath() : 'Unknown Category' }}
                            </span>
                        </p>
                    </div>
                @endif

                @error('category_id')
                    <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="bg-red-600 px-4 py-2 rounded-lg text-white hover:bg-red-700 transition-colors">
                Update Product
            </button>
        </form>
    </div>
</div>

@script
    <script>
        // Initialize editor when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Check if WysiwygEditor is available
            if (typeof WysiwygEditor !== 'undefined') {
                // Initialize the editor for description
                if (document.getElementById('editor-description-container')) {
                    // Destroy existing instance if any
                    if (window.wysiwygEditors && window.wysiwygEditors['editor-description-container']) {
                        window.wysiwygEditors['editor-description-container'].destroy();
                    }

                    // Create new editor instance
                    new WysiwygEditor('editor-description-container', {
                        height: 200,
                        placeholder: 'Enter product description...'
                    });
                }
            } else {
                console.warn('WysiwygEditor not loaded yet. Will retry after Livewire loads.');
            }
        });

        // Listen for Livewire initialization
        document.addEventListener('livewire:init', () => {
            console.log('Livewire initialized, setting up WYSIWYG editor...');
            initializeEditor();
        });

        // Listen for Livewire updates (after form submission)
        document.addEventListener('livewire:after-update', () => {
            console.log('Livewire updated, reinitializing editor...');
            // Small delay to ensure DOM is fully updated
            setTimeout(initializeEditor, 100);
        });

        // Function to initialize/reinitialize the editor
        function initializeEditor() {
            if (typeof WysiwygEditor !== 'undefined' && document.getElementById('editor-description-container')) {
                // Check if editor already exists
                const container = document.getElementById('editor-description-container');
                const existingEditor = container.querySelector('.wysiwyg-editor-container');

                if (existingEditor) {
                    // Save current content before removing
                    const editor = window.wysiwygEditors['editor-description-container'];
                    if (editor) {
                        const currentContent = editor.getContent();
                        editor.destroy();

                        // Create new editor with saved content
                        const newEditor = new WysiwygEditor('editor-description-container', {
                            height: 200,
                            placeholder: 'Enter product description...'
                        });

                        // Restore content
                        setTimeout(() => {
                            if (currentContent && currentContent !== 'Enter product description...') {
                                newEditor.setContent(currentContent);
                            }
                        }, 50);
                    }
                } else {
                    // Create new editor
                    new WysiwygEditor('editor-description-container', {
                        height: 200,
                        placeholder: 'Enter product description...'
                    });
                }
            } else {
                console.warn('WysiwygEditor or container not found');
            }
        }

        // Handle the product-edit event
        let editAlert = document.getElementById('editAlert');

        $wire.on('load-editor', (event) => {
            setTimeout(initializeEditor, 300);
        });
        $wire.on('product-edit', (event) => {
            let message = event[0]?.message || 'Product updated successfully!';
            editAlert.innerHTML = message;
            editAlert.classList.remove('hidden');

            // Add animation class
            editAlert.classList.add('animate-slide-in');

            // Hide after 3 seconds
            setTimeout(() => {
                editAlert.classList.remove('animate-slide-in');
                editAlert.classList.add('hidden');
            }, 3000);

            // Reinitialize editor after successful update
            console.log('Product edit successful, reinitializing editor...');
            setTimeout(initializeEditor, 300);
        });

        // Also handle any Livewire errors that might cause editor to disappear
        document.addEventListener('livewire:request-finished', (event) => {
            // If the request was successful (not an error)
            if (!event.detail.rejected) {
                // Reinitialize editor after any successful request
                setTimeout(initializeEditor, 200);
            }
        });
    </script>
@endscript
