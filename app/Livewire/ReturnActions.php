<?php

namespace App\Livewire;

use App\Models\OrderReturns;
use Livewire\Component;

class ReturnActions extends Component
{
    public $return;
    public $return_status = 'pending';
    public function updateRequestStatus(int $returnId, string $action)
    {
        $returnUpdate = OrderReturns::find($returnId);

        if ($returnUpdate) {
            $returnUpdate->update([
                'status' => $action
            ]);

            // Update the local return property
            $this->return->status = $action;
            $this->dispatch('return-updated', $action);
            // Optional: Show success message
            session()->flash('message', "Return {$action} successfully!");
        }
    }

    public function render()
    {
        return view('livewire.return-actions');
    }
}
