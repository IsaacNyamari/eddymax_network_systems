<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdatePriceInput extends Component
{
    public Product $product;

    #[Validate("required|numeric|min:0")]
    public $price;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->price = $product->price;
    }

    public function updatePrice()
    {
        $this->validate();
        $this->product->price = $this->price;
        $this->product->save();
        // Optional: Add success message
        session()->flash('message', 'Price updated successfully!');
    }

    public function render()
    {
        return view('livewire.update-price-input');
    }
}
