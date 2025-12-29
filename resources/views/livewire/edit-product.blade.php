  <div class="grid grid-row-1 lg:grid-row-2 gap-6">

      <div id="editAlert"
          class="fixed top-5 right-5 rounded-r-lg text-white font-semibold hidden border-l-8 border-l-red-500 z-50 p-4 bg-green-500 justify-center ml-auto">
          Product updated
          successfully!</div>
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
              {{-- image --}}
              <div>
                  <x-input-label for="image">Product Image</x-input-label>
                  <x-text-input type="file" wire:model.live="image" id="image" class="w-full p-2" />
                  @error('image')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
                  @if ($image)
                      <div class="mt-2">
                          <p class="text-sm text-gray-600">Preview:</p>
                          <img src="{{ $image->temporaryUrl() }}" class="mt-2 w-32 h-32 object-cover rounded-lg">
                      </div>
                  @endif
              </div>

              {{-- PRICE --}}
              <div>
                  <x-input-label for="price">Price</x-input-label>
                  <x-text-input type="number" wire:model.live="price" id="price" class="w-full" />
                  @error('price')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>
              {{-- Stock Status --}}
              <div>
                  <x-input-label for="stock_status">Stock Status</x-input-label>

                  <div class="mt-2 flex items-center gap-4">
                      <div class="inline-flex items-center">
                          <input type="radio" wire:model.live="stock_status" name="stock_status"
                              id="stock_status_in_stock" value="in_stock"
                              class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500" />
                          <label for="stock_status_in_stock" class="ml-2 text-sm text-gray-700">
                              In Stock
                          </label>
                      </div>

                      <div class="inline-flex items-center">
                          <input type="radio" wire:model.live="stock_status" name="stock_status"
                              id="stock_status_out_of_stock" value="out_of_stock"
                              class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500" />
                          <label for="stock_status_out_of_stock" class="ml-2 text-sm text-gray-700">
                              Out of Stock
                          </label>
                      </div>

                      <div class="inline-flex items-center">
                          <input type="radio" wire:model.live="stock_status" name="stock_status"
                              id="stock_status_backorder" value="backorder"
                              class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500" />
                          <label for="stock_status_backorder" class="ml-2 text-sm text-gray-700">
                              Backorder
                          </label>
                      </div>
                  </div>

                  @error('stock_status')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>
              {{-- MODEL --}}
              <div>
                  <x-input-label for="model">Model</x-input-label>
                  <x-text-input type="text" wire:model.live="model" id="model" class="w-full" />
                  @error('model')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>
              {{-- MODEL --}}
              <div class="mt-4">
                  <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                  <select name="" wire:model.live='brand'
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500">
                      @foreach ($brands as $brandInput)
                          <option value="{{ $brandInput->id }}">{{ $brandInput->name }}</option>
                      @endforeach
                  </select>
                  @error('brand')
                      <span class="text-red-600 text-sm">{{ $message }}</span>
                  @enderror
              </div>

              {{-- DESCRIPTION --}}
              <div>
                  <x-input-label for="description">Description</x-input-label>
                  <textarea wire:model="description"rows="3"
                      class="w-full rounded-lg border-gray-300 h-72 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                  @error('description')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>

              {{-- CATEGORY --}}
              <div class="mt-4">
                  <label class="block text-sm font-medium text-gray-700 mb-3">Select Category</label>

                  <div class="border border-gray-300 rounded-lg p-4 max-h-96 overflow-y-auto bg-gray-50">
                      @foreach ($categories as $parentCategory)
                          @if ($parentCategory->parent_id === null)
                              <div class="mb-3">
                                  <!-- Parent Category - Check if it's a leaf node -->
                                  @if ($parentCategory->children->isEmpty())
                                      <!-- This parent category has no children, so it's selectable -->
                                      <label
                                          class="flex items-center space-x-3 p-2 bg-white rounded shadow-sm mb-2 hover:bg-gray-50 cursor-pointer">
                                          <input type="radio" name="category_id" wire:model.live="category_id"
                                              value="{{ $parentCategory->id }}"
                                              class="text-red-600 focus:ring-red-500">
                                          <span class="font-semibold text-gray-800">{{ $parentCategory->name }}</span>
                                          <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Parent
                                              Category</span>
                                      </label>
                                  @else
                                      <!-- Parent category has children, show as header only -->
                                      <div class="font-semibold text-gray-800 p-2 bg-white rounded shadow-sm mb-2">
                                          {{ $parentCategory->name }}
                                          <span
                                              class="text-xs text-gray-500 ml-2">{{ $parentCategory->children->count() }}
                                              subcategories</span>
                                      </div>
                                  @endif

                                  @foreach ($parentCategory->children as $childCategory)
                                      <div class="ml-4 mb-2">
                                          <!-- Child Category - Check if it's a leaf node -->
                                          @if ($childCategory->children->isEmpty())
                                              <!-- This child category has no children, so it's selectable -->
                                              <label
                                                  class="flex items-center space-x-3 p-2 bg-white rounded shadow-sm mb-1 hover:bg-gray-50 cursor-pointer">
                                                  <input type="radio" name="category_id" wire:model.live="category_id"
                                                      value="{{ $childCategory->id }}"
                                                      class="text-red-600 focus:ring-red-500">
                                                  <span
                                                      class="text-gray-700 font-medium">{{ $childCategory->name }}</span>
                                                  <span
                                                      class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Category</span>
                                              </label>
                                          @else
                                              <!-- Child category has grandchildren, show as sub-header -->
                                              <div
                                                  class="text-gray-700 font-medium p-2 bg-white rounded shadow-sm mb-1">
                                                  {{ $childCategory->name }}
                                                  <span
                                                      class="text-xs text-gray-500 ml-2">{{ $childCategory->children->count() }}
                                                      subcategories</span>
                                              </div>
                                          @endif

                                          <!-- Grandchildren (Level 3) - Always selectable -->
                                          @foreach ($childCategory->children as $grandchildCategory)
                                              <label
                                                  class="flex items-center space-x-3 ml-8 p-2 hover:bg-gray-100 rounded cursor-pointer">
                                                  <input type="radio" name="category_id"
                                                      wire:model.live="category_id"
                                                      value="{{ $grandchildCategory->id }}"
                                                      class="text-red-600 focus:ring-red-500">
                                                  <span class="text-gray-600">
                                                      {{ $grandchildCategory->name }}
                                                      @if ($grandchildCategory->children->isNotEmpty())
                                                          <span class="text-xs text-red-500 ml-2">Has
                                                              {{ $grandchildCategory->children->count() }} more
                                                              levels</span>
                                                      @endif
                                                  </span>
                                              </label>

                                              <!-- Great Grandchildren (Level 4+) - Also selectable -->
                                              @foreach ($grandchildCategory->children as $greatGrandchild)
                                                  <label
                                                      class="flex items-center space-x-3 ml-12 p-2 hover:bg-gray-100 rounded cursor-pointer">
                                                      <input type="radio" name="category_id"
                                                          wire:model.live="category_id"
                                                          value="{{ $greatGrandchild->id }}"
                                                          class="text-red-600 focus:ring-red-500">
                                                      <span
                                                          class="text-sm text-gray-500">{{ $greatGrandchild->name }}</span>
                                                  </label>

                                                  <!-- Level 5 - Also selectable -->
                                                  @foreach ($greatGrandchild->children as $level5Category)
                                                      <label
                                                          class="flex items-center space-x-3 ml-16 p-2 hover:bg-gray-100 rounded cursor-pointer">
                                                          <input type="radio" name="category_id"
                                                              wire:model.live="category_id"
                                                              value="{{ $level5Category->id }}"
                                                              class="text-red-600 focus:ring-red-500">
                                                          <span
                                                              class="text-xs text-gray-500">{{ $level5Category->name }}</span>
                                                      </label>
                                                  @endforeach
                                              @endforeach
                                          @endforeach
                                      </div>
                                  @endforeach
                              </div>
                          @endif
                      @endforeach
                  </div>

                  @if ($category_id)
                      <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                          <p class="text-sm text-green-700">Selected:
                              <span class="font-semibold">
                                  @php
                                      $selectedCategory = \App\Models\Category::find($category_id);
                                  @endphp
                                  {{ $selectedCategory ? $selectedCategory->fullPath() : 'Unknown Category' }}
                              </span>
                          </p>
                      </div>
                  @endif

                  @error('category_id')
                      <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span>
                  @enderror
              </div>

              <button class="bg-red-600 px-4 py-2 rounded-lg text-white">Update</button>

          </form>

      </div>
  </div>
  @script
      <script>
          let editAlert = document.getElementById('editAlert')
          $wire.on('product-edit', (event) => {
              let message = event[0].message
              editAlert.innerHTML = message
              editAlert.classList.remove('hidden');
              editAlert.classList.add('animate-slide-in');

              setTimeout(() => {
                  editAlert.classList.add('hidden')
              }, 3000);
          })
      </script>
  @endscript
