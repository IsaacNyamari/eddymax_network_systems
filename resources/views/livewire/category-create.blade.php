<div class="overflow-x-auto">
    <form wire:submit.prevent="saveCategory" class="p-3 space-y-3">

        <div>
            <x-input-label for="name" value="Category Name" />
            <x-text-input id="name" type="text" class="w-full" wire:model.live="name" />
            @error('name')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <x-input-label for="parent_category" value="Parent Category" />
            <select name="" wire:model.live="parent_category" class="w-full rounded-lg" id="">
                <option value="">Choose Parent</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('parent_category')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-input-label for="image" value="Category Image" />
            <input id="image" type="file" class="w-full border rounded p-2" wire:model.live="image" />
            @error('image')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <x-primary-button type="submit">
            Create Category
        </x-primary-button>

    </form>
</div>
