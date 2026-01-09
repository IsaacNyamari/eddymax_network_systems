<div>
    <x-input-label for="description">Description</x-input-label>

    <div id="editor-description-container" data-wysiwyg data-height="200" data-placeholder="Enter product description...">
        <textarea wire:model="description" id="description" rows="3" class="hidden">{{ old('description', $description ?? '') }}</textarea>
    </div>

    @error('description')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror

</div>

