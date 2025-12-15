<div>
    @if($show)
        <div class="fixed top-4 right-4 z-50 animate-slide-in"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, {{ $duration }}), $watch('show', value => value === false && $wire.hideToast())"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-full">
            
            <div class="{{ $type === 'success' ? 'bg-green-500 border-green-600' : 
                            ($type === 'error' ? 'bg-red-500 border-red-600' : 
                            ($type === 'warning' ? 'bg-yellow-500 border-yellow-600' : 
                            ($type === 'info' ? 'bg-blue-500 border-blue-600' : 'bg-green-500 border-green-600'))) }} 
                        text-white px-6 py-4 rounded-lg shadow-lg border-l-4 max-w-sm">
                
                <div class="flex items-center">
                    <!-- Icon based on action -->
                    <div class="mr-3">
                        @if($action === 'added')
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                <path d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"/>
                            </svg>
                        @elseif($action === 'removed')
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($action === 'updated')
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($type === 'success')
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($type === 'error')
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                    
                    <!-- Message -->
                    <div class="flex-1">
                        <p class="font-medium">{{ $message }}</p>
                        @if($productName && $action === 'added')
                            <p class="text-sm opacity-90 mt-1">✓ Added to your cart</p>
                        @elseif($productName && $action === 'removed')
                            <p class="text-sm opacity-90 mt-1">Removed from cart</p>
                        @endif
                    </div>
                    
                    <!-- Close Button -->
                    <button @click="show = false" 
                            class="ml-4 text-white hover:text-gray-200 focus:outline-none">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Progress Bar -->
                <div class="mt-2">
                    <div class="h-1 bg-white/30 rounded-full overflow-hidden">
                        <div class="h-full bg-white/50 rounded-full transition-all duration-{{ $duration }} ease-linear"
                             x-data="{ width: '0%' }"
                             x-init="setTimeout(() => width = '100%', 10)"
                             :style="`width: ${width}`">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>