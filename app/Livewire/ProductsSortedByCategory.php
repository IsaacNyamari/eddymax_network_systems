<?php

namespace App\Livewire;

use Livewire\Component;

class ProductsSortedByCategory extends Component
{
    public $productsSorted;
    public function render()
    {
        return view('livewire.products-sorted-by-category');
    }
}
