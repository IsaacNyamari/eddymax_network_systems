<div>
    @if ($return->status != 'rejected')
        <button wire:click="updateRequestStatus({{ $return }},'approved')"
            class="bg-green-600 px-4 py-2 rounded text-white">Approve</button>
    @endif
    @if ($return->status != 'approved')
        <button wire:click="updateRequestStatus({{ $return }},'rejected')"
            class="bg-red-600 px-4 py-2 rounded text-white">Reject</button>
    @endif
</div>
