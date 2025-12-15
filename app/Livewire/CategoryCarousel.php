<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryCarousel extends Component
{
    public $categories;
    public function mount()
    {
        $this->categories = Category::withCount('products')->get();
    }
    public function render()
    {
        return view('livewire.category-carousel');
    }
}
