<div>
    <h2 class="text-lg font-semibold text-gray-900 mb-6">Edit User: {{ $user->name }}</h2>
    <form wire:submit.prevent='save({{ $user->id }})' method="POST">
        @csrf
        @method('PUT')
        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" wire:model.live="name" id="name" value="{{ old('name', $user->name) }}"
                class="mt-1 block w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
            @error('name')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" wire:model.live="email" id="email" value="{{ old('email', $user->email) }}"
                class="mt-1 block w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
            @error('email')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <!-- Phone -->
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="phone" wire:model.live="phone" id="phone"
                class="mt-1 block w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
            @error('phone')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <!-- Address -->
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <input type="address" wire:model.live="address" id="address"
                class="mt-1 block w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
            @error('address')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        {{-- <div class="mb-4">
            <label class="flex items-center space-x-3">
                <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}
                    class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                <span class="text-sm text-gray-700">Active</span>
            </label>
        </div> --}}

        <!-- Roles -->
        {{-- <div class="mb-4">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-2">Roles</h3>
            <div class="space-y-2">
                @foreach ($roles as $role)
                    <label class="flex items-center space-x-2 text-sm text-gray-600">
                        <input type="radio" name="roles[]" value="{{ $role->name }}"
                            {{ $user->hasRole($role->name) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span>{{ ucfirst($role->name) }}</span>
                    </label>
                @endforeach
            </div>
        </div> --}}

        <!-- Submit -->
        <div class="mt-6">
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500 transition">
              <i class="fa fa-check" aria-hidden="true"></i>  Update User
            </button>
        </div>
    </form>
</div>
