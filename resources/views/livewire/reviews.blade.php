<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Rate this product</h3>

    <form wire:submit.prevent="saveRating" class="space-y-6">
        <!-- Rating Stars -->
        <div class="space-y-3">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Your Rating
                @error('rateCount')
                    <span class="text-red-600 text-sm ml-2">* {{ $message }}</span>
                @enderror
            </label>

            <div class="flex items-center space-x-1">
                @for ($i = 1; $i <= 5; $i++)
                    <button type="button" wire:click="setRating({{ $i }})"
                        class="focus:outline-none transition-all duration-200 p-1 rounded-full bg-gray-100 hover:bg-orange-100">
                        <svg class="w-6 h-6 transition-colors duration-200
                    {{ $rateCount >= $i ? 'text-orange-400' : 'text-gray-400' }}
                    hover:text-orange-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    </button>
                @endfor

                <span class="ml-3 text-lg font-medium text-gray-700">
                    <span>{{ $rateCount }}</span>/5
                </span>
            </div>
        </div>

        <!-- Comment (Optional) -->
        <div>
            <label for="review_comment" class="block text-sm font-medium text-gray-700 mb-2">
                Your Comment (Optional)
            </label>
            <textarea id="review_comment" wire:model="comment" rows="3"
                placeholder="Share your thoughts about this product (optional)..."
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 resize-none"></textarea>
            @error('comment')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-70 cursor-not-allowed"
                class="w-fit py-3 px-4 bg-gradient-to-r from-red-600 to-red-500 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center">
                @if ($loading)
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>Submitting...</span>
                @else
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    <span>Submit Rating</span>
                @endif
            </button>

            <!-- Success/Error Messages -->
            @if (session()->has('message'))
                <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg" x-data="{ show: true }"
                    x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-green-700 font-medium">{{ session('message') }}</span>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg" x-data="{ show: true }" x-show="show"
                    x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-red-700 font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>

@script
    <script>
        // Auto-hide success messages after 5 seconds
        Livewire.on('review-saved', () => {
            setTimeout(() => {
                @this.dispatch('clear-messages');
            }, 5000);
        });
    </script>
@endscript
