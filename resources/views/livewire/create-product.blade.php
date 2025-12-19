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
            <label for="image" class="block text-sm font-medium text-gray-700">Main Product Image</label>
            <input type="file" id="image" wire:model="image" accept="image/*"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500">
            @error('image')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror

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
            <label for="editor" class="block text-sm font-medium text-gray-700">Description</label>
            <livewire:editor-toolbar />
            <textarea id="editor" wire:model.live="description"
                class="mt-0 block w-full border border-gray-300 rounded-bl-lg  rounded-br-lg shadow-sm p-2 focus:ring-red-500"
                rows="5"></textarea>
            @error('description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="categoryId" class="block text-sm font-medium text-gray-700">Category</label>
            <select id="categoryId" wire:model.live="category_id"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
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
