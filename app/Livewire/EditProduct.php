<?php

namespace App\Livewire;

use Livewire\Component;

class EditProduct extends Component
{
    public $product;
    public function render()
    {
        return view('livewire.edit-product');
    }
}
