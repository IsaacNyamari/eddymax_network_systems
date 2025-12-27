<div class="p-4">
    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="saveSiteSetting" class="text-left space-y-4">
        <!-- App Settings -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-3">Application Settings</h3>

            <div class="mb-4">
                <x-input-label for="app_name" class="mb-2">System / Website Name</x-input-label>
                <x-text-input id="app_name" class="w-full" wire:model.live="app_name" placeholder="My Application" />
                @error('app_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Mail Settings -->
        <div class="border-t pt-6">
            <h3 class="text-lg font-semibold mb-3">Mail Settings</h3>

            <div class="mb-4">
                <x-input-label for="mail_mailer" class="mb-2">Mail Driver</x-input-label>
                <select id="mail_mailer"
                    class="w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                    wire:model.live="mail_mailer">
                    <option value="smtp">SMTP</option>
                    <option value="mailgun">Mailgun</option>
                    <option value="ses">Amazon SES</option>
                    <option value="postmark">Postmark</option>
                    <option value="sendmail">Sendmail</option>
                    <option value="log">Log</option>
                </select>
                @error('mail_mailer')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label for="mail_host" class="mb-2">Mail Host</x-input-label>
                    <x-text-input id="mail_host" class="w-full" wire:model.live="mail_host"
                        placeholder="smtp.mailgun.org" />
                    @error('mail_host')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="mail_port" class="mb-2">Mail Port</x-input-label>
                    <x-text-input id="mail_port" class="w-full" wire:model.live="mail_port" placeholder="587"
                        type="number" />
                    @error('mail_port')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label for="mail_username" class="mb-2">Mail Username</x-input-label>
                    <x-text-input id="mail_username" class="w-full" wire:model.live="mail_username"
                        placeholder="username@domain.com" type="email" />
                    @error('mail_username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="mail_password" class="mb-2">Mail Password</x-input-label>
                    <x-text-input id="mail_password" class="w-full" wire:model.live="mail_password"
                        placeholder="Leave blank to keep current" type="password" />
                    @error('mail_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">Leave blank to keep current password</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label for="mail_encryption" class="mb-2">Mail Encryption</x-input-label>
                    <select id="mail_encryption"
                        class="w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                        wire:model.live="mail_encryption">
                        <option value="tls">TLS</option>
                        <option value="ssl">SSL</option>
                        <option value="">None</option>
                    </select>
                    @error('mail_encryption')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="mail_from_address" class="mb-2">From Email Address</x-input-label>
                    <x-text-input id="mail_from_address" class="w-full" wire:model.live="mail_from_address"
                        placeholder="noreply@domain.com" type="email" />
                    @error('mail_from_address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <x-input-label for="mail_from_name" class="mb-2">From Name</x-input-label>
                <x-text-input id="mail_from_name" class="w-full" wire:model.live="mail_from_name"
                    placeholder="My Application" />
                @error('mail_from_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Paystack Settings -->
        <div class="border-t pt-6">
            <h3 class="text-lg font-semibold mb-3">Paystack Settings</h3>

            <div class="mb-4">
                <x-input-label for="paystack_mode" class="mb-2">Paystack Mode</x-input-label>
                <select id="paystack_mode"
                    class="w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                    wire:model.live="paystack_mode">
                    <option value="live">Live</option>
                    <option value="test">Test</option>
                </select>
                @error('paystack_mode')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label for="paystack_public_key" class="mb-2">Paystack Public Key</x-input-label>
                    <x-text-input id="paystack_public_key" class="w-full" wire:model.live="paystack_public_key"
                        placeholder="pk_live_..." />
                    @error('paystack_public_key')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="paystack_payment_url" class="mb-2">Paystack API URL</x-input-label>
                    <x-text-input id="paystack_payment_url" class="w-full" wire:model.live="paystack_payment_url"
                        placeholder="https://api.paystack.co" />
                    @error('paystack_payment_url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-6 border-t">
            <button type="submit" id="saveSettingsButton" wire:loading.attr="disabled"
                class="bg-green-800 text-white px-6 py-3 rounded-lg hover:bg-green-600 hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading wire:target="saveSiteSetting" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Saving...
                </span>
                <span wire:loading.remove wire:target="saveSiteSetting">Save Settings</span>
            </button>

            <button type="button" wire:click="mount"
                class="ml-3 bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-all duration-200">
                Reset Changes
            </button>
        </div>
    </form>
</div>

