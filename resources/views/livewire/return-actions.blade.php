<div>
    @if ($return->status != ('approved'))
        <button wire:click="updateRequestStatus({{ $return->id }}, 'approved')"
            class="bg-green-600 px-4 py-2 rounded text-white hover:bg-green-700">
            Approve
        </button>
    @endif

    @if ($return->status != 'rejected')
        <button wire:click="updateRequestStatus({{ $return->id }}, 'rejected')"
            class="bg-red-600 px-4 py-2 rounded text-white hover:bg-red-700">
            Reject
        </button>
    @endif
</div>
