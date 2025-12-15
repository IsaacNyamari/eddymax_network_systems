  <div class="grid grid-row-1 lg:grid-row-2 gap-6">
      <!-- Recent Orders -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200">

          <form class="bg-white p-6 rounded-lg shadow-md space-y-4" wire:submit.prevent="saveProduct">

              {{-- GLOBAL ERRORS --}}
              @if ($errors->any())
                  <div class="p-3 text-sm text-red-700 bg-red-100 rounded-lg">
                      Please fix the errors below.
                  </div>
              @endif

              {{-- NAME --}}
              <div>
                  <x-input-label for="name">Name</x-input-label>
                  <x-text-input wire:model.live="name" id="name" class="w-full" />
                  @error('name')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>

              {{-- PRICE --}}
              <div>
                  <x-input-label for="price">Price</x-input-label>
                  <x-text-input type="number" wire:model.live="price" id="price" class="w-full" />
                  @error('price')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>

              {{-- DESCRIPTION --}}
              <div>
                  <x-input-label for="description">Description</x-input-label>
                  <textarea wire:model.live="description" rows="3"
                      class="w-full rounded-lg border-gray-300 h-72 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                  @error('description')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>

              {{-- CATEGORY --}}
              <div>
                  <x-input-label for="category_id">Category</x-input-label>
                  <select wire:model.live="category_id"
                      class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                      <option value="">Select category</option>
                      @foreach ($categories as $cat)
                          <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                      @endforeach
                  </select>
                  @error('category_id')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>

              <x-primary-button class="w-fit justify-center">
                  Update
              </x-primary-button>

          </form>

      </div>
  </div>
