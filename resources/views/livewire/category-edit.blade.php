<div class="overflow-x-auto">

    <form wire:submit.prevent="saveCategory" enctype="multipart/form-data" class="p-3">

        <div class="mb-2">
            <x-input-label for="name" class="mb-2" value="Category Name" />
            <x-text-input class="w-full" wire:model.live="name" id="name" />
            @error('name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-2">
            <x-input-label for="parent_id" class="mb-2" value="Parent Category" />
            <select name="parent_id" id="parent_id" wire:model.live='selectedParentCategory'
                class="w-full rounded-md border-gray-300">
                <option value="" {{ is_null($parent_id) ? 'selected' : '' }}>No Parent</option>
                @foreach ($categories as $category)
                    <option {{ $parent_id === $category->id ? 'selected' : '' }} value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-2">
            <label for="image">Category Image</label>
            <x-text-input class="w-full p-2" wire:model.live="image" type="file" id="image" />
        </div>
        <button class="bg-red-600 px-4 py-2 rounded-lg text-white">Update</button>
    </form>
</div>
