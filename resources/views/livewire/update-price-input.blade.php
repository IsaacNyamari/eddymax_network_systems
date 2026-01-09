<div>
    <form wire:submit.prevent='updatePrice' class="text-sm font-medium text-gray-900">
        KES
        <x-text-input wire:model='price' type="number" step="0.01" min="0" />
        <button class="px-4 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white" type="submit">
            Update
        </button>

        @if (session()->has('message'))
            <div class="mt-2 text-green-600 text-sm">
                {{ session('message') }}
            </div>
        @endif

        @error('price')
            <div class="mt-2 text-red-600 text-sm">
                {{ $message }}
            </div>
        @enderror
    </form>
</div>
