<?php

namespace App\Livewire;

use Livewire\Component;

class CartCount extends Component
{
    public $count = 0;
    public $listeners = ['cart-updated' => 'updateCount'];
    public function mount()
    {
        $this->count = array_sum(array_column(session()->get('cart', []), 'quantity'));
    }
    public function updateCount()
    {
        $this->count = array_sum(array_column(session()->get('cart', []), 'quantity'));
    }
    public function render()
    {
        return view('livewire.cart-count');
    }
}
