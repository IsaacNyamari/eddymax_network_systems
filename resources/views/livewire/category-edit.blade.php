<div class="overflow-x-auto">

    <form wire:submit.prevent="saveCategory" enctype="multipart/form-data" class="p-3">

        <div class="mb-2">
            <x-input-label for="name" class="mb-2" value="Category Name" />
            <x-text-input class="w-full" wire:model.live="name" id="name" />
        </div>
        <x-primary-button>Update</x-primary-button>
    </form>
</div>
