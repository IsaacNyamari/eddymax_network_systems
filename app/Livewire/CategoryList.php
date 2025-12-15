<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryList extends Component
{
    public $categories = [];
    public function mount()
    {
        // Assuming you have a Category model to fetch categories
        $this->categories = Category::all();
    }
    public function render()
    {
        return view('livewire.category-list');
    }
}
