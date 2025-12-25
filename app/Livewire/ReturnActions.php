<?php

namespace App\Livewire;

use App\Mail\OrderReturns as MailOrderReturns;
use App\Models\OrderReturns;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ReturnActions extends Component
{
    public $return;
    public $return_status = 'pending';
    public function updateRequestStatus(int $returnId, string $action)
    {
        $returnUpdate = OrderReturns::find($returnId);
        // dd($returnUpdate->order->user->email);
        if ($returnUpdate) {
            $returnUpdate->update([
                'status' => $action
            ]);

            // Update the local return property
            $this->return->status = $action;
            // Optional: Show success message
            Mail::to($returnUpdate->order->user->email)->send(new MailOrderReturns($returnUpdate, $this->return->status));
            $this->dispatch('return-updated', [
                "message" => "Return {$action} successfully!"
            ]);
        }
    }

    public function render()
    {
        return view('livewire.return-actions');
    }
}
