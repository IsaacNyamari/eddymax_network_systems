<div class="bg-white p-6 max-h-[90vh] rounded-lg shadow-md flex items-center justify-center">
    <form class="w-full max-w-md space-y-4">
        <x-input-label for='name'>Name </x-input-label>
        <x-text-input wire:model.live="name" id="name" class="w-full" placeholder="Enter name" />
        <x-input-label for='price'>Price </x-input-label>
        <x-text-input type='number' wire:model.live="price" id="price" class="w-full" placeholder="Enter price" />
        <x-input-label for='description'>Description </x-input-label>
        <textarea wire:model.live="description" id="description" class="w-full rounded-lg" placeholder="Enter description"></textarea>
    </form>
</div>
