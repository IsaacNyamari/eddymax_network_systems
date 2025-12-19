<?php

namespace App\Livewire;

use App\Models\OrderReturns;
use Livewire\Component;

class ReturnActions extends Component
{
    public $return;
    public $return_status;
    public function updateRequestStatus(array $return, string $action)
    {
        $return['status'] = $action;
        $returnUpdate = OrderReturns::where('id', $return['id']);
        $returnUpdate->update([
            'status' => $return['status']
        ]);
    }

    public function render()
    {
        return view('livewire.return-actions');
    }
}
