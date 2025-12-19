<div>
    <span
        class="px-3 py-1 rounded-full block mb-2 text-sm w-fit font-medium
                    @if ($return->status === 'pending') bg-yellow-100 text-yellow-700
                    @elseif($return->status === 'approved') bg-green-100 text-green-700
                    @elseif($return->status === 'rejected') bg-red-100 text-red-700 @endif
                ">
        {{ ucfirst($return->status) }}
    </span>
    @if ($return->status != 'pending')
        <button wire:click="updateRequestStatus({{ $return->id }}, 'pending')"
            class="bg-red-600 px-4 py-2 rounded text-white hover:bg-red-700">
            Pend
        </button>
    @endif
    @if ($return->status != 'approved')
        <button wire:click="updateRequestStatus({{ $return->id }}, 'approved')"
            class="bg-green-600 px-4 py-2 rounded text-white hover:bg-green-700">
            Approve
        </button>
    @endif

    @if ($return->status != 'rejected')
        <button wire:click="updateRequestStatus({{ $return->id }}, 'rejected')"
            class="bg-orange-600 px-4 py-2 rounded text-white hover:bg-orange-700">
            Reject
        </button>
    @endif
</div>
