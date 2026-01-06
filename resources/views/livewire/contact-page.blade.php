<div>
    <div class="bg-white rounded-xl shadow-lg p-8 space-y-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Send Us a Message</h2>

        <form wire:submit.prevent='submit()'>
            <div class="space-y-4">
                <!-- Form fields remain the same -->
                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-1">Name</label>
                    <input type="text" id="name" wire:model.live="name" placeholder="Your Name"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                    @error('name')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" id="email" wire:model.live="email" placeholder="Your Email"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                    @error('email')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block text-gray-700 font-semibold mb-1">Phone</label>
                    <input type="text" id="phone" wire:model.live="phone" placeholder="Your Phone"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                    @error('phone')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="message" class="block text-gray-700 font-semibold mb-1">Message</label>
                    <textarea id="message" wire:model.live="message" rows="5" placeholder="Your Message"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                    @error('message')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition transform hover:-translate-y-1 shadow-lg">
                    Send Message
                </button>
            </div>
        </form>
    </div>

    <!-- Toast Notification Container -->
    <div x-data="{ show: false, response: '' }"
        x-on:message-sent.window="
        response = $event.detail.message;
        show = true;
        setTimeout(() => show = false, 5000);
    "
        x-show="show" x-transition class="fixed top-4 right-4 z-50 w-96 max-w-full">
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow">
            <p class="text-green-700 text-sm" x-text="response"></p>
        </div>
    </div>


</div>
@script
    <script>
        $wire.on('message-sent', (data) => {
            const message = data[0].message;

            // Show the toast notification
            Alpine.data.toast = {
                show: true,
                response: `${message}`
            };
            // Auto-hide after 5 seconds
            setTimeout(() => {
                Alpine.data.toast.show = false;
            }, 5000);
        });
    </script>
@endscript
