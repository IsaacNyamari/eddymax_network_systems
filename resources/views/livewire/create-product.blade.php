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
            <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
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

        <div class="mt-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" wire:model.live="description"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500"
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
