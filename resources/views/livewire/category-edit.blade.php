<div class="overflow-x-auto">
    <form wire:submit.prevent="saveCategory" enctype="multipart/form-data" class="p-3">

        <div class="mb-2">
            <x-input-label for="name" class="mb-2" value="Category Name" />
            <x-text-input class="w-full" wire:model.live="name" id="name" />
            @error('name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
       <div class="mb-6" x-data="{ 
    open: false, 
    search: '', 
    selectedCategory: {{ $parent_id ?? 'null' }},
    selectedName: '{{ $parent_id ? $categories->firstWhere('id', $parent_id)->name ?? 'Select a parent' : 'Select a parent category (Optional)' }}'
}">
    <x-input-label for="parent_id" class="mb-3 font-medium text-gray-700" value="Parent Category" />
    
    <!-- Custom select with search -->
    <div class="relative">
        <!-- Selected value display -->
        <button 
            type="button"
            @click="open = !open"
            class="w-full px-4 py-3 text-left bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 flex justify-between items-center hover:bg-gray-50"
            :class="{ 'ring-2 ring-blue-500 border-blue-500': open }"
        >
            <span x-text="selectedName" :class="{ 'text-gray-500': !selectedCategory }"></span>
            <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        
        <!-- Hidden input for Livewire -->
        <input type="hidden" name="parent_id" wire:model.live="selectedParentCategory" x-model="selectedCategory">
        
        <!-- Dropdown -->
        <div 
            x-show="open"
            @click.away="open = false"
            class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
        >
            <!-- Search input -->
            <div class="p-2 border-b border-gray-100">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input 
                        type="text" 
                        x-model="search"
                        @click.stop
                        placeholder="Search categories..."
                        class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500"
                    >
                </div>
            </div>
            
            <!-- Options -->
            <div class="py-1">
                <!-- No parent option -->
                <button 
                    type="button"
                    @click="selectedCategory = ''; selectedName = 'Select a parent category (Optional)'; open = false; $wire.set('selectedParentCategory', '');"
                    class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center justify-between"
                    :class="{ 'bg-blue-50 text-blue-700': !selectedCategory }"
                >
                    <span>No Parent (Top-level category)</span>
                    <svg x-show="!selectedCategory" class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                
                <!-- Category options -->
                @foreach ($categories as $category)
                    <button 
                        type="button"
                        x-show="!search || '{{ strtolower($category->name) }}'.includes(search.toLowerCase())"
                        @click="selectedCategory = '{{ $category->id }}'; selectedName = '{{ $category->name }}'; open = false; $wire.set('selectedParentCategory', '{{ $category->id }}');"
                        class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center justify-between"
                        :class="{ 'bg-blue-50 text-blue-700': selectedCategory == '{{ $category->id }}' }"
                    >
                        <span>{{ $category->name }}</span>
                        <svg x-show="selectedCategory == '{{ $category->id }}'" class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                @endforeach
                
                <!-- No results -->
                <div x-show="search && Array.from(document.querySelectorAll('button[x-show]')).filter(btn => btn.style.display !== 'none').length === 0" 
                     class="px-4 py-3 text-center text-gray-500 text-sm">
                    No categories found for "<span x-text="search"></span>"
                </div>
            </div>
        </div>
    </div>
    
    <!-- Help text -->
    <p class="mt-2 text-sm text-gray-500">
        Select a parent category to make this a sub-category. Leave empty to create a top-level category.
    </p>
</div>

        <div class="mb-2">
            <label for="image">Category Image</label>
            <x-text-input class="w-full p-2" wire:model.live="image" type="file" id="image" />
        </div>
        <button class="bg-red-600 px-4 py-2 rounded-lg text-white">Update</button>
    </form>
</div>
