<div class="bg-white p-6 max-h-[90vh] rounded-lg shadow-md flex items-center justify-center">
    <form class="w-full max-w-md space-y-4">
        <x-input-label for='name'>Name </x-input-label>
        <x-text-input
            wire:model.live="name"
            id="name"
            class="w-full"
            placeholder="Enter name"
        />
        <x-input-label for='name'>Name </x-input-label>
        <x-text-input
            wire:model.live="name"
            id="name"
            class="w-full"
            placeholder="Enter name"
        />
    </form>
</div>
