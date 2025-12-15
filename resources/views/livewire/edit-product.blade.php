<div class="bg-white p-6 max-h-[90vh] rounded-lg shadow-md flex items-center justify-center">
    <form class="w-full max-w-md space-y-4" wire:submit.prevent="saveProduct">

        {{-- GLOBAL ERRORS --}}
        @if ($errors->any())
            <div class="p-3 text-sm text-red-700 bg-red-100 rounded-lg">
                Please fix the errors below.
            </div>
        @endif

        {{-- NAME --}}
        <div>
            <x-input-label for="name">Name</x-input-label>
            <x-text-input wire:model.live="name" id="name" class="w-full" placeholder="Enter name" />
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- PRICE --}}
        <div>
            <x-input-label for="price">Price</x-input-label>
            <x-text-input type="number" wire:model.live="price" id="price" class="w-full"
                placeholder="Enter price" />
            @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- DESCRIPTION --}}
        <div>
            <x-input-label for="description">Description</x-input-label>
            <textarea wire:model.live="description" id="description"
                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" rows="3"
                placeholder="Enter description"></textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- CATEGORY --}}
        <div>
            <x-input-label for="category">Category</x-input-label>
            <select wire:model.live="category" id="category"
                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Select category</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <x-primary-button class="w-full justify-center">
            Update
        </x-primary-button>

    </form>
</div>
