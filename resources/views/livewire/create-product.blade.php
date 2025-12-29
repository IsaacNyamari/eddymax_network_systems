<div>
    <form wire:submit.prevent="save">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" id="name" wire:model.live="name"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500">
            @error('name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            <input type="number" id="price" wire:model.live="price"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500">
            @error('price')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-3">Select Category</label>

            <div class="border border-gray-300 rounded-lg p-4 max-h-96 overflow-y-auto bg-gray-50">
                @foreach ($categories as $parentCategory)
                    @if ($parentCategory->parent_id === null)
                        <div class="mb-3">
                            <!-- Parent Category - Check if it's a leaf node -->
                            @if ($parentCategory->children->isEmpty())
                                <!-- This parent category has no children, so it's selectable -->
                                <label
                                    class="flex items-center space-x-3 p-2 bg-white rounded shadow-sm mb-2 hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="category_id" wire:model.live="category_id"
                                        value="{{ $parentCategory->id }}" class="text-red-600 focus:ring-red-500">
                                    <span class="font-semibold text-gray-800">{{ $parentCategory->name }}</span>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Parent
                                        Category</span>
                                </label>
                            @else
                                <!-- Parent category has children, show as header only -->
                                <div class="font-semibold text-gray-800 p-2 bg-white rounded shadow-sm mb-2">
                                    {{ $parentCategory->name }}
                                    <span class="text-xs text-gray-500 ml-2">{{ $parentCategory->children->count() }}
                                        subcategories</span>
                                </div>
                            @endif

                            @foreach ($parentCategory->children as $childCategory)
                                <div class="ml-4 mb-2">
                                    <!-- Child Category - Check if it's a leaf node -->
                                    @if ($childCategory->children->isEmpty())
                                        <!-- This child category has no children, so it's selectable -->
                                        <label
                                            class="flex items-center space-x-3 p-2 bg-white rounded shadow-sm mb-1 hover:bg-gray-50 cursor-pointer">
                                            <input type="radio" name="category_id" wire:model.live="category_id"
                                                value="{{ $childCategory->id }}"
                                                class="text-red-600 focus:ring-red-500">
                                            <span class="text-gray-700 font-medium">{{ $childCategory->name }}</span>
                                            <span
                                                class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Category</span>
                                        </label>
                                    @else
                                        <!-- Child category has grandchildren, show as sub-header -->
                                        <div class="text-gray-700 font-medium p-2 bg-white rounded shadow-sm mb-1">
                                            {{ $childCategory->name }}
                                            <span
                                                class="text-xs text-gray-500 ml-2">{{ $childCategory->children->count() }}
                                                subcategories</span>
                                        </div>
                                    @endif

                                    <!-- Grandchildren (Level 3) - Always selectable -->
                                    @foreach ($childCategory->children as $grandchildCategory)
                                        <label
                                            class="flex items-center space-x-3 ml-8 p-2 hover:bg-gray-100 rounded cursor-pointer">
                                            <input type="radio" name="category_id" wire:model.live="category_id"
                                                value="{{ $grandchildCategory->id }}"
                                                class="text-red-600 focus:ring-red-500">
                                            <span class="text-gray-600">
                                                {{ $grandchildCategory->name }}
                                                @if ($grandchildCategory->children->isNotEmpty())
                                                    <span class="text-xs text-red-500 ml-2">Has
                                                        {{ $grandchildCategory->children->count() }} more levels</span>
                                                @endif
                                            </span>
                                        </label>

                                        <!-- Great Grandchildren (Level 4+) - Also selectable -->
                                        @foreach ($grandchildCategory->children as $greatGrandchild)
                                            <label
                                                class="flex items-center space-x-3 ml-12 p-2 hover:bg-gray-100 rounded cursor-pointer">
                                                <input type="radio" name="category_id" wire:model.live="category_id"
                                                    value="{{ $greatGrandchild->id }}"
                                                    class="text-red-600 focus:ring-red-500">
                                                <span class="text-sm text-gray-500">{{ $greatGrandchild->name }}</span>
                                            </label>

                                            <!-- Level 5 - Also selectable -->
                                            @foreach ($greatGrandchild->children as $level5Category)
                                                <label
                                                    class="flex items-center space-x-3 ml-16 p-2 hover:bg-gray-100 rounded cursor-pointer">
                                                    <input type="radio" name="category_id"
                                                        wire:model.live="category_id" value="{{ $level5Category->id }}"
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
        <div class="mt-4">
            <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
               <select name="" wire:model.live='brand'
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500">
                @foreach ($brands as $brandInput)
                    <option value="{{ $brandInput->id }}">{{ $brandInput->name }}</option>
                @endforeach
            </select>
            @error('brand')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-4">
            <label for="model" class="block text-sm font-medium text-gray-700 capitalize">model</label>
            <input type="text" id="model"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500"
                wire:model.live='model'>
            @error('model')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-4">
            <label for="fileName" class="block text-sm font-medium text-gray-700">Main Product Image</label>
            <div class="drop-zone" id="dropZone">
                <i class="fa fa-upload" aria-hidden="true"></i>
                <p class="mt-3 fw-bold">Drop file here</p>
                <p class="text-muted small">or click to browse</p>
                <input type="file" id="fileInput" class="hidden" wire:model="image" accept="image/*"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500">
                @error('image')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>


            @if ($image)
                <div class="mt-2">
                    <p class="text-sm text-gray-600">Preview:</p>
                    <img src="{{ $image->temporaryUrl() }}" class="mt-2 w-32 h-32 object-cover rounded-lg">
                </div>
            @endif
        </div>

        <!-- Multiple Images Section -->
        <div class="mt-4">
            <label for="images" class="block text-sm font-medium text-gray-700">
                Additional Images (Max: 5)
            </label>
            <input type="file" id="images" wire:model="images" accept="image/*" multiple
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500">

            @error('images')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
            @error('images.*')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror

            @if ($images && count($images) > 0)
                <div class="mt-3">
                    <p class="text-sm text-gray-600 mb-2">Preview of additional images:</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($images as $index => $img)
                            <div class="relative">
                                <img src="{{ $img->temporaryUrl() }}"
                                    class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                                <button type="button" wire:click="removeImage({{ $index }})"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                    ×
                                </button>
                                <span
                                    class="absolute bottom-1 right-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        {{ count($images) }} image(s) selected
                    </p>
                </div>
            @endif
        </div>

        <div class="mt-4">
            <label for="editor" class="block text-sm font-medium text-gray-700">Short Description</label>
            <textarea id="editor" wire:model.live="short_description"
                class="mt-0 block w-full border border-gray-300 rounded-bl-lg  rounded-br-lg shadow-sm p-2 focus:ring-red-500"
                rows="5"></textarea>
            @error('short_description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-4">
            <label for="editor" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="editor" wire:model.live="description"
                class="mt-0 block w-full border border-gray-300 rounded-bl-lg  rounded-br-lg shadow-sm p-2 focus:ring-red-500"
                rows="15"></textarea>
            @error('description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>



        <div class="mt-6">
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition">
                Save Product
            </button>
        </div>

        @if (session('message'))
            <div class="mt-4 p-3 bg-green-100 text-green-700 rounded-lg">
                {{ session('message') }}
            </div>
        @endif
    </form>
</div>
