<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditProduct extends Component
{
    public $product;
    public $categories;
    #[Validate('required|int')]
    public $price;
    #[Validate('required|string|min:3')]
    public $name;
    #[Validate('required|string')]
    public $description;

    public function mount()
    {
        $this->categories = Category::all();
        $this->name = $this->product->name;
        $this->price = $this->product->price;
        $this->description = $this->product->description;
    }
    public function saveProduct()
    {
        dd($this->product);
    }
    public function render()
    {
        return view('livewire.edit-product');
    }
}
